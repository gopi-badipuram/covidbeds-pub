<!DOCTYPE html>
    <html lang="en">
       <!-- Basic -->
       <meta charset="utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <!-- Mobile Metas -->
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta name="viewport" content="initial-scale=1, maximum-scale=1">
       
       <title>Covidbeds | Counsellor registration</title>
       <!-- Site Icons -->
       <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon" />
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="../css/bootstrap.min.css">
       <!-- Site CSS -->
       <link rel="stylesheet" href="../style.css">
       <!-- Colors CSS -->
       <link rel="stylesheet" href="../css/colors.css">
       <!-- ALL VERSION CSS -->
       <link rel="stylesheet" href="../css/versions.css">
       <!-- Responsive CSS -->
       <link rel="stylesheet" href="../css/responsive.css">
       <!-- Custom CSS -->
       <link rel="stylesheet" href="../css/custom.css">
       <!-- Modernizer for Portfolio -->
       <script src="../js/modernizer.js"></script>
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

          .jumbotron{
            margin-top: 128px;
          }

          input, select{
            margin-top: 0px!important;
            margin-bottom: 10px!important;
          }

          @media only screen and (max-width: 600px){
              nav.main-menu .navbar-toggle{
                 margin-top: -10px;
              }

              .jumbotron {
                 margin-top: 60px !important;
              }

              .main{
                width: 80%!important;
              }

              .main-inner{
                width: 100%!important;
              }
           }
       </style>
       </head>
       <body style="background: #f8f9fa!important;">
          <!-- END LOADER -->
          <header>
             <div class="header-top wow fadeIn" style="padding: 5px 0px;">
                <div class="container">
                   <a class="navbar-brand" href="../" style="padding: 0;"><span style="font-size: 40px;"><img src="../images/logo2.png" alt="image"></span></a>
                   <div class="right-header" style="margin: 0;">
                      <div class="header-info">
                         <div class="info-inner">
                            <span class="icontop"><img src="../images/phone-icon.png" alt="#"></span>
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
                            <li><a class="active">Register</a></li>
                            <li><a href="login.php">Login</a></li>
                         </ul>
                      </div>
                   </nav>
                </div>
             </div>
          </header>

          <div class="main" style="margin: auto; width: 50%; margin-top: 160px;">
            <div class="main-inner" style="width: 80%; margin-top: 20px; padding: 10px; border: solid 1px lightgrey; border-radius: 10px; background-color: white; box-shadow: 2px 2px lightgrey;">
                <h4 style="text-align: center">Counsellor Registration</h4>

                <hr>

                <form id="reg_form">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control" placeholder="Name" required>
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input id="phone" type="number" class="form-control" placeholder="Phone Number" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email ID</label>
                    <input id="email" type="email" class="form-control" placeholder="Email ID" required>
                  </div>
                  <div class="form-group">
                    <label for="pass1">Password</label>
                    <input id="pass1" type="password" class="form-control" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <label for="pass2">Re-enter Password</label>
                    <input id="pass2" type="password" class="form-control" placeholder="Re-enter Password" required>
                  </div>
                  <center><button id="register_btn" class="btn btn-primary" type="submit">Register</button></center>
                </form>

                <form id="otp_form" style="display: none;">
                  <div class="form-group">
                    <label for="name">Enter OTP</label>
                    <input id="otp" type="number" class="form-control" placeholder="Enter OTP" required>
                    <p style="font-size: 12px; text-align: right;"><a id="resend_btn" href="javascript:void(0)">Resend OTP <span id="timer"></span></a></p>
                  </div>
                  <center><button id="verify_btn" class="btn btn-primary" type="submit">Submit</button></center>
                  <center><span id="alert-txt"></span></center>
                </form>
            </div>
        </div>

        <script src="../js/all.js"></script>
        <!-- all plugins -->
        <script src="../js/custom.js"></script>

        <script type="text/javascript">
          let resend_active = false;
          let phone;

          $(document).ready(function(){

            $("#reg_form").submit(function(e){
              e.preventDefault();

              let pass1 = $("#pass1").val();
              let pass2 = $("#pass2").val();

              if(pass1 != "" && pass1 == pass2){
                phone = $("#phone").val();

                $.ajax({
                  url: '../backend/index.php',
                  method: 'post',
                  data: {
                    register_counsellor: 1,
                    name: $("#name").val(),
                    phone: phone,
                    email: $("#email").val(),
                    pass: pass1
                  },
                  beforeSend: function(){
                    $("#register_btn").html('<center><img src="../images/white-loader.gif" style="height: 12px;">&nbsp;Please wait...</center').attr('disabled','disabled');
                  },
                  success: function(data){
                    $("#register_btn").html("Register").removeAttr('disabled');

                    data = JSON.parse(data);

                    if(data.response == 'success'){
                      $("#reg_form").css('display', 'none');
                      $("#otp_form").css('display', 'block');

                      $("#alert-txt").html('OTP sent successfully').css('color', 'green');

                      setTimeout(function(){
                        $("#alert-txt").html('');
                      }, 4000);

                      startTimer();
                    }
                    else{
                      alert('Something went wrong');
                    }
                  },
                  error: function(data){
                    $("#register_btn").html("Register").removeAttr('disabled');
                  }
                })
              }
              else{

              }
            })


            $("#otp_form").submit(function(e){
              e.preventDefault();

              $.ajax({
                url: '../backend/index.php',
                method: 'post',
                data: {
                  verify_otp: 1,
                  otp: $("#otp").val(),
                  phone: phone,
                  },
                  beforeSend: function(){
                    $("#verify_btn").html('<center><img src="../images/white-loader.gif" style="height: 12px;">&nbsp;Please wait...</center').attr('disabled','disabled');
                  },
                  success: function(data){
                    $("#verify_btn").html("Submit").removeAttr('disabled');

                    data = JSON.parse(data);

                    if(data.response == 'success'){
                     $("#alert-txt").html('Account registered successfully').css('color', 'green');

                      setTimeout(function(){
                        window.location.href = 'login.php';
                      }, 2000);
                     
                    }
                    else{
                      $("#alert-txt").html('Something went wrong').css('color', 'red');
                    }
                  },
                  error: function(data){
                    $("#verify_btn").html("Register").removeAttr('disabled');
                  }
                })
            })

          })

          function startTimer(){
            let count = 30;
            
            let x = setInterval(function(){
              count --;

              if(count == 0){
                clearInterval(x);
                $("#timer").html('');
                resend_active = true;
                $("#resend_btn").attr("onclick", "resendOTP()");
              }
              else{
                $("#timer").html('in ' + count + ' s');
              }
            }, 1500);
          }

          function resendOTP(){
            if(resend_active){
              $.ajax({
                url: '../backend/index.php',
                method: 'post',
                data: {
                  resend_otp: 1,
                  phone: phone
                },
                beforeSend: function(){

                },
                success: function(data){
                  data = JSON.parse(data);

                  if(data.response == "success"){
                    $("#alert-txt").html('OTP sent successfully').css('color', 'green');

                    setTimeout(function(){
                      $("#alert-txt").html('');
                    }, 4000);

                    $("#resend_btn").removeAttr('onclick');
                    resend_active = false;

                    startTimer();
                  }
                  else{
                    $("#alert-txt").html('Something went wrong').css('color', 'red');
                  }
                },
                error: function(data){
                  $("#alert-txt").html('Something went wrong').css('color', 'red');
                }
              })
            }
          }
        </script>

        </body>
    </html>