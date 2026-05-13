<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['permission:permissions.index'])->only('index');
        $this->middleware(['permission:permissions.create'])->only(['create', 'store']);
    }

    public function index()
    {
        $permissions = Permission::latest()->when(request()->q, function($permissions){
            $permissions = $permissions->where('name', 'like', '%'.request()->q.'%');
        })->paginate(10);

        return view('admin.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        $guardName = config('auth.defaults.guard', 'web');

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        $permission = Permission::create([
            'name' => $request->input('name'),
            'guard_name' => $guardName,
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        if ($permission) {
            return redirect()->route('admin.permission.index')->with(['success' => 'Permission berhasil ditambahkan']);
        }

        return redirect()->route('admin.permission.index')->with(['error' => 'Permission gagal ditambahkan']);
    }
}
