<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('notification.index')->with('notificatio',totalNotificaiton(auth()->user()->id));
    }
    public function store($data) {
        $notification = new Notification();
        $notification->user_id = $data['user_id'];
        $notification->title = $data['title'];
        $notification->body = $data['body'];
        $notification->url = $data['url'];
        $notification->save();

        $this->senditToMobileApplication($data);
    }

    public function senditToMobileApplication($data) {
        //FCM Send
    }


}
