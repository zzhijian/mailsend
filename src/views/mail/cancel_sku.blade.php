<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel SKU</title>
</head>
<body>
    
<div style="margin:auto;width: 300px;padding:30px 0;height: 55px;">
     <a style="float:left; width:144px;" href="http://www.patpat.com"><img style="display:block; width:100%;" src="https://patpatdev.s3.amazonaws.com/mail/large_size.png"/></a>
     <p style="float:left; width:120px; height:24px; color:#cdd2d3; font-size:12px; border-left:#cdd2d3 1px solid; margin:11px 0 0 15px; padding-left:15px;">DAILY DEALS FOR MOMS & KIDS</p>
</div>
<div style="width: 540px; margin: auto; background: #fff; border-radius: 5px; padding: 30px; box-shadow: 0 1px 1px 1px #cdd0cf; margin-bottom: 30px;">
    <strong style="color:#444; font-size:14px;">Dear {{$user_info['user_name']}},</strong>
    <p style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">Thank you for shopping with PatPat. We regret to inform you that the following item(s) in your order <strong>{{$order_id}}</strong> have been cancelled due to the following possible reasons:</p>
    <ul style="padding:0 0 0 -15px;">
        <li style="font-size: 14px;color: #666; line-height: 22px; position: relative;">The item(s) are out of stock or the quality failed to reach our Quality Control Standard.</li>
        <li style="font-size: 14px;color: #666; line-height: 22px; position: relative;">The customer has required the cancellation.</li>
    </ul>
    <p style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">The payment will be refunded to your account as soon as possible.</p>
    <p style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">You are our esteemed and valuable customer, and we feel sorry for any inconvenience. We hope you can accept a $5 coupon as a small compensation. Please input
        <strong style="color: #f1435a; border-bottom: 1px solid #f8a1ac;">{{$discount_code}}</strong> at cart page next time and the order total will decrease by $5.
        We deeply value your relationship with PatPat and thanks again for your understanding.</p>
    <p style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">If you have any question or concern, please reach us via email <a style="color: #6b7db2;" href="mailto:service@patpat.com">service@patpat.com</a>. We would love to help.</p>
    <p style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">Best regards,</p>
    <p style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">PatPat</p>


    <div style="margin-top: 20px; border: 1px solid #cdd2d3; padding: 0 20px 20px;">
        <div style="border-bottom: 1px solid #f1f3f2; padding: 15px 0; color: #666; font-size: 16px; text-align: center; height:20px;">Status: Canceled</div>  <!-- Canceled 状态需获取 -->

        <ul style="padding:20px 0;">
            <?php
                $cancel_subtotal = 0;
            ?>
            @foreach($cancel_sku as $cancel_sku_item)
                    <?php
                    $cancel_sku_item = (object)$cancel_sku_item;
                    $cancel_subtotal += $cancel_sku_item->single_price;
                    ?>
                        <li style="height:100px; margin-bottom: 15px; font-style: normal; list-style: none">
                            <img style="float: left; width: 100px; margin-right: 20px;" src="{{$cancel_sku_item->icon}}/120x120" />
                            <strong style="font-weight: normal;font-size: 12px;color: #444; overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical; padding-top: 5px;">{{$cancel_sku_item->product_name}}</strong>
                            <span style="display: block; color: #666; padding: 10px 0; font-size: 12px;">Quantity: {{$cancel_sku_item->order_quantity}}</span>
                            <p style="margin: 0; font-size: 12px; color: #a8b1b3; line-height: 22px;">
                                @foreach($cancel_sku_item->option as $option)
                                    <?php $option = (object)$option;?>
                                    {{$option->option_name}}: {{$option->option_value}}&nbsp;&nbsp;
                                @endforeach
                                Single Price: ${{$cancel_sku_item->single_price}}
                            </p>
                        </li>
            @endforeach
        </ul>
        <div style="border-top: 1px solid #f1f3f2; padding-top: 20px;">
            <strong style="display: block; margin-bottom: 5px; color:#444;font-size:15px;">Summary</strong>
            <div style="padding-top: 20px; color: #f1435a; font-size: 16px;">
                Total: <i style="float:right;font-style:normal; font-size:20px;">${{$cancel_subtotal}}</i>
            </div>
        </div>
    </div>

    <div style="margin-top: 20px; border: 1px solid #cdd2d3; padding: 0 20px 20px;">
        <div style="border-bottom: 1px solid #f1f3f2; padding: 15px 0; color: #666; font-size: 16px; text-align: center; height:20px;">
            <span style="float:left;">Order: {{$order_id}}</span>
            <span style="float:right;">Status: {{ucfirst($user_info['current_status'])}}</span>
        </div>

        <ul style="padding:20px 0;">
            <?php
                $ont_cancel_total = $user_info['tax'] + $user_info['shipping_fee'];
                $ont_cancel_subtotal = 0;
            ?>
            @foreach($not_cancel_sku as $not_cancel_sku_item)
                <?php
                    $not_cancel_sku_item = (object)$not_cancel_sku_item;
                    $ont_cancel_total += $not_cancel_sku_item->single_price;
                    $ont_cancel_subtotal += $not_cancel_sku_item->single_price;
                ?>
                    <li style="height:100px; margin-bottom: 15px; font-style: normal; list-style: none">
                        <img style="float: left; width: 100px; margin-right: 20px;" src="{{$not_cancel_sku_item->icon}}/120x120" />
                        <strong style="font-weight: normal;font-size: 12px;color: #444; overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical; padding-top: 5px;">{{$not_cancel_sku_item->product_name}}</strong>
                        <span style="display: block; color: #666; padding: 10px 0; font-size: 12px;">Quantity: {{$not_cancel_sku_item->order_quantity}}</span>
                        <p style="margin: 0; font-size: 12px; color: #a8b1b3; line-height: 22px;">
                        @foreach($not_cancel_sku_item->option as $option)
                            <?php $option = (object)$option;?>
                            {{$option->option_name}}: {{$option->option_value}}&nbsp;&nbsp;
                        @endforeach
                            Single Price: ${{$not_cancel_sku_item->single_price}}
                        </p>
                    </li>
            @endforeach
        </ul>
        <div style="border-top: 1px solid #f1f3f2; padding-top: 20px;">
            <strong style="display: block; margin-bottom: 5px; color:#444;font-size:15px;">Summary</strong>
            <span style="display: block;line-height: 26px;font-size: 14px;color: #666;">Subtotal: <i style="float:right;font-style:normal;">${{$ont_cancel_subtotal}}</i> </span>
            <span style="display: block;line-height: 26px;font-size: 14px;color: #666;">Tax: <i style="float:right;font-style:normal;">${{$user_info['tax']}}</i> </span>
            <span style="display: block;line-height: 26px;font-size: 14px;color: #666;">Shipping: <i style="float:right;font-style:normal;">${{$user_info['shipping_fee']}}</i> </span>
            <div style="padding-top: 20px; color: #f1435a; font-size: 16px;">
                Total: <i style="float:right;font-style:normal; font-size:20px;">${{$ont_cancel_total}}</i>
            </div>
        </div>
        <div style="display: none; border-top: 1px solid #f1f3f2; text-align: center; padding-top: 10px;">
        <a href="javascript:;" style="display: inline-block;height: 27px;padding: 0 5px;text-decoration: none;position: relative;font-size: 12px;">
            Unfolded 
            <i style="position: absolute;width: 10px;height: 10px;border-bottom: 2px solid #cdd2d3;border-left: 2px solid #cdd2d3;transform: rotate(-45deg);-webkit-transform: rotate(-45deg);left: 50%; margin-left: -5px; top: 12px;"></i></a>
        </div>
    </div>
</div>
<div style="width: 600px;margin: auto;background: #fff;border-radius: 5px;padding: 0 0 20px;box-shadow: 0 1px 1px 1px #cdd0cf;margin-bottom: 30px;">
    <div style="text-align: center;border-bottom: 1px solid #f1f3f2;padding: 20px 0;">
        YOU MAY LIKE
    </div>
    <div style="padding: 10px 10px 20px;">
        @foreach($daily_recommended as $index=>$item)
            <?php if ($index >=9) break; $item = (object)$item ?>
            <div style="float: left;width: 33.33%;padding: 10px;box-sizing: border-box;">
                <?php
                $flag_array = ['flag' => "recommended_$index"];
                $parameters = generateParameters($item,$flag_array);
                ?>
                <article>
                    <a href="{{getProductUrl($item->product_id,$parameters)}}" class="img" style="display: block;">
                        <img style="display:block; width: 173px; height: 173px;" src="{{cdnUrl($item->icon).'/350x350'}}"/>
                    </a>
                    <div>
                        <h2 style="margin-bottom: 5px; text-align: left;">
                            <a style="font-size: 14px;color: #444;font-family: avenir-medium,sans-serif;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;text-decoration: none; font-weight: normal;" href="{{getProductUrl($item->product_id,$parameters)}}">{{$item->product_name}}</a>
                        </h2>
                        <p style="display: block;margin-bottom: 0;color: #ff2556;font-size: 14px;overflow: hidden;font-family: avenir-medium,sans-serif;"><s style="color:#9ba5a7;">${{$item->msrp}}</s>&nbsp;&nbsp;${{$item->event_price}}</p>
                    </div>
                </article>

            </div>

        @endforeach
        <div style="content:'';display: table; clear: both; width:100%; height:1px;"></div>
    </div>
    <a href="https://www.patpat.com" style="display: block;border-radius: 5px;text-decoration: none;font-size: 14px;margin: auto;width: 120px;height: 32px;border: 1px solid #444;color: #444;line-height: 32px;text-align: center;">SHOW MORE</a>
</div>
<div style="width: 540px;margin: auto;text-align: center;padding-bottom: 100px;">
    <p style="font-size: 12px;color: #666;line-height: 22px;">If you have any quesstions or concerns,please don't hesitate to contact PatPat customer service via email <a href="mailto:service@patpat.com">service@patpat.com</a>.</p><br />
    <p style="font-size: 12px;color: #666;line-height: 22px;">Daily deals for moms. Happy Shopping - PatPat team</p>
    <p style="font-size: 12px;color: #666;line-height: 22px;">This email was sent from notification-only address that can not accept incoming emails.</p>
    <p style="font-size: 12px;color: #666;line-height: 22px;">Please do not reply to this message.</p>
    <p style="font-size: 12px;color: #666;line-height: 22px;">Interfocus INC - 650 Castro Street Ste.120-458, Mountain View, CA 94041, USA</p>
</div>
<script type="text/javascript">
    var orderList = document.getElementById("sku-page-order").getElementByTagName("li");
    var orderMore = document.getElementById("more-order");
    var orderPrice = document.getElementById("order-price");
    if( orderList.length > 1 ){
        orderPrice.hide();
        orderList.hide();
        orderList.first().show();
        orderMore.show();
    }
    orderMore.onclick = function(){
        orderMore.hide();
        orderMore.show();
        orderList.show();
    }

</script>
</body>
