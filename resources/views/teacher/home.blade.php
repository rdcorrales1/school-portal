@extends('layouts.app', ['title' => 'Teacher Home'])

@section('content')
    <h1 class="mb-2">Teacher Home</h1>
    <p class="text-muted mb-4">Welcome, {{ auth()->user()->name }}.</p>

    <div class="portal-card">
        <h2 class="mb-2">Dashboard</h2>
        <p class="text-muted mb-0">Students and marks pages are coming next.</p>
    </div>
@endsection
