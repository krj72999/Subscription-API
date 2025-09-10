<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, $id)
    {
        $user = User::select('id', 'name', 'email')->find($id);
        if (!$user) return response()->json([
            'message' => 'User not found'
        ], 404);
        $user = User::findOrFail($id);

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
