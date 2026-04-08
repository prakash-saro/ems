@extends('layouts.master')

@section('title')
    Edit Leave
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Leave: {{ $leave->employee->user->name }}</h4>
                    <p class="card-title-desc">Update the details for the leave application.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('leave.update', $leave->id) }}" method="POST" id="leaveForm">
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
                                                {{ old('employee_id', $leave->employee_id) == $emp->id ? 'selected' : '' }}>
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
                                    <option value="" disabled>Select Type</option>
                                    <option value="casual"
                                        {{ old('leave_type', $leave->leave_type) == 'casual' ? 'selected' : '' }}>Casual
                                        Leave</option>
                                    <option value="sick"
                                        {{ old('leave_type', $leave->leave_type) == 'sick' ? 'selected' : '' }}>Sick Leave
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
                                    value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending"
                                        {{ old('status', $leave->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved"
                                        {{ old('status', $leave->status) == 'approved' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="rejected"
                                        {{ old('status', $leave->status) == 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea name="reason" id="reason" rows="3" class="form-control @error('reason') is-invalid @enderror">{{ old('reason', $leave->reason) }}</textarea>
                                @error('reason')
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
        disableSubmitButton('leaveForm', 'submitBtn', 'btnText', 'spinner', 'Updating...');
    </script>
@endsection
