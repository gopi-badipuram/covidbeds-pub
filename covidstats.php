<?php

require_once('backend/redirect-https.php');
require_once('backend/dbconfig.php');

$query = "select * from covid_stats";

if($stmt = $con->prepare($query)){
   if($stmt->execute()){
      $result = $stmt->get_result();

      if(mysqli_num_rows($result) > 0){
         $arr1 = array();

         while($row = $result->fetch_assoc()){
            $arr1[$row['stat_key']] = $row['stat_value'];

            if($row['stat_key'] == 'bengaluru-today'){
               $arr1['bg-update'] = $row['stat_last_update'];
            }

            if($row['stat_key'] == 'karnataka-today'){
               $arr1['ka-update'] = $row['stat_last_update'];
            }

            if($row['stat_key'] == 'india-today'){
               $arr1['in-update'] = $row['stat_last_update'];
            }

         }
      }
   }
}

$query = "select * from blr_daily_stats where stat_date in (select max(stat_date) from blr_daily_stats);";

if($stmt = $con->prepare($query)){
    if($stmt->execute()){
        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0){
            $ward_cases = array();

            while($row = $result->fetch_assoc()){
                $ward_cases[$row['stat_ward_id']] = array("cases" => $row['stat_cases'], "date" => $row['stat_date'], "ward" => $row['stat_ward_name']);
                $d = $row['stat_date'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <!-- Basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Mobile Metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">

   <meta name="description" content="Latest Covid19 cases in Bengaluru, Karnataka and India.">
   <meta name="keywords" content="covid in Bengaluru, covid19 in Bengaluru, coronavirus, covid19, covid cases in India, covid cases in Bengaluru, covid cases in Karnataka">

   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172126833-1"></script>
   <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());

     gtag('config', 'UA-172126833-1');
   </script>

   <!-- Site Metas -->
   <title>Covidbeds | Covid beds in Bengaluru</title>
   <!-- Site Icons -->
   <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <!-- Site CSS -->
   <link rel="stylesheet" href="style.css">
   <!-- Colors CSS -->
   <link rel="stylesheet" href="css/colors.css">
   <!-- ALL VERSION CSS -->
   <link rel="stylesheet" href="css/versions.css">
   <!-- Responsive CSS -->
   <link rel="stylesheet" href="css/responsive.css">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/custom.css">

   <link rel="stylesheet" href="css/covidbeds.css">
   <!-- Modernizer for Portfolio -->
   <script src="js/modernizer.js"></script>
   <script src="js/all.js"></script>
   <script src="js/custom.js"></script>
   <!-- [if lt IE 9] -->

   <link rel="canonical" href="https://covidbeds.org/covidstats.php">

   <meta property="og:locale" content="en_US">
   <meta property="og:url" content="https://covidbeds.org/covidstats.php">
   <meta property="og:type" content="website">
   <meta property="og:title" content="Covid19 cases in Bengaluru, Karnataka and India.">
   <meta property="og:description" content="Latest Covid19 cases in Bengaluru, Karnataka and India.">
   <meta property="og:image" content="https://covidbeds.org/images/logo2.png">

   </head>

   <body class="clinic_version">
      <!-- END LOADER -->
      <header>
         <div class="header-top wow fadeIn" style="padding: 5px 0px;">
            <div class="container">
               <a class="navbar-brand" href="index.php" style="padding: 0;"><span style="font-size: 40px;"><img src="images/logo2.png" alt="image"></span></a>
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
                        <li><a href="index.php" title="Covid19 hospitals in Bengaluru">Home</a></li>
                        <li><a href="test-centers.php" title="Covid testing centers in Bengaluru">Testing centers</a></li>
                        <li><a class="active" href="#">Covid Cases</a></li>
                        <li><a href="news.php" title="Latest Covid related news">News</a></li>
                        <li><a href="counseling.php" title="Free counseling" >Free Counseling</a></li>
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

<div id="time-table" class="time-table-section">
    <div class="container">
    <div id="cs_heading" class="heading" >
        <h2 style="font-weight: bold; background-color: white; padding-top: 20px">Covid Stats</h2>
    </div>
    <br>
    <br>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ds">
            <div class="row">
                <div class="service-time one" style="background:#2895f1;">
                    <h3>Bengaluru <br><small style="color: white;">(as of
                        <?php
                        $date=date_create($arr1['bg-update']);

                        echo date_format($date,"d F h:i A");
                        ?>
                        )</small></h3>
                    <div class="time-table-section">
                        <ul>
                            <li><span class="left">Today:</span><span class="right">
                           <?
                              echo $arr1['bengaluru-today'];
                           ?>
                                cases</span></li>
                            <li><span class="left">Active cases:</span><span class="right"><?
                              echo $arr1['bengaluru-active'];
                           ?></span></li>
                            <li><span class="left">Discharges(today)</span><span class="right"><?
                              echo $arr1['bengaluru-discharges-today'];
                           ?></span></li>
                            <li><span class="left">Discharges(total):</span><span class="right"><?
                              echo $arr1['bengaluru-discharges-total'];
                           ?></span></li>
                            <li><span class="left">Deaths(today):</span><span class="right"><?
                              echo $arr1['bengaluru-deaths-today'];
                           ?></span></li>
                            <li><span class="left">Deaths(total):</span><span class="right"><?
                              echo $arr1['bengaluru-deaths-total'];
                           ?></span></li>
                            <li><span class="left">Total:</span><span class="right"><?
                              echo $arr1['bengaluru-total'];
                           ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ds">
            <div class="row">
                <div class="service-time middle" style="background:#0071d1;">
                    <h3>Karnataka <br><small style="color: white;">(as of
                        <?php
                        $date=date_create($arr1['ka-update']);

                        echo date_format($date,"d F h:i A");
                        ?>
                        )</small></h3>
                    <div class="time-table-section">
                        <ul>
                            <li><span class="left">Today:</span><span class="right">
                           <?
                              echo $arr1['karnataka-today'];
                           ?>
                                cases</span></li>
                            <li><span class="left">Active cases:</span><span class="right"><?
                              echo $arr1['karnataka-active'];
                           ?></span></li>
                            <li><span class="left">Discharges(today)</span><span class="right"><?
                              echo $arr1['karnataka-discharges-today'];
                           ?></span></li>
                            <li><span class="left">Discharges(total):</span><span class="right"><?
                              echo $arr1['karnataka-discharges-total'];
                           ?></span></li>
                            <li><span class="left">Deaths(today):</span><span class="right"><?
                              echo $arr1['karnataka-deaths-today'];
                           ?></span></li>
                            <li><span class="left">Deaths(total):</span><span class="right"><?
                              echo $arr1['karnataka-deaths-total'];
                           ?></span></li>
                            <li><span class="left">Total:</span><span class="right"><?
                              echo $arr1['karnataka-total'];
                           ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ds">
            <div class="row">
                <div class="service-time three" style="background:#0060b1;">
                    <h3>India <br><small style="color: white;">(as of
                        <?php
                        $date=date_create($arr1['in-update']);

                        echo date_format($date,"d F h:i A");
                        ?>
                        )</small></h3>
                    <div class="time-table-section">
                        <ul>
                            <li><span class="left">Today:</span><span class="right">
                           <?
                              echo $arr1['india-today'];
                           ?>
                                cases</span></li>
                            <li><span class="left">Active cases:</span><span class="right"><?
                              echo $arr1['india-active'];
                           ?></span></li>
                            <li><span class="left">Discharges(today)</span><span class="right"><?
                              echo $arr1['india-discharges-today'];
                           ?></span></li>
                            <li><span class="left">Discharges(total):</span><span class="right"><?
                              echo $arr1['india-discharges-total'];
                           ?></span></li>
                            <li><span class="left">Deaths(today):</span><span class="right"><?
                              echo $arr1['india-deaths-today'];
                           ?></span></li>
                            <li><span class="left">Deaths(total):</span><span class="right"><?
                              echo $arr1['india-deaths-total'];
                           ?></span></li>
                            <li><span class="left">Total:</span><span class="right"><?
                              echo $arr1['india-total'];
                           ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.html" ?>
<?php include "copyright.html" ?>
</body>
</html>
