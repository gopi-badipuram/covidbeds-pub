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
    <title>Latest Covid news</title>
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
    
   
    
    <script src="js/video.js"></script>
    <!-- [if lt IE 9] -->

    <link rel="canonical" href="https://covidbeds.org/news.php">

    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="https://covidbeds.org/news.php">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Latest Covid related news">
    <meta property="og:description" content="Read the latest in Covid news.">
    <meta property="og:image" content="https://covidbeds.org/images/logo_for_og.jpeg">

</head>

<body class="clinic_version">

<header>
    <div class="header-top wow fadeIn" style="padding: 5px 0px;">
        <?php include "header_top.html" ?>
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
                         <li><a class="active" href="#">News</a></li>
                         <!-- <li><a href="counseling.php" title="Free counseling" >Free Counseling</a></li> -->
                         <li><a href="ambulanceOnWhatsapp.php" title="Ambulance On WhatsApp">Ambulance On WhatsApp</a></li>
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

<div id="news" class="container">
    <div class="heading">
        <h2 style="font-weight: bold; background-color: white; padding-top: 20px">News</h2>
    </div>
    <div class="row">
        <div id="vid_div" class="col-md-12" style="margin-bottom: 20px;">
        </div>
        <div class="col-md-6" style="height: 600px; overflow: scroll;">
            <a class="twitter-timeline" href="https://twitter.com/covidbeds?ref_src=twsrc%5Etfw">Tweets by covidbeds</a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fcovidbeds%2F&tabs=timeline&width=340&height=600&small_header=true&adapt_container_width=false&hide_cover=false&show_facepile=true&appId" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
        </div>
    </div>
    <?php include "footer.html" ?>
    <?php include "copyright.html" ?>
</div>

</body>
</html>
