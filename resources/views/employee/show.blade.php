@extends('layouts.master')

@section('title')
    Employee Details
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Employee Details: {{ $employee->user->name }}</h4>
                        <a href="{{ route('employee.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 200px;">Full Name</th>
                                        <td>{{ $employee->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email Address</th>
                                        <td>{{ $employee->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Employee Code</th>
                                        <td>{{ $employee->employee_code }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Designation</th>
                                        <td>{{ $employee->designation }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 200px;">Mobile Number</th>
                                        <td>{{ $employee->mobile_number }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Joining Date</th>
                                        <td>{{ $employee->joining_date->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Salary</th>
                                        <td>{{ number_format($employee->salary, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td>
                                            @if ($employee->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit Employee
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
