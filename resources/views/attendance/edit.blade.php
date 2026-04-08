@extends('layouts.master')

@section('title')
    Edit Attendance
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Attendance: {{ $attendance->employee->user->name }}</h4>
                    <p class="card-title-desc">Update the attendance record for
                        {{ $attendance->attendance_date->format('d M, Y') }}.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" id="attendanceForm">
                        @csrf
                        @method('PUT')

                        @if (Auth::user()->hasRole('admin'))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="employee_id" class="form-label">Employee</label>
                                        <select class="form-select @error('employee_id') is-invalid @enderror"
                                            id="employee_id" name="employee_id" required>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('employee_id', $attendance->employee_id) == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->user->name }} ({{ $employee->employee_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="attendance_date" class="form-label">Attendance Date</label>
                                        <input type="date"
                                            class="form-control @error('attendance_date') is-invalid @enderror"
                                            id="attendance_date" name="attendance_date"
                                            value="{{ old('attendance_date', $attendance->attendance_date->format('Y-m-d')) }}"
                                            required>
                                        @error('attendance_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}">
                            <input type="hidden" name="attendance_date"
                                value="{{ $attendance->attendance_date->format('Y-m-d') }}">
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="check_in" class="form-label">Check In Time</label>
                                    <input type="time" class="form-control" id="check_in" name="check_in"
                                        value="{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="check_out" class="form-label">Check Out Time</label>
                                    <input type="time" class="form-control" id="check_out" name="check_out"
                                        value="{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status"
                                        required>
                                        <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>
                                            Present</option>
                                        <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>
                                            Absent</option>
                                        <option value="half_day" {{ $attendance->status == 'half_day' ? 'selected' : '' }}>
                                            Half Day</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-md" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none me-1" id="spinner" role="status"
                                    aria-hidden="true"></span>
                                <span id="btnText">Update</span>
                            </button>
                            <a href="{{ route('attendance.index') }}"
                                class="btn btn-outline-secondary w-md ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/js/custom/form-submit.js') }}"></script>
    <script>
        disableSubmitButton('attendanceForm', 'submitBtn', 'btnText', 'spinner', 'Updating...');
    </script>
@endsection
