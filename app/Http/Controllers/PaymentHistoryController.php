<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentHistoryController extends Controller
{
    public function index(Request $request){

        return view('payment_history.index');
    }

    public function get_payment_history(Request $request){
        // dd($request->all());
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        // $columnIndex = $columnIndex_arr[0]['column']; // Column index
        // $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        // Set default start and end dates
        $start_date = Carbon::today()->startOfDay();
        $end_date = Carbon::today()->endOfDay();

        // Check if start date and end date are present in the request
        if (request()->has('start_date') && request()->has('end_date')) {
            $start_date = Carbon::createFromFormat('Y-m-d', request()->input('start_date'))->startOfDay();
            $end_date = Carbon::createFromFormat('Y-m-d', request()->input('end_date'))->endOfDay();
        }

        $totalRecords = Payment::with(['corpse', 'user', 'service'])
        ->where('qty', '!=', 0)
        ->whereHas('corpse', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        })
        ->whereBetween('created_at', [$start_date, $end_date])
        ->count();

        $totalRecordswithFilter = Payment::with(['corpse', 'user', 'service'])
        ->where('qty', '!=', 0)
        ->whereHas('corpse', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        })
        ->whereBetween('created_at', [$start_date, $end_date])
        ->count();

        // Fetch records
        $records = Payment::with(['corpse', 'user', 'service'])
        ->where('qty', '!=', 0)
        ->whereHas('corpse', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        })
        ->whereBetween('created_at', [$start_date, $end_date])
        ->orderByDesc('created_at')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();
        $cash = Payment::where('mode', 'cash')->where('status', 'success')->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
        $transfer = Payment::where('mode', 'tranfer')->where('status', 'success')->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
        $pos = Payment::where('mode', 'pos')->where('status', 'success')->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
        $others = Payment::where('mode', 'others')->where('status', 'success')->whereBetween('created_at', [$start_date, $end_date])->sum('amount');
        $total = $cash + $transfer + $pos + $others;

        foreach ($records as $key => $record) {
            $id = $record->id;
            $corpse_name = $record->corpse->name;
            $user_name = $record->user->name;
            $date = $record->created_at->format('Y-m-d');
            $payment_method = ucfirst($record->mode);
            $amount = $record->price * $record->qty;
            $service = $record->service-> name ?? Str::limit($record->corpse->desc, 18, '...') ?? 'Affixed Bill';

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "corpse_name" => $corpse_name,
                "user_name" => $user_name,
                "payment_method" => $payment_method,
                "date" => $date,
                "amount" => number_format($amount,2),
                "service" => $service,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
            'cash' => number_format($cash,2),
            'transfer' => number_format($transfer,2),
            'pos' => number_format($pos,2),
            'others' => number_format($others,2),
            'total' => number_format($total,2),
        );

        echo json_encode($response);
        exit;
    }
}
