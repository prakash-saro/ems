<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeService
{
    /**
     * Create a new employee and their associated user.
     */
    public function createEmployee(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            $user = User::withTrashed()->where('email', $data['email'])->first();

            if ($user) {
                if ($user->trashed()) {
                    $user->restore();
                }

                $user->update([
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            } else {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]);
            }

            $employee = Employee::withTrashed()->where('user_id', $user->id)->first();

            if ($employee) {
                if ($employee->trashed()) {
                    $employee->restore();
                }

                $employee->update([
                    'designation' => $data['designation'] ?? null,
                    'mobile_number' => $data['mobile_number'] ?? null,
                    'joining_date' => $data['joining_date'],
                    'salary' => $data['salary'] ?? 0.0,
                    'status' => 'active',
                ]);
            } else {
                $employee = new Employee([
                    'designation' => $data['designation'] ?? null,
                    'mobile_number' => $data['mobile_number'] ?? null,
                    'joining_date' => $data['joining_date'],
                    'salary' => $data['salary'] ?? 0.0,
                    'status' => 'active',
                ]);
                $user->employee()->save($employee);
            }

            $user->assignRole('employee');

            return $employee;
        });
    }

    /**
     * Update an existing employee and their associated user.
     */
    public function updateEmployee(Employee $employee, array $data): bool
    {
        return DB::transaction(function () use ($employee, $data) {
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : false,
            ];

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            $employee->user->update($userData);

            $employee->update([
                'designation' => $data['designation'] ?? null,
                'mobile_number' => $data['mobile_number'] ?? null,
                'joining_date' => $data['joining_date'],
                'salary' => $data['salary'] ?? 0.0,
                'status' => (isset($data['is_active']) && $data['is_active']) ? 'active' : 'inactive',
            ]);

            return true;
        });
    }

    /**
     * Delete an employee.
     */
    public function deleteEmployee(Employee $employee): bool
    {
        return DB::transaction(function () use ($employee) {
            $employee->user->delete();
            return $employee->delete();
        });
    }
}
