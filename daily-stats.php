<?php

require_once('backend/dbconfig.php');

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
	header("Location: login.php?redirect=daily-stats.php");
}

$query = "select * from covid_stats;";

if($stmt = $con->prepare($query)){
    if($stmt->execute()){
        $result = $stmt->get_result();

        $arr = array();

        while($row = $result->fetch_assoc()){
            $arr[$row['stat_key']] = $row['stat_value'];

            if($row['stat_key'] == 'bengaluru-today'){
                $arr['bg-update'] = $row['stat_last_update'];
            } 

            if($row['stat_key'] == 'karnataka-today'){
                $arr['ka-update'] = $row['stat_last_update'];
            } 

            if($row['stat_key'] == 'india-today'){
                $arr['in-update'] = $row['stat_last_update'];
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

    <title>Covid Stats</title>

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
    		<a style="color: white; padding-right: 20px;" href="data-entry.php">Add Hospital</a>
    		<p id="logout_btn" style="color: white;" onclick="logout()">Logout</p>
    	</div>
    </div>

    <div class="container-fluid">
    	<h3 style="text-align: center; margin-top: 10px;">Covid Stats</h3>

    	<div id="main_inner" class="row" style="margin-top: 20px;">
    		<!-- <div class="col-md-4"></div>
    		<div class="col-md-4">
    			<center>
    				<div style="margin-top: 30%; width: 3rem; height: 3rem;" class="spinner-border text-primary" role="status">
                    	<span class="sr-only">Loading...</span>
                	</div>
    			</center>
    		</div> -->
    		<div class="col-md-4">
    			<div class="card">
				  <div class="card-body">
				    <h5 class="card-title" style="text-align: center;">Bengaluru</h5>
				    <h6 class="card-subtitle mb-2 text-muted" style="text-align: center;">Last updated 
                      <?php
                        $date=date_create($arr['bg-update']);

                        echo date_format($date,"d F Y h:i A");
                      ?>
                    </h6>
				    <form id="bg-form" class="stat-form">
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Cases Today:</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="bg_today" value="<?php echo $arr['bengaluru-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total active cases:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="bg_tot_active" value="<?php echo $arr['bengaluru-active']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Discharges Today:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="bg_dis_today" value="<?php echo $arr['bengaluru-discharges-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total discharges:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="bg_dis_tot" value="<?php echo $arr['bengaluru-discharges-total']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Deaths Today:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="bg_deaths_today" value="<?php echo $arr['bengaluru-deaths-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total deaths:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="bg_deaths_tot" value="<?php echo $arr['bengaluru-deaths-total']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Total cases:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="bg_tot" value="<?php echo $arr['bengaluru-total']; ?>">
                        </div>
                      </div>
                      <center><button type="submit" class="btn btn-primary">Update</button></center>
                    </form>
				  </div>
				</div>
    		</div>

    		<div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">Karnataka</h5>
                    <h6 class="card-subtitle mb-2 text-muted" style="text-align: center;">Last updated 
                      <?php
                        $date=date_create($arr['ka-update']);

                        echo date_format($date,"d F Y h:i A");
                      ?>
                    </h6>
                    <form id="ka-form" class="stat-form">
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Cases Today:</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="ka_today" value="<?php echo $arr['karnataka-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total active cases:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="ka_tot_active" value="<?php echo $arr['karnataka-active']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Discharges Today:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="ka_dis_today" value="<?php echo $arr['karnataka-discharges-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total discharges:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="ka_dis_tot" value="<?php echo $arr['karnataka-discharges-total']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Deaths Today:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="ka_deaths_today" value="<?php echo $arr['karnataka-deaths-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total deaths:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="ka_deaths_tot" value="<?php echo $arr['karnataka-deaths-total']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Total cases:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="ka_tot" value="<?php echo $arr['karnataka-total']; ?>">
                        </div>
                      </div>
                      <center><button type="submit" class="btn btn-primary">Update</button></center>
                    </form>
                  </div>
                </div>
            </div>

    		<div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">India</h5>
                    <h6 class="card-subtitle mb-2 text-muted" style="text-align: center;">Last updated 
                      <?php
                        $date=date_create($arr['in-update']);

                        echo date_format($date,"d F Y h:i A");
                      ?>
                    </h6>
                    <form id="in-form" class="stat-form">
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Cases Today:</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="in_today" value="<?php echo $arr['india-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total active cases:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="in_tot_active" value="<?php echo $arr['india-active']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Discharges Today:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="in_dis_today" value="<?php echo $arr['india-discharges-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total discharges:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="in_dis_tot" value="<?php echo $arr['india-discharges-total']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Deaths Today:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="in_deaths_today" value="<?php echo $arr['india-deaths-today']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-6 col-form-label">Total deaths:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="in_deaths_tot" value="<?php echo $arr['india-deaths-total']; ?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-6 col-form-label">Total cases:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="in_tot" value="<?php echo $arr['india-total']; ?>">
                        </div>
                      </div>
                      <center><button type="submit" class="btn btn-primary">Update</button></center>
                    </form>
                  </div>
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


    $(document).ready(function() {
    	$(".stat-form").submit(function(e){
            e.preventDefault();

            console.log(e.target.id);

            const inputs = $("#"+e.target.id+" input");

            let data1 = {
                update_stats: 1,
                type: e.target.id == 'bg-form' ? 'bengaluru' : e.target.id == 'ka-form' ? 'karnataka' : 'india',
                today: inputs.eq(0).val(),
                active: inputs.eq(1).val(),
                discharges_today: inputs.eq(2).val(),
                discharges_total: inputs.eq(3).val(),
                deaths_today: inputs.eq(4).val(),
                deaths_total: inputs.eq(5).val(),
                total: inputs.eq(6).val()
            };

            //console.log(data1);

            $.ajax({
                url: 'backend/index.php',
                method: 'post',
                data: data1,
                beforeSend: function() {
                    $("#"+e.target.id+" button").html(`<div class="spinner-border text-white" role="status">
                                              <span class="sr-only">Loading...</span>
                                            </div>`).attr("disabled", "true");
                },
                success: function(data) {
                    $("#"+e.target.id+" button").html(`Update`).removeAttr("disabled");

                    console.log(data);
                },
                error: function(data) {
                    $("#"+e.target.id+" button").html(`Update`).removeAttr("disabled");
                }
            })

        })
    })
    </script>
  </body>
</html>