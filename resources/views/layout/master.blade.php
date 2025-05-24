<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="School Name Student Portal">
    <meta name="keywords" content="School Name, Student Portal, student portal, abuyog">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} @yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('dist/img/PNHS_Logo.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ion Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/ionicons/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('data-table/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('data-table/bootstrap-table-filter-control.css') }}">
    <link rel="stylesheet" href="{{ asset('data-table/bootstrap-table-sticky-header.css') }}">
    <!-- Fileinput -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-fileinput/css/fileinput.css') }}">
    <!-- Fileinput -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('dist/css/animate.css') }}">
    <!-- Choosen -->
    <link rel="stylesheet" href="{{ asset('plugins/choosen/css/bootstrap-chosen.css') }}">
    <!-- ChartJS -->
    <link rel="stylesheet" href="{{ asset('plugins/chart.js/Chart.css') }}">
    <!-- touchspin -->
    <link rel="stylesheet" href="{{ asset('plugins/touchspin/css/jquery.bootstrap-touchspin.min.css') }}">
    <!-- x-editor CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('dist/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/x-editor-style.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Include X-editable CSS and JS -->
    <style style="text/css">
        .form-control {
            border: 1px solid purple;
        }

        .nav-link i {
            transition: color 0.3s ease;
        }

        .nav-link:hover i {
            color: #ffcc00;
            /* Change icon color on hover */
        }

        /* CSS for readonly-like dropdowns */
        select[data-readonly="true"] {
            pointer-events: none;
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
    </style>
    @yield('custom-css')
</head>

<body class="hold-transition sidebar-mini layout-footer-fixed accent-orange">
    <div class="wrapper">

        @include('layout.top')

        @include('layout.left')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('app-title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/view_dashboard">Home</a></li>
                                <li class="breadcrumb-item active">@yield('app-title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>
            </section>
        </div>

        @include('layout.footer')
    </div>
    <!-- ./wrapper -->

    <div id="updatePassword" class="modal fade">
        <div class="modal-dialog">
            <form id="changePassForm" class="modal-content text-left">
                <div class="modal-header">
                    <h3 class="modal-title">Update Password</h3>
                </div>
                <div class="modal-body">
                    <div id="error-add-msg" class="text-left"></div>
                    <div id="pwd-container">
                        <div class="form-group">
                            <label for="password1">Password: <span class="text-danger">*</span></label>
                            <input type="password" class="form-control password" id="password" name="password"
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" id="cpassword" name="cpassword" class="form-control"
                            placeholder="Confirm Password">
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

    <div id="settingsModal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <form id="settingsForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Change School Years</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="school_year">School Year</label>
                        <select name="school_year" id="school_year" class="form-control">
                            @if (Session::has('schoolYearList'))
                                @foreach (Session::get('schoolYearList') as $school_year)
                                    <option value="{{ $school_year->school_year }}"
                                        {{ session('school_year') == $school_year->school_year ? 'selected' : '' }}>
                                        {{ $school_year->school_year }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-save"></i>
                        Change</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-md"><i
                            class="fa fa-times"></i>
                        Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('data-table/bootstrap-table.js') }}"></script>
    {{-- <script src="{{ asset('data-table/bootstrap-table-auto-refresh.js') }}"></script> --}}
    <script src="{{ asset('data-table/bootstrap-table-cookie.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-copy-rows.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-defer-url.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-export.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-filter-control.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-key-events.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-mobile.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-print.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-sticky-header.js') }}"></script>
    <script src="{{ asset('data-table/bootstrap-table-toolbar.js') }}"></script>
    <script src="{{ asset('data-table/tableExport.js') }}"></script>
    <script src="{{ asset('data-table/utils.js') }}"></script>
    <!-- Fileinput -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- input-mask -->
    <script src="{{ asset('plugins/input-mask/jasny-bootstrap.min.js') }}"></script>
    <!-- Fileinput -->
    <script src="{{ asset('plugins/bootstrap-fileinput/js/fileinput.js') }}"></script>
    <!-- Choosen -->
    <script src="{{ asset('plugins/choosen/js/chosen.jquery.js') }}"></script>
    <!-- Validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.js') }}"></script>
    <!-- Touchspin -->
    <script src="{{ asset('plugins/touchspin/js/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!--  editable JS
		============================================ -->
    <script src="{{ asset('dist/js/jquery.mockjax.js') }}"></script>
    <script src="{{ asset('dist/js/mock-active.js') }}"></script>
    <script src="{{ asset('dist/js/select2.js') }}"></script>
    <script src="{{ asset('dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-editable.js') }}"></script>
    <script src="{{ asset('dist/js/xediable-active.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script type="text/javascript">
        function refresh_table() {
            var $table = $('#table');
            $table.bootstrapTable('destroy').bootstrapTable({
                autoRefresh: true
            });
        }

        function myCustomPrint(table, title) {
            return "\n  <html>\n  <head>\n  <title></title>\n  <style type=\"text/css\" media=\"print\">\n  @page {\n  size: auto;\n  margin: 25px 25px 25px 25px;\n  }\n  </style>\n  <style type=\"text/css\" media=\"all\">\n  body {\n  font-family: Arial, sans-serif;\n  margin: 0;\n  padding: 0;\n  }\n  p, h3 {\n  margin: 1px;\n  }\n  .container {\n  display: flex;\n  flex-direction: column;\n  align-items: center;\n  }\n  .header {\n  display: flex;\n  justify-content: space-between;\n  width: 100%;\n  padding: 10px;\n  }\n  .title {\n  text-align: center;\n  }\n  .content {\n  display: flex;\n  justify-content: space-between;\n  padding: 20px;\n  }\n  .info {\n  background-color: #eee;\n  padding: 10px;\n  }\n  table {\n  border-collapse: collapse;\n  font-size: 12px;\n  }\n  table, td, th {\n  border: 1px solid grey;\n  }\n  table th {\n  border-bottom: 6px solid grey;\n  }\n  td:first-child {\n  padding-top: 15px;\n  }\n  th, td {\n  text-align: center;\n  vertical-align: middle;\n  }\n  table {\n  width:94%;\n  margin-top: 20px;\n  margin-left:3%;\n  margin-right:3%;\n  }\n  table-header {\n  width:94%;\n  margin-left:3%;\n  margin-right:3%;\n border: none;\n  }\n  div.bs-table-print {\n  text-align:center;\n  padding-top:20px;\n  }\n  </style>\n  </head>\n  <body>\n  <div class=\"container\">\n  <div class=\"header\">\n  <div class=\"logo\"><img src=\"{{ asset('dist/img/PNHS_Logo.png') }}\" style=\"height: 150px; width: 150px\"></div>\n  <div class=\"title\">\n  <h3>PALALE NATIONAL HIGH SCHOOL</h3>\n  <h3>ATTENDANCE SYSTEM</h3>\n  <p>BRGY. PALALE</p>\n  <p>MAC ARTHUR, LEYTE</p>\n  <p><b>" +
                title +
                "</b></p>\n  </div>\n  <div class=\"logo\"><img src=\"{{ asset('dist/img/PNHS_Logo.png') }}\" style=\"height: 150px; width: 150px\"></div>\n  </div>\n  </div>\n  <div class=\"bs-table-print\">\n  <table id=\"table-header\" style=\"border: none;\">\n  <thead>\n  <tr>\n  <th style=\"text-align: left; width: 70px; border: none;\"></th>\n  <th style=\"text-align: left; width: 350px; border: none;\">"
                .concat("",
                    "</th>\n  <th style=\"text-align: left; width: 150px; border: none;\"></th>\n  <th style=\"text-align: left; border: none;\">"
                ).concat("",
                    "</th>\n  </tr>\n  <tr>\n  <th style=\"text-align: left; width: 70px; border: none;\"></th>\n  <th style=\"text-align: left; border: none;\">"
                ).concat("",
                    "</th>\n  <th style=\"text-align: left; width: 150px; border: none;\"></th>\n  <th style=\"text-align: left; border: none;\">"
                ).concat("", "</th>\n  </tr>\n  </thead>\n  </table>").concat(table, "</div>\n  </body>\n  </html>");
        }

        $(document).ready(function() {

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $('#homeaddress_province').chosen({
                width: "100%"
            });

            $('#homeaddress_municipality').chosen({
                width: "100%"
            });

            $('#homeaddress_brgy').chosen({
                width: "100%"
            });

            $('#religion').chosen({
                width: "100%"
            });

            $('#disability').chosen({
                width: "100%"
            });

            $('#civil_status').chosen({
                width: "100%"
            });

            $("select").chosen({
                width: "100%"
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#attachment").fileinput({
                showCancel: false,
                showUpload: false,
                showRemove: false,
                browseClass: "btn btn-primary",
                defaultPreviewContent: '<img src="{{ asset('dist/img/avatar4.png') }}" alt="Upload" id="preview-attachment" class="img img-responsive" style="left-margin:auto; max-width:auto">',
                allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
            });

            $('#logout').click(function(event) {
                event.preventDefault();

                $.ajax({
                    method: 'POST',
                    url: '{{ route('logout') }}',
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        if (response.valid === true) {
                            window.location.reload();
                        } else {
                            Swal.fire('Error', response.msg, 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire('Error',
                            'Something went wrong. Please try again later.',
                            'error');
                    }
                });
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
                    element.closest('.form-group').append(error);
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
                    Swal.fire({
                        title: 'Are you sure you want to update password?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'PUT',
                                url: `/passwordChange/${userID}`,
                                data: $('#changePassForm').serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    if (response.valid) {
                                        refresh_table();
                                        $('#changePassForm')[0].reset();
                                        $('#show-msg').html(
                                            '<div class="alert alert-success">' +
                                            response.msg + '<div>');
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
                    });
                }
                $('#changePassForm').find('button[type=submit]').removeAttr('disabled');
            });

            $('#settingsForm').submit(function(event) {
                event.preventDefault();
                $('#settingsForm').find('button[type=submit]').attr('disabled', true);

                if ($('#settingsForm').valid()) {
                    $('#settingsModal').modal('hide');
                    Swal.fire({
                        title: 'Are you sure you want to change school year?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'PUT',
                                url: `/changeSchoolYear/${$('#settingsForm').find('select[id=school_year]').val()}`,
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    if (response.valid) {
                                        $('#show-msg').html(
                                            '<div class="alert alert-success">' +
                                            response.msg + '<div>');
                                        window.location.href = '/';
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
                    });
                }

                $('#settingsForm').find('button[type=submit]').removeAttr('disabled');
            });

        });
    </script>
    @yield('scripts')

    @if (Session::get('role') === 'principal')
    @endif
</body>

</html>
