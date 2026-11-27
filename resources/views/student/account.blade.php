@extends('layouts.app')

@section('title', 'My Account')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0" style="font-family: var(--font-heading); color: var(--text-on-blue);">My Account</h1>
    </div>

    <div class="portal-card" style="max-width: 560px;">
        <h3 class="mb-3">Profile picture</h3>

        <div class="d-flex align-items-center gap-4 mb-4">
            @include('partials.avatar', ['user' => $user, 'size' => 96])
            <div>
                <div class="fw-semibold">{{ $user->name }}</div>
                <div class="small text-muted">{{ $user->email }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('student.account.photo') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="photo" class="form-label">Choose a new picture</label>
                <input type="file" id="photo" name="photo" accept="image/png,image/jpeg"
                       class="form-control @error('photo') is-invalid @enderror">
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">JPG or PNG, up to 2 MB.</div>
            </div>
            <button type="submit" class="btn btn-cyan px-4">Upload picture</button>
        </form>
    </div>
@endsection
