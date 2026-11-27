@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <h1 class="mb-4">Students</h1>

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
                            <td>
                                <a href="{{ route('principal.students.show', $student) }}">{{ $student->user->name }}</a>
                            </td>
                            <td>{{ $student->user->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">No students yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
