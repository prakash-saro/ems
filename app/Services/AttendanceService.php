<?php

namespace App\Services;

use App\Events\AttendanceSaved;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceService
{
    /**
     * Create or restore and update an attendance record.
     */
    public function saveAttendance(array $data, int $employeeId): Attendance
    {
        return DB::transaction(function () use ($data, $employeeId) {
            $attendance = Attendance::withTrashed()
                ->where('employee_id', $employeeId)
                ->where('attendance_date', $data['attendance_date'])
                ->first();

            if ($attendance) {
                if ($attendance->trashed()) {
                    $attendance->restore();
                }
                
                $attendance->update($data);
                event(new AttendanceSaved($attendance, 'updated'));
                return $attendance;
            }

            $data['employee_id'] = $employeeId;
            $newAttendance = Attendance::create($data);
            event(new AttendanceSaved($newAttendance, 'created'));
            
            return $newAttendance;
        });
    }

    /**
     * Delete an attendance record.
     */
    public function deleteAttendance(Attendance $attendance): bool
    {
        return DB::transaction(function () use ($attendance) {
            $deleted = $attendance->delete();
            if ($deleted) {
                event(new AttendanceSaved($attendance, 'deleted'));
            }
            return $deleted;
        });
    }
}
