<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Services\AttendanceService;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Attendance::class);

        $query = Attendance::with('employee.user')->latest();

        if (Auth::user()->hasRole('employee')) {
            $query->where('employee_id', Auth::user()->employee->id);
        }

        $attendances = $query->paginate(10);

        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource (Admin Only).
     */
    public function create()
    {
        $this->authorize('create', Attendance::class);
        $employees = Employee::with('user')->get();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage (Mark Attendance via Form).
     */
    public function store(StoreAttendanceRequest $request)
    {
        $this->authorize('create', Attendance::class);

        $data = $request->validated();
        $employeeId = Auth::user()->hasRole('admin') ? $data['employee_id'] : Auth::user()->employee->id;

        // Default status to present if not provided (now that it's removed from create form)
        if (!isset($data['status'])) {
            $data['status'] = 'present';
        }

        $this->attendanceService->saveAttendance($data, $employeeId);

        return redirect()->route('attendance.index')->with('success', 'Attendance record saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        $this->authorize('view', $attendance);
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource (Admin Only).
     */
    public function edit(Attendance $attendance)
    {
        $this->authorize('update', $attendance);
        $employees = Employee::with('user')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage (Admin Only).
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $this->authorize('update', $attendance);

        $data = $request->validated();
        $employeeId = Auth::user()->hasRole('admin') ? $data['employee_id'] : $attendance->employee_id;

        $this->attendanceService->saveAttendance($data, $employeeId);

        return redirect()->route('attendance.index')->with('success', 'Attendance record updated.');
    }

    /**
     * Remove the specified resource from storage (Admin Only).
     */
    public function destroy(Attendance $attendance)
    {
        $this->authorize('delete', $attendance);
        $this->attendanceService->deleteAttendance($attendance);

        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted.');
    }
}
