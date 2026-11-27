@extends('layouts.app')

@section('title', 'Add Subject')

@section('content')
    <h1 class="mb-4">Add Subject</h1>

    <div class="portal-card" style="max-width: 520px;">
        <form method="POST" action="{{ route('teacher.subjects.store') }}" novalidate>
            @csrf

            <div class="mb-3">
                <label for="code" class="form-label">Subject code</label>
                <input id="code" name="code" type="text"
                       class="form-control mono @error('code') is-invalid @enderror"
                       value="{{ old('code') }}" placeholder="CS-101" required>
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="form-label">Subject name</label>
                <input id="name" name="name" type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-accent">Save Subject</button>
        </form>
    </div>
@endsection
