<?php

namespace App\Http\Controllers;

use App\Models\CommentAndRating;
use Illuminate\Http\Request;

class CommentAndRatingController extends Controller
{
    public function index()
    {
        $commentsAndRatings = CommentAndRating::all();
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
