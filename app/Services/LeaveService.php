<?php

namespace App\Services;

use App\Events\LeaveSaved;
use App\Models\Leave;
use Illuminate\Support\Facades\DB;

class LeaveService
{
    /**
     * Create or update a leave record.
     */
    public function saveLeave(array $data, int $employeeId, ?Leave $leave = null): Leave
    {
        return DB::transaction(function () use ($data, $employeeId, $leave) {
            $data['employee_id'] = $employeeId;
            
            // Default to pending if not provided
            if (!isset($data['status'])) {
                $data['status'] = 'pending';
            }

            if ($leave) {
                // If updating and status changed to approved/rejected, set approved_by
                if (isset($data['status']) && $data['status'] !== 'pending') {
                    // Only update approved_by if we don't already have one, or if admin is specifically providing it
                    // In a more robust system, we would always log the current auth user id if status changes
                    if (auth()->check() && auth()->user()->hasRole('admin')) {
                        $data['approved_by'] = auth()->id();
                    }
                } elseif (isset($data['status']) && $data['status'] === 'pending') {
                    $data['approved_by'] = null;
                }

                $leave->update($data);
                event(new LeaveSaved($leave, 'updated'));
                return $leave;
            }

            $newLeave = Leave::create($data);
            event(new LeaveSaved($newLeave, 'created'));
            
            return $newLeave;
        });
    }

    /**
     * Delete a leave record.
     */
    public function deleteLeave(Leave $leave): bool
    {
        return DB::transaction(function () use ($leave) {
            $deleted = $leave->delete();
            if ($deleted) {
                event(new LeaveSaved($leave, 'deleted'));
            }
            return $deleted;
        });
    }
}
