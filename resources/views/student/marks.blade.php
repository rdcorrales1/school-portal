@extends('layouts.app')

@section('title', 'My Marks')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0" style="font-family: var(--font-heading); color: var(--text-on-blue);">My Marks</h1>
    </div>

    <div class="card" style="background: var(--surface-white); border-radius: var(--radius-lg);">
        <div class="card-body" style="padding: var(--space-6);">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr style="background: var(--surface-cool-gray); color: var(--text-muted); text-transform: uppercase; font-size: 12px; font-weight: 600;">
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Quarter</th>
                            <th>Mark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($marks as $mark)
                            <tr>
                                <td style="font-family: var(--font-mono);">{{ $mark->subject->code }}</td>
                                <td>{{ $mark->subject->name }}</td>
                                <td style="font-family: var(--font-mono);">{{ $mark->quarter }}</td>
                                <td style="font-family: var(--font-mono);">{{ $mark->mark }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center" style="color: var(--text-muted);">
                                    No marks yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
