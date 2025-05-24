@extends('layout.master')
@section('title')
    | Add Teacher
@endsection
@section('active-teacher-list')
    active
@endsection
@section('app-title')
    Add Teacher
@endsection
@section('content')
    <form id="addForm" class="card">
        <div class="card-body">
            <div id="show-msg"></div>
            <div class="row">
                <div class="col-lg-3 col-sm-12">
                    <div class="form-group">
                        <label>Teacher ID: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="teacher_id" name="teacher_id"
                            value="{{ $teacherID }}" required>
                    </div>
                </div>
            </div>
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
                        <select class="form-control" id="municipality_code" name="municipality_code" required="true">
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
                        <input type="text" class="form-control" id="zip_code" name="zip_code" required readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary btn-lg">SAVE</button>
            <a href="{{ route('viewTeachers') }}" type="button" class="btn btn-danger btn-lg">CANCEL</a>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript">
        function add_another() {
            $('#addForm').trigger('reset');
            Swal.fire({
                title: 'Do you want to another?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'PROCEED',
                cancelButtonText: 'CANCEL',
                reverseButtons: true,
                allowOutsideClick: false,
                showClass: {
                    popup: 'animated fadeInDown'
                },
                hideClass: {
                    popup: 'animated fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#addData').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                } else {
                    window.location.href = '{{ route('viewTeachers') }}';
                }
            });
        }

        $(document).ready(function() {

            $('#addForm').trigger('reset');
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
                            $('#municipality_code').append('<option value="' + data[i]
                                .municipality_code + '">' + data[i].municipality_name +
                                '</option>');
                        }
                        $('#municipality_code').trigger('chosen:updated');
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
                            $('#brgy_code').append('<option value="' + data[i].brgy_code +
                                '">' + data[i].brgy_name + '</option>');
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

            $("#addForm").validate({
                rules: {
                    teacher_id: {
                        required: true,
                        remote: {
                            url: "{{ route('checkUsername') }}",
                            type: "POST",
                            data: {
                                username: function() {
                                    return $('#addForm').find('input[id=teacher_id]').val();
                                }
                            }
                        }
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
                        remote: {
                            url: "{{ route('checkContact') }}",
                            type: "POST",
                            data: {
                                contact: function() {
                                    return $('#addForm').find('input[id=contact]').val();
                                }
                            }
                        }
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ route('checkEmail') }}",
                            type: "POST",
                            data: {
                                email: function() {
                                    return $('#addForm').find('input[id=email]').val();
                                }
                            }
                        }
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
                        required: "Teacher ID is required.",
                        remote: "Teacher ID has already been taken."
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
                        remote: "This contact number has already been taken."
                    },
                    email: {
                        required: "Email address is required.",
                        email: "Please enter a valid email address.",
                        remote: "The email address has already been taken."
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

            // Custom method for select fields to check "REQUIRED"
            $.validator.addMethod("notEqualTo", function(value, element, param) {
                return this.optional(element) || value !== param;
            }, "Please select a valid option.");

            $("#addForm").submit(function(event) {
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

                if ($("#addForm").valid()) {

                    $('#addForm').find('button[type=submit]').attr('disabled', true);
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
                                method: 'POST',
                                url: '/teachers/',
                                data: $('#addForm').serialize(),
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

                                        $('#addForm').trigger('reset');
                                        refresh_table();
                                        add_another();
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
                        $('#addForm').find('button[type=submit]').removeAttr('disabled');
                    });
                }
            });

        });
    </script>
@endsection
