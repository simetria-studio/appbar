<?php

namespace App\Http\Controllers;

use App\Models\Captura;
use App\Models\Pedido;
use App\Models\Comanda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $dias = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $dia_da_semana = (date('N'));

        $dia_atual = date('Y-m-d');

        $semana_atual_inicial = date('Y-m-d', strtotime('-'.$dia_da_semana.' Days'));
        $semana_atual_final = date('Y-m-d', strtotime('+'.(6-$dia_da_semana).' Days'));

        $mes_atual_inicial = date('Y-m-d', strtotime(date('Y').'-'.date('m').'-01'));
        $mes_atual_final = date('Y-m-d', strtotime(date('Y').'-'.date('m').'-'.$dias));

        // Vendas do dia
        $valor_dia = 0;
        foreach(Pedido::whereIn('status', ['1','2','3','4','5'])->whereDate('created_at', $dia_atual)->get() as $venda_dia){
            foreach($venda_dia->pedidos as $pedido){
                $valor_dia += (float)($pedido->quantity * $pedido->unit_price);
            }
        }
        $valor_dia = number_format($valor_dia, 2, '.', ',');
        // Vendas da semana
        $valor_semana = 0;
        foreach(Pedido::whereIn('status', ['1','2','3','4','5'])->whereDate('created_at', '>=',$semana_atual_inicial)->whereDate('created_at', '<=', $semana_atual_final)->get() as $venda_semana){
            foreach($venda_semana->pedidos as $pedido){
                $valor_semana += (float)($pedido->quantity * $pedido->unit_price);
            }
        }
        $valor_semana = number_format($valor_semana, 2, '.', ',');
        // Vendas do mes
        $valor_mes = 0;
        foreach(Pedido::whereIn('status', ['1','2','3','4','5'])->whereDate('created_at', '>=',$mes_atual_inicial)->whereDate('created_at', '<=', $mes_atual_final)->get() as $venda_mes){
            foreach($venda_mes->pedidos as $pedido){
                $valor_mes += (float)($pedido->quantity * $pedido->unit_price);
            }
        }

        // Vendas do dia
        foreach(Comanda::whereIn('status', ['2','3'])->whereDate('created_at', $dia_atual)->get() as $venda_dia){
            $valor_dia += (float)$venda_dia->total_value;
        }
        // Vendas da semana
        foreach(Comanda::whereIn('status', ['2','3'])->whereDate('created_at', '>=',$semana_atual_inicial)->whereDate('created_at', '<=', $semana_atual_final)->get() as $venda_semana){
            $valor_semana += (float)$venda_semana->total_value;
        }
        // Vendas do mes
        foreach(Comanda::whereIn('status', ['2','3'])->whereDate('created_at', '>=',$mes_atual_inicial)->whereDate('created_at', '<=', $mes_atual_final)->get() as $venda_mes){
            $valor_mes += (float)$venda_mes->total_value;
        }

        return view('painel.index', get_defined_vars());
    }

    public function clientes()
    {
        $capturas =  Captura::orderBy('created_at', 'desc')->paginate(10);
        return view('painel.clientes', compact('capturas'));
    }
}
