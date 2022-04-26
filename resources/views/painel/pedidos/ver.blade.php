@extends('layouts.app')


@section('content')


    <div class="container">
        <div class="text-center text-white">
            <h3>Endereço</h3>
        </div>
        <div class="text-white">
            <p>Rua: {{ $pedido->adress->endereco }}, {{ $pedido->adress->numero }}</p>
            <p>Bairro: {{ $pedido->adress->bairro }}</p>
            <p>Cidade: {{ $pedido->adress->cidade }}</p>
            <p>CEP: {{ $pedido->adress->cep }}</p>
        </div>
        <div class="text-center text-white">
            <h3>Entrega</h3>
        </div>
        <div class="text-white">
            @if ($pedido->ship->data == 'Agendar Pedido')
                <p>Data: {{ $pedido->ship->horario }}</p>
                <p>Horario: {{ $pedido->ship->data }}</p>
            @else
                <p>Data: {{ $pedido->ship->data }}</p>
            @endif

            <p>Tipo: {{ $pedido->ship->tipo }}</p>

            @if ($pedido->ship->tipo == 'Receber em Casa')
                <p>Valor de Entrega: R$ {{number_format($pedido->valor_frete, 2, ',', '.')}}</p>
                <p>Tempo de Entrega: {{$pedido->tempo_entrega}} dias</p>
            @endif

        </div>
        <div class="text-center text-white">
            <h3>Comprador</h3>
        </div>
        <div class="text-white">
            <p>Nome: {{ $pedido->users->name }}</p>
            <p>Email: {{ $pedido->users->email }}</p>
            <p>WhatsApp: {{ $pedido->users->whatsapp }}</p>
        </div>
        <div class="text-center text-white">
            <h3>Pedidos</h3>
        </div>
        <div class="text-white">
            @foreach ($items as $item)
                <div>
                    <p>Title: {{ $item->title }}</p>
                    <p>Preço: {{ 'R$ ' . number_format($item->unit_price, 2, ',', '.') }} </p>
                    <p>Quantidade: {{ $item->quantity }}</p>
                </div>
            @endforeach

        </div>
        <div class="text-center text-white">
            <h3>Pagamento</h3>
        </div>
        <div class="text-white">
            <p>Forma de Pagamento: {{ $pedido->pagamento }}</p>
            <p>Troco: {{ $pedido->troco ?  : ($pedido->troco ?? 'Sem troco')}} </p>
        </div>
        <div class="text-center text-white">
            <h3>Status</h3>
        </div>
        <form action="{{ url('painel/pedidos/status/'. $pedido->id) }}" method="POST">
        <div class="row">
                @csrf
                <div class="form-group col-md-6">
                    <select class="form-control" name="status" id="exampleFormControlSelect1">
                        <option value="1" @if($pedido->status == '1') selected @endif>Preparando</option>
                        <option value="2" @if($pedido->status == '2') selected @endif>Liberado para Retirada</option>
                        <option value="3" @if($pedido->status == '3') selected @endif>Aguardando Entrega</option>
                        <option value="4" @if($pedido->status == '4') selected @endif>Saiu Para Entrega</option>
                        <option value="5" @if($pedido->status == '5') selected @endif>Entregue</option>
                        <option value="6" @if($pedido->status == '6') selected @endif>Cancelado</option>

                    </select>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-success">Atualizar</button>
                </div>
        </div>
    </form>
    </div>



@endsection
