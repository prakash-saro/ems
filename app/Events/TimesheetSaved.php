<?php

namespace App\Events;

use App\Models\Timesheet;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TimesheetSaved
{
    use Dispatchable, SerializesModels;

    public $timesheet;
    public $action;

    public function __construct(Timesheet $timesheet, string $action)
    {
        $this->timesheet = $timesheet;
        $this->action = $action;
    }
}
