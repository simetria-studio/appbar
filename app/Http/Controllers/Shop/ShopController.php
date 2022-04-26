<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $produtos = Product::all();
        return view('front.home.inicio', get_defined_vars());
    }

    public function single($slug)
    {
        $product = Product::where('slug', $slug)->first();
        return view('front.produto-single.produto-single', get_defined_vars());
    }

    public function cervejas()
    {
        $produtos = Product::where('categoria', 'cerveja')->get();
        return view('front.produtos.cervejas.cervejas', get_defined_vars());
    }
    public function kits()
    {
        $produtos = Product::where('categoria', 'kit')->get();
        return view('front.produtos.kits.kits', get_defined_vars());
    }
    public function embutidos()
    {
        $produtos = Product::where('categoria', 'embutido')->get();
        return view('front.produtos.embutidos.embutidos', get_defined_vars());
    }
    public function search(Request $request)
    {
        $pesquisa = $request->search;

        $produtos = Product::where('name', 'like', '%' . $pesquisa . '%')->get();

        return view('front.home.pesquisa', get_defined_vars());
    }
}
