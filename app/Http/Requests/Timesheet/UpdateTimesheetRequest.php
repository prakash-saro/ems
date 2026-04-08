<?php

namespace App\Http\Requests\Timesheet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimesheetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'work_date' => 'required|date',
            'hours_worked' => 'required|numeric|min:0.5|max:24',
            'task_description' => 'required|string|max:2000',
            'status' => 'required|in:pending,approved,rejected',
        ];

        if ($this->user()->hasRole('admin')) {
            $rules['employee_id'] = 'required|exists:employees,id';
        }

        return $rules;
    }
}
