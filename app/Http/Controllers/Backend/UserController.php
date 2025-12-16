<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // Permission middleware can be uncommented when permissions are fully set up
            // new Middleware('permission:user.view', only: ['index']),
            // new Middleware('permission:user.create', only: ['create', 'store']),
            // new Middleware('permission:user.edit', only: ['edit', 'update']),
            // new Middleware('permission:user.delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('roles', function($row){
                    $roles = $row->getRoleNames();
                    $badges = '';
                    foreach($roles as $role) {
                        $badges .= '<span class="badge bg-info me-1">'.$role.'</span>';
                    }
                    return $badges;
                })
                ->addColumn('action', function($row){
                    $editUrl = route('backend.users.edit', $row->id);
                    $deleteUrl = route('backend.users.destroy', $row->id);
                    
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
                ->rawColumns(['roles', 'action'])
                ->make(true);
        }
        return view('backend.users.index');
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('backend.users.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return response()->json([
            'success' => 'User created successfully',
            'url' => route('backend.users.index')
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('backend.users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        
        $user->roles()->detach(); // clear old roles
        $user->assignRole($request->input('roles')); // assign new roles
    
        return response()->json([
            'success' => 'User updated successfully',
            'url' => route('backend.users.index')
        ]);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
