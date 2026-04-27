<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    {{-- Sidebar toggle --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    {{-- Right side --}}
    <ul class="navbar-nav ml-auto">

        @php
            $webUser = Auth::guard('web')->user();
            $currentUser = $staffUser ?? $webUser;
        @endphp

        @if($currentUser)
        <li class="nav-item dropdown">

            <a class="nav-link dropdown-toggle"
               data-toggle="dropdown"
               href="#"
               role="button"
               aria-haspopup="true"
               aria-expanded="false">

                <i class="far fa-user-circle mr-1"></i>
                {{ $currentUser->emp_name ?? $currentUser->name ?? 'User' }}
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow">

                <span class="dropdown-header text-muted small">
                    Signed in as <strong>{{ $currentUser->emp_email ?? $currentUser->email ?? session('email') ?? 'Unknown' }}</strong>
                </span>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2 text-muted"></i> Profile
                </a>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-key mr-2 text-muted"></i> Reset Password
                </a>

                <div class="dropdown-divider"></div>

                <a href="#"
                   class="dropdown-item text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>

                <form id="logout-form"
                      method="POST"
                      action="{{ route('logout') }}"
                      class="d-none">
                    @csrf
                </form>

            </div>

        </li>
        @endif

    </ul>

</nav>
