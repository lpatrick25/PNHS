<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Palale National High School Attendance System">
    <meta name="keywords" content="Palale National High School, Attendance Portal, student attendance, palale">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Portal - {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('dist/img/PNHS_Logo.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <style type="text/css">
        body {
            background-image: url('dist/img/main_bg.jpg');
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
    <div class="login-box">
        <div class="card card-outline card-success">
            <div class="card-header text-center" style="border: none;">
                <img src="dist/img/header.png" class="login-logo" style="margin: 0px; width: 100%; height: 150px;"
                    id="login-header">
                <p href="index.php" class="h3 text-bold text-success mt-5">LOGIN PORTAL</p>
            </div>
            <div class="card-body">
                <form id="quickForm" method="post">
                    <div id="error-msg"></div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" id="username"
                            placeholder="Student ID | Employee ID | Instructor ID" autocomplete="false">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Password" autocomplete="false">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="show-password"></span>
                            </div>
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-block">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="updateData" class="modal animated fade">
        <div class="modal-dialog">
            <form id="updateDataForm" class="modal-content">
                <input type="hidden" class="form-control" id="emailTxt" name="emailTxt" required>
                <div class="modal-header">
                    <h3 class="modal-title">Update Password</h3>
                </div>
                <div class="modal-body">
                    <div id="display-msg"></div>
                    <div class="form-group">
                        <label for="password">Password: <span class="text-danger">*</span></label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm Password: <span class="text-danger">*</span></label>
                        <input type="password" id="cpassword" name="cpassword" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-save"> SAVE</i></button>
                    <button type="button" data-dismiss="modal" class="btn btn-lg btn-danger"><i class="fa fa-times">
                            CANCEL</i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Fileinput -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- Validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#quickForm').trigger('reset');

            $('#show-password').click(function() {
                var inputType = $('#quickForm').find('input[id=password]').attr('type');
                if (inputType === 'password') {
                    $(this).attr('class', 'fa fa-eye-slash');

                    $('#quickForm').find('input[id=password]').attr('type', 'text');
                } else {
                    $(this).attr('class', 'fa fa-eye');
                    $('#quickForm').find('input[id=password]').attr('type', 'password');
                }
            });

            $('#quickForm').submit(function(event) {
                //Prevent page from reloading
                event.preventDefault();

                $(this).find('#error-msg').html('');

                var form_data = {
                    username: $('#quickForm').find('input[id=username]').val(),
                    password: $('#quickForm').find('input[id=password]').val(),
                };

                // Client-side validation
                if (form_data.username === '' || form_data.password === '') {
                    $('#error-msg').html(
                        '<p class="alert alert-danger">Please fill in both username and password.</p>');
                    return;
                }

                $('#quickForm').find('button[type=submit]').attr('disabled', true);

                // AJAX request
                $.ajax({
                    method: 'POST',
                    url: '{{ route('login') }}',
                    data: $('#quickForm').serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        if (response.valid) {
                            window.location.href = '{{ route('viewDashboardAdmin') }}';
                        } else {
                            $('#error-msg').html(
                                '<p class="alert alert-danger">' + response
                                .msg + '</p>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#error-msg').html(
                            '<p class="alert alert-danger">Something went wrong. Please try again later.</p>'
                        );
                    }
                });
                $('#quickForm').find('button[type=submit]').removeAttr('disabled');
            });

        });
    </script>
</body>

</html>
