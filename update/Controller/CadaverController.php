<?php

namespace App\Http\Controllers;

use App\Models\Corpse;
use App\Models\Document;
use App\Models\FileUpload;
use App\Models\Payment;
use App\Models\Rack;
use App\Models\Referral;
use App\Models\ReferralDetails;
use App\Models\Release;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CadaverController extends Controller
{
    public function index(Request $request)
    {
        return view('corpses.index');
    }

    public function admit(Request $request)
    {
        if ($request->isMethod("POST")) {
            $request->validate([
                'name' => 'required',
                'rack_id' => 'required'
            ], ['rack_id.required' => 'No available rack or non selected']);
            $data = $request->except('admission_id');

            $data['user_id'] = Auth::user()->id;
            try {
                $rack = Rack::find($request->rack_id);
                if ($rack->status != 'available') {
                    return response()->json(['error' => 'Selected rack is not available'], 500);
                } else {
                    $rack->update([
                        'status' => 'used'
                    ]);
                }
                if ($request->admission_id) {
                    $saved = Corpse::find($request->admission_id)->update($data);
                    $saved = Corpse::find($request->admission_id);
                } else {
                    $admit = new Corpse();
                    $saved = $admit->create($data);
                    session()->flash('ref_corpse_id', $saved->id);
                }

                return response()->json(['success' => 'Added Successfully', 'data' => $saved], 200);
               
            } catch (\Exception $e) {
                info('admit error', $e);
                return response()->json(['error' => 'An error occurred, Please try again', 'data' => 'no data'], 500);
               
            }
        }

        $files = Document::latest()->get();
        $fees = Service::latest()->get();
        $racks = Rack::where('status', 'available')->get();
        return view('corpses.admit', ['files' => $files, 'fees' => $fees, 'racks' => $racks]);
    }

    public function get_num_of_days(Request $request)
    {
        $date_from = Carbon::parse($request->date_from);
        $date_to = Carbon::parse($request->date_to);
        if ($date_to < $date_from) {
            return response()->json(['error' => 'Start Date is greater than end date'], 500);
        }
        $number_of_days = $date_to->diffInDays($date_from);

        return response()->json(['success' => 'Success', 'days' => $number_of_days], 200);
    }

    public function add_days(Request $request)
    {
        // Retrieve the date_from and days values from the request
        $date_from = $request->input('date_from');
        $days = $request->input('days');

        // Convert the date_from value to a Carbon instance
        $date = Carbon::parse($date_from);

        // Add the number of days to the date_from value
        $date->addDays($days);

        // Format the resulting date as dd-mm-yyyy
        $date_to = $date->format('Y-m-d');

        // Set the calculated date to the date_to field in the response
        return response()->json(['date' => $date_to]);
    }

    public function update_admission(Request $request)
    {
        $update = Corpse::find($request->admission_id);
        // dd($request->all());
        if ($update) {
            // check if the request contains files
            if ($request->hasFile('document_1') || $request->hasFile('document_2') || $request->hasFile('document_3') || $request->hasFile('document_4')) {
                $data = $request->except(['filename', '_token', 'admission_id', 'document_id']);
                // get the admission_id parameter from the request
                $admissionId = $request->input('admission_id');
                // create a folder for the files based on the admission_id
                $folderName = 'admission_' . $admissionId;

                try {
                    // loop through the files in the request
                    $index = 0;
                    foreach ($data as $key => $file) {
                        // create a unique filename for the file
                        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                        // resize the image or keep the file as is
                        if (in_array($file->getClientOriginalExtension(), ['png', 'jpg', 'jpeg'])) {
                            // resize the image using the Intervention Image library
                            $resizedFile = Image::make($file)->resize(800, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode();
                        } else {
                            // keep the file as is
                            $resizedFile = file_get_contents($file);
                        }

                        // save the file to the storage disk
                        Storage::disk('public')->put($folderName . '/' . $filename, $resizedFile);

                        // save the file path to the database
                        $fileModel = new FileUpload();
                        $fileModel->corpse_id = $admissionId;
                        $fileModel->filename = $filename;
                        $fileModel->user_id = auth()->user()->id;
                        $fileModel->document_id = $request->document_id[$index];
                        // dd($fileModel);
                        $fileModel->path = $folderName . '/' . $filename;
                        $fileModel->save();
                        $index++;
                    }
                    // return a success response
                    return response()->json(['success' => 'Files uploaded successfully.'], 201);
                } catch (\Exception $e) {
                    return response()->json(['error', 'Somthing went wrong1'], 500);
                }
            } else {
                // return an error response if no files were found in the request
                return response()->json(['error' => 'No files were found in the request.'], 500);
            }
        } else {
            return response()->json(['error', 'Somthing went wrong3'], 500);
        }
    }

    public function with_payment(Request $request)
    {
        // dd($request->all());
        if ($request->isMethod('POST')) {
            $request->validate([
                'admission_id' => 'required',
                'date_from' => 'required',
                // 'date_to' => 'required',
                'total_amount' => 'required',
                // 'no_of_days' => 'required',
                'mode' => 'required',
            ], ['mode.required' => 'Please select a payment mode', 'admission_id.required' => 'Error !', 'date_from' => 'Please select a start date']);

           if($request->date_from && $request->date_to){
                $dateFrom = Carbon::parse($request->date_from);
                $dateTo = Carbon::parse($request->date_to);
                $noOfDays = $request->no_of_days;
                $daysDiff = $dateTo->diffInDays($dateFrom);
                
                if ($daysDiff != $noOfDays) {
                    return response()->json(['error' => 'Start and End date selected does not match number of days. Please check your input'], 500);
                }
           }

            $corpse = Corpse::find($request->admission_id);

            try {
                DB::beginTransaction();
                $corpse->update([
                    'date_from' => $request->date_from,
                    'date_to' => $request->date_to,
                    'amount' => $corpse->amount + $request->total_amount,
                    'discount' => $corpse->discount + $request->discount,
                    'amount_paid' => $corpse->amount_paid + $request->amount_paid,
                    'no_of_days' => $corpse->no_of_days + $request->no_of_days,
                    'paid' => 'yes'
                ]);


                $unit = count($request->unit_fee);
                // Loop through the fees and create/update payment records
                for ($i = 0; $i < $unit; $i++) {
                    $feeId = $request->fee[$i];
                    $price = $request->price[$i];
                    $qty = $request->unit_fee[$i];
                    $amount = $price * $qty;
                    // Check if a payment record already exists for this fee and corpse
                    $payment = Payment::where('corpse_id', $corpse->id)
                    ->where('service_id', $feeId)
                    ->first();

                    if ($payment) {
                        // If a payment record exists, update it
                        $payment->update([
                            'qty' => $payment->qty + $qty,
                            'price' => $price,
                            'status' => 'success',
                            'mode' => $request->mode,
                            'amount' => $payment->amount + $amount,
                            'user_id' => auth()->user()->id,
                        ]);
                    } else {
                        // If no payment record exists, create a new one
                        Payment::create([
                            'qty' => $qty,
                            'service_id' => $feeId,
                            'price' => $price,
                            'status' => 'success',
                            'mode' => $request->mode,
                            'amount' => $amount,
                            'corpse_id' => $corpse->id,
                            'user_id' => auth()->user()->id,
                        ]);
                    }
                }
                DB::commit();
                // if($request->wantsJson()){
                return response()->json(['success' => 'Payment updated Successfully.', 'corpse_id' => $corpse->id, 'service_id' => $request->fee ], 201);
                // }else{
                return redirect()->route('corpses')->with('success', 'Payment updated Successfully');
                // }
            } catch (\Throwable $th) {
                DB::rollBack();
                // if ($request->wantsJson()) {
                    return response()->json(['error' => 'An error occurred, please try again later.'], 500);
                // } else {
                    return redirect()->route('corpses')->with('error', 'An error occurred, please try again later');
                // }
            }
        }
    }

    public function update_receipt_numbers(Request $request)
    {
        // dd($request->all());
        $corpse_id = $request->input('corpse_id');
        $payments = Payment::where('corpse_id', $corpse_id)->whereIn('service_id', $request->input('service_id'))->get();
        $newReceiptNumber = $request->input('receipt_number');

        foreach ($payments as $payment) {
            $receiptNumbersString = $payment->receipt_numbers ?? '[]'; // Default to an empty array if it's not set
            $receiptNumbers = json_decode($receiptNumbersString, true); // Decode the JSON string into an array
            $receiptNumbers[] = $newReceiptNumber; // Append the new receipt number
            $updatedReceiptNumbersString = json_encode($receiptNumbers); // Encode the array back into a JSON string

            $payment->update([
                'receipt_numbers' => $updatedReceiptNumbersString,
            ]);

        }
        info('receipt_number'.$corpse_id, ['newReceiptNumber' => $newReceiptNumber]);
        return response()->json(['receipt_number' => $newReceiptNumber, 'success' => 'Receipt number updated successfully.' ], 201);
    }


    public function update_payment(Request $request){
        // dd($request->all());
        if ($request->id) {
            //   Check payment
            $corpse = Corpse::find(base64_decode($request->id));
            $payment = DB::table('payments')->where('corpse_id', $corpse->id)->where('status', 'success')->sum(DB::raw('price * qty'));
          
            $release = $payment == $corpse->amount & $payment != 0 & $corpse->amount ? 'yes' : 'no';
            $release1 = $payment == $corpse->amount & $payment != 0 & $corpse->amount != 0 ? 'yes' : 'no';

            $fees = Service::latest()->get();
            $origina_daily_fee = Service::where('name', 'Daily Fee')->pluck('price')[0];
            $daily_fee = Payment::with('service')->where('corpse_id', $corpse->id)->whereHas('service', function ($query) {
                $query->where('name', 'Daily Fee');
            })->pluck('price')[0] ?? $origina_daily_fee;
         
            $fees = $fees->map(function ($fee) use ($daily_fee) {
                // Check if the fee is the "Daily Fee" and update its price
                if ($fee->name === 'Daily Fee') {
                    $fee->price = $daily_fee;
                }
                return $fee;
            });
            session()->flash('ref_corpse_id', $corpse->id);
            return view('corpses.update_payment', [
                'fees' => $fees,
                'data' => $corpse,
                'release' => $release,
                'payment_message' => $release1 == 'no' ? 'You need to make payment before releasing this corpse.' : 'no',
            ]);
        } else {
            return back()->withErrors('Something went wrong!');
        }
    }

    public function without_payment()
    {
        return redirect()->route('corpses')->with('success', 'Success! Please remember to make payment later');
    }

    public function get_corpses(Request $request)
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
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        // $columnSortOrder = $order_arr[0]['desc']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Corpse::select('count(*) as allcount')->where('status', 'admitted')->count();
        $totalRecordswithFilter = Corpse::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->where('status', 'admitted')->count();

        // Fetch records
        $records = Corpse::orderBy($columnName?? 'created_at', 'desc')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->where('status', 'admitted')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        // dd($records);
        $data_arr = array();
        $view_route = route('get_corpse');
        $release_route = route('release');
        $delete_route = route('release');
        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $age = $record->age;
            $sex = $record->sex;
            $date_received = $record->date_received;
            $date_to = $record->date_to;
            $relation = $record->family_rep1_name ?? $record->family_rep2_name;
            $rack = DB::table('racks')->where('id', $record->rack_id)->get()->last()->name ?? 'None';

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "relation" => $relation,
                "sex" => $sex,
                "age" => $age,
                "date_received" => $date_received,
                "date_to" => $date_to,
                "rack" => $rack,
                "action" => '<div class="d-flex justify-content-center">
                    <a class="btn btn-primary m-2" href=' . $view_route . '?id=' . base64_encode($id) . '> <i class="fa fa-eye"></i> View </a>
                    <a class="btn btn-success m-2" href=' . $release_route . '?id=' . base64_encode($id) . '> <i class="fa fa-sign-out-alt"></i> Release</a>'
                . (Auth::user() && session()->get('user_type') == 'admin' ?
                    '<a class="btn btn-danger m-2" onclick="deleteConfirm(\'' . $id . '\',\'' . $name . '\')"> <i class="fa fa-trash"></i> Delete</a>' : '')
                . '</div>',
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

    public function get_corpse(Request $request)
    {
        // dd($request->all());
        if ($request->id) {
            $corpse = Corpse::find(base64_decode($request->id));
            $files = FileUpload::where('corpse_id', base64_decode($request->id))->with('document')->get();
            $referral = ReferralDetails::with(['referral'])->where('corpse_id', base64_decode($request->id))->first();
            // dd($corpse);
            return view('corpses.view', ['data' => $corpse, 'files' => $files, 'referral' => $referral]);
        } else {
            return back()->withErrors('Something went wrong!');
        }
    }

    public function edit_corpse(Request $request)
    {
        if ($request->id) {
            $corpse = Corpse::find(base64_decode($request->id));
            // dd($corpse);
            if($request->isMethod('POST')){
                $corpse = Corpse::find($request->id);
                try{
                    $data = $request->except(['_token', 'id']);
                    $corpse->update($data);
                    return redirect()->route('get_corpse', ['id' => base64_encode($corpse->id)])->with('success', 'Corpse updated successfully');
                }catch(\Exception $e){
                    return back()->withErrors('Something went wrong..!');
                }
            }
            return view('corpses.edit', ['data' => $corpse]);
        } else {
            return back()->withErrors('Something went wrong..!');
        }
    }

    public function delete_corpse(Request $request){
        if($request->id){
            $delete =  Corpse::find($request->id);
            if($delete){
                // try{
                    // Payment 
                    DB::table('payments')->where('corpse_id', $delete->id)->delete();
                    // Refferal
                    DB::table('referral_details')->where('corpse_id', $delete->id)->delete();
                    // Files
                    DB::table('file_uploads')->where('corpse_id', $delete->id)->delete();
                    // Update rack
                    DB::table('racks')->where('id', $delete->rack_id)->update([
                        'status' => 'available'
                    ]);
                    // Corpse
                    $delete->delete();
                    return response()->json(['success','Deleted Successfully'],200);
                // } catch (\Exception $e) {
                //     return  response()->json([ 'error','An error occurred'],404);
                // }
            }else{
                return response()->json([ 'error','Something went wrong..!'],404);
            }
        }
    }


    public function release(Request $request)
    {
        if ($request->id) {
            //   Check payment
            $corpse = Corpse::find(base64_decode($request->id));
            $payment = DB::table('payments')->where('corpse_id', $corpse->id)->where('status', 'success')->sum('amount');
            // Check if all required files has been uploaded
            // Get the required document IDs
            $file_message = 'no';
            $documentIds = Document::where('required', 'yes')->pluck('id');
            // Get all the files uploaded by the user
            $uploadedFiles = FileUpload::where('corpse_id', base64_decode($request->id))->get();
            // Get the IDs of the uploaded files that match the required files
            $uploadedFileIds = $uploadedFiles->pluck('id')->toArray();
            $matchingFileIds = FileUpload::whereIn('id', $uploadedFileIds)
                ->whereIn('document_id', $documentIds)
                ->pluck('document_id')->toArray();
            // Get the IDs of the required files that have not been uploaded
            $missingFileIds = array_diff($documentIds->toArray(), $matchingFileIds);
            // Get the names of the missing documents
            $missingDocumentNames = Document::whereIn('id', $missingFileIds)->pluck('name');
            // If there are missing files, return an error message
            if ($missingDocumentNames->isNotEmpty()) {
                $file_message = "Please upload the following required documents before releasing this corpse: " . $missingDocumentNames->implode(', ');
                // Return the error message to the user
            } else {
                // All required files have been uploaded
            }

            $due_today = 0;
            $advance = 0;

            $origina_daily_fee = Service::where('name', 'Daily Fee')->pluck('price')[0];
            $daily_fee = Payment::with('service')->where('corpse_id', $corpse->id)->whereHas('service', function ($query) { $query->where('name', 'Daily Fee');})->pluck('price')[0]?? $origina_daily_fee;
            $daily_fee_paid = Payment::with('service')->where('corpse_id', $corpse->id)->whereHas('service', function ($query) { $query->where('name', 'Daily Fee');})->pluck('amount')[0]?? 0;

            // dd($daily_fee_paid);
            $date_from = Carbon::parse($corpse->date_from);
            $date_received = Carbon::parse($corpse->date_received);
            $optional_from_date_received = $date_received->diffInDays(now());


            $days_diff = $date_from->diffInDays(now());
            // dd($days_diff);
            if($days_diff > 0 & $date_from < now()){
                $due_today = ($daily_fee * $days_diff) - $daily_fee_paid;
                $due_today = $due_today > 0 ? $due_today : ($due_today < 0 ? $due_today : 0) ;
                $advance = $due_today < 0 ? $due_today : 0;
            }

            // $corpse_amount = $corpse->amount_paid + $corpse->discount + $corpse->affixed_bill;
            // dd($payment, $corpse_amount);
            $release = $corpse->amount_paid != 0 & $file_message == 'no' & $due_today <= 0 ? 'yes' : 'no';
            $release1 = $corpse->amount_paid != 0  & $due_today <= 0 ? 'yes' : 'no';
          
            $corpse_payment = Payment::with('service')->where('corpse_id', $corpse->id)->where('status', 'success')->get();
        
            return view(
                'corpses.release',
                [
                    'data' => $corpse,
                    'release' => $release,
                    'file_message' => $file_message,
                    'payment_message' => $release1 == 'no' ? 'You need to make payment or pay due fees before releasing this corpse.' : 'no',
                    'due_today' => $due_today,
                    'advance' => $advance,
                    'corpse_payment' => $corpse_payment,
                    'days_diff' => $days_diff,
                    'daily_fee' => number_format($daily_fee?? 0, 2),
                    'optional_from_date_received' => $optional_from_date_received,
                ]
            );
        }
       

        // handle release form
        if ($request->isMethod('POST')) {
            // dd($request->all());
            $request->validate([
                'name' => 'required',
                'corpse_id' => 'required',
            ]);

            $data =  $request->except(['_token', 'rack_id', 'name', 'date_admit', 'address', 'age', 'date']);
            $data['user_id'] = Auth::user()->id;
            try {
                $release = new Release();
                $corpse = Corpse::find($request->corpse_id);
                $rack = Rack::find($request->rack_id);

                DB::beginTransaction();
                $corpse->update([
                    'status' => 'released'
                ]);
               
                $rack->update([
                    'status' => 'available'
                ]);
                
                $saved = $release->create($data);
                DB::commit();
                return response()->json(['success' => 'Released Successfully', 'data' => $saved], 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['error' => 'An error occurred, Please try again', 'error_data' => $th], 500);
            }
        }
    }

    public function release_list(Request $request)
    {
        return view('corpses.release_list');
    }

    public function get_release_list(Request $request)
    {
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

        // Check if start and end date are present in the request
        if (isset($request->start_date) && isset($request->end_date)) {
            $startDate = Carbon::createFromFormat('Y-m-d', request()->input('start_date'))->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', request()->input('end_date'))->endOfDay();

            // Total records between selected date range
            $totalRecords = Release::with('corpse')
            ->whereHas('corpse', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

            $totalRecordswithFilter = Release::with('corpse')
            ->whereHas('corpse', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

            // Fetch records between selected date range
            $records = Release::with('corpse')
                ->whereHas('corpse', function ($query) use ($searchValue) {
                    $query->where('name', 'like', '%' . $searchValue . '%');
                })
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderByDesc('created_at')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        } else {
            // Total records for today
            $totalRecords = Release::with('corpse')
            ->whereHas('corpse', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })
            ->whereDate('created_at', Carbon::today())
            ->count();

            $totalRecordswithFilter = Release::with('corpse')
            ->whereHas('corpse', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })
            ->whereDate('created_at', Carbon::today())
            ->count();

            // Fetch records for today
            $records = Release::with('corpse')
                ->whereHas('corpse', function ($query) use ($searchValue) {
                    $query->where('name', 'like', '%' . $searchValue . '%');
                })
                ->whereDate('created_at', Carbon::today())
                ->orderByDesc('created_at')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        $data_arr = array();
        $view_route = route('get_corpse');
        $release_route = route('release');
        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->corpse->name;
            $required = ucfirst($record->required);
            $date_discharged = $record->date_discharged;
            $sex = $record->corpse->sex;
            $collector = $record->collector;
            $relationship = $record->relationship;
            $collector_phone = $record->collector_phone;
            $collector_address = $record->collector_address;
            $interment_address = $record->interment_address;
            $interment_lga = $record->interment_lga;
            $driver_name = $record->driver_name;
            $vehicle_number = $record->vehicle_number;

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "sex" => $sex,
                "date_discharged" => $date_discharged,
                "collector" => $collector,
                "relationship" => $relationship,
                "collector_phone" => $collector_phone,
                "collector_address" => $collector_address,
                "interment_address" => $interment_address,
                "interment_lga" => $interment_lga,
                "driver_name" => $driver_name,
                "vehicle_number" => $vehicle_number,
                "action" => '<div class="d-flex justify-content-center">
                                            <a class="btn btn-primary m-2" href=' . $view_route . '?id=' . base64_encode($id) . '> <i class="fa fa-eye"></i> View Details</a>
                                            <a class="btn btn-success m-2" href=' . $release_route . '?id=' . base64_encode($id) . '> <i class="fa fa-sign-out-alt"></i> Release</a>
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

    public function update_before_release(Request $request)
    {
        if ($request->id) {
            //   Check payment
            $corpse = Corpse::find(base64_decode($request->id));
            $payment = DB::table('payments')->where('corpse_id', $corpse->id)->where('status', 'success')->sum('amount');
            // Check if all required files has been uploaded
            // Get the required document IDs
            $file_message = 'no';
            $documentIds = Document::where('required', 'yes')->pluck('id');
            // Get all the files uploaded by the user
            $uploadedFiles = FileUpload::where('corpse_id', base64_decode($request->id))->get();
            // Get the IDs of the uploaded files that match the required files
            $uploadedFileIds = $uploadedFiles->pluck('id')->toArray();
            $matchingFileIds = FileUpload::whereIn('id', $uploadedFileIds)
                ->whereIn('document_id', $documentIds)
                ->pluck('document_id')->toArray();
            // Get the IDs of the required files that have not been uploaded
            $missingFileIds = array_diff($documentIds->toArray(), $matchingFileIds);
            // Get the names of the missing documents
            $missingDocumentNames = Document::whereIn('id', $missingFileIds)->pluck('name');
            // If there are missing files, return an error message
            if ($missingDocumentNames->isNotEmpty()) {
                $file_message = "Please upload the following required documents before releasing this corpse: " . $missingDocumentNames->implode(', ');
                // Return the error message to the user
            } else {
                // All required files have been uploaded
            }

            $due_today = 0;
            $advance = 0;

            $origina_daily_fee = Service::where('name', 'Daily Fee')->pluck('price')[0];
            $daily_fee = Payment::with('service')->where('corpse_id', $corpse->id)->whereHas('service', function ($query) {
                $query->where('name', 'Daily Fee');
            })->pluck('price')[0] ?? $origina_daily_fee;
            $daily_fee_paid = Payment::with('service')->where('corpse_id', $corpse->id)->whereHas('service', function ($query) {
                $query->where('name', 'Daily Fee');
            })->pluck('amount')[0] ?? 0;

            // dd($daily_fee_paid);
            $date_from = Carbon::parse($corpse->date_from);

            $days_diff = $date_from->diffInDays(now());
            // dd($days_diff);
            if ($days_diff > 0 & $date_from < now()) {
                $due_today = ($daily_fee * $days_diff) - $daily_fee_paid;
                $due_today = $due_today > 0 ? $due_today : ($due_today < 0 ? $due_today : 0);
                $advance = $due_today < 0 ? $due_today : 0;
            }

            // $corpse_amount = $corpse->amount_paid + $corpse->discount + $corpse->affixed_bill;
            // dd($payment, $corpse_amount);
            $release = $corpse->amount_paid != 0 & $file_message == 'no' & $due_today <= 0 ? 'yes' : 'no';
            $release1 = $corpse->amount_paid != 0  & $due_today <= 0 ? 'yes' : 'no';

            $corpse_payment = Payment::with('service')->where('corpse_id', $corpse->id)->where('status', 'success')->get();
            $files = Document::latest()->get();
            $fees = Service::latest()->get();
            $daily_fee = Payment::with('service')->where('corpse_id', $corpse->id)->whereHas('service', function ($query) {
                $query->where('name', 'Daily Fee');
            })->pluck('price')[0];

            $fees = $fees->map(function ($fee) use ($daily_fee) {
                // Check if the fee is the "Daily Fee" and update its price
                if ($fee->name === 'Daily Fee') {
                    $fee->price = $daily_fee;
                }
                return $fee;
            });

            session()->flash('ref_corpse_id',
                $corpse->id
            );
            return view('corpses.update_before_release', [
                'files' => $files,
                'fees' => $fees,
                'data' => $corpse,
                'release' => $release,
                'file_message' => $file_message,
                'payment_message' => $release1 == 'no' ? 'You need to make payment or pay due fees before releasing this corpse.' : 'no',
                'due_today' => $due_today,
                'advance' => $advance,
                'corpse_payment' => $corpse_payment,
                'days_diff' => $days_diff,
                'daily_fee' => number_format($daily_fee ?? 0, 2)
            ]);
        } else {
            return back()->withErrors('Something went wrong!');
        }
    }

    public function view_by_due_and_to_be_collected_this_month(){
        return view('corpses.view_by_due_and_to_be_collected_this_month');
    }

    public function get_view_by_due_and_to_be_collected_this_month(Request $request)
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
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        // $columnSortOrder = $order_arr[0]['desc']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        if($request->stats == 'due'){
            // Total records
            $totalRecords = Corpse::select('count(*) as allcount')->where('status', 'admitted')->whereDate('date_to', '<=', now())->count();
            $totalRecordswithFilter = Corpse::select('count(*) as allcount')->where('status', 'admitted')->whereDate('date_to', '<=', now())->where('name', 'like', '%' . $searchValue . '%')->count();

            // Fetch records
            $records = Corpse::orderBy($columnName ?? 'created_at', 'desc')
                ->where('name', 'like', '%' . $searchValue . '%')
                ->where('status', 'admitted')
                ->whereDate('date_to', '<=', now())
                ->skip($start)
                ->take($rowperpage)
                ->get();
            
        }

        if($request->stats == 'collect'){
            // Total records
            $totalRecords = Corpse::select('count(*) as allcount')->where('status', 'admitted')->whereRaw('MONTH(date_to) = ?', [now()->format('m')])->count();
            $totalRecordswithFilter = Corpse::select('count(*) as allcount')->where('status', 'admitted')->whereRaw('MONTH(date_to) = ?', [now()->format('m')])->where('name', 'like', '%' . $searchValue . '%')->count();

            // Fetch records
            $records = Corpse::orderBy($columnName ?? 'created_at', 'desc')
                ->where('name', 'like', '%' . $searchValue . '%')
                ->where('status', 'admitted')
                ->whereRaw('MONTH(date_to) = ?', [now()->format('m')])
                ->skip($start)
                ->take($rowperpage)
                ->get();

        }

        // dd($records);
        $data_arr = array();
        $view_route = route('get_corpse');
        $release_route = route('release');
        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $age = $record->age;
            $sex = $record->sex;
            $date_received = $record->date_received;
            $date_to = $record->date_to;
            $relation = $record->family_rep1_name ?? $record->family_rep2_name;
            $rack = DB::table('racks')->where('id', $record->rack_id)->get()->last()->name ?? 'None';

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "relation" => $relation,
                "sex" => $sex,
                "age" => $age,
                "date_received" => $date_received,
                "date_to" => $date_to,
                "rack" => $rack,
                "action" => '<div class="d-flex justify-content-center">
                                            <a class="btn btn-primary m-2" href=' . $view_route . '?id=' . base64_encode($id) . '> <i class="fa fa-eye"></i> View </a>
                                            <a class="btn btn-success m-2" href=' . $release_route . '?id=' . base64_encode($id) . '> <i class="fa fa-sign-out-alt"></i> Release</a>
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

     public function reports(){
        return view('corpses.reports');
    }
    
    public function get_reports(Request $request)
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
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        // $columnSortOrder = $order_arr[0]['desc']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Set default start and end dates
        $start_date = Carbon::today()->startOfDay();
        $end_date = Carbon::today()->endOfDay();

        // Check if start date and end date are present in the request
        if (request()->has('start_date') && request()->has('end_date')
        ) {
            $start_date = Carbon::createFromFormat('Y-m-d', request()->input('start_date'))->startOfDay();
            $end_date = Carbon::createFromFormat('Y-m-d', request()->input('end_date'))->endOfDay();
        }

        // Total records
        $totalRecords = Corpse::select('count(*) as allcount')
        ->where(function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date])
            ->orWhereBetween('updated_at', [$start_date, $end_date]);
        })
        ->count();

        $totalRecordswithFilter = Corpse::select('count(*) as allcount')
        ->where(function ($query) use ($start_date, $end_date, $searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%')
            ->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date])
                ->orWhereBetween('updated_at', [$start_date, $end_date]);
            });
        })
        ->count();

        $records = Corpse::orderBy($columnName ?? 'created_at', 'desc')
        ->where('name', 'like', '%' . $searchValue . '%')
        ->where(function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date])
            ->orWhereBetween('updated_at', [$start_date, $end_date]);
        })
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();
        $total = Corpse::select('count(*) as allcount')
        ->where(function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date])
            ->orWhereBetween('updated_at', [$start_date, $end_date]);
        })
        ->count();

        $admitted = Corpse::select('count(*) as allcount')
        ->where('status', 'admitted')
        ->where(function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date])
            ->orWhereBetween('updated_at', [$start_date, $end_date]);
        })
        ->count();

        $released = Corpse::select('count(*) as allcount')
        ->where('status', 'released')
        ->where(function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date])
            ->orWhereBetween('updated_at', [$start_date, $end_date]);
        })
        ->count();


        foreach ($records as $key => $record) {

            $id = $record->id;
            $name = $record->name;
            $age = $record->age;
            $sex = $record->sex;
            $date_received = $record->date_received;
            $date_to = $record->date_to;
            $relation = $record->family_rep1_name ?? $record->family_rep2_name;
            $rack = DB::table('racks')->where('id', $record->rack_id)->get()->last()->name ?? 'None';
            $status = $record->status;

            $data_arr[] = array(
                "id" => ($start / $rowperpage) * $rowperpage + $key + 1,
                "name" => $name,
                "relation" => $relation,
                "sex" => $sex,
                "age" => $age,
                "date_received" => $date_received,
                "date_to" => $date_to,
                "rack" => $rack,
                "status" => ucfirst($status),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
            "total" => $total,
            "admitted" => $admitted,
            "released" => $released,
        );

        echo json_encode($response);
        exit;
    }

}
