<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use App\Models\Saller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function App\Http\Helpers\saller;
use function App\Http\Helpers\store_saller;

class DashbordController extends Controller
{



    public function index()
    {
        // Replace this with your actual data retrieval logic
        $data = [
            'labels' => ['January', 'February', 'March', 'April', 'May'],
            'data' => [65, 59, 80, 81, 56],
        ];

        $unreadNotifications = store_saller()->saller()->with('unreadNotifications')->withCount('unreadNotifications')->first();

        return view('Backend.Saller.index', compact('unreadNotifications', 'data'));
    }
    public function viewall_notification()
    {

        saller()->unreadNotifications->markAsRead();
        flash()->addSuccess('Data Readed  Sucessfully');

        return redirect()->back();
    }
}
