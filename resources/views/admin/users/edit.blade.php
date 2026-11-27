@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <h1 class="mb-2">Reset Password</h1>
    <p class="text-muted mb-4">
        {{ $user->name }} · <span class="mono">{{ $user->email }}</span> · <span class="text-capitalize">{{ $user->role }}</span>
    </p>

    <div class="portal-card" style="max-width: 520px;">
        <form method="POST" action="{{ route('admin.users.password', $user) }}" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="password" class="form-label">New password (at least 8 characters)</label>
                <input id="password" name="password" type="password" autocomplete="new-password"
                       class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Type the new password again</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                       class="form-control" required>
            </div>

            <button type="submit" class="btn btn-accent">Save New Password</button>
            <a class="btn btn-link" href="{{ route('admin.users.index') }}">Cancel</a>
        </form>
    </div>
@endsection
