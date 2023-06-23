<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class InventoryHistoyController extends Controller
{
    public function history(Request $request){
        return view('inventory.history');
    }

    public function get_inventory_history(Request $request){
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

        $totalRecords = InventoryHistory::with(['inventory', 'user'])
            ->whereHas('inventory', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        $totalRecordswithFilter = InventoryHistory::with(['inventory', 'user'])
            ->whereHas('inventory', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Fetch records
        $records = InventoryHistory::with(['inventory', 'user'])
            ->whereHas('inventory', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderByDesc('created_at')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $key => $record) {
            $id = $record->id;
            $user = $record->user->name;
            $name = $record->inventory->name;
            $date = $record->created_at->format('Y-m-d');
            $status = ucfirst($record->status);
            $type = ucfirst($record->type);
            $qty = $record->qty;
            $unit_of_measure = $record->inventory->unit_of_measure;

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "user" => $user,
                "status" => $status,
                "date" => $date,
                "qty" => $qty,
                "type" => $type,
                'unit_of_measure' => $unit_of_measure
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        echo json_encode($response);
        exit;
    }

    public function expenses(Request $request){

        if($request->isMethod('POST')){
            // dd($request->all());
            $request->validate([
                'expense_category_id' => 'required',
                'date' => 'required',
                'amount' => 'required',
            ]);

            try{
              $expense = new Expense();
              $expense->date =  $request->date;
              $expense->vendor =  $request->vendor;
              $expense->amount =  $request->amount;
              $expense->details =  $request->details;
              $expense->expense_category_id =  $request->expense_category_id;
              $expense->user_id =  auth()->user()->id;
              $expense->save();
             return response()->json(['success' => 'Added Successfully !.'], 200);
              
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error'], 500);
            }
        }

        $expense_category = ExpenseCategory::latest()->get();
        return view('inventory.expenses', ['expense_category' => $expense_category]);
    }
    
    public function get_expenses(Request $request){

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
            // dd($end_date, $start_date);
        $totalRecords = Expense::where('vendor', 'like', '%' . $searchValue . '%')->whereBetween('created_at', [$start_date, $end_date])->count();
        $totalRecordswithFilter = Expense::where('vendor', 'like', '%' . $searchValue . '%')->whereBetween('created_at', [$start_date, $end_date])->count();

        // Fetch records
        $records = Expense::with('category')->where('vendor', 'like', '%' . $searchValue . '%')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderByDesc('created_at')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $key => $record) {
            $id = $record->id;
            $date = $record->date;
            $user = $record->name;
            $vendor = $record->vendor;
            $amount = $record->amount;
            $details = $record->details;
            $category = $record->category->name?? '-';
// dd($record);  
            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "date" => $date,
                "vendor" => $vendor,
                "user" => $user,
                "amount" => $amount,
                'details' => $details,
                'category' => $category
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        echo json_encode($response);
        exit;
    }
}
