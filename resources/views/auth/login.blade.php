@extends('layouts.app')

@section('title', 'Sign In · Student & Academic Management Portal')

@section('content')
<div class="row g-0 min-vh-100">

    {{-- Left: showcase panel --}}
    <div class="col-lg-6 bg-royal-blue d-flex flex-column justify-content-between p-5">
        <div>
            <div class="fw-bold text-on-blue mb-4" style="font-family: var(--font-heading);">Portal</div>
            <h1 class="text-on-blue">Student &amp; Academic Management Portal</h1>
            <p class="text-muted-on-blue fs-5">Track students, enter marks and view results in one place.</p>
        </div>

        <div class="feature-card my-4">
            <h3>Marks made simple</h3>
            <p class="text-muted-token mb-0">Teachers enter marks by quarter. Students see only their own results.</p>
        </div>

        <div>
            <span class="school-year-badge mono">SY 2026–2027</span>
        </div>
    </div>

    {{-- Right: sign-in form --}}
    <div class="col-lg-6 surface-white d-flex align-items-center justify-content-center p-4">
        <div class="w-100" style="max-width: 400px;">
            <h2 class="mb-1">Portal Sign In</h2>
            <p class="text-muted-token mb-4">Students, Teachers &amp; Principal</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        autocomplete="username"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="current-password"
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-cyan w-100">Sign In</button>
            </form>
        </div>
    </div>

</div>
@endsection
