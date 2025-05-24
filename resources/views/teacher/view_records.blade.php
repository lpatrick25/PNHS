<input type="hidden" class="form-control" id="subjectListing" name="subjectListing" value="{{ $subject_listing }}">
<input type="hidden" class="form-control" id="records_name" name="records_name" value="{{ $request->records_name }}">
<input type="hidden" class="form-control" id="quarter" name="quarter" value="{{ $request->quarter }}">
<div id="toolbar-4">
    <button class="btn btn-primary btn-md" id="back-btn"><i class="fa fa-arrow-left"></i> Go Back</button>
</div>
<table id="table4" data-show-refresh="true" data-auto-refresh="true" data-pagination="false"
    data-show-columns="false" data-cookie="false" data-cookie-id-table="table" data-search="false"
    data-click-to-select="false" data-show-copy-rows="false" data-page-number="1" data-total-rows="11"
    data-show-toggle="false" data-show-export="false" data-filter-control="true" data-show-search-clear-button="false"
    data-key-events="false" data-mobile-responsive="true" data-check-on-init="true" data-show-print="false"
    data-sticky-header="true" data-url="" data-toolbar="#toolbar-4">
    <thead>
        <tr>
            <th data-field="count">#</th>
            <th data-field="image">Image</th>
            <th data-field="student_lrn">Student LRN</th>
            <th data-field="student_name">Student Name</th>
            <th data-field="action">Score</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(document).ready(function() {

        $('#back-btn').click(function(event) {
            event.preventDefault();

            $('#add-class-records').html('');
            $('#class-records-tables').show();
        });

        var $table4 = $('#table4');
        $table4.bootstrapTable({
            url: `/classRecords/viewClassRecords/${$('#records_name').val()}`,
            method: 'GET', // Use GET to fetch the records
            queryParams: function(params) {
                // Include subject_listing in the request
                params.subject_listing = $('#subjectListing').val();
                params.quarter = $('#quarter').val();
                return params;
            },
            responseHandler: function(res) {
                // Handle the response to only return valid data
                if (res.valid) {
                    return res.data;
                } else {
                    $('#show-msg').html(
                        '<div class="alert alert-danger">' +
                        res.msg + '</div>'
                    );

                    // Remove the notification after 5 seconds (5000 milliseconds)
                    setTimeout(function() {
                        $('#show-msg').html(
                            ''); // Clears the notification
                    }, 5000); // 5000 milliseconds = 5 seconds

                    return [];
                }
            },
            columns: [{
                    field: 'count',
                    title: '#',
                },
                {
                    field: 'image',
                    title: 'Image',
                    formatter: function(value, row, index) {
                        return value; // Render the image HTML
                    },
                },
                {
                    field: 'student_lrn',
                    title: 'Student LRN',
                },
                {
                    field: 'student_name',
                    title: 'Student Name',
                },
                {
                    field: 'action',
                    title: 'Action',
                    formatter: function(value, row, index) {
                        return value; // Render the score input field
                    },
                },
            ],
        });
    });
</script>
