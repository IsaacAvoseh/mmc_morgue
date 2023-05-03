<?php

namespace App\Http\Controllers;

use App\Models\Corpse;
use App\Models\Payment;
use App\Models\Rack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        // dd(now()->month);
        return view('dashboard', [
            'available_rack_count' => Rack::where('status', 'available')->count(),
            'used_rack_count' => Rack::where('status', 'used')->count(),
            'rack_count' => Rack::count(),
            'user_count' => User::count(),
            'in_morgue' => Corpse::where('status', 'admitted')->count(),
            'due' => Corpse::where('status', 'admitted')
            ->whereDate('date_to', '<=', now())
            ->count(),
            'to_be_collected' => Corpse::where('status', 'admitted')
            ->whereRaw('MONTH(date_to) = ?', [now()->format('m')])
            ->count(),
            'sales' => DB::table('payments')->where('status', 'success')->whereRaw('MONTH(created_at) = ?', [now()->format('m')])->sum(DB::raw('price * qty'))
        ]);
    }
    
    public function getChartData()
    {
        // Get the data for the chart
        $currentMonthData = DB::table('corpses')
        ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
        ->whereMonth('created_at', date('m'))
        ->groupBy('day')
        ->orderBy('day', 'asc')
        ->pluck('count')
        ->toArray();

        $previousMonthData = DB::table('corpses')
        ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
        ->whereMonth('created_at', Carbon::now()->subMonth()->month)
        ->groupBy('day')
        ->orderBy('day', 'asc')
        ->pluck('count')
        ->toArray();

        $data = [
            'current_month' => $currentMonthData,
            'previous_month' => $previousMonthData
        ];

        // Return the data as a JSON response
        return response()->json($data);
    }

}
