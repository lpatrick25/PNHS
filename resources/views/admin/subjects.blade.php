@extends('layout.master')
@section('title')
    | Subjects
@endsection
@section('active-subject')
    active
@endsection
@section('app-title')
    Subjects
@endsection
@section('content')
    <div id="show-msg"></div>
    <div id="toolbar">
        <button type="button" class="btn btn-primary btn-md" id="add-btn"><i class="fa fa-plus"></i>
            Add Subject</button>
    </div>
    <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="false"
        data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
        data-show-copy-rows="false" data-page-number="1" data-total-rows="11" data-show-toggle="false"
        data-show-export="false" data-filter-control="true" data-show-search-clear-button="false" data-key-events="false"
        data-mobile-responsive="true" data-check-on-init="true" data-show-print="false" data-sticky-header="true"
        data-url="/subjects/" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th data-field="count">#</th>
                <th data-field="subject_code">Subject Code</th>
                <th data-field="subject_name">Subject Name</th>
                <th data-field="action">Action</th>
            </tr>
        </thead>
    </table>
    <div id="addModal" class="modal fade">
        <div class="modal-dialog">
            <form id="addForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Subject</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject_code">Subject Code</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code"
                            placeholder="Subject Name" required>
                    </div>
                    <div class="form-group">
                        <label for="subject_name">Subject Name</label>
                        <input type="text" class="form-control" id="subject_name" name="subject_name"
                            placeholder="Subject Name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-plus"></i>
                        Add</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-md"><i class="fa fa-times"></i>
                        Close</button>
                </div>
            </form>
        </div>
    </div>
    <div id="updateModal" class="modal fade">
        <div class="modal-dialog">
            <form id="updateForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update Subject</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject_code">Subject Code</label>
                        <input type="text" class="form-control" id="subject_code" name="subject_code"
                            placeholder="Subject Name" required>
                    </div>
                    <div class="form-group">
                        <label for="subject_name">Subject Name</label>
                        <input type="text" class="form-control" id="subject_name" name="subject_name"
                            placeholder="Subject Name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-plus"></i>
                        Add</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-md"><i class="fa fa-times"></i>
                        Close</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        let originalSubjectCode;

        function view(subject_code) {
            $.ajax({
                method: 'GET',
                url: `/subjects/${subject_code}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response) {
                        originalSubjectCode = response.subject_code;
                        $('#updateForm').find('input[id=subject_code]').val(response.subject_code);
                        $('#updateForm').find('input[id=subject_name]').val(response.subject_name);
                        $('#updateModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });
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
                            errorMsg + '</div>'
                        );

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

        $(document).ready(function() {

            var $table = $('#table');
            $table.bootstrapTable({
                exportDataType: $(this).val(),
                printPageBuilder: function printPageBuilder(table) {
                    return myCustomPrint(table, "List of Subjects");
                },
            });

            $('#add-btn').click(function(event) {
                event.preventDefault();

                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            });

            // Validation for #addForm
            $('#addForm').validate({
                rules: {
                    subject_code: {
                        required: true,
                        remote: {
                            url: "{{ route('checkSubjectCode') }}",
                            type: "POST",
                            data: {
                                subject_code: function() {
                                    return $('#addForm').find('input[id=subject_code]').val();
                                }
                            }
                        }
                    },
                    subject_name: {
                        required: true,
                    },
                },
                messages: {
                    subject_code: {
                        required: "Please enter subject code",
                        remote: "Subject Code has already been taken."
                    },
                    subject_name: {
                        required: "Please enter subject name"
                    },
                },
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    if (element.is("select")) {
                        element
                            .closest(".form-group")
                            .find(".select2-container")
                            .append(error);
                    } else {
                        element.closest(".form-group").append(error);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("is-invalid");
                },
            });

            // Custom method for unique subject code validation on update form
            $.validator.addMethod("uniqueSubjectCode", function(value, element) {
                if (value === originalSubjectCode) return true;
                let response = false;
                $.ajax({
                    url: "{{ route('checkSubjectCode') }}",
                    type: "POST",
                    data: {
                        subject_code: value
                    },
                    async: false,
                    success: function(data) {
                        response = data;
                    }
                });
                return response;
            }, "The subject code has already been taken.");

            // Validation for #addForm
            $('#updateForm').validate({
                rules: {
                    subject_code: {
                        required: true,
                        uniqueSubjectCode: true
                    },
                    subject_name: {
                        required: true,
                    },
                },
                messages: {
                    subject_code: {
                        required: "Please enter subject code",
                    },
                    subject_name: {
                        required: "Please enter subject name"
                    },
                },
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    if (element.is("select")) {
                        element
                            .closest(".form-group")
                            .find(".select2-container")
                            .append(error);
                    } else {
                        element.closest(".form-group").append(error);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("is-invalid");
                },
            });

            $('#addForm').submit(function(event) {
                event.preventDefault();
                $('#addForm').find('button[type=submit]').attr('disabled', true);
                if ($('#addForm').valid()) {
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'POST',
                                url: '/subjects',
                                data: $('#addForm').serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    if (response.valid) {
                                        // Reset the form
                                        $('#addForm')[0].reset();

                                        // Refresh the table (if needed)
                                        refresh_table();

                                        // Display success message
                                        $('#show-msg').html(
                                            '<div class="alert alert-success">' +
                                            response.msg + '</div>'
                                        );

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    } else {
                                        $('#show-msg').html(
                                            '<div class="alert alert-danger">' +
                                            response.msg + '</div>'
                                        );

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
                                            errorMsg + '</div>'
                                        );

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
                    });
                }
                $('#addForm').find('button[type=submit]').removeAttr('disabled');
            });

            $('#updateForm').submit(function(event) {
                event.preventDefault();
                $('#updateForm').find('button[type=submit]').attr('disabled', true);
                if ($('#updateForm').valid()) {
                    $('#updateModal').modal('hide');
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'PUT',
                                url: `/subjects/${originalSubjectCode}`,
                                data: $('#updateForm').serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    if (response.valid) {
                                        // Reset the form
                                        $('#updateForm')[0].reset();

                                        // Refresh the table (if needed)
                                        refresh_table();

                                        // Display success message
                                        $('#show-msg').html(
                                            '<div class="alert alert-success">' +
                                            response.msg + '</div>'
                                        );

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    } else {
                                        $('#show-msg').html(
                                            '<div class="alert alert-danger">' +
                                            response.msg + '</div>'
                                        );

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
                                            errorMsg + '</div>'
                                        );

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
                    });
                }
                $('#updateForm').find('button[type=submit]').removeAttr('disabled');
            });

        });
    </script>
@endsection
