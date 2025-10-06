<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SafeZone Rwanda') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('assets/css/dashlitee1e3.css?ver=3.2.4') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/themee1e3.css?ver=3.2.4') }}">
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger"><a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none"
                            data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a><a href="#"
                            class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                            data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a></div>
                    <div class="nk-sidebar-brand"><a href="{{ route('dashboard') }}" class="logo-link nk-sidebar-logo">
                            {{ config('app.name', 'SafeZone Rwanda') }}
                        </a></div>
                </div>
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                @if(Auth::check())
                                {{-- Admin --}}
                                @if(Auth::user()->role === 'admin')
                                <li class="nk-menu-item"><a href="{{ route('dashboard') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span><span
                                            class="nk-menu-text">Default Dashboard</span></a></li>
                                <li class="nk-menu-item"><a href="{{ route('users.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-bitcoin-cash"></em></span><span
                                            class="nk-menu-text">User Management</span></a></li>
                                <li class="nk-menu-item"><a href="{{ route('safe-zone-cases.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-growth"></em></span><span
                                            class="nk-menu-text">Cases Report</span></a></li>
                                <li class="nk-menu-item"><a href="{{ route('evidences.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-coins"></em></span><span
                                            class="nk-menu-text">Evidences</span></a>
                                </li>
                                <li class="nk-menu-item"><a href="{{ route('reporters.list') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span><span
                                            class="nk-menu-text">Reporters</span></a>
                                </li>
                                <li class="nk-menu-item"><a href="{{ route('medical-staff.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-users"></em></span><span
                                            class="nk-menu-text">Medical Staff</span></a>

                                </li>
                                <li class="nk-menu-item"><a href="{{ route('agents.list') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span><span
                                            class="nk-menu-text">Agents</span></a>

                                </li>

                                {{-- Agent --}}
                                @elseif(Auth::user()->role === 'agent')
                                <li class="nk-menu-item"><a href="{{ route('dashboard') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span><span
                                            class="nk-menu-text">Default Dashboard</span></a></li>
                                <li class="nk-menu-item"><a href="{{ route('safe-zone-cases.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-growth"></em></span><span
                                            class="nk-menu-text">Cases Report</span></a></li>
                                <li class="nk-menu-item"><a href="{{ route('evidences.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-coins"></em></span><span
                                            class="nk-menu-text">Evidences</span></a>
                                </li>
                                <li class="nk-menu-item"><a href="{{ route('reporters.list') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span><span
                                            class="nk-menu-text">Reporters</span></a>
                                </li>
                                <li class="nk-menu-item"><a href="{{ route('medical-staff.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-users"></em></span><span
                                            class="nk-menu-text">Medical Staff</span></a>

                                </li>

                                {{-- Medical Staff --}}
                                @elseif(Auth::user()->role === 'medical_staff')
                                <li class="nk-menu-item"><a href="{{ route('dashboard') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span><span
                                            class="nk-menu-text">Default Dashboard</span></a></li>
                                <li class="nk-menu-item"><a href="{{ route('safe-zone-cases.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-growth"></em></span><span
                                            class="nk-menu-text">Cases Report</span></a></li>
                                <li class="nk-menu-item"><a href="{{ route('evidences.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-coins"></em></span><span
                                            class="nk-menu-text">Evidences</span></a>
                                </li>
                                <li class="nk-menu-item"><a href="{{ route('reporters.list') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span><span
                                            class="nk-menu-text">Reporters</span></a>
                                </li>
                                {{-- Survivor/User --}}
                                @elseif(Auth::user()->role === 'user')
                                <li class="nk-menu-item"><a href="{{ route('dashboard') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span><span
                                            class="nk-menu-text">Default Dashboard</span></a></li>
                                <li class="nk-menu-item"><a data-bs-toggle="modal" data-bs-target="#reportCaseModal" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-growth"></em></span><span
                                            class="nk-menu-text">Report a Case</span></a></li>
                                <li class="nk-menu-item"><a href="{{ route('user.reportCases.index') }}" class="nk-menu-link"><span
                                            class="nk-menu-icon"><em class="icon ni ni-coins"></em></span><span
                                            class="nk-menu-text">My Cases</span></a>
                                </li>
                                @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-wrap ">
                @include('layouts.navigation')

                <!-- Page Content -->
                <div class="nk-content ">
                    @yield('content')
                </div>
            </div>

            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright float-center"> &copy; 2025 {{ config('app.name') }}</div>
                    </div>
                </div>
            </div>

            <!-- Report Case Modal -->
            <div class="modal fade" id="reportCaseModal" tabindex="-1" aria-labelledby="reportCaseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="reportCaseModalLabel">Report a Case</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form id="reportCaseForm" action="{{ route('user.reportCases.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                </div>

                                <!-- Name of Survivor -->
                                <div class="mb-3">
                                    <label for="survivorName" class="form-label">Name of Survivor</label>
                                    <input type="text" class="form-control" id="survivorName" name="survivor_name" placeholder="Enter name of survivor" required>
                                </div>

                                <!-- phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                                </div>

                                <!-- Type of GBV -->
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type of GBV</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="" selected disabled>Select type</option>
                                        <option value="physical">Physical</option>
                                        <option value="sexual">Sexual</option>
                                        <option value="psychological">Psychological</option>
                                    </select>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description of Incident</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                </div>

                                <!-- Location -->
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location (Optional)</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
                                </div>

                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="reportCaseForm" class="btn btn-primary">Submit Case</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bundlee1e3.js?ver=3.2.4') }}"></script>
    <script src="{{ asset('assets/js/scriptse1e3.js?ver=3.2.4') }}"></script>
    <script src="{{ asset('assets/js/demo-settingse1e3.js?ver=3.2.4') }}"></script>
    <script src="{{ asset('assets/js/charts/gd-defaulte1e3.js?ver=3.2.4') }}"></script>
    <script src="{{ asset('assets/js/libs/datatable-btnse1e3.js?ver=3.2.4') }}"></script>
</body>

</html>