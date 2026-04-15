<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'staff') {
            return view('staff.edit', compact('user'));
        }
        return redirect()->route('users.admin');
    }

    public function indexAdmin()
    {
        $users = User::where('role', 'admin')->get();
        return view('admin.account.index', compact('users'));
    }

    public function indexStaff()
    {
        $users = User::where('role', 'staff')->get();
        return view('admin.account.index_operator', compact('users'));
    }

    public function create()
    {
        return view('admin.account.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make('secret-temporary'),
        ]);

        $firstFourEmail = substr($user->email, 0, 4);
        $passwordRaw = $firstFourEmail . $user->id;

        $user->password = Hash::make($passwordRaw);
        $user->save();

        $targetRoute = ($request->role == 'admin') ? 'users.admin' : 'users.staff';
        return redirect()->route($targetRoute)->with('created_password', $passwordRaw);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->role == 'staff') {
            return view('staff.edit', compact('user'));
        }
        return view('admin.account.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if (Auth::user()->role == 'staff') {
            return redirect()->route('users.index')->with('success', 'Profil diperbarui!');
        }

        $targetRoute = ($user->role == 'admin') ? 'users.admin' : 'users.staff';
        return redirect()->route($targetRoute)->with('success', 'Akun diperbarui!');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $firstFourEmail = substr($user->email, 0, 4);
        $passwordRaw = $firstFourEmail . $user->id;

        $user->password = Hash::make($passwordRaw);
        $user->save();

        return back()->with('reset_password', $passwordRaw);
    }

    public function destroy($id)
    {
        if ($id == auth()->id()) {
            return redirect()->back()->with('error', 'Gagal! Anda tidak dapat menghapus akun yang sedang Anda gunakan.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }

    public function exportAdmin()
    {
        return Excel::download(new UsersExport('admin'), 'admin-accounts.xlsx');
    }
    public function exportStaff()
    {
        return Excel::download(new UsersExport('staff'), 'staff-accounts.xlsx');
    }
}
