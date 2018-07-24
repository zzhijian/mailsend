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
        .maintitle{
            font-size: 24px;
            color: rgba(68,68,68,1.00);
            text-align: left;
            padding:15px 35px 20px;
            border-bottom:1px solid #f1f3f2;
        }
        .maincontent{
            font-size: 14px;
            color:#666;
            line-height: 22px;;
            text-align: left;
            margin:10px 0;
        }
        .summarycontent p{
            text-align: right;
        }
        .footercontent p{
            color: rgba(155,165,167,1.00);
        }
        .track{
            display: block;
            width: 160px;
            height:30px;
            text-align: center;
            line-height: 30px;
            color:#fff;
            border-radius:5px;
            margin:10px auto;
            background: #f1435a;
            font-size:14px;
            text-decoration: none;
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
                                                Order #{{$order_id}} Shipped
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
                                                <p class="maincontent">Hi {{$user_name}},</p>
                                                <p class="maincontent">Thank you for shopping with PatPat. Your order #{{$order_id}} has been shipped!
                                                    The tracking number is <a href="https://www.patpat.com/order/track?tracking_number={{$tracking_number}}" style="color:#f1435a;">{{$tracking_number}}</a>.
                                                    If you have purchased multiple items, they may be shipped separately.</p>
                                                <p class="maincontent">If you have any questions or concerns,
                                                    please don't hesitate to contact to contact PatPat customer service via email
                                                    <a style="color:#0078de;" href="mailto:service@patpat.com">service@patpat.com</a>.
                                                </p>
                                                <br />
                                                <a href="https://www.patpat.com/order/track?tracking_number={{$tracking_number}}" class="track"
                                                    style="display: block; width: 160px;
                                                    height:30px;
                                                    text-align: center;
                                                    line-height: 30px;
                                                    color:#fff;
                                                    border-radius:5px;
                                                    margin:10px auto;
                                                    background: #f1435a;
                                                    font-size:14px;
                                                    text-decoration: none;">Track Your Order</a>
                                                <br />
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