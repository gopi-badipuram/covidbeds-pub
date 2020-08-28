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

                    for(var i = 0; i < test_center_list.length; i++){
                        if (!(test_center_list[i]['tc_name'].toLowerCase().search(val.toLowerCase()) != -1 || 
                            test_center_list[i]['tc_addr'].toLowerCase().search(val.toLowerCase()) != -1 ||
                            test_center_list[i]['tc_types'].toLowerCase().search(val.toLowerCase()) != -1 ||
                            test_center_list[i]['tc_phone'].search(val.toLowerCase()) != -1)){
                        
                                $("#test_center_" + i + "_desktop").removeClass('table-row').addClass('hidden');
                                $("#test_center_" + i + "_mobile").removeClass('table-row').addClass('hidden');
                        } else {
                     
                                $("#test_center_" + i + "_desktop").removeClass('hidden').addClass('table-row');
                                $("#test_center_" + i + "_mobile").removeClass('hidden').addClass('table-row');
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

