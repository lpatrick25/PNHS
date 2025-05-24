@extends('layout.master')
@section('title')
    | Subject Teachers
@endsection
@section('active-subject_teacher')
    active
@endsection
@section('app-title')
    Subject Teachers
@endsection
@section('content')
    <div id="show-msg"></div>
    <div id="teacher-div">
        <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="false"
            data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
            data-show-copy-rows="false" data-page-number="1" data-total-rows="11" data-show-toggle="false"
            data-show-export="false" data-filter-control="true" data-show-search-clear-button="false"
            data-key-events="false" data-mobile-responsive="true" data-check-on-init="true" data-show-print="false"
            data-sticky-header="true" data-url="{{ route('subjectTeachersList') }}">
            <thead>
                <tr>
                    <th data-field="count">#</th>
                    <th data-field="image">Image</th>
                    <th data-field="teacher_id">TEACHER ID</th>
                    <th data-field="teacher_name">TEACHER NAME</th>
                    <th data-field="action">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="subject-teacher" style="display: none;">
        <table id="table1" data-show-refresh="true" data-auto-refresh="true" data-pagination="true"
            data-show-columns="false" data-cookie="false" data-cookie-id-table="table" data-search="true"
            data-click-to-select="false" data-show-copy-rows="false" data-page-number="1" data-total-rows="11"
            data-show-toggle="false" data-show-export="false" data-filter-control="true"
            data-show-search-clear-button="false" data-key-events="false" data-mobile-responsive="true"
            data-check-on-init="true" data-show-print="false" data-sticky-header="true">
            <thead>
                <tr>
                    <th data-field="count">#</th>
                    <th data-field="teacher_name">TEACHER NAME</th>
                    <th data-field="subject_code">SUBJECT CODE</th>
                    <th data-field="subject_name">SUBJECT NAME</th>
                    <th data-field="grade_level">GRADE LEVEL</th>
                    <th data-field="section">SECTION</th>
                    <th data-field="school_year">SCHOOL YEAR</th>
                    <th data-field="action">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="addModal" class="modal fade">
        <div class="modal-dialog">
            <form id="addForm" class="modal-content">
                <input type="hidden" id="teacher_id" name="teacher_id" required="true" readonly="true">
                <div class="modal-header">
                    <h3 class="modal-title">Add Subject</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="subject_code">Subject Name</label>
                                <select class="form-control" id="subject_code" name="subject_code" required="true">
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->subject_code }}">{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="grade_level">Grade Level</label>
                                <select class="form-control" id="grade_level" name="grade_level" required="true">
                                    @for ($i = 7; $i <= 12; $i++)
                                        <option value="{{ $i }}">Grade {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="section">Section Name</label>
                                <select class="form-control" id="section" name="section" required="true"></select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="school_year">School Year Level</label>
                                <input type="text" class="form-control" id="school_year" name="school_year"
                                    value="{{ Session::get('school_year') }}" required="true" readonly="true">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-plus"></i>
                        Add</button>
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
        let teacherID;

        function view(teacher_id) {
            $('#teacher-div').hide();
            $('#subject-teacher').show();

            // Check if toolbar exists, and remove it before creating a new one
            if ($('#toolbar').length) {
                $('#toolbar').remove();
            }

            var $table1 = $('#table1');
            $table1.bootstrapTable('destroy').bootstrapTable({
                url: `/subjectTeachers/${teacher_id}`,
                toolbar: '<div id="toolbar"><button type="button" class="btn btn-danger btn-md" id="cancel-btn" style="margin-right: 5px;"><i class="fa fa-arrow-left"></i> Go Back</button><button type="button" class="btn btn-primary btn-md" id="add-btn"><i class="fa fa-plus"></i> Add Subject</button></div>',
                columns: [{
                        field: 'count',
                        title: '#'
                    },
                    {
                        field: 'teacher_name',
                        title: 'TEACHER NAME'
                    },
                    {
                        field: 'subject_code',
                        title: 'SUBJECT CODE'
                    },
                    {
                        field: 'subject_name',
                        title: 'SUBJECT NAME'
                    },
                    {
                        field: 'grade_level',
                        title: 'GRADE LEVEL'
                    },
                    {
                        field: 'section',
                        title: 'SECTION'
                    },
                    {
                        field: 'school_year',
                        title: 'SCHOOL YEAR'
                    },
                    {
                        field: 'action',
                        title: 'ACTION'
                    },
                ]
            });

            $('#subject_code').change();
            $('#teacher_id').val(teacher_id);
        }

        function trash(subject_list) {
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
                        method: 'DELETE',
                        url: `/subjectTeachers/${subject_list}`,
                        dataType: 'JSON',
                        cache: false,
                        success: function(response) {
                            if (response.valid) {
                                view(response.teacher_id);

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
            $table.bootstrapTable('destroy').bootstrapTable({});

            $(document).on('click', '#add-btn', function(event) {
                event.preventDefault();
                $('#addModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            });

            $(document).on('click', '#cancel-btn', function(event) {
                event.preventDefault();
                var $table1 = $('#table1');
                $table1.bootstrapTable('destroy').bootstrapTable({
                    autoRefresh: false,
                });
                $('#teacher-div').show();
                $('#subject-teacher').hide();
            });

            $('#grade_level').change(function() {
                var value = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: `/admin/sectionList/${value}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        if (response) {
                            $('#section').empty();
                            for (var i = 0; i < response.length; i++) {
                                $('#section').append('<option value="' + response[i].section +
                                    '">' + response[i].section + '</option>');
                            }
                            $('#section').trigger('chosen:updated');
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
            });

            $('#grade_level').change();

            // Validation for #addForm
            $('#addForm').validate({
                rules: {
                    subject_code: {
                        required: true,
                    },
                    teacher_id: {
                        required: true,
                    },
                    grade_level: {
                        required: true,
                    },
                    section: {
                        required: true,
                    },
                    school_year: {
                        required: true,
                    }
                },
                messages: {
                    subject_code: {
                        required: "Please select subject code",
                    },
                    teacher_id: {
                        required: "Teacher ID is required"
                    },
                    grade_level: {
                        required: "Grade level is required"
                    },
                    section: {
                        required: "Please select section"
                    },
                    school_year: {
                        required: "School year is required"
                    }
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
                                url: '/subjectTeachers',
                                data: $('#addForm').serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    if (response.valid) {
                                        // Refresh the table (if needed)
                                        view(response.teacher_id);

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

        });
    </script>
@endsection
