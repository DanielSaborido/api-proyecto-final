<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $product = new Product;

        if ($request->picture != null) {
            $image_info = getimagesize($request->picture);
            $ext = (isset($image_info["mime"]) ? explode('/', $image_info["mime"])[1] : "");
            $exp = explode(',', $request->picture);
            $picture = $exp[1];
            $fecha = Carbon::now()->timestamp;
            $filename = "foto_{$request->name}_{$fecha}.{$ext}";
            Storage::disk('imgProduct')->put($filename, base64_decode($picture));
            $product->picture = $filename;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->availability = $request->availability;
        $product->category_id = $request->category_id;
        $product->save();

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        $product->picture = getFileToBase64(Storage::disk('imgProduct')->get($product->picture));
        return response()->json($product);
    }

    public function showProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        foreach ($products as $product) {
            $product->picture = getFileToBase64(Storage::disk('imgProduct')->get($product->picture));
        }
        return response()->json($products);
    }

    public function update(Request $request, Product $product)
    {
        if ($request->has('picture')) {
            $picture = $request->picture;
            $ext = explode('/', mime_content_type($picture))[1];
            $exp = explode(',', $picture);
            $picture = $exp[1];
            $filename = "foto_{$product->name}_".Carbon::now()->timestamp.".$ext";
            Storage::disk('imgProduct')->put($filename, base64_decode($picture));
            $product->picture = $filename;
        }

        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        Log::info('Search method called', ['search' => $request->input('search')]);

        $searchTerm = $request->input('search');

        if (!$searchTerm) {
            Log::info('No search term provided');
            return response()->json([], 400);
        }

        $products = Product::where('name', 'like', "%{$searchTerm}%")
            ->take(5)
            ->get();

        Log::info('Products found', ['products' => $products]);

        return response()->json($products);
    }
}
