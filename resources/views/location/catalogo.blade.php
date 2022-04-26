@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('mesa.home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">{{mb_convert_case($slug, MB_CASE_UPPER)}}</h2>
        </div>

        <div class="my-3">
            <div class="row justify-content-center product-showcase">
                @foreach ($products as $product)
                    <div class="col-5 col-md-4 my-3 product d-flex flex-column align-items-center">
                        <div class=" mb-3 product-image">
                            <a href="{{ route('mesa.produto', $product->slug) }}">
                                <img src="{{ asset('storage/produtos/'.$product->image) }}" alt="">
                            </a>
                        </div>
                        <div class="caption text-center">
                            <span>{{ $product->name }}</span>
                        </div>
                        <div class="caption price mt-auto text-center text-orange">
                            <span>{{  'R$ '.number_format($product->sellprice, 2, ',', '.') }}  </span>
                        </div>
                        <div class="caption mt-auto">
                            <a href="{{ route('mesa.produto', $product->slug) }}">  <button class="btn btn-adicionar">Ver Mais</button></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="my-5">
            <div class="row justify-content-center">
                <div class="col-10 d-flex p-0">
                    <a href="{{route('comanda')}}" class="btn btn-block btn-c-location-c btn-c-orange">COMANDA</a>
                </div>
            </div>
        </div>
    </div>
@endsection
