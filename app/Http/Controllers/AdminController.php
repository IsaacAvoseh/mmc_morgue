<?php

namespace App\Http\Controllers;

use App\Models\Corpse;
use App\Models\Rack;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        return view('dashboard', [
            'available_rack_count' => Rack::where('status', 'available')->count(),
            'used_rack_count' => Rack::where('status', 'used')->count(),
            'rack_count' => Rack::count(),
            'user_count' => User::count(),
            'in_morgue' => Corpse::where('status', 'admitted')->count(),
        ]);
    }
}
