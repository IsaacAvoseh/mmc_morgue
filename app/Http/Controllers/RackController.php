<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use App\Traits\CrudTrait;

class RackController extends Controller
{
    public function racks(Request $request){
        $last_rack_id = Rack::orderBy('id', 'desc')->first();
        $last_rack_id = $last_rack_id !== null ? $last_rack_id->id : 0;
        if ($request->isMethod('POST')) {
            $request->validate([
                'racks' => 'required'
            ]);

            if (Auth::user()->type != 'admin') {
                return back()->with('error', 'You are not permitted to perform this action');
            }

            try {
                //save list of rack to table racks depending on the number of $request->no_of_racks entered, if $request->no_of_racks is 10 , save 10 racks to database
                for ($i = $last_rack_id; $i < number_format($request->racks) + $last_rack_id;) {
                    $rack = new Rack();
                    $rack->name = 'Rack' . ' ' . ($i + 1);
                    $rack->status = 'available';
                    $rack->user_id = Auth()->user()->id;
                    $saved1 = $rack->save();
                    $i++;
                }
                return redirect()->route('racks')->with('success', 'Racks added successfully');
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to add racks');
            }
        }
        $available = Rack::where('status', 'available')->count();
        return view('racks.index',['available' => $available]);
    }

    public function get_racks(Request $request)
    {
        // dd($request->all());
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        // $columnSortOrder = $order_arr[0]['desc']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Rack::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Rack::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Rack::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $status = $record->status;
            $corpse = DB::table('corpses')->where('rack_id', $id)->where('status', 'admitted')->get()->last();
            // $corpse = $record->created_at->format('Y-m-d');

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "status" => $status,
                "corpse" => isset($corpse) ? '<a href="' . route('get_corpse', ['id' => base64_encode($corpse->id?? '')]) . '">' . ($corpse->name ?? 'None') . '</a>' : 'None',
                "action" => '  <div class="d-flex">
                            <a class="btn btn-primary m-2" onclick="get_rack(' . $id . ')"> <i class="fa fa-edit"></i> </a>
                            <a class="btn btn-danger m-2" onclick="deleteConfirm(' . $id . ',' . "'$name'" .  ')"> <i class="fa fa-trash"></i> </a>
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

    public function get_rack(Request $request){
        // return json response
        if ($request->id) {
            try {
                $rack = Rack::find($request->id);
                // delay for 1 seconds
                sleep(0.5);
                return response()->json(['success' => 'Rack fetched successfully', 'data' => $rack], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error fetching rack'], 500);
            }
        } else {
            return response()->json(['error' => 'Error fetching rack'], 500);
        }
    }

    public function rack_edit(Request $request)
    {
        if ($request->rack_id) {
            $rack = Rack::find($request->rack_id);
            // abort(500);
            $rack->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);
            return response()->json(['success' => 'Updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function delete_rack(Request $request)
    {
        if ($request->id) {
            try {
                $rack = Rack::find($request->id);
                $rack->delete();
                return response()->json(['success' => 'Rack deleted successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error deleting rack'], 500);
            }
        } else {
            return response()->json(['error' => 'Error deleting rack'], 500);
        }
    }
}
