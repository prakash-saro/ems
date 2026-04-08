@extends('layouts.master')

@section('title')
    Timesheet Details
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Timesheet Entry Details</h4>
                    <a href="{{ route('timesheet.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to History
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Employee Name:</div>
                        <div class="col-sm-8 fw-bold">{{ $timesheet->employee->user->name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Employee Code:</div>
                        <div class="col-sm-8">{{ $timesheet->employee->employee_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Designation:</div>
                        <div class="col-sm-8">{{ $timesheet->employee->designation }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Work Date:</div>
                        <div class="col-sm-8 fw-bold">{{ $timesheet->work_date->format('d M, Y') }} ({{ $timesheet->work_date->format('l') }})</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Hours Worked:</div>
                        <div class="col-sm-8 text-primary fw-bold">{{ $timesheet->hours_worked }} Hours</div>
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
                            <span class="badge {{ $statusBadge[$timesheet->status] ?? 'bg-secondary' }}">
                                {{ ucfirst($timesheet->status) }}
                            </span>
                        </div>
                    </div>

                    @if ($timesheet->approvedBy)
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Action Taken By:</div>
                            <div class="col-sm-8 text-success">{{ $timesheet->approvedBy->name }}</div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Task Description:</div>
                        <div class="col-sm-8" style="white-space: pre-line;">{{ $timesheet->task_description }}</div>
                    </div>

                    @can('update', $timesheet)
                        <div class="mt-4 pt-2 border-top">
                            <a href="{{ route('timesheet.edit', $timesheet->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit Entry
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
