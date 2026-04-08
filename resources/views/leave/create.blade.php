@extends('layouts.master')

@section('title')
    Apply Leave
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Apply for Leave</h4>
                    <p class="card-title-desc">Fill in the details below to submit a new leave request.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('leave.store') }}" method="POST" id="leaveForm">
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
                                <label for="leave_type" class="form-label">Leave Type <span
                                        class="text-danger">*</span></label>
                                <select name="leave_type" id="leave_type"
                                    class="form-select @error('leave_type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="casual" {{ old('leave_type') == 'casual' ? 'selected' : '' }}>Casual
                                        Leave</option>
                                    <option value="sick" {{ old('leave_type') == 'sick' ? 'selected' : '' }}>Sick Leave
                                    </option>
                                </select>
                                @error('leave_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea name="reason" id="reason" rows="3" class="form-control @error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
                                @error('reason')
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
                            <a href="{{ route('leave.index') }}" class="btn btn-secondary w-md">Cancel</a>
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
        disableSubmitButton('leaveForm', 'submitBtn', 'btnText', 'spinner', 'Submitting...');
    </script>
@endsection
