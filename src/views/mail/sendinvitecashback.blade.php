<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patpat, You got cash credits!</title>

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
            /* [disabled]line-height: 1.8; */
            text-align: center;
            /*padding: 40px 20px 0px 20px;*/
        }
        .subcontent{
            font-size: 22px;
            color: rgba(68,68,68,1.00);
            /* [disabled]line-height: 1.8; */
            text-align: center;
            padding: 30px 20px 20px 20px;
        }
        .maincontent{
            font-size: 14px;
            color: rgba(68,68,68,1.00);
            /* [disabled]line-height: 1.8; */
            text-align: left;
            /*padding: 20px 35px 10px 35px;*/
        }
        .summaryleft{
            font-size: 14px;
            color: rgba(68,68,68,1.00);
            /* [disabled]line-height: 1.8; */
            text-align: left;
        }
        .summarycontent{
            font-size: 14px;
            color: rgba(68,68,68,1.00);
            /* [disabled]line-height: 1.8; */
            text-align: right;
            padding: 20px;
        }
        .summarycontent p{
            text-align: right;
        }

        .itemcontent{
            font-size: 14px;
            color: rgba(68,68,68,1.00);
            /* [disabled]line-height: 1.8; */
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
            /* [disabled]line-height: 1.8; */
        }
        .footercontent
        {
            padding:0px 35px 20px 35px;
            font-size: 14px;
            color: rgba(155,165,167,1.00);
            /* [disabled]line-height: 1.8; */
        }
        .footercontent p{
            color: rgba(155,165,167,1.00);
            /*padding:0px 35px 20px 35px;*/
        }

    </style>
</head>
<body>


<table width="100%"  cellspacing="0" cellpadding="0" style="background-color:rgba(241,243,242,1.00); padding:25px;">
    <tbody>
    <tr>
        <td align="center"  style="padding-bottom:25px;">
            <a href="http://www.patpat.com"><img src="http://patpatdev.s3.amazonaws.com/mail/large_size.png" alt="Insert Logo Here" width="165" height="50" id="Insert_logo" display:block;" /></a>
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
                        <table cellpadding="0" cellspacing="0" align="center" width="100%"  style="padding-left:35px;padding-top:10px;padding-right:35px;">
                            <!--item row begin-->
                            <tr>
                                <td>
                                    <table width="100%"  cellspacing="0" cellpadding="0" align="center" style="padding:0px">
                                        <tbody>
                                        <tr>
                                            <td align="center">
                                                <span class="maintitle" style="color:#f46159;text-align: center;">You've got cash credits!</span>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%"  cellspacing="0" cellpadding="0" align="left" style="padding:0px">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <p class="maincontent">Hi, {{ $user_name }}</p>
                                                <p class="maincontent">Congratulations! Your friend "{{ $buyerusername }}" referral code was used to purchase the following product, so you just earned cash credits in the amount of ${{ $cashback }} . These credits have no expiration date, so treat yourself or your loved one to something nice! Thank you for shopping with PatPat!</p>

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



                <!-- HTML spacer row -->
                <tr>
                    <td style="font-size: 0; line-height: 0; padding:0px 0px 0px 0px;" height="1">
                        <table width="100%" align="center"  cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size: 0; line-height: 0;border-bottom:1px solid #f2f2f2;" height="1">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td align="center" class="subcontent"  style="color:#f46159;padding-top:20px;padding-bottom:10px;">Order List</td>
                </tr>

                <tr style="font-size:12px;">
                    <td>
                        <table width="100%" align="center"  cellpadding="0" cellspacing="0" style="padding:0 35px 10px 35px;">
                            <tr>
                                <td align="left">

                                </td>
                                <td align="right">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- HTML spacer row -->
                <tr>
                    <td style="font-size: 0; line-height: 0; padding:0px 35px 0px 35px;" height="1">
                        <table width="100%" align="center"  cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size: 0; line-height: 0;border-bottom:1px solid #f2f2f2;" height="1">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
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
                                        {{$order_list}}
                                        <!--item row end-->




                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table></td>
                </tr>



                <tr>
                    <!-- HTML spacer row -->
                    <td style="font-size: 0; line-height: 0; padding:0px 35px 0px 35px;" height="1"><table width="100%" align="center"  cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size: 0; line-height: 0;border-bottom:1px solid #f2f2f2;" height="1">&nbsp;</td>
                            </tr>
                        </table></td>
                </tr>
                <tr bgcolor="white">
                    <td style="border-radius:10px;">
                        <table class="footer" width="100%"  align="center" cellpadding="0" cellspacing="0">
                            <!-- Second column of footer content -->
                            <tr>
                                <td align="center" class="footercontent" style="padding:5px 35px 5px 35px;">
                                    <p></p>
                                </td>
                            </tr>
                        </table></td>
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
                <tr><td align="center" style="color:#aaaeaf;">Pleas do not reply to this message.</td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table align="center"  style="padding-top:10px;font-size:14px;">
                <tr>
                    <td style="color:#aaaeaf;">Interfocus INC - 440N. Wolfe Road, Suite W013, Sunnyvale, CA 94085, United States</td>
                </tr>
            </table>
        </td>
    </tr>

</table>
</body>
</html>

