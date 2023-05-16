<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    use HasFactory;
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
