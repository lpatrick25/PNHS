@extends('layout.master')
@section('title')
    | Profile
@endsection
@section('active-profile')
    active
@endsection
@section('app-title')
    Profile
@endsection
@section('content')
    <div class="card card-outline card-success">
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 mg-b-20 mg-lr-20">
                        <p class="text-bold text-center">
                            <span class="text-danger" style="text-decoration: underline;">Teacher Profile</span>
                        </p>
                        <img src="{{ asset($teacher->image) }}" alt="Avatar Image" style="height: 250px; width: 100%;">
                        <hr>
                        <div class="form-group">
                            <label>Teacher ID:</label>
                            <p class="form-control">{{ $teacher->teacher_id }}</p>
                        </div>
                        <hr class="bg-success">
                        <button type="button" class="btn btn-primary btn-block btn-md" onclick="update({{ Session::get('user_id') }})"><i class="fa fa-edit"></i> Change Password</button>
                    </div>
                    <div class="col-lg-9 mg-b-20 mg-lr-20">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <h3 class="text-center">Personal Information</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label>First Name:</label>
                                <p class="form-control">{{ $teacher->first_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Middle Name:</label>
                                <p class="form-control">{{ $teacher->middle_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Last Name:</label>
                                <p class="form-control">{{ $teacher->last_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Suffix:</label>
                                <p class="form-control">{{ $teacher->extension_name }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-sm-12">
                                <h3 class="text-center">Address Information</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Region Name:</label>
                                <p class="form-control">{{ $teacher->region_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Province Name:</label>
                                <p class="form-control">{{ $teacher->province_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Municipality Name:</label>
                                <p class="form-control">{{ $teacher->municipality_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Brgy Name:</label>
                                <p class="form-control">{{ $teacher->brgy_name }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-sm-12">
                                <h3 class="text-center">Teacher Information</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label>Civil Status:</label>
                                <p class="form-control">{{ $teacher->civil_status }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Religion:</label>
                                <p class="form-control">{{ $teacher->religion }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Birthday:</label>
                                <p class="form-control">{{ date('F j, Y', strtotime($teacher->birthday)) }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Gender:</label>
                                <p class="form-control">{{ $teacher->sex }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Email Address:</label>
                                <p class="form-control">{{ $teacher->email }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Contact Number:</label>
                                <p class="form-control">{{ $teacher->contact }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

            $('#change-pass').click(function(event) {
                event.preventDefault();

                $('#updatePassword').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true,
                });
            });

        });
    </script>
@endsection
