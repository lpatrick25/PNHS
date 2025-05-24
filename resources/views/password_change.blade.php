<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Session::get('user_id') }}">
    <meta name="description" content="Palale National High School Attendance System">
    <meta name="keywords" content="Palale National High School, Attendance Portal, student attendance, palale">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Password - {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('dist/img/PNHS_Logo.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style type="text/css">
        body {
            background-image: url('{{ asset('dist/img/main_bg.jpg') }}');
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .login-box {
            width: 550px;
        }

        .login-logo {
            margin: 0 !important;
        }
    </style>
</head>
</head>

<body class="hold-transition login-page">

    <div id="updatePassword" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="changePassForm" class="modal-content text-left">
                <div class="modal-header">
                    <h3 class="modal-title">Update Password</h3>
                </div>
                <div class="modal-body">
                    <div id="show-msg" class="text-left"></div>
                    <div class="form-group">
                        <label for="password1">Password: <span class="text-danger">*</span></label>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control password" id="password" name="password"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="show-password"></span>
                            </div>
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="cpassword">Confirm Password <span class="text-danger">*</span></label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="cpassword" name="cpassword" class="form-control"
                            placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="show-password1"></span>
                            </div>
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-custon-rounded-three btn-primary btn-md"><i
                            class="fa fa-paper-plane"></i> Submit</button>
                    <button type="button" data-dismiss="modal" class="btn btn-custon-rounded-three btn-danger btn-md"
                        href="#"><i class="fa fa-times"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Fileinput -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- Validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script type="text/javascript">
        var userID;

        function update(user_id) {
            userID = user_id;
            $('#changePassForm')[0].reset();
            $('#updatePassword').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            Swal.fire({
                icon: 'warning',
                title: 'Default Password Detected',
                text: 'You are using the default password. It is highly recommended to change your password for better security.',
                confirmButtonText: 'Update Now',
                cancelButtonText: 'Later',
                allowOutsideClick: false,
            }).then((result) => {
                update($('meta[name="user-id"]').attr('content')); // Trigger the update function
            });

            $('#show-password').click(function() {
                var inputType = $('#changePassForm').find('input[id=password]').attr('type');
                if (inputType === 'password') {
                    $(this).attr('class', 'fa fa-eye-slash');

                    $('#changePassForm').find('input[id=password]').attr('type', 'text');
                } else {
                    $(this).attr('class', 'fa fa-eye');
                    $('#changePassForm').find('input[id=password]').attr('type', 'password');
                }
            });

            $('#show-password1').click(function() {
                var inputType = $('#changePassForm').find('input[id=cpassword]').attr('type');
                if (inputType === 'password') {
                    $(this).attr('class', 'fa fa-eye-slash');

                    $('#changePassForm').find('input[id=cpassword]').attr('type', 'text');
                } else {
                    $(this).attr('class', 'fa fa-eye');
                    $('#changePassForm').find('input[id=cpassword]').attr('type', 'password');
                }
            });

            // Add regex validation method
            $.validator.addMethod("regex", function(value, element, regexpr) {
                return regexpr.test(value);
            }, "Please enter a valid format.");

            // Validation for #changePassForm
            $('#changePassForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8,
                        regex: /^(?=.*[A-Z])(?=.*[0-9]).+$/
                    },
                    cpassword: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    password: {
                        regex: "The password must contain at least one uppercase letter and one number."
                    },
                    cpassword: {
                        equalTo: "The password confirmation does not match."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#changePassForm').submit(function(event) {
                event.preventDefault();
                $('#changePassForm').find('button[type=submit]').attr('disabled', true);
                if ($('#changePassForm').valid()) {
                    $('#updatePassword').modal('hide');
                    $.ajax({
                        method: 'PUT',
                        url: `/passwordChange/${userID}`,
                        data: $('#changePassForm').serialize(),
                        dataType: 'JSON',
                        cache: false,
                        success: function(response) {
                            if (response.valid) {
                                $('#changePassForm')[0].reset();
                                $('#show-msg').html(
                                    '<div class="alert alert-success">' +
                                    response.msg + '<div>');
                                window.location.href = '{{ route('viewDashboardTeacher') }}';
                            } else {
                                $('#show-msg').html(
                                    '<div class="alert alert-danger">' +
                                    response.msg + '<div>');
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
                $('#changePassForm').find('button[type=submit]').removeAttr('disabled');
            });

        });
    </script>
</body>

</html>
