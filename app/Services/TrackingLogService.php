<?php

// app/Services/TrackingLogService.php
namespace App\Services;

use App\Models\TrackingLogs;

class TrackingLogService
{
    public static function log($caseId, $userId, $action, $details = null)
    {
        TrackingLogs::create([
            'case_id' => $caseId,
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
        ]);
    }
}
