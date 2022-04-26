<?php

namespace App\Http\Controllers\Location;

use App\Models\Unity;
use App\Models\Table;
use App\Models\Product;
use App\Models\Comanda;
use App\Models\ComandaProduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Inicio do check-in
    public function checkIn()
    {
        $comanda = Comanda::where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->get();
        if($comanda->count() > 0) return redirect()->route('mesa.home');
        session()->forget('comanda_aceita');

        $unities = Unity::all();
        return view('location.checkIn', get_defined_vars());
    }

    public function mesa($unidade)
    {
        $tables = Table::where('unity_id', $unidade)->get();
        return view('location.mesa', get_defined_vars());
    }

    public function gerarComanda(Request $request)
    {
        Comanda::create([
            'client_id' => auth()->guard('cliente')->user()->id,
            'table_code' => $request->mesa,
        ]);

        return response()->json('success', 200);
    }
    // FIm do check-in

    // Escolha dos catalogos e produtos
    public function mesaHome()
    {
        $comanda = Comanda::where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();
        if(empty($comanda)) return redirect()->route('home');

        $table = Table::where('code', $comanda->table_code)->first();
        return view('location.mesaHome', get_defined_vars());
    }

    public function catalogo($slug)
    {
        $products = Product::where('categoria', str_replace('s','', $slug))->where('stock', '>', 0)->where('location', 1)->get();
        return view('location.catalogo', get_defined_vars());
    }

    public function produto($slug)
    {
        $product = Product::where('slug', $slug)->where('stock', '>', 0)->where('location', 1)->first();
        if(empty($product)) return redirect()->route('mesa.home');

        return view('location.produto', get_defined_vars());
    }
    // Fim dos catalogos e produtos

    // Adição de produtos a comanda
    public function addProduto(Request $request)
    {
        $comanda = Comanda::where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();

        $comandaProduct['comanda_id'] = $comanda->id;
        $comandaProduct['product_id'] = $request->id;
        $comandaProduct['quantity'] = $request->quantity;
        $comandaProduct['total_value'] = ($request->quantity * $request->price);
        ComandaProduct::create($comandaProduct);

        $new_value = ($comanda->total_value + $comandaProduct['total_value']);
        Comanda::find($comanda->id)->update(['total_value' => $new_value]);

        return redirect()->route('mesa.home')->with('success', 'Produto adicionado a sua comanda!');
    }

    public function removeProduto($id)
    {
        $comanda = Comanda::where('client_id', auth()->guard('cliente')->user()->id)->where('status', 1)->first();

        $comandaProduct = ComandaProduct::find($id);

        $new_value = ($comanda->total_value - $comandaProduct->total_value);

        Comanda::find($comanda->id)->update(['total_value' => $new_value]);

        $comandaProduct->delete();

        return redirect()->back()->with('success', 'Produto removido da comanda');
    }
}
