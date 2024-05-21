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
        // dd(session()->all());
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
            // 'sales' => DB::table('payments')->where('status', 'success')->whereRaw('MONTH(created_at) = ?', [now()->format('m')])->sum(DB::raw('price * qty'))
            'sales' => DB::table('payments')->where('status', 'success')->whereRaw('MONTH(created_at) = ?', [now()->format('m')])->sum('amount')
        ]);
    }
    
    public function getChartData()
    {
       
        $currentMonthData = [];
        $previousMonthData = [];

        $currentDate = Carbon::today();
        $daysInCurrentMonth = $currentDate->daysInMonth;

        // Retrieve the current month data
        for ($day = 1; $day <= $currentDate->day; $day++) {
            $date = clone $currentDate;
            $count = DB::table('corpses')->whereDate('created_at', $date->subDays($currentDate->day - $day))->count();
            $currentMonthData[] = $count;
        }

        // Retrieve the previous month data
        $previousDate = clone $currentDate->subMonth();
        $daysInPreviousMonth = $previousDate->daysInMonth;

        for ($day = 1; $day <= $daysInPreviousMonth; $day++) {
            $date = clone $previousDate;
            $count = DB::table('corpses')->whereDate('created_at', $date->subDays($daysInPreviousMonth - $day))->count();
            $previousMonthData[] = $count;
        }

        $data = [
            'current_month' => $currentMonthData,
            'previous_month' => $previousMonthData
        ];

        // Return the data as a JSON response
        return response()->json($data);

    }

}
