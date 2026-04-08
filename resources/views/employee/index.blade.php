@extends('layouts.master')

@section('title')
    Employees
@endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="font-size-20">Employees</h4>
                        <a href="{{ route('employee.create') }}">
                            <button class="btn btn-primary waves-effect waves-light">Add Employee</button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Designation</th>
                                    <th>Phone</th>
                                    <th>Joining Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($employees as $key => $employee)
                                    <tr>
                                        <td>{{ ++$key }}.</td>
                                        <td>{{ $employee->employee_code }}</td>
                                        <td>{{ $employee->user->name ?? 'N/A' }}</td>
                                        <td>{{ $employee->user->email ?? 'N/A' }}</td>
                                        <td>{{ $employee->designation }}</td>
                                        <td>{{ $employee->mobile_number }}</td>
                                        <td>{{ $employee->joining_date->format('d M, Y') }}</td>
                                        <td>
                                            @if ($employee->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can('view', $employee)
                                                <a href="{{ route('employee.show', $employee->id) }}"
                                                    class="fa fa-eye fs-4 text-warning-emphasis" title="View Details"></a>
                                            @endcan

                                            @if (Auth::user()->hasRole('admin'))
                                                <form action="{{ route('employee.destroy', $employee->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('employee.edit', $employee->id) }}"
                                                        class="fa fa-edit fs-4 ms-4 text-primary" title="Edit"></a>

                                                    <button type="button" title="Delete" id="sa-warning"
                                                        style="border: none; background-color:transparent;">
                                                        <i class="fas fa-trash fs-4 ms-4" style="color: red;"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/ecommerce-datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/sweet-alerts.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/custom/delete-sweet-alert.js') }}"></script>
@endsection
