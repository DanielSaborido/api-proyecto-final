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

        if ($request->foto != null) {
            $image_info = getimagesize($request->foto);
            $ext = (isset($image_info["mime"]) ? explode('/', $image_info["mime"])[1] : "");
            $exp = explode(',', $request->foto);
            $foto = $exp[1];
            $fecha = Carbon::now()->timestamp;
            $filename = "foto_{$request->name}_{$fecha}.{$ext}";
            Storage::disk('imgCategory')->put($filename, base64_decode($foto));
            $category->foto = $filename;
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return response()->json($category, 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
