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
                    <a href="{{ route('viewClassRecordStudent') }}" class="btn btn-danger btn-md"><i
                            class="fa fa-arrow-left"></i> Go Back</a>
                </div>
                <div class="col-lg-4">

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
@endsection
@section('scripts')
    <script type="text/javascript">
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
                                <th>
                                    ${score.score !== null ? score.score : `-`}
                                </th>`;
                            });
                        }

                        // Add headers for Performance Tasks
                        if (Array.isArray(scores.performanceTasks)) {
                            scores.performanceTasks.forEach((score, index) => {
                                headerRow += `
                                <th>
                                    ${score.score !== null ? score.score : `-`}
                                </th>`;
                            });
                        }

                        // Add header for Quarterly Assessment
                        if (scores.quarterlyAssessment && typeof scores.quarterlyAssessment === "object") {
                            headerRow += `
                            <th>
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
                            <td>
                                ${score !== 0 ? score : ""}
                            </td>`;
                        });

                        // Add Performance Tasks Scores
                        student.performanceTasks.forEach((score, index) => {
                            row += `
                            <td>
                                ${score !== 0 ? score : ""}
                            </td>`;
                        });

                        // Add Quarterly Assessment Score
                        row += `
                        <td>
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

                    console.log("Table updated successfully!");
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", status, error);
                },
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
