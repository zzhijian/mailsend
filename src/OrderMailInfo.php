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

    public static function getOrder($order_id)
    {
        return DB::table('oms_orders')->find($order_id);
    }

    public static function getOrderDelivery($delivery_id)
    {
        return DB::table('mb_user_delivery')->find($delivery_id);
    }

    public static function getUserInfo($user_id)
    {
        return DB::table('sys_customers')->find($user_id);
    }

    public static function getOrderBilling($billing_id)
    {
        return DB::table("mb_user_billing")->find($billing_id);
    }

    public static function getProduct($product_id){
        return DB::table("oms_products")->find($product_id);
    }

    public static function getSkuImage($sku_id)
    {
        $sku = DB::table('oms_product_sku')
            ->select('product_id', 'image')
            ->where('id', $sku_id)
            ->first();
        if ($sku && $sku->image) {
            $image = $sku->image;
        } else {
            $product = DB::table('oms_products')
                ->select('icon')
                ->where('id', $sku->product_id)
                ->first();
            $image = $product->icon;
        }
        return $image;
    }

    public static function getSmsMessage($sms_id){
        return DB::table('sms_message')->useWritePdo()->find($sms_id);
    }

    public static function getCashbackByOrderId($order_id){
        $cashback = DB::table('mb_wallet_credit_record')->useWritePdo()
            ->where('order_id', $order_id)
            ->where('record_type', 'activity_cashback')
            ->where('product_id', 0)
            ->where('referral_id', 0)
            ->value('total');
        return isset($cashback) ? $cashback : 0;
    }

    public static function getOrderProductList($orderId)
    {
        $products = DB::table('oms_order_sku')
            ->select(
                "'' as product_name", "'' as brand", "'' as icon",
                "oms_order_sku.event_id", "oms_order_sku.product_id", "oms_order_sku.order_id",
                "oms_order_sku.sku_id", "oms_order_sku.current_status", "oms_order_sku.id",
                "oms_order_sku.order_quantity AS quantity", "oms_order_sku.final_price AS order_price",
                "oms_order_sku.single_price AS single_price", "oms_order_sku.shipping_fee AS shipping_fee",
                "oms_order_sku.updated_at","'0' as msrp"
            )
            ->where('oms_order_sku.order_id', '=', $orderId)
            ->where("is_bundle",'!=',2)
            ->get();
        $sku_ids = [];
        $product_ids = [];
        foreach ($products as $key => &$product) {
            //sku
            $pdt_sku = DB::table("oms_product_sku")
                ->select('oms_product_sku.product_id','oms_product_sku.msrp')
                ->find($product->sku_id);
            $product->msrp = $pdt_sku->msrp;
            //product
            $pdt = DB::table("oms_products")
                ->select('oms_products.product_name', 'oms_products.brand', 'oms_products.icon')
                ->find($pdt_sku->product_id);
            $product->product_name = $pdt->product_name;
            $product->brand = $pdt->brand;
            $product->icon = $pdt->icon;
            $product->updated_at = date('d-m-Y', strtotime($product->updated_at));

            $sku_ids[] = $product->sku_id;
            $product_ids[] = $product->product_id;
            //判断是否存在映射关系，如果存在则拆分sku信息
            $order_sku_maps = DB::table('oms_order_sku_map')
                ->where('order_id', $product->order_id)
                ->where('sku_id', $product->sku_id)
                ->where('event_id', $product->event_id)
                ->select('sku_id', 'num', 'option_value_id')
                ->get();
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
            foreach ($products as $product) {
                foreach ($sku_options as $sku_option) {
                    //去掉引用调用，防止值覆盖
                    $sku_option = clone $sku_option;
                    if ($product->sku_id == $sku_option->sku_id) {
                        $product->option[] = $sku_option;
                        //判断尺码是否存在尺码映射，如果存在则转换尺码属性值
                        if (($sku_option->option_name == 'Size') && isset($product->option_value_id)) {
                            $new_size_option_value = DB::table('oms_option_values')
                                ->where('id', $product->option_value_id)
                                ->first();
                            if ($new_size_option_value) {
                                $sku_option->option_value = $new_size_option_value->value;
                            }
                        }
                        $order_sku_ext = DB::table('oms_order_sku_ext')
                            ->select('image_url')
                            ->where('order_sku_id', $product->id)
                            ->value('image_url');
                        if ($order_sku_ext) {
                            $product->icon = $order_sku_ext;
                        }
                    }
                }
            }
        }
        return $products;
    }





}