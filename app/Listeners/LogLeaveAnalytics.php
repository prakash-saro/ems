<?php

namespace App\Listeners;

use App\Events\LeaveSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogLeaveAnalytics implements ShouldQueue
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
    public function handle(LeaveSaved $event): void
    {
        Log::info("Leave Activity Logged for Analytics:", [
            'action' => $event->action,
            'leave_id' => $event->leave->id,
            'employee_id' => $event->leave->employee_id,
            'leave_type' => $event->leave->leave_type,
            'status' => $event->leave->status,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
