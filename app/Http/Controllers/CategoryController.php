<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $category = new Category;

        if ($request->picture != null) {
            $image_info = getimagesize($request->picture);
            $ext = (isset($image_info["mime"]) ? explode('/', $image_info["mime"])[1] : "");
            $exp = explode(',', $request->picture);
            $picture = $exp[1];
            $fecha = Carbon::now()->timestamp;
            $filename = "foto_{$request->name}_{$fecha}.{$ext}";
            Storage::disk('imgCategory')->put($filename, base64_decode($picture));
            $category->picture = $filename;
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        $category->picture = getFileToBase64(Storage::disk('imgCategory')->get($category->picture));
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        if ($request->has('picture')) {
            $picture = $request->picture;
            $ext = explode('/', mime_content_type($picture))[1];
            $exp = explode(',', $picture);
            $picture = $exp[1];
            $filename = "foto_{$category->name}_".Carbon::now()->timestamp.".$ext";
            Storage::disk('imgCategory')->put($filename, base64_decode($picture));
            $category->picture = $filename;
        }
    
        $category->update($request->all());
        return response()->json($category, 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
