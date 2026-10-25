<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'user_id',
        'member_id_card_number',
        'id_card_photo',
        'id_card_issue_date',
        'id_card_expiry_date',
        'id_card_status',
        'post_name',
        'bangla_name',
        'english_name',
        'father_name',
        'mother_name',
        'village',
        'post_office',
        'thana',
        'district',
        'village2',
        'post_office2',
        'thana2',
        'district2',
        'education',
        'date_of_birth',
        'nid',
        'blood_group',
        'jonmodag',
        'current_job',
        'nationality',
        'passport_number',
        'marital_status',
        'spouse_name',
        'spouse_number',
        'religion',
        'phone_number',
        'office_number',
        'facebook_id',
        'email',
        'reference_name',
        'youtube_id',
        'reference_post',
        'signature',
        'status',
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

    public function getEffectivePhotoAttribute(): ?string
    {
        if ($this->id_card_photo && file_exists(public_path($this->id_card_photo))) {
            return asset($this->id_card_photo);
        }
        if ($this->user && $this->user->profile_image && file_exists(public_path($this->user->profile_image))) {
            return asset($this->user->profile_image);
        }
        return null;
    }


    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => ['bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'label' => 'অপেক্ষমান (Pending)'],
            'approved' => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'label' => 'অনুমোদিত (Approved)'],
            'rejected' => ['bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'label' => 'বাতিল (Rejected)'],
            default => ['bg' => 'bg-slate-100 text-slate-800 border-slate-200', 'label' => ucfirst($this->status)]
        };
    }
}
