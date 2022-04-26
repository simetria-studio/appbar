@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('shop')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">VOLTAR</h2>
        </div>

        <div class="text-center mt-3">
            <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
        </div>

        <div class="idade pt-5">
            @if (isset($payment))
                @if($payment->payment_method == 'card')
                <h1>PEDIDO CONCLUÍDO COM SUCESSO</h1>
                @elseif($payment->payment_method == 'pix')
                    <img id="code" src="{{ $code }}" alt="">
                    <div class="mt-3">
                        <div class="text-center">
                            <button id="copia" class="btn btn-continuar">Copia e Cola</button>
                        </div>
                    </div>

                @endif
            @else
                <h1>PEDIDO CONCLUÍDO COM SUCESSO</h1>
            @endif
        </div>
        <div class="mt-3">
            <div class="text-center">
                <a href="{{ route('user.pedidos') }}" class="btn btn-continuar">ACOMPANHAR PEDIDO</a>
            </div>
        </div>
    </div>
@endsection
