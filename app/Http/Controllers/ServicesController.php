<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function services(Request $request){

        if ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
            ]);

            if (Auth::user()->type != 'admin') {
                return back()->with('error', 'You are not permitted to perform this action');
            }

            try {
                    $service = new Service();
                    $service->name = $request->name;
                    $service->price = $request->price;
                    $service->user_id = Auth()->user()->id;
                   $service->save();

                return redirect()->route('services')->with('success', 'Services added successfully');
            } catch (\Exception $e) {

                return back()->with('error', 'Failed to add services');
            }
        }

        return view('services.index');
    }

    public function get_services(Request $request)
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
        $totalRecords = Service::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Service::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Service::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $price = $record->price;
            $added = $record->created_at->diffForHumans();

            $data_arr[] = array(
                "id" => $key + 1,
                "name" => $name,
                "price" => number_format($price,2),
                "added" => $added,
                "action" => '  <div class="d-flex">
                                            <a class="btn btn-primary m-2" onclick="get_service(' . $id . ')"> <i class="fa fa-edit"></i> </a>
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

    public function get_service(Request $request)
    {
        // return json response
        if ($request->id) {
            try {
                $service = Service::find($request->id);
                // delay for 1 seconds
                sleep(0.5);
                return response()->json(['success' => 'Service fetched successfully', 'data' => $service], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error fetching service'], 500);
            }
        } else {
            return response()->json(['error' => 'Error fetching service'], 500);
        }
    }

    public function service_edit(Request $request)
    {
        if ($request->service_id) {
            $service = Service::find($request->service_id);
            // abort(500);
            $service->update([
                'name' => $request->name,
                'price' => $request->price,
            ]);
            return response()->json(['success' => 'Updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function delete_service(Request $request)
    {
        if ($request->id) {
            try {
                $service = Service::find($request->id);
                $service->delete();
                return response()->json(['success' => 'Service deleted successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error deleting service'], 500);
            }
        } else {
            return response()->json(['error' => 'Error deleting service'], 500);
        }
    }
}
