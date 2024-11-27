<?php

namespace App\Http\Controllers;

use App\Models\Eventcategory;
use App\Models\Categories;
use App\Models\Event;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventCategoyController extends Controller
{
    public function index(){
        $eventCategoryList = DB::table("event_categories as ec")
        ->join("events as e", "e.id",  "ec.event_id")
        ->join("users as u", "e.user_id",  "u.id")
        ->join("categories as c", "c.id","ec.category_id")
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
            "c.name"
        )->get();

        return response()->json($eventCategoryList);
    }

    public function categoryName()
    {
        $categoryList = DB::table('categories as ca')
        ->select(
            "ca.id",
            "ca.name",
        )->get();
    
        if($categoryList) {
            return response()->json(['message' => 'Category found', 'data' => $categoryList]);
        } else {
            return response()->json(['message' => 'Event Category not found'], 404);
        }
    }
    

    public function show(string $id)
    {
        $eventCategory = DB::table('event_categories as ec')
            ->join('events as e', 'e.id', '=', 'ec.event_id')
            ->join('categories as c', 'c.id', '=', 'ec.category_id')
            ->where('e.id', $id)
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
                "c.id as category_id",
            )->first();

        if ($eventCategory) {
            return response()->json(['message' => 'Event Category found', 'data' => $eventCategory]);
        } else {
            return response()->json(['message' => 'Event Category not found'], 404);
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
            'category_id' => 'required|exists:categories,id', // Asocia a una categoría existente
        ]);
    
        DB::beginTransaction();
    
        try {
            // Crear el evento
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
    
            // Crear la relación en Eventcategory con una categoría existente
            $eventCategory = new Eventcategory();
            $eventCategory->event_id = $event->id;
            $eventCategory->category_id = $request->category_id; // Usar el ID de la categoría que llega del frontend
            $eventCategory->save();
    
            DB::commit();
            return response()->json(['message' => 'Event created successfully']);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating event: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
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
            'category_id' => 'required|exists:categories,id', // Aseguramos que la categoría exista
        ]);
    
        DB::beginTransaction();
    
        try {
            // Encontrar el evento a actualizar
            $event = Event::findOrFail($id);
    
            // Actualizar el evento con los nuevos datos
            $event->title = $request->title;
            $event->description = $request->description;
            $event->hour = $request->hour;
            $event->place = $request->place;
            $event->availabl_space = $request->availabl_space;
            $event->type = $request->type;
            $event->base_value = $request->base_value;
            $event->opening_date = $request->opening_date;
            $event->closing_date = $request->closing_date;
            $event->user_id = auth()->user()->id; // Mantener al mismo usuario
            $event->save();
    
            // Actualizar la relación en Eventcategory con la nueva categoría
            $eventCategory = $event->categories()->first(); // Asumiendo que la relación es many-to-many
            $eventCategory->category_id = $request->category_id; // Actualizamos la categoría
            $eventCategory->save();
    
            DB::commit();
            return response()->json(['message' => 'Event updated successfully']);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating event: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            // Buscar el evento
            $event = Event::find($id);
            if (!$event) {
                return response()->json(['message' => 'Event not found'], 404);
            }
    
            // Obtener las categorías asociadas al evento
            $categories = Eventcategory::where('event_id', $id)->pluck('category_id');
    
            // Eliminar las relaciones en Eventcategory
            Eventcategory::where('event_id', $id)->delete();
    
            // Eliminar las categorías asociadas al evento
            Categories::whereIn('id', $categories)->delete();
    
            // Eliminar el evento
            $event->delete();
    
            return response()->json(['message' => 'Event and related data deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting event: ' . $e->getMessage()], 500);
        }
    }
}
