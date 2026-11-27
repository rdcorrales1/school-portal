@extends('layouts.app')

@section('title', $subject->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h1 class="mb-0">{{ $subject->name }}</h1>
        <a class="btn btn-outline-light" href="{{ route('principal.subjects.index') }}">Back to Subjects</a>
    </div>

    <div class="portal-card mb-4">
        <h2 class="mb-3">Details</h2>
        <dl class="row mb-0">
            <dt class="col-sm-3">Code</dt>
            <dd class="col-sm-9 mono">{{ $subject->code }}</dd>

            <dt class="col-sm-3">Teacher</dt>
            <dd class="col-sm-9">{{ $subject->teacher?->name ?? 'No teacher' }}</dd>

            <dt class="col-sm-3">Teacher email</dt>
            <dd class="col-sm-9">{{ $subject->teacher?->email ?? '-' }}</dd>
        </dl>
    </div>

    <div class="portal-card">
        <h2 class="mb-3">Students</h2>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Student No</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="mono">{{ $student->student_no }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">
                                No students enrolled in this subject yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
