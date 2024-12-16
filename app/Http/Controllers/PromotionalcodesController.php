<?php

namespace App\Http\Controllers;

use App\Models\Promotionalcodes;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionalcodesController extends Controller
{
    public function index()
    {
        $promotionList = DB::table("promotional_codes as pc")
            ->select(
                "pc.id",
                "pc.code",
            )
            ->get();
    
        return response()->json($promotionList);
    }

    public function show(string $id){
        $promotionalCodes = Promotionalcodes::find($id);

        if($promotionalCodes) {
            return response()->json(['message' => 'Promotional Codes found', 'data' => $promotionalCodes]);
        } else {
            return response()->json(['message' => 'Promotional Codes not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'discount' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string'
        ]);

        try {
            $promotionalCodes = new Promotionalcodes();
            $promotionalCodes->code = $request->code;
            $promotionalCodes->discount = $request->discount;
            $promotionalCodes->start_date = $request->start_date;
            $promotionalCodes->end_date = $request->end_date;
            $promotionalCodes->status = $request->status;
            $promotionalCodes->save();

            return response()->json(['message' => 'Promotional code created successfully']);

        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating promotional code: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => 'required|string',
            'discount' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string'
        ]);
        
        try {
            $promotionalCodes = Promotionalcodes::find($id);
            if (!$promotionalCodes) {
                return response()->json(['message' => 'Promotional code not found'], 404);
            }

            $promotionalCodes->name = $request->name;
            $promotionalCodes->code = $request->code;
            $promotionalCodes->discount = $request->discount;
            $promotionalCodes->start_date = $request->start_date;
            $promotionalCodes->end_date = $request->end_date;
            $promotionalCodes->status = $request->status;
            $promotionalCodes->save();

            return response()->json(['message' => 'Promotional code updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating promotional code: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $promotionalCodes = Promotionalcodes::find($id);

        if(!$promotionalCodes){
            return response()->json(['message' => 'Promotional code not found'], 404);
        }

        $promotionalCodes->delete();

        return response()->json(['message' => 'Promotional code deleted successfully']);
    }
}
