<?php

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
	header("Location: login.php?redirect=ambulance.php");
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

    <title>Ambulance details</title>

    <style type="text/css">

    	#logout_btn:hover{
    		cursor: pointer;
    	}

    	.nav-link{
    		color: white!important;
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
    	<h3 style="text-align: center; margin-top: 10px;">Ambulance Details</h3>

    	<div id="main_inner" class="row" style="margin-top: 20px;">
    		<div class="col-md-4"></div>
    		<div class="col-md-4">
    			<center>
    				<div style="margin-top: 30%; width: 3rem; height: 3rem;" class="spinner-border text-primary" role="status">
                    	<span class="sr-only">Loading...</span>
                	</div>
    			</center>
    		</div>
    		<!-- <div class="col-md-4">
    			<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Ambedkar medical college</h5>
				    <h6 class="card-subtitle mb-2 text-muted">+91-1122334455/ (+91)-08022345644</h6>
				    <p class="card-text">No.93 11th cross someswaranagar jayanagar 1st block</p>
				    <p class="card-text"><span style="font-weight: bold;">Beds available: </span>100</p>
				    <a href="#" class="card-link">Delete</a>
				    <a href="#" class="card-link">Update</a>
				  </div>
				</div>
    		</div>

    		<div class="col-md-4">
    			<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Card title</h5>
				    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				    <a href="#" class="card-link">Card link</a>
				    <a href="#" class="card-link">Another link</a>
				  </div>
				</div>
    		</div>

    		<div class="col-md-4">
    			<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Card title</h5>
				    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				    <a href="#" class="card-link">Card link</a>
				    <a href="#" class="card-link">Another link</a>
				  </div>
				</div>
    		</div> -->
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

    function getAmbulanceList(){
    	$.ajax({
    		url: 'backend/index.php',
    		method: 'post',
    		data: {
    			get_ambulance_list: 1
    		},
    		success: function(data) {
    			//alert(data);

    			data = JSON.parse(data);

    			if(data.response == "success"){
    				displayAmbulanceList(data.payload);
    			}
    		},
    		error: function() {

    		}
    	})
    }

    function displayAmbulanceList(list){
    	let htm = ``;

    	for(var i = 0; i < list.length; i++){
    		htm += `<div id="hosp_div${list[i]['ambulance_id']}" class="col-md-4" style="margin-top: 10px;">
    			<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">${list[i].ambulance_provider}</h5>
				    <h6 class="card-subtitle mb-2 text-muted">${list[i].ambulance_phone}</h6>
				    <p class="card-text"><span style="font-weight: bold;">Number of ambulance: </span>${list[i].ambulance_qty}</p>
				    <p class="card-text"><span style="font-weight: bold;">Approx cost: </span>${list[i].ambulance_cost}</p>
                    <p class="card-text"><span style="font-weight: bold;">Types of ambulance: </span>${list[i].ambulance_types}</p>
				    <p class="card-text"><span style="font-weight: bold;">Last updated: </span>${list[i].last_update}</p>`;

			let attr = JSON.parse(list[i].ambulance_attr);

			for(var j = 0; j < attr.length; j++){
				htm += `<p class="card-text"><span style="font-weight: bold;">${attr[j].key}: </span>${attr[j].value}</p>`;
			}

			htm += `<a href="#" class="card-link" onclick="deleteAmbulance(${list[i].ambulance_id})">Delete</a>
				    <a href="add-ambulance.php?id=${list[i].ambulance_id}" class="card-link">Update</a>
				  </div>
				</div>
    		</div>`;
    	}

    	$("#main_inner").html(htm);

    }

    function deleteAmbulance(id){
    	var res = confirm('Are you sure you want to delete the ambulance details?');

    	if(res){
    		$.ajax({
    			url: 'backend/index.php',
    			method: 'post',
    			data: {
    				delete_ambulance: 1,
    				amb_id: id
    			},
    			success: function(data) {
    				//alert(data);

    				data = JSON.parse(data);

    				if(data.response == "success"){
    					$("#hosp_div"+id).remove();
    				}
    			},
    			error: function(data) {
    				alert('Something went wrong');
    			}
    		})
    	}
    }

    $(document).ready(function() {
    	getAmbulanceList();
    })
    </script>
  </body>
</html>