<?php

namespace App\Listeners;

use App\Events\EmployeeSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogEmployeeAnalytics implements ShouldQueue
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
    public function handle(EmployeeSaved $event): void
    {
        // Basic analytics logic - logic can be extended here
        // to save to a database table or send to a service.
        Log::info("Employee Activity Logged for Analytics:", [
            'action' => $event->action,
            'employee_id' => $event->employee->id,
            'name' => $event->employee->user->name ?? 'Unknown',
            'email' => $event->employee->user->email ?? 'N/A',
            'employee_code' => $event->employee->employee_code,
            'timestamp' => now()->toDateTimeString(),
        ]);

        // If you had a dedicated analytics table, you'd insert here.
    }
}
