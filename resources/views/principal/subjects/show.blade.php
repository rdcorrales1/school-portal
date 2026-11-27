@extends('layouts.app')

@section('title', $subject->name)

@section('content')
    <div class="mb-4">
        <a class="btn btn-sm btn-outline-light mb-3" href="{{ route('principal.subjects.index') }}">&larr; Back to Subjects</a>
        <h1 class="mb-1">{{ $subject->name }}</h1>
        <p class="mb-0">
            <span class="mono">{{ $subject->code }}</span>
            &middot;
            @if ($subject->teacher)
                <a href="{{ route('principal.teachers.show', $subject->teacher) }}">{{ $subject->teacher->name }}</a>
            @else
                No teacher
            @endif
        </p>
    </div>

    <div class="portal-card">
        <h2 class="mb-3">Enrolled students</h2>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted" style="font-size: 12px; font-weight: 600;">
                        <th>Student No</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="mono">{{ $student->student_no }}</td>
                            <td>
                                <a href="{{ route('principal.students.show', $student) }}">{{ $student->user->name }}</a>
                            </td>
                            <td>{{ $student->user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">No students enrolled yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
