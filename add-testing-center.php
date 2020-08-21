<?php

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
	$redirect = (isset($_GET['id'])?'redirect=add-testing-center.php?id='.$_GET['id']:'redirect=add-testing-center.php');
	header("Location: login.php?".$redirect);
}

if(isset($_GET['id'])){
	require_once('backend/dbconfig.php');

	$query = "select * from testing_centers where tc_id=?";

	if($stmt = $con->prepare($query)){
		$stmt->bind_param("s",$_GET['id']);

		if($stmt->execute()){
			$result = $stmt->get_result();

			if(mysqli_num_rows($result) == 1){
				$row = $result->fetch_assoc();

				$attr = json_decode($row['tc_attr'],true);
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

    <title>Add testing center</title>

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
    		<a style="color: white; padding-right: 20px;" href="admin-home.php">HOME</a>
    		<p id="logout_btn" style="color: white;" onclick="logout()">Logout</p>
    	</div>
    </div>

    <div class="main" style="margin: auto; width: 50%;">
    	<div class="main-inner" style="width: 80%; margin-top: 20px; padding: 10px; border: solid 1px lightgrey; border-radius: 10px; background-color: white; box-shadow: 2px 2px lightgrey;">
    		<h4 style="text-align: center">Testing center details</h4>

    		<hr>

    		<form id="hospital_form">
			  <div class="form-group">
			    <label for="name">Name</label>
			    <input type="text" class="form-control" id="name" placeholder="Name of testing center" value="<?php if(isset($_GET['id'])) echo $row['tc_name']; ?>"  required>
			  </div>
			  <div class="form-group">
			    <label for="phone">Phone numbers</label>
			    <input type="text" class="form-control" id="phone" placeholder="Phone numbers of testing center" value="<?php if(isset($_GET['id'])) echo $row['tc_phone']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="addr">Address</label>
			    <textarea id="addr" class="form-control" placeholder="Address of testing center"><?php if(isset($_GET['id'])) echo $row['tc_addr']; ?></textarea>
			  </div>
			  <div class="form-group">
			    <label for="cost">Approx cost</label>
			    <input id="cost" type="text" class="form-control" placeholder="Approx cost of test" value="<?php if(isset($_GET['id'])) echo $row['tc_cost']; ?>">
			  </div>
			  <div class="form-group">
			    <label for="types">Types of tests</label>
			    <input id="types" type="text" class="form-control" placeholder="Eg:- PCR, ELISA" value="<?php if(isset($_GET['id'])) echo $row['tc_types']; ?>">
			  </div>
              <div class="form-group">
                <label for="wait_time">Wait time</label>
                <input id="wait_time" type="text" class="form-control" placeholder="Wait time for result" value="<?php if(isset($_GET['id'])) echo $row['tc_wait_time']; ?>">
              </div>
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
			  <center><button id="submit_btn" class="btn btn-primary" type="submit"><? if($_GET['id']) echo "Update"; else echo "Submit";?></button></center>
			</form>
    	</div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script type="text/javascript">

    let attr = <? echo sizeof($attr);?>;
    let tc_id = <? if($_GET['id']) echo $_GET['id']; else echo -1;?>

    console.log(tc_id);

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
    		let cost = $("#cost").val();
    		let types = $("#types").val();
            let wait_time = $("#wait_time").val();
    		
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
    			cost: cost,
    			types: types,
                wait_time: wait_time,
    			attr: JSON.stringify(arr)
    		};

    		if($("#submit_btn").html() == "Update"){
    			data1['update_tc'] = 1;
    			data1['tc_id'] = tc_id;

                console.log('update');
    		}
    		else{
    			data1['add_tc'] = 1;
                console.log('add');
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
                        window.location.href = 'testing-center.php';
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