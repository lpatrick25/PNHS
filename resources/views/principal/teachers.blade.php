@extends('layout.master')
@section('title')
    | Teachers
@endsection
@section('active-teacher')
    active
@endsection
@section('app-title')
    Teachers
@endsection
@section('content')
    <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="false"
        data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
        data-show-copy-rows="false" data-page-number="1" data-total-rows="11" data-show-toggle="false"
        data-show-export="false" data-filter-control="true" data-show-search-clear-button="false" data-key-events="false"
        data-mobile-responsive="true" data-check-on-init="true" data-show-print="false" data-sticky-header="true"
        data-url="/teachers/">
        <thead>
            <tr>
                <th data-field="count">#</th>
                <th data-field="image">Image</th>
                <th data-field="teacher_id">TEACHER ID</th>
                <th data-field="teacher_name">TEACHER NAME</th>
                <th data-field="contact">CONTACT</th>
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
                    return myCustomPrint(table, "List of Teacher");
                },
            });

        });
    </script>
@endsection
