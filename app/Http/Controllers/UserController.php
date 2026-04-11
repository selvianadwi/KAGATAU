<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan Daftar Petugas (Hanya Admin)
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak');
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Form Tambah Petugas Baru (Hanya Admin)
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('users.create');
    }

    /**
     * Proses Simpan Petugas Baru (Hanya Admin)
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:mysql_layanan.users,username|max:50',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password, // Otomatis ter-hash oleh Model
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Petugas baru berhasil ditambahkan!');
    }

    /**
     * Form Edit (Bisa Admin edit siapa saja, atau User edit diri sendiri)
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $user->id) {
            abort(403, 'Bukan hak akses Anda.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Proses Update Data
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $user->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:mysql_layanan.users,username,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        // Role hanya bisa diubah oleh Admin dan tidak boleh mengubah role diri sendiri
        if (Auth::user()->role === 'admin' && $request->has('role') && $user->id !== Auth::id()) {
            $user->role = $request->role;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Hapus Petugas (Hanya Admin)
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Petugas berhasil dihapus!');
    }
}