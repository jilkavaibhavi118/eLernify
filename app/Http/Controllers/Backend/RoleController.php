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
                    $editUrl = route('backend.roles.edit', $row->id);
                    $deleteUrl = route('backend.roles.destroy', $row->id);
                    $csrf = csrf_token();

                    $btn = '<div class="d-flex gap-2">';
                    
                    // Edit Button
                    $btn .= '<a href="' . $editUrl . '" class="btn btn-warning btn-sm d-flex align-items-center gap-1" title="Edit">';
                    $btn .= '<svg class="icon icon-sm"><use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-pencil"></use></svg>';
                    $btn .= '<span>Edit</span></a>';

                    // Delete Button
                    $btn .= '<a href="javascript:void(0)" data-url="'.$deleteUrl.'" class="btn btn-danger btn-sm d-flex align-items-center gap-1 delete-btn" title="Delete">';
                    $btn .= '<svg class="icon icon-sm"><use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-trash"></use></svg>';
                    $btn .= '<span>Delete</span></a>';
                    
                    $btn .= '</div>';

                    return $btn;
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
}
