<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    //  ADD BANK

    public function get(Request $request)
    {
        $bank = Bank::find($request->id);

        return response()->json([
            'status' => true,
            'data' => $bank
        ]);
    }

    public function store(Request $request)
    {
        $bank = Bank::create([
            'bank_name' => $request->bank_name,
            'bank_detail' => $request->bank_detail
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bank Added',
            'data' => $bank
        ]);
    }

    //  UPDATE BANK
    public function update(Request $request)
    {
        $bank = Bank::find($request->id);

        if (!$bank) {
            return response()->json([
                'status' => false,
                'message' => 'Bank not found'
            ]);
        }

        $bank->update([
            'bank_name' => $request->bank_name,
            'bank_detail' => $request->bank_detail
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bank Updated'
        ]);
    }

    //  DELETE BANK
    public function delete(Request $request)
    {
        $bank = Bank::find($request->id);

        if ($bank) {
            $bank->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Bank Deleted'
        ]);
    }
}
