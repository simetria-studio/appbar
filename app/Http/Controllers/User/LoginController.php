<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Cart;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.auth.login');
    }

    public function login(Request $request)
    {
        $cookie_maior18 = !empty($_COOKIE['cookie_maior18']) ? $_COOKIE['cookie_maior18'] : null;

        $remember = $request->remember ? true : false;

        $authValid = Auth::guard('cliente')->validate(['cpf' => $request->cpf, 'password' => $request->password]);
        
        if($authValid){
            if (Auth::guard('cliente')->attempt(['cpf' => $request->cpf, 'password' => $request->password],$remember)) {

                if($cookie_maior18) setcookie('cookie_maior18', $cookie_maior18, null, '/');
                if(\Cart::getContent()->count() > 0){
                    return response()->json(route('pre.checkout'), 200);
                }else{
                    return response()->json(route('home'), 200);
                }
            }
        }else{
            return response()->json(['invalid' => 'CPF ou Senha invalidos'], 422);
        }
    }

    public function logout(Request $request)
    {
        auth()->guard('cliente')->logout();
        return redirect()->route('store.login');
    }
}
