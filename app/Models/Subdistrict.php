<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;

    protected $fillable = ['district_id', 'name', 'code', 'full_code', 'pos_code'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
