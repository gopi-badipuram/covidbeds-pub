<?php session_start();

require_once('backend/redirect-https.php');
require_once('backend/dbconfig.php');


$query = "select * from testing_centers order by tc_name;";

if($stmt = $con->prepare($query)){
   if($stmt->execute()){
      $result = $stmt->get_result();

      if(mysqli_num_rows($result) > 0){
         $tc_arr = array();

         while($row = $result->fetch_assoc()){
            $tc_arr[] = $row;
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

   <meta name="description" content="Covid19 testing centers in Bengaluru with details of prices, type of test, results time,  contacts and location maps.">
   <meta name="keywords" content="covid test centers in Bengaluru, covid, coronavirus, covid19, rt-pcr, pcr, antibody antigen, rapid antigen">

   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-172126833-1"></script>
   <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());

     gtag('config', 'UA-172126833-1');
   </script>

   <!-- Site Metas -->
   <title>Covid testing centers in Bangalore.</title>
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
   <!-- [if lt IE 9] -->

   <link rel="canonical" href="https://covidbeds.org/test-centers.php">

   <meta property="og:locale" content="en_US">
   <meta property="og:url" content="https://covidbeds.org/test-centers.php">
   <meta property="og:type" content="website">
   <meta property="og:title" content="Covid19 testing centers in Bengaluru">
   <meta property="og:description" content="Covid19 testing centers in Bengaluru with details of prices, type of test, results time,  contacts and location maps.">
   <meta property="og:image" content="https://covidbeds.org/images/logo2.png">

   </head>

   <body class="clinic_version">
      <!-- END LOADER -->
      <header>
         <div class="header-top wow fadeIn" style="padding: 5px 0px;">
            <div class="container">
               <a class="navbar-brand" href="#" style="padding: 0;"><span style="font-size: 40px;"><img src="images/logo2.png" alt="image"></span></a>
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
                        <li><a class="active" href="#">Testing centers</a></li>
                        <li><a href="covidstats.php" title="Latest Covid statistics for Bengaluru, Karanataka and India.">Covid Cases</a></li>
                        <li><a href="news.php" title="Latest Covid related news">News</a></li>
                        <li><a href="counseling.php" title="Free counseling" >Free Counseling</a></li>
                     </ul>
                  </div>
               </nav>
               <div class="serch-bar">
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

            <div id="test_centers" class="services" style="padding: 20px 5%!important;">
               <div class="row">
                  <div class="col-md-12" style="background: white; border: solid 1px lightgrey;">
                     <center>
                        <h1 style="font-weight: bold;padding-top: 20px">Covid testing centres in Bengaluru</h1>
                        <h3 style="color: grey"><?php echo sizeof($tc_arr); ?> centres listed</h3>
                     </center>
                     <div class="table-responsive desktop-table">
                       <table id="testCenterTable" class="table" style="background: #2895f1;">
                       <thead>
                         <tr>
                           <th scope="col">#</th>
                           <th scope="col">Name</th>
                           <th scope="col">Phone Number</th>
                           <th scope="col" style="text-align: center;">Cost</th>
                           <th scope="col" style="text-align: center;">Result in</th>
                           <th scope="col" style="text-align: center;">Types of tests</th>
                           <th scope="col" style="text-align: center;">Address</th>
                         </tr>
                       </thead>
                       <tbody>
                        <?php
                           for($i = 0; $i < sizeof($tc_arr); $i++){

                              $date=date_create($tc_arr[$i]['last_update']);

                              echo '<tr>
                                       <th scope="row">'.($i+1).'</th>
                                       <td><a href="http://maps.google.com/?q='.$tc_arr[$i]['tc_name'].'" target="_blank">'.$tc_arr[$i]['tc_name'].'</a></td>';

                              $phone = explode("/", $tc_arr[$i]['tc_phone']);

                              $p = '<td>';

                              for ($j=0; $j < sizeof($phone); $j++) {
                                 $p .= '<a href="tel:'.$phone[$j].'">'.$phone[$j].'</a>';

                                 if($j != sizeof($phone) - 1){
                                    $p .= ' /';
                                 }
                              }

                              $p .= '</td>';

                              echo $p;

                              '<td>'.$tc_arr[$i]['tc_phone'].'</td>';
                              echo '<td style="color: black; font-size: 12px; font-weight: bold; text-align: center;">'.$tc_arr[$i]['tc_cost'].'</td>
                                       <td style="color: black; text-align: center;">'.$tc_arr[$i]['tc_wait_time'].'</td>
                                       <td style="color: black; text-align: center;">'.$tc_arr[$i]['tc_types'].'</td>
                                       <td><a href="http://maps.google.com/?q='.$tc_arr[$i]['tc_name'].'" target="_blank">'.$tc_arr[$i]['tc_addr'].'</a></td>
                                     </tr>';

                              $tc_arr[$i]['phone'] = $p;

                           }
                        ?>
                       </tbody>
                     </table>
                     </div>

                     <table id="testCenterTable" class="table mobile-table" style="background: #2895f1;">
                       <thead>
                         <tr>
                           <th scope="col">#</th>
                           <th scope="col">Name</th>
                         </tr>
                       </thead>
                       <tbody>
                        <?php
                           for($i = 0; $i < sizeof($tc_arr); $i++){

                              $date=date_create($tc_arr[$i]['last_update']);

                              echo '<tr>
                                       <th scope="row">'.($i+1).'</th>
                                       <td><a href="http://maps.google.com/?q='.$tc_arr[$i]['tc_name'].'" target="_blank">'.$tc_arr[$i]['tc_name'].'</a><br>';

                              $phone = explode("/", $tc_arr[$i]['tc_phone']);

                              $p = '';

                              for ($j=0; $j < sizeof($phone); $j++) {
                                 $p .= '<a href="tel:'.$phone[$j].'">'.$phone[$j].'</a>';

                                 if($j != sizeof($phone) - 1){
                                    $p .= ' /';
                                 }
                              }

                              $p .= '';

                              echo $p;

                              echo '<br><span style="color: green; font-weight: 500;">Cost: </span><span style="color: black; font-size: 12px; font-weight: bold;">'.$tc_arr[$i]['tc_cost'].'</span><br>
                                       <span style="color: green; font-weight: 500;">Result in: </span><span style="color: black; text-align: center;">'.$tc_arr[$i]['tc_wait_time'].'</span><br>
                                       <span style="color: green; font-weight: 500;">Types of test: </span><span style="color: black; text-align: center;">'.$tc_arr[$i]['tc_types'].'</span><br>
                                       <a href="http://maps.google.com/?q='.$tc_arr[$i]['tc_name'].'" target="_blank">'.$tc_arr[$i]['tc_addr'].'</a></td>
                                     </tr>';

                              $tc_arr[$i]['phone'] = $p;

                           }
                        ?>
                       </tbody>
                     </table>


                  </div>
               </div>
            </div>
            <!-- all js files -->
      <script src="js/all.js"></script>
      <!-- all plugins -->
      <script src="js/custom.js"></script>

      <script src="https://d3js.org/d3.v2.min.js?2.10.0"></script>
      <script src="js/test_center_search.php"></script>
            
      <?php include "footer.html" ?>
      <?php include "copyright.html" ?>
      <?php $_SESSION['test_center_list'] = $tc_arr; ?>
</body>
