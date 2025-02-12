<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KtrRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job',
        'address',
        'act_as',
        'road',
        'subdistrict_id',
        'district_id',
        'regency_id',
        'land_area',
        'land_status',
        'purpose',
        'latitude',
        'longitude',
        'ktp_file',
        'land_document',
        'activity_location',
        'sign',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }
}
