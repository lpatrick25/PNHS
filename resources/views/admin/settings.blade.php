@extends('layout.master')
@section('title')
    | Settings
@endsection
@section('active-settings')
    active
@endsection
@section('app-title')
    Settings
@endsection
@section('content')
    <div id="show-msg"></div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-outline card-success">
                <div class="card-content">
                    <div class="card-header">
                        <h3 class="card-title">School Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="school_id">School ID: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="school_id" name="school_id" value="303414"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="school_name">School Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="school_name" name="school_name"
                                value="PALALE NATIONAL HIGH SCHOOL" required>
                        </div>
                    </div>
                    <div class="card-footer" style="display: none;">
                        <button type="button" class="btn btn-primary btn-md btn-block"><i class="fa fa-save"></i>
                            Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div id="toolbar">
                <button type="button" class="btn btn-primary btn-md" id="add-btn"><i class="fa fa-plus"></i>
                    Add Settings</button>
            </div>
            <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true"
                data-show-columns="false" data-cookie="false" data-cookie-id-table="table" data-search="true"
                data-click-to-select="false" data-show-copy-rows="false" data-page-number="1" data-total-rows="11"
                data-show-toggle="false" data-show-export="false" data-filter-control="true"
                data-show-search-clear-button="false" data-key-events="false" data-mobile-responsive="true"
                data-check-on-init="true" data-show-print="false" data-sticky-header="true" data-url="/schoolYears"
                data-toolbar="#toolbar">
                <thead>
                    <tr>
                        <th data-field="count">#</th>
                        <th data-field="school_year">School Year</th>
                        <th data-field="start_date">Start Date</th>
                        <th data-field="end_date">End Date</th>
                        <th data-field="current">Current</th>
                        <th data-field="action">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="addModal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <form id="addForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add School Years</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="school_year">School Year</label>
                        <input type="text" class="form-control" id="school_year" name="school_year" data-mask="2099-2099"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
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
        <div class="modal-dialog modal-sm">
            <form id="updateForm" class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Update School Years</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="school_year">School Year</label>
                        <input type="text" class="form-control" id="school_year" name="school_year"
                            data-mask="2099-2099" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-plus"></i>
                        Update</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-md"><i
                            class="fa fa-times"></i>
                        Close</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        let schoolYearID;

        function view(school_year_id) {
            $.ajax({
                method: 'GET',
                url: `/schoolYears/${school_year_id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response) {
                        schoolYearID = response.school_year_id;
                        $('#updateForm').find('input[id=school_year]').val(response.school_year);
                        $('#updateForm').find('input[id=start_date]').val(response.start_date);
                        $('#updateForm').find('input[id=end_date]').val(response.end_date);
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
                    return myCustomPrint(table, "List of School Year");
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
                    school_year: {
                        required: true,
                    },
                    start_date: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                    },
                },
                messages: {
                    school_year: {
                        required: "Please enter school year",
                    },
                    start_date: {
                        required: "Please enter start date"
                    },
                    end_date: {
                        required: "Please enter end date"
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

            // Validation for #addForm
            $('#updateForm').validate({
                rules: {
                    school_year: {
                        required: true,
                    },
                    start_date: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                    },
                },
                messages: {
                    school_year: {
                        required: "Please enter school year",
                    },
                    start_date: {
                        required: "Please enter start date"
                    },
                    end_date: {
                        required: "Please enter end date"
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
                    $('#addModal').modal('hide');
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
                                url: '/schoolYears',
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
                                error: function(jqXHR) {
                                    let errorMsg =
                                        "An error occurred. Please try again.";
                                    if (jqXHR.responseJSON && jqXHR.responseJSON.msg) {
                                        errorMsg = jqXHR.responseJSON
                                            .msg; // Use the backend error message
                                    }
                                    $('#show-msg').html(
                                        '<div class="alert alert-danger">' +
                                        errorMsg + '</div>'
                                    );

                                    // Remove the notification after 5 seconds (5000 milliseconds)
                                    setTimeout(function() {
                                        $('#show-msg').html(
                                            ''); // Clears the notification
                                    }, 5000); // 5000 milliseconds = 5 seconds

                                }
                            });
                        }
                    });
                }

                $('#addForm').find('button[type=submit]').removeAttr('disabled');
            });

            $('#updateForm').submit(function(event) {
                alert('asa');
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
                                url: `/schoolYears/${schoolYearID}`,
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
                                    let errorMsg =
                                        "An error occurred. Please try again.";
                                    if (jqXHR.responseJSON && jqXHR.responseJSON.msg) {
                                        errorMsg = jqXHR.responseJSON
                                            .msg; // Use the backend error message
                                    }
                                    $('#show-msg').html(
                                        '<div class="alert alert-danger">' +
                                        errorMsg + '</div>'
                                    );

                                    // Remove the notification after 5 seconds (5000 milliseconds)
                                    setTimeout(function() {
                                        $('#show-msg').html(
                                            ''); // Clears the notification
                                    }, 5000); // 5000 milliseconds = 5 seconds

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
