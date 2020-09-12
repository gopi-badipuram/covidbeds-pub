<?php

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
	$redirect = (isset($_GET['id'])?'redirect=data-entry.php?id='.$_GET['id']:'redirect=data-entry.php');
	header("Location: login.php?".$redirect);
}

if(isset($_GET['id'])){
	require_once('backend/dbconfig.php');

	$query = "select * from hospital_details where hospital_id=?";

	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$_GET['id']);

		if($stmt->execute()){
			$result = $stmt->get_result();

			if(mysqli_num_rows($result) == 1){
				$row = $result->fetch_assoc();

				$attr = json_decode($row['hospital_attr'],true);
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

    <title>Data entry page</title>

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
    		<p style="color: white; padding-right: 20px;">HOME</p>
    		<p id="logout_btn" style="color: white;" onclick="logout()">Logout</p>
    	</div>
    </div>

    <div class="main" style="margin: auto; width: 50%;">
    	<div class="main-inner" style="width: 80%; margin-top: 20px; padding: 10px; border: solid 1px lightgrey; border-radius: 10px; background-color: white; box-shadow: 2px 2px lightgrey;">
    		<h4 style="text-align: center">Hospital details</h4>

    		<hr>

    		<form id="hospital_form">
			  <div class="form-group">
			    <label for="name">Hospital name</label>
			    <input type="text" class="form-control" id="name" placeholder="Name of hospital" value="<?php if(isset($_GET['id'])) echo $row['hospital_name']; ?>"  required>
			  </div>
			  <div class="form-group">
			    <label for="phone">Hospital Phone</label>
			    <input type="text" class="form-control" id="phone" placeholder="Phone number of hospital" value="<?php if(isset($_GET['id'])) echo $row['hospital_phone']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="addr">Hospital Address</label>
			    <textarea id="addr" class="form-control" placeholder="Address of Hospital"><?php if(isset($_GET['id'])) echo $row['hospital_address']; ?></textarea>
			  </div>
			  <hr style="background:green;height:5px"/>
			  <p style="color:blue;size:medium;"> You can fill the general beds availability in these fields or fill detailed (private vs government, ic, hdu, ventilators) beds availability further below. If detailed beds availablity is provided, these general availability fields will be ignored.</p>
			  <div class="form-group">
			    <label for="beds">Beds allotted</label>
			    <input id="beds" type="number" class="form-control" placeholder="Number of beds allotted" value="<?php if(isset($_GET['id'])) echo $row['hospital_alloted_beds']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="vacant">Beds vacant</label>
			    <input id="vacant" type="text" class="form-control" placeholder="Number of beds vacant" value="<?php if(isset($_GET['id'])) echo $row['hospital_vacant_beds']; ?>">
			  </div>
			  <hr style="background:green;height:5px"/>
			  <p style="color:blue;size:medium;"> You can fill detailed (private vs government, ic, hdu, ventilators) beds availability in these fields. If detailed beds availablity is provided, the general availability fields filled above will be ignored.</p>
			  <div class="form-group">
			    <label for="detailed_general">Govt - General beds available</label>
			    <input id="detailed_general" type="number" class="form-control" placeholder="Number of general beds available under Govt quota" value="<?php if(isset($_GET['id'])) echo $row['detailed_general']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="detailed_hdu">Govt - HDU beds available</label>
			    <input id="detailed_hdu" type="text" class="form-control" placeholder="Number of HDU beds available under Govt quota" value="<?php if(isset($_GET['id'])) echo $row['detailed_hdu']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="detailed_icu">Govt - ICU beds available</label>
			    <input id="detailed_icu" type="text" class="form-control" placeholder="Number of ICU beds available under Govt quota" value="<?php if(isset($_GET['id'])) echo $row['detailed_icu']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="detailed_vent">Govt - ventilator beds available</label>
			    <input id="detailed_vent" type="text" class="form-control" placeholder="Number of beds with ventilators available under Govt quota" value="<?php if(isset($_GET['id'])) echo $row['detailed_vent']; ?>">
			  </div>
			  
			  <hr style="background:green;height:2px"/>
			  <label>Other attributes <span class="ion-plus-circled text-primary" onclick="addAttr()"></span></label>
			  <div id="form_inner">
			  	<?php
			  		if(sizeof($attr) > 0){
			  			for($i = 0; $i < sizeof($attr); $i++){
			  				echo '<div id="form_div'.($i+1).'" class="form-row">
								    <div class="form-group col-md-6">
								      <label>Attribute name &nbsp;
								      	<span class="ion-close-circled" style="color: grey;" onclick="deleteAttr('.($i+1).')"></span>
								      </label>
								      <input type="text" class="form-control" placeholder="Eg:- Number of beds available" value="'.$attr[$i]['key'].'" required>
								    </div>
								    <div class="form-group col-md-6">
								      <label>Attribute value</label>
								      <input type="text" class="form-control" placeholder="Eg:- Value of number of beds like 100" value="'.$attr[$i]['value'].'" required>
								    </div>
								  </div>';
			  			}
			  		}
			  	?>
			  </div>
			  <div class="form-group">
			    <label for="last_updated">Last updated</label>
			    <input id="last_updated" type="datetime-local" class="form-control" placeholder="Last updated" value="<?echo substr(date_format(date_create($row['last_update']), DATE_ISO8601), 0, 19);?>">
			  </div>
			  <center><button id="submit_btn" class="btn btn-primary" type="submit"><?php if($_GET['id']) echo "Update"; else echo "Submit";?></button></center>
			</form>
    	</div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script type="text/javascript">

    let attr = <?php echo sizeof($attr);?>;
    let hosp_id = <?php if($_GET['id']) echo $_GET['id']; else echo -1;?>

    function addAttr(){
    	$("#form_inner").append(`<div id="form_div${++attr}" class="form-row">
			    <div class="form-group col-md-6">
			      <label>Attribute name &nbsp;
			      	<span class="ion-close-circled" style="color: grey;" onclick="deleteAttr(${attr})"></span>
			      </label>
			      <input type="text" class="form-control" placeholder="Eg:- Number of beds available" required>
			    </div>
			    <div class="form-group col-md-6">
			      <label>Attribute value</label>
			      <input type="text" class="form-control" placeholder="Eg:- Value of number of beds like 100" required>
			    </div>
			  </div>`);

    }

    function deleteAttr(id){
    	$("#form_div"+id).remove();

    	for(var i = id + 1; i <= attr; i++){
    		$("#form_div"+i).attr('id', 'form_div' + (i - 1));
    		$("#form_div"+(i-1)+" .ion-close-circled").attr('onclick', 'deleteAttr('+(i-1)+')');
    	}

    	attr--;
    }

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

    $(document).ready(function() {
    	$("#hospital_form").submit(function(e){
    		e.preventDefault();

    		let name = $("#name").val();
    		let phone = $("#phone").val();
    		let addr = $("#addr").val();
    		let beds = $("#beds").val();
    		let vacant = $("#vacant").val();
    		let last_updated = $("#last_updated").val();
    		
    		let detailed_general = $("#detailed_general").val();
    		let detailed_hdu = $("#detailed_hdu").val();
    		let detailed_icu = $("#detailed_icu").val();
    		let detailed_vent = $("#detailed_vent").val();
    		
    		let arr = [];

    		for(var i = 1; i <= attr; i++){
    			if($("#form_div"+i+" input").eq(0).val() != "" && $("#form_div"+i+" input").eq(1).val() != ""){
    				arr.push({
    					key: $("#form_div"+i+" input").eq(0).val(),
    					value: $("#form_div"+i+" input").eq(1).val()
    				});
    			}
    		}

    		//console.log(arr);

    		let data1 = {
    			name: name,
    			phone: phone,
    			addr: addr,
    			beds: beds,
    			vacant: vacant,
    			last_updated: last_updated,
    			detailed_general: detailed_general,
    			detailed_hdu: detailed_hdu,
    			detailed_icu: detailed_icu,
    			detailed_vent: detailed_vent,
    			attr: JSON.stringify(arr)
    		};

    		if($("#submit_btn").html() == "Update"){
    			data1['update_hospital'] = 1;
    			data1['hosp_id'] = hosp_id;
    		}
    		else{
    			data1['add_hospital'] = 1;
    		}

    		console.log(data1);

    		$.ajax({
    			url: 'backend/index.php',
    			method: 'post',
    			data: data1,
    			beforeSend: function() {
    				$("#submit_btn").html(`<div class="spinner-border text-white" role="status">
                                              <span class="sr-only">Loading...</span>
                                            </div>`).attr('disabled', 'true');
    			},
    			success: function(data) {
    				$("#submit_btn").html('Submit').removeAttr('disabled');

                    data = JSON.parse(data);

                    if(data.response == 'success'){
                        window.location.href = 'admin-home.php';
                    }
                    else{
                        alert('Something went wrong');
                    }
    			},
    			error: function(data) {
    				$("#submit_btn").html('Submit').removeAttr('disabled');
    			}
    		})
    	})
    	
    })
    </script>
  </body>
</html>
