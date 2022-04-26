@extends('layouts.waiter')
@section('content')
    <div class="container vh-100 d-flex flex-column">
        <div class="text-center mt-5">
            <a href="{{route('waiter.comanda')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">VOLTAR</h2>
        </div>

        <div class="mt-2">
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    <h5>CLIENTE: <span class="text-orange">{{mb_convert_case($comanda->client->name, MB_CASE_UPPER)}}</span></h5>
                </div>
                <div class="col-10 text-center">
                    <h5>MESA: <span class="text-orange">{{$comanda->table->name}}</span></h5>
                </div>

                @if ($comanda->status == 1)
                    <div class="col-10 gastos text-center mt-2">
                        <h5 class="">GASTOU ATÉ AGORA</h5>
                        <h5 class="text-orange">R$ {{number_format($comanda->total_value, 2, ',', '.')}}</h5>
                    </div>
                @else
                    @if ($comanda->payment_method == 'dinheiro')
                        <div class="col-10 gastos text-center mt-2">
                            <h5 class="">TOTAL A PAGAR: <span class="text-orange">R$ {{number_format($comanda->total_value, 2, ',', '.')}}</span></h5>
                            <h5 class="">TROCO: <span class="text-orange">R$ {{number_format(((float)$comanda->troco - $comanda->total_value), 2, ',', '.')}} (R$ {{number_format((float)$comanda->troco, 2, ',', '.')}})</span></h5>
                        </div>
                    @else
                        <div class="col-10 gastos text-center mt-2">
                            <h5 class="">TOTAL PAGO: <span class="text-orange">R$ {{number_format($comanda->total_value, 2, ',', '.')}}</span></h5>
                            <h5 class="">METODO: <span class="text-orange">@if($comanda->payment_method == 'card') CARTÃO @endif @if($comanda->payment_method == 'pix') PIX @endif</span></h5>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        @if ($comanda->status == 2)
            <div class="my-2">
                <div class="row justify-content-center">
                    <div class="col-10 d-flex p-0">
                        <a href="{{route('waiter.comanda.fechar', $comanda->id)}}" class="btn btn-block btn-c-location-c btn-c-red">FECHAR COMANDA</a>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if($comanda->status == 1) active @endif" id="notDelivered-tab" data-bs-toggle="tab" data-bs-target="#notDelivered" type="button" role="tab" aria-controls="notDelivered" aria-selected="true">NÃO ENTREGUE</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if($comanda->status == 2) active @endif" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered" type="button" role="tab" aria-controls="delivered" aria-selected="false">ENTREGUE</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="pre-visualizar-produto  tab-pane fade @if($comanda->status == 1) show active @endif" id="notDelivered" role="tabpanel" aria-labelledby="notDelivered-tab">
                    @foreach ($comanda->products as $product)
                        @if ($product->status == 1)
                            <div class="row comanda-produto" id="produto-{{$product->id}}">
                                <div class="col-5 my-2">
                                    <div class="fundo-branco">
                                        <img src="{{asset('storage/produtos/'.$product->product->image)}}" alt="">
                                    </div>
                                </div>
                                <div class="title col-6 my-2">
                                    <div class="nome mb-1">
                                        <span>{{$product->product->name}}</span>
                                    </div>
                                    <div class="unid mb-1">
                                        <span>{{$product->quantity}} UNID</span>
                                    </div>
                                    <div class="preco d-flex mb-1">
                                        <h2>{{ 'R$ ' . number_format($product->total_value, 2, ',', '.') }} </h2> <br>
                                    </div>
                                    <div class="stock">
                                        <span>ESTQ {{$product->product->stock}} </span> <br>
                                    </div>

                                    <div class="edit-custom">
                                        <button type="button" class="btn btn-entregue-comandaProduto text-white" data-id="{{$product->id}}" data-route="{{route('waiter.comanda.pedido.entregue')}}"><i class="fas fa-check-square text-size-2"></i></button>
                                    </div>
                                </div>

                                <div class="my-3 linha-horizontal"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="pre-visualizar-produto tab-pane fade @if($comanda->status == 2) show active @endif" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                    @foreach ($comanda->products as $product)
                        @if ($product->status == 2)
                            <div class="row comanda-produto" id="produto-{{$product->id}}">
                                <div class="col-5 my-2">
                                    <div class="fundo-branco">
                                        <img src="{{asset('storage/produtos/'.$product->product->image)}}" alt="">
                                    </div>
                                </div>
                                <div class="title col-6 my-2">
                                    <div class="nome mb-1">
                                        <span>{{$product->product->name}}</span>
                                    </div>
                                    <div class="unid mb-1">
                                        <span>{{$product->quantity}} UNID</span>
                                    </div>
                                    <div class="preco d-flex mb-1">
                                        <h2>{{ 'R$ ' . number_format($product->total_value, 2, ',', '.') }} </h2> <br>
                                    </div>
                                </div>
                                <div class="my-3 linha-horizontal"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
