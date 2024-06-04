<?php

namespace App\Http\Controllers;

use App\Models\CommentAndRating;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class CommentAndRatingController extends Controller
{
    public function index()
    {
        $commentsAndRatings = CommentAndRating::all();
        return response()->json($commentsAndRatings);
    }

    public function getByProduct(Product $product)
    {
        $commentsAndRatings = CommentAndRating::where('product_id', $product->id)->get();

        $commentsAndRatings = $commentsAndRatings->map(function ($comments) {
            $customer = Customer::where('id',$comments->customer_id)->first();
            return [
                'id' => $comments->id,
                'rating' => $comments->rating,
                'title' => $comments->title,
                'comment' => $comments->comment,
                'customer_name' => $customer?->name,
                'customer_picture' => $customer?->picture
            ];
        });

        return response()->json($commentsAndRatings);
    }

    public function store(Request $request)
    {
        $commentAndRating = CommentAndRating::create($request->all());

        return response()->json($commentAndRating, 201);
    }

    public function show(CommentAndRating $commentAndRating)
    {
        return response()->json($commentAndRating);
    }

    public function update(Request $request, CommentAndRating $commentAndRating)
    {
        $commentAndRating->update($request->all());
        return response()->json($commentAndRating, 200);
    }

    public function destroy(CommentAndRating $commentAndRating)
    {
        $commentAndRating->delete();
        return response()->json(null, 204);
    }
}
