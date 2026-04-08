@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <div class="py-2">
                        <i class="fas fa-users fs-1 mb-3"></i>
                        <h4 class="mb-1 text-white"><span data-plugin="counterup">{{ $totalEmployees }}</span></h4>
                        <p class="text-white-50 mb-0">
                            @if (Auth::user()->hasRole('admin'))
                                Total Employees
                            @else
                                My Employee Record
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card bg-warning text-white text-center">
                <div class="card-body">
                    <div class="py-2">
                        <i class="fas fa-calendar-check fs-1 mb-3"></i>
                        <h4 class="mb-1 text-white"><span data-plugin="counterup">{{ $pendingLeaves }}</span></h4>
                        <p class="text-white-50 mb-0">
                            @if (Auth::user()->hasRole('admin'))
                                Total Pending Leaves
                            @else
                                My Pending Leaves
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <!-- end col-->
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <div class="py-2">
                        <i class="fas fa-clock fs-1 mb-3"></i>
                        <h4 class="mb-1 text-white"><span data-plugin="counterup">{{ $pendingTimesheets }}</span></h4>
                        <p class="text-white-50 mb-0">
                            @if (Auth::user()->hasRole('admin'))
                                Total Pending Timesheets
                            @else
                                My Pending Timesheets
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
    @endsection
