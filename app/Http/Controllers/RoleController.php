<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json("hello");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);
        return response()->json([
            "message" => "add role successfully",
            "role" => $role,
            201
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $role)
    {
        $role = Role::findOrFail($role);
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id.'|max:255',
        ]);

        $role->update([
            'name' => $request->name,
        ]);
        return response()->json([
            "message" => "update role successfully",
            "role" => $role,
            201
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($role)
    {
        $role = Role::findOrFail($role);
        $role->permission()->detach();
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }
}
