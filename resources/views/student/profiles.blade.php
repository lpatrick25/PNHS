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
                            <span class="text-danger" style="text-decoration: underline;">Student Profile</span>
                        </p>
                        <img src="{{ asset($student->image) }}" alt="Avatar Image" style="height: 250px; width: 100%;">
                        <hr>
                        <div class="form-group">
                            <label>Student LRN:</label>
                            <p class="form-control">{{ $student->student_lrn }}</p>
                        </div>
                        <p class="text-bold text-center">
                            <span class="text-danger" style="text-decoration: underline;">Parents Information</span>
                        </p>
                        <div class="form-group">
                            <label>Mother's Name:</label>
                            <p class="form-control">{{ $student->mother_firstname }} {{ $student->mother_middlename }}
                                {{ $student->mother_lastname }}</p>
                        </div>
                        <div class="form-group">
                            <label>Father's Name:</label>
                            <p class="form-control">{{ $student->father_firstname }} {{ $student->father_middlename }}
                                {{ $student->father_lastname }} {{ $student->father_suffix }}</p>
                        </div>
                        <div class="form-group">
                            <label>Guardian's Name:</label>
                            <p class="form-control">{{ $student->guardian }}</p>
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
                                <p class="form-control">{{ $student->first_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Middle Name:</label>
                                <p class="form-control">{{ $student->middle_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Last Name:</label>
                                <p class="form-control">{{ $student->last_name }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Suffix:</label>
                                <p class="form-control">{{ $student->extension_name }}</p>
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
                                <p class="form-control">{{ $student->region_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Province Name:</label>
                                <p class="form-control">{{ $student->province_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Municipality Name:</label>
                                <p class="form-control">{{ $student->municipality_name }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Brgy Name:</label>
                                <p class="form-control">{{ $student->brgy_name }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-sm-12">
                                <h3 class="text-center">Student Information</h3>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label>Religion:</label>
                                <p class="form-control">{{ $student->religion }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Birthday:</label>
                                <p class="form-control">{{ date('F j, Y', strtotime($student->birthday)) }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Gender:</label>
                                <p class="form-control">{{ $student->sex }}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Disability:</label>
                                <p class="form-control">{{ $student->disability }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Address if Boarding:</label>
                                <p class="form-control">{{ $student->address_ifboarding }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Email Address:</label>
                                <p class="form-control">{{ $student->email }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Parents Contact Number:</label>
                                <p class="form-control">{{ $student->parent_contact }}</p>
                            </div>
                            <div class="col-lg-6">
                                <label>Contact Number:</label>
                                <p class="form-control">{{ $student->contact }}</p>
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
