<?php

namespace Inspirium\UserManagement\Controllers\Api;

use App\Http\Controllers\Controller;

class NotificationController extends Controller {

    public function getNotifications() {
        $user = \Auth::user();
        $notifications = $user->notifications;
        return response()->json($notifications);
    }
}
