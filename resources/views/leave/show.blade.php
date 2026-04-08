@extends('layouts.master')

@section('title')
    Leave Details
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Leave Details</h4>
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to History
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Employee Name:</div>
                        <div class="col-sm-8 fw-bold">{{ $leave->employee->user->name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Employee Code:</div>
                        <div class="col-sm-8">{{ $leave->employee->employee_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Designation:</div>
                        <div class="col-sm-8">{{ $leave->employee->designation }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Leave Type:</div>
                        <div class="col-sm-8 fw-bold text-primary">{{ ucfirst($leave->leave_type) }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Start Date:</div>
                        <div class="col-sm-8">{{ $leave->start_date->format('d M, Y') }} ({{ $leave->start_date->format('l') }})</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">End Date:</div>
                        <div class="col-sm-8">{{ $leave->end_date->format('d M, Y') }} ({{ $leave->end_date->format('l') }})</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Status:</div>
                        <div class="col-sm-8">
                            @php
                                $statusBadge = [
                                    'pending' => 'bg-warning',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                ];
                            @endphp
                            <span class="badge {{ $statusBadge[$leave->status] ?? 'bg-secondary' }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </div>
                    </div>

                    @if ($leave->approvedBy)
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Approved By:</div>
                            <div class="col-sm-8">{{ $leave->approvedBy->name }}</div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Reason:</div>
                        <div class="col-sm-8">{{ $leave->reason ?: 'No reason provided.' }}</div>
                    </div>

                    @if (Auth::user()->hasRole('admin'))
                        <div class="mt-4 pt-2 border-top">
                            <a href="{{ route('leave.edit', $leave->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit Leave
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
