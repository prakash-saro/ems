@extends('layouts.master')

@section('title')
    Create Attendance
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Manual Attendance</h4>
                    <p class="card-title-desc">Fill in the form to log attendance for an employee manually.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.store') }}" method="POST" id="attendanceForm">
                        @csrf

                        <div class="row">
                            @if (Auth::user()->hasRole('admin'))
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="employee_id" class="form-label">Employee</label>
                                        <select class="form-select @error('employee_id') is-invalid @enderror"
                                            id="employee_id" name="employee_id" required>
                                            <option value="" disabled selected>Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->user->name }} ({{ $employee->employee_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="{{ Auth::user()->hasRole('admin') ? 'col-md-6' : 'col-md-12' }}">
                                <div class="mb-3">
                                    <label for="attendance_date" class="form-label">Attendance Date</label>
                                    <input type="date"
                                        class="form-control @error('attendance_date') is-invalid @enderror"
                                        id="attendance_date" name="attendance_date"
                                        value="{{ old('attendance_date', date('Y-m-d')) }}" required>
                                    @error('attendance_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="check_in" class="form-label">Check In Time</label>
                                    <input type="time" class="form-control @error('check_in') is-invalid @enderror"
                                        id="check_in" name="check_in" value="{{ old('check_in', '09:00') }}">
                                    @error('check_in')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="check_out" class="form-label">Check Out Time</label>
                                    <input type="time" class="form-control @error('check_out') is-invalid @enderror"
                                        id="check_out" name="check_out" value="{{ old('check_out') }}">
                                    @error('check_out')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-md" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none me-1" id="spinner" role="status"
                                    aria-hidden="true"></span>
                                <span id="btnText">Save</span>
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
        disableSubmitButton('attendanceForm', 'submitBtn', 'btnText', 'spinner', 'Saving...');
    </script>
@endsection
