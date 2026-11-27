@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h1 class="mb-0">Students</h1>
        <a class="btn btn-accent" href="{{ route('teacher.students.create') }}">+ Add Student</a>
    </div>

    <div class="portal-card">
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
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">
                                No students yet. Add a student to one of your subjects.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
