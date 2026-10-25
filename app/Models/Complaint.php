<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'father_name',
        'mother_name',
        'spouse_name',
        'village',
        'post_office',
        'thana',
        'district',
        'phone_number',
        'complaint_type',
        'details',
        'complainant_name',
        'complainant_phone',
        'signature',
        'status',
        'pdf_url',
        'payment_amount',
        'payment_gateway',
        'payment_number',
        'transaction_id',
        'reject_reason',
        'time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function accuseds()
    {
        return $this->hasMany(Accused::class, 'complaint_id');
    }

    public function witnesses()
    {
        return $this->hasMany(Witness::class, 'complaint_id');
    }

    // Helper for status badge class
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => ['bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'label' => 'অপেক্ষমান (Pending)'],
            'approved' => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'label' => 'অনুমোদিত (Approved)'],
            'rejected' => ['bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'label' => 'বাতিল (Rejected)'],
            'investigated' => ['bg' => 'bg-blue-100 text-blue-800 border-blue-200', 'label' => 'তদন্তাধীন (Investigating)'],
            'complete' => ['bg' => 'bg-purple-100 text-purple-800 border-purple-200', 'label' => 'নিষ্পত্তিকৃত (Complete)'],
            default => ['bg' => 'bg-slate-100 text-slate-800 border-slate-200', 'label' => ucfirst($this->status)]
        };
    }
}
