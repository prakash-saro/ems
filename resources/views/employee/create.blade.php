@extends('layouts.master')

@section('title')
    Create Employee
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New</h4>
                    <p class="card-title-desc">Fill in the details below to create a new profile.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('employee.store') }}" method="POST" id="employeeForm">
                        @csrf
                        @include('employee.form')

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-md" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none me-1" id="spinner" role="status"
                                    aria-hidden="true"></span>
                                <span id="btnText">Submit</span>
                            </button>
                            <a href="{{ route('employee.index') }}" class="btn btn-outline-secondary w-md ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/js/custom/password-toggle.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/custom/form-submit.js') }}"></script>
    <script>
        disableSubmitButton('employeeForm', 'submitBtn', 'btnText', 'spinner', 'Submitting...');
    </script>
@endsection
