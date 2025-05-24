@extends('layout.master')
@section('title')
    | Grades
@endsection
@section('active-grades')
    active
@endsection
@section('app-title')
    Grades
@endsection
@section('content')
    <div id="show-msg"></div>
    <div class="row">
        @php
            $count = 1;
        @endphp
        @foreach ($gradeLevels as $gradeLevel)
            <div class="col-lg-12">
                <div class="card card-outline card-purple">
                    <div class="card-body">
                        <div id="toolbar{{ $count }}">
                            <h3>Grade Level: <span class="text-success">{{ $gradeLevel->grade_level }}</span> - Section:
                                <span class="text-danger">{{ $gradeLevel->section }}</span>
                            </h3>
                        </div>
                        <table id="table{{ $count }}" class="table table-bordered table-striped"
                            data-toolbar="#toolbar{{ $count }}"
                            data-url="/reportCards/getStudentGrades/{{ $gradeLevel->grade_level }}/{{ $gradeLevel->section }}">
                            <thead>
                                <tr>
                                    <th data-field="count">#</th>
                                    <th data-field="subject_code">Subject Name</th>
                                    <th data-field="teacher_name">Teacher Name</th>
                                    <th data-field="1st_quarter">1st Quarter</th>
                                    <th data-field="2nd_quarter">2nd Quarter</th>
                                    <th data-field="3rd_quarter">3rd Quarter</th>
                                    <th data-field="4th_quarter">4th Quarter</th>
                                    <th data-field="final_grade">Final Grade</th>
                                    <th data-field="remarks">Remarks</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @php
                $count++;
            @endphp
        @endforeach
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize all tables dynamically
            $('table[id^="table"]').each(function() {
                const tableId = $(this).attr('id');
                const url = $(this).data('url');

                $(`#${tableId}`).bootstrapTable({
                    url: url, // Fetch data from the URL
                    method: 'GET',
                    dataType: 'json',
                    pagination: true,
                    search: false,
                    showRefresh: true,
                    toolbar: $(this).data('toolbar'),
                    columns: [{
                            field: 'count',
                            title: '#',
                            formatter: (value, row, index) => index +
                            1, // Auto-increment row count
                        },
                        {
                            field: 'subject_name',
                            title: 'Subject Name'
                        },
                        {
                            field: 'teacher_name',
                            title: 'Teacher Name'
                        },
                        {
                            field: '1st_quarter',
                            title: '1st Quarter'
                        },
                        {
                            field: '2nd_quarter',
                            title: '2nd Quarter'
                        },
                        {
                            field: '3rd_quarter',
                            title: '3rd Quarter'
                        },
                        {
                            field: '4th_quarter',
                            title: '4th Quarter'
                        },
                        {
                            field: 'final_grade',
                            title: 'Final Grade'
                        },
                        {
                            field: 'remarks',
                            title: 'Remarks'
                        },
                    ],
                    onLoadSuccess: function(data) {
                        console.log(`Data loaded for ${tableId}:`, data);
                    },
                    onLoadError: function(status, jqXHR) {
                        console.error(`Failed to load data for ${tableId}:`, jqXHR);
                    },
                });
            });
        });
    </script>
@endsection
