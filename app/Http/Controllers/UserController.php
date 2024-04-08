<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function addUser(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
//            'role_id' => 'required|integer',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json(['message' => 'User added successfully', 'user' => $user], 201);

    }


    public function editUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email' . $id,
            'password' => 'required',
            'role_id' => 'required|integer',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;

        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }


    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        return response()->json(['message' => 'user deleted successfully'], 200);
    }

}
