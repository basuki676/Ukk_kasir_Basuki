<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function ViewUsers()
    {
        $users = User::all();
        return view('users.view', compact('users'));
    }

    public function AddData()
    {
        return view('users.add');
    }

    public function CreateData(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ],
            [
                'email.unique' => 'Email sudah digunakan, silakan gunakan email lain.',
            ],
        );

        // Simpan user baru
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = bcrypt($request->password); // Enkripsi password
        $users->save();

        return redirect()->route('users.view');
    }
    public function EditData($id)
    {
        $users = User::find($id);
        return view('users.edit', compact('users'));
    }
    public function UpdateData(Request $request, $id)
    {
        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = $request->password;
        $users->save();
        return redirect()->route('users.view');
    }
    public function DeleteData($id)
    {
        $users = User::find($id);
        $users->delete();
        return redirect()->route('users.view');
    }
}
