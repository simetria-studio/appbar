<?php

namespace App\Http\Controllers\Painel;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $admins = User::all();
        return view('painel.settings.admin.index', get_defined_vars());
    }

    public function store(Request $request)
    {
        $admin['name'] = $request->name;
        $admin['email'] = $request->email;
        $admin['password'] = Hash::make($request->password);

        User::create($admin);

        return redirect()->back()->with('success', 'Administrador registrado com successo!');
    }

    public function edit($id)
    {
        $admin = User::find($id);
        return view('painel.settings.admin.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $admin['name'] = $request->name;
        $admin['email'] = $request->email;
        if($request->password) $admin['password'] = Hash::make($request->password);

        User::find($id)->update($admin);

        return redirect()->route('setting.admin')->with('success', 'Administrador alterado com successo!');
    }

    public function destroy(Request $request, $id)
    {
        User::find($id)->delete();

        return response()->json('success', 200);
    }
}
