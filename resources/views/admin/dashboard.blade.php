@extends('layout.master')
@section('title')
    | Dashboard
@endsection
@section('active-dashboard')
    active
@endsection
@section('app-title')
    Dashboard
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $dashboard['principals'] }}<sup style="font-size: 20px"></sup></h3>
                    <p>No. Principal</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i> <!-- Icon for Principal -->
                </div>
                <a href="{{ route('viewPrincipals') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $dashboard['students'] }}<sup style="font-size: 20px"></sup></h3>
                    <p>No. Students</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i> <!-- Icon for Students -->
                </div>
                <a href="{{ route('viewStudents') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $dashboard['teachers'] }}<sup style="font-size: 20px"></sup></h3>
                    <p>No. Teachers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i> <!-- Icon for Teachers -->
                </div>
                <a href="{{ route('viewTeachers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $dashboard['users'] }}<sup style="font-size: 20px"></sup></h3>
                    <p>No. Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i> <!-- Icon for Users -->
                </div>
                <a href="{{ route('viewUsers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $dashboard['advisers'] }}<sup style="font-size: 20px"></sup></h3>
                    <p>No. Advisers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i> <!-- Icon for Advisers -->
                </div>
                <a href="{{ route('viewAdvisers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {});
    </script>
@endsection
