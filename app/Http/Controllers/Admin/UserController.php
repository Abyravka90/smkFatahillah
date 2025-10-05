<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:users.index')->only('index');
        $this->middleware('permission:users.create')->only('create', 'store');
        $this->middleware('permission:users.edit')->only('edit', 'update');
        $this->middleware('permission:users.delete')->only('destroy');
    }

    public function index(){
        $users = User::latest()->when(request()->q, function($users){ 
            $users = $users->where('name', 'like', '%'.request()->q.'%');
        } )->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function create(){
        $roles = Role::latest()->get();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->assignRole($request->input('roles'));

        if($user){
            return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Disimpan']);
        }else{
            return redirect()->route('admin.user.index')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function edit(User $user){
        $roles = Role::latest()->get();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user = User::findOrFail($user->id);

        if($request->input('password') == ''){
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email')
            ]);
        }else{
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
        }

        $user->syncRoles($request->input('roles'));

        if($user){
            return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return redirect()->route('admin.user.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        if($user){
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
