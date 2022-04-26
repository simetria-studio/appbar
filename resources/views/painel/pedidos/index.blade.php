
@extends('layouts.app')


@section('content')

@if ($errors->any())
      <div class="alert alert-danger">
            <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
            </ul>
      </div>
      @endif


<div>

      <table class="table table-dark">
            <thead>
                  <tr class="table-th">
                        <th>ID</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Pagamento</th>
                        <th scope="col">Endereço</th>

                        <th scope="col">Ações</th>
                  </tr>
            </thead>
            <tbody>
                  @foreach ($pedidos as $pedido)
                  <tr class="table-tr">
                        <th>{{ $pedido->id }}</th>
                        <td>{{ $pedido->users->name ?? ''}}</td>
                        <td>{{ $pedido->pagamento }}</td>
                        <td>{{ $pedido->adress->endereco }}, {{ $pedido->adress->numero }}</td>

                        <td>
                              <div class="icons d-flex justify-content-around">
                                    <a href="{{ url('painel/pedidos/ver/'. $pedido->id) }}">
                                          <div class="edit">
                                                <i class="far fa-edit"></i>
                                          </div>
                                    </a>
                                    {{-- <a onclick="deleteItem(this)" data-id="{{ $pedido->id }}">
                                          <div class="trash">
                                                <i class="far fa-trash-alt"></i>
                                          </div>
                                    </a> --}}
                                    <div class="block">
                                          <i class="fas fa-ban"></i>
                                    </div>
                              </div>
                        </td>
                  </tr>
                  @endforeach
            </tbody>
      </table>

      {{$pedidos->links()}}
</div>


@endsection
