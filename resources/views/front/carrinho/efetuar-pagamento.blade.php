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

        <div class="text-center pt-4">
            <h1>EFETUAR <br> PAGAMENTO</h1>
        </div>

        <form class="mt-5" id="form-checkout">
            <div class="my-3 linha-horizontal"></div>
            <div class="profile-check mt-5">
                <div class="row">
                    <div class="col-2">
                        <div class="icon-img"><img src="{{ url('assets/img/card.png') }}" alt=""></div>
                    </div>
                    <label class="check-in col-8" for="primeiro">Pagar com cartão
                        <input name="metodo" value="card" id="primeiro" type="radio">
                        <span class="check"></span>
                    </label>
                </div>
            </div>
            <div id="card" class="d-none">
                <div class="row my-4 justify-content-center">
                    <div class="form-group col-10">
                        <label class="text-white" for="">Numero do Cartão</label>

                        <input type="text" name="numero" id="numero" class="form-control req">
                    </div>
                    <div class="form-group col-10">
                        <label class="text-white" for="">Nome do Titular</label>
                        <input type="text" name="name" class="form-control req">
                    </div>
                    <div class="form-group col-3">
                        <label class="text-white" for="">Mês</label>
                        <select name="mes" class="form-control" id="">
                            @for ($i = 1; $i < 13; $i++)
                            <option value="{{str_pad($i, 2, '0', STR_PAD_LEFT)}}">{{str_pad($i, 2, '0', STR_PAD_LEFT)}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label class="text-white" for="">Ano</label>
                        <select name="ano" class="form-control" id="">
                            @for ($i = 0; $i < 11; $i++)
                                <option value="{{date('Y', strtotime('+ '.$i.'years'))}}">{{date('Y', strtotime('+ '.$i.'years'))}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label class="text-white" for="">CVV</label>
                        <input type="text" name="cvv" id="cvv" class="form-control req">
                    </div>

                </div>
            </div>

            <div class="my-3 linha-horizontal"></div>
            <div class="profile-check mt-5">
                <div class="row">
                    <div class="col-2">
                        <div class="icones-back">
                            <div class="text-center">
                                <div class="icon-img">
                                    <img src="{{ url('assets/img/dinheiro.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <label class="check-in col-8" for="segundo">Pagar com dinheiro
                        <input class="form-check-input" value="dinheiro" name="metodo" id="segundo" type="radio">
                        <span class="check"></span>
                    </label>
                </div>
            </div>
            <div id="money" class="container d-none">
                <div class="row justify-content-between my-4 mx-3">
                    <div class="form-group col-12 my-2">
                        <label class="text-white" for="">Troco Para:</label>
                        <input type="text" name="troco" id="dinheiro" value="{{number_format(($comanda->total_value ?? 0), 2, ',', '.') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="my-3 linha-horizontal"></div>
            <div class="profile-check mt-5">
                <div class="row">
                    <div class="col-2">
                        <div class="icones-back">
                            <div class="text-center">
                                <div class="icon-img">
                                    <img src="{{ url('assets/img/dinheiro.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <label class="check-in col-8" for="terceiro">Pagar com Pix
                        <input class="form-check-input" value="pix" name="metodo" id="terceiro" type="radio">
                        <span class="check"></span>
                    </label>
                </div>
            </div>

            <div class="my-3 linha-horizontal"></div>

            @foreach (\Cart::getContent() as $item)
                <div class="row mt-5 pre-visualizar-produto">
                    <div class="col-5 my-2">
                        <div class="fundo-branco">
                            <img src="{{ url('storage/produtos/' . $item->attributes->image) }}" alt="">
                        </div>
                    </div>
                    <div class="title col-6 my-2">
                        <div class="nome mb-1">
                            <span>{{ $item->name }} <br> {{ $item->attributes->resume }}</span>
                        </div>
                        <div class="unid mb-1">
                            <span>{{ $item->quantity }} UNID</span>
                        </div>
                        <div class="preco mb-1">
                            <h2>{{ 'R$ ' . number_format($item->price, 2, ',', '.') }} </h2>
                        </div>
                        <div class="edit">
                            <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-lixeira"><img src="{{ url('assets/img/lixeira.png') }}" alt=""></a>
                        </div>
                    </div>

                    <div class="my-3 linha-horizontal"></div>
                </div>
            @endforeach

            <div class="mt-5">
                @if ($transporte)
                    <div class="row">
                        <div class="col-6 my-2 mb-3">
                            <div class="spans text-center"><div class="nome"><span>Valor de Entrega</span></div></div>
                            <div class="spans text-center"><div class="email"><span>R$ {{number_format($transporte->valor_frete, 2, ',', '.')}}</span></div></div>
                        </div>
                        <div class="col-6 my-2 mb-3">
                            <div class="spans text-center"><div class="nome"><span>Tempo de Entrega</span></div></div>
                            <div class="spans text-center"><div class="email"><span>{{$transporte->tempo_entrega}} Minutos</span></div></div>
                        </div>
                    </div>
                    <div class="mt-3" id="linha-horizontal"></div>
                @endif
                <div class="d-flex mt-5 justify-content-center">
                    <div>
                        <div class="icones-back text-white text-center">
                            <h5>Total do Pedido: {{  'R$ '.number_format(Cart::getTotal(), 2, ',', '.') }}  </h5>

                            <h5>Total a Pagar: {{  'R$ '.number_format((Cart::getTotal()+($transporte->valor_frete ?? 0)), 2, ',', '.') }}  </h5>
                        </div>
                    </div>
                </div>
                <div class="mt-5" id="linha-horizontal"></div>
            </div>

            <div class="text-center my-5 pb-5">
                <button type="button" id="enviar" class="btn btn-c-orange btn-c-location-c">PAGAR E FINALIZAR</button>
            </div>
        <form>
    </div>

@endsection
