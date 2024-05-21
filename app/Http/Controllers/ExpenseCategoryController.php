<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
public function expense_category(Request $request)
    {
        // dd(session()->all());

        if ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required'
            ]);

            try {
                $expense_category = new ExpenseCategory();
                $expense_category->name =  $request->name;
                $expense_category->user_id =  auth()->user()->id;
                $expense_category->save();
                return response()->json(['success' => 'Added Successfully !.'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error'], 500);
            }
        }

        return view('expense_category.index');
    }

    public function get_expense_category(Request $request)
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
        $totalRecords = ExpenseCategory::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ExpenseCategory::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = ExpenseCategory::with('user')->orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $user = $record->user->name?? '-';
            $date = $record->created_at->format('Y-m-d');

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "user" => $user,
                "date" => $date,
                
                "action" => '  <div class="d-flex">
                            <a class="btn btn-primary m-2" onclick="get_single_expense_category(' . $id . ')"> <i class="fa fa-edit"></i> </a>
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


    public function get_single_expense_category(Request $request)
    {
        // return json response
        if ($request->id) {
            try {
                $expense_category = ExpenseCategory::find($request->id);
                // delay for 1 seconds
                sleep(0.5);
                return response()->json(['success' => 'ExpenseCategory fetched successfully', 'data' => $expense_category], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error fetching expenseCategory'], 500);
            }
        } else {
            return response()->json(['error' => 'Error fetching expenseCategory'], 500);
        }
    }

    public function expense_category_edit(Request $request)
    {
        if ($request->expense_category_id) {
            $expenseCategory = ExpenseCategory::find($request->expense_category_id);
            // abort(500);
            $expenseCategory->update([
                'name' => $request->name,
            ]);
            return response()->json(['success' => 'Updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function delete_expense_category(Request $request)
    {
        if ($request->id) {
            try {
                $expenseCategory = ExpenseCategory::find($request->id);
                $expenseCategory->delete();
                return response()->json(['success' => 'ExpenseCategory deleted successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error deleting expenseCategory'], 500);
            }
        } else {
            return response()->json(['error' => 'Error deleting expenseCategory'], 500);
        }
    }
}
