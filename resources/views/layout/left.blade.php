<aside class="main-sidebar elevation-4 sidebar-dark-indigo sidebar-no-expand text-lg">
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('dist/img/PNHS_Logo.png') }}" alt="PNHS Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">PNHS System</span>
    </a>

    <div class="sidebar">
        <div class="user-panel d-flex align-items-center p-3">
            <div class="image">
                <img src="{{ Session::get('image') }}" class="img-circle elevation-2"
                    style="height: 50px; width: 50px; object-fit: cover;" alt="User Image">
            </div>
            <div class="info ms-3">
                <a href="#" class="d-block fw-bold" style="font-size: 1rem;">{{ Session::get('fullname') }}</a>
                <span class="d-block text-muted"
                    style="font-size: 0.85rem;">{{ Session::get('is_adviser') ? 'Adviser' : Str::ucfirst(Session::get('role')) }}</span>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child nav-child-indent"
                data-widget="treeview" role="menu" data-accordion="false">
                @if (Session::get('role') === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('viewDashboardAdmin') }}" class="nav-link @yield('active-dashboard')">
                            <i class="nav-icon ion ion-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewStudents') }}" class="nav-link @yield('active-student-list')">
                            <i class="nav-icon ion ion-university"></i>
                            <p>Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewTeachers') }}" class="nav-link @yield('active-teacher-list')">
                            <i class="nav-icon ion ion-person"></i>
                            <p>Teacher</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewPrincipals') }}" class="nav-link @yield('active-principal-list')">
                            <i class="nav-icon ion ion-ribbon-a"></i>
                            <p>Principal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewAdvisers') }}" class="nav-link @yield('active-advisers')">
                            <i class="nav-icon ion ion-person-stalker"></i>
                            <p>Adviser</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewSubjectList') }}" class="nav-link @yield('active-subject')">
                            <i class="nav-icon ion ion-ios-bookmarks-outline"></i>
                            <p>Subjects</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewSubjectTeacherList') }}" class="nav-link @yield('active-subject_teacher')">
                            <i class="nav-icon ion ion-briefcase"></i>
                            <p>Subject Teachers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewSettings') }}" class="nav-link @yield('active-settings')">
                            <i class="nav-icon ion ion-gear-a"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewUsers') }}" class="nav-link @yield('active-users')">
                            <i class="nav-icon ion ion-person-add"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                @endif
                @if (Session::get('role') === 'principal')
                    <li class="nav-item">
                        <a href="{{ route('viewDashboardPrincipal') }}" class="nav-link @yield('active-dashboard')">
                            <i class="nav-icon ion ion-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewTeacherList') }}" class="nav-link @yield('active-teacher')">
                            <i class="nav-icon ion ion-person-stalker"></i>
                            <p>Teachers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewStudentList') }}" class="nav-link @yield('active-student')">
                            <i class="nav-icon ion ion-university"></i>
                            <p>Students</p>
                        </a>
                    </li>
                @endif
                @if (Session::get('role') === 'teacher')
                    <li class="nav-item">
                        <a href="{{ route('viewDashboardTeacher') }}" class="nav-link @yield('active-dashboard')">
                            <i class="nav-icon ion ion-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewAdvisory') }}" class="nav-link @yield('active-student')">
                            <i class="nav-icon ion ion-person-stalker"></i>
                            <p>Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewTeacherSubject') }}" class="nav-link @yield('active-subject')">
                            <i class="nav-icon ion ion-clipboard"></i>
                            <p>Subject Handle</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewAttendanceTeacher') }}" class="nav-link @yield('active-attendance')">
                            <i class="nav-icon ion ion-calendar"></i>
                            <p>Attendance</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewClassRecordTeacher') }}" class="nav-link @yield('active-class-records')">
                            <i class="nav-icon ion ion-ios-book"></i>
                            <p>Class Records</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewReportCardTeacher') }}" class="nav-link @yield('active-report-card')">
                            <i class="nav-icon ion ion-document-text"></i>
                            <p>Report Card</p>
                        </a>
                    </li>
                @endif
                @if (Session::get('role') === 'student')
                    <li class="nav-item">
                        <a href="{{ route('viewDashboardStudent') }}" class="nav-link @yield('active-dashboard')">
                            <i class="nav-icon ion ion-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewAttendances') }}" class="nav-link @yield('active-attendances')">
                            <i class="nav-icon ion ion-calendar"></i>
                            <p>Attendance</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewGrades') }}" class="nav-link @yield('active-grades')">
                            <i class="nav-icon ion ion-document-text"></i>
                            <p>Grade</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('viewClassRecordStudent') }}" class="nav-link @yield('active-class-records')">
                            <i class="nav-icon ion ion-ios-book"></i>
                            <p>Class Records</p>
                        </a>
                    </li>
                @endif
                @if (Session::get('role') !== 'admin')
                    <li class="nav-item">
                        <a href="{{ route('viewProfile') }}" class="nav-link @yield('active-profile')">
                            <i class="nav-icon ion ion-person"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" id="logout">
                        <i class="nav-icon ion ion-log-out"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
