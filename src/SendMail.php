<?php
/**
 * Created by patpat.
 * User: zhijian
 * Date: 18-7-24
 * Time: 下午4:53
 */

namespace PatpatWeb\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendMail
{
    /**
     * 订单取消邮件发送
     *
     * @param $order_id
     */
    public static function cancelOrder($order_id)
    {
        $reason = "We have received your notice to cancel your order, and this notice is to confirm that order has been canceled per your request.";
        try {
            $email = null;
            $order_info = OrderMailInfo::getOrder($order_id);
            // get delivery email address
            $deliveryInfo = OrderMailInfo::getOrderDelivery($order_info->delivery_id);
            $user_name = '';
            if ($deliveryInfo->delivery_email) {
                $email = $deliveryInfo->delivery_email;
                $user_name = $deliveryInfo->delivery_name;
            }
            // get order's user_id
            $user_id = $order_info->user_id;
            $user_info = OrderMailInfo::getUserInfo($user_id);
            if (!$email) {
                $user_name = $user_info->customers_firstname ? $user_info->customers_firstname : 'Customer';
                $email = $user_info->customers_email_address;
            }
            if ($email && self::checkEmail($email)){
                    // get order list
                    $mailData = array(
                        'order_id' => $order_id,
                        'user_name' => $user_name,
                        'email' => $email,
                        'reason' => $reason ?: "",
                        'total_amount' => $order_info->total_amount,
                        'tax' => $order_info->tax,
                        'total_pay' => $order_info->total_pay,
                        'shipping_fee' => $order_info->shipping_fee,
                        'delivery_info' => $deliveryInfo,
                        'order_date' => $order_info->updated_at,
                        'order_list' => OrderMailInfo::getOrderProductList($order_id)
                    );
                    $configQueue = Config::get('queue.connections.sqs.queue');
                    Mail::queue('mail.cancelorder', $mailData, function ($message) use ($email, $user_name) {
                        $message->from(env('MAIL_USERNAME'),'PatPat');
                        $message->to($email, $user_name)->subject('Order Cancelled');
                    }, $configQueue);
                    //log
                    Log::info(sprintf('[Send Email Queue][After Canceled][success][user_id=%d][order_id=%d][email=%s]', $user_id, $order_id, $email));
            }
        } catch (\Exception $e) {
            Log::error("send cancelled order#$order_id email error message : " . $e->getMessage());
        }
    }

    public static function checkEmail($email)
    {
        // @facebook.com
        $fbemail = substr($email, -13);
        if ($fbemail == "@facebook.com") {
            return false;
        } else
            return true;
    }

    public static function sendCashBack($user_id, $product_id, $buyer_username, $cashback)
    {
        try {
            $userinfo = OrderMailInfo::getUserInfo($user_id);
            $email = $userinfo->customers_email_address;

            // var_dump($email);exit;
            if ($email && self::checkEmail($email)) {
                // get product name
                $product = OrderMailInfo::getProduct($product_id);
                $user_name = $userinfo->customers_firstname . " " . $userinfo->customers_lastname;
                $userinfo->email = $email;
                $mailData = array(
                    'user_name' => $user_name,
                    'buyer_username' => $buyer_username,
                    'cashback' => $cashback,
                    'email' => $email,
                    'product' => $product
                );
                $configQueue = Config::get('queue.connections.sqs.queue');
                Mail::queue('mail.sendcashback', $mailData, function ($message) use ($userinfo) {
                    $message->to($userinfo->email, $userinfo->customers_firstname . " " . $userinfo->customers_lastname)
                        ->subject('PatPat: You got cash credits from your friend!');
                }, $configQueue);
                //log
                Log::info(sprintf('[Send Email Queue][After Placed cashback][success][user_id=%d][mail=%s][product_id=%d][cashback=%s]', $user_id, $userinfo->email, $product_id, $cashback));
            }
        } catch (\Exception $e) {
            Log::error("send CashBack product_id#$product_id buyer_username#$buyer_username email error message : " . $e->getMessage());
        }
    }

    /**
     * 订单创建发送邮件
     *
     * @param int $order_id
     * @param int $user_id
     */
    public static function sendOrder($order_id, $user_id = null)
    {
        try {
            $email = null;
            $order_info = OrderMailInfo::getOrder($order_id);
            // get delivery email address
            $deliveryInfo = OrderMailInfo::getOrderDelivery($order_info->delivery_id);
            $user_id = $user_id?:$deliveryInfo->user_id;
            $user_name = '';
            if ($deliveryInfo->delivery_email) {
                $email = $deliveryInfo->delivery_email;
                $user_name = $deliveryInfo->delivery_name;
            }
            $user_info = OrderMailInfo::getUserInfo($user_id);
            $is_guest = $user_info->registered;
            if (!$email) {
                $email = $user_info->customers_email_address;
            }
            if ($email && self::checkEmail($email)){
                    //order list
                    $order_list = OrderMailInfo::getOrderProductList($order_id);
                    foreach ($order_list as $key => &$value) {
                        $value->image_url = OrderMailInfo::getSkuImage($value->sku_id);
                    }
                    //user
                    if (!$user_name) {
                        $user_name = $user_info->customers_firstname ? $user_info->customers_firstname : 'Customer';
                    }
                    $params = [
                        'email' => $deliveryInfo->delivery_email,
                        'first_name' => $deliveryInfo->delivery_name,
                        'last_name' => $deliveryInfo->delivery_lastname,
                        'refer' => request()->getSchemeAndHttpHost()
                    ];
                    $register_url = URL::secure('register').'?'.http_build_query($params);
                    $mailData = array(
                        'order_id' => $order_id,
                        'user_name' => $user_name,
                        'email' => $email,
                        'total_amount' => $order_info->total_amount,
                        'tax' => $order_info->tax,
                        'total_pay' => $order_info->total_pay,
                        'shipping_fee' => $order_info->shipping_fee,
                        'delivery_info' => $deliveryInfo,
                        'order_date' => $order_info->updated_at,
                        'order_list' => $order_list,
                        'is_guest' => $is_guest,
                        'track_order_id' => ($is_guest == 0 ? Crypt::encrypt($order_id) : ""),
                        'return_money' => OrderMailInfo::getCashbackByOrderId($order_id),//返现金额
                        'register_url' => $register_url,//注册地址
                    );
                    // $email = "zhijian.zhang@patpat.com";
                    $configQueue = Config::get('queue.connections.sqs.queue');
                    Mail::queue('mail.sendorder', $mailData, function ($message) use ($email, $user_name) {
//                        $message->from(env('MAIL_USERNAME'), 'PatPat');
                        $message->to($email, $user_name)->subject('Your PatPat Order Confirmation');
                    }, $configQueue);
                    Log::info(sprintf('[Send Email Queue][After Placed][success][user_id=%d][order_id=%d][email=%s]', $user_id, $order_id, $email));
                }
        } catch (\Exception $e) {
            Log::error("send order#$order_id email error message : " . $e->getMessage());
        }
    }

    /**
     * 发送折扣码邮件
     *
     * @param $code
     * @param $email
     * @return array
     */
    public static function sendDiscountCode($code, $email)
    {
        try {
            $configQueue = Config::get('queue.connections.sqs.queue');
            Mail::queue("mail.discount_code", ['code' => $code], function ($message) use ($email) {
                $message->to($email, "test")->subject('Confirmation of your coupon code on PatPat');
            }, $configQueue);
            return ['status' => true, 'message' => "coupon code has been sent."];
        } catch (\Exception $e) {
            Log::error('send coupon code mail error:' . $e->getMessage());
            return ['status' => false, 'message' => "error"];
        }
    }

    /**
     * 订单转仓通知邮件
     * @param $order_id
     */
    public static function orderInTransit($order_id)
    {
        try {
            $email = null;
            // get delivery email address
            $deliveryInfo = OrderMailInfo::getOrderDelivery($order_id);
            $user_name = '';
            if ($deliveryInfo->delivery_email) {
                $email = $deliveryInfo->delivery_email;
                $user_name = $deliveryInfo->delivery_name;
            }
            // get order's user_id
            $order_info = OrderMailInfo::getOrder($order_id);
            $user_id = $order_info->user_id;
            $user_info = OrderMailInfo::getUserInfo($user_id);
            if (!$email) {
                $user_name = $user_info->customers_firstname ? $user_info->customers_firstname : 'Customer';
                $email = $user_info->customers_email_address;
            }
            if ($email && self::checkEmail($email)){
                $mailData = array(
                    'user_name' => $user_name,
                    'email' => $email,
                    'order_info' => $order_info,
                );
                //队列发送邮件
                $configQueue = Config::get('queue.connections.sqs.queue');
                Mail::queue('mail.order_in_transit', $mailData, function ($message) use ($email, $user_name) {
                    $message->from(env('MAIL_USERNAME'));
                    $message->to($email, $user_name)
                        ->subject('Your Order Is in Transit to PatPat Distribution Center');
                }, $configQueue);

                Log::info(sprintf('[orderInTransit Queue][After Placed][success][user_id=%d][order_id=%d][email=%s]', $user_id, $order_id, $email));
            }
        } catch (\Exception $e) {
            Log::error("orderInTransit error message : " . $e->getMessage());
        }
    }

    public static function orderShippedSendEmail($parameters)
    {
        try {
            $user_name = $parameters->user_name;
            $email = $parameters->user_email;
            $title = 'Your Order #' . $parameters->order_id . ' Has Been Shipped';
            $mailData = [
                'user_name' => $user_name,
                'order_id' => $parameters->order_id,
                'tracking_number' => $parameters->tracking_number
            ];
            $configQueue = Config::get('queue.connections.sqs.queue');
            Mail::queue('mail.order_shipped', $mailData, function ($message) use ($email, $user_name, $title) {
                $message->from(env('MAIL_USERNAME'));
                $message->to($email, $user_name)->subject($title);
            }, $configQueue);

            Log::info(sprintf('[orderShippedSendEmail Queue][After Placed][success][user_name=%d][order_id=%d][email=%s]', $user_name, $parameters->order_id, $email));
        } catch (\Exception $e) {
             Log::error("orderInTransit error message : " . $e->getMessage());
        }
    }

    public static function sendReminder($email, $reminder)
    {
        try {
            $mailData = array(
                'email' => $email,
                'token' => $reminder->token
            );
            Mail::send('mail.reminder', $mailData, function ($message) use ($mailData) {
                $message->to($mailData["email"], "Dear Patpat User")
                    ->subject('Reset Your PatPat Password');
            });
            Log::info(sprintf('[Send Email Queue][Password Reminder][success][email=%s]', $email));
        } catch (\Exception $e) {
            Log::error(sprintf('[Send Email Queue][Password Reminder][failed][%s]', $e->getMessage()));
        }
    }

    public static function sendDmcaContent($data)
    {
        try {
            $email = 'copyright@patpat.com';
            $main_sender = $data['email_full_name'];
            Mail::send('mail.dmca_email_msg', $data, function ($message) use ($email, $main_sender) {
                $message->from(env('MAIL_USERNAME'), $main_sender);
                $message->to($email)->subject('DMCA Reporting Form');
            });
            return true;
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            Log::error($e->getMessage());
            return false;
        }
    }


    /**
     * 发送消息到客户邮箱
     * @param $id
     * @param $order_no
     */
    public static function email2service($id, $order_no)
    {
        $data =  OrderMailInfo::getSmsMessage($id);
        $order_str = $order_no ? 'Order No:' . $order_no : '';
        if($data) {
            $mail_data = [
                'order_no'=>$order_no,
                'email' => $data->email,
                'title' => 'Customer\'s message; No:' . $data->message_no . ($order_str ? ';' . $order_str : ''),
                'content' => ($order_str ? $order_str . "\r\n" : '') . $data->content,
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
            ];

            //队列发送邮件
            $configQueue = config('queue.connections.' . env('QUEUE_DRIVER') . '.queue');
            Mail::queue('mail.sms_message', $mail_data, function($message) use ($mail_data)
            {
                $message->from(env('MAIL_USERNAME'));
                $message->to('service@patpat.com', 'patpat')
                    ->subject($mail_data['title']);
            }, $configQueue);
        }
    }

}