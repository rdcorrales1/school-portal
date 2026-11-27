@extends('layouts.app')

@section('title', $student->user->name)

@section('content')
    <div class="mb-4">
        <a class="btn btn-sm btn-outline-light mb-3" href="{{ route('principal.students.index') }}">&larr; Back to Students</a>
        <h1 class="mb-1">{{ $student->user->name }}</h1>
        <p class="mb-0 mono">{{ $student->student_no }} &middot; {{ $student->user->email }}</p>
    </div>

    <div class="portal-card mb-4">
        <h2 class="mb-3">Subjects</h2>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted" style="font-size: 12px; font-weight: 600;">
                        <th>Code</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subjects as $subject)
                        <tr>
                            <td class="mono">
                                <a href="{{ route('principal.subjects.show', $subject) }}">{{ $subject->code }}</a>
                            </td>
                            <td>{{ $subject->name }}</td>
                            <td>
                                @if ($subject->teacher)
                                    <a href="{{ route('principal.teachers.show', $subject->teacher) }}">{{ $subject->teacher->name }}</a>
                                @else
                                    <span class="text-muted">No teacher</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">Not enrolled in any subject yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="portal-card">
        <h2 class="mb-3">Marks</h2>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted" style="font-size: 12px; font-weight: 600;">
                        <th>Subject</th>
                        <th>Quarter</th>
                        <th class="text-end">Mark</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($marks as $mark)
                        <tr>
                            <td>{{ $mark->subject->name }}</td>
                            <td class="mono">Q{{ $mark->quarter }}</td>
                            <td class="mono text-end">{{ $mark->mark }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">No marks yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
