@extends('layouts.master')

@section('title')
    Leave
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
                        <h4 class="font-size-20">Leaves</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('leave.create') }}" class="btn btn-primary waves-effect waves-light">
                                <i class="fas fa-plus me-1"></i> Apply Leave
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
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaves as $key => $leave)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $leave->employee->user->name ?? 'N/A' }}
                                        </td>
                                        <td>{{ ucfirst($leave->leave_type) }}</td>
                                        <td>{{ $leave->start_date->format('d M, Y') }}</td>
                                        <td>{{ $leave->end_date->format('d M, Y') }}</td>
                                        <td>
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
                                        </td>
                                        <td>
                                            @can('view', $leave)
                                                <a href="{{ route('leave.show', $leave->id) }}"
                                                    class="text-warning-emphasis fa fa-eye fs-4" title="View Details"></a>
                                            @endcan

                                            @if (Auth::user()->hasRole('admin'))
                                                <form action="{{ route('leave.destroy', $leave->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a href="{{ route('leave.edit', $leave->id) }}"
                                                        class="text-primary fa fa-edit fs-4 ms-4" title="Edit"></a>

                                                    <button type="button" class="btn-delete" id="sa-warning"
                                                        style="border:none; background:none;" title="Delete">
                                                        <i class="fas fa-trash fs-4 ms-4 text-danger"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $leaves->links() }}
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
