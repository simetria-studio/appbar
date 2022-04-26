@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">HOME</h2>
        </div>

        <div class="text-center mt-3 mb-4">
            <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
        </div>

        <div class="idade pt-5">
            @if($comanda_payment->payment_method == 'card')
            <h1>PEDIDO CONCLUÍDO COM SUCESSO</h1>
            @elseif($comanda_payment->payment_method == 'pix')
                <img id="code" src="{{ $code }}" alt="">
                <div class="mt-3">
                    <div class="text-center">
                        <button id="copia" class="btn btn-continuar">Copia e Cola</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.reload();
        }, 60000)
    </script>
@endsection
