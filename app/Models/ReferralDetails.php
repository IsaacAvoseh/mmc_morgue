<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function corpse(){
        return $this->belongsTo(Corpse::class);
    }

    public function referral(){
        return $this->belongsTo(Referral::class);
    }
}
