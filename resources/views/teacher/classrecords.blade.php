@extends('layout.master')
@section('title')
    | Class Records
@endsection
@section('active-class-records')
    active
@endsection
@section('app-title')
Class Records
@endsection
@section('content')
    <div id="show-msg"></div>
    <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="false"
        data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
        data-show-copy-rows="false" data-page-number="1" data-total-rows="11" data-show-toggle="false"
        data-show-export="false" data-filter-control="true" data-show-search-clear-button="false" data-key-events="false"
        data-mobile-responsive="true" data-check-on-init="true" data-show-print="false" data-sticky-header="true"
        data-url="/classRecords/getClassRecordsByTeacher/{{ $teacher_id }}">
        <thead>
            <tr>
                <th data-field="count">#</th>
                <th data-field="subject">Subject</th>
                <th data-field="grade_level_section">Grade Level & Section</th>
                <th data-field="adviser_name">Adviser Name</th>
                <th data-field="school_year">School Year</th>
                <th data-field="action">Action</th>
            </tr>
        </thead>
    </table>
@endsection
@section('scripts')
    <script type="text/javascript">
        function view(subject_listing) {
            window.location.href = `/teacher/viewClassRecord/${subject_listing}`;
        }

        $(document).ready(function() {

            var $table = $('#table');
            $table.bootstrapTable({
                exportDataType: $(this).val(),
                printPageBuilder: function printPageBuilder(table) {
                    return myCustomPrint(table, "List of Class Records");
                },
            });

            var $table1 = $('#table1');
            $table1.bootstrapTable({});

        });
    </script>
@endsection
