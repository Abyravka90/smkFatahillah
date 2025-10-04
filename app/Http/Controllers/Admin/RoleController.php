<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['permission:roles.index'])->only('index');
        $this->middleware(['permission:roles.create'])->only('create', 'store');
        $this->middleware(['permission:roles.edit'])->only('edit', 'update');
        $this->middleware(['permission:roles.delete'])->only('destroy');
    }

    public function index(){
        $roles = Role::latest()->when(request()->q, function($roles){
            $roles = $roles->where('name','like','%'.request()->q.'%');
        })->paginate(10);

        return view('admin.role.index', compact('roles'));
    }

    public function create(){
        $permissions = Permission::latest()->get();
        return view('admin.role.create', compact('permissions'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|unique:roles',
        ]);

        $role = Role::create([
            'name' => $request->input('name')
        ]);

        //assign permission to role
        $role->syncPermissions($request->input('permissions'));

        if($role){
            return redirect()->route('admin.role.index')->with(['success'=>'Data Berhasil Disimpan']);
        }else{
            return redirect()->route('admin.role.index')->with(['error'=>'Data Gagal Disimpan']);
        }
    }

    public function edit(Role $role){
        $permissions = Permission::latest()->get();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role){
        $this->validate($request,[
            'name' => 'required|unique:roles,name,'.$role->id
        ]);

        $role = Role::findOrFail($role->id);
        $role->update([
            'name' => $request->input('name') 
        ]);

        $role->syncPermissions($request->input('permissions'));

        if($role){
            return redirect()->route('admin.role.index')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('admin.role.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        $role->revokePermissionTo($permissions);
        $role->delete();

        if($role){
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
