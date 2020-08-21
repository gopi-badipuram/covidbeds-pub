<?php

require_once('../backend/dbconfig.php');

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
	header("Location: ../login.php?redirect=blog/blog-list.php");
}

$query = "select * from blog order by blog_date desc";

if($stmt = $con->prepare($query)){
    if($stmt->execute()){
        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0){
            $arr = array();

            while($row = $result->fetch_assoc()){
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

    <title>Blog list</title>

    <style type="text/css">

    	#logout_btn:hover{
    		cursor: pointer;
    	}

    	.nav-link{
    		color: white!important;
    	}

        .card-text {
           overflow: hidden;
           text-overflow: ellipsis;
           display: -webkit-box;
           -webkit-line-clamp: 3; /* number of lines to show */
           -webkit-box-orient: vertical;
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
    		<a style="color: white; padding-right: 20px;" href="../admin-home.php">Home</a>
            <a style="color: white; padding-right: 20px;" href="../add-article.php">Add Article</a>
    		<p id="logout_btn" style="color: white;" onclick="logout()">Logout</p>
    	</div>
    </div>


    <div class="container-fluid">
    	<h3 style="text-align: center; margin-top: 10px;">Blog List</h3>

    	<div id="main_inner" class="row" style="margin-top: 20px;">
    		
            <div class="container">
                <div class="row">

                    <? 
                        for($i = 0; $i < sizeof($arr); $i++){
                            echo '<div class="col-md-4">
                                    <div class="card">
                                      <img src="'.$arr[$i]['blog_img'].'" class="card-img-top" alt="...">
                                      <div class="card-body">
                                        <h5 class="card-title"><a href="'.$arr[$i]['blog_slug'].'.php">'.$arr[$i]['blog_title'].'</a></h5>
                                        <h6 class="card-subtitle mb-2 text-muted">2 July 2:30PM</h6>
                                        <p class="card-text">'.strip_tags($arr[$i]['blog_content']).'</p>
                                        <a href="../add-article.php?id='.$arr[$i]['blog_id'].'" class="card-link">Edit</a>
                                        <a href="#" class="card-link">Delete</a>
                                      </div>
                                    </div>
                                </div>';
                        }
                    ?>

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

    function getHospitalList(){
    	$.ajax({
    		url: 'backend/index.php',
    		method: 'post',
    		data: {
    			get_hospitals: 1
    		},
    		success: function(data) {
    			//alert(data);

    			data = JSON.parse(data);

    			if(data.response == "success"){
    				displayHospitalList(data.payload);
    			}
    		},
    		error: function() {

    		}
    	})
    }

    function displayHospitalList(list){
    	let htm = ``;

    	for(var i = 0; i < list.length; i++){
    		htm += `<div id="hosp_div${list[i]['hospital_id']}" class="col-md-4" style="margin-top: 10px;">
    			<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">${list[i].hospital_name}</h5>
				    <h6 class="card-subtitle mb-2 text-muted">${list[i].hospital_phone}</h6>
				    <p class="card-text">${list[i].hospital_address}</p>
				    <p class="card-text"><span style="font-weight: bold;">Total Beds: </span>${list[i].hospital_alloted_beds}</p>
				    <p class="card-text"><span style="font-weight: bold;">Beds available: </span>${list[i].hospital_vacant_beds}</p>
				    <p class="card-text"><span style="font-weight: bold;">Last updated: </span>${list[i].last_update}</p>`;

			let attr = JSON.parse(list[i].hospital_attr);

			for(var j = 0; j < attr.length; j++){
				htm += `<p class="card-text"><span style="font-weight: bold;">${attr[j].key}: </span>${attr[j].value}</p>`;
			}

			htm += `<a href="#" class="card-link" onclick="deleteHospital(${list[i].hospital_id})">Delete</a>
				    <a href="data-entry.php?id=${list[i].hospital_id}" class="card-link">Update</a>
				  </div>
				</div>
    		</div>`;
    	}

    	$("#main_inner").html(htm);

    }

    function deleteHospital(id){
    	var res = confirm('Are you sure you want to delete the hospital details?');

    	if(res){
    		$.ajax({
    			url: 'backend/index.php',
    			method: 'post',
    			data: {
    				delete_hospital: 1,
    				hosp_id: id
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
    	//getHospitalList();
    })
    </script>
  </body>
</html>