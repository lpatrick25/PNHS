@extends('layout.master')
@section('title')
    | Student Update
@endsection
@section('active-student-list')
    active
@endsection
@section('app-title')
    Students
@endsection
@section('active-student-open')
    menu-is-opening menu-open
@endsection
@section('content')
    <form id="updateForm" class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12" id="show-msg"></div>
                <div class="col-lg-3 my-body mg-b-20 mg-lr-20" style="display: block;">
                    <p class="text-bold text-center">
                        <span id="user-position" class="text-danger" style="text-decoration: underline;">STUDENT</span>
                    </p>
                    <img src="{{ asset('dist/img/avatar4.png') }}" alt="Avatar Image" style="350px; width: 100%"
                        id="user_picture">
                    <hr>
                    <div class="form-group">
                        <label>Student LRN:</label>
                        <input type="text" class="form-control" id="student_lrn" name="student_lrn"
                            value="{{ $student_lrn }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>RFID No:</label>
                        <input type="text" class="form-control" id="rfid_no" name="rfid_no" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-lg btn-block" id="pictureBtn"><i
                                class="fa fa-image"></i> PICTURE</button>
                    </div>
                </div>
                <div class="col-lg-9 my-body mg-lr-20">
                    <div class="row mg-t-10">
                        <div class="col-lg-12 col-sm-12">
                            <h3 class="text-center">Personal Information</h3>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="first_name">First Name: <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                placeholder="First Name" required>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="middle">Middle name: <span style="color:red;"></span></label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name"
                                placeholder="Middle Name">
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="last_name">Last Name: <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                placeholder="Last Name" required>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="extension_name">Extension Name: <span style="color:red;"></span></label>
                            <input type="text" class="form-control" id="extension_name" name="extension_name"
                                placeholder="Extension Name">
                        </div>
                        <div class="col-lg-12">
                            <p class="text-left text-danger"><strong>PERMANENT ADDRESS</strong></p>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="province_code">Province: <span style="color:red;">*</span></label>
                            <select class="form-control" id="province_code" name="province_code" required>
                                <option selected="true" value="REQUIRED" disabled>-- Select Province --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="municipality_code">Municipality: <span style="color:red;">*</span></label>
                            <select class="form-control" id="municipality_code" name="municipality_code" required="true">
                                <option selected="true" value="REQUIRED" disabled>-- Select Municipality --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="brgy_code">Barangay: <span style="color:red;">*</span></label>
                            <select class="form-control" id="brgy_code" name="brgy_code" required="true">
                                <option selected="true" value="REQUIRED" disabled>-- Select Barangay --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="zip_code">Zip Code: <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code"
                                placeholder="Zip Code" required readonly>
                        </div>
                        <div class="col-lg-12">
                            <p class="text-left text-danger"><strong>STUDENT INFORMATION</strong></p>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="religion">Religion: <span style="color:red;">*</span></label>
                            <select id="religion" name="religion" class="form-control">
                                <option selected="true" value="REQUIRED" disabled>-- Select Religion --</option>
                                <option>Roman Catholic</option>
                                <option>Seventh-Day Adventist</option>
                                <option>Iglesia ni Cristo</option>
                                <option>Jehovah Witnesses</option>
                                <option>Pentecostal</option>
                                <option>Church of Christ</option>
                                <option>Christian</option>
                                <option>Baptist</option>
                                <option>God is Able</option>
                                <option>UCCP</option>
                                <option>Church of God</option>
                                <option>Dating Daan</option>
                                <option>Jesus is Miracle</option>
                                <option>Rizal</option>
                                <option>Robin</option>
                                <option>JMCIM </option>
                                <option>Mormons</option>
                                <option>Magtotoo</option>
                                <option>Protestant</option>
                                <option>Born Again</option>
                                <option>Assemblies of God</option>
                                <option>Iglesia Filipina Independiente</option>
                                <option>Muslim</option>
                                <option>Iglesia Ni Cristo</option>
                                <option>Jerusalem</option>
                                <option>Foursquare</option>
                                <option>United Church of God</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="birthday">Birthday: <span style="color:red;">*</span></label>
                            <input type="date" class="form-control" id="birthday" name="birthday" required>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="sex">Sex: <span style="color:red;">*</span></label>
                            <select type="text" class="form-control" id="sex" name="sex">
                                <option selected="true" value="REQUIRED" disabled>-- Select Sex --</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="disability">Disability: <span style="color:red;">*</span></label>
                            <select id="disability" name="disability" class="form-control">
                                <option selected="true" value="REQUIRED" disabled>-- Select Disability --</option>
                                <option value="None">None</option>
                                <option value="Communication Disability">Communication Disability</option>
                                <option value="Disability due to Chronic Illness">Disability due to Chronic Illness
                                </option>
                                <option value="Learning Disability">Learning Disability</option>
                                <option value="Intellectual Disability">Intellectual Disability</option>
                                <option value="Orthopedic Disability">Orthopedic Disability</option>
                                <option value="Mental/ Psychosocial Disability">Mental/Psychosocial Disability</option>
                                <option value="Mental/ Psychosocial Disability">Mental/Psychosocial Disability</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="email">Email Address: <span style="color:red;">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email Address" required>
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="parent_contact">Parents Contact Number: <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="parent_contact" name="parent_contact"
                                data-mask="(+63) 999-999-9999" placeholder="(+63)" required>
                        </div>
                        <div class="form-group col-md-12 col-lg-4">
                            <label for="contact">Students Contact Number: <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="contact" name="contact"
                                data-mask="(+63) 999-999-9999" placeholder="(+63)" required>
                        </div>
                        <div class="col-lg-12">
                            <p class="text-left text-danger"><strong>PRESENT ADDRESS</strong></p>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="present_province_code">Province: <span style="color:red;">*</span></label>
                            <select class="form-control" id="present_province_code" name="present_province_code"
                                required>
                                <option selected="true" value="REQUIRED" disabled>-- Select Province --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="present_municipality_code">Municipality: <span style="color:red;">*</span></label>
                            <select class="form-control" id="present_municipality_code" name="present_municipality_code"
                                required="true">
                                <option selected="true" value="REQUIRED" disabled>-- Select Municipality --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="present_brgy_code">Barangay: <span style="color:red;">*</span></label>
                            <select class="form-control" id="present_brgy_code" name="present_brgy_code"
                                required="true">
                                <option selected="true" value="REQUIRED" disabled>-- Select Barangay --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 col-lg-3">
                            <label for="present_zip_code">Zip Code: <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="present_zip_code" name="present_zip_code"
                                placeholder="Zip Code" required readonly>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" value="" id="user_permanent_address"> <i></i> Use
                                    permanent address </label>
                                <hr>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p class="text-left text-danger"><strong>Family/Guardian Background</strong></p>
                        </div>
                        <div class="col-lg-12">
                            @include('form.family_guard')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary btn-lg">SAVE</button>
            <a href="{{ route('viewStudents') }}" type="button" class="btn btn-danger btn-lg">CANCEL</a>
        </div>
    </form>
    <div class="modal fade" id="updatePicture">
        <div class="modal-dialog">
            <form id="updatePictureForm" class="modal-content" enctype="multipart/form-data">
                <div class="modal-header">
                    <h3 class="modal-title">Update Picture</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="attachment">Upload Picture: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="attachment" name="attachment" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-lg btn-primary">SAVE</button>
                    <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">CANCEL</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        let selectedMunicipality, selectedBrgy, selectedPresentMunicipality, selectedPresentBrgy;
        $(document).ready(function() {

            $('#updateForm').trigger('reset');
            $('#updateForm').find('input').attr('disabled', true);
            $('#updateForm').find('select').attr('disabled', true);
            $('#updateForm').find('button').attr('disabled', true);
            $('select').trigger('chosen:updated');

            // Helper function to handle zip code update asynchronously
            function updateZipCode(municipalityCode, zipField) {
                $.ajax({
                    method: 'GET',
                    url: `/address/getZipCode/${municipalityCode}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        $(zipField).val(data.zip_code);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });
            }

            $.ajax({
                method: 'GET',
                url: '/address/getProvinces/8',
                dataType: 'JSON',
                cache: false,
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        $('#province_code').append('<option value="' + data[i].province_code +
                            '">' + data[i].province_name + '</option>');
                        $('#present_province_code').append('<option value="' + data[i]
                            .province_code +
                            '">' + data[i].province_name + '</option>');
                    }
                    $('#province_code').trigger('chosen:updated');
                    $('#present_province_code').trigger('chosen:updated');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.'
                    });
                }
            })

            $('#province_code').change(function() {
                var provinceCode = $('#province_code').val();

                $('#municipality_code').empty();
                $('#municipality_code').append(
                    '<option selected="true" value="NONE">-- Select Municipality --</option>');

                $.ajax({
                    method: 'GET',
                    url: `/address/getMunicipalities/${provinceCode}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            if (selectedMunicipality !== data[i].municipality_code) {
                                $('#municipality_code').append('<option value="' + data[i]
                                    .municipality_code + '">' + data[i].municipality_name +
                                    '</option>');
                            } else {
                                $('#municipality_code').append('<option value="' + data[i]
                                    .municipality_code + '" selected>' + data[i]
                                    .municipality_name +
                                    '</option>');
                            }
                        }
                        $('#municipality_code').trigger('chosen:updated');
                        $('#municipality_code').change();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });
            });

            $('#municipality_code').change(function() {
                var municipalityCode = $('#municipality_code').val();

                $('#brgy_code').empty();
                $('#brgy_code').append(
                    '<option selected="true" value="NONE">-- Select Barangay --</option>');

                $.ajax({
                    method: 'GET',
                    url: `/address/getBrgys/${municipalityCode}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            if (selectedBrgy !== data[i].brgy_code) {
                                $('#brgy_code').append('<option value="' + data[i].brgy_code +
                                    '">' + data[i].brgy_name + '</option>');
                            } else {
                                $('#brgy_code').append('<option value="' + data[i].brgy_code +
                                    '" selected>' + data[i].brgy_name + '</option>');
                            }
                        }
                        $('#brgy_code').trigger('chosen:updated');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });

                // Update zip code using asynchronous handling
                updateZipCode(municipalityCode, '#zip_code');
            });

            $('#present_province_code').change(function() {
                var provinceCode = $('#present_province_code').val();

                $('#present_municipality_code').empty();
                $('#present_municipality_code').append(
                    '<option selected="true" value="NONE">-- Select Municipality --</option>'
                );

                $.ajax({
                    method: 'GET',
                    url: `/address/getMunicipalities/${provinceCode}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            if (selectedPresentMunicipality === data[i]
                                .municipality_code) {
                                $('#present_municipality_code').append(
                                    `<option value="${data[i].municipality_code}" selected>${data[i].municipality_name}</option>`
                                );
                            } else {
                                $('#present_municipality_code').append(
                                    `<option value="${data[i].municipality_code}">${data[i].municipality_name}</option>`
                                );
                            }
                        }

                        $('#present_municipality_code').trigger('chosen:updated');
                        $('#present_municipality_code').change();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.',
                        });
                    },
                });
            });

            $('#present_municipality_code').change(function() {
                var municipalityCode = $('#present_municipality_code').val();

                $('#present_brgy_code').empty();
                $('#present_brgy_code').append(
                    '<option selected="true" value="NONE">-- Select Barangay --</option>');

                $.ajax({
                    method: 'GET',
                    url: `/address/getBrgys/${municipalityCode}`,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            if (selectedPresentBrgy === data[i].brgy_code) {
                                $('#present_brgy_code').append(
                                    `<option value="${data[i].brgy_code}" selected>${data[i].brgy_name}</option>`
                                );
                            } else {
                                $('#present_brgy_code').append(
                                    `<option value="${data[i].brgy_code}">${data[i].brgy_name}</option>`
                                );
                            }
                        }
                        $('#present_brgy_code').trigger('chosen:updated');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.'
                        });
                    }
                });

                // Update zip code asynchronously
                updateZipCode(municipalityCode, '#present_zip_code');
            });

            $('#user_permanent_address').click(function() {
                if ($(this).prop('checked')) {
                    // Get values from permanent address fields
                    var brgyCode = $('#brgy_code').val();
                    var provinceCode = $('#province_code').val();
                    var municipalityCode = $('#municipality_code').val();

                    if (provinceCode && municipalityCode && brgyCode) {
                        // Set selected values
                        selectedBrgy = brgyCode;
                        selectedMunicipality = municipalityCode;

                        // Update zip code asynchronously
                        updateZipCode(municipalityCode, '#present_zip_code');

                        // Make present address fields readonly-like
                        $('#present_province_code').val(provinceCode).trigger('chosen:updated');
                        $('#present_province_code').attr('data-readonly', 'true');
                        $('#present_province_code')
                            .change(); // Trigger change to update municipalities and barangays

                        $('#present_municipality_code').attr('data-readonly', 'true');
                        $('#present_brgy_code').attr('data-readonly', 'true');

                    } else {
                        // If any required field is missing, uncheck the checkbox and alert the user
                        $(this).prop('checked', false);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Address Information',
                            text: 'Please fill in all permanent address fields before copying to the present address.',
                        });
                    }
                } else {
                    // Clear present address fields when checkbox is unchecked
                    $('#present_province_code').val('').trigger('chosen:updated');
                    $('#present_province_code').removeAttr('data-readonly');

                    $('#present_municipality_code').empty().append(
                        '<option value="NONE">-- Select Municipality --</option>'
                    ).trigger('chosen:updated').removeAttr('data-readonly');

                    $('#present_brgy_code').empty().append(
                        '<option value="NONE">-- Select Barangay --</option>'
                    ).trigger('chosen:updated').removeAttr('data-readonly');

                    $('#present_zip_code').val('');
                }
            });

            let student_lrn = $('#student_lrn').val();

            $.ajax({
                method: 'GET',
                url: `/students/${student_lrn}`,
                dataType: 'JSON',
                cache: false,
                success: function(response) {
                    if (response) {
                        $('#rfid_no').val(response.rfid_no);
                        $('#first_name').val(response.first_name);
                        $('#middle_name').val(response.middle_name);
                        $('#last_name').val(response.last_name);
                        $('#extension_name').val(response.extension_name);
                        $('#religion').val(response.religion);
                        $('#birthday').val(response.birthday);
                        $('#sex').val(response.sex);
                        $('#disability').val(response.disability);
                        $('#email').val(response.email);
                        $('#parent_contact').val(response.parent_contact);
                        $('#contact').val(response.contact);
                        $('#mother_first_name').val(response.mother_first_name);
                        $('#mother_middle_name').val(response.mother_middle_name);
                        $('#mother_last_name').val(response.mother_last_name);
                        $('#mother_address').val(response.mother_address);
                        $('#father_first_name').val(response.father_first_name);
                        $('#father_middle_name').val(response.father_middle_name);
                        $('#father_last_name').val(response.father_last_name);
                        $('#father_suffix').val(response.father_suffix);
                        $('#father_address').val(response.father_address);
                        $('#guardian').val(response.guardian);
                        $('#guardian_address').val(response.guardian_address);
                        $('#user_picture').prop('src', response.image);

                        selectedBrgy = response.brgy_code;
                        selectedMunicipality = response.municipality_code;
                        selectedPresentBrgy = response.present_brgy_code;
                        selectedPresentMunicipality = response.present_municipality_code;

                        if (selectedBrgy === selectedPresentBrgy) {
                            $('#user_permanent_address').prop('checked', true);
                        }

                        $('#province_code').val(response.province_code);
                        $('#present_province_code').val(response.present_province_code);

                        $('#updateForm').find('input').removeAttr('disabled');
                        $('#updateForm').find('select').removeAttr('disabled');
                        $('#updateForm').find('button').removeAttr('disabled');
                        $('select').trigger('chosen:updated');
                        $('#province_code').change();
                        $('#present_province_code').change();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.'
                    });
                }
            });

            $('#pictureBtn').click(function() {
                $('#updatePicture').modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            });

            $('#updatePictureForm').submit(function(event) {
                event.preventDefault();

                $('#show-msg').html('');
                const requiredFields = $(this).find('input[required], select[required]');

                let isEmptyField = false;
                requiredFields.each(function() {
                    if ($(this).val() === '' || $(this).val() === 'REQUIRED') {
                        isEmptyField = true;
                    }
                });

                if (isEmptyField) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Some fields are empty'
                    });
                } else {
                    $('#updatePicture').modal('hide');
                    $('#updatePictureForm').find('button[type=submit]').attr('disabled', true);
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'SAVE',
                        cancelButtonText: 'CANCEL',
                        reverseButtons: false,
                        allowOutsideClick: false,
                        showClass: {
                            popup: 'animated fadeInDown'
                        },
                        hideClass: {
                            popup: 'animated fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var formData = new FormData($('#updatePictureForm')[0]);

                            $.ajax({
                                method: 'POST', // Use 'POST' for uploads, or 'PUT' if updating
                                url: `/students/updateImage/${student_lrn}`,
                                data: formData,
                                processData: false,
                                contentType: false,
                                dataType: 'JSON',
                                success: function(response) {
                                    if (response.valid) {
                                        $('#show-msg').html(
                                            `<div class="alert alert-success">${response.msg}</div>`
                                        );

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                        $('#user_picture').attr("src", response
                                            .image); // Update image source
                                    } else {
                                        $('#show-msg').html(
                                            `<div class="alert alert-danger">${response.msg}</div>`
                                        );

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    if (jqXHR.responseJSON && jqXHR.responseJSON
                                        .error) {
                                        let errorMsg = "Error submitting data: " + jqXHR
                                            .responseJSON.error;
                                        $('#show-msg').html(
                                            `<div class="alert alert-danger">${errorMsg}</div>`
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
                        $('#updatePictureForm').find('button[type=submit]').removeAttr('disabled');
                    });
                }
            });

            $('#updateForm').submit(function(event) {
                event.preventDefault();

                $('#show-msg').html('');
                const requiredFields = $(this).find('input[required], select[required]');

                let isEmptyField = false;
                requiredFields.each(function() {
                    if ($(this).val() === '' || $(this).val() === 'REQUIRED') {
                        isEmptyField = true;
                    }
                });

                if (isEmptyField) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Some fields are empty'
                    });
                } else {
                    $('#updateForm').find('button[type=submit]').attr('disabled', true);
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'UPDATE',
                        cancelButtonText: 'CANCEL',
                        reverseButtons: false,
                        allowOutsideClick: false,
                        showClass: {
                            popup: 'animated fadeInDown'
                        },
                        hideClass: {
                            popup: 'animated fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'PUT',
                                url: `/students/${student_lrn}`,
                                data: $('#updateForm').serialize(),
                                dataType: 'JSON',
                                cache: false,
                                success: function(response) {
                                    if (response.valid == true) {
                                        $('html, body').animate({
                                            scrollTop: 0
                                        }, 800);
                                        $('#show-msg').html(
                                            '<div class="alert alert-success">' +
                                            response.msg + '<div>');

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    } else {
                                        $('#show-msg').html(
                                            '<div class="alert alert-danger">' +
                                            response.msg + '<div>');

                                        // Remove the notification after 5 seconds (5000 milliseconds)
                                        setTimeout(function() {
                                            $('#show-msg').html(
                                                ''); // Clears the notification
                                        }, 5000); // 5000 milliseconds = 5 seconds

                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    if (jqXHR.responseJSON && jqXHR.responseJSON
                                        .error) {
                                        var errors = jqXHR.responseJSON.error;
                                        var errorMsg = "Error submitting data: "
                                            .errors + ". ";
                                        $('#show-msg').html(
                                            '<div class="alert alert-danger">' +
                                            errorMsg + '</div>');

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
                        $('#updateForm').find('button[type=submit]').removeAttr('disabled');
                    });
                }
            });

        });
    </script>
@endsection
