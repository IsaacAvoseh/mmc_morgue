<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\ReferralDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    public function referrals(Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
            ]);
            $referral = new Referral();
            try {
                $referral->name = $request->name;
                $referral->phone = $request->phone;
                $referral->email = $request->email;
                $referral->address = $request->address;
                $referral->dob = $request->dob;
                $referral->referred = 0;
                $referral->save();
                return back()->with('success', 'Saved Successfully');
            } catch (\Exception $e) {
                return back()->with('error', 'Something went wrong');
            }
        }
        return view('referrals.index');
    }

    public function get_referrals(Request $request)
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
        $totalRecords = Referral::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Referral::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Referral::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $phone = $record->phone;
            $email = $record->email?? '---';
            $address = $record->address?? '---';
            $dob = $record->dob?? '---';
            $referred = $record->referred;

            $data_arr[] = array(
                "id" => $key + 1,
                "name" => $name,
                "phone" => $phone,
                "email" => $email,
                "address" => $address,
                "dob" => $dob,
                "referred" => DB::table('referral_details')->where('referral_id', $id)->count(),
                "action" => '  <div class="d-flex">
                                            <a href="' . route('referral', ['id' => base64_encode($id)]) . '" class="btn btn-primary m-2"> <i class="fa fa-eye"></i> </a>
                                            <a class="btn btn-warning m-2" onclick="get_referral(' . $id . ')"> <i class="fa fa-edit"></i> </a>
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
    public function get_referral_details(Request $request)
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
        $totalRecords = ReferralDetails::with(['referral', 'corpse'])->where('referral_id', session()->get('referral_id'))
            ->count();

        $totalRecordswithFilter = ReferralDetails::with(['referral', 'corpse'])->where('referral_id', session()->get('referral_id'))
        ->whereHas('corpse', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        })
        ->count();

        // Fetch records
        $records = ReferralDetails::with(['referral', 'corpse'])->where('referral_id', session()->get('referral_id'))
        ->orderBy('created_at', 'desc')
        ->whereHas('corpse', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        })
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->corpse->name?? '---';
            $amount = $record->amount?? '---';
            $status = $record->status?? '---';
            $date = $record->created_at->diffForHumans()?? '---';
          

            $data_arr[] = array(
                "id" => $key + 1,
                "name" => $name,
                "amount" => number_format($amount, 2),
                "status" => $status,
                "date" => $date,
                "action" => '  <div class="d-flex">
                                            <a href="' . route('get_corpse', ['id' => base64_encode($record->corpse_id)]) . '" class="btn btn-primary m-2"> <i class="fa fa-eye"></i> </a>
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

    public function referral(Request $request){
        if($request->id){
            $referral = Referral::find(base64_decode($request->id));
            session()->flash('referral_id', $referral->id);
            return view('referrals.view', ['data' => $referral]);
        }
        return back()->with('error', 'Something went wrong');
    }

    public function add_ref_details(Request $request){
        try {
            // dd($request->all());
            $ref_details = ReferralDetails::updateOrCreate(
                ['corpse_id' => $request->corpse_id],
                [
                    'referral_id' => $request->referral_id,
                    'status' => $request->status,
                    'user_id' => auth()->user()->id,
                    'amount' => $request->amount,
                ]
            );
            // dd($ref_details);
            return  response()->json(['success' => 'Success !!'],201);
        }catch (\Exception $e){
            return  response()->json(['error' => 'An error occurred, please try again on corpse details page after saving this record'],500 );
        };
    }

    public function get_referral(Request $request){
        if ($request->id) {
            try {
                $referral = Referral::find($request->id);
                // delay for 1 seconds
                sleep(0.5);
                return response()->json(['success' => 'Referral fetched successfully', 'data' => $referral], 200);
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Error fetching referral'], 500);
            }
        } else {
            return response()->json(['error' => 'Error fetching referral'], 500);
        }
    }

   public function referral_edit(Request $request){
        if ($request->id) {
            $referral = Referral::find($request->id);
            // abort(500);
            $referral->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'dob' => $request->dob,
            ]);
            return response()->json(['success' => 'Updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
   }
}
