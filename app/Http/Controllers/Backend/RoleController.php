<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:role.view', only: ['index']),
            new Middleware('can:role.create', only: ['create', 'store']),
            new Middleware('can:role.edit', only: ['edit', 'update']),
            new Middleware('can:role.delete', only: ['destroy']),
        ];
    }   

    public function index()
    {
        if (request()->ajax()) {
            $roles = Role::with('permissions')->latest()->get();
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('layouts.includes.list-actions', [
                        'module' => 'role',
                        'routePrefix' => 'backend.roles',
                        'data' => $row,
                    ])->render();
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.roles.index');
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('backend.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return response()->json([
            'success' => 'Role created successfully',
            'url' => route('backend.roles.index')
        ]);
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('backend.roles.edit', compact(
            'role','permissions','rolePermissions'
        ));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return response()->json([
            'success' => 'Role updated successfully',
            'url' => route('backend.roles.index')
        ]);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully'
        ]);
    }

    public function permissions(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('backend.roles.permissions', compact(
            'role',
            'permissions',
            'rolePermissions'
        ));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('backend.roles.index')
            ->with('success', 'Permissions updated successfully');
    }

}
