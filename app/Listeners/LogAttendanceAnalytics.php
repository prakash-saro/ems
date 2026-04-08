<?php

namespace App\Listeners;

use App\Events\AttendanceSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogAttendanceAnalytics implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AttendanceSaved $event): void
    {
        // Basic analytics logic
        Log::info("Attendance Activity Logged for Analytics:", [
            'action' => $event->action,
            'attendance_id' => $event->attendance->id,
            'employee_id' => $event->attendance->employee_id,
            'attendance_date' => $event->attendance->attendance_date->toDateString(),
            'status' => $event->attendance->status,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
