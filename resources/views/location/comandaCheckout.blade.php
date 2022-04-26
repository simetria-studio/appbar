@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    <h3 class="text-orange">EFETUAR PAGAMENTO</h3>
                </div>
            </div>
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
        <form>

        <div class="mt-5">
            <div class="row justify-content-center">
                <div class="col-10 d-flex mt-4 p-0">
                    <button type="button" data-route="{{route('comanda.checkout.finalizar')}}" id="btnComandaCheckout" class="btn btn-block btn-c-location-c btn-c-orange">PAGAR E FINALIZAR</button>
                </div>
                <div class="col-10 d-flex mt-4 p-0">
                    <a href="{{route('mesa.home')}}" class="btn btn-block btn-c-location-c btn-c-white">VOLTAR</a>
                </div>
            </div>
        </div>
    </div>
@endsection
