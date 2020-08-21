<?php

require_once('backend/dbconfig.php');

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
	header("Location: login.php?redirect=bangalore-stats.php");
}

$query = "select * from blr_daily_stats where stat_date in (select max(stat_date) from blr_daily_stats);";

if($stmt = $con->prepare($query)){
    if($stmt->execute()){
        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0){
            $arr = array();

            while($row = $result->fetch_assoc()){
                $arr[$row['stat_ward_id']] = array("cases" => $row['stat_cases'], "date" => $row['stat_date'], "ward" => $row['stat_ward_name']);
                $d = $row['stat_date'];
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

    <script src="https://d3js.org/d3.v2.min.js?2.10.0"></script>

    <title>Bangalore Stats</title>

    <style type="text/css">

        @media only screen and (max-width: 600px){
            #map_div{
                padding-right: 0px; 
            }

            #ward_list{
                padding-right: 0px; 
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
    	<h3 style="text-align: center; margin-top: 10px;">Bangalore Stats</h3>

    	<div id="main_inner" class="row" style="margin-top: 20px;">
    		
            <div class="container">
                <form id="cases_form" class="form-inline">
                  <label class="sr-only" for="ward">Ward</label>
                  <select id="ward_sel" class="form-control mb-2 mr-sm-2">
                      <option>Ward name</option>
                  </select>

                  <label class="sr-only" for="cases">Cases</label>
                  <div class="input-group mb-2 mr-sm-2">
                    <input type="text" class="form-control" id="cases" placeholder="Cases" required>
                  </div>

                  <label class="sr-only" for="date">Date</label>
                  <div class="input-group mb-2 mr-sm-2">
                    <input type="date" class="form-control" id="date" placeholder="Date" required>
                  </div>

                  <button id="submitBtn" type="submit" class="btn btn-primary mb-2">Submit</button>
                </form>
            </div>
    	</div>
    </div>

    <div class="row">
        <div id="map_div" class="col-md-6">
            <div style="float: right;">
                <small id="map_ward" style="color: grey;"></small>
                <small id="map_cases" style="color: grey;"></small>
            </div>
            <svg id="blr_map" width="100%" style="overflow: scroll;"></svg>
            <svg id="legends" width="100%" height="100px"></svg>
        </div>
         <div id="ward_list" class="col-md-6" style="margin-top: 20px; height: 500px; overflow: scroll;">
            <div style="width: 100%; display: flex; justify-content: space-between;">
                <p style="font-size: 24px;">Cases in 24 hours</p>
                <input type="date" style="" value="<? echo $d;?>">
            </div>

            <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                <div style="padding: 5px;">
                    <table class="table" style="background: white;">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Ward name</th>
                          <th scope="col">Cases</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?
                            $arr1 = $arr;
                            $i = 0;

                            foreach ($arr1 as $key => $value) {
                                echo '<tr>
                                        <td>'.$key.'</td>
                                        <td>'.$value['ward'].'</td>
                                        <td>'.$value['cases'].'</td>
                                      </tr>';

                                $i++;

                                unset($arr1[$key]);

                                if($i == (int)(sizeof($arr)/2) + 3){
                                    break;
                                }
                            }
                        ?>
                      </tbody>
                    </table>

                </div>

                <div style="padding: 10px 5px;">
                    <table class="table" style="background: white;">
                      <tbody>

                        <?

                            foreach ($arr1 as $key => $value) {
                                echo '<tr>
                                        <td>'.$key.'</td>
                                        <td>'.$value['ward'].'</td>
                                        <td>'.$value['cases'].'</td>
                                      </tr>';
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

    let stats = <? echo json_encode($arr);?>;

    var width = screen.width/2,
    height = 500;

    var svg = d3.select("#blr_map").attr("height", height);

    var xym = d3.geo.albers();
    var path = d3.geo.path().projection(xym);

    xym.origin([77.68, 12.67])
    xym.translate([350, 745])
    xym.parallels([24.6, 43.6])
    xym.scale(90000)

    if(screen.width < 600){
        xym.scale(70000)
        xym.origin([77.74, 12.56])
    }
    

    console.log(stats);

    d3.json("Bangalore.GeoJSON", function(data) {
        //console.log(data);

        let feat = data.features;

        let opt_htm = ``;

        for(var i = 0; i < feat.length; i++){
            let ward_name = feat[i].properties.WARD_NAME;
            let ward_num = feat[i].properties.WARD_NO;

            opt_htm += `<option value="${ward_num}">${ward_name}</option>`;

            if(stats[ward_num]){
                data.features[i].properties.CASES = stats['cases'];
            }
            else{
                data.features[i].properties.CASES = '3-10';
            }
        }

        $("#ward_sel").append(opt_htm);

        svg.selectAll("path")
        .data(data.features)
        .enter()
        .append("path")
        .attr("d", path)
        //.attr("fill", "none")
        .attr("stroke", "White")
        .attr("fill", "#157fda")
        .attr("stroke-width", 1)
        .attr("stroke-opacity", 0.5)
        .attr("class", "place")
        .style("fill", function(e) { 

            let c;

            if(stats[parseInt(e.properties.WARD_NO)] != undefined){
                c = stats[parseInt(e.properties.WARD_NO)].cases;
            }
            else{
                c = '3-10';
            }

            //let c = stats[parseInt(e.properties.WARD_NO)].cases;

            if(c == '0'){ 
                console.log('0: '+e.properties.WARD_NAME);
                return "rgba(21, 127, 218, 0.1)";
            }
            else if(c == '1-2'){
                console.log('1-2: '+e.properties.WARD_NAME);
                return "rgba(21, 127, 218, 0.2)";
            }
            else if(c == '3-10'){
                console.log('3-10: '+e.properties.WARD_NAME);
                return "rgba(21, 127, 218, 0.3)";
            }
            else if(c == '10-15'){
                console.log('10-15: '+e.properties.WARD_NAME);
                return "rgba(21, 127, 218, 0.5)";
            }
            else if(parseInt(c) > 15 && parseInt(c) < 50){
                console.log('15-50: '+e.properties.WARD_NAME);
                return "rgba(21, 127, 218, 0.7)";
            }
            else{
                console.log('>50: '+e.properties.WARD_NAME);
                return "rgba(21, 127, 218, 1)";
            }
        })
        .on("mouseover", function(e) {
            /*console.log(e);*/ 
            d3.select(this).style("fill", "#5522aa");

            $("#map_ward").html(e.properties.WARD_NAME);
            $("#map_cases").html(stats[parseInt(e.properties.WARD_NO)] ? stats[parseInt(e.properties.WARD_NO)].cases : '3-10');
        })
        .on("mouseout", function(e) {
            let c;
            let color;

            if(stats[parseInt(e.properties.WARD_NO)] != undefined){
                c = stats[parseInt(e.properties.WARD_NO)].cases;
            }
            else{
                c = '3-10';
            }

            if(c == '0'){ 
                color = "rgba(21, 127, 218, 0.1)";
            }
            else if(c == '1-2'){
                color = "rgba(21, 127, 218, 0.2)";
            }
            else if(c == '3-10'){
                color = "rgba(21, 127, 218, 0.3)";
            }
            else if(c == '10-15'){
                color = "rgba(21, 127, 218, 0.5)";
            }
            else if(c > 15 && c < 50){
                color = "rgba(21, 127, 218, 0.7)";
            }
            else{
                color = "rgba(21, 127, 218, 1)";
            }

            d3.select(this).style("fill", color);
        })

         var svg1 = d3.select("#legends");

        // Handmade legend
        svg1.append("circle").attr("cx",10).attr("cy",30).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.1)")
        svg1.append("circle").attr("cx",10).attr("cy",60).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.2)")
        svg1.append("circle").attr("cx",120).attr("cy",30).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.3)")
        svg1.append("circle").attr("cx",120).attr("cy",60).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.5)")
        svg1.append("circle").attr("cx",260).attr("cy",30).attr("r", 6).style("fill", "rgba(21, 127, 218, 0.7)")
        svg1.append("circle").attr("cx",260).attr("cy",60).attr("r", 6).style("fill", "rgba(21, 127, 218, 1)")
        svg1.append("text").attr("x", 20).attr("y", 30).text("No cases").style("font-size", "12px").attr("alignment-baseline","middle")
        svg1.append("text").attr("x", 20).attr("y", 60).text("1 - 2 cases").style("font-size", "12px").attr("alignment-baseline","middle")
        svg1.append("text").attr("x", 130).attr("y", 30).text("3 - 10 cases").style("font-size", "12px").attr("alignment-baseline","middle")
        svg1.append("text").attr("x", 130).attr("y", 60).text("10 - 15 cases").style("font-size", "12px").attr("alignment-baseline","middle")
        svg1.append("text").attr("x", 270).attr("y", 30).text("15 - 50 cases").style("font-size", "12px").attr("alignment-baseline","middle")
        svg1.append("text").attr("x", 270).attr("y", 60).text("more than 50 cases").style("font-size", "12px").attr("alignment-baseline","middle")

    })


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

        $("#ward_list").css({
            "height": $("#map_div").height,
            "overflow": "scroll"
        });

    	$("#cases_form").submit(function(e){
            e.preventDefault();

            let data1 = {
                add_blr_daily_stats: 1,
                ward_num: $("#ward_sel option:selected").val(),
                ward_name: $("#ward_sel option:selected").html(),
                cases: $("#cases").val(),
                date: $("#date").val()
            }

            console.log(data1);

            $.ajax({
                url: 'backend/index.php',
                method: 'post',
                data: data1,
                beforeSend: function() {
                    $("#submitBtn").html(`<div class="spinner-border text-white" role="status">
                                              <span class="sr-only">Loading...</span>
                                            </div>`).attr('disabled', 'true');
                },
                success: function(data){
                    alert(data);
                    $("#submitBtn").html('Submit').removeAttr('disabled');
                },
                error: function(data){
                    $("#submitBtn").html('Submit').removeAttr('disabled');
                }
            })
        });


    })
    </script>
  </body>
</html>