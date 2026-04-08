<?php

namespace App\Listeners;

use App\Events\TimesheetSaved;
use Illuminate\Support\Facades\Log;

class LogTimesheetAnalytics
{
    /**
     * Handle the event.
     */
    public function handle(TimesheetSaved $event): void
    {
        $timesheet = $event->timesheet;
        $action = $event->action;

        Log::info("Timesheet Analytics: Action [{$action}] on Timesheet ID [{$timesheet->id}] by User [" . (auth()->user()->name ?? 'System') . "].");
        
        // Additional analytics logic would go here (e.g. inserting into an analytics table)
    }
}
