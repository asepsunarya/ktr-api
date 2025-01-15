<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ktr_request_id',
        'total_cost',
        'payment_id',
        'status',
    ];

    public function ktrRequest()
    {
        return $this->belongsTo(KtrRequest::class);
    }
}
