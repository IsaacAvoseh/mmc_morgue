<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\RequestItem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {

        if ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required',
                'unit_of_measure' => 'required'
            ]);

            try {
                $inv = new Inventory();
                $inv->name = $request->name;
                $inv->unit_of_measure = $request->unit_of_measure;
                $inv->user_id = auth()->user()->id;
                $inv->save();
                return back()->with('success', 'Item added successfully');
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to add Item');
            }
        }
        return view('inventory.index');
    }

    public function get_inventory(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        // $columnSortOrder = $order_arr[0]['desc']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Inventory::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Inventory::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Inventory::orderByDesc('created_at')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $unit_of_measure = $record->unit_of_measure;
            $updated = $record->updated_at->diffForHumans();
            $in_stock = $record->qty ?? 0;
            $out_stock = $record->out_stock ?? 0;
            // $balance = $record->qty - $record->out_stock?? 0;

            $data_arr[] = array(
                "id" => $key + 1,
                "name" => $name,
                "unit_of_measure" => $unit_of_measure,
                "updated" => $updated,
                "total_in_stock" => $in_stock + $out_stock,
                "total_out_stock" => $out_stock,
                "balance" => $in_stock,
                "action" => '<div class="d-flex">
                <a class="btn btn-success m-2" onclick="get_item1(' . $id . ')" title="Re-stock Item" > <i class="fa fa-plus"></i> </a>
                <a class="btn btn-primary m-2" onclick="get_item(' . $id . ')" title="Edit Item"> <i class="fa fa-edit"></i> </a>
                <a class="btn btn-danger m-2" onclick="deleteConfirm(' . $id . ',' . "'$name'" .  ')" title="Delete Item"> <i class="fa fa-trash"></i> </a>
                </div>',
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }


    public function get_item(Request $request)
    {
        // return json response
        if ($request->id) {
            try {
                $inv = Inventory::find($request->id);
                // delay for 1 seconds
                sleep(0.5);
                return response()->json(['success' => 'Fetched successfully', 'data' => $inv], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error fetching'], 500);
            }
        } else {
            return response()->json(['error' => 'Error fetching'], 500);
        }
    }

    public function edit_item(Request $request)
    {
        if ($request->item_id) {
            $item = Inventory::find($request->item_id);
            // abort(500);
            $item->update([
                'name' => $request->name,
                'unit_of_measure' => $request->unit_of_measure,
            ]);
            return response()->json(['success' => 'Updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function restock_item(Request $request)
    {
        if ($request->item_id) {
            $item = Inventory::find($request->item_id);
            $history = new InventoryHistory();
            $item->update([
                'qty' => $item->qty + $request->qty
            ]);

            $history->inventory_id = $item->id;
            $history->user_id = auth()->user()->id;
            $history->qty = $request->qty;
            $history->type = 'restock';
            $history->status = 'success';
            $history->save();
            return response()->json(['success' => 'Successful !'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function delete_item(Request $request)
    {
        if ($request->id) {
            try {
                $item = Inventory::find($request->id);
                $item->delete();
                return response()->json(['success' => 'Inventory deleted successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error deleting item'], 500);
            }
        } else {
            return response()->json(['error' => 'Error deleting item'], 500);
        }
    }

    public function item_request(Request $request)
    {

        return view('inventory.request');
    }

    public function item_list(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        // $columnSortOrder = $order_arr[0]['desc']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Inventory::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Inventory::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Inventory::orderByDesc('created_at')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $unit_of_measure = $record->unit_of_measure;
            $balance = $record->qty ?? 0;

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "unit_of_measure" => $unit_of_measure,
                "balance" => $balance,
                "action" => '<div class="d-flex">
                <a class="btn btn-success m-2" onclick="get_item1(' . $id . ')" title="Request" > <i class="fa fa-shopping-basket"></i> Request </a>
                </div>',
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    public function make_request(Request $request)
    {

        $request->validate([
            'qty' => 'required',
            'item_id' => 'required',
        ]);

        $item = Inventory::find($request->item_id);
        $new_req = new RequestItem();

        if ($item) {
            if ($request->qty > $item->qty) {
                return response()->json(['error' => 'Requested quantity is greater than item balance'], 500);
            }
            try {
                $new_req->user_id =  auth()->user()->id;
                $new_req->qty =  $request->qty;
                $new_req->status = 'request';
                $new_req->inventory_id = $request->item_id;
                $new_req->save();
                return response()->json(['success' => 'Request sent to Admin for Approval.'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error deleting item'], 500);
            }
        }
    }

    public function request_list()
    {
        return view('inventory.request_list');
    }

    public function get_request_list(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        // $columnSortOrder = $order_arr[0]['desc']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = RequestItem::select('count(*) as allcount')->where('status', 'request')->count();
        $totalRecordswithFilter = RequestItem::with('inventory')->select('count(*) as allcount')
            ->whereHas('inventory', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })->where('status', 'request')
            ->count();

        // Fetch records
        $records = RequestItem::with('inventory')->orderByDesc('created_at')
            ->whereHas('inventory', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })->where('status', 'request')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->inventory->name;
            $unit_of_measure = $record->inventory->unit_of_measure;
            $quantity = $record->qty ?? 0;

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "unit_of_measure" => $unit_of_measure,
                "quantity" => $quantity,
                "action" => '<div class="d-flex">
                <a class="btn btn-success m-2" onclick="get_item1(' . $id . ')" title="Approve" > <i class="fa fa-check"></i> Approve </a>
                <a class="btn btn-danger m-2" onclick="rejectConfirm(' . $id . ',' . "'$name'" .   ')" title="Reject" > <i class="fa fa-window-close"></i> Reject </a>
                </div>',
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    public function get_requested_item(Request $request)
    {
        if ($request->id) {
            $requested_item = RequestItem::with('inventory')->where('id', $request->id)->where('status', 'request')->first();
            if ($requested_item) {
                return response()->json(['data' => $requested_item], 200);
            } else {
                return response()->json(['error' => 'Somthing went wrong.'], 500);
            }
        } {
            return response()->json(['error' => 'Somthing went wrong.'], 500);
        }
    }

    public function approve_request(Request $request)
    {
        // dd($request->all());
        if ($request->inventory_id && $request->id) {
            $item = RequestItem::where('status', 'request')->where('inventory_id', $request->inventory_id)->where('id', $request->id)->first();
            $inv =  Inventory::where('id', $request->inventory_id)->first();
            $history = new InventoryHistory();
           try{
                if ($request->qty > $inv->qty) {
                    return response()->json(['error' => 'Requested quantity is greater than item balance'], 500);
                }
                // update item quantity
                $item->update([
                    'qty' => $request->qty,
                    'status' => 'approved'
                ]);

                $inv->update([
                    'qty' => $inv->qty - $request->qty,
                    'out_stock' => $inv->out_stock + $request->qty
                ]);

                // save history
                $history->inventory_id = $inv->id;
                $history->user_id = auth()->user()->id;
                $history->qty = $request->qty;
                $history->type = 'request';
                $history->status = 'approved';
                $history->save();

                return response()->json(['success' => 'Request Approved.'], 200);

            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error'], 500);
            }
        } else {
            return response()->json(['error' => 'Somthing went wrong.'], 500);
        }
    }

    public function reject_request(Request $request){
        if ($request->id) {
            $item = RequestItem::where('status', 'request')->where('id', $request->id)->first();
            $history = new InventoryHistory();

            try {
                // update item staus
                $item->update([
                    'status' => 'rejected'
                ]);

                // save history
                $history->inventory_id = $item->inventory_id;
                $history->user_id = auth()->user()->id;
                $history->qty = $item->qty;
                $history->type = 'request';
                $history->status = 'rejected';
                $history->save();
                return response()->json(['success' => 'Rejected !.'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error'], 500);
            }
        } else {
            return response()->json(['error' => 'Somthing went wrong.'], 500);
        }

    }
}
