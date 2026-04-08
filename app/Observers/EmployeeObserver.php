<?php

namespace App\Observers;

use App\Events\EmployeeSaved;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class EmployeeObserver
{
    /**
     * Handle the Employee "creating" event.
     */
    public function creating(Employee $employee): void
    {
        if (!$employee->employee_code) {

            $lastEmployee = Employee::withTrashed()
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            $lastNumber = $lastEmployee
                ? (int) filter_var($lastEmployee->employee_code, FILTER_SANITIZE_NUMBER_INT)
                : 0;

            $nextNumber = $lastNumber + 1;

            $employee->employee_code = 'EMP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }
    }

    /**
     * Handle the Employee "created" event.
     */
    public function created(Employee $employee): void
    {
        Log::info("Employee OBSERVER Created:", ['id' => $employee->id, 'code' => $employee->employee_code]);
        event(new EmployeeSaved($employee, 'created'));
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        Log::info("Employee OBSERVER Updated:", ['id' => $employee->id, 'code' => $employee->employee_code]);
        event(new EmployeeSaved($employee, 'updated'));
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        Log::info("Employee OBSERVER Deleted:", ['id' => $employee->id, 'code' => $employee->employee_code]);
        event(new EmployeeSaved($employee, 'deleted'));
    }
}
