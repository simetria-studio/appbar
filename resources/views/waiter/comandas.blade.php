@extends('layouts.waiter')

@section('content')
    <div class="container vh-100 d-flex flex-column">
        <div class="text-center mt-5">
            <img src="{{asset('assets/img/logo-simples.png')}}" alt="">
        </div>

        <form action="{{route('waiter.check_in')}}" method="post">
            @csrf
            <input type="hidden" name="leave_unity" value="true">
            <div class="mb-2 mt-3">
                <div class="row justify-content-center">
                    <div class="col-10 d-flex p-0">
                        <button type="submit" class="btn btn-block btn-c-location-c btn-c-orange">Trocar Unidade</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="my-3 linha-horizontal"></div>

        <div class="my-3">
            <div class="container table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <td>MESA</td>
                            <td>CLIENTE</td>
                            <td>PEDIDOS</td>
                            <td>AÇÕES</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comandas as $comanda)
                            @if ($comanda->waiter_status == '1' || $comanda->waiter_status == '2')
                                <tr>
                                    <td>{{$comanda->table->name}}</td>
                                    <td>
                                        {{explode(' ',$comanda->client->name)[0]}}
                                    </td>
                                    <td>
                                        @php
                                            $total_comanda_produto = 0;
                                            foreach($comanda->products as $product){
                                                if($product->status == 1) $total_comanda_produto += 1;
                                            }
                                        @endphp
                                        {{$total_comanda_produto}}
                                    </td>
                                    <td>
                                        @if ($comanda->status == 1)
                                            <a href="{{route('waiter.comanda.pedido', $comanda->id)}}" class="btn btn-sm btn-c-orange">{{empty($comanda->waiter_id) ? 'Aceitar' : 'Pedidos'}}</a>
                                        @else
                                            <a href="{{route('waiter.comanda.pedido', $comanda->id)}}" class="btn btn-sm {{$comanda->payment_method == 'dinheiro' ? 'btn-danger' : 'btn-success'}}">
                                                @if ($comanda->payment_method == 'dinheiro')
                                                    Dinheiro
                                                @else
                                                    Pago
                                                @endif
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.reload();
        }, 60000)
    </script>
@endsection