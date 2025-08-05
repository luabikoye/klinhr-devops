<script>
    $(document).on("click", "#checked", function () {

        var id = $('#id').val();
       

            alert(id);

        var form_data = new FormData();
      
        form_data.append("id", id);
        form_data.append("btn_login", btn_login);

        $.ajax({
            url: 'UpdateStatus?',
            method: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function () {
                $('#signup_result').html('Checking....');
                $('#btn_login').show();
            },
            success: function (data) {
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
                    $('#error2').html(result['message']);
                    $('#btn_login').text('Account Successfuly Created');
                }
                if (result['status'] == 'success') {
                    $('#btn_login').html('Redirecting....');
                    setTimeout(function () {
                        window.location.href = data.Url = "login";
                    }, 5000);
                }
            }
        });
    });

    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>