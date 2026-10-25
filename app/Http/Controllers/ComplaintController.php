<?php

namespace App\Http\Controllers;

use App\Models\Accused;
use App\Models\Complaint;
use App\Models\Witness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $complaints = Complaint::with(['accuseds', 'witnesses'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('complaints.index', compact('complaints'));
    }

    public function create()
    {
        $user = Auth::user();
        $complaintTypes = [
            'জমিজমা সংক্রান্ত বিরোধ',
            'প্রতারণা ও অর্থ আত্মসাৎ',
            'পারিবারিক সমস্যা ও নারী নির্যাতন',
            'শিশু নির্যাতন ও বাল্যবিবাহ',
            'চাঁদাবাজি ও ব্ল্যাকমেইল',
            'শারীরিক নির্যাতন ও মারধর',
            'সাইবার ক্রাইম ও সামাজিক মাধ্যমে হেনস্তা',
            'চুরি, ডাকাতি ও ছিনতাই',
            'মাদক সংক্রান্ত অভিযোগ',
            'অন্যান্য মানবাধিকার লঙ্ঘন'
        ];

        return view('complaints.create', compact('user', 'complaintTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|numeric',
            'phone_number' => 'required|string|max:20',
            'village' => 'required|string|max:255',
            'thana' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'complaint_type' => 'required|string',
            'details' => 'required|string',
            'payment_gateway' => 'required|string',
            'payment_number' => 'required|string',
            'transaction_id' => 'required|string',
        ], [
            'name.required' => 'অভিযোগকারীর নাম আবশ্যক।',
            'age.required' => 'বয়স প্রদান করুন।',
            'phone_number.required' => 'ফোন নম্বর দিন।',
            'village.required' => 'গ্রাম/মহল্লা দিন।',
            'thana.required' => 'থানা নির্বাচন করুন।',
            'district.required' => 'জেলা নির্বাচন করুন।',
            'complaint_type.required' => 'অভিযোগের ধরণ নির্বাচন করুন।',
            'details.required' => 'ঘটনার বিস্তারিত বিবরণ লিখুন।',
            'payment_gateway.required' => 'পেমেন্ট মেথড নির্বাচন করুন।',
            'payment_number.required' => 'যে নম্বর থেকে টাকা পাঠিয়েছেন তা লিখুন।',
            'transaction_id.required' => 'ট্রানজেকশন আইডি প্রদান করুন।',
        ]);

        $user = Auth::user();

        // Optional PDF attachment if user uploaded scanned copy
        $pdfUrl = '';
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfName = uniqid() . '_' . $pdfFile->getClientOriginalName();
            $pdfFile->move(public_path('uploads'), $pdfName);
            $pdfUrl = 'uploads/' . $pdfName;
        }

        $complaint = Complaint::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'age' => $request->age,
            'father_name' => $request->father_name ?? '',
            'mother_name' => $request->mother_name ?? '',
            'spouse_name' => $request->spouse_name ?? '',
            'village' => $request->village,
            'post_office' => $request->post_office ?? '',
            'thana' => $request->thana,
            'district' => $request->district,
            'phone_number' => $request->phone_number,
            'complaint_type' => $request->complaint_type,
            'details' => $request->details,
            'complainant_name' => $request->complainant_name ?? $user->name,
            'complainant_phone' => $request->complainant_phone ?? $user->number,
            'signature' => $request->signature ?? $user->name,
            'status' => 'pending',
            'pdf_url' => $pdfUrl,
            'payment_amount' => $request->payment_amount ?? '250',
            'payment_gateway' => $request->payment_gateway,
            'payment_number' => $request->payment_number,
            'transaction_id' => $request->transaction_id,
            'reject_reason' => '',
            'time' => now()->format('d-m-Y h:i A'),
        ]);

        // Save accused persons if provided
        if ($request->has('accused') && is_array($request->accused)) {
            foreach ($request->accused as $acc) {
                if (!empty($acc['name'])) {
                    Accused::create([
                        'complaint_id' => $complaint->id,
                        'name' => $acc['name'],
                        'age' => !empty($acc['age']) ? $acc['age'] : null,
                        'father_name' => $acc['father_name'] ?? '',
                        'address' => $acc['address'] ?? '',
                        'phone' => $acc['phone'] ?? '',
                    ]);
                }
            }
        }

        // Save witnesses if provided
        if ($request->has('witnesses') && is_array($request->witnesses)) {
            $wNo = 1;
            foreach ($request->witnesses as $wit) {
                if (!empty($wit['name'])) {
                    Witness::create([
                        'complaint_id' => $complaint->id,
                        'witness_no' => (string)$wNo++,
                        'name' => $wit['name'],
                        'age' => !empty($wit['age']) ? $wit['age'] : null,
                        'father_name' => $wit['father_name'] ?? '',
                        'address' => $wit['address'] ?? '',
                        'phone_number' => $wit['phone_number'] ?? '',
                    ]);
                }
            }
        }

        return redirect()->route('complaints.show', $complaint->id)
            ->with('success', 'আপনার অভিযোগটি সফলভাবে জমা হয়েছে! ট্র্যাকিং আইডি: #' . $complaint->id);
    }

    public function show($id)
    {
        $complaint = Complaint::with(['user', 'accuseds', 'witnesses'])->findOrFail($id);

        // Security check: only owner or admin can view details unless tracked
        if (Auth::check() && Auth::id() !== $complaint->user_id && !session('admin_logged_in')) {
            abort(403, 'অননুমোদিত অ্যাক্সেস।');
        }

        return view('complaints.show', compact('complaint'));
    }

    public function printView($id)
    {
        $complaint = Complaint::with(['user', 'accuseds', 'witnesses'])->findOrFail($id);
        return view('complaints.print', compact('complaint'));
    }
}
