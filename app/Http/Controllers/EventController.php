<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $eventList = DB::table("events as e")
        ->join("event_categories as ec", "e.id", "ec.event_id")
        ->join("categories as c", "ec.category_id", "c.id")
        ->join("users as u", "e.user_id", "u.id")
        ->select(
            "e.id",
            "e.title",
            "e.description",
            "e.hour",
            "e.place",
            "e.availabl_space",
            "e.type",
            "e.base_value",
            "e.opening_date",
            "e.closing_date",
            "c.name as category_name",
        )->get();

        return response()->json($eventList);
    }

    public function show(string $id){
        $event = Event::find($id);

        if($event) {
            return response()->json(['message' => 'Event found', 'data' => $event]);
        } else {
            return response()->json(['message' => 'Event not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'hour' => 'required',
            'place' => 'required|string',
            'availabl_space' => 'required',
            'type' => 'required|string',
            'base_value' => 'required',
            'opening_date' => 'required|string',
            'closing_date' => 'required|string',
        ]);

        try {
            $event = new Event();
            $event->title = $request->title;
            $event->description = $request->description;
            $event->hour = $request->hour;
            $event->place = $request->place;
            $event->availabl_space = $request->availabl_space;
            $event->type = $request->type;
            $event->base_value = $request->base_value;
            $event->opening_date = $request->opening_date;
            $event->closing_date = $request->closing_date;
            $event->user_id = auth()->user()->id;
            $event->save();

            return response()->json(['message' => 'Event created successfully']);

        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating event: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'hour' => 'required',
            'place' => 'required|string',
            'availabl_space' => 'required',
            'type' => 'required|string',
            'base_value' => 'required',
            'opening_date' => 'required|string',
            'closing_date' => 'required|string',
        ]);
        
        try {
            $event = Event::find($id);
            if (!$event) {
                return response()->json(['message' => 'Event not found'], 404);
            }

            $event->title = $request->title;
            $event->description = $request->description;
            $event->hour = $request->hour;
            $event->place = $request->place;
            $event->availabl_space = $request->availabl_space;
            $event->type = $request->type;
            $event->base_value = $request->base_value;
            $event->opening_date = $request->opening_date;
            $event->closing_date = $request->closing_date;
            $event->save();

            return response()->json(['message' => 'Event updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating event: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $event = Event::find($id);

        if(!$event){
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
