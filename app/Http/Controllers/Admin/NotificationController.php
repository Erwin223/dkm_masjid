<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Redirect based on type
        if ($notification->data['type'] === 'deletion_request') {
            return redirect()->route('admin.deletion_approvals.index');
        }

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
