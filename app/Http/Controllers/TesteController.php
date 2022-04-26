<?php

namespace App\Http\Controllers;

use PagarMe\Client;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TesteController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('ship')->get();

        // dd(Hash::make('Sucesso@2021'));
    }
}
