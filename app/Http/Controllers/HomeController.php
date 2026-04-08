<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    public function root()
    {
        $user = auth()->user();
        
        $totalEmployees = 0;
        $pendingLeaves = 0;
        $pendingTimesheets = 0;

        if ($user->hasRole('admin')) {
            $totalEmployees = \App\Models\Employee::count();
            $pendingLeaves = \App\Models\Leave::where('status', 'pending')->count();
            $pendingTimesheets = \App\Models\Timesheet::where('status', 'pending')->count();
        } else {
            // Employee role
            $employee = $user->employee;
            if ($employee) {
                // For an employee, "Total Employees" doesn't strictly make sense 
                // but we fetch their own record count as requested "show own"
                $totalEmployees = 1; 
                $pendingLeaves = \App\Models\Leave::where('employee_id', $employee->id)
                    ->where('status', 'pending')
                    ->count();
                $pendingTimesheets = \App\Models\Timesheet::where('employee_id', $employee->id)
                    ->where('status', 'pending')
                    ->count();
            }
        }

        return view('index', compact('totalEmployees', 'pendingLeaves', 'pendingTimesheets'));
    }

    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }
}
