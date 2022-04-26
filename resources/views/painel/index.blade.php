@extends('layouts.app')


@section('content')
      <div class="font-bungeo d-flex justify-content-around text-center">
            <div class="dia">
                  <p>Vendas por Dia</p>
                  <p>R$ {{number_format($valor_dia, 2, ',', '.')}}</p>
            </div>
            <div class="semana">
                  <p>Vendas da Semana</p>
                  <p>R$ {{number_format($valor_semana, 2, ',', '.')}}</p>
            </div>
            <div class="mes">
                  <p>Vendas do Mês</p>
                  <p>R$ {{number_format($valor_mes, 2, ',', '.')}}</p>
            </div>
            <div class="closed">
                  <p>Fechado</p>
            </div>
      </div>


@endsection
