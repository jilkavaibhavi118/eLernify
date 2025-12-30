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
                ->addColumn('status', function ($user) {
                    return $user->status == 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row){
                    $ordersUrl = route('backend.orders.index', ['user_id' => $row->id]);
                    
                    // Custom buttons for User
                    $extra = '
                        <a href="' . $ordersUrl . '" class="btn btn-info btn-sm text-white d-flex align-items-center gap-1" title="Orders">
                            <svg class="icon text-white" width="16" height="16" style="fill: currentColor; vertical-align: middle;">
                                <use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-cart"></use>
                            </svg>
                            <span>Orders</span>
                        </a>
                        <button type="button" 
                                class="btn btn-sm '.($row->status == 'active' ? 'btn-danger' : 'btn-success').' toggle-status" 
                                data-id="'.$row->id.'">
                            '.($row->status == 'active' ? 'Disable' : 'Enable').'
                        </button>';

                    return view('layouts.includes.list-actions', [
                        'module' => 'users',
                        'routePrefix' => 'backend.users',
                        'data' => $row,
                        'extra' => $extra
                    ])->render();
                })
                ->rawColumns(['roles', 'action', 'status'])
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'status' => 'required|in:active,inactive',
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

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.show', compact('user'));
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'status' => 'required|in:active,inactive',
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

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully'
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q', '');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = User::whereHas('roles', function($q) {
                $q->whereIn('name', ['Instructor', 'Instructores']);
            })
            ->where('status', 'active')
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        $total = $query->count();
        $users = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get(['id', 'name', 'email']);

        $results = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name . ' (' . $user->email . ')'
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }
}
