@extends('layout.master')
@section('title')
    | Dashboard
@endsection
@section('active-dashboard')
    active
@endsection
@section('app-title')
    Dashboard
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $dashboard['student_list'] }}<sup style="font-size: 20px"></sup></h3>
                    <p>No. Students</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                </div>
                <a href="{{ route('viewAdvisory') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $dashboard['subject_list'] }}<sup style="font-size: 20px"></sup></h3>
                    <p>No. Subject Handle</p>
                </div>
                <div class="icon">
                    <i class="ion ion-clipboard"></i>
                </div>
                <a href="{{ route('viewTeacherSubject') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $dashboard['advisory']->section }}<sup style="font-size: 20px"></sup></h3>
                    <p>Grade Level: {{ $dashboard['advisory']->grade_level }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <a href="{{ route('viewAdvisory') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $dashboard['attendance_count'] }}<sup style="font-size: 20px"></sup></h3>
                    <p>No. Attendance</p>
                </div>
                <div class="icon">
                    <i class="ion ion-calendar"></i>
                </div>
                <a href="{{ route('viewAttendanceTeacher') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
            $.ajax({
                method: 'GET',
                url: '{{ route('passwordCheck') }}',
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (!response.valid) {
                        // Prompt the user to update their password
                        Swal.fire({
                            icon: 'warning',
                            title: 'Default Password Detected',
                            text: response.msg,
                            confirmButtonText: 'Update Now',
                            showCancelButton: true,
                            cancelButtonText: 'Later',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                update(response.user_id); // Trigger the update function
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                        // Extract and display error messages
                        var errors = jqXHR.responseJSON.error;
                        var errorMsg = "Error occurred: " + errors + ".";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMsg,
                        });
                    } else {
                        // Display a generic error message for unexpected issues
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.',
                        });
                    }
                }
            });
        });
    </script>
@endsection
