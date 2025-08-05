<script>

  
  $(document).on("click", "#save_password", function () {
    $('#error').fadeIn(100);
    var current_password = $('#current_password').val();
    var new_pass = $('#new_pass').val();
    var confirm_pass = $('#confirm_pass').val();
    var return_val = $('#return_val').val();

    if (current_password == '') 
    {
      document.getElementById("error").innerHTML = "Current password is required";
      document.getElementById("current_password").style.borderColor = 'red';
     
      return false;
    } 
    else 
    {
      document.getElementById("current_password").style.borderColor = 'green';
    }
    if (new_pass == '') 
    {
      document.getElementById("error").innerHTML = "New password is required";
      document.getElementById("new_pass").style.borderColor = 'red';
      return false;
    }
    else
    {
      document.getElementById("new_pass").style.borderColor = 'green';
    }
    if (confirm_pass == '') 
    {
      document.getElementById("error").innerHTML = "Confirm password is required";
      document.getElementById("confirm_pass").style.borderColor = 'red';
      return false;
    }
    else
    {
      document.getElementById("confirm_pass").style.borderColor = 'green';
    }
    if (new_pass != confirm_pass) 
    {
      document.getElementById("error").innerHTML = "Password do not match";
      document.getElementById("confirm_pass").style.borderColor = 'red';
      return false;
    }
    else
    {
      document.getElementById("confirm_pass").style.borderColor = 'green';
    }
    
    
  });

</script>