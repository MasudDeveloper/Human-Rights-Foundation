<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use HasFactory;

    protected $table = 'witnesses';
    public $timestamps = false;

    protected $fillable = [
        'complaint_id',
        'witness_no',
        'name',
        'age',
        'father_name',
        'address',
        'phone_number',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }
}
