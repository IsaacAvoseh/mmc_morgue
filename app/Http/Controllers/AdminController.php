<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        return view('dashboard', [
            'billing_count' => 3,
            'payment_count' => 3,
            'user_count' => User::count()
        ]);
    }
}
