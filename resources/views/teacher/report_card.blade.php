@extends('layout.master')
@section('title')
    | Learner's Report Card
@endsection
@section('active-report-card')
    active
@endsection
@section('app-title')
    Learner's Report Card
@endsection
@section('content')
    <div id="toolbar1">
        <select name="school_year" id="school_year" class="form-control">
            <option value="2024-2025">School Year: 2024-2025</option>
            <option value="2025-2026">School Year: 2025-2026</option>
            <option value="2026-2027">School Year: 2026-2027</option>
        </select>

    </div>
    <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="false"
        data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
        data-show-copy-rows="false" data-page-number="1" data-total-rows="11" data-show-toggle="false"
        data-show-export="false" data-filter-control="true" data-show-search-clear-button="false" data-key-events="false"
        data-mobile-responsive="true" data-check-on-init="true" data-show-print="false" data-sticky-header="true"
        data-url="" data-toolbar="#toolbar1">
        <thead>
            <tr>
                <th data-field="count">#</th>
                <th data-field="image">Image</th>
                <th data-field="student_lrn">STUDENT LRN</th>
                <th data-field="student_name">STUDENT NAME</th>
                <th data-field="action">ACTION</th>
            </tr>
        </thead>
    </table>
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Exported Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="file-content">
                    <ul id="fileList" class="list-group"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function refresh_tables() {
            $('#table').bootstrapTable('destroy').bootstrapTable({
                url: '{{ route('getAdvisoryStudentsBySchoolYear') }}',
                queryParams: function(params) {
                    // Add subject_listing to the request
                    params.school_year = $('#school_year').val();
                    return params;
                },
            });
        }

        function generate(student_lrn) {
            const startTime = Date.now();
            let timerInterval;

            Swal.fire({
                title: 'Generating Student Report Card',
                html: 'Please wait... Time Taken: <b>0</b> seconds',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            timerInterval = setInterval(() => {
                const currentTime = Date.now();
                const timeTaken = ((currentTime - startTime) / 1000).toFixed(2);
                const timerElement = Swal.getHtmlContainer().querySelector('b');
                if (timerElement) timerElement.textContent = timeTaken;
            }, 1000);

            $.ajax({
                method: 'POST',
                url: `/reportCards`,
                data: {
                    student_lrn: student_lrn,
                    school_year: $('#school_year').val()
                },
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response.valid) {
                        $('#show-msg').html(
                            '<div class="alert alert-success">' +
                            response.msg + '</div>'
                        );

                        // Remove the notification after 5 seconds (5000 milliseconds)
                        setTimeout(function() {
                            $('#show-msg').html(
                                ''); // Clears the notification
                        }, 5000); // 5000 milliseconds = 5 seconds


                        $('#file-content').html('');
                        $('#file-content').html('<ul id="fileList" class="list-group"></ul>');

                        // Add the exported file to the modal list
                        const filePath = response.file_path;
                        const fileName = filePath.split('/').pop();
                        $('#fileList').append(
                            `<li class="list-group-item">
                                <a href="${filePath}" target="_blank" download>${fileName}</a>
                            </li>`
                        );

                        $('#file-content').append(response.download);

                        // Show the modal
                        $('#exportModal').modal('show');
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
                    clearInterval(timerInterval);
                    Swal.close();
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

            $('#school_year').change(function() {
                refresh_tables();
            });

            refresh_tables();
        });
    </script>
@endsection
