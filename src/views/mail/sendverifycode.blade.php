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
            font-size:22px;
        }
        .billcontent{
            font-family:'Avenir light';
            font-size:14px;
        }
        .maintitle{
            font-size: 24px;
            color: rgba(68,68,68,1.00);
            text-align: center;
        }
        .subcontent{
            font-size: 22px;
            color: rgba(68,68,68,1.00);
            text-align: center;
            padding: 30px 20px 20px 20px;
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
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color:rgba(241,243,242,1.00); padding:25px;">
        <tbody>
            <tr>
                <td align="center" style="padding-bottom:25px;">
                    <a href="http://www.patpat.com">
                        <img src="http://patpatdev.s3.amazonaws.com/mail/large_size.png" alt="Insert Logo Here" width="165" height="50" id="Insert_logo" style="display:block;"/>
                    </a>
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td>
                    <table width="600px" align="center" cellpadding="0" cellspacing="0" style="background-color: white; border-top-color: #C8C8C8;border-radius:10px;">
                        <!-- Main Wrapper Table with initial width set to 60opx -->
                        <!-- Start Introduction area -->
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" align="center" width="100%"  style="padding-left:35px;padding-top:10px;padding-right:35px;">
                                    <!--item row begin-->
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0" align="center"  style="padding:0px">
                                                <tbody>
                                                    <tr>
                                                        <td align="left">
                                                            <span class="maintitle" style="color:#444;font-size:20px;">Reset PatPat Password</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" cellpadding="0" align="left">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p class="maincontent">You recently requested to reset your PatPat password. Please use the code below to reset the password.</p>
                                                            <p class="maincontent">Here is your code: <span style="color:#f46159;">{{ $verify_code }}.</span></p>
                                                            <p class="maincontent">If you have any questions or did not make this request,
                                                                you can contact us at <a style="color:#0078de;" href="mailto:service@patpat.com">service@patpat.com</a>. We would love to help you.</p>
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
                    <table align="center" style="font-size:14px;">
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
                    <table align="center" style="font-size:14px;">
                        <tr>
                            <td align="center" style="color:#aaaeaf;">Interfocus INC - 650 Castro Street Ste.120-458, Mountain View, CA 94041, USA</td>


                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>