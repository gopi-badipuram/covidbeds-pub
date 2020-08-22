<!DOCTYPE html>
<html lang="en">
   <!-- Basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Mobile Metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   
   <title>Covidbeds | Beds availability at covid hospitals in Bengaluru</title>
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
   <!-- Modernizer for Portfolio -->
   <script src="js/modernizer.js"></script>
   <!-- [if lt IE 9] -->
   <style type="text/css">
      .iconcont{
         font-size: 16px;
         margin: 0;
         margin-top: -5px;
      }

      .contact-section{
         background: none;
      }

      .form-contant{
         width: 100%;
      }
   </style>
   </head>
   <body style="background: #f8f9fa!important;">
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
                        <li><a href="#">Home</a></li>
                        <li><a class="active">Blog</a></li>
                     </ul>
                  </div>
               </nav>
            </div>
         </div>
      </header>

      <div class="jumbotron jumbotron-fluid" style="height: 60vh; margin-top: 128px; background-image: url(images/bg2.jpg); background-color: rgba(0, 0, 0, 0.6); background-blend-mode: color; margin-bottom: 0;">
        <div class="container" style="padding-top: 15vh;">
          <center>
            <h1 class="display-4" style="color: white">Title of the blog</h1>
            <p class="lead">By author name on 2 July 9:00AM</p>
          </center>
        </div>
      </div>

      <div style="width: 100%;">
         <div class="container" style="background: white; width: 80%; margin-left: 10%; padding-top: 30px;">
            <h1>About</h1>
            <p>A card is a flexible and extensible content container. It includes options for headers and footers, a wide variety of content, contextual background colors, and powerful display options. If you’re familiar with Bootstrap 3, cards replace our old panels, wells, and thumbnails. Similar functionality to those components is available as modifier classes for cards.</p>
         </div>
      </div>

      <footer id="footer" class="footer-area wow fadeIn">
         <div class="container">
            <div class="heading">
               <h2>Get in touch</h2>
            </div>
            <div class="row">
               <div class="col-md-8">
                  <div class="contact-section">
                     <div class="form-contant">
                        <form id="contact-form">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group in_name">
                                    <input id="contact-name" type="text" class="form-control" placeholder="Name*" required="required">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group in_email">
                                    <input id="contact-email" type="email" class="form-control" placeholder="E-mail">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group in_email">
                                    <input id="contact-phone" type="tel" class="form-control" placeholder="Phone">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group in_email">
                                    <input type="text" class="form-control" id="contact-subject" placeholder="Subject*" required="required">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group in_message"> 
                                    <textarea class="form-control" id="contact-message" rows="5" placeholder="Message*" required="required"></textarea>
                                 </div>
                                 <div class="actions">
                                    <input type="submit" value="Send Message" name="submit" id="submitButton" class="btn small" title="Submit Your Message!">
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="subcriber-info">
                     <h3>UPDATES</h3>
                     <p>Get updates on beds availability status and covid situation in Karnataka.</p>
                     <div class="subcriber-box">
                        <form id="mc-form" class="mc-form">
                           <div class="newsletter-form">
                              <input type="email" autocomplete="off" id="mc-email" placeholder="Email address" class="form-control" name="EMAIL" required>
                              <button class="mc-submit" type="submit"><i class="fa fa-paper-plane"></i></button> 
                              <div class="clearfix"></div>
                              <!-- mailchimp-alerts Start -->
                              <div class="mailchimp-alerts">
                                 <div class="mailchimp-submitting"></div>
                                 <!-- mailchimp-submitting end -->
                                 <div class="mailchimp-success"></div>
                                 <!-- mailchimp-success end -->
                                 <div class="mailchimp-error"></div>
                                 <!-- mailchimp-error end -->
                              </div>
                              <!-- mailchimp-alerts end -->
                           </div>
                        </form>
                        <div id="mc-response"></div>
                     </div>

                     <div class="footer-info padding" style="margin-top: 20px;">
                        <h3>CONTACT US</h3>
                        <p><i class="fa fa-map-marker" aria-hidden="true"></i> Bengaluru, Karnataka</p>
                        <p><i class="fa fa-paper-plane" aria-hidden="true"></i> covidbeds@gmail.com</p>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </footer>

      <div class="copyright-area wow fadeIn">
         <div class="container">
            <div class="row">
               <div class="col-md-8">
                  <div class="footer-text">
                     <p>© 2020 covidbeds.org. All Rights Reserved.</p>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="social">
                     <ul class="social-links">
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="https://www.facebook.com/covidbeds" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/covidbeds" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </body>
</html>
