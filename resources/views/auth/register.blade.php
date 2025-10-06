@extends('layouts.guest')
@section('title', 'Register - SafeZone')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-5">
        <!-- Card -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Create an Account</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="username"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role Selection -->
                        <div class="mb-3">
                            <label for="role">Select Role</label>
                            <div class="input-group">
                                <select name="role" id="role" class="form-control form-control-lg border-left-0" required>
                                    <option value="" disabled selected>-- Choose Role --</option>
                                    <option value="agent">Agent</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="medical">Medical</option>
                                </select>
                            </div>
                        </div>
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               autocomplete="new-password"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               required
                               autocomplete="new-password"
                               class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Register Button -->
                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        {{ __('Register') }}
                    </button>

                    <!-- Already Registered -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            {{ __('Already registered? Log in') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
