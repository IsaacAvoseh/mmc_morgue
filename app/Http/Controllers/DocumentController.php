<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function documents(Request $request){

        if ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required',
                'required' => 'required',
            ]);

            if (Auth::user()->type != 'admin') {
                return back()->with('error', 'You are not permitted to perform this action');
            }

            try {
                $service = new Document();
                $service->name = $request->name;
                $service->required = $request->required;
                $service->user_id = auth()->user()->id;
                $service->save();
                return back()->with('success', 'Document added successfully');
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to add document');
            }
        }
        return view('documents.index');
    }

    public function get_documents(Request $request){
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
        $totalRecords = Document::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Document::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Document::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $required = ucfirst($record->required);
            $added = $record->created_at->diffForHumans();

            $data_arr[] = array(
                "id" => $key + 1,
                "name" => $name,
                "required" => $required,
                "added" => $added,
                "action" => '  <div class="d-flex">
                                            <a class="btn btn-primary m-2" onclick="get_document(' . $id . ')"> <i class="fa fa-edit"></i> </a>
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


    public function get_document(Request $request)
    {
        // return json response
        if ($request->id) {
            try {
                $document = Document::find($request->id);
                // delay for 1 seconds
                sleep(0.5);
                return response()->json(['success' => 'Document fetched successfully', 'data' => $document], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error fetching document'], 500);
            }
        } else {
            return response()->json(['error' => 'Error fetching document'], 500);
        }
    }

    public function document_edit(Request $request)
    {
        if ($request->document_id) {
            $document = Document::find($request->document_id);
            // abort(500);
            $document->update([
                'name' => $request->name,
                'required' => $request->required,
            ]);
            return response()->json(['success' => 'Updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function delete_document(Request $request)
    {
        if ($request->id) {
            try {
                $document = Document::find($request->id);
                $document->delete();
                return response()->json(['success' => 'Document deleted successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error deleting document'], 500);
            }
        } else {
            return response()->json(['error' => 'Error deleting document'], 500);
        }
    }
}
