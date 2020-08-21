<?php session_start();

    $arr = $_SESSION['hospitals_array'];
?>

         
         let hosp_list = <?php echo json_encode($arr); ?>;
    
         $(document).ready(function() {

            scroll = false;

            $("#searchDiv").click(function(){
               $('html, body').animate({
                  scrollTop: $("#stats").offset().top
               }, 1000, function() {
                  $("#searchInput").focus();
              });
            })

            $("#searchInput").on('input', function(){
               let val = $(this).val();


                  let htm = ``;

                  for(var i = 0; i < hosp_list.length; i++){
                     if(hosp_list[i]['hospital_name'].toLowerCase().search(val.toLowerCase()) != -1 || hosp_list[i]['hospital_address'].toLowerCase().search(val.toLowerCase()) != -1){
                        if(screen.width <= 600){
                           htm += `<tr>
                                 <th scope="row">` + (i+1) + `</th>
                                 <td><a style="font-weight: bold" href="http://maps.google.com/?q=${hosp_list[i]['hospital_name']}" target="_blank">${hosp_list[i]['hospital_name']}</a><br><span style="color: lightgrey;">Beds Status: </span>
                                  `+(hosp_list[i]['hospital_vacant_beds'] == 'Full' ? '<span class="badge badge-danger">Full</span>' : hosp_list[i]['hospital_vacant_beds'] == 'Available' ? '<span class="badge badge-success">Available</span>' : '<span class="badge">Unknown</span>')+`
                                 `+ hosp_list[i]['phone'] +`<br>
                                 <a href="http://maps.google.com/?q=${hosp_list[i]['hospital_name']}" target="_blank">${hosp_list[i]['hospital_address']}</a><br><span style="color: lightgrey;">Last checked on:</span><br>
                                 `+hosp_list[i]['last_update']+`</td>
                               </tr>`;
                        }
                        else{
                           htm += `<tr>
                                 <th scope="row">` + (i+1) + `</th>
                                 <td><a href="http://maps.google.com/?q=${hosp_list[i]['hospital_name']}" target="_blank">${hosp_list[i]['hospital_name']}</a></td>
                                  <td><center>`+(hosp_list[i]['hospital_vacant_beds'] == 'Full' ? '<span class="badge badge-danger">Full</span>' : hosp_list[i]['hospital_vacant_beds'] == 'Available' ? '<span class="badge badge-success">Available</span>' : '<span class="badge">Unknown</span>')+`</center></td>
                                 <td>`+ hosp_list[i]['phone'] +`</td>
                                 <td><a href="http://maps.google.com/?q=${hosp_list[i]['hospital_name']}" target="_blank">${hosp_list[i]['hospital_address']}</a></td>
                                 <td>`+hosp_list[i]['last_update']+`</td>
                               </tr>`;
                        }
                     }
                  }

                  $("#hospTable tbody").html(htm);
            });
         })

         let scrollPos = 0

         function scrollRight() {
            $(".table-responsive").animate({
               scrollLeft: scrollPos + 200
            }, 800);

            scrollPos += 200;
         }

