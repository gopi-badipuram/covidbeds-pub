<?php session_start();

    $tc_arr = $_SESSION['test_center_list'];
?>

         
         let test_center_list = <?php echo json_encode($tc_arr); ?>;

         $(document).ready(function() {

            scroll = false;

            console.log(test_center_list);
            
            $("#searchDiv").click(function(){
               $('html, body').animate({
                  scrollTop: $("#test_centers").offset().top
               }, 1000, function() {
                  $("#searchInput").focus();
              });
            })

            $("#searchInput").on('input', function(){
                  let val = $(this).val();


                  let htm = ``;

                  for(var i = 0; i < test_center_list.length; i++){
                     if(test_center_list[i]['tc_name'].toLowerCase().search(val.toLowerCase()) != -1 || 
                     test_center_list[i]['tc_addr'].toLowerCase().search(val.toLowerCase()) != -1 ||
                     test_center_list[i]['tc_types'].toLowerCase().search(val.toLowerCase()) != -1 ||
                     test_center_list[i]['tc_phone'].search(val.toLowerCase()) != -1){
                        if(screen.width <= 600){
                           htm += `<tr>
                                 <th scope="row">` + (i+1) + `</th>
                                 <td><a style="font-weight: bold" href="http://maps.google.com/?q=${test_center_list[i]['tc_name']}" target="_blank">${test_center_list[i]['tc_name']}</a><br>
                                 `+ test_center_list[i]['phone'] +`<br><span style="color: grey; font-weight: bold;">Cost: </span><span style="color: black; font-size: 12px; font-weight: bold;">'.$tc_arr[$i]['tc_cost'].'</span><br>
                                       <span style="color: grey; font-weight: bold;">Result in: </span><span style="color: black; text-align: center;">'.$tc_arr[$i]['tc_wait_time'].'</span><br>
                                       <span style="color: grey; font-weight: bold;">Types of test: </span><span style="color: black; text-align: center;">'.$tc_arr[$i]['tc_types'].'</span><br>
                                       <a href="http://maps.google.com/?q='.$tc_arr[$i]['tc_name'].'" target="_blank">'.$tc_arr[$i]['tc_addr'].'</a></td>` +
                               `</tr>`;
                        }
                        else{
                           htm += `<tr>
                                 <th scope="row">` + (i+1) + `</th>
                                 <td><a href="http://maps.google.com/?q=${test_center_list[i]['tc_name']}" target="_blank">${test_center_list[i]['tc_name']}</a></td>
                                 <td>`+ test_center_list[i]['phone'] +
                                 `</td><td style="color: black; font-size: 12px; font-weight: bold; text-align: center;">` + test_center_list[i]['tc_cost'] + `</td>
                                       <td style="color: black; text-align: center;">` + test_center_list[i]['tc_wait_time'] + `</td>
                                       <td style="color: black; text-align: center;">` + test_center_list[i]['tc_types'] + `</td>
                                       <td><a href="http://maps.google.com/?q=${test_center_list[i]['tc_name']}" target="_blank">` + test_center_list[i]['tc_addr'] + `</a></td>
                                     </tr>`;
                        }
                     }
                  }

                  $("#testCenterTable  tbody").html(htm);
            });
         });

         let scrollPos = 0

         function scrollRight() {
            $(".table-responsive").animate({
               scrollLeft: scrollPos + 200
            }, 800);

            scrollPos += 200;
         }

