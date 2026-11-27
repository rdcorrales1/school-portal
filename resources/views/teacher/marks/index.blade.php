@extends('layouts.app')

@section('title', 'Marks')

@section('content')
    <h1 class="mb-4">Marks</h1>

    <div class="portal-card mb-4">
        <form method="GET" action="{{ route('teacher.marks.index') }}" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="subject_id" class="form-label">Subject</label>
                <select id="subject_id" name="subject_id" class="form-select" required>
                    <option value="">Choose a subject</option>
                    @foreach ($subjects as $item)
                        <option value="{{ $item->id }}" @selected($subject && $subject->id === $item->id)>
                            {{ $item->code }} · {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="quarter" class="form-label">Quarter</label>
                <select id="quarter" name="quarter" class="form-select">
                    @for ($q = 1; $q <= 4; $q++)
                        <option value="{{ $q }}" @selected($quarter === $q)>Quarter {{ $q }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-accent w-100">Show Students</button>
            </div>
        </form>
    </div>

    @if ($subject)
        <form method="POST" action="{{ route('teacher.marks.store') }}" novalidate>
            @csrf
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
            <input type="hidden" name="quarter" value="{{ $quarter }}">

            <div class="portal-card">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase small text-muted" style="font-size: 12px; font-weight: 600;">
                                <th>Student No</th>
                                <th>Name</th>
                                <th style="width: 140px;">Mark (0–100)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                @php($current = $existingMarks->get($student->id))
                                <tr>
                                    <td class="mono">{{ $student->student_no }}</td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>
                                        <input type="number" min="0" max="100" step="1"
                                               name="marks[{{ $student->id }}]"
                                               aria-label="Mark for {{ $student->user->name }}"
                                               class="form-control mono @error('marks.'.$student->id) is-invalid @enderror"
                                               value="{{ old('marks.'.$student->id, $current?->mark) }}">
                                        @error('marks.'.$student->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-4">
                                        No students are enrolled in this subject yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($students->isNotEmpty())
                    <div class="mt-4">
                        <button type="submit" class="btn btn-accent">Save Marks</button>
                    </div>
                @endif
            </div>
        </form>
    @endif
@endsection
