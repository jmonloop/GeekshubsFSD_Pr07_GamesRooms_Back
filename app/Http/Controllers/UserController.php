<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    //GET USER BY ID
    public function getById($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }


    //GET ALL USERS
    public function getAll()
    {
        $users = User::all();
        return response()->json($users);
    }


    //UPDATE USER
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Validation failed',
                $validator->errors()
            ], 400);
        }

        $user = User::find($id);
        $user->email = $request->email;

        $user->save();

        return response()->json($user);
    }


    //DELETE USER
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json($user);
    }
}
