<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rack extends Model
{
    // use CrudTrait;
    use HasFactory;
    // use SoftDeletes;
    protected $guarded = [];
}
