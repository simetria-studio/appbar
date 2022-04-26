<?php

namespace App\Http\Controllers\User;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:clientes',
            'cpf' => 'required|string|unique:clientes',
            'password' => 'required|string|min:8|confirmed',
            'whatsapp' => 'required',
            'terms' => 'required',
        ];

        $customMessages = [
            'name.required' => 'O campo Nome é obrigatório!',
            'email.required' => 'O campo Email é obrigatório!',
            'email.unique' => 'Já existe um Email desse registrado!',
            'cpf.required' => 'O campo CPF é obrigatório!',
            'cpf.unique' => 'Já existe um CPF desse registrado!',
            'whatsapp.required' => 'O campo Celular é Obrigatório!',
            'password.required' => 'O campo Senha é Obrigatório!',
            'password.confirmed' => 'O campo Senha não confere!',
            'terms.required' => 'O campo Termos e Condições deve ser aceito!',
        ];

        $this->validate($request, $rules, $customMessages);

        $save = Cliente::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password),
            'whatsapp' => $request->whatsapp,
        ]);

        if (Auth::guard('cliente')->attempt(['cpf' => $request->cpf, 'password' => $request->password])) {

            if(\Cart::getContent()->count() > 0){
                return response()->json(route('pre.checkout'), 200);
            }else{
                return response()->json(route('home'), 200);
            }
        }
    }
}
