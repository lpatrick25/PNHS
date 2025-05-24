@extends('layout.master')
@section('title')
    | Advisers
@endsection
@section('active-advisers')
    active
@endsection
@section('app-title')
    Adviser List
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12" id="show-msg"></div>
        <div class="col-lg-12" id="adviser-list" style="display: block;">
            <div class="row">
                <div class="col-lg-4 mt-5">
                    <div class="card card-outline card-purple mt-2">
                        <form class="card" id="addForm">
                            <div class="card-header">
                                <h3 class="card-title">Add Adviser</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="teacher_id">Teacher Name</label>
                                    <select class="form-control" id="teacher_id" name="teacher_id" required="true">
                                        <option selected="true" value="REQUIRED" selected disabled>-- Select Teacher --
                                        </option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->teacher_id }}">{{ $teacher->first_name }}
                                                {{ $teacher->middle_name }} {{ $teacher->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="grade_level">Grade Level</label>
                                    <select class="form-control" id="grade_level" name="grade_level" required="true">
                                        <option selected="true" value="REQUIRED" selected disabled>-- Select Grade Level --
                                        </option>
                                        <option value="7">Grade 7</option>
                                        <option value="8">Grade 8</option>
                                        <option value="9">Grade 9</option>
                                        <option value="10">Grade 10</option>
                                        <option value="11">Grade 11</option>
                                        <option value="12">Grade 12</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="section">Section</label>
                                    <input type="text" class="form-control" id="section" name="section"
                                        placeholder="Section Name" required>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary btn-md btn-block"><i class="fa fa-plus"></i>
                                    Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="false"
                        data-show-columns="false" data-cookie="false" data-cookie-id-table="table" data-search="true"
                        data-click-to-select="false" data-show-copy-rows="false" data-page-number="1" data-total-rows="11"
                        data-show-toggle="false" data-show-export="false" data-filter-control="true"
                        data-show-search-clear-button="false" data-key-events="false" data-mobile-responsive="true"
                        data-check-on-init="true" data-show-print="false" data-sticky-header="true" data-url="/advisers">
                        <thead>
                            <tr>
                                <th data-field="count">#</th>
                                <th data-field="adviser_name">Adviser</th>
                                <th data-field="grade_level">Grade Level</th>
                                <th data-field="section">Section</th>
                                <th data-field="students">No. Students</th>
                                <th data-field="action" data-print-ignore="true">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12" id="add-student" style="display: none;">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="card-title">
                        Adviser: <span id="adviserName" class="text-danger"></span><br>
                        Grade Level: <span id="gradeLevel" class="text-danger"></span><br>
                        Section: <span id="sectionName" class="text-danger"></span></h3>
                </div>
                <div class="col-lg-4 mt-5">
                    <div class="card card-outline card-purple mt-2">
                        <form class="card" id="addStudentForm">
                            <div class="card-header">
                                <h3 class="card-title">Add Student</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="student_lrn">Student Name</label>
                                    <input type="hidden" class="form-control" id="adviser_id" name="adviser_id"
                                        required>
                                    <select class="form-control" id="student_lrn" name="student_lrn" required="true">
                                        <option selected="true" value="REQUIRED" selected disabled>-- Select Student --
                                        </option>
                                        @foreach ($studentsWithoutAdvisories as $student)
                                            <option value="{{ $student->student_lrn }}">{{ $student->first_name }}
                                                {{ $student->middle_name }} {{ $student->last_name }}
                                                {{ $student->exention_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary btn-md btn-block"><i
                                        class="fa fa-plus"></i>
                                    Add</button>
                                <button type="button" class="btn btn-danger btn-md btn-block" id="cancel-btn"><i
                                        class="fa fa-times"></i> Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <table id="table1" data-url="" data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <th data-field="count">#</th>
                                <th data-field="image">Image</th>
                                <th data-field="student_lrn">Student LRN</th>
                                <th data-field="student_name">Student Name</th>
                                <th data-field="action" data-print-ignore="true">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function add_student(adviser_id) {
            $.ajax({
                method: 'GET',
                url: `/advisers/${adviser_id}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response) {
                        $('#adviserName').text(response.adviser_name);
                        $('#gradeLevel').text(response.grade_level);
                        $('#sectionName').text(response.section);

                        $('#adviser_id').val(adviser_id);
                        show_advisories(adviser_id);
                        // Hide the adviser list with fadeOut animation
                        $('#adviser-list').addClass('animate fadeOut').css('display', 'none');

                        // Show the add student section with fadeIn animation
                        $('#add-student').removeClass('fadeOut').addClass('animate fadeIn').css('display',
                            'block');
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
        }

        function show_advisories(adviser_id) {
            var $table1 = $('#table1');
            $table1.bootstrapTable('destroy').bootstrapTable({
                autoRefresh: false,
                url: `/student_statuses/${adviser_id}`,
                columns: [{
                        field: 'count',
                        title: '#'
                    },
                    {
                        field: 'image',
                        title: 'Image'
                    },
                    {
                        field: 'student_lrn',
                        title: 'STUDENT LRN'
                    },
                    {
                        field: 'student_name',
                        title: 'STUDENT NAME'
                    }
                ]
            });
        }

        function remove(student_lrn) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Remove'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: `/student_statuses/${student_lrn}`,
                        dataType: 'JSON',
                        cache: false,
                        success: function(response) {
                            if (response.valid) {
                                show_advisories(response.data.adviser_id);

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

        $(document).ready(function() {

            var $table = $('#table');
            $table.bootstrapTable({
                exportDataType: $(this).val(),
                printPageBuilder: function printPageBuilder(table) {
                    return myCustomPrint(table, "List of Adviser");
                },
            });

            var $table1 = $('#table1');
            $table1.bootstrapTable({
                exportDataType: $(this).val(),
            });

            $('#cancel-btn').click(function() {
                // Show the adviser list with fadeOut animation
                $('#adviser-list').addClass('animate fadeOut').css('display', 'block');

                // Hide the add student section with fadeIn animation
                $('#add-student').removeClass('fadeOut').addClass('animate fadeIn').css('display', 'none');
            });

            // Validation for #addForm
            $('#addForm').validate({
                rules: {
                    teacher_id: {
                        required: true,
                    },
                    grade_level: {
                        required: true,
                    },
                    section: {
                        required: true,
                    }
                },
                messages: {
                    teacher_id: {
                        required: "Please select teacher"
                    },
                    grade_level: {
                        required: "Please select grade level"
                    },
                    grade_level: {
                        required: "Please enter a valid section"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).closest(".form-group-inner").addClass("input-with-error");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest(".form-group-inner").removeClass("input-with-error");
                }
            });

            // Validation for #addStudentForm
            $('#addStudentForm').validate({
                rules: {
                    student_lrn: {
                        required: true,
                    },
                    adviser_id: {
                        required: true,
                    },
                },
                messages: {
                    student_lrn: {
                        required: "Please select student"
                    },
                    adviser_id: {
                        required: "Please select adviser"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).closest(".form-group-inner").addClass("input-with-error");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest(".form-group-inner").removeClass("input-with-error");
                }
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
                                url: '/advisers',
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

            $('#addStudentForm').submit(function(event) {
                event.preventDefault();
                $('#addStudentForm').find('button[type=submit]').attr('disabled', true);
                if ($('#addStudentForm').valid()) {
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
                                url: '/student_statuses',
                                data: $('#addStudentForm').serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    if (response.valid) {
                                        // Remove the selected student from the dropdown
                                        $('#student_lrn option:selected').remove();

                                        show_advisories(response.data.adviser_id);

                                        // Reset the form
                                        $('#addStudentForm')[0].reset();

                                        $('select').trigger('chosen:updated');

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
                $('#addStudentForm').find('button[type=submit]').removeAttr('disabled');
            });

        });
    </script>
@endsection
