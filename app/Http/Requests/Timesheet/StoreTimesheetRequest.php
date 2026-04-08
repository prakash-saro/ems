<?php

namespace App\Http\Requests\Timesheet;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimesheetRequest extends FormRequest
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
        ];

        if ($this->user()->hasRole('admin')) {
            $rules['employee_id'] = 'required|exists:employees,id';
        }

        return $rules;
    }
}
