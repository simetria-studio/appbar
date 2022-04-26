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

<div class="row my-4">
    <div class="col-6 col-md-5">
    </div>
    <div class="col-6 col-md-7 text-right">
        <button data-toggle="modal" data-target="#addUnity" class="btn btn-add"><i class="fas fa-plus"></i> Adicionar Unidade</button>
    </div>
</div>

<div>
    <table class="table table-dark">
        <thead>
                <tr class="table-th">
                    <th>Nome da Unidade</th>
                    <th>Endereço</th>
                    <th scope="col">Ações</th>
                </tr>
        </thead>
        <tbody>
            @foreach ($unities as $unity)
                <tr class="table-tr">
                    <th>{{ $unity->name }}</th>
                    <td>{{ $unity->address }}, Nº {{ $unity->number }} - {{$unity->city}}/{{$unity->state}}</td>
                    <td>
                        <div class="icons d-flex justify-content-around">
                            <a title="Editar" href="{{ route('table.edit.unity', $unity->id) }}" class="mx-1">
                                    <div class="edit">
                                        <i class="fas fa-edit"></i>
                                    </div>
                            </a>
                            <a title="Deletar" onclick="deleteItem(this)" data-route="{{route('table.delete.unity')}}" data-id="{{ $unity->id }}" class="mx-1">
                                    <div class="trash">
                                        <i class="fas fa-trash-alt"></i>
                                    </div>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="row my-4">
    <div class="col-6 col-md-5"></div>
    <div class="col-6 col-md-7 text-right">
        <button data-toggle="modal" data-target="#addTable" class="btn btn-add"><i class="fas fa-plus"></i> Adicionar Mesa</button>
    </div>
</div>

<div>
    <table class="table table-dark">
        <thead>
                <tr class="table-th">
                    <th>Codigo</th>
                    <th>Mesa</th>
                    <th>Unidade</th>
                    <th>QRCODE</th>
                    <th scope="col">Ações</th>
                </tr>
        </thead>
        <tbody>
            @foreach ($tables as $table)
                <tr class="table-tr">
                    <th>{{ $table->code }}</th>
                    <td>{{ $table->name }}</td>
                    <td>{{ $table->unity->name }}</td>
                    <td><button type="button" class="btn btn-orange">Gerar QrCode</button></td>
                    <td>
                        <div class="icons d-flex justify-content-around">
                            <a title="Editar" href="{{ route('table.edit', $table->id) }}" class="mx-1">
                                <div class="edit">
                                    <i class="fas fa-edit"></i>
                                </div>
                            </a>
                            <a title="Deletar" onclick="deleteItem(this)" data-route="{{route('table.delete')}}" data-id="{{ $table->id }}" class="mx-1">
                                <div class="trash">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script type="application/javascript">
    function deleteItem(e) {
        let id = e.getAttribute('data-id');
        let route = e.getAttribute('data-route');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Você tem certeza?',
            text: "Está deletando permanentemente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, delete!',
            cancelButtonText: 'Não, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: route+'/' + id,
                        data: {
                                "_token": "{{ csrf_token() }}",
                        },
                        success: function (data) {
                            if (data.success) {
                                swalWithBootstrapButtons.fire(
                                        'Deletado!',
                                        'item deletado com successo!',
                                        "success"
                                );

                                setTimeout(() => {location.reload();}, 1800);
                            }
                        }
                    });
                }
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'operação Cancelada',
                    'Item não apagado',
                    'info'
                );
            }
        });
    }

</script>

@endsection

@section('modal')
    {{-- nova unidade --}}
    <div class="modal fade" id="addUnity" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addUnityLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="addUnityLabel">Adicionar Unidade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('table.store.unity') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="Nome da Unidade">
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="zip_code" placeholder="CEP">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-dark btn-search-cep"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="state" placeholder="Estado">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="city" placeholder="Cidade">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="address2" placeholder="Bairro">
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control" name="address" placeholder="Endereço">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" name="number" placeholder="Nº">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-orange">Cadastrar Unidade</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Não Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- nova mesa --}}
    <div class="modal fade" id="addTable" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addTableLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="addTableLabel">Adicionar Mesa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('table.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" name="name" placeholder="Nome da Mesa">
                                </div>
                                <div class="form-group col-md-12">
                                    <select name="unity_id" class="form-control">
                                        @forelse ($unities as $unity)
                                            <option value="{{$unity->id}}">{{$unity->name}}</option>
                                        @empty
                                            <option value="">Sem Unidade Cadastrada</option>
                                        @endforelse
                                    </select>
                                </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-orange">Cadastrar Mesa</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Não Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection