<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $complaints = Complaint::where('user_id', $user->id)->latest()->take(5)->get();
        $memberships = Member::where('user_id', $user->id)->latest()->get();

        $stats = [
            'total_complaints' => Complaint::where('user_id', $user->id)->count(),
            'pending_complaints' => Complaint::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved_complaints' => Complaint::where('user_id', $user->id)->where('status', 'approved')->count(),
            'investigated_complaints' => Complaint::where('user_id', $user->id)->where('status', 'investigated')->count(),
        ];

        return view('dashboard', compact('user', 'complaints', 'memberships', 'stats'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
}
