@extends('layouts.master')

@section('title')
    Edit Employee
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit: {{ $employee->user->name }}</h4>
                    <p class="card-title-desc">Modify the details below to update the profile.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('employee.update', $employee->id) }}" method="POST" id="employeeEditForm">
                        @csrf
                        @method('PUT')
                        @include('employee.form')

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-md" id="updateBtn">
                                <span class="spinner-border spinner-border-sm d-none me-1" id="editSpinner" role="status"
                                    aria-hidden="true"></span>
                                <span id="editText">Update</span>
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
        disableSubmitButton('employeeEditForm', 'updateBtn', 'editText', 'editSpinner', 'Updating...');
    </script>
@endsection
