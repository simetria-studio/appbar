<?php

namespace App\Http\Controllers\Location;

use App\Models\Unity;
use App\Models\Table;
use App\Models\Product;
use App\Models\Comanda;
use App\Models\ComandaProduct;
use App\Models\OrderFlow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComandaController extends Controller
{
    public function comanda()
    {
        $comanda = Comanda::with('table', 'products.product')->where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();

        return view('location.comanda', get_defined_vars());
    }

    public function makeWish()
    {
        $comanda = Comanda::with('table', 'products.product')->where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();

        foreach($comanda->products as $product) {
            if($product->status == 0){
                ComandaProduct::find($product->id)->update(['status' => 1]);

                if($comanda->waiter_id){
                    if($product->status == 0){
                        OrderFlow::create([
                            'key' => 'comanda_produto',
                            'key_id' => $product->id,
                            'reason' => 'Solicitando pedido'
                        ]);
                    }
                }
            }
        }

        if(empty($comanda->waiter_id)){
            Comanda::find($comanda->id)->update(['waiter_status' => 1]);

            if($comanda->waiter_status == 0){
                OrderFlow::create([
                    'key' => 'comanda',
                    'key_id' => $comanda->id,
                    'reason' => 'Geração da comanda'
                ]);
            }

            $OrderFlow = OrderFlow::where('key', 'comanda')->where('key_id', $comanda->id)->where('status', 0)->first();

            return view('location.waitWaiter', get_defined_vars());
        }

        if(session()->has('comanda_aceita')){
            return redirect()->route('mesa.home')->with('info', 'Aguarde enquanto o garçom prepara seu pedido, logo entregará na sua mesa!');
        }else{
            session(['comanda_aceita', 'true']);
            return redirect()->route('mesa.home')->with('info', 'Garçom já anotou seu pedido e já esta preparando, logo entregará na sua mesa!');
        }
    }
    public function comandaConfirma()
    {
        $comanda = Comanda::with('table', 'products.product')->where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();
        if(empty($comanda)) return redirect()->route('home');
        return view('location.comandaConfirma', get_defined_vars());
    }

    public function comandaCheckout()
    {
        $comanda = Comanda::where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();
        if(empty($comanda)) return redirect()->route('home');
        if($comanda->payment_method == 'dinheiro') {
            if($comanda->status == 2) return redirect()->route('comanda.checkout.confirma');
        }
        return view('location.comandaCheckout', get_defined_vars());
    }

    public function give_up()
    {
        $comanda = Comanda::with('table', 'products.product')->where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();
        OrderFlow::where('key', 'comanda')->where('key_id', $comanda->id)->where('status', 0)->update(['status' => 2]);
        ComandaProduct::where('comanda_id', $comanda->id)->delete();
        Comanda::find($comanda->id)->update(['status' => 3]);
    }
}
