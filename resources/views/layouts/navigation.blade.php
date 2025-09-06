<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #0d83fd;">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}">
            {{ config('app.name', 'SafeZone') }}
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav text-center">
    @if(Auth::check())
        {{-- Admin --}}
        @if(Auth::user()->role === 'admin')
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('users.index') ? 'active' : '' }}"
                   href="{{ route('users.index') }}">Users</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('safe-zone-cases.index') ? 'active' : '' }}"
                   href="{{ route('safe-zone-cases.index') }}">Cases</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('evidences.index') ? 'active' : '' }}"
                   href="{{ route('evidences.index') }}">Evidences</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('reporters.list') ? 'active' : '' }}"
                   href="{{ route('reporters.list') }}">Reporters</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('medical-staff.index') ? 'active' : '' }}"
                   href="{{ route('medical-staff.index') }}">Medical Staff</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('agents.list') ? 'active' : '' }}"
                   href="{{ route('agents.list') }}">Agents</a>
            </li>

        {{-- Agent --}}
        @elseif(Auth::user()->role === 'agent')
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('safe-zone-cases.index') ? 'active' : '' }}"
                   href="{{ route('safe-zone-cases.index') }}">Cases</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('evidences.index') ? 'active' : '' }}"
                   href="{{ route('evidences.index') }}">Evidences</a>
            </li>

        {{-- Medical Staff --}}
        @elseif(Auth::user()->role === 'medical_staff')
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('safe-zone-cases.index') ? 'active' : '' }}"
                   href="{{ route('safe-zone-cases.index') }}">Cases</a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('medical-staff.index') ? 'active' : '' }}"
                   href="{{ route('medical-staff.index') }}">Medical Reports</a>
            </li>

        {{-- Survivor/User --}}
        @elseif(Auth::user()->role === 'user')
            <li class="nav-item mx-2">
                <a class="nav-link text-white {{ request()->routeIs('user.reportCases.index') ? 'active' : '' }}"
                   href="{{ route('user.reportCases.index') }}">My Reports</a>
            </li>
        @endif
    @endif
</ul>

        </div>

        <!-- Right Side -->
        <ul class="navbar-nav ms-auto align-items-center">
            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown me-2">
                <a class="nav-link position-relative text-white" href="#" id="notificationDropdown" role="button"
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
                <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-2"></i> {{ Auth::user()->name }}
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
</nav>
