<?php

namespace App\Http\Controllers;

use App\Http\Requests\Timesheet\StoreTimesheetRequest;
use App\Http\Requests\Timesheet\UpdateTimesheetRequest;
use App\Models\Employee;
use App\Models\Timesheet;
use App\Services\TimesheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    protected $timesheetService;

    public function __construct(TimesheetService $timesheetService)
    {
        $this->timesheetService = $timesheetService;
    }

    public function index()
    {
        $this->authorize('viewAny', Timesheet::class);

        $query = Timesheet::with('employee.user', 'approvedBy')->latest();

        if (Auth::user()->hasRole('employee')) {
            $query->where('employee_id', Auth::user()->employee->id);
        }

        $timesheets = $query->paginate(10);

        return view('timesheet.index', compact('timesheets'));
    }

    public function create()
    {
        $this->authorize('create', Timesheet::class);

        $employees = [];
        if (Auth::user()->hasRole('admin')) {
            $employees = Employee::with('user')->get();
        }

        return view('timesheet.create', compact('employees'));
    }

    public function store(StoreTimesheetRequest $request)
    {
        $this->authorize('create', Timesheet::class);

        $data = $request->validated();
        $employeeId = Auth::user()->hasRole('admin') ? $data['employee_id'] : Auth::user()->employee->id;

        $this->timesheetService->saveTimesheet($data, $employeeId);

        return redirect()->route('timesheet.index')->with('success', 'Timesheet submitted successfully.');
    }

    public function show(Timesheet $timesheet)
    {
        $this->authorize('view', $timesheet);

        return view('timesheet.show', compact('timesheet'));
    }

    public function edit(Timesheet $timesheet)
    {
        $this->authorize('update', $timesheet);

        $employees = [];
        if (Auth::user()->hasRole('admin')) {
            $employees = Employee::with('user')->get();
        }

        return view('timesheet.edit', compact('timesheet', 'employees'));
    }

    public function update(UpdateTimesheetRequest $request, Timesheet $timesheet)
    {
        $this->authorize('update', $timesheet);

        $data = $request->validated();
        $employeeId = Auth::user()->hasRole('admin') ? $data['employee_id'] : $timesheet->employee_id;

        $this->timesheetService->saveTimesheet($data, $employeeId, $timesheet);

        return redirect()->route('timesheet.index')->with('success', 'Timesheet updated successfully.');
    }

    public function destroy(Timesheet $timesheet)
    {
        $this->authorize('delete', $timesheet);

        $this->timesheetService->deleteTimesheet($timesheet);

        return redirect()->route('timesheet.index')->with('success', 'Timesheet deleted successfully.');
    }
}
