<?php

namespace App\Http\Controllers;

use App\Http\Requests\Leave\StoreLeaveRequest;
use App\Http\Requests\Leave\UpdateLeaveRequest;
use App\Models\Employee;
use App\Models\Leave;
use App\Services\LeaveService;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    protected $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }

    public function index()
    {
        $this->authorize('viewAny', Leave::class);

        $query = Leave::with('employee.user', 'approvedBy')->latest();

        if (Auth::user()->hasRole('employee')) {
            $query->where('employee_id', Auth::user()->employee->id);
        }

        $leaves = $query->paginate(10);

        return view('leave.index', compact('leaves'));
    }

    public function create()
    {
        $this->authorize('create', Leave::class);
        $employees = Employee::with('user')->get();
        return view('leave.create', compact('employees'));
    }

    public function store(StoreLeaveRequest $request)
    {
        $this->authorize('create', Leave::class);

        $data = $request->validated();
        $employeeId = Auth::user()->hasRole('admin') ? $data['employee_id'] : Auth::user()->employee->id;

        $this->leaveService->saveLeave($data, $employeeId);

        return redirect()->route('leave.index')->with('success', 'Leave applied successfully.');
    }

    public function show(Leave $leave)
    {
        $this->authorize('view', $leave);
        $leave->load('employee.user', 'approvedBy');
        return view('leave.show', compact('leave'));
    }

    public function edit(Leave $leave)
    {
        $this->authorize('update', $leave);
        $employees = Employee::with('user')->get();
        return view('leave.edit', compact('leave', 'employees'));
    }

    public function update(UpdateLeaveRequest $request, Leave $leave)
    {
        $this->authorize('update', $leave);

        $data = $request->validated();
        $employeeId = Auth::user()->hasRole('admin') ? $data['employee_id'] : $leave->employee_id;

        $this->leaveService->saveLeave($data, $employeeId, $leave);

        return redirect()->route('leave.index')->with('success', 'Leave updated successfully.');
    }

    public function destroy(Leave $leave)
    {
        $this->authorize('delete', $leave);
        
        $this->leaveService->deleteLeave($leave);

        return redirect()->route('leave.index')->with('success', 'Leave deleted successfully.');
    }
}
