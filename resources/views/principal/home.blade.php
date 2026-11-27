@extends('layouts.app')

@section('title', 'Principal Home')

@section('content')
    <h1 class="mb-2">Principal Home</h1>
    <p class="text-muted mb-4">Welcome, {{ auth()->user()->name }}.</p>

    <div class="portal-card">
        <h2 class="mb-2">Overview</h2>
        <p class="text-muted mb-0">Use the Students and Teachers pages to see everyone in the school. These pages are read-only.</p>
    </div>
@endsection
