@extends('layout.master')
@section('title')
    | {{ $subjectTeacher->subject_code . ' - ' . $subjectTeacher->subject_name }}
@endsection
@section('active-class-records')
    active
@endsection
@section('app-title')
    Class Record <span class="text-success" style="font-weight: bolder;">Grade
        {{ $subjectTeacher->grade_level }}</span> - <span class="text-danger"
        style="font-weight: bolder;">{{ $subjectTeacher->section }}</span>
@endsection
@section('custom-css')
    <style type="text/css">
        td,
        th,
        thead {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            /* Ensures borders do not double up */
            width: 100%;
            /* Optional, ensures the table stretches full width */
        }

        th,
        td {
            text-align: center;
            /* Centers text in table cells */
            padding: 8px;
            /* Adds padding for better readability */
        }

        .bootstrap-table .fixed-table-container .table th,
        .bootstrap-table .fixed-table-container .table td {
            vertical-align: middle;
            box-sizing: border-box;
            border: 1px solid black;
        }

        .popover {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1060;
            display: none;
            max-width: 276px;
            padding: 1px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: left;
            text-align: start;
            text-decoration: none;
            text-shadow: none;
            text-transform: none;
            letter-spacing: normal;
            word-break: normal;
            word-spacing: normal;
            word-wrap: normal;
            white-space: normal;
            background-color: #fff;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: 6px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            line-break: auto
        }

        .popover.top {
            margin-top: -10px
        }

        .popover.right {
            margin-left: 10px
        }

        .popover.bottom {
            margin-top: 10px
        }

        .popover.left {
            margin-left: -10px
        }

        .popover-title {
            padding: 8px 14px;
            margin: 0;
            font-size: 14px;
            background-color: #f7f7f7;
            border-bottom: 1px solid #ebebeb;
            border-radius: 5px 5px 0 0
        }

        .popover-content {
            padding: 9px 14px
        }

        .popover>.arrow,
        .popover>.arrow:after {
            position: absolute;
            display: block;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid
        }

        .popover>.arrow {
            border-width: 11px
        }

        .popover>.arrow:after {
            content: "";
            border-width: 10px
        }

        .popover.top>.arrow {
            bottom: -11px;
            left: 50%;
            margin-left: -11px;
            border-top-color: #999;
            border-top-color: rgba(0, 0, 0, .25);
            border-bottom-width: 0
        }

        .popover.top>.arrow:after {
            bottom: 1px;
            margin-left: -10px;
            content: " ";
            border-top-color: #fff;
            border-bottom-width: 0
        }

        .popover.right>.arrow {
            top: 50%;
            left: -11px;
            margin-top: -11px;
            border-right-color: #999;
            border-right-color: rgba(0, 0, 0, .25);
            border-left-width: 0
        }

        .popover.right>.arrow:after {
            bottom: -10px;
            left: 1px;
            content: " ";
            border-right-color: #fff;
            border-left-width: 0
        }

        .popover.bottom>.arrow {
            top: -11px;
            left: 50%;
            margin-left: -11px;
            border-top-width: 0;
            border-bottom-color: #999;
            border-bottom-color: rgba(0, 0, 0, .25)
        }

        .popover.bottom>.arrow:after {
            top: 1px;
            margin-left: -10px;
            content: " ";
            border-top-width: 0;
            border-bottom-color: #fff
        }

        .popover.left>.arrow {
            top: 50%;
            right: -11px;
            margin-top: -11px;
            border-right-width: 0;
            border-left-color: #999;
            border-left-color: rgba(0, 0, 0, .25)
        }

        .popover.left>.arrow:after {
            right: 1px;
            bottom: -10px;
            content: " ";
            border-right-width: 0;
            border-left-color: #fff
        }

        .editable-click:after {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            content: "\f044";
            /* fa-pencil-alt */
            margin-left: 5px;
            color: #007bff;
            /* Optional: Customize color */
        }

        /* Loading state icon replacement */
        .editableform-loading:after {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            content: "\f110";
            /* fa-spinner */
            margin-left: 5px;
            animation: spin 1s infinite linear;
            /* Add spinning animation */
        }

        /* Define spin animation for loading spinner */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .editableform {
            margin: 10px !important;
        }

        .bootstrap-table .fixed-table-container .table thead th {
            vertical-align: middle;
        }
    </style>
@endsection
@section('content')
    <div id="show-msg"></div>
    <input type="hidden" class="form-control" id="subjectListing" name="subjectListing"
        value="{{ $subjectTeacher->subject_listing }}">
    <div class="row" id="class-records-tables">
        <div class="col-lg-12">
            <hr class="card card-outline card-success">
            <div class="row">
                <div class="col-lg-6 text-left">
                    <a href="{{ route('viewClassRecordTeacher') }}" class="btn btn-danger btn-md"><i
                            class="fa fa-arrow-left"></i> Go Back</a>
                </div>
                <div class="col-lg-2 text-right">

                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <select name="select_quarter" id="select_quarter" class="form-control">
                            <option value="1st Quarter">1st Quarter</option>
                            <option value="2nd Quarter">2nd Quarter</option>
                            <option value="3rd Quarter">3rd Quarter</option>
                            <option value="4th Quarter">4th Quarter</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 text-right">
                    <button class="btn btn-success btn-md"
                        onclick="exportToExcel('{{ $subjectTeacher->subject_listing }}')">
                        <i class="fa fa-file-excel"></i> Export to Excel
                    </button>
                </div>
            </div>
            <hr class="card card-outline card-success">
        </div>
        <div class="col-lg-12 x-editable-list">
            <div id="toolbar-1">
                <h3>{{ $subjectTeacher->subject_name }}</h3>
            </div>
            <table id="table1" data-show-refresh="true" data-auto-refresh="true" data-pagination="false"
                data-show-columns="false" data-cookie="false" data-cookie-id-table="table" data-search="false"
                data-click-to-select="false" data-show-copy-rows="false" data-page-number="1" data-total-rows="11"
                data-show-toggle="false" data-show-export="false" data-filter-control="true"
                data-show-search-clear-button="false" data-key-events="false" data-mobile-responsive="true"
                data-check-on-init="true" data-show-print="false" data-sticky-header="true" data-url=""
                data-toolbar="#toolbar-1">
                <thead>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
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
        let recordsID;

        function exportToExcel(subject_listing) {
            const startTime = Date.now();
            let timerInterval;

            Swal.fire({
                title: 'Exporting Class Records',
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
                method: 'GET',
                url: `/classRecords/exportToExcel/${subject_listing}`,
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

        function defaultTableHeader() {
            return `
                    <tr>
                        <th class="text-center" style="min-width: 200px;">LEARNERS' NAME</th>
                        <th colspan="10" class="text-center">WRITTEN WORKS (30%)</th>
                        <th colspan="10" class="text-center">PERFORMANCE TASKS (50%)</th>
                        <th class="text-center" style="min-width: 50px;">QUARTERLY ASSESSMENT (20%)</th>
                    </tr>
                    <tr>
                        <th></th>
                        <!-- WRITTEN WORKS Columns -->
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <!-- PERFORMANCE TASKS Columns -->
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <!-- QUARTERLY ASSESSMENT -->
                        <th>1</th>
                    </tr>
             `;
        }

        function refresh_tables() {
            $.ajax({
                url: `/classRecords/${$('#select_quarter').val()}`, // Replace with your endpoint URL
                method: 'GET',
                success: function(response) {
                    const students = response.students || [];
                    const scores = response.scores || {};

                    if (!Array.isArray(students)) {
                        console.error("Expected 'students' to be an array, but got:", students);
                        return;
                    }

                    const thead = $("#table1 thead");
                    thead.empty(); // Clear existing header
                    thead.append(defaultTableHeader());

                    if (students.length > 0) {
                        // Update the table header
                        let headerRow = `<tr>`;
                        headerRow +=
                            `<th class="text-center" style="min-width: 200px;">Highest Possible Score</th>`; // Student Name Header

                        // Add headers for Written Works
                        if (Array.isArray(scores.writtenWorks)) {
                            scores.writtenWorks.forEach((score, index) => {
                                headerRow += `
                                <th class="editable"
                                    data-name="total_written_work_${index + 1}"
                                    data-pk="Written Works ${index + 1},${score.quarter}"
                                    data-update-type="totalScore">
                                    ${score.score !== null ? score.score : ``}
                                </th>`;
                            });
                        }

                        // Add headers for Performance Tasks
                        if (Array.isArray(scores.performanceTasks)) {
                            scores.performanceTasks.forEach((score, index) => {
                                headerRow += `
                                <th class="editable"
                                    data-name="total_performance_task_${index + 1}"
                                    data-pk="Performance Tasks ${index + 1},${score.quarter}"
                                    data-update-type="totalScore">
                                    ${score.score !== null ? score.score : ``}
                                </th>`;
                            });
                        }

                        // Add header for Quarterly Assessment
                        if (scores.quarterlyAssessment && typeof scores.quarterlyAssessment === "object") {
                            headerRow += `
                            <th class="editable"
                                data-name="total_quarterly_assessment"
                                data-pk="Quarterly Assessment,${scores.quarterlyAssessment.quarter}"
                                data-update-type="totalScore">
                                ${scores.quarterlyAssessment.score !== null ? scores.quarterlyAssessment.score : "Quarterly Assessment"}
                            </th>`;
                        }

                        headerRow += `</tr>`;
                        thead.append(headerRow);
                    }

                    // Update the table body
                    const tbody = $("#table1 tbody");
                    tbody.empty();

                    students.forEach((student) => {
                        let row = `<tr>`;
                        row +=
                            `<td class="text-left" style="min-width: 200px;">${student.name}</td>`; // Student Name

                        // Add Written Works Scores
                        student.writtenWorks.forEach((score, index) => {
                            row += `
                            <td class="editable"
                                data-name="written_work_${index + 1}"
                                data-pk="${student.writtenWorksRecordsID[index]}"
                                data-update-type="score">
                                ${score !== 0 ? score : ""}
                            </td>`;
                        });

                        // Add Performance Tasks Scores
                        student.performanceTasks.forEach((score, index) => {
                            row += `
                            <td class="editable"
                                data-name="performance_task_${index + 1}"
                                data-pk="${student.performanceTasksRecordsID[index]}"
                                data-update-type="score">
                                ${score !== 0 ? score : ""}
                            </td>`;
                        });

                        // Add Quarterly Assessment Score
                        row += `
                        <td class="editable"
                            data-name="quarterly_assessment"
                            data-pk="${student.quarterlyAssessmentRecordsID}"
                            data-update-type="score">
                            ${student.quarterlyAssessment !== 0 ? student.quarterlyAssessment : ""}
                        </td>`;

                        row += `</tr>`;
                        tbody.append(row);
                    });

                    // Initialize Bootstrap Table
                    $('#table1').bootstrapTable({
                        stickyHeader: true,
                        filterControl: true,
                        search: true,
                        pagination: false,
                        autoRefresh: true,
                        toolbarAlign: 'right',
                        buttonsAlign: 'left',
                        searchAlign: 'left',
                        classes: 'table table-bordered table-hover x-editor-custom',
                    });

                    // Initialize X-editable for all rows after appending them
                    initializeEditable();

                    console.log("Table updated successfully!");
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", status, error);
                },
            });
        }

        function initializeEditable() {
            // Global X-editable settings
            $.fn.editable.defaults.mode = 'inline';

            // Attach editable functionality to elements with the class "editable"
            $('.editable').editable({
                type: 'number', // Set a valid input type
                url: function(params) {
                    const pk = $(this).data('pk'); // Record ID
                    const updateType = $(this).data('update-type'); // Update type: "totalScore" or "score"
                    const value = params.value; // New value

                    // Call appropriate function based on data-update-type
                    if (updateType === "totalScore") {
                        return $.ajax({
                            url: '/teacher/updateTotalScore',
                            method: 'PUT',
                            data: {
                                pk: pk,
                                value: value
                            },
                            success: function(response) {
                                handleResponse(response);
                                $('#table1').bootstrapTable('refresh');
                            },
                            error: function() {
                                handleError();
                            }
                        });
                    } else if (updateType === "score") {
                        return $.ajax({
                            url: '/teacher/updateScore',
                            method: 'PUT',
                            data: {
                                pk: pk,
                                value: value
                            },
                            success: function(response) {
                                handleResponse(response);
                                $('#table1').bootstrapTable('refresh');
                            },
                            error: function() {
                                handleError();
                            }
                        });
                    } else {
                        console.error("Invalid update type:", updateType);
                    }
                },
                validate: function(value) {
                    if ($.trim(value) === '') {
                        return 'This field is required.';
                    }
                    if (isNaN(value) || value < 0 || value > 100) {
                        return 'Please enter a valid score between 0 and 100.';
                    }
                }
            });
        }

        function handleResponse(response) {
            if (response && response.valid) {
                $('#show-msg').html(
                    '<div class="alert alert-success">' +
                    response.msg + '</div>'
                );
            } else {
                $('#show-msg').html(
                    '<div class="alert alert-danger">' +
                    response.msg + '</div>'
                );
            }
        }

        function handleError() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again later.',
            });
        }

        $(document).ready(function() {

            $('#select_quarter').change(function() {
                refresh_tables();
            });

            $('#select_quarter').change();

            refresh_tables();
        });
    </script>
@endsection
