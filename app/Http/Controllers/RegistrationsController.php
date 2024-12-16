<?php

namespace App\Http\Controllers;

use App\Models\Registrations;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationsController extends Controller
{
    public function index()
    {
        $registrationList = DB::table("registrations as r")
        ->join("assistants as as", "as.id", "r.assitant_id")
        ->join("events as e", "e.id", "r.assitant_id")
        ->join("users as u", "e.user_id", "u.id")
        ->select(
            "r.id",
            "r.type_input",
            "r.calculated_value",
            "r.purchase_date",
            "r.code_promotional",
            DB::raw("CONCAT(as.first_name, ' ', as.last_name) as assitant_id"),
            "e.title as event_id",
            "r.user_id"
        )->get();

        return response()->json($registrationList);
    }

    public function show(string $id){
        $registration = Registrations::find($id);

        if($registration) {
            return response()->json(['message' => 'Registration found', 'data' => $registration]);
        } else {
            return response()->json(['message' => 'Registration not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_input' => 'required|string',
            'calculated_value' => 'required',
            'purchase_date' => 'required',
            'code_promotional' => 'required|string',
            'user_id' => 'required',
            'assistant_id' => 'required|string',
            'event_id' => 'required',
        ]);

        try {
            $registration = new Registrations();
            $registration->type_input = $request->type_input;
            $registration->calculated_value = $request->calculated_value;
            $registration->purchase_date = $request->purchase_date;
            $registration->code_promotional = $request->code_promotional;
            $registration->user_id = auth()->user()->id;
            $registration->event_id = $request->event_id;
            $registration->assistant_id = $request->assistant_id;
            $registration->save();

            return response()->json(['message' => 'Registration created successfully']);

        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating registration: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'type_input' => 'required|string',
            'calculated_value' => 'required',
            'purchase_date' => 'required',
            'code_promotional' => 'required|string',
            'user_id' => 'required',
            'assistant_id' => 'required|string',
            'event_id' => 'required',
        ]);
        
        try {
            $registration = Registrations::find($id);
            if (!$registration) {
                return response()->json(['message' => 'Registration not found'], 404);
            }

            $registration->type_input = $request->type_input;
            $registration->calculated_value = $request->calculated_value;
            $registration->purchase_date = $request->purchase_date;
            $registration->code_promotional = $request->code_promotional;
            $registration->user_id = auth()->user()->id;
            $registration->event_id = $request->event_id;
            $registration->assistant_id = $request->assistant_id;
            $registration->save();

            return response()->json(['message' => 'Registration updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating registration: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $registration = Registrations::find($id);

        if(!$registration){
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $registration->delete();

        return response()->json(['message' => 'Registration deleted successfully']);
    }
}
