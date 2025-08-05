<style>
    .profile_results {
        color: green;
        margin-bottom: 15px;
        font-size: 15px;
        font-weight: bold;
    }

    .c-accordion-content .add-more {
        color: #ED3E43;
        margin-top: 30px;
        margin-bottom: 50px;
        background: none;
        border: none;
    }
</style>

<script>
    $(document).ready(function () {

        $('.qualications_area').hide();


        $('#add_qua1').click(function () {
            $(this).hide();
            $('#qualification2').show();
        })

        $('#add_qua1').click(function () {
            $(this).hide();
            $('#add_qua2').show();
        })

        $('#add_qua2').click(function () {
            $(this).hide();
            $('#qualification3').show();
        })

        $('#remove_qua2').click(function () {
            $('#qualification2').hide();
            $('#add_qua2').hide();
            $('#add_qua1').show();

        })

        $('#remove_qua3').click(function () {
            $('#qualification3').hide();
            $('#add_qua2').show();
        })

        //EXPERIENCE

        $('.experience_area').hide();

        $('#add_exp1').click(function () {
            $(this).hide();
            $('#experience2').show();
        })

        $('#add_exp1').click(function () {
            $(this).hide();
            $('#add_exp2').show();

        })

        $('#add_exp2').click(function () {
            $(this).hide();
            $('#experience3').show();
            $('#remove_exp2').hide();
            $('#remove_exp3').show();
        })

        $('#remove_exp2').click(function () {
            $('#experience2').hide();
            $('#add_exp2').hide();
            $('#add_exp1').show();

        })

        $('#remove_exp3').click(function () {
            $('#experience3').hide();
            $('#remove_exp3').hide();

            $('#add_exp2').show();
            $('#remove_exp2').show();
        })

        // EXPERIENCE END


        //  CAREER
        $('.certification_area').hide();

        $('#add_cert1').click(function () {
            $(this).hide();
            $('#certification2').show();
            $('#add_cert3').hide();
            $('#remove_cert3').hide();
            $('#remove_cert4').hide();
        })

        $('#add_cert1').click(function () {
            $(this).hide();
            $('#add_cert2').show();
        })

        $('#add_cert2').click(function () {
            $(this).hide();
            $('#certification3').show();
            $('#remove_cert2').hide();
            $('#add_cert3').show();
            $('#remove_cert3').show();
        })

        $('#add_cert3').click(function () {
            $(this).hide();
            $('#certification4').show();
            $('#remove_cert3').hide();
            $('#remove_cert4').show();
        })

        $('#remove_cert2').click(function () {
            $('#certification2').hide();
            $('#add_cert2').hide();
            $('#add_cert1').show();

        })

        $('#remove_cert3').click(function () {
            $('#certification4').hide();
            $('#remove_cert4').hide();
            $('#certification3').hide();

            $('#add_cert4').hide();
            $('#remove_cert3').hide();

            $('#add_cert3').hide();

            $('#add_cert2').show();
            $('#remove_cert2').show();
        })

        $('#remove_cert4').click(function () {
            $('#certification4').hide();
            $('#remove_cert4').hide();
            $('#add_cert4').hide();
            $('#add_cert3').show();
            $('#remove_cert3').show();

        })
        // career ends here

        // show list

        $('#show_qualification_list').hide();
        $('#show_institution_list').hide();
        $('#show_course_list').hide();

        $('#show_qualification_list2').hide();
        $('#show_institution_list2').hide();
        $('#show_course_list2').hide();

        $('#show_qualification_list3').hide();
        $('#show_institution_list3').hide();
        $('#show_course_list3').hide();

        $('#show_cert_list').hide();
        $('#show_cert_list2').hide();
        $('#show_cert_list3').hide();
        $('#show_cert_list4').hide();

        $('#show_work_exp_list').hide();
        $('#show_work_exp_list2').hide();
        $('#show_work_exp_list3').hide();

        $('#show_pref_list').hide();

        // $('#current').click(function () {
        //     $(this).hide();

        //     $('#exp_year_end').hide();
        //     $('#current').show();

        // })


        $(document).ready(function () {
            $('input[type="checkbox"]').click(function () {
                var inputValue = $(this).attr("value");
                $("." + inputValue).toggle();
            });
        });


        $('#show_qualification_list').click(function () {
            $(this).hide();
            $('#first_qualification').show();
            $('#other_first_qualification').hide();
        })

        $('#show_institution_list').click(function () {
            $(this).hide();
            $('#first_institution').show();
            $('#other_first_institution').hide();
        })

        $('#show_course_list').click(function () {
            $(this).hide();
            $('#first_course').show();
            $('#other_first_course').hide();
        })
        /////////

        $('#show_qualification_list2').click(function () {
            $(this).hide();
            $('#qualification_2').show();
            $('#other_qualification_2').hide();
        })

        $('#show_institution_list2').click(function () {
            $(this).hide();
            $('#institution2').show();
            $('#other_institution2').hide();
        })

        $('#show_course_list2').click(function () {
            $(this).hide();
            $('#course2').show();
            $('#other_course2').hide();
        })
        /////////

        $('#show_qualification_list3').click(function () {
            $(this).hide();
            $('#qualification_3').show();
            $('#other_qualification_3').hide();
        })

        $('#show_institution_list3').click(function () {
            $(this).hide();
            $('#institution3').show();
            $('#other_institution3').hide();
        })

        $('#show_course_list3').click(function () {
            $(this).hide();
            $('#course3').show();
            $('#other_course3').hide();
        })
        //////

        // Professional certificate
        $('#show_cert_list').click(function () {
            $(this).hide();
            $('#profCert').show();
            $('#other_cert1').hide();
        })

        $('#show_cert_list2').click(function () {
            $(this).hide();
            $('#profCert2').show();
            $('#other_cert2').hide();
        })

        $('#show_cert_list3').click(function () {
            $(this).hide();
            $('#profCert3').show();
            $('#other_cert3').hide();
        })

        $('#show_cert_list4').click(function () {
            $(this).hide();
            $('#profCert4').show();
            $('#other_cert4').hide();
        })

        /////
        // WORK EXPERIENCE
        $('#show_work_exp_list').click(function () {
            $(this).hide();
            $('#industry').show();
            $('#other_industry1').hide();
        })
        $('#show_work_exp_list2').click(function () {
            $(this).hide();
            $('#industry2').show();
            $('#other_industry2').hide();
        })
        $('#show_work_exp_list3').click(function () {
            $(this).hide();
            $('#industry3').show();
            $('#other_industry3').hide();
        })

        // job preference
        $('#show_pref_list').click(function () {
            $(this).hide();
            $('#prefCat').show();
            $('#other_industry4').hide();
        })



        //personal information jquery
        $(document).on("click", "#btn_personal", function () {
            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var middlename = $('#middlename').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var gender = $('#gender').val();
            var dob = $('#dob').val();
            var landmark = $('#landmark').val();
            var state = $('#state_residence').val();           
            var address = $('#address').val();
            var selectBox = 'Passport';
            var del = $('#del').val();

            if (!firstname) {
                alert('Firstname is required');
                return false;
            }

            if (!lastname) {
                alert('Lastname is required');
                return false;

            }
            if (!email) {
                alert('Email is required');
                return false;

            }
            if (!phone) {
                alert('Phone is required');
                return false;

            }
            if (!gender) {
                alert('Gender is required');
                return false;

            }
            if (!dob) {
                alert('Date of birth is required');
                return false;

            }
            if (!state) {
                alert('State is required');
                return false;

            }           

            var local_govt = document.getElementById("local_govt");
            var selectedValue = local_govt.options[local_govt.selectedIndex].value;
            if (selectedValue == "local_govt") {
                alert('Local govt is required');
                return false;

            }
            if (!address) {
                alert('Current address is required');
                return false;

            }

            if (!landmark) {
                alert('Bustop is required');
                return false;
            }

            if (document.getElementById("passport").files.length == 0) {
                alert("No passport file has been uploaded");
                return false;
            }

            var property = document.getElementById('passport').files[0];
            var file_name = property.name;
            var file_extension = file_name.split('.').pop().toLowerCase();

            if (jQuery.inArray(file_extension, ['gif', 'GIF', 'jpg', 'JPG', 'png', 'PNG', 'JPEG',
                    'jpeg',
                    ''
                ]) == -1) {
                alert(
                    "Invalid file format uploaded. Only gif, GIF, jpg, JPG, png, PNG, JPEG, jpeg are allowed"
                );
                return false;
            }

        });


        $(document).on("click", "#btn_credentials", function () {
            var selectBox = 'CV';
            var del = $('#del').val();
            var address = $('#address').val();
            if (document.getElementById("userfile").files.length == 0) {
                alert("No  file has been uploaded");
            }
            var property = document.getElementById('userfile').files[0];
            var file_name = property.name;
            var file_extension = file_name.split('.').pop().toLowerCase();
            if (jQuery.inArray(file_extension, ['gif', 'GIF', 'jpg', 'JPG', 'png', 'PNG', 'JPEG',
                    'jpeg', 'pdf', 'PDF', 'doc', 'docx', 'ppt', 'pptx',
                    ''
                ]) == -1) {
                alert(
                    "Invalid file format uploaded. Only images and Word documents are allowed"
                );
                return false;
            }
            var form_data = new FormData();
            form_data.append('selectBox', selectBox);
            form_data.append("file", property);
            form_data.append("passport", property);
            form_data.append('file', property);

            $.ajax({
                url: 'save_cv.php?',
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,

                beforeSend: function () {
                    $('#credential_result').html('Loading......');
                    $('#academic').show();
                },

                success: function (data) {

                    console.log(data);
                    var result = JSON.parse(data);
                    if (result['status'] == 'error') {
                        $('.profile_results').hide();
                        $('#credential_result').show();
                        $('#credential_result').html(result['message']);
                    } else {
                        $('.profile_results').hide();
                        $('#credential_result2').show();
                        $('#credential_result2').html(result['message']);
                    }
                    $('#btn_credentials').text('Uploaded!');
                }
            });
        });
        //other document information jquery

        //delete cv jquery
        $(document).on("click", "#id", function () {

            var form_data = new FormData();
            form_data.append("id", id);

            $.ajax({
                url: 'delete_cv.php?',
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,

                beforeSend: function () {
                    $('#delete_result');
                    $('#academic').show();
                },
                success: function (data) {
                    console.log(data);
                    $('#delete_result').html(data);
                    // var result = JSON.parse(data);
                    // if (result['status'] == 'error') {
                    //     $('.profile_results').hide();
                    //     $('#credential_result').show();
                    //     $('#credential_result').html(result['message']);
                    // } else {
                    //     $('.profile_results').hide();
                    //     $('#credential_result').show();
                    //     $('#credential_result2').html(result['message']);

                    // }
                }
            });
        });

        //delete cv jquery


        //certificate information jquery
        $('#btn_career').click(function () {

            $(this).text('Saving...');

            var first_qualification = $('#first_qualification').val();
            var other_first_qualification = $('#other_first_qualification').val();
            var year_of_qualification1 = $('#year_of_qualification1').val();
            var year_of_qualification2 = $('#year_of_qualification2').val();
            var year_of_qualification3 = $('#year_of_qualification3').val();
            var year_of_qualification4 = $('#year_of_qualification4').val();

            var qualification_2 = $('#qualification_2').val();
            var other_qualification_2 = $('#other_qualification_2').val();

            var qualification_3 = $('#qualification_3').val();
            var other_qualification_3 = $('#other_qualification_3').val();

            var first_institution = $('#first_institution').val();
            var other_first_institution = $('#other_first_institution').val();

            var institution2 = $('#institution2').val();
            var other_institution2 = $('#other_institution2').val();

            var institution3 = $('#institution3').val();
            var other_institution3 = $('#other_institution3').val();


            var first_course = $('#first_course').val();
            var other_first_course = $('#other_first_course').val();

            var course2 = $('#course2').val();
            var other_course2 = $('#other_course2').val();

            var course3 = $('#course3').val();
            var other_course3 = $('#other_course3').val();


            var email = $('#email').val();
            var profCert = $('#profCert').val();
            var other_cert1 = $('#other_cert1').val();
            var profcert_year_start = $('#profcert_year_start').val();
            var profcert_year_end = $('#profcert_year_end').val();

            var profCert2 = $('#profCert2').val();
            var other_cert2 = $('#other_cert2').val();
            var profcert2_year_start = $('#profcert2_year_start').val();
            var profcert2_year_end = $('#profcert2_year_end').val();

            var profCert3 = $('#profCert3').val();
            var other_cert3 = $('#other_cert3').val();
            var profcert3_year_start = $('#profcert3_year_start').val();
            var profcert3_year_end = $('#profcert3_year_end').val();

            var profCert4 = $('#profCert4').val();
            var other_cert4 = $('#other_cert4').val();
            var profcert4_year_start = $('#profcert4_year_start').val();
            var profcert4_year_end = $('#profcert4_year_end').val();

            var first_degree = $('#first_degree').val();
            var degree2 = $('#degree2').val();
            var degree3 = $('#degree3').val();


            // if (!first_qualification || !first_institution || !first_course || !first_degree) {
            //     alert('All information on first qualification is compulsory');
            //     return false;
            // }

            $.ajax({

                url: "SaveCareer.php",
                method: "POST",
                data: {
                    first_qualification: first_qualification,
                    other_first_qualification: other_first_qualification,
                    qualification_2: qualification_2,
                    other_qualification_2: other_qualification_2,
                    qualification_3: qualification_3,
                    other_qualification_3: other_qualification_3,
                    year_of_qualification1: year_of_qualification1,
                    year_of_qualification2: year_of_qualification2,
                    year_of_qualification3: year_of_qualification3,
                    year_of_qualification4: year_of_qualification4,

                    first_institution: first_institution,
                    other_first_institution: other_first_institution,
                    institution2: institution2,
                    other_institution2: other_institution2,
                    institution3: institution3,
                    other_institution3: other_institution3,


                    first_course: first_course,
                    other_first_course: other_first_course,
                    course2: course2,
                    other_course2: other_course2,
                    course3: course3,
                    other_course3: other_course3,


                    email: email,

                    profCert: profCert,
                    other_cert1: other_cert1,
                    profcert_year_start: profcert_year_start,
                    profcert_year_end: profcert_year_end,

                    profCert2: profCert2,
                    other_cert2: other_cert2,
                    profcert2_year_start: profcert2_year_start,
                    profcert2_year_end: profcert2_year_end,

                    profCert3: profCert3,
                    other_cert3: other_cert3,
                    profcert3_year_start: profcert3_year_start,
                    profcert3_year_end: profcert3_year_end,

                    profCert4: profCert4,
                    other_cert4: other_cert4,
                    profcert4_year_start: profcert4_year_start,
                    profcert4_year_end: profcert4_year_end,

                    first_degree: first_degree,
                    degree2: degree2,
                    degree3: degree3,


                },
                success: function (data) {
                    // $('#career_result').html(data);
                    $('#btn_career').text('Saved!');
                    var result = JSON.parse(data);
                    if (result['status'] == 'error') {
                        $('.profile_results').hide();
                        $('#career_result').show();
                        $('#career_result').html(result['message']);
                    } else {
                        $('.profile_results').hide();
                        $('#career_result2').show();
                        $('#career_result2').html(result['message']);
                    }
                }
            })
            //certificate information jquery end here
        })

        //work experience information jquery
        $('#btn_work').click(function () {

            $(this).text('Saving...');
            var industry = $('#industry').val();
            var experience_1 = $('#experience_1').val();
            var achievement = $('#achievement').val();

            var name_of_org = $('#name_of_org').val();
            var position = $('#position').val();
            var job_level = $('#job_level').val();
            var exp_year_start = $('#exp_year_start').val();

            if ($("#current_workplace_1").is(":checked", true)) {
                var exp_year_end = 'Till Date';
            } else {
                var exp_year_end = $('#exp_year_end').val();
            }
            var industry2 = $('#industry2').val();
            var experience_2 = $('#experience_2').val();
            var achievement2 = $('#achievement2').val();
            var workplace_2 = $('#workplace_2').val();
            var name_of_org2 = $('#name_of_org2').val();
            var position2 = $('#position2').val();
            var job_level2 = $('#job_level2').val();
            var exp2_year_start = $('#exp2_year_start').val();

            if ($("#current_workplace_2").is(":checked", true)) {
                var exp2_year_end = 'Till Date';
            } else {
                var exp2_year_end = $('#exp2_year_end').val();
            }
            var industry3 = $('#industry3').val();
            var experience_3 = $('#experience_3').val();
            var achievement3 = $('#achievement3').val();
            var workplace_3 = $('#workplace_3').val();
            var name_of_org3 = $('#name_of_org3').val();
            var position3 = $('#position3').val();
            var job_level3 = $('#job_level3').val();
            var exp3_year_start = $('#exp3_year_start').val();

            if ($("#current_workplace_3").is(":checked", true)) {

                var exp3_year_end = 'Till Date';
            } else {
                var exp3_year_end = $('#exp3_year_end').val();
            }

            $.ajax({

                url: "save_work_experience.php",
                method: "POST",
                data: {
                    industry: industry,
                    experience_1: experience_1,
                    achievement: achievement,
                    name_of_org: name_of_org,
                    job_level: job_level,
                    position: position,
                    exp_year_start: exp_year_start,
                    exp_year_end: exp_year_end,

                    industry2: industry2,
                    experience_2: experience_2,
                    achievement2: achievement2,
                    name_of_org2: name_of_org2,
                    job_level2: job_level2,
                    position2: position2,
                    exp2_year_start: exp2_year_start,
                    exp2_year_end: exp2_year_end,
                    workplace_2: workplace_2,

                    industry3: industry3,
                    experience_3: experience_3,
                    achievement3: achievement3,
                    name_of_org3: name_of_org3,
                    job_level3: job_level3,
                    position3: position3,
                    exp3_year_start: exp3_year_start,
                    exp3_year_end: exp3_year_end,
                    workplace_3: workplace_3,

                    email: email,
                },
                success: function (data) {
                    // $('#work_result').html(data);
                    $('#btn_work').text('Saved!');
                    var result = JSON.parse(data);
                    if (result['status'] == 'error') {
                        $('.profile_results').hide();
                        $('#work_result').show();
                        $('#work_result').html(result['message']);
                    } else {
                        $('.profile_results').hide();
                        $('#work_result2').show();
                        $('#work_result2').html(result['message']);
                    }
                }
            })
        })
        //work experience jquery end here

        //social media  information jquery
        $('#btn_social').click(function () {

            $(this).text('Saving...');

            var facebook = $('#facebook').val();
            var twitter = $('#twitter').val();
            var linkedin = $('#linkedin').val();
            var instagram = $('#instagram').val();
            var email = $('#email').val();

            $.ajax({

                url: "save_social_media.php",
                method: "POST",
                data: {
                    facebook: facebook,
                    twitter: twitter,
                    linkedin: linkedin,
                    instagram: instagram,
                    email: email,
                },
                success: function (data) {
                    // $('#social_result').html(data);
                    $('#btn_social').text('Saved!');
                    var result = JSON.parse(data);
                    if (result['status'] == 'error') {
                        $('.profile_results').hide();
                        $('#social_result').show();
                        $('#social_result').html(result['message']);
                    } else {
                        $('.profile_results').hide();
                        $('#social_result2').show();
                        $('#social_result2').html(result['message']);
                    }
                }
            })
        })
        //social media   jquery end here

        //job preference   information jquery
        $('#btn_job').click(function () {

            $(this).text('Saving...');

            var salary = $('#salary').val();
            var prefJob = $('#prefJob').val();
            var availDate = $('#availDate').val();
            var prefState = $('#prefState').val();
            var prefCat = $('#prefCat').val();
            var other_industry4 = $('#other_industry4').val();
            var notify = $('#notify').val();
            var email = $('#email').val();


            $.ajax({

                url: "save_job_preference.php",
                method: "POST",
                data: {
                    salary: salary,
                    prefJob: prefJob,
                    availDate: availDate,
                    prefState: prefState,
                    prefCat: prefCat,
                    other_industry4: other_industry4,
                    notify: notify,
                    email: email,
                },
                success: function (data) {
                    // $('#job_result').html(data);
                    $('#btn_job').text('Saved!');
                    var result = JSON.parse(data);
                    if (result['status'] == 'error') {
                        $('.profile_results').hide();
                        $('#job_result').show();
                        $('#job_result').html(result['message']);
                    } else {
                        $('.profile_results').hide();
                        $('#job_result2').show();
                        $('#job_result2').html(result['message']);
                    }
                }

            })
        })
        //job preference    jquery end here


        // refree   information jquery
        $('#btn_ref').click(function () {

            $(this).text('Saving...');

            var refName = $('#refName').val();
            var refEmail = $('#refEmail').val();
            var refPhone = $('#refPhone').val();
            var refPosition = $('#refPosition').val();
            var refCity = $('#refCity').val();
            var refAddress = $('#refAddress').val();
            var refCompany = $('#refCompany').val();
            var refState = $('#refState').val();

            var refName2 = $('#refName2').val();
            var refEmail2 = $('#refEmail2').val();
            var refPhone2 = $('#refPhone2').val();
            var refPosition2 = $('#refPosition2').val();
            var refCity2 = $('#refCity2').val();
            var refAddress2 = $('#refAddress2').val();
            var refCompany2 = $('#refCompany2').val();
            var refState2 = $('#refState2').val();
            var email = $('#email').val();

            $.ajax({

                url: "save_refree.php",
                method: "POST",
                data: {
                    refName: refName,
                    refEmail: refEmail,
                    refPhone: refPhone,
                    refPosition: refPosition,
                    refCompany: refCompany,
                    refAddress: refAddress,
                    refCity: refCity,
                    refState: refState,

                    refName2: refName2,
                    refEmail2: refEmail2,
                    refPhone2: refPhone2,
                    refPosition2: refPosition2,
                    refCompany2: refCompany2,
                    refAddress2: refAddress2,
                    refCity2: refCity2,
                    refState2: refState2,
                    email: email,
                },
                success: function (data) {
                    // $('#ref_result').html(data);
                    $('#btn_ref').text('Saved!');
                    var result = JSON.parse(data);
                    if (result['status'] == 'error') {
                        $('.profile_results').hide();
                        $('#ref_result').show();
                        $('#ref_result').html(result['message']);
                    } else {
                        $('.profile_results').hide();
                        $('#ref_result2').show();
                        $('#ref_result2').html(result['message']);
                    }
                }

            })
        })
        //refree   jquery end here

        /// update prpfile

        $('#update_profile').click(function () {

            $(this).text('Saving...');

            var email = $('#email').val();

            $.ajax({

                url: "update_profile.php",
                method: "POST",
                data: {
                    email: email,
                },
                success: function (data) {
                    $('#update_result').html(data);
                    $('#update_profile').text(
                        'Your profile has been successfully updated!!!');
                }
            })
        })
    });

    //For other document


    $(function () {
        // $('#hear_about2').hide();

        $('#first_qualification').change(function () {
            var how = $(this).val();
            if (how == 'MASTERS') {
                $(this).hide();
                $('#first_qualification').show();
                $('#first_degree').hide();

            } else {
                if (how == 'HND' || how == 'OND' || how == 'BACHELOR DEGREE' || how == 'NCE' ||
                    how == 'HIGH SCHOOL (S.S.C.E)') {
                    $(this).show();
                    $('#first_degree').show();
                }
            }

        })

        $('#qualification_2').change(function () {
            var how2 = $(this).val();
            if (how2 == 'MASTERS') {
                $(this).hide();
                $('#qualification_2').show();
                $('#degree2').hide();
                // $('#institution2').hide();
            } else {
                if (how2 == 'HND' || how2 == 'OND' || how2 == 'BACHELOR DEGREE' || how2 == 'NCE' ||
                    how2 == 'HIGH SCHOOL (S.S.C.E)') {
                    $(this).show();
                    $('#degree2').show();

                }

            }

        })

        $('#qualification_3').change(function () {
            var how3 = $(this).val();
            if (how3 == 'MASTERS') {
                $(this).hide();
                $('#qualification_3').show();
                $('#degree3').hide();
                // $('#institution2').hide();
            } else {
                if (how3 == 'HND' || how3 == 'OND' || how3 == 'BACHELOR DEGREE' || how3 == 'NCE' ||
                    how3 == 'HIGH SCHOOL (S.S.C.E)') {
                    $(this).show();
                    $('#degree3').show();
                }
            }
        })
    })

    function changeFunc() {
        var first_qualification = document.getElementById("first_qualification");
        var selectedValue = first_qualification.options[first_qualification.selectedIndex].value;
        if (selectedValue == "FSLC") {   
            flsc = "First School Leaving Certificate";
            // institution
            // $('#first_institution').hide();
            // $('.other-star').hide();
            $('#first_institution').html(flsc);
            // $('#other_first_institution').show();

            // degree          
            // $('#first_degree').hide();
            // $('#first_course').hide();
            // $('#other_first_course').show();
            // $('.other-star').hide();
            $('#other_first_course').val(flsc);

        }

        
        
        if (selectedValue == "other_first_qualification") {
            $('#other_first_qualification').show();
            $('#first_qualification').hide();
            $('#show_qualification_list').show();
        } 
        else {
            $('#other_first_qualification').hide();
            $('#show_qualification_list').hide();
        }
       
    }

    function change_qualification_2() {
        var qualification_2 = document.getElementById("qualification_2");
        var selectedValue = qualification_2.options[qualification_2.selectedIndex].value;
         if (selectedValue == "FSLC") {
          var  flsc = "First School Leaving Certificate";
            // $('#first_institution').val('Hi');              
           
            $('#institution2').val('bike');
        }
        if (selectedValue == "other_qualification_2") {
            $('#other_qualification_2').show();
            $('#qualification_2').hide();
            $('#show_qualification_list2').show();
        } else {
            $('#other_qualification_2').hide();
            $('#show_qualification_list2').hide();
        }
    }

    function change_qualification_3() {
        var qualification_3 = document.getElementById("qualification_3");
        var selectedValue = qualification_3.options[qualification_3.selectedIndex].value;
        if (selectedValue == "other_qualification_3") {
            $('#other_qualification_3').show();
            $('#qualification_3').hide();
            $('#show_qualification_list3').show();
        } else {
            $('#other_qualification_3').hide();
            $('#show_qualification_list3').hide();
        }
    }
    // END OF QUALIFICATION

    // START OF  INSTITUTION 
    function change_first_institution() {
        var first_institution = document.getElementById("first_institution");
        var selectedValue = first_institution.options[first_institution.selectedIndex].value;
        if (selectedValue == "other_first_institution") {
            $('#other_first_institution').show();
            $('#first_institution').hide();
            $('#show_institution_list').show();
        } else {
            $('#other_first_institution').hide();
            $('#show_institution_list').hide();
        }
    }

    function change_institution2() {
        var institution2 = document.getElementById("institution2");
        var selectedValue = institution2.options[institution2.selectedIndex].value;
        if (selectedValue == "other_institution2") {
            $('#other_institution2').show();
            $('#institution2').hide();
            $('#show_institution_list2').show();
        } else {
            $('#other_institution2').hide();
            $('#show_institution_list2').hide();
        }
    }

    function change_institution3() {
        var institution3 = document.getElementById("institution3");
        var selectedValue = institution3.options[institution3.selectedIndex].value;
        if (selectedValue == "other_institution3") {
            $('#other_institution3').show();
            $('#institution3').hide();
            $('#show_institution_list3').show();
        } else {
            $('#other_institution3').hide();
            $('#show_institution_list3').hide();
        }
    }
    // END OF  INSTITUTION 

    // START OF COURSE
    function change_first_course() {
        var first_course = document.getElementById("first_course");
        var selectedValue = first_course.options[first_course.selectedIndex].value;
        if (selectedValue == "other_first_course") {
            $('#other_first_course').show();
            $('#first_course').hide();
            $('#show_course_list').show();
        } else {
            $('#other_first_course').hide();
            $('#show_course_list').hide();
        }
    }

    function change_course2() {
        var course2 = document.getElementById("course2");
        var selectedValue = course2.options[course2.selectedIndex].value;
        if (selectedValue == "other_course2") {
            $('#other_course2').show();
            $('#course2').hide();
            $('#show_course_list2').show();
        } else {
            $('#other_course2').hide();
            $('#show_course_list2').hide();
        }
    }

    function change_course3() {
        var course3 = document.getElementById("course3");
        var selectedValue = course3.options[course3.selectedIndex].value;
        if (selectedValue == "other_course3") {
            $('#other_course3').show();
            $('#course3').hide();
            $('#show_course_list3').show();
        } else {
            $('#other_course3').hide();
            $('#show_course_list3').hide();
        }
    }

    //END of course

    // START OF CERTIFICATE
    function first_cert() {
        var profCert = document.getElementById("profCert");
        var selectedValue = profCert.options[profCert.selectedIndex].value;
        if (selectedValue == "other_cert1") {
            $('#other_cert1').show();
            $('#profCert').hide();
            $('#show_cert_list').show();
        } else {
            $('#other_cert1').hide();
            $('#show_cert_list').hide();
        }
    }

    function second_cert() {
        var profCert2 = document.getElementById("profCert2");
        var selectedValue = profCert2.options[profCert2.selectedIndex].value;
        if (selectedValue == "other_cert2") {
            $('#other_cert2').show();
            $('#profCert2').hide();
            $('#show_cert_list2').show();
        } else {
            $('#other_cert2').hide();
            $('#show_cert_list2').hide();
        }
    }

    function third_cert() {
        var profCert3 = document.getElementById("profCert3");
        var selectedValue = profCert3.options[profCert3.selectedIndex].value;
        if (selectedValue == "other_cert3") {
            $('#other_cert3').show();
            $('#profCert3').hide();
            $('#show_cert_list3').show();
        } else {
            $('#other_cert3').hide();
            $('#show_cert_list3').hide();
        }
    }

    function fourth_cert() {
        var profCert4 = document.getElementById("profCert4");
        var selectedValue = profCert4.options[profCert4.selectedIndex].value;
        if (selectedValue == "other_cert4") {
            $('#other_cert4').show();
            $('#profCert4').hide();
            $('#show_cert_list4').show();
        } else {
            $('#other_cert4').hide();
            $('#show_cert_list4').hide();
        }
    }
    // END OF CERTIFICATE

    // START OF WORK EXPERIENCE
    function first_industry() {
        var industry = document.getElementById("industry");
        var selectedValue = industry.options[industry.selectedIndex].value;
        if (selectedValue == "other_industry1") {
            $('#other_industry1').show();
            $('#industry').hide();
            $('#show_work_exp_list').show();
        } else {
            $('#other_industry1').hide();
            $('#show_work_exp_list').hide();
        }
    }

    function second_industry() {
        var industry2 = document.getElementById("industry2");
        var selectedValue = industry2.options[industry2.selectedIndex].value;
        if (selectedValue == "other_industry2") {
            $('#other_industry2').show();
            $('#industry2').hide();
            $('#show_work_exp_list2').show();
        } else {
            $('#other_industry2').hide();
            $('#show_work_exp_list2').hide();
        }
    }

    function third_industry() {
        var industry3 = document.getElementById("industry3");
        var selectedValue = industry3.options[industry3.selectedIndex].value;
        if (selectedValue == "other_industry3") {
            $('#other_industry3').show();
            $('#industry3').hide();
            $('#show_work_exp_list3').show();
        } else {
            $('#other_industry3').hide();
            $('#show_work_exp_list3').hide();
        }
    }

    function fourth_industry() {
        var prefCat = document.getElementById("prefCat");
        var selectedValue = prefCat.options[prefCat.selectedIndex].value;
        if (selectedValue == "other_industry4") {
            $('#other_industry4').show();
            $('#prefCat').hide();
            $('#show_pref_list').show();
        } else {
            $('#other_industry4').hide();
            $('#show_pref_list').hide();
        }
    }
    //

    (function () {
        'use strict'
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var msViewportStyle = document.createElement('style')
            msViewportStyle.appendChild(
                document.createTextNode(
                    '@-ms-viewport{width:auto!important}'
                )
            )
            document.head.appendChild(msViewportStyle)
        }
    }())

    $(function () {
        $("#newLoc").hide();
        $("#state_residence").change(function () {

            var id = $('select#state_residence option:selected').val();
            $.ajax({
                type: "POST",
                url: "getstate.php",
                data: {
                    state: id
                },
                success: function (response) {
                    $("#stateAjax").html(response);
                    $("#stateAjax").show();
                    $("#newLoc").show();
                    $("#oldLoc").hide();
                }
            });
        });
    });
</script>