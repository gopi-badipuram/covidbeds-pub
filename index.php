<?php session_start();

require_once('backend/redirect-https.php');
require_once('backend/dbconfig.php');

$query = "select * from hospital_details order by hospital_name;";

if($stmt = $con->prepare($query)){
   if($stmt->execute()){
      $result = $stmt->get_result();
      $arr = array();
      
      if(mysqli_num_rows($result) > 0){
         while($row = $result->fetch_assoc()){
            $arr[] = $row;
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

   <meta name="description" content="Covidbeds is an organisation to help covid patients. View latest beds availabilty at covid hospitals, view covid testing centers (with cost of testing) and avail free online counseling on our website. Also take a look at latest Covid cases and read latest Covid news and guidelines.">
   <meta name="keywords" content="covid beds in Bengaluru, covid beds in Bengaluru covid, coronavirus, covid19, covid hospitals in india, covid hospitals in Bengaluru, covid guidelines">

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

   <link rel="canonical" href="https://covidbeds.org/">

   <meta property="og:locale" content="en_US">
   <meta property="og:url" content="https://covidbeds.org">
   <meta property="og:type" content="website">
   <meta property="og:title" content="Covid19 beds availability status at Bengaluru hospitals">
   <meta property="og:description" content="Covidbeds is an organisation to help covid patients. View latest beds availabilty at covid hospitals, view covid testing centers (with cost of testing) and avail free online counseling on our website. Also take a look at latest Covid cases and read latest Covid news and guidelines.">
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
                        <li><a class="active" href="#">Hospitals</a></li>
                        <li><a href="test-centers.php" title="Covid testing centers in Bengaluru">Testing Centers</a></li>
                        <li><a href="covidstats.php" title="Latest Covid statistics for Bengaluru, Karanataka and India.">Covid Cases</a></li>
                        <li><a href="news.php" title="Latest Covid related news">News</a></li>
                        <li><a href="counseling.php" title="Free counseling">Free Counseling</a></li>
                        <li><a href="ambulanceOnWhatsapp.php" title="Ambulance On WhatsApp">Ambulance On WhatsApp</a></li>
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

      <div id="stats" class="container">
         <div class="row">
            <div class="col-md-12" style="background: white; border: solid 1px lightgrey;">
               <center>
                  <h1 style="font-weight: bold; padding-top: 20px">Covid treatment centres in Bengaluru</h1>
                  <h3 style="color: grey"> <?php echo sizeof($arr); ?> hospitals listed</h3>
               </center>
               <div class="table-responsive desktop-table">
                  <table id="hospTable" class="table" style="background: #2895f1;">
                 <thead>
                   <tr>
                     <th scope="col">#</th>
                     <th scope="col">Hospital name &nbsp;&nbsp;<span id="scr1" style="color: lightgrey; font-size: 12px;">scroll</span>&nbsp;<span id="scr2" class="fa fa-arrow-right" style="color: lightgrey; font-size: 12px;"></span></th>
                     <th scope="col" style="text-align: center;">Beds Status</th>
                     <th scope="col">Phone Number</th>
                     <th scope="col" style="text-align: center;">Address</th>
                     <th scope="col">Last updated</th>
                   </tr>
                 </thead>
                 <tbody>
                  <?php
                     for($i = 0; $i < sizeof($arr); $i++){

                        $date=date_create($arr[$i]['last_update']);

                        echo '<tr>
                                 <th scope="row">'.($i+1).'</th>
                                 <td><a href="http://maps.google.com/?q='.$arr[$i]['hospital_name'].'" target="_blank">'.$arr[$i]['hospital_name'].'</a></td><td><center>';

                        if($arr[$i]['hospital_vacant_beds'] == 'Full'){
                           echo '<span class="badge badge-danger">Full</span>';
                        }
                        elseif($arr[$i]['hospital_vacant_beds'] == 'Available'){
                           echo '<span class="badge badge-success">Available</span>';
                        }
                        else{
                           echo '<span class="badge">Unknown</span>';
                        }

                        echo '</td>';

                        $phone = explode("/", $arr[$i]['hospital_phone']);

                        $p = '<td>';

                        for ($j=0; $j < sizeof($phone); $j++) { 
                           $p .= '<a href="tel:'.$phone[$j].'">'.$phone[$j].'</a>';

                           if($j != sizeof($phone) - 1){
                              $p .= ' /';
                           }
                        }

                        $p .= '</td>';

                        echo $p;

                        '<td>'.$arr[$i]['hospital_phone'].'</td>';
                        echo '<td><a href="http://maps.google.com/?q='.$arr[$i]['hospital_name'].'" target="_blank">'.$arr[$i]['hospital_address'].'</a></td>
                                 <td>'.date_format($date,"d F Y h:i A").'</td>
                               </tr>';

                        $arr[$i]['last_update'] = date_format($date,"d F Y h:i A");
                        $arr[$i]['phone'] = $p;

                     }
                  ?>
                 </tbody>
               </table>
               </div>

               <table id="hospTable" class="table mobile-table" style="background: #2895f1;">
                 <thead>
                   <tr>
                     <th scope="col">#</th>
                     <th scope="col">Hospital</th>
                   </tr>
                 </thead>
                 <tbody>
                  <?php
                     for($i = 0; $i < sizeof($arr); $i++){

                        $date=date_create($arr[$i]['last_update']);

                        echo '<tr>
                                 <th scope="row">'.($i+1).'</th>
                                 <td><a style="font-weight: bold;" href="http://maps.google.com/?q='.$arr[$i]['hospital_name'].'" target="_blank">'.$arr[$i]['hospital_name'].'</a><br><span style="color: lightgrey;">Beds Status: </span>';

                        if($arr[$i]['hospital_vacant_beds'] == 'Full'){
                           echo '<span class="badge badge-danger">Full</span>';
                        }
                        elseif($arr[$i]['hospital_vacant_beds'] == 'Available'){
                           echo '<span class="badge badge-success">Available</span>';
                        }
                        else{
                           echo '<span class="badge">Unknown</span>';
                        }


                        $phone = explode("/", $arr[$i]['hospital_phone']);

                        $p = '<br>';

                        for ($j=0; $j < sizeof($phone); $j++) { 
                           $p .= '<a href="tel:'.$phone[$j].'">'.$phone[$j].'</a>';

                           if($j != sizeof($phone) - 1){
                              $p .= ' /';
                           }
                        }

                       
                        echo $p;

                        echo '<br><a style="width: 50px;" href="http://maps.google.com/?q='.$arr[$i]['hospital_name'].'" target="_blank">'.$arr[$i]['hospital_address'].'</a><br><span style="color: lightgrey;">Last checked on:</span><br>
                                 '.date_format($date,"d F Y h:i A").'
                               </tr>';

                        $arr[$i]['last_update'] = date_format($date,"d F Y h:i A");
                        $arr[$i]['phone'] = $p;

                     }
                  ?>
                 </tbody>
               </table>


               </div>
            </div>
         </div>
      </div>


      <div id="service" class="services wow fadeIn" style="margin-top: 20px;">
         <div class="container">
            <h2 style="color: white; text-align: center;">Guidelines By Govt of India to fight against coronavirus</h2>
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                  <div class="inner-services">
                     <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                        <div class="serv">
                           <span class="icon-service"><img src="images/stay-home.png" alt="stay home and fight against coronavirus" /></span>
                           <h4>Stay Home</h4>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                        <div class="serv">
                           <span class="icon-service"><img src="images/wash-hands.png" alt="wash your hands frequently and prevent covid infection" /></span>
                           <h4>Wash hands frequently</h4>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                        <div class="serv">
                           <span class="icon-service"><img src="images/sanitizer.png" alt="use sanitizers" /></span>
                           <h4>Use sanitizers</h4>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                        <div class="serv">
                           <span class="icon-service"><img src="images/mask.png" alt="wear mask to be safe from coronavirus" /></span>
                           <h4>Wear Masks</h4>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                        <div class="serv">
                           <span class="icon-service"><img src="images/handshake.png" alt="maintain social distancing" /></span>
                           <h4>Maintain Social distancing</h4>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                        <div class="serv">
                           <span class="icon-service"><img src="images/download.png" alt="download arogya setu app" /></span>
                           <h4>Download Arogya Setu App</h4>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end section -->

      <!-- all js files -->
      
      <!-- all plugins -->
      

      <script src="https://d3js.org/d3.v2.min.js?2.10.0"></script>
      <script src="js/hospital_search.php"></script>
      
      <?php include "footer.html" ?>
      <?php include "copyright.html" ?>
      <?php $_SESSION['hospitals_array'] = $arr; ?>
      
      <!--Start of Tawk.to Script-->
      <script type="text/javascript">
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      (function(){
      var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
      s1.async=true;
      s1.src='https://embed.tawk.to/5f2976712da87279037e48c5/default';
      s1.charset='UTF-8';
      s1.setAttribute('crossorigin','*');
      s0.parentNode.insertBefore(s1,s0);
      })();
      </script>
      <!--End of Tawk.to Script-->
   </body>
</html>

