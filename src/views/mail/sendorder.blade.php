<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patpat, Order Placed</title>
    <style type="text/css">
        body {
            margin: 0;
        }
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: none!important;
            font-family: 'Avenir roman',"Helvetica Neue", Helvetica, Arial, sans-serif;
            color: rgba(68,68,68,1.00);
            font-style: normal;
            font-weight: 400;
            border-color: #E1E1E1;
        }
        button{
            width:90%;
        }
        .patpattd {
            border:1px solid #9ea4a4;
            border-radius:10px;
        }
        .billtitle{
            color:#f46159;
            font-size:20px;
        }
        .billcontent{
            font-size:14px;
        }
        .maintitle{
            font-size: 24px;
            color: rgba(68,68,68,1.00);
            text-align: left;
            padding:15px 35px 20px;
            border-bottom:1px solid #f1f3f2;
        }
        .subcontent{
            font-size: 20px;
            color: #f46159;
            text-align: center;
            text-align: left;;
            padding: 25px 20px 15px 35px;
        }
        .maincontent{
            font-size: 14px;
            color:#666;
            line-height: 22px;;
            text-align: left;
            margin:10px 0;
        }
        .summaryleft{
            font-size: 14px;
            color: rgba(68,68,68,1.00);
            text-align: left;
        }
        .summarycontent{
            font-size: 14px;
            color: rgba(68,68,68,1.00);
            text-align: right;
            padding: 20px;
        }
        .summarycontent p{
            text-align: right;
        }
        .itemcontent{
            font-size: 14px;
            color: rgba(68,68,68,1.00);
            text-align: left;
            padding-top:19px;
        }
        .arrivals{
            padding-left:35px;
            padding-right:35px;
            padding-top:10px;

            padding-bottom:40px;
            font-size: 12px;
            color: rgba(155,165,167,1.00);
        }
        .footercontent
        {
            padding:0px 35px 20px 35px;
            font-size: 14px;
            color: rgba(155,165,167,1.00);
        }
        .footercontent p{
            color: rgba(155,165,167,1.00);
        }
    </style>
</head>
<body>
    <table width="100%"  cellspacing="0" cellpadding="0" style="background-color:rgba(241,243,242,1.00); padding:25px;">
        <tbody>
            <tr>
                <td align="center"  style="padding-bottom:25px;">
                    <a href="http://www.patpat.com"><img src="http://patpatdev.s3.amazonaws.com/mail/large_size.png" alt="Insert Logo Here" width="165" height="50" id="Insert_logo" /></a>
                </td>
            </tr>
        </tbody>
        <tr>
            <td>
                <table width="600px"  align="center" cellpadding="0" cellspacing="0" style="background-color: white; border-top-color: #C8C8C8;border-radius:10px;">
                <!-- Main Wrapper Table with initial width set to 60opx -->
                    <!-- Start Introduction area -->
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" align="center" width="100%"  style="padding-top:10px;">
                            <!--item row begin-->
                                <tr>
                                    <td>
                                        <table width="100%"  cellspacing="0" cellpadding="0" align="center" style="font-size: 28px;">
                                            <tbody>
                                                <tr>
                                                    <td class="maintitle" align="center">
                                                        Your PatPat Order Confirmation
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%"  cellspacing="0" cellpadding="0" align="left" style="font-size: 18px; padding:0 20px;">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 18px; border-bottom:1px solid #f1f2f3; padding:0 15px;" >
                                                        <p class="maincontent" style="color:#444;font-weight:bold;font-size:14px;">Dear {{ $user_name }},</p>

                                                        <p class="maincontent" style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">Thank you for shopping with PatPat! Your order <span style="border-bottom: 1px dashed rgb(204, 204, 204); z-index: 1; position: static;">#{{$order_id}}</span> has
                                                            been placed successfully. </p>

                                                        <p class="maincontent" style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">Once your order is shipped, you will receive another email with all of the information you will need to track your package. Due to the
                                                            current high volume of orders, we are experiencing brief delays with some shipments. Please allow up to 30 business days for delivery.</p>
                                                        @if(!$is_guest && $return_money > 0)
                                                            <p class="maincontent" style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">We are excited to tell you that you’ve earned ${{ $return_money }} Cashback from this order.
                                                            <a href="{{ $register_url }}">Join us</a> with email <a href="{{ $register_url }}">{{ $email }}</a> to get your Cashback right now!
                                                        @endif
                                                        <p class="maincontent" style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">If you have any questions or concerns, please contact us at
                                                            <a style="color:#0078de;" href="mailto:service@patpat.com">service@patpat.com</a>. We would love to help you.</p>

                                                        <p class="maincontent" style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">
                                                            Thank you again for your business!
                                                        </p>
                                                        <p class="maincontent" style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">Sincerely,</p>
                                                        <p class="maincontent" style="font-size:14px; color:#666; margin-top:15px; line-height:22px;">PatPat</p>
                                                        @if($is_guest == 0)
                                                            <a style="display: block; width: 160px; height: 30px;text-align: center;line-height: 30px;color: #fff;border-radius: 5px; margin: 10px auto;background: #f1435a;font-size: 14px;text-decoration: none;"
                                                                href="https://www.patpat.com/guest/order/{{$track_order_id}}">Track Your Order</a>
                                                        @endif
                                                        <br />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- End Introduction area -->
                    <!--Strat Billing Shipping Info-->
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" align="center" width="100%"  style="padding-left:35px;padding-top:25px;padding-right:35px;padding-bottom: 25px;">
                                <!--item row begin-->
                                <tr>
                                    <td>
                                        <table width="50%"  cellspacing="0" cellpadding="0" align="left">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span class="billtitle" style="color:#f46159;">Shipped to:</span>
                                                        <p class="maincontent">{{$delivery_info->delivery_name}} {{$delivery_info->delivery_lastname}}</p>
                                                        <p class="maincontent">{{$delivery_info->delivery_street_address}} </p>
                                                        <p class="maincontent">{{$delivery_info->delivery_suburb ? $delivery_info->delivery_suburb . ', ' : ''}}{{$delivery_info->delivery_city}}, {{$delivery_info->delivery_state}}, {{$delivery_info->delivery_postcode}}, {{$delivery_info->delivery_country}}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table width="50%"  cellspacing="0" cellpadding="0" align="right">
                                            <tbody>
                                                <tr>
                                                    <td>

                                                        <p class="maincontent">Order Date: {{$order_date}}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!--item row end-->
                            </table>
                        </td>
                    </tr>
                    <!-- End Billing Shipping Info-->

                    <!-- HTML spacer row -->
                    <tr>
                        <td style="font-size: 0; line-height: 0; padding:0px 20px 0px 20px;" height="1">
                            <table width="100%" align="center"  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-size: 0; line-height: 0;border-bottom:1px solid #f2f2f2;" height="1">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 35px;"><span class="billtitle" style="color:#f46159;">Here's what you ordered:</span></td>
                    </tr>
                    <tr>
                        <td style="padding-left:35px;padding-right:35px;">
                            <table cellpadding="0" cellspacing="0" align="center" width="100%" class="catalog">
                            <!-- Table for catalog -->
                                <tr>
                                    <td>
                                        <table class ="responsive-table" width="100%"  cellspacing="0" cellpadding="0" align="left">
                                        <!-- Table container for each image and description in catalog -->
                                            <tbody>
                                            <!--item row begin-->
                                            @foreach($order_list as $value)
                                            <tr>
                                                <td>
                                                    <table width="100px"  cellspacing="0" cellpadding="0" align="left">
                                                        <!-- Table container for image -->
                                                        <tbody>
                                                        <tr>
                                                            <td align="left" style="padding:20px 20px 20px 0px;">
                                                                <img src="{{$value->image_url}}/120x120" alt="sample" width="100" height="100" >
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="400px"  cellspacing="0" cellpadding="0" align="left">
                                                        <!-- Table container for content -->
                                                        <tbody>
                                                        <tr>
                                                            <td class="itemcontent" style="padding-top: 19px;">
                                                                {{$value->product_name}}
                                                                <p>Quantity: {{$value->quantity}} </p>
                                                            </td>
                                                        </tr>

                                                        <tr style="font-size:14px;">
                                                            <td style="color:#a0a4a5">Single Price: ${{$value->single_price }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <!--item row end-->
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 0; line-height: 0; padding:0 25px;" height="1">
                            <table width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="font-size: 0; line-height: 0;border-bottom:1px solid #f2f2f2;" height="1">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    <!-- Row container for Intro/ Description -->
                        <td align="center" class="subcontent">Summary:</td>
                    </tr>
                    <tr>
                        <td style="padding-left:20px;padding-right:20px;padding-bottom: 30px;">
                            <table cellpadding="0" cellspacing="0" align="center" width="100%" class="catalog">
                            <!-- Table for catalog -->
                                <tr>
                                    <td>
                                        <table class ="responsive-table" width="100%"  cellspacing="0" cellpadding="0">
                                        <!-- Table container for each image and description in catalog -->
                                            <tbody>
                                                <tr>
                                                    <td width="50%" style="padding-left:15px;">
                                                        <table class="table.responsiveContent" cellspacing="0" cellpadding="0">
                                                        <!-- Table container for content -->
                                                            <tbody>

                                                                <tr>
                                                                    <td class="summaryleft">
                                                                        <span>Subtotal:</span>
                                                                        <p>Tax:</p>
                                                                        <p>Shipping:</p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td width="50%" align="right" style="padding:0 15px 0 0;" >
                                                        <table class="table.responsiveContent" cellspacing="0" cellpadding="0">
                                                        <!-- Table container for content -->
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <span style="font-size:14px;">{{$total_pay}}</span>
                                                                        <p style="font-size:14px;">{{$tax}}</p>
                                                                        <p style="font-size:14px;">{{$shipping_fee}}</p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-top:1px solid #f1f2f3; padding: 15px 0 0 15px; color:#f46159; font-size:18px;">Total:</td>
                                                    <td style="border-top:1px solid #f1f2f3;  padding: 15px 15px 0 0; color:#f46159; font-size:20px;" align="right">{{$total_amount}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    <!-- HTML spacer row -->
                        <td style="font-size: 0; line-height: 0; padding:0px 20px 0px 20px;" height="1">
                            <table width="100%" align="center"  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="font-size: 0; line-height: 0;border-bottom:1px solid #f2f2f2;" height="1">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table align="center" style="padding-top:30px;font-size:14px;">
                    <tr>
                        <td>Daily deals for moms. Happy Shopping <span style="color:#aaaeaf;">- PatPat team</span></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table align="center"  style="padding-top:10px;font-size:14px;">
                    <tr>
                        <td align="center" style="color:#aaaeaf;">This email was sent from notification-only address that can not accept incoming emails.</td>
                    </tr>
                    <tr>
                        <td align="center" style="color:#aaaeaf;">Please do not reply to this message.</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table align="center"  style="padding-top:10px;font-size:14px;">
                    <tr>
                        <td align="center" style="color:#aaaeaf;">Interfocus INC - 650 Castro Street Ste.120-458, Mountain View, CA 94041, USA</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>