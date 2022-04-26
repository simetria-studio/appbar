@extends('layouts.main')

@section('content')
    <div class="container-fluid py-4 font top-header">
        <div class="container">
            <div class="text-center mt-1">
                <a href="{{url()->previous()}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
                <h2 class="ms-2 inline-block text-white">VOLTAR</h2>
            </div>

            @if ($pedido->status !== 5)
                @if ($pedido->ship->tipo == 'Receber em Casa')
                    <div class="text-center mt-2 mb-4">
                        <span>Estimativa de Entrega</span> <br>
                        <span>{{$pedido->tempo_entrega}} min</span>
                    </div>
                @endif
            @endif

            <div class="text-center my-4">
                <img src="{{asset('assets/img/group-18.png')}}" alt="">
            </div>

            @if ($pedido->status == 5)
                <div class="text-center mt-2 mb-4">
                    <span>ENTREGUE</span> <br>
                    <span>{{date('d/m/Y - H:i', strtotime($pedido->updated_at))}}</span>
                </div>
            @else
                @if ($pedido->ship->tipo == 'Receber em Casa')
                    <div class="row">
                        <div class="col-4 text-center">
                            <div class="pedido-step @if($pedido->status >= 1) active @endif"></div>
                            <div class="pedido-step-text">Preparando seu Pedido</div>
                        </div>
                        <div class="col-4">
                            <div class="pedido-step @if($pedido->status >= 3) active @endif"></div>
                            <div class="pedido-step-text">Aguardando Entregador</div>
                        </div>
                        <div class="col-4">
                            <div class="pedido-step @if($pedido->status >= 4) active @endif"></div>
                            <div class="pedido-step-text">Saiu para Entrega</div>
                        </div>
                    </div>
                @else
                    <div class="row justify-content-center">
                        <div class="col-4 text-center">
                            <div class="pedido-step @if($pedido->status >= 1) active @endif"></div>
                            <div class="pedido-step-text">Preparando seu Pedido</div>
                        </div>
                        <div class="col-4">
                            <div class="pedido-step @if($pedido->status >= 2) active @endif"></div>
                            <div class="pedido-step-text">Liberado para Retirada</div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <div class="container pre-visualizar-produto font">
        @php
            $valor_pedido = 0;
        @endphp
        @foreach ($items as $item)
            @php
                $valor_pedido += ($item->quantity * $item->unit_price);
            @endphp
            <div class="row">
                <div class="col-5 my-2">
                    <div class="fundo-branco">
                        <img src="{{asset('storage/produtos/'.$item->produto->image)}}" alt="">
                    </div>
                </div>
                <div class="title col-6 my-2">
                    <div class="nome mb-1">
                        <span>{{$item->produto->name}}</span>
                    </div>
                    <div class="unid mb-1">
                        <span>R$ {{ number_format($item->unit_price, 2, ',', '.') }} UNID</span>
                    </div>
                    <div class="preco d-flex mb-1">
                        <div class="me-2">{{$item->quantity}}</div>
                        x
                        <div class="ms-2">{{ 'R$ ' . number_format(($item->quantity * $item->unit_price), 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center line-product">
                <div></div>
            </div>
        @endforeach
    </div>

    <div class="container font my-5">
        <div class="row justify-content-center">
            @if ($pedido->status !== 2)
                <div class="col-10"><h3 class="title-orange">DETALHES DA ENTREGA</h3></div>

                <div class="col-10 col-md-6 sub-title-white">
                    <strong>Rua:</strong> {{ $pedido->adress->endereco }}, {{ $pedido->adress->numero }} <br>
                    <strong>Bairro:</strong> {{ $pedido->adress->bairro }}<br>
                    <strong>Cidade:</strong> {{ $pedido->adress->cidade }}<br>
                    <strong>CEP:</strong> {{ $pedido->adress->cep }}
                </div>

                <div class="col-10 mt-3"><h3 class="title-orange">TAXA DE ENTREGA</h3></div>
                <div class="col-10 col-md-6 sub-title-white">R$ {{number_format($pedido->valor_frete, 2, ',', '.')}}</div>
            @endif

            <div class="col-10 mt-3"><h3 class="title-orange">RESUMO</h3></div>
            <div class="col-10 col-md-6 sub-title-white">
                <div class="row">
                    <div class="col-6">Pedido</div>
                    <div class="col-6">R${{number_format($valor_pedido, 2, ',', '.')}}</div>
                    @if ($pedido->status !== 2)
                        <div class="col-6">Entrega</div>
                        <div class="col-6">R$ {{number_format($pedido->valor_frete, 2, ',', '.')}}</div>
                    @endif
                    <div class="col-6">Total</div>
                    <div class="col-6">R$ {{number_format((($pedido->valor_frete ?? 0) + $valor_pedido), 2, ',', '.')}}</div>
                    <div class="col-12">Forma de Pagamento</div>
                    <div class="col-12 title-orange">{{mb_convert_case($pedido->pagamento, MB_CASE_TITLE)}}</div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container">
        <div class="text-center pt-4">
            <h1>SEUS <br> PEDIDOS</h1>
        </div>
        <div class="text-center pt-4">
            <a href="{{route('user.pedidos')}}" class="btn btn-continuar">Voltar</a>
        </div>
    </div>

    <div class="pedido my-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center ">
                        <p>PEDIDO #{{str_pad($pedido->id, 3, '0', STR_PAD_LEFT)}}</p>
                    </div>

                    <div class="col-12 col-md-6 text-center font">
                        <h4>Endereço</h4>
                        <p><strong>Rua:</strong> {{ $pedido->adress->endereco }}, {{ $pedido->adress->numero }}</p>
                        <p><strong>Bairro:</strong> {{ $pedido->adress->bairro }}</p>
                        <p><strong>Cidade:</strong> {{ $pedido->adress->cidade }}</p>
                        <p><strong>CEP:</strong> {{ $pedido->adress->cep }}</p>
                    </div>

                    <div class="col-12 col-md-6 text-center font">
                        <h4>Entrega</h4>
                        @if ($pedido->ship->data == 'Agendar Pedido')
                            <p><strong>Data:</strong> {{ $pedido->ship->horario }}</p>
                            <p><strong>Data:
                                Data:</strong> {{ $pedido->ship->data }}</p>
                        @else
                            <p><strong>Data:</strong> {{ $pedido->ship->data }}</p>
                        @endif
            
                        <p>Tipo: {{ $pedido->ship->tipo }}</p>

                        @if ($pedido->ship->tipo = 'Receber em Casa')
                            <p>Valor do Frete: R$ {{number_format($pedido->valor_frete, 2, ',', '.')}}</p>
                            <p>Tempo d Entrega: {{$pedido->tempo_entrega}} minutos</p>
                        @endif
            
                    </div>

                    <div class="col-12 col-md-6 text-center font">
                        <h4>Comprador</h4>
                        <p><strong>Nome:</strong> {{ $pedido->users->name }}</p>
                        <p><strong>Email:</strong> {{ $pedido->users->email }}</p>
                        <p><strong>WhatsApp:</strong> {{ $pedido->users->whatsapp }}</p>
                    </div>

                    <div class="col-12 col-md-6 text-center font">
                        <h4>Pagamento</h4>
                        <p><strong>Forma de Pagamento:</strong> {{ $pedido->pagamento }}</p>
                        <p><strong>Troco:</strong> R${{ $pedido->troco ?? 'Cartão' }} </p>
                        <p>
                            <strong>STATUS:</strong>
                            @if ($pedido->status == '0')
                                Aguardando
                            @elseif($pedido->status == '1')
                                Preparando
                            @elseif($pedido->status == '2')
                                Saiu para entrega
                            @elseif($pedido->status == '3')
                                Entregue
                            @elseif($pedido->status == '4')
                                Cancelado
                            @endif
                        </p>
                    </div>

                    <div class="col-12 text-center font">
                        <h4>Pedidos</h4>
                        @foreach ($items as $item)
                            <div>
                                <p><strong>Title:</strong> {{ $item->title }}</p>
                                <p><strong>Preço:</strong> {{ 'R$ ' . number_format($item->unit_price, 2, ',', '.') }} </p>
                                <p><strong>Quantidade:</strong> {{ $item->quantity }}</p>
                            </div>
                        @endforeach
            
                    </div>
                </div>
            </div>
    </div> --}}
@endsection
