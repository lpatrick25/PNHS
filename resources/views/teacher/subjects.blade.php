@extends('layout.master')
@section('title')
    | Subject Handled
@endsection
@section('active-subject')
    active
@endsection
@section('app-title')
    Subject Handled
@endsection
@section('content')
    <div id="show-msg"></div>
    <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="false"
        data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
        data-show-copy-rows="false" data-page-number="1" data-total-rows="11" data-show-toggle="false"
        data-show-export="false" data-filter-control="true" data-show-search-clear-button="false" data-key-events="false"
        data-mobile-responsive="true" data-check-on-init="true" data-show-print="false" data-sticky-header="true"
        data-url="/subjectTeachers/{{ $teacher_id }}">
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
    <div id="viewStudent" class="modal fadeIn">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">List of Students</h3>
                </div>
                <div class="modal-body">
                    <table id="table1">
                    </table>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" data-dismiss="modal" class="btn btn-danger btn-md"><i class="fa fa-times"></i>
                        Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function view(subject_listing) {
            var $table1 = $('#table1');
            $table1.bootstrapTable('destroy').bootstrapTable({
                autoRefresh: false,
                url: `/subjectTeachers/getEnrolledStudent/${subject_listing}`,
                formatLoadingMessage: function() {
                    return 'Fetching student, please wait...';
                },
                toolbar: '<div id="table-toolbar"></div>',
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
                ]
            });
            $('#viewStudent').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }

        $(document).ready(function() {

            var $table = $('#table');
            $table.bootstrapTable({
                exportDataType: $(this).val(),
                printPageBuilder: function printPageBuilder(table) {
                    return myCustomPrint(table, "List of Attendance");
                },
            });

            var $table1 = $('#table1');
            $table1.bootstrapTable({});

        });
    </script>
@endsection
