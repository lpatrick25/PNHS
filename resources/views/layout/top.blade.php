<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            @if (Session::get('role') === 'student')
                <a class="nav-link" href="#" data-toggle="modal" role="button">
                    <i class="fas fa-calendar-alt"></i> School Year: <span>{{ session('school_year') }}</span>
                </a>
            @else
                <a class="nav-link" href="#" data-toggle="modal" data-target="#settingsModal" role="button">
                    <i class="fas fa-calendar-alt"></i> School Year: <span>{{ session('school_year') }}</span>
                </a>
            @endif

        </li>
    </ul>
</nav>
