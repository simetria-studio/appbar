@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('shop')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">KITS</h2>
        </div>

        <div class="text-center mt-3">
            <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
        </div>

        <div class="mt-5">
            <div class="row catalogo-location justify-content-center">
                <div class="col-3 d-flex flex-column align-items-center">
                    <div class="beer">
                        <a href="{{ route('shop.cervejas') }}">
                            <img src="{{ asset('assets/img/beer 1.png') }}" alt="merg">
                        </a>
                    </div>
                    <p class="pt-2 text-orange">Cervejas</p>
                </div>
                <div class="col-3 d-flex flex-column align-items-center">
                    <div class="beer">
                        <a href="{{ route('shop.kits') }}">
                            <img src="{{ asset('assets/img/beer-box 1.png') }}" alt="">
                        </a>
                    </div>
                    <p class="pt-2 text-orange">Kits</p>
                </div>
                <div class="col-3 d-flex flex-column align-items-center">
                    <div class="beer">
                        <a href="{{ route('shop.embutidos') }}">
                            <img src="{{ asset('assets/img/sausage 1.png') }}" alt="">
                        </a>
                    </div>
                    <p class="pt-2 text-orange">embutidos</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-american-ipa_">American IPA</button>
            <button class="btn btn-american-ibv">IBV 7% </button>
        </div>

        <div class="my-3">
            <div class="row justify-content-center product-showcase">
                @foreach ($produtos as $product)
                    <div class="col-5 col-md-4 my-3 product d-flex flex-column align-items-center">
                        <div class=" mb-3 product-image">
                            <a href="{{ route('shop.single', $product->slug) }}">
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
                            <a href="{{ route('shop.single', $product->slug) }}">  <button class="btn btn-adicionar">Ver Mais</button></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
