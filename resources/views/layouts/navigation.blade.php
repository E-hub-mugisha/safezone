<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            {{ config('app.name', 'SafeZone') }}
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('safe_zone_cases.index') ? 'active' : '' }}"
                        href="{{ route('safe-zone-cases.index') }}">
                        Cases
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('evidences.index') ? 'active' : '' }}"
                        href="{{ route('evidences.index') }}">
                        Evidences
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reporters.list') ? 'active' : '' }}"
                        href="{{ route('reporters.list') }}">
                        Reporters
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('medical-staff.index') ? 'active' : '' }}"
                        href="{{ route('medical-staff.index') }}">
                        Medical Staff
                    </a>
                </li>
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Notifications Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-5"></i>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown"
                        style="width: 320px; max-height: 400px; overflow-y: auto;">
                        <li class="dropdown-header fw-bold">Notifications</li>
                        @forelse(Auth::user()->notifications()->latest()->take(10)->get() as $notification)
                            <li>
                                <a href="{{ url('/safe_zone_cases/'.$notification->data['case_id']) }}"
                                    class="dropdown-item small {{ $notification->read_at ? '' : 'fw-bold' }}">
                                    {{ $notification->data['message'] ?? 'New notification' }}<br>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @empty
                            <li class="dropdown-item text-muted">No notifications</li>
                        @endforelse
                    </ul>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-circle me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
