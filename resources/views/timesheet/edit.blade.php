@extends('layouts.master')

@section('title')
    Edit Timesheet
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Timesheet: {{ $timesheet->employee->user->name }}</h4>
                    <p class="card-title-desc">Update the details for the work log entry.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('timesheet.update', $timesheet->id) }}" method="POST" id="timesheetForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            @if (Auth::user()->hasRole('admin'))
                                <div class="col-md-6 mb-3">
                                    <label for="employee_id" class="form-label">Employee <span
                                            class="text-danger">*</span></label>
                                    <select name="employee_id" id="employee_id"
                                        class="form-select @error('employee_id') is-invalid @enderror" required>
                                        <option value="" disabled>Select Employee</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{ $emp->id }}"
                                                {{ old('employee_id', $timesheet->employee_id) == $emp->id ? 'selected' : '' }}>
                                                {{ $emp->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <label for="work_date" class="form-label">Work Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="work_date" id="work_date"
                                    class="form-control @error('work_date') is-invalid @enderror"
                                    value="{{ old('work_date', $timesheet->work_date->format('Y-m-d')) }}" required>
                                @error('work_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="hours_worked" class="form-label">Hours Worked <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.5" min="0.5" max="24" name="hours_worked"
                                    id="hours_worked" class="form-control @error('hours_worked') is-invalid @enderror"
                                    value="{{ old('hours_worked', $timesheet->hours_worked) }}" required>
                                @error('hours_worked')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending"
                                        {{ old('status', $timesheet->status) == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved"
                                        {{ old('status', $timesheet->status) == 'approved' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="rejected"
                                        {{ old('status', $timesheet->status) == 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="task_description" class="form-label">Task Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="task_description" id="task_description" rows="4"
                                    class="form-control @error('task_description') is-invalid @enderror" required>{{ old('task_description', $timesheet->task_description) }}</textarea>
                                @error('task_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary w-md" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none me-1" id="spinner" role="status"
                                    aria-hidden="true"></span>
                                <span id="btnText">Update</span>
                            </button>
                            <a href="{{ route('timesheet.index') }}" class="btn btn-secondary w-md">Cancel</a>
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
        disableSubmitButton('timesheetForm', 'submitBtn', 'btnText', 'spinner', 'Updating...');
    </script>
@endsection
