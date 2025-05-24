@extends('layout.master')
@section('title')
    | Attendances
@endsection
@section('active-attendances')
    active
@endsection
@section('app-title')
    Attendances
@endsection
@section('content')
    <div id="show-msg"></div>
    <div id="attendance-records">
        <div class="alert alert-warning">No attendance records found.</div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajax({
                method: 'GET',
                url: '{{ route('getStudentAttendance') }}',
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response.valid) {
                        const recordsContainer = $('#attendance-records');
                        recordsContainer.empty(); // Clear previous content

                        // Define available background color classes
                        const bgClasses = ['bg-primary', 'bg-success', 'bg-warning', 'bg-danger'];
                        let colorIndex = 0; // Initialize a counter for cycling through colors

                        // Loop through the data and build the cards
                        response.data.forEach((record) => {
                            const gradeLevel = record.grade_level;
                            const section = record.section;
                            const subjects = record.subjects;

                            // Build the card
                            let card = `
                <div class="card card-outline card-success">
                    <div class="card-content">
                        <div class="card-header">
                            <h3 class="card-title">
                                <span class="text-danger">Grade Level: ${gradeLevel}</span> -
                                <span class="text-success">Section: ${section}</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                `;

                            // Add subject boxes cycling through background colors
                            subjects.forEach((subject) => {
                                const bgClass = bgClasses[colorIndex];
                                colorIndex = (colorIndex + 1) % bgClasses
                                .length; // Move to the next color, reset if at the end

                                card += `
                        <div class="col-lg-4">
                            <div class="small-box ${bgClass}">
                                <div class="inner">
                                    <h3>${subject.attendance_summary}<sup style="font-size: 20px"></sup></h3>
                                    <p>${subject.subject_code}</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <a href="#" class="small-box-footer">${subject.subject_name}</a>
                            </div>
                        </div>
                    `;
                            });

                            card += `
                            </div>
                        </div>
                    </div>
                </div>
                `;

                            // Append the card to the container
                            recordsContainer.append(card);
                        });
                    } else {
                        $('#attendance-records').html(
                            '<div class="alert alert-warning">No attendance records found.</div>'
                        );
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                        var errors = jqXHR.responseJSON.error;
                        var errorMsg = "Error submitting data: " + errors + ". ";
                        $('#show-msg').html(
                            '<div class="alert alert-danger">' + errorMsg + '</div>'
                        );
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
    </script>
@endsection
