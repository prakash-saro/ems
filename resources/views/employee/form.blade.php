<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $employee->user->name ?? '') }}" placeholder="Enter full name" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email', $employee->user->email ?? '') }}" placeholder="Enter email address" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="designation" class="form-label">Designation</label>
            <input type="text" class="form-control @error('designation') is-invalid @enderror" id="designation"
                name="designation" value="{{ old('designation', $employee->designation ?? '') }}" placeholder="Job Title">
            @error('designation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number"
                name="mobile_number" value="{{ old('mobile_number', $employee->mobile_number ?? '') }}"
                placeholder="Enter mobile number">
            @error('mobile_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date</label>
            <input type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date"
                name="joining_date"
                value="{{ old('joining_date', isset($employee) ? $employee->joining_date->format('Y-m-d') : date('Y-m-d')) }}"
                required>
            @error('joining_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="number" step="0.01" min="0" class="form-control @error('salary') is-invalid @enderror" id="salary"
                name="salary" value="{{ old('salary', $employee->salary ?? '') }}" placeholder="Enter salary amount" required>
            @error('salary')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@if (isset($employee))
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" 
                        id="is_active" name="is_active" value="1" 
                        {{ old('is_active', $employee->user->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">User Account Active</label>
                </div>
                @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password" class="form-label">{{ isset($employee) ? 'New Password (leave blank to keep current)' : 'Password' }}</label>
            <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Enter password" {{ isset($employee) ? '' : 'required' }}>
                <div class="input-group-text">
                    <input type="checkbox" class="d-none" id="togglePasswordCheck" onchange="togglePassword(this, 'password'); document.getElementById('eyeIcon').classList.toggle('fa-eye'); document.getElementById('eyeIcon').classList.toggle('fa-eye-slash');">
                    <label for="togglePasswordCheck" class="mb-0" style="cursor: pointer;">
                        <i class="fa fa-eye-slash" id="eyeIcon"></i>
                    </label>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Confirm password" {{ isset($employee) ? '' : 'required' }}>
                <div class="input-group-text">
                    <input type="checkbox" class="d-none" id="toggleConfirmPasswordCheck" onchange="togglePassword(this, 'password_confirmation'); document.getElementById('eyeIconConfirm').classList.toggle('fa-eye'); document.getElementById('eyeIconConfirm').classList.toggle('fa-eye-slash');">
                    <label for="toggleConfirmPasswordCheck" class="mb-0" style="cursor: pointer;">
                        <i class="fa fa-eye-slash" id="eyeIconConfirm"></i>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
