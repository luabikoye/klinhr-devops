
$("#fav").click(() => {
	const buttonData = $('#fav').data();
    const id = buttonData.id;
    $.ajax({
			url: "favourite",
			method: "POST",
			data: {
				id: id,
			},
        success: function (data) {                
            console.log(data);
            response = JSON.parse(data)
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-bottom-right";
            if (response["status"] == "success") {
                toastr["success"](response['message']);
            } else {
                toastr["error"](response['message']);                
            }
			},
			error: function (xhr, status, error) {
				console.error(error);
			},
		});
});


