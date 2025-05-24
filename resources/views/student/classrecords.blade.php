@extends('layout.master')
@section('title')
    | Subject Handled
@endsection
@section('active-class-records')
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
        data-url="{{ route('getStudentSubject') }}">
        <thead>
            <tr>
                <th data-field="count">#</th>
                <th data-field="subject_code">Subject Code</th>
                <th data-field="subject_name">Subject Name</th>
                <th data-field="teacher_name">Teacher Name</th>
                <th data-field="action">Action</th>
            </tr>
        </thead>
    </table>
@endsection
@section('scripts')
    <script type="text/javascript">
        function view(subject_listing) {
            window.location.href = `/student/viewStudentRecords/${subject_listing}`;
        }

        $(document).ready(function() {

            var $table = $('#table');
            $table.bootstrapTable({
                exportDataType: $(this).val(),
                printPageBuilder: function printPageBuilder(table) {
                    return myCustomPrint(table, "List of Attendance");
                },
            });

        });
    </script>
@endsection
