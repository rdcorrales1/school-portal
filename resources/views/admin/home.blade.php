@extends('layouts.app')

@section('title', 'Admin Home')

@section('content')
    <h1 class="mb-2">Admin Home</h1>
    <p class="text-muted mb-4">Welcome, {{ auth()->user()->name }}.</p>

    <div class="portal-card">
        <h2 class="mb-2">Users</h2>
        <p class="text-muted mb-3">Reset a password for any teacher, student or principal.</p>
        <a class="btn btn-accent" href="{{ route('admin.users.index') }}">Go to Users</a>
    </div>
@endsection
