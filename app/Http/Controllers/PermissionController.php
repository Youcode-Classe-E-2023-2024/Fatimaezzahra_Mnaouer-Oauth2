<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
/**

Display a listing of the resource.*/
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

/**

Show the form for creating a new resource.*/
    public function create()
    {
        //
        }

        /**

        Store a newly created resource in storage .*/
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions|max:255',
            ]);

        $permission = Permission::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'message' => "add perimission successfully",
            'permission' => $permission,
            200
        ]);
    }

    /**

Display the specified resource .*/
  public function show(permission $permission)
    {

    //
    }

        /**

        Show the form for editing the specified resource .*/
  public function edit(permission $permission)
    {
    //
    }

    /**
        Update the specified resource in storage .*/
  public function update(Request $request, $permission)
    {
        $permission = Permission::findOrFail($permission);
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id . '|max:255',
            ]);

        $permission->update([
            'name' => $request->name,
        ]);
        return response()->json([
            'message' => "updating perimission successfully",
            'permission' => $permission,
            200
        ]);
    }

    /**
     *
     * Remove the specified resource from storage.*/
  public function destroy($permission)
    {
        $permission = Permission::findOrFail($permission);
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully']);
    }


    public function assignPermission(Request $request, $roleId)
    {

        $permission = Permission::findOrFail($request->permission_id);
        $permission->role()->attach($roleId);
        return response()->json(['message' => 'Permission assigned successfully']);
    }

}
