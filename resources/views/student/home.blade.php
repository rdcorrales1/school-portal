@extends('layouts.app')

@section('title', 'Student Home')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0" style="font-family: var(--font-heading); color: var(--text-on-blue);">Welcome, {{ $user->name }}</h1>
        <a href="{{ route('student.marks') }}" class="btn btn-cyan">My Marks</a>
    </div>

    <div class="card" style="background: var(--surface-white); border-radius: var(--radius-lg);">
        <div class="card-body" style="padding: var(--space-6);">
            <h3 class="mb-2" style="font-family: var(--font-heading); color: var(--text-dark);">Your portal</h3>
            <p class="mb-0" style="color: var(--text-muted);">
                Open "My Marks" to see your marks for each subject and quarter.
            </p>
        </div>
    </div>
@endsection
