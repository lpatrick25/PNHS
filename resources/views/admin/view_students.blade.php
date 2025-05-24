@extends('layout.master')
@section('title')
    | Student
@endsection
@section('active-student-list')
    active
@endsection
@section('app-title')
    Students
@endsection
@section('content')
    <div id="toolbar">
        <a href="{{ route('viewAddStudent') }}" class="btn btn-primary btn-md btn-block"><i class="fa fa-user-plus"></i> Add
            New</a>
    </div>
    <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="false"
        data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
        data-show-copy-rows="false" data-page-number="1" data-total-rows="11" data-show-toggle="false"
        data-show-export="false" data-filter-control="true" data-show-search-clear-button="false" data-key-events="false"
        data-mobile-responsive="true" data-check-on-init="true" data-show-print="false" data-sticky-header="true"
        data-url="/students/" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th data-field="count">#</th>
                <th data-field="image">Image</th>
                <th data-field="rfid_no">RFID No</th>
                <th data-field="student_lrn">Student LRN</th>
                <th data-field="student_name">Student Name</th>
                <th data-field="contact">CONTACT</th>
                <th data-field="email">EMAIL</th>
                <th data-field="action">ACTION</th>
            </tr>
        </thead>
    </table>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            var $table = $('#table');
            $table.bootstrapTable({
                exportDataType: $(this).val(),
                printPageBuilder: function printPageBuilder(table) {
                    return myCustomPrint(table, "List of Students");
                },
            });

        });
    </script>
@endsection
