<?php

require_once('backend/redirect-https.php');
require_once('backend/dbconfig.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <meta name="description" content="Read the latest in Covid news.">
    <meta name="keywords" content="covid, coronavirus, covid19, covid news">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172126833-1"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());

     gtag('config', 'UA-172126833-1');
   </script>

    <!-- Site Metas -->
    <title>Latest Covid related news</title>
    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Colors CSS -->
    <link rel="stylesheet" href="css/colors.css">
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="css/versions.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <link rel="stylesheet" href="css/covidbeds.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<!-- Modernizer for Portfolio -->
    <script src="js/modernizer.js"></script>
    <!-- [if lt IE 9] -->

    <link rel="canonical" href="https://covidbeds.org/news.php">

    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="https://covidbeds.org/news.php">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Latest Covid related news">
    <meta property="og:description" content="Read the latest in Covid news.">
    <meta property="og:image" content="https://covidbeds.org/images/logo2.png">

</head>

<body class="clinic_version">

<header>
    <div class="header-top wow fadeIn" style="padding: 5px 0px;">
        <div class="container">
            <a class="navbar-brand" href="index.php" style="padding: 0;">
                <span style="font-size: 40px;">
                    <img src="images/logo2.png" alt="image">
                </span>
            </a>
            <div class="right-header" style="margin: 0;">
                <div class="header-info">
                    <div class="info-inner">
                        <span class="icontop"><img src="images/phone-icon.png" alt="#"></span>
                        <span class="iconcont" style="padding-right: 10px;">Emergency Medical Support: <a title="Emergency medical support phone number for covid" href="tel: 104">104 /</a> <a title="Emergency medical support phone number for covid" href="tel: 97456-97456">97456-97456 </a></span><br>
                        <span class="iconcont">Aptamitra: <a title="Aptamitra phone number for covid related queries" href="tel: 14410">14410</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom wow fadeIn">
        <div class="container">
            <nav class="main-menu">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i class="fa fa-bars" aria-hidden="true"></i></button>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                         <li><a href="index.php" title="Covid19 hospitals in Bengaluru">Hospitals</a></li>
                         <li><a href="test-centers.php" title="Covid testing centers in Bengaluru">Testing centers</a></li>
                         <li><a href="covidstats.php" title="Latest Covid statistics for Bengaluru, Karanataka and India.">Covid Cases</a></li>
                         <li><a href="news.php">News</a></li>
                         <li><a href="counseling.php" title="Free counseling" >Free Counseling</a></li>
                         <li><a class="active" href="#" title="Ambulance On WhatsApp">Ambulance On WhatsApp</a></li>

                    </ul>
                </div>
            </nav>
            <div class="serch-bar" style="display:none">
                <div id="custom-search-input">
                    <div id="searchDiv" class="input-group col-md-12">
                        <input id="searchInput" type="text" class="form-control input-lg" placeholder="Search for hospital, pincode, address" autocomplete="off"/>
                        <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php include "header.html" ?>

<div id="ambulance_on_whatsapp" class="container">
    <div class="heading">
        <h2 style="font-weight: bold; background-color: white; padding-top: 20px">Ambulance On WhatsApp</h2>
    </div>
    <div class="row">
    <div class="col-md-12">
        <table id="table_ambulance_sop">
            <tr>
                <td class="img-container">
                    <img class="poster" src="images/ambulance_on_whatsapp.jpg" />
                </td>
            </tr>
        </table>
    </div>
    </div>
    <?php include "footer.html" ?>
    <?php include "copyright.html" ?>
</div>

</body>
</html>
