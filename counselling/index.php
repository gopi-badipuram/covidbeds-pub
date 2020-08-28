<?php

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'counsellor'){
	header("Location: login.php");
}

require_once('../backend/dbconfig.php');

$query = "select * from counselling_requests order by req_date desc";

if($stmt = $con->prepare($query)){
	if($stmt->execute()){
		$result = $stmt->get_result();

		if(mysqli_num_rows($result) > 0){
			$arr = array();

			while ($row = $result->fetch_assoc()) {
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
	   
	   <title>Covidbeds | Counsellor</title>
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
	   <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
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

	      .card{
	      	border: solid 1px lightgrey;
	      	border-radius: 10px;
	      	padding: 10px;
	      	margin-top: 10px;
	      }

	      @media only screen and (max-width: 600px){
		      nav.main-menu .navbar-toggle{
		         margin-top: -10px;
		      }

		      .jumbotron {
		         margin-top: 60px !important;
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
	                        <li><a class="active">Home</a></li>
	                        <li><a href="#">Profile</a></li>
	                        <li><a href="#">Logout</a></li>
	                     </ul>
	                  </div>
	               </nav>
	            </div>
	         </div>
	      </header>



	      <div class="container" style="background: white; padding: 10px; margin-top: 160px;">
	      	<center><h1>My Sessions</h1></center>

	      	<?
	      		$count = 0;

	      		for($i = 0; $i < sizeof($arr); $i++){
	      			if($arr[$i]['req_accepted_by'] == $_SESSION['covid_app_user_id']){
	      				echo '<div class="card">
							  <div class="row">
							  	<div class="col-md-10" style="line-height: 1.2;">
							  		<h4 style="padding-bottom: 0px;">'.($count + 1).'. '.$arr[$i]['req_name'].'</h4>
							    	<small style="padding-left: 10px;">'.$arr[$i]['req_phone'].' | </small>
							    	<small>'.$arr[$i]['req_email'].'</small><br>
							    	<small style="padding-left: 10px;">'.$arr[$i]['req_country'].', '.$arr[$i]['req_city'].' | </small>
							    	<small>'.$arr[$i]['req_age'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Occupation: </small><small>'.$arr[$i]['req_occupation'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Preferred Language: </small><small>'.$arr[$i]['req_language'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Preferred mode of counseling: </small><small>'.$arr[$i]['req_mode'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Preferred days of counseling: </small><small>'.$arr[$i]['req_days'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Preferred time of counseling: </small><small>'.$arr[$i]['req_time'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Counseling needed for: </small><small>'.$arr[$i]['req_for'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Counseling history: </small><small>'.$arr[$i]['req_history'].'</small><br>
							  	</div>
							  </div>
							</div>';

						$count++;
	      			}
	      		}

	      		if($count == 0){
	      			echo '<center><h3 style="color: grey;">You have no sessions</h3><center>';
	      		}
	      	?>

	      </div>




	      <!-- <div class="container" style="background: white; padding: 10px; margin-top: 160px;">
	      	<center><h1>New requests</h1></center>
	      	<div class="card">
			  <div class="row">
			  	<div class="col-md-10" style="line-height: 1.2;">
			  		<h4 style="padding-bottom: 0px;">1. Mohammed Sulaiman bakash</h4>
			    	<small style="padding-left: 10px;">+91 - 8660434512 | </small>
			    	<small>sulaimanbakash@gmail.com</small><br>
			    	<small style="padding-left: 10px;">India, Bengaluru | </small>
			    	<small><18 years</small><br>
			    	<small style="color: black; padding-left: 10px;">Occupation: </small><small>Software Engineer</small><br>
			    	<small style="color: black; padding-left: 10px;">Preferred Language: </small><small>English</small><br>
			    	<small style="color: black; padding-left: 10px;">Preferred mode of counseling: </small><small>Voice</small><br>
			    	<small style="color: black; padding-left: 10px;">Preferred days of counseling: </small><small>Monday, Thursday, Friday</small><br>
			    	<small style="color: black; padding-left: 10px;">Preferred time of counseling: </small><small>Morning</small><br>
			    	<small style="color: black; padding-left: 10px;">Counseling needed for: </small><small>Home quarantine</small><br>
			    	<small style="color: black; padding-left: 10px;">Counseling history: </small><small>No</small><br>
			  	</div>
			  	<div class="col-md-2" style="line-height: 1.2; margin-top: 5%;">
			  		<center><button class="btn btn-primary">Accept</button><br><br>
			  		<small>posted on: <br>10 August 2:00PM</small></center>
			  	</div>
			  </div>
			</div>

			<div class="card">
			  <div class="row">
			  	<div class="col-md-10" style="line-height: 1.2;">
			  		<h4 style="padding-bottom: 0px;">1. Mohammed Sulaiman bakash</h4>
			    	<small style="padding-left: 10px;">+91 - 8660434512 | </small>
			    	<small>sulaimanbakash@gmail.com</small><br>
			    	<small style="padding-left: 10px;">India, Bengaluru | </small>
			    	<small><18 years</small><br>
			    	<small style="color: black; padding-left: 10px;">Occupation: </small><small>Software Engineer</small><br>
			    	<small style="color: black; padding-left: 10px;">Preferred Language: </small><small>English</small><br>
			    	<small style="color: black; padding-left: 10px;">Preferred mode of counseling: </small><small>Voice</small><br>
			    	<small style="color: black; padding-left: 10px;">Preferred days of counseling: </small><small>Monday, Thursday, Friday</small><br>
			    	<small style="color: black; padding-left: 10px;">Preferred time of counseling: </small><small>Morning</small><br>
			    	<small style="color: black; padding-left: 10px;">Counseling needed for: </small><small>Home quarantine</small><br>
			    	<small style="color: black; padding-left: 10px;">Counseling history: </small><small>No</small><br>
			  	</div>
			  	<div class="col-md-2" style="line-height: 1.2; margin-top: 5%;">
			  		<center><button class="btn btn-primary">Accept</button><br><br>
			  		<small>posted on: <br>10 August 2:00PM</small></center>
			  	</div>
			  </div>
			</div>
	      </div> -->

	      <div class="container" style="background: white; padding: 10px; margin-top: 30px;">
	      	<center><h1>New Counselling requests</h1></center>
	      	
	      	<?
	      		$count = 0;

	      		for($i = 0; $i < sizeof($arr); $i++){
	      			if($arr[$i]['req_accepted'] == '0'){
	      				echo '<div class="card">
							  <div class="row">
							  	<div class="col-md-10" style="line-height: 1.2;">
							  		<h4 style="padding-bottom: 0px;">'.($count + 1).'. '.$arr[$i]['req_name'].'</h4>
							    	<small style="padding-left: 10px;">'.$arr[$i]['req_phone'].' | </small>
							    	<small>'.$arr[$i]['req_email'].'</small><br>
							    	<small style="padding-left: 10px;">'.$arr[$i]['req_country'].', '.$arr[$i]['req_city'].' | </small>
							    	<small>'.$arr[$i]['req_age'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Occupation: </small><small>'.$arr[$i]['req_occupation'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Preferred Language: </small><small>'.$arr[$i]['req_language'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Preferred mode of counseling: </small><small>'.$arr[$i]['req_mode'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Preferred days of counseling: </small><small>'.$arr[$i]['req_days'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Preferred time of counseling: </small><small>'.$arr[$i]['req_time'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Counseling needed for: </small><small>'.$arr[$i]['req_for'].'</small><br>
							    	<small style="color: black; padding-left: 10px;">Counseling history: </small><small>'.$arr[$i]['req_history'].'</small><br>
							  	</div>
							  	<div class="col-md-2" style="line-height: 1.2; margin-top: 5%;">
							  		<center><button class="btn btn-primary" onclick="acceptRequest(this, '.$arr[$i]['req_id'].', '.$arr[$i]['req_phone'].')">Accept</button><br><br>
							  		<small>posted on: <br>'.date_format(date_create($arr[$i]['req_date']),"d F Y h:i A").'</small></center>
							  	</div>
							  </div>
							</div>';

						$count++;
	      			}
	      		}

	      		if($count == 0){
	      			echo '<center><h3 style="color: grey;">No new counseling requests</h3><center>';
	      		}
	      	?>
			
	      </div>

	    
   
        <!-- all plugins -->
        <script src="../js/custom.js"></script>

	    <script type="text/javascript">

	      	function acceptRequest(ele, id, phone){

	      		$.ajax({
	      			url: '../backend/index.php',
	      			method: 'post',
	      			data: {
	      				accept_counseling_request: 1,
	      				req_id: id,
	      				phone: phone
	      			},
	      			beforeSend: function(){
	      				$(ele).html('<img src="../images/white-loader.gif" style="height: 16px"> Please wait...').attr('disabled', 'disabled');
	      			},
	      			success: function(data){
	      				$(ele).html('Accept').removeAttr('disabled');

	      				data = JSON.parse(data);

	      				if(data.response == 'success'){
	      					window.location.reload();
	      				}
	      				else{
	      					$(ele).parent().append('<small style="display: block; color: black;">Something went wrong</small>');
	      				}
	      			},
	      			error: function(data){
	      				$(ele).html('Accept').removeAttr('disabled');
	      				$(ele).parent().append('<small style="display: block; color: black;">Something went wrong</small>');
	      			}
	      		})
	      	}

	    </script>

	    </body>
	</html>
