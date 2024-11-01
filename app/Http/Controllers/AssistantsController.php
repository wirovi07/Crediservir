<?php

namespace App\Http\Controllers;

use App\Models\Assistants;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AssistantsController extends Controller
{

    public function index()
    {
        $assistantsList = DB::table("assistants as ass")
            ->join("users as us", "ass.user_id", "=", "us.id")
            ->select(
                "ass.id",
                "ass.birthdate",
                "ass.email",
                "ass.phone",
                DB::raw("CONCAT(ass.first_name, ' ', ass.last_name) as assistants")
            )
            ->get();
    
        return $assistantsList;
    }

    public function show(string $id){
        $assistant = Assistants::find($id);

        if($assistant) {
            return response()->json(['message' => 'Assistant found', 'data' => $assistant]);
        } else {
            return response()->json(['message' => 'Assistant not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthdate' => 'required|date',
            'email' => 'required|email|string',
            'phone' => 'required|numeric',
        ]);

        try{
            $assistant = new Assistants();
            $assistant->first_name = $request->first_name;
            $assistant->last_name = $request->last_name;
            $assistant->birthdate = $request->birthdate;
            $assistant->email = $request->email;
            $assistant->phone = $request->phone;
            $assistant->user_id = auth()->user()->id;
            $assistant->save();

            return response()->json(['message' => 'Assistant created success']);

        } catch(QueryException $e){
            return response()->json(['message' => 'Error creating Assistant' .$e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthdate' => 'required|date',
            'email' => 'required|email|string',
            'phone' => 'required|numeric',
        ]);
        
        try {
            $assistant = Assistants::find($id);
            $assistant->first_name = $request->first_name;
            $assistant->last_name = $request->last_name;
            $assistant->birthdate = $request->birthdate;
            $assistant->email = $request->email;
            $assistant->phone = $request->phone;

            return response()->json(['message' => 'Assistant updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating assistant' .$e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $assistant = Assistants::find($id);

        if(!$assistant){
            return response()->json(['message' => 'Assistant not found'], 404);
        }

        $assistant->delete();

        return response()->json(['message' => 'Assistant deleted successfully']);
    }
}
