<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }
}
