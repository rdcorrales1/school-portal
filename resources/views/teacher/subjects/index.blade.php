@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h1 class="mb-0">Subjects</h1>
        <a class="btn btn-accent" href="{{ route('teacher.subjects.create') }}">+ Add Subject</a>
    </div>

    <div class="portal-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted" style="font-size: 12px; font-weight: 600;">
                        <th>Code</th>
                        <th>Name</th>
                        <th>Students</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subjects as $subject)
                        <tr>
                            <td class="mono">{{ $subject->code }}</td>
                            <td>{{ $subject->name }}</td>
                            <td class="mono">{{ $subject->students_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center py-4">
                                No subjects yet. Add your first subject.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
