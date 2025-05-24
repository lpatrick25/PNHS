@extends('layout.master')
@section('title')
    | Users
@endsection
@section('active-users')
    active
@endsection
@section('app-title')
    User Management
@endsection
@section('content')
    <div id="show-msg"></div>
    <table id="table" data-show-refresh="true" data-auto-refresh="true" data-pagination="true" data-show-columns="true"
        data-cookie="false" data-cookie-id-table="table" data-search="true" data-click-to-select="false"
        data-show-copy-rows="true" data-page-number="1" data-total-rows="11" data-show-toggle="true" data-show-export="true"
        data-filter-control="true" data-show-search-clear-button="false" data-key-events="true"
        data-mobile-responsive="true" data-check-on-init="true" data-show-print="true" data-sticky-header="true"
        data-defer-url="" data-url="/admin/users" data-pagination="true" data-toolbar="">
        <thead>
            <tr>
                <th data-field="count">#</th>
                <th data-field="image">IMAGE</th>
                <th data-field="fullname">NAME</th>
                <th data-field="contact">CONTACT</th>
                <th data-field="email">EMAIL</th>
                <th data-field="username">USERNAME</th>
                <th data-field="role">ROLE</th>
                <th data-field="action" data-print-ignore="true">ACTION</th>
            </tr>
        </thead>
    </table>
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

            var $table = $('#table');
            $table.bootstrapTable({
                exportDataType: $(this).val(),
                printPageBuilder: function printPageBuilder(table) {
                    return myCustomPrint(table, "List of Users");
                },
            });

        });
    </script>
@endsection
