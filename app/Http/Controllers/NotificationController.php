<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;

class NotificationController extends Controller
{
    public function showForUpdating($id, $notification_id)

    {
        $notifications = Notification::find($notification_id)->latest();
        $notifications->status = 'read';
        $notifications->color = 'green';
        $notifications->update();
        return view('home', [
            'notifications' => $notifications
        ]);
    }

    public function read($id)
    {
        $notifications = Notification::find($id);
        $notifications->status = 'read';
        $notifications->color = 'gray';
        $notifications->reciver_id = auth()->user()->id;
        $notifications->update();
        if ($notifications->link == null) {

            return Redirect::to('/home');
        } else {
            return Redirect::to($notifications->link);
        }
    }

    // Show notifications index for authenticated user
    public function index()
    {
        $userId = auth()->id();
        $notifications = Notification::where(function ($q) use ($userId) {
            $q->where('user_id', $userId)->orWhere('reciver_id', $userId);
        })->orderBy('id', 'desc')->paginate(30);

        return view('backend.notifications.index', compact('notifications'));
    }

    // Mark a notification read (AJAX or form)
    public function markRead(Request $request, $id)
    {
        $notification = Notification::find($id);
        if (! $notification) {
            return response()->json(['ok' => false], 404);
        }
        // support both `status` and `read_at` patterns
        if (Schema::hasColumn('notifications', 'status')) {
            $notification->status = 'read';
            $notification->color = 'gray';
        } else {
            $notification->read_at = now();
        }
        $notification->reciver_id = auth()->id();
        $notification->save();

        return response()->json(['ok' => true]);
    }

    // Mark a notification unread
    public function markUnread(Request $request, $id)
    {
        $notification = Notification::find($id);
        if (! $notification) {
            return response()->json(['ok' => false], 404);
        }
        if (Schema::hasColumn('notifications', 'status')) {
            $notification->status = 'unread';
            $notification->color = 'green';
        } else {
            $notification->read_at = null;
        }
        $notification->save();

        return response()->json(['ok' => true]);
    }

    // Mark all notifications for current user as read
    public function markAllRead(Request $request)
    {
        $userId = auth()->id();
        $query = Notification::where(function ($q) use ($userId) {
            $q->where('user_id', $userId)->orWhere('reciver_id', $userId);
        })->where(function ($q) {
            $q->whereNull('status')->orWhere('status', 'unread')->orWhereNull('read_at');
        });

        if (Schema::hasColumn('notifications', 'status')) {
            $query->update(['status' => 'read', 'color' => 'gray']);
        } else {
            foreach ($query->get() as $n) {
                $n->read_at = now();
                $n->save();
            }
        }

        return response()->json(['ok' => true]);
    }

    // Delete a notification
    public function destroy(Request $request, $id)
    {
        $notification = Notification::find($id);
        if (! $notification) {
            return response()->json(['ok' => false], 404);
        }
        $notification->delete();
        return response()->json(['ok' => true]);
    }
}
