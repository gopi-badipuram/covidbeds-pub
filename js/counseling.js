$(document).ready(function() {
    $("#counsel_form").submit(function(e){
                   e.preventDefault();

                   let details = {
                      new_counseling_request: 1,
                      name: $("#counsel_name").val(),
                      phone: $("#counsel_phone").val(),
                      email: $("#counsel_email").val(),
                      country: $("#counsel_country").val(),
                      city: $("#counsel_city").val(),
                      age: $("#counsel_age option:selected").html(),
                      occupation: $("#counsel_occupation").val(),
                      language: $("#counsel_language option:selected").html(),
                      mode: $("#counsel_mode option:selected").html(),
                      time: $("#counsel_time option:selected").html(),
                      cfor: $("#counsel_for option:selected").html(),
                      history: $("input[name=counsel_history]:checked").val(),
                      comments: $("#counsel_message").val()
                   };

                   let days = '';

                   for(var i = 0; i < $("#counsel_days input:checked").length; i++){
                      days += $("#counsel_days input:checked").eq(i).val();

                      if(i != $("#counsel_days input:checked").length - 1){
                         days += ', ';
                      }
                   }

                   details['days'] = days;

                   console.log(details);

                   $.ajax({
                      url: 'backend/index.php',
                      method: 'post',
                      data: details,
                      beforeSend: function(){
                         $("#counsel_submit_btn").html('<img src="images/white-loader.gif" style="height: 20px;"> Please wait...').attr('disabled', 'disabled');
                      },
                      success: function(data){
                         $("#counsel_submit_btn").html('Submit').removeAttr('disabled');

                         data = JSON.parse(data);

                         if(data.response == "success"){
                            $("#counsel-alert-txt").html('Your request has been submitted. We will contact you soon.').css('color', 'green');
                         }
                         else{
                            $("#counsel-alert-txt").html('Something went wrong. Please try again later').css('color', 'red');
                         }

                         setTimeout(function(){
                            $("#counsel-alert-txt").html('');
                         }, 2000)
                      },
                      error: function(data){
                         $("#counsel_submit_btn").html('Submit').removeAttr('disabled');

                         $("#counsel-alert-txt").html('Something went wrong. Please try again later').css('color', 'red');

                         setTimeout(function(){
                            $("#counsel-alert-txt").html('');
                         }, 2000);
                      }
                   })
                })


});
