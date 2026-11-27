@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
    <h1 class="mb-4">Subjects</h1>

    <div class="portal-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted" style="font-size: 12px; font-weight: 600;">
                        <th>Code</th>
                        <th>Subject</th>
                        <th>Teacher</th>
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
                            <td>{{ $subject->teacher?->name ?? 'No teacher' }}</td>
                            <td class="mono text-end">{{ $subject->students_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted text-center py-4">No subjects yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
