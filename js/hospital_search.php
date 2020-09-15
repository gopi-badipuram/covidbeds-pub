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
                     
                     if(hosp_list[i]['hospital_name'].toLowerCase().search(val.toLowerCase()) != -1 || hosp_list[i]['hospital_address'].toLowerCase().search(val.toLowerCase()) != -1) {
                     
                        $("#hospital_" + i + "_desktop").addClass('table-row').removeClass('hidden');
                        $("#hospital_" + i + "_mobile").addClass('table-row').removeClass('hidden');
                        
                     } else {
                        
                        $("#hospital_" + i + "_desktop").removeClass('table-row').addClass('hidden');
                        $("#hospital_" + i + "_mobile").removeClass('table-row').addClass('hidden');
                     }
                  }
            });
         })

         let scrollPos = 0

         function scrollRight() {
            $(".table-responsive").animate({
               scrollLeft: scrollPos + 200
            }, 800);

            scrollPos += 200;
         }

