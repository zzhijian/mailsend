<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patpat</title>
    <style>
        html,body,ul,li,h1,h2,h3,h4,h5,h6,p,section{
            margin: 0;
            padding:0;
            list-style: none;
        }
        body{
            font-family: 'Avenir roman',"Helvetica Neue", Helvetica, Arial, sans-serif;
            font-style: normal;
            font-weight: 400;
        }
        .report-box{
            padding:30px 15px;
        }
        .report-title{
            text-align: center;
            margin-bottom:30px;
            font-size:22px;
        }
        .information{
            margin-bottom:25px;
        }
        .information h3{
            margin-bottom:15px;
            font-size:18px;
        }
        .information-ul{
            list-style:none;
        }
        .information-ul li{
            margin-bottom:15px;
            list-style-type:none !important;
        }
        .description{
            display: inline-block;
            vertical-align: top;
        }
        .description-msg{
            display: inline-block;
            vertical-align: top;
            width: calc(100% - 280px);
            line-height:20px;
        }
        .statement-msg{
            margin-top:5px;
            line-height:20px;
        }

        @media (max-width:767px){
            .description-msg{
                width:100%;
                margin-top:5px;
            }
        }
    </style>
</head>
<body>
<div class="report-box">
    <h2 class="report-title">Copyright Infringement Notice</h2>

    <section class="information">
        <h3>Personal Information</h3>
        <ul class="information-ul">
            @if($claimant_owner_name)
            <li>
                <span>Owner's name: </span>
                <span>{{$claimant_owner_name}}</span>
            </li>
            @endif
            <li>
                <span>Your name: </span>
                <span>{{$claimant_name}}</span>
            </li>
            <li>
                <span>Company: </span>
                <span>{{$claimant_company}}</span>
            </li>
            <li>
                <span>Job title: </span>
                <span>{{$claimant_job}}</span>
            </li>
            <li>
                <span>Address: </span>
                <span>{{$claimant_street}}, {{$claimant_city}}, {{$claimant_state}}, {{$claimant_postal_code}}, {{$claimant_country}}</span>
            </li>
            <li>
                <span>Email: </span>
                <span>{{$claimant_email}}</span>
            </li>
            <li>
                <span>Phone: </span>
                <span>{{$claimant_phone}}</span>
            </li>
            <li>
                <span>Fax: </span>
                <span>{{$claimant_fax}}</span>
            </li>
        </ul>
    </section>

    <section class="information">
        <h3>Infringing Material</h3>
        <ul class="information-ul">
            <li>
                <span>Project URL: </span>
                <span>{{$project_url}}</span>
            </li>
            <li>
                <div class="description">Description of copyrighted material: </div>
                <div class="description-msg">{{$copyright_desc}}</div>
            </li>
            <li>
                <div class="description">Description of infringing material: </div>
                <div class="description-msg">{{$infringement_desc}}</div>
            </li>
        </ul>
    </section>

    <section class="information">
        <h3>Statements</h3>
        <ul class="information-ul">
            <li>
                <div class="statement-title">1. 512(f) acknowledgement</div>
                <p class="statement-msg">I understand that, under 17 U.S.C § 512(f), I may be liable for any damages, including costs and attorneys' fees, if I knowingly and materially misrepresent that reported material or activity is infringing.</p>
            </li>
            <li>
                <div class="statement-title">2. Good faith belief</div>
                <p class="statement-msg">I declare under penalty of perjury that I have a good faith belief that the disputed use is not authorized by the copyright owner, its agent, or the law.</p>
            </li>
            <li>
                <div class="statement-title">3. Accuracy acknowledgement</div>
                <p class="statement-msg">I declare under penalty of perjury that the information above is accurate and that I am the copyright owner or am authorized to act on the copyright owner's behalf.</p>
            </li>
        </ul>
    </section>

    <section class="information">
        <h3>Full Name: <span>{{$email_full_name}}</span></h3>
    </section>
</div>
</body>
</html>