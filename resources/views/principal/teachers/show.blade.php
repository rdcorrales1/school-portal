@extends('layouts.app')

@section('title', $teacher->name)

@section('content')
    <div class="mb-4">
        <a class="btn btn-sm btn-outline-light mb-3" href="{{ route('principal.teachers.index') }}">&larr; Back to Teachers</a>
        <h1 class="mb-1">{{ $teacher->name }}</h1>
        <p class="mb-0 mono">{{ $teacher->email }}</p>
    </div>

    <div class="portal-card">
        <h2 class="mb-3">Subjects taught</h2>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted" style="font-size: 12px; font-weight: 600;">
                        <th>Code</th>
                        <th>Subject</th>
                        <th class="text-end">Students</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subjects as $subject)
                        <tr>
                            <td class="mono">
                                <a href="{{ route('principal.subjects.show', $subject) }}">{{ $subject->code }}</a>
                            </td>
                            <td>{{ $subject->name }}</td>
                            <td class="mono text-end">{{ $subject->students_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">No subjects yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
