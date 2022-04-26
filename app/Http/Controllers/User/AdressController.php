<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Adress;
use App\Models\ShippMethod;
use Illuminate\Http\Request;
use FlyingLuscas\Correios\Client;

class AdressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $address = Adress::where('user_id', auth()->user()->id)->first();
        $ship = ShippMethod::where('user_id', auth()->user()->id)->first();
        return view('front.suas-preferencia.atualizar-endereco', compact('address', 'ship'));
    }
    public function buscaCep(Request $request)
    {
        $correios = new Client;

        $cep = $correios->zipcode()->find($request->search);

        return $cep;
    }

    public function update(Request $request)
    {
        $address['user_id'] = auth()->guard('cliente')->user()->id;
        $address['cep'] = $request->cep;
        $address['endereco'] = $request->endereco;
        $address['complemento'] = $request->complemento;
        $address['ref'] = $request->ref;
        $address['numero'] = $request->numero;
        $address['bairro'] = $request->bairro;
        $address['cidade'] = $request->cidade;
        $address['estado'] = $request->estado;

        if($request->address_id){
            $address = Adress::where('id', $request->address_id)->update($address);
        }else{
            $address = Adress::create($address);
        }

        $ship['user_id'] = auth()->guard('cliente')->user()->id;
        $ship['data'] = $request->data;
        $ship['horario'] = $request->horario;
        $ship['tipo'] = $request->tipo;

        if($request->ship_id){
            $ship = ShippMethod::where('id', $request->ship_id)->update($ship);
        }else{
            $ship = ShippMethod::create($ship);
        }

        return redirect($request->url_previous)->with('success', 'Endereço atualizadocom sucesso!');
    }
}
