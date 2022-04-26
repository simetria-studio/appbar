@extends('layouts.main')
@section('content')
    <div class="container vh-100 d-flex flex-column">
        <div class="text-center mt-5">
            <a href="{{route('mesa.home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">VOLTAR</h2>
        </div>

        <div class="mt-2">
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    @php
                        $cpf = auth()->guard('cliente')->user()->cpf;
                    @endphp
                    <h5>CPF: <span class="text-orange">{{substr($cpf, 0, 3)}}.{{substr($cpf, 3, 3)}}.{{substr($cpf, 6, 3)}}-{{substr($cpf, 9, 2)}}</span></h5>
                </div>
                <div class="col-10 text-center">
                    <h5>MESA: <span class="text-orange">{{$comanda->table->name}}</span></h5>
                </div>

                <div class="col-8 gastos text-center mt-2">
                    <h5 class="">GASTOU ATÉ AGORA</h5>
                    <h5 class="text-orange">R$ {{number_format($comanda->total_value, 2, ',', '.')}}</h5>
                </div>
            </div>
        </div>

        <div class="my-3 linha-horizontal"></div>

        <div class="my-3 pre-visualizar-produto">
            @foreach ($comanda->products as $product)
                @if ($product->status >= 1)
                    <div class="row">
                        <div class="col-5 my-2">
                            <div class="fundo-branco">
                                    <img src="{{asset('storage/produtos/'.$product->product->image)}}" alt="">
                            </div>
                        </div>
                        <div class="title col-7 my-2">
                            <div class="nome mb-1">
                                <span>{{$product->product->name}}</span>
                            </div>
                            <div class="unid mb-1">
                                <span>{{$product->quantity}} UNID</span>
                            </div>
                            <div class="preco">
                                <h2>{{ 'R$ ' . number_format($product->total_value, 2, ',', '.') }} </h2>
                            </div>
                        </div>

                        <div class="my-3 linha-horizontal"></div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-auto mb-3">
            <div class="row justify-content-center">
                <div class="col-10 d-flex p-0">
                    <a href="{{route('comanda.checkout')}}" class="btn btn-block btn-c-location-c btn-c-orange">PAGAR SUA COMANDA</a>
                </div>
            </div>
        </div>
    </div>
@endsection
