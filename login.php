<!Doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <title>Login</title>

    <style type="text/css">
    	@media only screen and (max-width: 600px) {
		  .main{
		  	width: 80%!important;
		  }

		  .main-inner{
		  	width: 100%!important;
		  }
		}
    </style>
  </head>
  <body class="bg-light">
    
    <div class="container-fluid bg-primary" style="display: flex; justify-content: space-between;">
    	<div>
    		<h3 style="color: white; margin-top: 5px;">COVID STATS</h3>
    	</div>
    	<div style="display: flex; margin-top: 10px;">
    		<p style="color: white; padding-right: 20px;">HOME</p>
    	</div>
    </div>

    <div class="main" style="margin: auto; width: 50%;">
    	<div class="main-inner" style="width: 80%; margin-top: 20px; padding: 10px; border: solid 1px lightgrey; border-radius: 10px; background-color: white; box-shadow: 2px 2px lightgrey;">
    		<h4 style="text-align: center">Login Form</h4>

    		<hr>

    		<form id="login_form">
			  <div class="form-group">
			    <label for="login_id">Login ID</label>
			    <input id="login_id" type="text" class="form-control" placeholder="Login ID" autocomplete="username" required>
                <div class="invalid-feedback">
                    Wrong username or password
                </div>
			  </div>
			  <div class="form-group">
			    <label for="login_pass">Password</label>
			    <input id="login_pass" type="password" class="form-control" placeholder="Login Password" autocomplete="current-password" required>
                <div class="invalid-feedback">
                    Wrong username or password
                </div>
			  </div>
			  <center><button id="login_btn" class="btn btn-primary is-invalid" type="submit">Login</button></center>
			</form>
    	</div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script type="text/javascript">

    $(document).ready(function() {
    	$("#login_form").submit(function(e){
            e.preventDefault();

            let id = $("#login_id").val();
            let pass = $("#login_pass").val();

            if(id != '' && pass != ''){
                $.ajax({
                    url: 'backend/index.php',
                    method: 'post',
                    data: {
                        admin_login: 1,
                        login_id: id,
                        login_pass: pass
                    },
                    beforeSend: function() {
                        $("#login_btn").html(`<div class="spinner-border text-white" role="status">
                                              <span class="sr-only">Loading...</span>
                                            </div>`).attr('disabled', 'true');
                    },
                    success: function(data) {
                        $("#login_btn").html('Login').removeAttr('disabled');

                        data = JSON.parse(data);

                        if(data.response == 'success'){
                            let redirect = "<?php if(isset($_GET['redirect'])) echo $_GET['redirect']; else echo 'admin-home.php'; ?>";
                            console.log(redirect);
                            window.location.href = redirect;
                        }
                        else{
                            if(data.cause == 'wrong password'){
                                $('.invalid-feedback').html('wrong username or password');
                                $('input').addClass('is-invalid');
                            }
                            else if(data.cause == "paramas empty"){
                                $('.invalid-feedback').html('username or password cannot be empty');
                                $('input').addClass('is-invalid');
                            }
                            else{
                                $('.invalid-feedback').html('Something went wrong. Please try again later');
                                $('input').addClass('is-invalid');
                            }
                        }
                    },
                    error: function(data) {
                        $("#login_btn").html('Login').removeAttr('disabled');

                        $('.invalid-feedback').html('Something went wrong. Please try again later');
                        $('input').addClass('is-invalid');
                    }
                })
            }
        })
    })
    </script>
  </body>
</html>
