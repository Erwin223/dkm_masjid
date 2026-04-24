<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::query()->orderBy('name', 'asc')->get();

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$admin->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];

        if (Auth::id() == $admin->id) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        $request->validate($rules, [
            'current_password.required' => 'Kata sandi saat ini wajib diisi untuk keamanan.',
            'current_password.current_password' => 'Kata sandi saat ini tidak cocok dengan data kami.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        if (Auth::id() == $admin->id) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
