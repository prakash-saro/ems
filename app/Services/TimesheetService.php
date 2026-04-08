<?php

namespace App\Services;

use App\Events\TimesheetSaved;
use App\Models\Timesheet;
use Illuminate\Support\Facades\DB;

class TimesheetService
{
    /**
     * Create or update a timesheet record.
     */
    public function saveTimesheet(array $data, int $employeeId, ?Timesheet $timesheet = null): Timesheet
    {
        return DB::transaction(function () use ($data, $employeeId, $timesheet) {
            $data['employee_id'] = $employeeId;
            $user = auth()->user();
            
            // Track if this is a requested update or a creation (including restoration)
            $isExplicitUpdate = ($timesheet !== null);

            // Check for existing record for this date (if not editing an existing instance)
            if (!$isExplicitUpdate) {
                $existing = Timesheet::withTrashed()
                    ->where('employee_id', $employeeId)
                    ->where('work_date', $data['work_date'])
                    ->first();

                if ($existing) {
                    if ($existing->trashed()) {
                        $existing->restore();
                    }
                    $timesheet = $existing;
                }
            }
            
            // Logic for status and approved_by based on role and operation
            if (!$isExplicitUpdate) {
                // New record creation or Restoration
                if ($user && $user->hasRole('admin')) {
                    $data['status'] = 'approved';
                    $data['approved_by'] = $user->id;
                } else {
                    $data['status'] = 'pending';
                    $data['approved_by'] = null;
                }
            } else {
                // Legitimate update of an existing record
                if ($user && $user->hasRole('admin')) {
                    if (isset($data['status']) && $data['status'] !== 'pending') {
                        $data['approved_by'] = $user->id;
                    } elseif (isset($data['status']) && $data['status'] === 'pending') {
                        $data['approved_by'] = null;
                    }
                } else {
                    // Ensure employees cannot manipulate status/approver during update
                    unset($data['status']);
                    // Keep original approved_by
                }
            }

            if ($timesheet) {
                $timesheet->update($data);
                event(new TimesheetSaved($timesheet, 'updated'));
                return $timesheet;
            }

            $newTimesheet = Timesheet::create($data);
            event(new TimesheetSaved($newTimesheet, 'created'));
            
            return $newTimesheet;
        });
    }

    /**
     * Delete a timesheet record.
     */
    public function deleteTimesheet(Timesheet $timesheet): bool
    {
        return DB::transaction(function () use ($timesheet) {
            $deleted = $timesheet->delete();
            if ($deleted) {
                event(new TimesheetSaved($timesheet, 'deleted'));
            }
            return $deleted;
        });
    }
}
