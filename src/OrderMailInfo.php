<?php
/**
 * Created by patpat.
 * User: zhijian
 * Date: 18-7-24
 * Time: 下午12:10
 */

namespace PatpatWeb\Mail;


use Illuminate\Support\Facades\DB;

class OrderMailInfo
{


    public static function getOrderDelivery($order_id)
    {
        $data = DB::table('oms_orders')
            ->leftjoin('mb_user_delivery', 'oms_orders.delivery_id', '=', 'mb_user_delivery.id')
            ->leftjoin('oms_shipping_country_mode', 'oms_orders.delivery_mode_id', '=', 'oms_shipping_country_mode.id')
            ->where('oms_orders.id', $order_id)
            ->first();
        return $data ?: '';
    }

    public static function getUserInfo($user_id)
    {
        return DB::table('sys_customers')->useWritePdo()->find($user_id) ?: null;
    }


    public static function get_order_product_list($orderId)
    {
        $products = DB::table('oms_order_sku')
            ->leftjoin('oms_product_sku', 'oms_order_sku.sku_id', '=', 'oms_product_sku.id')
            ->leftjoin('oms_products', 'oms_product_sku.product_id', '=', 'oms_products.id')
            ->select(
                'oms_products.product_name', 'oms_products.brand', 'oms_products.icon',
                'oms_order_sku.event_id', 'oms_order_sku.product_id', 'oms_order_sku.order_id',
                'oms_order_sku.sku_id', 'oms_order_sku.current_status', 'oms_order_sku.id',
                'oms_order_sku.order_quantity AS quantity', 'oms_order_sku.final_price AS order_price',
                'oms_order_sku.single_price AS single_price', 'oms_order_sku.shipping_fee AS shipping_fee',
                'oms_order_sku.updated_at',
                'oms_product_sku.msrp'
            )
            ->where('oms_order_sku.order_id', '=', $orderId)
            ->where("is_bundle",'!=',2)
            ->get();

        $sku_ids = [];
        $product_ids = [];
        foreach ($products as $key => $product) {
            $products[$key]->updated_at = date('d-m-Y', strtotime($products[$key]->updated_at));
            $sku_ids[] = $product->sku_id;
            $product_ids[] = $product->product_id;

            //判断是否存在映射关系，如果存在则拆分sku信息
            $order_sku_maps = DB::table('oms_order_sku_map')
                ->where('order_id', $product->order_id)
                ->where('sku_id', $product->sku_id)
                ->where('event_id', $product->event_id)
                ->select('sku_id', 'num', 'option_value_id')->get();
            if ($order_sku_maps) {
                $order_sku_map_qty = array_sum(array_pluck($order_sku_maps, 'num'));
                foreach ($order_sku_maps as $order_sku_map) {
                    //当映射尺码的sku数量!=sku的实际数量
                    //则重新插入映射的尺码sku信息并减少原sku尺码的数量
                    if ($order_sku_map_qty != $products[$key]->quantity) {
                        $products[$key]->quantity = $product->quantity - $order_sku_map_qty;
                        $products[$key]->final_price = $products[$key]->quantity * $product->single_price;

                        $list = clone $product;
                        $list->quantity = $order_sku_map->num;
                        $list->final_price = $list->quantity * $list->single_price;
                        $list->option_value_id = $order_sku_map->option_value_id;
                        array_push($products, $list);
                    } else {
                        //当映射尺码的sku数量==sku的实际数量
                        //说明oms_order_sku里面的sku全部为映射尺码sku信息
                        $products[$key]->option_value_id = $order_sku_map->option_value_id;
                    }
                }
            }

        }

        if (count($products)) {
            $sku_options = DB::table('oms_sku_option_value')
                ->leftjoin('oms_option_values', 'oms_sku_option_value.value_id', '=', 'oms_option_values.id')
                ->join("oms_options", "oms_options.id", "=", "oms_sku_option_value.option_id")
                ->select(
                    'oms_sku_option_value.sku_id AS sku_id',
                    'oms_sku_option_value.option_name AS option_name',
                    'oms_sku_option_value.option_value AS option_value'
                )
                ->whereNull('oms_sku_option_value.deleted_at')
                ->where('oms_options.type', '=', "option")
                ->whereIn('oms_sku_option_value.option_id', [1, 2])
                ->whereIn('oms_sku_option_value.sku_id', $sku_ids)
                ->orderBy('oms_option_values.display_order', 'asc')
                ->get();
            $product_comments = DB::table('mb_user_comments')
                ->selectRaw('product_id')
                ->where('order_id', $orderId)
                ->whereIn('product_id', $product_ids)
                ->orderBy('product_id')
                ->orderBy("comment_score","desc")
                ->get();

            foreach ($products as $product) {
                $option_value = ProductsService::getSkuOptionValue($product->sku_id);
                $product->offer_id = $product->sku_id . ($option_value ? '-en-USD-' . $option_value : '-en-USD');
                $product->category_name = ProductsService::getCategoryNameByProductId($product->product_id);
                $product->option = [];
                $product->has_comment = false;
                foreach ($sku_options as $sku_option) {
                    //去掉引用调用，防止值覆盖
                    $sku_option = clone $sku_option;
                    if ($product->sku_id == $sku_option->sku_id) {
                        $product->option[] = $sku_option;
                        //判断尺码是否存在尺码映射，如果存在则转换尺码属性值
                        if (($sku_option->option_name == 'Size') && isset($product->option_value_id)) {
                            $new_size_option_value = DB::table('oms_option_values')->where('id', $product->option_value_id)->first();
                            if ($new_size_option_value) {
                                $sku_option->option_value = $new_size_option_value->value;
                            }
                        }
                        $order_sku_ext = DB::table('oms_order_sku_ext')->select('image_url')->where('order_sku_id', $product->id)->value('image_url');
                        if ($order_sku_ext) {
                            $product->icon = $order_sku_ext;
                        }
                        $product->icon = cdn_url($product->icon);
                    }
                }
                foreach ($product_comments as $product_comment) {
                    if ($product->product_id == $product_comment->product_id) {
                        $product->has_comment = true;
                    }
                }
            }
        }
        return $products;
    }

    public static function getOrderBilling($order_id)
    {
        $data = DB::table('oms_orders')->useWritePdo()
            ->leftjoin('mb_user_billing', 'oms_orders.billing_id', '=', 'mb_user_billing.id')
            ->where('oms_orders.id', $order_id)
            ->first();
        return $data ?: '';
    }



}