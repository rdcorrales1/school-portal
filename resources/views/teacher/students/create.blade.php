@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
    <h1 class="mb-4">Add Student</h1>

    <div class="portal-card" style="max-width: 520px;">
        @if ($subjects->isEmpty())
            <p class="text-muted mb-3">You need a subject before you can add a student.</p>
            <a class="btn btn-accent" href="{{ route('teacher.subjects.create') }}">+ Add Subject</a>
        @else
            <form method="POST" action="{{ route('teacher.students.store') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full name</label>
                    <input id="name" name="name" type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email (used to sign in)</label>
                    <input id="email" name="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="subject_id" class="form-label">Enroll in subject</label>
                    <select id="subject_id" name="subject_id"
                            class="form-select @error('subject_id') is-invalid @enderror" required>
                        <option value="">Choose a subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>
                                {{ $subject->code }} · {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-accent">Save Student</button>
            </form>
        @endif
    </div>
@endsection
