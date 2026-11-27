@extends('layouts.app')

@section('title', 'Student Home')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0" style="font-family: var(--font-heading); color: var(--text-on-blue);">Welcome, {{ $user->name }}</h1>
        <a href="{{ route('student.marks') }}" class="btn btn-cyan">My Marks</a>
    </div>

    <div class="card mb-4" style="background: var(--surface-white); border-radius: var(--radius-lg);">
        <div class="card-body" style="padding: var(--space-6);">
            <h3 class="mb-3" style="font-family: var(--font-heading); color: var(--text-dark);">My details</h3>
            <dl class="row mb-0">
                <dt class="col-sm-3" style="color: var(--text-muted);">Name</dt>
                <dd class="col-sm-9">{{ $user->name }}</dd>

                <dt class="col-sm-3" style="color: var(--text-muted);">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3" style="color: var(--text-muted);">Student no.</dt>
                <dd class="col-sm-9 mb-0" style="font-family: var(--font-mono);">{{ $student?->student_no ?? 'Not assigned yet' }}</dd>
            </dl>
        </div>
    </div>

    <div class="card" style="background: var(--surface-white); border-radius: var(--radius-lg);">
        <div class="card-body" style="padding: var(--space-6);">
            <h3 class="mb-3" style="font-family: var(--font-heading); color: var(--text-dark);">My subjects</h3>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr style="background: var(--surface-cool-gray); color: var(--text-muted); text-transform: uppercase; font-size: 12px; font-weight: 600;">
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subjects as $subject)
                            <tr>
                                <td style="font-family: var(--font-mono);">{{ $subject->code }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->teacher?->name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center" style="color: var(--text-muted);">
                                    You are not enrolled in any subject yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
