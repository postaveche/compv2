<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('id', 'DESC');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'LIKE', "%{$s}%")->orWhere('email', 'LIKE', "%{$s}%");
            });
        }
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }
        $users = $query->paginate(25);
        $roles = Role::all();
        $rolesMap = $roles->pluck('name', 'id')->toArray();
        return view('admin.users.index', compact('users', 'roles', 'rolesMap'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.form', ['user' => null, 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Utilizator creat!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.form', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'Utilizator actualizat!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users.index')->with('danger', 'Nu poti sterge propriul cont!');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilizator sters!');
    }

    // === ROLES ===
    public function roles()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.users.roles', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Role::create(['name' => $request->name, 'slug' => \Illuminate\Support\Str::slug($request->name)]);
        return redirect()->route('admin.roles.index')->with('success', 'Rol adaugat!');
    }

    public function deleteRole($id)
    {
        if ($id <= 4) {
            return redirect()->route('admin.roles.index')->with('danger', 'Rolurile de baza nu pot fi sterse!');
        }
        Role::findOrFail($id)->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rol sters!');
    }
}
