@extends('layouts.app')

@section('title', 'All Subjects')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h1 class="mb-0">All Subjects</h1>
    </div>

    <div class="portal-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Teacher</th>
                        <th>Students</th>
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
                            <td class="mono">{{ $subject->students_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted text-center py-4">
                                No subjects in the school yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
