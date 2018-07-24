<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Oops! You Forgot Something</title>
    <style>
        body{
            padding-bottom:0 !important;
            font-family:'-webkit-pictograph';
            margin:0;
            padding-top:20px;
        }
        *{
            box-sizing: border-box;
        }
        ul,li,ol{padding: 0;margin: 0;list-style: none;}
        img{border: none;}
        a:focus{ outline: none; }
        .email-box{
            width:712px;
            margin:0 auto;
        }
        .email-box .patpat-logo{
            text-align: center;
        }
        .email-box .email-message h2{
            text-align: center;
            margin-bottom:40px;
        }
        @media (max-width: 767px) {
            body{
                background: #edeaeb;
            }
            .email-box {
                width:100%;
            }
        }
    </style>
</head>
<body>
<div class="email-box">
    <div class="patpat-logo">
        <a href="http://www.patpat.com"><img src="http://patpatdev.s3.amazonaws.com/mail/large_size.png" alt="Insert Logo Here" width="165" height="50" id="Insert_logo" /></a>
    </div>
    <div class="email-message">
        <p>Hi <span>{{$user_name}}</span>，</p>
        <p>Thank you for shopping with us. Your package is in transit to PatPat central facility. It will be shipped within 2 to 3 business days.</p>
        <p>If you have any questions or concerns, please don't hesitate to contact support by clicking "Contact Support" on the order history page, or click "Customer Support" in our App. You can also email us via service@patpat.com or call our customer service number at 1-844-9-PATPAT from 8am-5pm PST.</p>
    </div>
</div>
</body>
</html>