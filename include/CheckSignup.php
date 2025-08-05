<script>
    $("#firstname").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#btn_login").click();
        }
    });

    $("#lastname").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#btn_login").click();
        }
    });
    $("#email").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#btn_login").click();
        }
    });
    $("#phone").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#btn_login").click();
        }
    });
    $("#password").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#btn_login").click();
        }
    });
    $("#confirm_password").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#btn_login").click();
        }
    });

    $(document).on("click", "#btn_login", function() {
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        var btn_login = $('#btn_login').val();

        if (firstname == '') {
            document.getElementById("error").innerHTML = "Firstname is required";
            document.getElementById("firstname").style.borderColor = 'red';
            return false;
        } else {
            document.getElementById("firstname").style.borderColor = 'green';
        }

        if (lastname == '') {
            document.getElementById("error").innerHTML = "Lastname is required";
            document.getElementById("lastname").style.borderColor = 'red';
            return false;
        } else {
            document.getElementById("lastname").style.borderColor = 'green';
        }

        if (email == '') {
            document.getElementById("error").innerHTML = "Email is required";
            document.getElementById("email").style.borderColor = 'red';
            return false;
        } else {
            document.getElementById("email").style.borderColor = 'green';
        }

        if (phone == '') {
            document.getElementById("error").innerHTML = "Phone is required";
            document.getElementById("phone").style.borderColor = 'red';
            return false;
        } else {
            document.getElementById("phone").style.borderColor = 'green';
        }

        if (password == '') {
            document.getElementById("error").innerHTML = "Password is required";
            document.getElementById("password").style.borderColor = 'red';
            return false;
        } else {
            document.getElementById("password").style.borderColor = 'green';
        }

        if (confirm_password == '') {
            document.getElementById("error").innerHTML = "Confirms password is required";
            document.getElementById("confirm_password").style.borderColor = 'red';
            return false;
        } else {
            document.getElementById("confirm_password").style.borderColor = 'green';
        }

        if (password != confirm_password) {
            document.getElementById("error").innerHTML = "Password do not match";
            document.getElementById("confirm_password").style.borderColor = 'red';
            return false;
        } else {
            document.getElementById("confirm_password").style.borderColor = 'green';
        }

        // let passlength = password.length;            

        var form_data = new FormData();
        form_data.append('firstname', firstname);
        form_data.append("lastname", lastname);
        form_data.append("email", email);
        form_data.append("phone", phone);
        form_data.append('password', password);
        form_data.append("confirm_password", confirm_password);
        form_data.append("btn_login", btn_login);
        

        $.ajax({
            url: 'ProcessSignup?',
            method: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function() {
                $('#signup_result').html('Checking....');
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
                    $('#btn_login').text('Checking....');
                } else {
                    $('.signup_result').hide();
                    $('#error2').show();
                    // $('#error2').html(result['message']);
                    $('#btn_login').text('Account Successfuly Created');

                }
                if (result['status'] == 'success') {
                    $('#btn_login').html('Account Successfuly Created');
                    setTimeout(function() {
                        window.location.href = data.Url = "thankyou?registration=success";
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