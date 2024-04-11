<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images');
        } else {
            $path = null;
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile_image = $path;
        $user->save();

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
