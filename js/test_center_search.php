<?php session_start();

    $tc_arr = $_SESSION['test_center_list'];
?>

         
         

         $(document).ready(function() {

            let test_center_list = <?php echo json_encode($tc_arr); ?>;
            scroll = false;
            
            $("#searchDiv").click(function(){
               $('html, body').animate({
                  scrollTop: $("#test_centers").offset().top
               }, 1000, function() {
                  $("#searchInput").focus();
              });
            })

            $("#searchInput").on('input', function(){
                  let val = $(this).val();
                  
                  if(screen.width <= 600){
                   let htm = '';
                   
                    for(var i = 0; i < test_center_list.length; i++){
                        if ((test_center_list[i]['tc_name'].toLowerCase().search(val.toLowerCase()) != -1 || 
                            test_center_list[i]['tc_addr'].toLowerCase().search(val.toLowerCase()) != -1 ||
                            test_center_list[i]['tc_types'].toLowerCase().search(val.toLowerCase()) != -1 ||
                            test_center_list[i]['tc_phone'].search(val.toLowerCase()) != -1)){
                            
                            htm += `<tr>
                               <th scope="row">` + (i+1) + `</th>
                                <td><a style="font-weight: bold" href="http://maps.google.com/?q=${test_center_list[i]['tc_name']}" target="_blank">${test_center_list[i]['tc_name']}</a><br>
                                `+ test_center_list[i]['phone'] +`<br><span style="font-weight: bold;">Cost: </span><span style="color: black; font-size: 12px; font-weight: bold;">`+ test_center_list[i]['tc_cost'] + `</span><br>
                                      <span style="font-weight: bold;">Result in: </span><span style="color: black; text-align: center;">` + test_center_list[i]['tc_wait_time'] + `</span><br>
                                      <span style="font-weight: bold;">Types of test: </span><span style="color: black; text-align: center;">` + test_center_list[i]['tc_types'] + `</span><br>
                                      <a href="http://maps.google.com/?q={$test_center_list[i]['tc_name']}" target="_blank">` + test_center_list[i]['tc_addr'] + `</a></td>` +
                             `</tr>`;
                        }
                    }
                    
                    $("#testCenterTable  tbody").html(htm);
                  
                  } else {

                    for(var i = 0; i < test_center_list.length; i++){
                        if (!(test_center_list[i]['tc_name'].toLowerCase().search(val.toLowerCase()) != -1 || 
                            test_center_list[i]['tc_addr'].toLowerCase().search(val.toLowerCase()) != -1 ||
                            test_center_list[i]['tc_types'].toLowerCase().search(val.toLowerCase()) != -1 ||
                            test_center_list[i]['tc_phone'].search(val.toLowerCase()) != -1)){
                        
                                $("#test_center_" + i).removeClass('table-row');
                                $("#test_center_" + i).addClass('hidden');
                        } else {
                     
                                $("#test_center_" + i).removeClass('hidden');
                                $("#test_center_" + i).addClass('table-row');
                        }
                    }
                  }
            });
         });

         let scrollPos = 0

         function scrollRight() {
            $(".table-responsive").animate({
               scrollLeft: scrollPos + 200
            }, 800);

            scrollPos += 200;
         }

