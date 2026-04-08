@extends('layouts.master')

@section('title')
    Add Timesheet
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New Timesheet Entry</h4>
                    <p class="card-title-desc">Fill in the details below to log your work hours.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('timesheet.store') }}" method="POST" id="timesheetForm">
                        @csrf

                        <div class="row">
                            @if (Auth::user()->hasRole('admin'))
                                <div class="col-md-6 mb-3">
                                    <label for="employee_id" class="form-label">Employee <span
                                            class="text-danger">*</span></label>
                                    <select name="employee_id" id="employee_id"
                                        class="form-select @error('employee_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Select Employee</option>
                                        @foreach ($employees as $emp)
                                            <option value="{{ $emp->id }}"
                                                {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
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
                                    value="{{ old('work_date', date('Y-m-d')) }}" required>
                                @error('work_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="hours_worked" class="form-label">Hours Worked <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.5" min="0.5" max="24" name="hours_worked"
                                    id="hours_worked" class="form-control @error('hours_worked') is-invalid @enderror"
                                    value="{{ old('hours_worked') }}" placeholder="e.g. 8.5" required>
                                @error('hours_worked')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="task_description" class="form-label">Task Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="task_description" id="task_description" rows="4"
                                    class="form-control @error('task_description') is-invalid @enderror"
                                    placeholder="Describe the tasks you worked on..." required>{{ old('task_description') }}</textarea>
                                @error('task_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary w-md" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none me-1" id="spinner" role="status"
                                    aria-hidden="true"></span>
                                <span id="btnText">Submit</span>
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
        disableSubmitButton('timesheetForm', 'submitBtn', 'btnText', 'spinner', 'Submitting...');
    </script>
@endsection
