<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    function showAnnouncement()
    {
        $announcements = Announcement::all();
        return inertia('Dashboard/Announcement/AnnouncementShow',[
            'announcements' => $announcements,
        ]);
    }

    public function createAnnouncement()
    {
        return inertia('Dashboard/Announcement/AnnouncementAdd');
    }
}
