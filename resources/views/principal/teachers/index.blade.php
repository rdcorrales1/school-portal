@extends('layouts.app')

@section('title', 'Teachers')

@section('content')
    <h1 class="mb-4">Teachers</h1>

    <div class="portal-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted" style="font-size: 12px; font-weight: 600;">
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                        <tr>
                            <td>
                                <a href="{{ route('principal.teachers.show', $teacher) }}">{{ $teacher->name }}</a>
                            </td>
                            <td>{{ $teacher->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted text-center py-4">No teachers yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
