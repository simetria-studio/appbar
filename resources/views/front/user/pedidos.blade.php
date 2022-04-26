@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-3">
            <a href="{{route('home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">PEDIDOS</h2>
        </div>

        <div class="text-center mt-4 mb-4">
            <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
        </div>
    </div>
    @foreach ($pedidos as $pedido)
        <div class="pedido my-4">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center ">
                            <p>PEDIDO</p>
                        </div>
                        <div class="col-12 text-center font">
                            <p><strong>PEDIDO</strong> #00{{ $pedido->id }}</p>
                        </div>
                        <div class="col-12 text-center font">
                            <p><Strong>PAGAMENTO</strong> {{ $pedido->pagamento }}</p>
                        </div>
                        <div class="col-12 text-center font">
                            <p>
                                <strong>STATUS:</strong>
                                @if ($pedido->status == '0')
                                    Aguardando
                                @elseif($pedido->status == '1')
                                    Preparando
                                @elseif($pedido->status == '2')
                                    Saiu para entrega
                                @elseif($pedido->status == '3')
                                    Entregue
                                @elseif($pedido->status == '4')
                                    Cancelado
                                @endif
                            </p>
                        </div>

                    </div>
                    <div class="text-center">
                        <a href="{{ url('user/pedidos/ver/'. $pedido->id) }}" class="btn btn-dark text-white">DETALHES</a>
                    </div>
                </div>
        </div>

    @endforeach




@endsection
