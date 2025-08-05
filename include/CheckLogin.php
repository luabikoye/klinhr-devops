<?php
require_once('app/inc/fns.php');
?>
<script>
  $("#email").keypress(function(event) {
    if (event.keyCode === 13) {
      $("#btn_login").click();
    }
  });

  $("#password").keypress(function(event) {
    if (event.keyCode === 13) {
      $("#btn_login").click();
    }
  });

  $(document).on("click", "#btn_login", function() {

    var email = $('#email').val();
    var password = $('#password').val();
    var btn_login = $('#btn_login').val();
    var return_val = $('#return_val').val();
    var return_page = $('#return_page').val();

    if (email == '') {
      document.getElementById("error").innerHTML = "Email is required";
      document.getElementById("email").style.borderColor = 'red';
      return false;
    } else {
      document.getElementById("email").style.borderColor = 'green';
    }
    if (password == '') {
      document.getElementById("error").innerHTML = "Password is required";
      document.getElementById("password").style.borderColor = 'red';
      return false;
    } else {
      document.getElementById("password").style.borderColor = 'green';
    }


    var form_data = new FormData();

    form_data.append("email", email);
    form_data.append('password', password);
    form_data.append('return', return_val);
    form_data.append('btn_login', btn_login);
    form_data.append('return_page', return_page);


    $.ajax({
      url: 'ProcessLogin',
      method: 'POST',
      data: form_data,
      contentType: false,
      cache: false,
      processData: false,

      beforeSend: function() {
        $('#signup_result').html('Checking...');
        $('#btn_login').show();
      },
      success: function(data) {
        console.log(data);
        var result = JSON.parse(data);
        if (result['status'] == 'error') {
          $('.signup_result').hide();
          $('#error').show();
          $('#error').html(result['message']);

          // Button validating the inputs
          // $('#btn_login').text('Checking...');
        } else {
          $('.signup_result').hide();
          $('#error2').show();
          $('#error2').html(result['message']);
        }
        if (result['status'] == 'success') {
          $('#btn_login').html('Logging in...');
          setTimeout(function() {
            window.location.href = data.Url = "dashboard";
          });
        }
        if (result['status'] == 'return') {
          $('#btn_login').html('Logging in...');
          setTimeout(function() {
            window.location.href = data.Url =
              "search-details?1c30f1ae89e3ba2eb42c7d=0f52ac208baa24be3b8f7"
          });
        }

        if (result['status'] == 'return_page') {
          $('#btn_login').html('Logging in...');
          setTimeout(function() {
            window.location.href = data.Url =
              "return_url?0f52ac208baa24be3b8f7=1c30f1ae89e3ba2eb42c7d"
          });
        }

      }

    });


  });

  $(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>