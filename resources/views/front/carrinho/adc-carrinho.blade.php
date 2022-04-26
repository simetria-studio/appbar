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
            <h2 class="text-size-2">ITEM ADICIONADO</h2>
        </div>
        <div class="mt-3">
            <div class="text-center">
                <a  href="{{ route('shop') }}" class="btn btn-c-location-c btn-c-orange">CONTINUAR COMPRANDO</a>
            </div>
        </div>
        <div class="mt-3 mb-5">
            <div class="text-center">
                <a href="{{ route('pre.checkout') }}" class="btn btn-c-location-c btn-c-orange">FINALIZAR COMPRA</a>
            </div>
        </div>
    </div>
@endsection
