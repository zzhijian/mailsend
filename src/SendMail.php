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
use Illuminate\Support\Facades\DB;
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
            // get delivery email address
            $deliveryInfo = OrderMailInfo::getOrderDelivery($order_id);
            $user_name = '';
            if ($deliveryInfo->delivery_email) {
                $email = $deliveryInfo->delivery_email;
                $user_name = $deliveryInfo->delivery_name;
            }

            // get order's user_id
            $order_info = DB::table('oms_orders')->find($order_id);
            $user_id = $order_info->user_id;
            $userinfo = OrderMailInfo::getUserInfo($user_id);

            if (!$email) {
                $user_name = $userinfo->customers_firstname ? $userinfo->customers_firstname : 'Customer';
                $email = $userinfo->customers_email_address;
            }

            if ($email) {
                $checkEmail = self::checkEmail($email);
                if ($checkEmail) {
                    // get order list
                    $order_list = OrderMailInfo::get_order_product_list($order_id);
                    $billing = OrderMailInfo::getOrderBilling($order_id);
                    if ($billing) {
                        $hasbilling = " ";
                    } else {
                        $hasbilling = 'No billing info';
                    }
                    $resultOrderList = "";
                    $userinfo->email = $email;
                    foreach ($order_list as $key => $value) {
                        $dataOrderList = "

								<tr>
								                            <td>
								                              <table width='100px'  cellspacing='0' cellpadding='0' align='left'>
								                                    <!-- Table container for image -->
								                                    <tbody>
								                                      <tr>
								                                        <td align='left' style='padding:20px 20px 20px 0px;'><img src='" . $value->icon . "/120x120' alt='sample' width='100' height='100' ></td>
								                                      </tr>
								                                    </tbody>
								                              </table>
								                              <table width='400px'  cellspacing='0' cellpadding='0' align='left'>
								                                <!-- Table container for content -->
								                                <tbody>

								                                  <tr>
								                                    <td class='itemcontent'>
								                                    	" . $value->product_name . "
								                                      <p>Quantity: " . $value->quantity . "</p>
								                                     </td>
								                                  </tr>

								                                  <tr style='font-size:14px;'>
								                                  	<td style='color:#a0a4a5'>Single Price: $" . $value->single_price . "</td>
								                                  </tr>
								                                </tbody>
								                              </table>
								                            </td>
								                          </tr>
                              	";
                        $resultOrderList .= $dataOrderList;
                    }
                    $mailData = array(
                        'order_id' => $order_id,
                        'user_name' => $user_name,
                        'email' => $email,
                        'total_amount' => $order_info->total_amount,
                        'tax' => $order_info->tax,
                        'total_pay' => $order_info->total_pay,
                        'shipping_fee' => $order_info->shipping_fee,
                        'reason' => $reason ?: "",
                        'delivery_name' => $deliveryInfo->delivery_name,
                        'delivery_street_address' => $deliveryInfo->delivery_street_address,
                        'delivery_suburb' => $deliveryInfo->delivery_suburb,
                        'delivery_city' => $deliveryInfo->delivery_city,
                        'delivery_postcode' => $deliveryInfo->delivery_postcode,
                        'delivery_phone' => $deliveryInfo->delivery_phone,
                        'delivery_state' => $deliveryInfo->delivery_state,
                        'delivery_country' => $deliveryInfo->delivery_country,
                        'delivery_lastname' => $deliveryInfo->delivery_lastname,
                        'billing_name' => $billing->billing_name ?: "",
                        'billing_street_address' => $billing->billing_street_address ?: "",
                        'billing_suburb' => $billing->billing_suburb ?: "",
                        'billing_city' => $billing->billing_city ?: "",
                        'billing_postcode' => $billing->billing_postcode ?: "",
                        'billing_state' => $billing->billing_state ?: "",
                        'billing_country' => $billing->billing_country ?: "",
                        'order_date' => $order_info->updated_at,
                        'hasbilling' => $hasbilling,
                        'order_list' => $resultOrderList
                    );
                    $configQueue = Config::get('queue.connections.sqs.queue');
                    Mail::queue('mail.cancelorder', $mailData, function ($message) use ($email, $user_name) {
                        $message->from(env('MAIL_USERNAME'),'PatPat');
                        $message->to($email, $user_name)->subject('Order Cancelled');
                    }, $configQueue);
                    Log::info(sprintf('[Send Email Queue][After Canceled][success][user_id=%d][order_id=%d][email=%s]', $user_id, $order_id, $email));
                }
            }
        } catch (\Exception $e) {
            Log::info("err message : " . $e->getMessage());
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

    public static function sendCashBack($user_id, $product_id, $buyerusername, $cashback)
    {
        try {
            $userinfo = OrderMailInfo::getUserInfo($user_id);
            $email = $userinfo->customers_email_address;

            // var_dump($email);exit;
            if ($email) {
                $checkEmail = self::checkEmail($email);
                if ($checkEmail) {
                    // get product name
                    $product = DB::table('oms_products')->find($product_id);
                    $product_name = $product->product_name;
                    $icon = $product->icon;
                    $user_name = $userinfo->customers_firstname . " " . $userinfo->customers_lastname;
                    $userinfo->email = $email;

                    $dataOrderList = "

								<tr>
                                    <td>
                                      <table width='100px'  cellspacing='0' cellpadding='0' align='left'>
                                            <!-- Table container for image -->
                                            <tbody>
                                              <tr>
                                                <td align='left' style='padding:20px 20px 20px 0px;'><img src='" . $icon . "/120x120' alt='sample' width='100' height='100' ></td>
                                              </tr>
                                            </tbody>
                                      </table>
                                      <table width='400px'  cellspacing='0' cellpadding='0' align='left'>
                                        <!-- Table container for content -->
                                        <tbody>

                                          <tr>
                                            <td class='itemcontent'>
                                                " . $product_name . "
                                              <p>Cash back: $" . $cashback . "</p>
                                              <p>Order status: Placed  (It is unavailiabel now, you can use it after the order turn into processing) </p>
                                             </td>
                                          </tr>

                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>

                                <tr><td style='font-size: 0; line-height: 0;' height='1'>
                                <table width='100%' align='center'  cellpadding='0' cellspacing='0'>
                                <tr><td style='font-size: 0; line-height: 0;border-bottom:1px solid #f2f2f2;' height='1'>&nbsp;</td></tr></table></td></tr>

			        ";
                    $mailData = array(
                        'user_name' => $user_name,
                        'buyerusername' => $buyerusername,
                        'cashback' => $cashback,
                        'email' => $email,
                        'order_list' => $dataOrderList
                    );
                    $configQueue = Config::get('queue.connections.sqs.queue');
                    Mail::queue('mail.sendcashback', $mailData, function ($message) use ($userinfo) {
                        $message->to($userinfo->email, $userinfo->customers_firstname . " " . $userinfo->customers_lastname)->subject('PatPat: You got cash credits from your friend!');
                    }, $configQueue);
                    Log::info(sprintf('[Send Email Queue][After Placed cashback][success][user_id=%d][mail=%s][product_id=%d][cashback=%s]', $user_id, $userinfo->email, $product_id, $cashback));
                }
            }
        } catch (\Exception $e) {
            Log::info(sprintf('message %s', $e->getMessage()));
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
            // get delivery email address
            $deliveryInfo = OrderMailInfo::getUserOrderDelivery($order_id);
            $user_id = $deliveryInfo->user_id;
            $user_name = '';
            if ($deliveryInfo->delivery_email) {
                $email = $deliveryInfo->delivery_email;
                $user_name = $deliveryInfo->delivery_name;
            }

            //处理用户参数
            if (!$user_id) {
                $user_id = UsersService::getUserId();
            }

            $userinfo = OrderMailInfo::getUserInfo($user_id);
            $is_guest = $userinfo->registered;
            if (!$email) {
                $email = $userinfo->customers_email_address;
            }

            //todo 获取邮箱用户信息
            $email_account = AuthUtil::getAccountByEmail($email);
            if ($email) {
                $checkEmail = self::checkEmail($email);
                if ($checkEmail) {
                    $order_info = DB::table('oms_orders')->useWritePdo()->find($order_id);
//					$deliveryInfo = App::make("AccountController")->getOrderDelivery($order_id);
                    $billing = OrderMailInfo::getOrderBilling($order_id);
                    if ($billing) {
                        $hasbilling = " ";
                    } else {
                        $hasbilling = 'No billing info';
                    }
                    $order_list = OrderService::getOrderProducts($order_id);
                    if (!$user_name) {
                        $user_name = $userinfo->customers_firstname ? $userinfo->customers_firstname : 'Customer';
                    }
                    $resultOrderList = "";
                    $userinfo->email = $email;
                    foreach ($order_list as $key => $value) {
                        $image_url = ProductsService::getSkuImage($value->sku_id);
                        $dataOrderList = "

								<tr>
								                            <td>
								                              <table width='100px'  cellspacing='0' cellpadding='0' align='left'>
								                                    <!-- Table container for image -->
								                                    <tbody>
								                                      <tr>
								                                        <td align='left' style='padding:20px 20px 20px 0px;'><img src='" . $image_url . "/120x120' alt='sample' width='100' height='100' ></td>
								                                      </tr>
								                                    </tbody>
								                              </table>
								                              <table width='400px'  cellspacing='0' cellpadding='0' align='left'>
								                                <!-- Table container for content -->
								                                <tbody>

								                                  <tr>
								                                    <td class='itemcontent' style='padding-top: 19px;'>
								                                    	" . $value->product_name . "
								                                      <p>Quantity: " . $value->quantity . "</p>
								                                     </td>
								                                  </tr>

								                                  <tr style='font-size:14px;'>
								                                  	<td style='color:#a0a4a5'>Single Price: $" . $value->single_price . "</td>
								                                  </tr>
								                                </tbody>
								                              </table>
								                            </td>
								                          </tr>

                              	";
                        $resultOrderList .= $dataOrderList;
                    }
                    if ($is_guest == 0) {
                        $track_order_id = Crypt::encrypt($order_id);
                    } else {
                        $track_order_id = "";
                    }

                    $is_sign_up = AuthSignUp::checkEmailRegistered($email);
                    $return_money = Wallet::getCashbackByOrderId($order_id);//圣诞活动返现金额
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
                        'email_account' => $email_account,
                        'total_amount' => $order_info->total_amount,
                        'tax' => $order_info->tax,
                        'total_pay' => $order_info->total_pay,
                        'shipping_fee' => $order_info->shipping_fee,
                        'delivery_name' => $deliveryInfo->delivery_name,
                        'delivery_street_address' => $deliveryInfo->delivery_street_address,
                        'delivery_suburb' => $deliveryInfo->delivery_suburb,
                        'delivery_city' => $deliveryInfo->delivery_city,
                        'delivery_postcode' => $deliveryInfo->delivery_postcode,
                        'delivery_phone' => $deliveryInfo->delivery_phone,
                        'delivery_state' => $deliveryInfo->delivery_state,
                        'delivery_country' => $deliveryInfo->delivery_country,
                        'delivery_lastname' => $deliveryInfo->delivery_lastname,
                        'billing_name' => isset($billing->billing_name) ? $billing->billing_name : "",
                        'billing_street_address' => isset($billing->billing_street_address) ? $billing->billing_street_address : "",
                        'billing_suburb' => isset($billing->billing_suburb) ? $billing->billing_suburb : "",
                        'billing_city' => isset($billing->billing_city) ? $billing->billing_city : "",
                        'billing_postcode' => isset($billing->billing_postcode) ? $billing->billing_postcode : "",
                        'billing_state' => isset($billing->billing_state) ? $billing->billing_state : "",
                        'billing_country' => isset($billing->billing_country) ? $billing->billing_country : "",
                        'order_date' => $order_info->updated_at,
                        'hasbilling' => $hasbilling,
                        'order_list' => $resultOrderList,
                        'is_guest' => $is_guest,
                        'track_order_id' => $track_order_id,
                        'is_sign_up' => $is_sign_up,//是否注册
                        'return_money' => $return_money,//返现金额
                        'register_url' => $register_url,//注册地址
//                        'easter' => new EasterService(),
                    );
                    // $email = "zhijian.zhang@patpat.com";
                    $configQueue = Config::get('queue.connections.sqs.queue');
                    Mail::queue('mail.sendorder', $mailData, function ($message) use ($email, $user_name) {
//                        $message->from(env('MAIL_USERNAME'), 'PatPat');
                        $message->to($email, $user_name)->subject('Your PatPat Order Confirmation');
                    }, $configQueue);
                    Log::info(sprintf('[Send Email Queue][After Placed][success][user_id=%d][order_id=%d][email=%s]', $user_id, $order_id, $userinfo->email));
                }
            }
        } catch (\Exception $e) {
            Log::info('send order mail error:' . $e->getMessage());
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
            Log::info('send coupon code mail error:' . $e->getTraceAsString());
            Log::info('send coupon code mail error:' . $e->getMessage());
            return ['status' => false, 'message' => "error"];
        }
    }

    /**
     * 订单转仓通知邮件
     *
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
            $order_info = DB::table('oms_orders')->find($order_id);
            $user_id = $order_info->user_id;
            $userinfo = OrderMailInfo::getUserInfo($user_id);
            if (!$email) {
                $user_name = $userinfo->customers_firstname ? $userinfo->customers_firstname : 'Customer';
                $email = $userinfo->customers_email_address;
            }
            if ($email) {
                $checkEmail = self::checkEmail($email);
                if ($checkEmail) {
                    $userinfo->email = $email;
                    $mailData = array(
                        'user_name' => $user_name,
                        'email' => $email,
                        'order_info' => $order_info,
                    );
                    //队列发送邮件
                    $configQueue = Config::get('queue.connections.sqs.queue');
                    Mail::queue('mail.order_in_transit', $mailData, function ($message) use ($email, $user_name) {
                        $message->from(env('MAIL_USERNAME'));
                        $message->to($email, $user_name)->subject('Your Order Is in Transit to PatPat Distribution Center');
                    }, $configQueue);
                }
            }
        } catch (\Exception $e) {
            Log::info("err message : " . $e->getMessage());
        }
    }

    public static function orderShippedSendEmail($parameters)
    {
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
    }

    public static function sendReminder($email, $reminder)
    {
        try {
            $mailData = array(
                'email' => $email,
                'token' => $reminder->token
            );
            $configQueue = Config::get('queue.connections.sqs.queue');
            Mail::send('mail.reminder', $mailData, function ($message) use ($mailData) {
                $message->to($mailData["email"], "Dear Patpat User")
                    ->subject('Reset Your PatPat Password');
            });
            Log::info(sprintf('[Send Email Queue][Password Reminder][success][email=%s]', $email));
        } catch (\Exception $e) {
            Log::info(sprintf('[Send Email Queue][Password Reminder][failed][%s]', $e->getMessage()));
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
     *
     * @param $id
     * @param $order_no
     */
    public static function email2service($id, $order_no)
    {
        $data =  DB::table('sms_message')->useWritePdo()->find($id);
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
                $message->to('service@patpat.com', 'patpat')->subject($mail_data['title']);
            }, $configQueue);
        }
    }

}