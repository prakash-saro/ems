@extends('layouts.master')

@section('title')
    Attendance Details
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Attendance Details</h4>
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Log
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Employee Name:</div>
                        <div class="col-sm-8 fw-bold">{{ $attendance->employee->user->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Employee Code:</div>
                        <div class="col-sm-8">{{ $attendance->employee->employee_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Designation:</div>
                        <div class="col-sm-8">{{ $attendance->employee->designation }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Attendance Date:</div>
                        <div class="col-sm-8 fw-bold text-primary">{{ $attendance->attendance_date->format('d M, Y') }}
                            ({{ $attendance->attendance_date->format('l') }})</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Check In Time:</div>
                        <div class="col-sm-8">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'Not Recorded' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Check Out Time:</div>
                        <div class="col-sm-8">
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'Not Recorded' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Status:</div>
                        <div class="col-sm-8">
                            @php
                                $statusBadge = [
                                    'present' => 'bg-success',
                                    'absent' => 'bg-danger',
                                    'half_day' => 'bg-warning',
                                ];
                            @endphp
                            <span class="badge {{ $statusBadge[$attendance->status] ?? 'bg-secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                            </span>
                        </div>
                    </div>

                    @if (Auth::user()->hasRole('admin'))
                        <div class="mt-4 pt-2 border-top">
                            <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit Record
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
