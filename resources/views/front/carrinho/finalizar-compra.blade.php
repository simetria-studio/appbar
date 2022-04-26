@extends('layouts.main')
@section('content')
    <input type="hidden" class="transportes" value="{{$transporte}}">
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('shop')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">VOLTAR</h2>
        </div>

        <div class="text-center mt-3">
            <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
        </div>

        <div class="text-center pt-4">
            <h1>FINALIZAR <br> COMPRA</h1>
        </div>

        <div class="mt-3">
            <div class="row">
                <div class="col-12 avatar d-flex justify-content-center">
                    <div class="profile-photo btn-edit-img" @if (auth()->user()->profile_photo_path) style="background-image: url('{{asset('storage/profile_path/'.auth()->user()->profile_photo_path)}}');" @endif></div>
                </div>

                <div class="my-3 linha-horizontal"></div>

                <div class="col-12 perfil">
                    <div class="row justify-content-center">
                        <div class="col-10">{{auth()->guard('cliente')->user()->name}}</div>
                        <div class="col-10">Email: {{auth()->guard('cliente')->user()->email}}</div>
                        <div class="col-10">CPF: {{auth()->guard('cliente')->user()->cpf}}</div>
                        <div class="col-10">WhatsApp: {{auth()->guard('cliente')->user()->whatsapp}}</div>
                        <div class="col-12">
                            <div class="row justify-content-center">
                                <div class="col-5"></div>
                                <div class="col-5"></div>
                            </div>
                        </div>
                        <div class="col-10 mt-3">
                            <a href="{{route('perfil.edit')}}" class="btn btn-edit d-flex justify-content-center">EDITAR <img src="{{ url('assets/img/edit.png') }}" alt=""></a>
                        </div>
                    </div>
                </div>

                <div class="my-3 linha-horizontal"></div>

                <div class="col-12 mb-5 perfil">
                    @if ($address)
                        <div class="row justify-content-center">
                            <div class="col-2 d-flex flex-column justify-content-center"><div class="icon-img"><img src="{{ url('assets/img/gps.png') }}" alt=""></div></div>
                            <div class="col-8">
                                {{$address->endereco}}, {{$address->numero}} - {{$address->bairro}}
                                <br>
                                {{$address->complemento}} {{$address->complemento && $address->ref ? ', ' : ''}} {{$address->ref}}
                                {{$address->complemento || $address->ref ? '<br> ' : ''}}
                                {{$address->cidade}}/{{$address->estado}}
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row justify-content-center">
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="icon-img">
                                                    <img src="{{ url('assets/img/relogio.png') }}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <span>{{ $ship->data ?? 'Escolha a Data da Entrega' }}</span> <br>
                                                <span>{{ $ship->horario ?? ''}}</span> <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="icon-img">
                                                    <img src="{{ url('assets/img/moto.png') }}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-5 tipo_entrega">
                                                <span>{{ $ship->tipo ?? 'Retirar ou Entrega?' }}</span> <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-10 mt-3">
                                <a href="{{route('address')}}" class="btn btn-edit d-flex justify-content-center">EDITAR <img src="{{ url('assets/img/edit.png') }}" alt=""></a>
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <div class="col-10 text-center"><h5>Você ainda não cadastrou um endereço</h5></div>
                            <div class="col-10 mt-3">
                                <a href="{{route('address')}}" class="btn btn-edit d-flex justify-content-center">EDITAR <img src="{{ url('assets/img/edit.png') }}" alt=""></a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="my-3 linha-horizontal"></div>

                <div class="col-12 pre-visualizar-produto">
                    @foreach (\Cart::getContent() as $item)
                        <div class="row">
                            <div class="col-5 my-2">
                                <div class="fundo-branco">
                                    <img src="{{asset('storage/produtos/'.$item->attributes->image)}}" alt="">
                                </div>
                            </div>
                            <div class="title col-6 my-2">
                                <div class="nome mb-1">
                                    <span>{{$item->name}}</span>
                                </div>
                                <div class="unid mb-1">
                                    <span>{{$item->quantity}} UNID</span>
                                </div>
                                <div class="preco mb-1">
                                    <h2>{{ 'R$ ' . number_format($item->price, 2, ',', '.') }} </h2>
                                </div>
                                <div class="edit">
                                    <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-lixeira"><img src="{{ url('assets/img/lixeira.png') }}" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <div class="my-3 linha-horizontal"></div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- <div class="profile mt-3">
            <div class="row">
                @foreach (\Cart::getContent() as $item)
                    <div class="col-4 my-2 mt-3">
                        <div class="fundo-branco ">
                            <div class="text-center">
                                <div class="lata">
                                    <a href="#">
                                        <img style="width: 100%; object-fit: cover;"
                                            src="{{ url('storage/produtos/' . $item->attributes->image) }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="title col-6 my-2">
                        <div class="nome_">
                            <span>{{ $item->name }} <br> {{ $item->attributes->resume }}</span> <br>
                        </div>
                        <div class="unid">
                            <span>{{ $item->quantity }} UNID</span> <br>
                        </div>
                        <div class="preco">
                            <h2>{{ 'R$ ' . number_format($item->price, 2, ',', '.') }} </h2> <br>
                        </div>
                    </div>
                    <div class="d-block col-2">
                        <div class="edit">
                            <button class="btn btn-edit">
                                <img src="{{ url('assets/img/edit.png') }}" alt="">
                            </button>
                        </div>
                        <div class="edit mt-5">
                            <a href="{{ route('cart.remove', $item->id) }}"><button type="button"
                                    class="btn btn-lixeira"> <img src="{{ url('assets/img/lixeira.png') }}"
                                        alt=""></button></a>
                        </div>
                    </div>

                @endforeach
            </div>
            @isset ($ship->tipo)
                @if ($ship->tipo == 'Receber em Casa')
                    <div class="mt-3" id="linha-horizontal"></div>
                    <div class="row">
                        @if ($transporte)
                            <div class="col-6 my-2 mt-3">
                                <div class="spans text-center"><div class="nome"><span>Valor de Entrega</span></div></div>
                                <div class="spans text-center"><div class="email"><span>R$ {{number_format($transporte->valor_frete, 2, ',', '.')}}</span></div></div>
                            </div>
                            <div class="col-6 my-2 mt-3">
                                <div class="spans text-center"><div class="nome"><span>Tempo de Entrega</span></div></div>
                                <div class="spans text-center"><div class="email"><span>{{$transporte->tempo_entrega}} Minutos</span></div></div>
                            </div>
                        @else
                            <div class="col-12 my-2 mt-3">
                                <div class="spans d-flex justify-content-center"><div class="nome text-center"><span>Entrega Indisponivel Para o Endereço cadastrado.</span></div></div>
                            </div>
                        @endif
                    </div>
                @endif
            @endisset
            <div class="mt-3" id="linha-horizontal"></div>
        </div> --}}
        <div class="text-center mb-5 pb-5">
            <a href="{{ route('checkout.process') }}">  <button class="btn btn-c-location-c btn-c-orange btn-verificar">FECHAR PEDIDO</button></a>
        </div>
    </div>
@endsection
