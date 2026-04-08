@extends('layouts.master')

@section('title')
    Timesheet
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
                        <h4 class="font-size-20">Timesheets</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('timesheet.create') }}" class="btn btn-primary waves-effect waves-light">
                                <i class="fas fa-plus me-1"></i> Add Timesheet
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Work Date</th>
                                    <th>Hours Worked</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timesheets as $key => $timesheet)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $timesheet->employee->user->name ?? 'N/A' }}
                                        </td>
                                        <td>{{ $timesheet->work_date->format('d M, Y') }}</td>
                                        <td>{{ $timesheet->hours_worked }} Hours</td>
                                        <td>
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
                                        </td>
                                        <td>
                                            @can('view', $timesheet)
                                                <a href="{{ route('timesheet.show', $timesheet->id) }}"
                                                    class="text-warning-emphasis fa fa-eye fs-4" title="View Details"></a>
                                            @endcan

                                            @can('update', $timesheet)
                                                <a href="{{ route('timesheet.edit', $timesheet->id) }}"
                                                    class="text-primary fa fa-edit fs-4 ms-4" title="Edit"></a>
                                            @endcan

                                            @can('delete', $timesheet)
                                                <form action="{{ route('timesheet.destroy', $timesheet->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" class="btn-delete" id="sa-warning"
                                                        style="border:none; background:none;" title="Delete">
                                                        <i class="fas fa-trash fs-4 ms-4 text-danger"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $timesheets->links() }}
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
