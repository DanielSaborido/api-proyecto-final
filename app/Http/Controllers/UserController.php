<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $user = new User;
        $fecha = Carbon::now()->timestamp;

        if ($request->picture != null) {
            $image_info = getimagesize($request->picture);
            $ext = (isset($image_info["mime"]) ? explode('/', $image_info["mime"])[1] : "");
            $exp = explode(',', $request->picture);
            $picture = $exp[1];
            $filename = "foto_{$request->name}_{$fecha}.{$ext}";
            Storage::disk('imgUser')->put($filename, base64_decode($picture));
            $user->picture = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->token = $request->admin==1?`A_{$user->id}_{$fecha}`:`U_{$user->id}_{$fecha}`;
        $user->save();
        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        $user->picture = getFileToBase64(Storage::disk('imgUser')->get($user->picture));
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        if ($request->has('picture')) {
            $picture = $request->picture;
            $ext = explode('/', mime_content_type($picture))[1];
            $exp = explode(',', $picture);
            $picture = $exp[1];
            $nombreArchivo = "foto_{$user->name}_".Carbon::now()->timestamp.".$ext";
            Storage::disk('imgUser')->put($nombreArchivo, base64_decode($picture));
            $user->picture = $nombreArchivo;
        }

        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
