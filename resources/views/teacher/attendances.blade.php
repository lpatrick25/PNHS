@extends('layout.master')
@section('title')
    | Attendance List
@endsection
@section('active-attendance')
    active
@endsection
@section('app-title')
    Attendance List
@endsection
@section('content')
    <div id="show-msg"></div>
    <div id="subject-list">
        <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="false"
            data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
            data-show-copy-rows="false" data-page-number="1" data-total-rows="11" data-show-toggle="false"
            data-show-export="false" data-filter-control="true" data-show-search-clear-button="false"
            data-key-events="false" data-mobile-responsive="true" data-check-on-init="true" data-show-print="false"
            data-sticky-header="true" data-url="/subjectTeachers/{{ $teacher_id }}">
            <thead>
                <tr>
                    <th data-field="count">#</th>
                    <th data-field="subject_code">Subject Code</th>
                    <th data-field="subject_name">Subject Name</th>
                    <th data-field="grade_level">Grade Level</th>
                    <th data-field="section">Section</th>
                    <th data-field="school_year">School Year</th>
                    <th data-field="action">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="attendance-list" style="display: none">
        <div id="toolbar">
            <button class="btn btn-danger btn-md" id="back-btn"><i class="fa fa-arrow-left"></i> Back</button>
            <button class="btn btn-primary btn-md" id="add-btn"><i class="fa fa-sync"></i> Generate Attendance</button>
        </div>
        <table id="table1" data-show-refresh="true" data-auto-refresh="true" data-pagination="true"
            data-show-columns="false" data-cookie="false" data-cookie-id-table="table" data-search="true"
            data-click-to-select="false" data-show-copy-rows="false" data-page-number="1" data-total-rows="11"
            data-show-toggle="false" data-show-export="false" data-filter-control="true"
            data-show-search-clear-button="false" data-key-events="false" data-mobile-responsive="true"
            data-check-on-init="true" data-show-print="false" data-sticky-header="true" data-toolbar="#toolbar">
        </table>
    </div>
    <div id="viewStudent" class="modal fadeIn">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">List of Students</h3>
                </div>
                <div class="modal-body">
                    <div id="toolbar1">
                        <div class="form-group">
                            <label for="rfid_no">RFID No: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="rfid_no" name="rfid_no" required autofocus>
                        </div>
                    </div>
                    <table id="table2" data-show-refresh="false" data-auto-refresh="false" data-pagination="false"
                        data-show-columns="false" data-cookie="false" data-cookie-id-table="table" data-search="false"
                        data-click-to-select="false" data-show-copy-rows="false" data-page-number="1" data-total-rows="11"
                        data-show-toggle="false" data-show-export="false" data-filter-control="true"
                        data-show-search-clear-button="false" data-key-events="false" data-mobile-responsive="true"
                        data-check-on-init="true" data-show-print="false" data-sticky-header="true"
                        data-toolbar="#toolbar1">
                    </table>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-md"><i
                            class="fa fa-times"></i>
                        Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        let subjectListing, attendanceDate;

        function view(subject_listing) {
            subjectListing = subject_listing;
            $('#subject-list').hide();
            $('#attendance-list').show();
            $('#table1').bootstrapTable('destroy').bootstrapTable({
                url: `/attendances/${subjectListing}`,
                columns: [{
                        field: 'count',
                        title: '#'
                    },
                    {
                        field: 'attendance_date',
                        title: 'Attendance Date'
                    },
                    {
                        field: 'number_of_present',
                        title: 'Present'
                    },
                    {
                        field: 'number_of_late',
                        title: 'Late'
                    },
                    {
                        field: 'number_of_absent',
                        title: 'Absent'
                    },
                    {
                        field: 'action',
                        title: 'Action'
                    }
                ]
            });
        }

        function viewStudents(attendance_date) {
            attendanceDate = attendance_date;
            $('#table2').bootstrapTable('destroy').bootstrapTable({
                autoRefresh: false,
                url: `/attendances/getAttendanceByDate/${attendance_date}`,
                formatLoadingMessage: function() {
                    return 'Fetching student, please wait...';
                },
                columns: [{
                        field: 'count',
                        title: '#'
                    },
                    {
                        field: 'image',
                        title: 'IMAGE'
                    },
                    {
                        field: 'student_lrn',
                        title: 'STUDENT LRN'
                    },
                    {
                        field: 'student_name',
                        title: 'STUDENT NAME'
                    },
                    {
                        field: 'attendance_status',
                        title: 'STATUS'
                    },
                ]
            });
            $('#viewStudent').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $('#rfid_no').focus();
        }

        $(document).ready(function() {

            $('#table').bootstrapTable('destroy').bootstrapTable({
                exportDataType: $(this).val(),
                printPageBuilder: function printPageBuilder(table) {
                    return myCustomPrint(table, "List of Attendance");
                },
            });

            $('#back-btn').click(function(event) {
                event.preventDefault();

                $('#subject-list').show();
                $('#attendance-list').hide();
            });

            $('#add-btn').click(function(event) {
                event.preventDefault();

                const currentDate = new Date().toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                Swal.fire({
                    title: 'Are you sure?',
                    html: `Today's date is <strong>${currentDate}</strong>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'POST',
                            url: '/attendances',
                            data: {
                                subject_listing: subjectListing
                            },
                            dataType: 'JSON',
                            cache: false,
                            success: function(response) {
                                if (response.valid) {
                                    $('#show-msg').html(
                                        '<div class="alert alert-success">' +
                                        response.msg + '</div>');

                                    // Remove the notification after 5 seconds (5000 milliseconds)
                                    setTimeout(function() {
                                        $('#show-msg').html(
                                            ''); // Clears the notification
                                    }, 5000); // 5000 milliseconds = 5 seconds

                                    view(response.subject_listing);
                                } else {
                                    $('#show-msg').html(
                                        '<div class="alert alert-danger">' +
                                        response.msg + '</div>');

                                    // Remove the notification after 5 seconds (5000 milliseconds)
                                    setTimeout(function() {
                                        $('#show-msg').html(
                                            ''); // Clears the notification
                                    }, 5000); // 5000 milliseconds = 5 seconds

                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
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
            });

            // Set focus to #rfid_no when the modal is shown
            $('#attendanceModal').on('shown.bs.modal', function() {
                $('#rfid_no').focus();
            });

            $('#rfid_no').change(function(event) {
                event.preventDefault();

                // Get RFID number and validate input
                let rfid_no = $('#rfid_no').val().trim();
                if (!rfid_no) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Input',
                        text: 'Please scan a valid RFID card.',
                    });
                    $('#rfid_no').focus();
                    return;
                }

                // Make AJAX request
                $.ajax({
                    method: 'PUT',
                    url: `/attendances/${rfid_no}`,
                    data: {
                        subject_listing: subjectListing, // Ensure these variables are defined
                        attendance_date: attendanceDate // Ensure these variables are defined
                    },
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        $('#rfid_no').val(''); // Clear the input after response
                        $('#rfid_no').focus();

                        if (response.valid) {
                            // Refresh views
                            view(response.subject_listing);
                            viewStudents(response.attendance_date);
                        }
                    },
                    error: function(jqXHR, textStatus, error) {
                        $('#rfid_no').val(''); // Clear the input on error
                        $('#rfid_no').focus();
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
            });

        });
    </script>
@endsection
