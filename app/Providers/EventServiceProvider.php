<?php

namespace App\Providers;

use App\Events\AttendanceSaved;
use App\Events\EmployeeSaved;
use App\Events\LeaveSaved;
use App\Events\TimesheetSaved;
use App\Listeners\LogAttendanceAnalytics;
use App\Listeners\LogEmployeeAnalytics;
use App\Listeners\LogLeaveAnalytics;
use App\Listeners\LogTimesheetAnalytics;
use App\Models\Employee;
use App\Observers\EmployeeObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EmployeeSaved::class => [
            LogEmployeeAnalytics::class,
        ],
        AttendanceSaved::class => [
            LogAttendanceAnalytics::class,
        ],
        LeaveSaved::class => [
            LogLeaveAnalytics::class,
        ],
        TimesheetSaved::class => [
            LogTimesheetAnalytics::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Employee::observe(EmployeeObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
