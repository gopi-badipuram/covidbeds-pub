<?php

require_once('backend/dbconfig.php');

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
	header("Location: login.php?redirect=messages.php");
}

$query = "select * from feedback order by feed_date desc";

if($stmt = $con->prepare($query)){
    if($stmt->execute()){
        $result = $stmt->get_result();

        $arr = array();

        if(mysqli_num_rows($result) > 0){
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }
    }
}

?>

<!Doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <title>Messages</title>

    <style type="text/css">

    	#logout_btn:hover{
    		cursor: pointer;
    	}

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
    		<h3 style="color: white; margin-top: 5px;">Covidbeds.org</h3>
    	</div>
    	<div style="display: flex; margin-top: 10px;">
    		<a style="color: white; padding-right: 20px;" href="admin-home.php">Home</a>
    		<p id="logout_btn" style="color: white;" onclick="logout()">Logout</p>
    	</div>
    </div>

    <div class="container-fluid">
    	<h3 style="text-align: center; margin-top: 10px;">Feedback</h3>

    	<div id="main_inner" class="row" style="margin-top: 20px;">
    		<!-- <div class="col-md-4"></div>
    		<div class="col-md-4">
    			<center>
    				<div style="margin-top: 30%; width: 3rem; height: 3rem;" class="spinner-border text-primary" role="status">
                    	<span class="sr-only">Loading...</span>
                	</div>
    			</center>
    		</div> -->
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table" style="background: white;">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Email</th>
                          <th scope="col">Phone</th>
                          <th scope="col">Subject</th>
                          <th scope="col">Message</th>
                          <th scope="col">Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?
                            if(sizeof($arr) > 0){
                                for($i = 0; $i < sizeof($arr); $i++){

                                    echo '<tr>
                                          <th scope="row">'.($i+1).'</th>
                                          <td>'.$arr[$i]['feed_name'].'</td>
                                          <td>'.$arr[$i]['feed_email'].'</td>
                                          <td>'.$arr[$i]['feed_phone'].'</td>
                                          <td>'.$arr[$i]['feed_subject'].'</td>
                                          <td>'.$arr[$i]['feed_msg'].'</td>
                                          <td>'.(date_format(date_create($arr[$i]['feed_date']),"d F Y h:i A")).'</td>
                                        </tr>';
                                }
                            }
                            else{
                                echo '<center><h4>No Messages</h4</center>';
                            }
                        ?>
                      </tbody>
                    </table>
                </div>
            </div>
    	</div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script type="text/javascript">

    function logout(){
    	$.ajax({
    		url: 'backend/index.php',
    		method: 'post',
    		data: {
    			logout: 1
    		},
    		beforeSend: function() {
    			$("#logout_btn").html(`<div class="spinner-border text-white" role="status">
                                        <span class="sr-only">Loading...</span>
                                       </div>`).attr('disabled', 'true');
    		},
    		success: function(data) {
    			$("#logout_btn").html('Logout').removeAttr('disabled');

                data = JSON.parse(data);

                if(data.response == "success"){
                	window.location.href = 'login.php';
                }
    		},
    		error: function(data) {
    			$("#logout_btn").html('Logout').removeAttr('disabled');
    		}
    	})
    }

    </script>
  </body>
</html>