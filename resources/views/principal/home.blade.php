@extends('layouts.app')

@section('title', 'Principal Home')

@section('content')
    <h1 class="mb-2">Principal Home</h1>
    <p class="text-muted mb-4">Welcome, {{ auth()->user()->name }}.</p>

    <div class="portal-card">
        <h2 class="mb-2">Overview</h2>
        <p class="text-muted mb-3">View all students, teachers and subjects. Read only.</p>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-accent" href="{{ route('principal.students.index') }}">Students</a>
            <a class="btn btn-accent" href="{{ route('principal.teachers.index') }}">Teachers</a>
            <a class="btn btn-accent" href="{{ route('principal.subjects.index') }}">Subjects</a>
        </div>
    </div>
@endsection
