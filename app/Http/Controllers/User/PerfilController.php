<?php

namespace App\Http\Controllers\User;

use App\Models\Cliente;
use App\Models\Adress;
use App\Models\ShippMethod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function index()
    {
        $address = Adress::where('user_id', auth()->user()->id)->first();
        return view('front.suas-preferencia.perfil', compact('address'));
    }

    public function edit()
    {
        return view('front.suas-preferencia.atualizar-perfil');
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:clientes,email,'.auth()->guard('cliente')->user()->id,
            'whatsapp' => 'required',
        ];
        if($request->password) $rules['password'] = 'required|string|min:8|confirmed';

        $customMessages = [
            'name.required' => 'O campo Nome é obrigatório!',
            'email.required' => 'O campo Email é obrigatório!',
            'email.unique' => 'Já existe um Email desse registrado!',
            'whatsapp.required' => 'O campo Celular é Obrigatório!',
        ];
        if($request->password) $customMessages['password.required'] = 'O campo Senha é Obrigatório!';
        if($request->password) $customMessages['password.confirmed'] = 'O campo Senha não confere!';

        $this->validate($request, $rules, $customMessages);

        $user = Cliente::find(auth()->guard('cliente')->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->whatsapp = $request->whatsapp;
        if($request->password) $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('perfil')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function update_photo(Request $request)
    {
        if($request->img_profile){
            $img = Image::make($request->img_profile);
            
            $name = Str::random() . '.jpg';
            
            $originalPath = storage_path('app/public/profile_path/');
            
            $img->save($originalPath . $name);
        }

        $user = Cliente::find(auth()->guard('cliente')->user()->id);
        if($request->img_profile) $user->profile_photo_path = $name;
        $user->save();

        return response()->json('success',200);
    }
}
