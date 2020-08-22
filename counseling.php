<?php

require_once('backend/redirect-https.php');
require_once('backend/dbconfig.php');

$counsellors_query = "select count(*) from counsellors where phone_verified = 1;";

if($stmt = $con->prepare($counsellors_query)){
   if($stmt->execute()){
      $result = $stmt->get_result();
      
      $counsellors = mysqli_fetch_field($result);
   }
}

$counselling_requests_query = "select count(*) from counselling_requests;";

if($stmt = $con->prepare($counselling_requests_query)){
   if($stmt->execute()){
      $result = $stmt->get_result();
      
      $counselling_requests = mysqli_fetch_field($result);
   }
}

$counselling_sessions_query = "select count(*) from counselling_requests where req_session_date != '0000-00-00 00:00:00';";

if($stmt = $con->prepare($counselling_sessions_query)){
   if($stmt->execute()){
      $result = $stmt->get_result();
      
      $counselling_sessions = mysqli_fetch_field($result);
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

   <meta name="description" content="Avail free online Covid counselling offered by expert counsellors of Naturae Viam.">
   <meta name="keywords" content="covid counselling, covid guidelines, online counselling, free online counselling, free covid counselling, covid, corona, Naturae Viam">

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
   <script src="js/counseling.js"></script>
   <!-- [if lt IE 9] -->

   <link rel="canonical" href="https://covidbeds.org/counseling.php">

   <meta property="og:locale" content="en_US">
   <meta property="og:url" content="https://covidbeds.org/counseling.php">
   <meta property="og:type" content="website">
   <meta property="og:title" content="Free online Covid counselling.">
   <meta property="og:description" content="Avail free online Covid counselling offered by expert counsellors of Naturae Viam.">
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
                        <li><a href="index.php" title="Covid19 hospitals in Bengaluru">Hospitals</a></li>
                        <li><a href="test-centers.php" title="Covid testing centers in Bengaluru">Testing centers</a></li>
                        <li><a href="covidstats.php" title="Latest Covid statistics for Bengaluru, Karanataka and India.">Covid Cases</a></li>
                        <li><a href="news.php" title="Latest Covid related news">News</a></li>
                        <li><a class="active" href="#">Free counseling</a></li>
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
     <div id="counseling_div" class="services wow fadeIn">
         <div class="container">
            <center><h2 style="font-weight: bold; background-color: white; padding-top: 20px; margin-top:-6%" >Free Counseling services from Naturae Viam</h2></center>
            <?php if(isset($_GET["preview"])) { ?>
         </div>   
         <div class="tiles_row" >
            <div class="covid_tile ">
                 
                 <div style="
                      height: inherit;
                      margin-right: 5%;
                      ">
                     <div id="counselling_requests_count" class="covid_inner_tile tile_requests"> 
                         <span class="desktop-only"> Counselling Requests </span>
                         <span class="mobile-only"> Requests </span>
                         <br class="desktop-only">
                             <div style="
                                  font-weight: bolder;
                                  padding-left: 22%;
                                  ">
                                 <div class="tile_data">100</div>
                             </div>
                     </div>
                 </div>
            </div>   
            <div class="covid_tile ">
                 
                 <div style="
                      height: inherit;
                      margin-right: 5%;
                      ">
                     <div id="counselling_sessions_done" class="covid_inner_tile tile_sessions"> 
                         <span class="desktop-only"> Counselling Sessions </span>
                         <span class="mobile-only"> Sessions </span>
                         <br class="desktop-only">
                             <div style="
                                  font-weight: bolder;
                                  padding-left: 22%;">
                                 <div class="tile_data">100</div>
                             </div>
                             
                     </div>
                 </div>
            </div>
            <div class="covid_tile ">
                 
                 <div style="
                      height: inherit;
                      margin-right: 5%;
                      ">
                     <div id="counsellors_count" class="covid_inner_tile tile_counsellors"> 
                         <span class="desktop-only"> <br> Counsellors </span>
                         <span class="mobile-only"> Counsellors </span>
                         <br class="desktop-only">
                             <div style="
                                  font-weight: bolder;
                                  padding-left: 22%;
                                  ">
                                 <div class="tile_data">100</div>
                             </div>
                             
                     </div>
                 </div>
        
             </div>
        </div>
        <div class="container">
            <?php } ?>
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="appointment-form">
                     <center><h3><span>+</span> Book counseling session</h3></center>
                     <div class="form">
                        <form id="counsel_form">
                           <div class="row">
                              <div class="col-md-6">
                                 <fieldset>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <input type="text" id="counsel_name" placeholder="Your Name*" required/>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <input type="email" placeholder="Email Address*" id="counsel_email" required/>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <input type="number" placeholder="Phone Number*" id="counsel_phone" required/>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <input type="text" placeholder="Country*" id="counsel_country" required/>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <input type="text" placeholder="City*" id="counsel_city" required/>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <select id="counsel_age" class="form-control">
                                                <option>Age*</option>
                                                <option>less than 18 years</option>
                                                <option>18 - 35 years</option>
                                                <option>more than 35 years</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <input type="text" placeholder="Occupation" id="counsel_occupation" />
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <select id="counsel_language" class="form-control">
                                                <option>Preferred Language*</option>
                                                <option>English</option>
                                                <option>Hindi</option>
                                                <option>Other</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </fieldset>
                              </div>

                              <div class="col-md-6">
                                 <fieldset>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <select id="counsel_mode" class="form-control">
                                                <option>Preferred Mode of Counseling*</option>
                                                <option>Voice</option>
                                                <option>Video</option>
                                                <option>Any</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="">
                                             <span style="color: #333; font-size: 13px; font-weight: 400;">Preferred days for counseling*</span><br>
                                             <div id="counsel_days" style="padding-left: 15px;">
                                                <input type="checkbox" value="Monday">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Monday</span>
                                                <input type="checkbox" value="Tuesday">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Tuesday</span>
                                                <input type="checkbox" value="Wednesday">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Wednesday</span>
                                                <input type="checkbox" value="Thursday">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Thursday</span>
                                                <input type="checkbox" value="Friday">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Friday</span>
                                                <input type="checkbox" value="Saturday">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Saturday</span>
                                                <input type="checkbox" value="Sunday">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Sunday</span>
                                                <input type="checkbox" value="Any day">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Any day</span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 select-section">
                                       <div class="row">
                                          <div class="form-group">
                                             <select id="counsel_time" class="form-control">
                                                <option>Preferred time*</option>
                                                <option>Morning</option>
                                                <option>Afternoon</option>
                                                <option>Evening</option>
                                                <option>Night</option>
                                                <option>Any time</option>
                                             </select>
                                          </div>
                                          <div class="form-group">
                                             <select id="counsel_for" class="form-control">
                                                <option>Counseling for*</option>
                                                <option>Home Quarantine</option>
                                                <option>Anxiety</option>
                                                <option>Stress</option>
                                                <option>Depression</option>
                                                <option>Relationship</option>
                                                <option>Health Management</option>
                                                <option>Other</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="">
                                             <span style="color: #333; font-size: 13px; font-weight: 400;">Have you attended any session with any psychologist or psychiatrist prior to this?*</span><br>
                                             <div style="padding-left: 15px;">
                                                <input type="radio" name="counsel_history" value="Yes">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">Yes</span><br>
                                                <input type="radio" name="counsel_history" value="No">&nbsp;<span style="color: #333; font-size: 13px; margin-right: 10px;">No</span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <textarea rows="4" id="counsel_message" class="form-control" placeholder="Comments or any questions"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="row">
                                          <div class="form-group">
                                             <div class="center">
                                                <button id="counsel_submit_btn" type="submit">
                                                   Submit
                                                </button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                     <center><small id="counsel-alert-txt"></small></center>
                                 </fieldset>
                              </div>


                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>


            <?php include "footer.html" ?>
            <?php include "copyright.html" ?>


      </body>

