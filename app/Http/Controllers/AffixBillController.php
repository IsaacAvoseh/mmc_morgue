<?php

namespace App\Http\Controllers;

use App\Models\Corpse;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AffixBillController extends Controller
{
    function affix_bill(Request $request){
        if ($request->corpse_id) {
            $corpse = Corpse::find($request->corpse_id);
            // abort(500);
          try{
            DB::beginTransaction();
                $corpse->update([
                    'affixed_bill' => $corpse->affixed_bill + $request->affixed_bill,
                    'desc' => $request->desc,
                ]);
                $affix = new Payment();
                $affix->corpse_id = $corpse->id;
                // $affix->service_id = 0;
                $affix->price = $request->affixed_bill;
                $affix->amount = $request->affixed_bill;
                $affix->mode = $request->mode;
                $affix->qty = 1;
                $affix->status = 'success';
                $affix->user_id = auth()->user()->id;
                $affix->save();
                DB::commit();
                return response()->json(['success' => 'Added successfully'], 201);
          }catch(\Exception $e){
            DB::rollBack();
             return response()->json(['error' => 'Something went wrong'], 500);
          }
        } else {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
