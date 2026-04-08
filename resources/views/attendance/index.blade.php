@extends('layouts.master')

@section('title')
    Attendance
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
                        <h4 class="font-size-20">Attendance</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('attendance.create') }}" class="btn btn-primary waves-effect waves-light">
                                <i class="fas fa-plus me-1"></i> Create Attendance
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
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $key => $attendance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $attendance->employee->user->name }}
                                        </td>
                                        <td>{{ $attendance->attendance_date->format('d M, Y') }}</td>
                                        <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '--' }}
                                        </td>
                                        <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '--' }}
                                        </td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <form action="{{ route('attendance.destroy', $attendance->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                @can('view', $attendance)
                                                    <a href="{{ route('attendance.show', $attendance->id) }}"
                                                        class="text-warning-emphasis fa fa-eye fs-4"></a>
                                                @endcan

                                                @if (Auth::user()->hasRole('admin'))
                                                    <a href="{{ route('attendance.edit', $attendance->id) }}"
                                                        class="text-primary fa fa-edit fs-4 ms-4"></a>

                                                    <button type="button" class="btn-delete" id="sa-warning"
                                                        style="border:none; background:none;">
                                                        <i class="fas fa-trash fs-4 ms-4 text-danger"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $attendances->links() }}
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
