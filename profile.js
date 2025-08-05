
function ajax_request(url, formData, nextTabId) {
	$.ajax({
		url: url, // Replace with your server-side script URL
		type: "POST",
		data: formData,
		success: function (data) {
			// Handle the server response
			console.log(data);
			const response = JSON.parse(data);
			toastr.options.closeButton = true;
			toastr.options.positionClass = "toast-bottom-right";
			if (response["status"] == "success") {
				toastr["success"](response["message"]);

				openCity(null, nextTabId);
			} else {
				toastr["error"](response["message"]);
			}
		},
		error: function (xhr, status, error) {
			// Handle errors
			console.error("Error:", error);
			alert("An error occurred while submitting the data.");
		},
	});
}

// save profile details
$("#personal").click(() => {              
	const formData = {
		firstname: $("#firstname").val(),
		lastname: $("#lastname").val(),
		email: $("#email").val(),
		phone: $("#phone").val(),
		middlename : $("#middlename").val(),
		dob : $('#date').val(),
		bus : $("#bus").val(),
		state : $('#state').val()    ,
		address : $('#address').val(),
		gender : $("#gender").val(),
	};
	ajax_request("proc_profile", formData, "Career-information");
})

//hide second and third qualification, and second and third certification
$(".qual2").hide();
$(".qual3").hide();
$(".cert2").hide();
$(".cert3").hide();


// show and 
// qualification
$(".show1").click(() => {
    $(".show1").slideToggle();
	$(".qual2").slideToggle();
});
$(".hide2").click(() => {
    $(".show1").slideToggle();
	$(".qual2").slideToggle();
});
$(".show2").click(() => {
    $(".show2").slideToggle();
    $(".hide2").slideToggle();
	$(".qual3").slideToggle();
});
$(".hide3").click(() => {
    $(".show2").slideToggle();
    $(".hide2").slideToggle();
	$(".qual3").slideToggle();
});
//certification
$(".show4").click(() => {
    $(".show4").slideToggle();    
	$(".cert2").slideToggle();
});
$(".show5").click(() => {
    $(".show5").slideToggle();    
	$(".cert3").slideToggle();
	$(".hide5").slideToggle();
});
$(".hide5").click(() => {    
    $(".cert2").slideToggle();	
    $('.show4').slideToggle()
});
$(".hide6").click(() => {    
    $(".cert3").slideToggle();	
    $('.show5').slideToggle()
    $('.hide5').slideToggle()
}); 




//save career info
$("#career").click(() => {	
	const formData = {
		first_qualification: $("#first_qualification").val(),
		qualification_2: $("#qualification_2").val(),
		qualification_3: $("#qualification_3").val(),
		first_institution: $("#first_institution").val(),
		institution2: $("#institution2").val(),
		institution3: $("#institution3").val(),
		first_degree: $("#first_degree").val(),
		degree2: $("#degree2").val(),
		degree3: $("#degree3").val(),
		first_course: $("#first_course").val(),
		course2: $("#course2").val(),
		course3: $("#course3").val(),
		q1_year: $("#q1_year").val(),
		q2_year: $("#q2_year").val(),
		q3_year: $("#q3_year").val(),
		first_professional: $("#first_professional").val(),
		first_professional_year: $("#first_professional_year").val(),
		professional2: $("#professional2").val(),
		professional3: $("#professional3").val(),
		professional2_year: $("#professional2_year").val(),
		professional3_year: $("#professional3_year").val(),
	};
    
	ajax_request("proc_career", formData, "Work-experience");
});


//save work experience
$('#work').click(() => {

	const formData = {
		experience_1 : $('#experience_1').val(),
		industry : $('#industry').val(),
		achievement : $('#achievement').val()
	}

	ajax_request("proc_experience", formData, "Job-preference");    
})


//save job preference
$("#prefer").click(() => {   

	const formData = {
		prefState: $("#prefState").val(),
		prefJob: $("#prefJob").val(),
		availDate: $("#availDate").val(),
		prefCat: $("#prefCat").val(),
		salary: $("#salary").val(),
	};
	ajax_request("proc_job_preference", formData, "Social-media");
})


//save social media links
$('#social').click(() => {
	const formData = {
		facebook: $("#facebook").val(),
		twitter: $("#twitter").val(),
		instagram: $("#instagram").val(),
		linkedin: $("#linkedin").val()
	};
	ajax_request("proc_social_media", formData, "Reference");	
})


//save referee details
$("#referee").click(() => {
	const formData = {
		refName: $('#refName').val(),
		refEmail: $('#refEmail').val(),
		refPhone: $('#refPhone').val(),
		refPosition: $('#refPosition').val(),
		refCity: $('#refCity').val(),
		refState: $('#refState').val(),
		refCompany: $('#refCompany').val(),
		refAddress: $('#refAddress').val(),
		refName2: $('#refName2').val(),
		refEmail2: $('#refEmail2').val(),
		refPhone2: $('#refPhone2').val(),
		refPosition2: $('#refPosition2').val(),
		refCity2: $('#refCity2').val(),
		refState2: $('#refState2').val(),
		refCompany2: $('#refCompany2').val(),
		refAddress2: $('#refAddress2').val()
		
	}

	ajax_request("proc_reference", formData, "Personal-information");    
})