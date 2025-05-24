@extends('layout.master')
@section('title')
    | Update Teacher
@endsection
@section('active-teacher-list')
    active
@endsection
@section('app-title')
    Teachers
@endsection
@section('content')
    <form id="updateForm" class="card">
        <div class="card-body">
            <div id="show-msg"></div>
            <div class="row">
                <div class="col-lg-3 my-body mg-b-20 mg-lr-20" style="display: block;">
                    <p class="text-bold text-center">
                        <span id="user-position" class="text-danger" style="text-decoration: underline;">TEACHER</span>
                    </p>
                    <img src="{{ asset('dist/img/avatar4.png') }}" alt="Avatar Image" style="350px; width: 100%"
                        id="user_picture">
                    <hr>
                    <div class="form-group">
                        <label>Teacher ID: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="teacher_id" name="teacher_id"
                            value="{{ $teacher_id }}" required readonly>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-lg btn-block" id="pictureBtn"><i
                                class="fa fa-image"></i> PICTURE</button>
                    </div>
                </div>
                <div class="col-lg-9 my-body mg-lr-20">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label>First Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label>Middle Name: <span class="text-danger"></span></label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label>Last Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label>Extension Name: <span class="text-danger"></span></label>
                                <input type="text" class="form-control" id="extension_name" name="extension_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>Gender: <span class="text-danger">*</span></label>
                                <select class="form-control" id="sex" name="sex" required="true">
                                    <option selected="true" value="REQUIRED">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>Birthday: <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="birthday" name="birthday" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>Civil Status: <span class="text-danger">*</span></label>
                                <select class="form-control" id="civil_status" name="civil_status" required="true">
                                    <option selected="true" value="REQUIRED">-- Select Civil Status --</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Annulled">Annulled</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>Religion: <span class="text-danger">*</span></label>
                                <select required="true" class="form-control" id="religion" name="religion">
                                    <option selected="true" value="REQUIRED">-- Select Religion --</option>
                                    <option value="None">None</option>
                                    <option value="Roman Catholic">Roman Catholic </option>
                                    <option value="Seventh-Day Adventist">Seventh-Day Adventist</option>
                                    <option value="Eglesia ni Cristo">Eglesia ni Cristo</option>
                                    <option value="Jehovah Witnesses">Jehovah Witnesses</option>
                                    <option value="Pentecostal">Pentecostal</option>
                                    <option value="Church of Christ">Church of Christ</option>
                                    <option value="Christian"> Christian</option>
                                    <option value="Baptist">Baptist</option>
                                    <option value="God is Able"> God is Able</option>
                                    <option value="UCCP">UCCP</option>
                                    <option value="Church of God"> Church of God</option>
                                    <option value="Dating Daan"> Dating Daan</option>
                                    <option value="Jesus is Miracle "> Jesus is Miracle</option>
                                    <option value="Rizal">Rizal</option>
                                    <option value="Robin">Robin</option>
                                    <option value="JMCIM">JMCIM </option>
                                    <option value="Mormons">Mormons</option>
                                    <option value="Magtotoo">Magtotoo</option>
                                    <option value="Protestant">Protestant</option>
                                    <option value="Born Again">Born Again</option>
                                    <option value="Assemblies of God ">Assemblies of God</option>
                                    <option value="Iglesia Filipina Independiente">Iglesia Filipina Independiente</option>
                                    <option value="Muslim">Muslim</option>
                                    <option value="Iglesia Ni Cristo">Iglesia Ni Cristo</option>
                                    <option value="Jerusalem">Jerusalem</option>
                                    <option value="Foursquare">Foursquare</option>
                                    <option value="United Church of God">United Church of God</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>Contact: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="contact" name="contact"
                                    data-mask="(+63) 999-999-9999" placeholder="(+63)" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>Email address: <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="province_code">Province: <span style="color:red;">*</span></label>
                                <select class="form-control" id="province_code" name="province_code" required>
                                    <option selected="true" value="REQUIRED" disabled>-- Select Province --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="municipality_code">Municipality: <span style="color:red;">*</span></label>
                                <select class="form-control" id="municipality_code" name="municipality_code"
                                    required="true">
                                    <option selected="true" value="REQUIRED" disabled>-- Select Municipality --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="brgy_code">Barangay: <span style="color:red;">*</span></label>
                                <select class="form-control" id="brgy_code" name="brgy_code" required="true">
                                    <option selected="true" value="REQUIRED" disabled>-- Select Barangay --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label>Zip code: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" required
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary btn-lg">SAVE</button>
            <a href="{{ route('viewTeachers') }}" type="button" class="btn btn-danger btn-lg">CANCEL</a>
        </div>
    </form>
    <div class="modal fade" id="updatePicture">
        <div class="modal-dialog">
            <form id="updatePictureForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Picture</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="attachment">Upload Picture: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="attachment" name="attachment" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-lg btn-primary">SAVE</button>
                    <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">CANCEL</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        let selectedMunicipality, selectedBrgy, originalContactNumber, originalEmail;

        $(document).ready(function() {

            $('#updateForm').trigger('reset');
            $('#updateForm').find('input').attr('disabled', true);
            $('#updateForm').find('select').attr('disabled', true);
            $('#updateForm').find('button').attr('disabled', true);
            $('select').trigger('chosen:updated');

            function findZipCode(municipalityCode) {
                $.ajax({
                    method: 'GET',
                    url: `/address/getZipCode/${municipalityCode}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        $('#zip_code').val(data.zip_code);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });
            }

            $.ajax({
                method: 'GET',
                url: '/address/getProvinces/8',
                dataType: 'JSON',
                cache: false,
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        $('#province_code').append('<option value="' + data[i].province_code +
                            '">' + data[i].province_name + '</option>');
                    }
                    $('#province_code').trigger('chosen:updated');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.'
                    });
                }
            })

            $('#province_code').change(function() {
                var provinceCode = $('#province_code').val();

                $('#municipality_code').empty();
                $('#municipality_code').append(
                    '<option selected="true" value="NONE">-- Select Municipality --</option>');

                $.ajax({
                    method: 'GET',
                    url: `/address/getMunicipalities/${provinceCode}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            if (selectedMunicipality !== data[i].municipality_code) {
                                $('#municipality_code').append('<option value="' + data[i]
                                    .municipality_code + '">' + data[i].municipality_name +
                                    '</option>');
                            } else {
                                $('#municipality_code').append('<option value="' + data[i]
                                    .municipality_code + '" selected>' + data[i]
                                    .municipality_name +
                                    '</option>');
                            }

                        }
                        $('#municipality_code').trigger('chosen:updated');
                        $('#municipality_code').change();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });
            });

            $('#municipality_code').change(function() {
                var municipalityCode = $('#municipality_code').val();

                $('#brgy_code').empty();
                $('#brgy_code').append(
                    '<option selected="true" value="NONE">-- Select Barangay --</option>');

                $.ajax({
                    method: 'GET',
                    url: `/address/getBrgys/${municipalityCode}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            if (selectedBrgy !== data[i].brgy_code) {
                                $('#brgy_code').append('<option value="' + data[i].brgy_code +
                                    '">' + data[i].brgy_name + '</option>');
                            } else {
                                $('#brgy_code').append('<option value="' + data[i].brgy_code +
                                    '" selected>' + data[i].brgy_name + '</option>');
                            }
                        }
                        $('#brgy_code').trigger('chosen:updated');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });

                findZipCode(municipalityCode);
            });

            let teacher_id = $('#teacher_id').val();

            $.ajax({
                method: 'GET',
                url: `/teachers/${teacher_id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response) {
                        $('#first_name').val(response.first_name);
                        $('#middle_name').val(response.middle_name);
                        $('#last_name').val(response.last_name);
                        $('#extension_name').val(response.extension_name);
                        $('#sex').val(response.sex);
                        $('#birthday').val(response.birthday);
                        $('#civil_status').val(response.civil_status);
                        $('#religion').val(response.religion);
                        $('#contact').val(response.contact);
                        $('#email').val(response.email);
                        $('#user_picture').attr("src", response.image);

                        selectedBrgy = response.brgy_code;
                        selectedMunicipality = response.municipality_code;

                        $('#province_code').val(response.province_code);

                        $('#updateForm').find('input').removeAttr('disabled');
                        $('#updateForm').find('select').removeAttr('disabled');
                        $('#updateForm').find('button').removeAttr('disabled');
                        $('select').trigger('chosen:updated');
                        $('#province_code').change();

                        originalContactNumber = response.contact;
                        originalEmail = response.email;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.'
                    });
                }
            });

            $('#pictureBtn').click(function() {
                $('#updatePicture').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            });

            $('#updatePictureForm').submit(function(event) {
                event.preventDefault();

                $('#show-msg').html('');
                const requiredFields = $(this).find('input[required], select[required]');

                let isEmptyField = false;
                requiredFields.each(function() {
                    if ($(this).val() === '' || $(this).val() === 'REQUIRED') {
                        isEmptyField = true;
                    }
                });

                if (isEmptyField) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Some fields are empty'
                    });
                } else {
                    $('#updatePictureForm').find('button[type=submit]').attr('disabled', true);
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'SAVE',
                        cancelButtonText: 'CANCEL',
                        reverseButtons: false,
                        allowOutsideClick: false,
                        showClass: {
                            popup: 'animated fadeInDown'
                        },
                        hideClass: {
                            popup: 'animated fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var formData = new FormData($('#updatePictureForm')[0]);

                            $.ajax({
                                method: 'POST',
                                url: `/teachers/updateImage/${teacher_id}`,
                                data: formData,
                                dataType: 'JSON',
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.valid == true) {
                                        $('html, body').animate({
                                            scrollTop: 0
                                        }, 800);
                                        $('#show-msg').html(
                                            '<div class="alert alert-success">' +
                                            response.msg + '<div>');

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                        $('#updatePicture').modal('hide');
                                        $('#user_picture').attr("src", response.image);
                                    } else {
                                        $('#show-msg').html(
                                            '<div class="alert alert-danger">' +
                                            response.msg + '<div>');

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    if (jqXHR.responseJSON && jqXHR.responseJSON
                                        .error) {
                                        var errors = jqXHR.responseJSON.error;
                                        var errorMsg = "Error submitting data: " +
                                            errors + ". ";
                                        $('#show-msg').html(
                                            '<div class="alert alert-danger">' +
                                            errorMsg + '</div>');

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong! Please try again later.'
                                        });
                                    }
                                }
                            });
                        }
                        $('#updatePictureForm').find('button[type=submit]').removeAttr('disabled');
                    });
                }
            });

            $("#updateForm").validate({
                rules: {
                    teacher_id: {
                        required: true
                    },
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    sex: {
                        required: true,
                        notEqualTo: "REQUIRED" // Ensures "Select Gender" is not chosen
                    },
                    birthday: {
                        required: true,
                        date: true
                    },
                    civil_status: {
                        required: true,
                        notEqualTo: "REQUIRED" // Ensures "Select Civil Status" is not chosen
                    },
                    religion: {
                        required: true,
                        notEqualTo: "REQUIRED" // Ensures "Select Religion" is not chosen
                    },
                    contact: {
                        required: true,
                        uniqueContactNumber: true
                    },
                    email: {
                        required: true,
                        email: true,
                        uniqueEmail: true
                    },
                    province_code: {
                        required: true,
                        notEqualTo: "REQUIRED"
                    },
                    municipality_code: {
                        required: true,
                        notEqualTo: "REQUIRED"
                    },
                    brgy_code: {
                        required: true,
                        notEqualTo: "REQUIRED"
                    }
                },
                messages: {
                    teacher_id: {
                        required: "Teacher ID is required."
                    },
                    firstname: {
                        required: "First Name is required."
                    },
                    lastname: {
                        required: "Last Name is required."
                    },
                    sex: {
                        required: "Gender is required.",
                        notEqualTo: "Please select a valid gender."
                    },
                    birthday: {
                        required: "Birthday is required.",
                        date: "Please enter a valid date."
                    },
                    civil_status: {
                        required: "Civil Status is required.",
                        notEqualTo: "Please select a valid civil status."
                    },
                    religion: {
                        required: "Religion is required.",
                        notEqualTo: "Please select a valid religion."
                    },
                    contact: {
                        required: "Contact is required.",
                    },
                    email: {
                        required: "Email address is required.",
                        email: "Please enter a valid email address.",
                    },
                    province_code: {
                        required: "Province is required.",
                        notEqualTo: "Please select a valid province."
                    },
                    municipality_code: {
                        required: "Municipality is required.",
                        notEqualTo: "Please select a valid municipality."
                    },
                    brgy_code: {
                        required: "Barangay is required.",
                        notEqualTo: "Please select a valid barangay."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            // Custom method for unique contact number validation on update form
            $.validator.addMethod("uniqueContactNumber", function(value, element) {
                if (value === originalContactNumber) return true; // Skip if unchanged
                let response = false;
                $.ajax({
                    url: "{{ route('checkContact') }}",
                    type: "POST",
                    data: {
                        contact: value
                    },
                    async: false, // Synchronous to wait for the response
                    success: function(data) {
                        response = data; // Use the direct response (true/false)
                    }
                });
                return response;
            }, "The contact number has already been taken.");

            $.validator.addMethod("uniqueEmail", function(value, element) {
                // Skip validation if email hasn't changed
                if (value === originalEmail) return true;
                let response = false;
                $.ajax({
                    url: "{{ route('checkEmail') }}",
                    type: "POST",
                    data: {
                        email: value
                    },
                    async: false,
                    success: function(data) {
                        response = data; // true if email is unique, false if taken
                    }
                });
                return response;
            }, "The email address has already been taken.");

            // Custom method for select fields to check "REQUIRED"
            $.validator.addMethod("notEqualTo", function(value, element, param) {
                return this.optional(element) || value !== param;
            }, "Please select a valid option.");

            $("#updateForm").submit(function(event) {
                /* Prevent page from reloading */
                event.preventDefault();

                $('#show-msg').html('');
                const requiredFields = $(this).find('input[required], select[required]');
                let isEmptyField = false;
                requiredFields.each(function() {
                    if ($(this).val() === '' || $(this).val() === 'REQUIRED') {
                        isEmptyField = true;
                    }
                });

                if (isEmptyField) {
                    $('#show-msg').html('<div class="alert alert-danger">Some fields are empty<div>');

                    // Remove the notification after 5 seconds (5000 milliseconds)
                    setTimeout(function() {
                        $('#show-msg').html(
                            ''); // Clears the notification
                    }, 5000); // 5000 milliseconds = 5 seconds

                    return;
                }

                if ($("#updateForm").valid()) {

                    $('#updateForm').find('button[type=submit]').attr('disabled', true);
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'SUBMIT',
                        cancelButtonText: 'CANCEL',
                        reverseButtons: false,
                        allowOutsideClick: false,
                        showClass: {
                            popup: 'animated fadeInDown'
                        },
                        hideClass: {
                            popup: 'animated fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'PUT',
                                url: `/teachers/${teacher_id}`,
                                data: $('#updateForm').serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    if (response.valid == true) {
                                        $('html, body').animate({
                                            scrollTop: 0
                                        }, 800);
                                        $('#show-msg').html(
                                            '<div class="alert alert-success">' +
                                            response.msg + '<div>');

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                        $('#updateForm').trigger('reset');
                                        refresh_table();
                                    } else {
                                        $('#show-msg').html(
                                            '<div class="alert alert-danger">' +
                                            response.msg + '<div>');

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    if (jqXHR.responseJSON && jqXHR.responseJSON
                                        .error) {
                                        var errors = jqXHR.responseJSON.error;
                                        var errorMsg = "Error submitting data: " +
                                            errors + ". ";
                                        $('#show-msg').html(
                                            '<div class="alert alert-danger">' +
                                            errorMsg + '</div>');

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong! Please try again later.'
                                        });
                                    }
                                }
                            });
                        }
                        $('#updateForm').find('button[type=submit]').removeAttr('disabled');
                    });
                }
            });

        });
    </script>
@endsection
