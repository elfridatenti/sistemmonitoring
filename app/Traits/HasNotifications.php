<?php

namespace App\Traits;

use App\Http\Controllers\NotifikasiController;

// app/Traits/HasNotifications.php
trait HasNotifications
{
    public function sendNotification($userId, $title, $message, $redirectUrl = '/')
    {
        $notificationController = new NotifikasiController();
        return $notificationController->triggerNotification($userId, $title, $message, $redirectUrl);
    }
}