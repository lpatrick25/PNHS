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
                            <span class="text-danger" style="text-decoration: underline;">Principal Profile</span>
                        </p>
                        <img src="{{ asset($principal->image) }}" alt="Avatar Image" style="height: 250px; width: 100%;">
                        <hr>
                        <div class="form-group">
                            <label>Principal ID:</label>
                            <p class="form-control">{{ $principal->principal_id }}</p>
                        </div>
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
                                <p class="form-control">{{ $principal->first_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Middle Name:</label>
                                <p class="form-control">{{ $principal->middle_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Last Name:</label>
                                <p class="form-control">{{ $principal->last_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Suffix:</label>
                                <p class="form-control">{{ $principal->extension_name }}</p>
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
                                <p class="form-control">{{ $principal->region_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Province Name:</label>
                                <p class="form-control">{{ $principal->province_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Municipality Name:</label>
                                <p class="form-control">{{ $principal->municipality_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Brgy Name:</label>
                                <p class="form-control">{{ $principal->brgy_name }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-sm-12">
                                <h3 class="text-center">principal Information</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label>Civil Status:</label>
                                <p class="form-control">{{ $principal->civil_status }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Religion:</label>
                                <p class="form-control">{{ $principal->religion }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Birthday:</label>
                                <p class="form-control">{{ date('F j, Y', strtotime($principal->birthday)) }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Gender:</label>
                                <p class="form-control">{{ $principal->sex }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Email Address:</label>
                                <p class="form-control">{{ $principal->email }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Contact Number:</label>
                                <p class="form-control">{{ $principal->contact }}</p>
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
        $(document).ready(function() {});
    </script>
@endsection
