<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categorysList = DB::table("categories as cat")
            ->join("users as us", "cat.user_id", "=", "us.id")
            ->select(
                "cat.id",
                "cat.name",
                "cat.description"
            )
            ->get();
    
        return response()->json($categorysList);
    }

    public function show(string $id){
        $category = Categories::find($id);

        if($category) {
            return response()->json(['message' => 'Category found', 'data' => $category]);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        try {
            $category = new Categories();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->user_id = auth()->user()->id;
            $category->save();

            return response()->json(['message' => 'Category created successfully']);

        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating category: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);
        
        try {
            $category = Categories::find($id);
            if (!$category) {
                return response()->json(['message' => 'Category not found'], 404);
            }

            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return response()->json(['message' => 'Category updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating category: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $category = Categories::find($id);

        if(!$category){
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
