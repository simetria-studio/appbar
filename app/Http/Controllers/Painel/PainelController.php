<?php

namespace App\Http\Controllers\Painel;

use App\Models\Item;
use App\Models\Pedido;
use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Bairro;
use App\Models\Transporte;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PainelController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('users', 'adress')->orderBy('created_at', 'desc')->paginate(15);

        return view('painel.pedidos.index', compact('pedidos'));
    }

    public function ver($id)
    {
        $items = Item::where('pedido_id', $id)->get();
        $pedido = Pedido::with('users', 'adress', 'ship')->find($id);
        return view('painel.pedidos.ver', compact('pedido', 'items'));
    }

    public function status(Request $request, $id)
    {
        $status = Pedido::find($id);
        $status->status = $request->status;
        $status->save();
        return redirect()->back();
    }

    public function transportes()
    {
        $transportes = Transporte::paginate(15);
        return view('painel.transportes.index', compact('transportes'));
    }
    public function transportesId($id)
    {
        $transportes = Transporte::find($id);
        return view('painel.transportes.edit', compact('transportes'));
    }

    public function buscaEstado()
    {
        $estados = Estado::get();
        return response()->json($estados);
    }
    public function buscaCidade($id)
    {
        $cidades = Cidade::where('localidade_estado_id', $id)->get();
        return response()->json($cidades);
    }
    public function buscaBairro($id)
    {
        $bairros = Bairro::where('localidade_municipio_id', $id)->get();
        return response()->json($bairros);
    }

    public function cadastrarTransporte(Request $request)
    {
        Transporte::create([
            'estado' => $request->estado,
            'cidade' => $request->cidade,
            'bairro' => $request->bairro,
            'valor_frete' => str_replace(['.',','],['','.'], $request->valor_frete),
            'tempo_entrega' => $request->tempo_entrega,
        ]);

        return redirect('/painel/transportes')->with('success', 'Transporte cadastrado com sucesso');
    }

    public function transportadorEdit(Request $request)
    {
        Transporte::find($request->id)->update([
            'estado' => $request->estado,
            'cidade' => $request->cidade,
            'bairro' => $request->bairro,
            'valor_frete' => str_replace(['.',','],['','.'], $request->valor_frete),
            'tempo_entrega' => $request->tempo_entrega,
        ]);

        return redirect('/painel/transportes')->with('success', 'Transporte atualizado com sucesso');
    }

    public function transportadorDelete(Request $request, $id)
    {
        if ($request->ajax()) {

            $transportes = Transporte::findOrFail($id);

            if ($transportes) {

                $transportes->delete();

                return response()->json(array('success' => true));
            }
        }
    }
}
