<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_complaints' => Complaint::count(),
            'approved' => Complaint::where('status', 'approved')->count(),
            'investigated' => Complaint::where('status', 'investigated')->count(),
            'completed' => Complaint::where('status', 'complete')->count(),
            'total_members' => Member::where('status', 'approved')->count(),
        ];

        // Recent public complaints (anonymized preview)
        $recentComplaints = Complaint::latest()->take(6)->get();

        // Recent public notices for homepage
        $recentNotices = Notice::active()->orderBy('published_date', 'desc')->take(4)->get();

        // Recent gallery photos for homepage preview
        $recentPhotos = Gallery::active()->orderBy('sort_order', 'asc')->orderBy('event_date', 'desc')->orderBy('id', 'desc')->take(6)->get();

        return view('home', compact('stats', 'recentComplaints', 'recentNotices', 'recentPhotos'));
    }

    public function track(Request $request)
    {
        $query = $request->input('search');
        $complaint = null;

        if ($query) {
            $complaint = Complaint::with(['accuseds', 'witnesses'])
                ->where('id', $query)
                ->orWhere('phone_number', $query)
                ->orWhere('transaction_id', $query)
                ->latest()
                ->first();
        }

        return view('track', compact('complaint', 'query'));
    }

    public function membersDirectory(Request $request)
    {
        $query = Member::where('status', 'approved');

        if ($request->has('district') && $request->district) {
            $query->where('district', 'like', '%' . $request->district . '%');
        }

        if ($request->has('search') && $request->search) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('bangla_name', 'like', "%$s%")
                  ->orWhere('english_name', 'like', "%$s%")
                  ->orWhere('post_name', 'like', "%$s%");
            });
        }

        $members = $query->latest()->paginate(12);

        return view('members_directory', compact('members'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function notices(Request $request)
    {
        $query = Notice::active()->orderBy('published_date', 'desc')->orderBy('id', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        $notices = $query->paginate(9)->withQueryString();
        $categories = ['জরুরি বিজ্ঞপ্তি', 'সাধারণ নোটিশ', 'প্রেস বিজ্ঞপ্তি', 'আইনি নির্দেশনা'];

        return view('notices', compact('notices', 'categories'));
    }

    public function noticeDetail($id)
    {
        $notice = Notice::active()->findOrFail($id);
        $notice->increment('views_count');

        $recentNotices = Notice::active()
            ->where('id', '!=', $id)
            ->orderBy('published_date', 'desc')
            ->take(5)
            ->get();

        return view('notice_detail', compact('notice', 'recentNotices'));
    }

    public function gallery(Request $request)
    {
        $query = Gallery::active()->orderBy('sort_order', 'asc')->orderBy('event_date', 'desc')->orderBy('id', 'desc');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        $photos = $query->paginate(12)->withQueryString();
        $categories = Gallery::active()->distinct()->whereNotNull('category')->pluck('category');
        $currentCategory = $request->input('category', 'all');

        return view('gallery', compact('photos', 'categories', 'currentCategory'));
    }
}
