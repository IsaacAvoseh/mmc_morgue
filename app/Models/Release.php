<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function corpse(){
        return $this->belongsTo(Corpse::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
