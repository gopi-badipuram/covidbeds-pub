<!DOCTYPE html>
    <html lang="en">
       <!-- Basic -->
       <meta charset="utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <!-- Mobile Metas -->
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta name="viewport" content="initial-scale=1, maximum-scale=1">
       
       <title>Covidbeds | Counsellor login</title>
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

          input{
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
                            <li><a class="active">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                         </ul>
                      </div>
                   </nav>
                </div>
             </div>
          </header>

          <div class="main" style="margin: auto; width: 50%; margin-top: 160px;">
            <div class="main-inner" style="width: 80%; margin-top: 20px; padding: 10px; border: solid 1px lightgrey; border-radius: 10px; background-color: white; box-shadow: 2px 2px lightgrey;">
                <h4 style="text-align: center">Counsellor Login</h4>

                <hr>

                <form id="login_form">
                  <div class="form-group">
                    <label for="login_id">Email ID or Phone number</label>
                    <input id="login_id" type="text" class="form-control" placeholder="Login ID" required>
                  </div>
                  <div class="form-group">
                    <label for="login_pass">Password</label>
                    <input id="login_pass" type="password" class="form-control" placeholder="Login Password" required>
                  </div>
                  <p style="font-size: 12px; text-align: right;"><a id="resend_btn" href="register.php">Register here</a></p>
                  <center><button id="login_btn" class="btn btn-primary is-invalid" type="submit">Login</button></center>
                  <center><span id="alert-txt"></span></center>
                </form>
            </div>
        </div>

        <script src="../js/all.js"></script>
        <!-- all plugins -->
        <script src="../js/custom.js"></script>

        <script type="text/javascript">

            $("#login_form").submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: '../backend/index.php',
                    method: 'post',
                    data: {
                        counsellor_login: 1,
                        login_id: $("#login_id").val(),
                        login_pass: $("#login_pass").val()
                    },
                    beforeSend: function(){
                        $("#login_btn").html('<center><img src="../images/white-loader.gif" style="height: 12px;">&nbsp;Please wait...</center').attr('disabled','disabled');
                    },
                    success: function(data){
                        $("#login_btn").html("Login").removeAttr('disabled');

                        data = JSON.parse(data);

                        if(data.response == 'success'){
                            window.location.href = './';
                        }
                        else{
                            if(data.cause == 'wrong password'){
                                $("#alert-txt").html('Wrong password').css('color','red');
                            }
                            else{
                                $("#alert-txt").html('Something went wrong').css('color','red');
                            }
                        }
                    },
                    error: function(data){
                        $("#login_btn").html("Login").removeAttr('disabled');
                        $("#alert-txt").html('Something went wrong').css('color','red');
                    }
                })
            })

        </script>

        </body>
    </html>