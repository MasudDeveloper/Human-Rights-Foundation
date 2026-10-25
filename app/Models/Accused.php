<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accused extends Model
{
    use HasFactory;

    protected $table = 'accused';
    public $timestamps = false;

    protected $fillable = [
        'complaint_id',
        'name',
        'age',
        'father_name',
        'address',
        'phone',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }
}
