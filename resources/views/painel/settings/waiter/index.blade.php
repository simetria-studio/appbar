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
        <button data-toggle="modal" data-target="#addWaiter" class="btn btn-add"><i class="fas fa-plus"></i> Adicionar Garçom</button>
    </div>
</div>

<div>
    <table class="table table-dark">
        <thead>
                <tr class="table-th">
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th scope="col">Ações</th>
                </tr>
        </thead>
        <tbody>
            @foreach ($waiters as $waiter)
                <tr @if(auth()->user()->id == $waiter->id) class="bg-warning text-dark" @endif class="table-tr">
                    <th>{{ $waiter->name }}</th>
                    <td>{{ $waiter->email }}</td>
                    <td>{{ $waiter->user }}</td>
                    <td>
                        <div class="icons d-flex justify-content-around">
                            <a title="Editar" href="{{ route('setting.waiter.edit', $waiter->id) }}" class="mx-1">
                                <div class="edit">
                                    <i class="fas fa-edit"></i>
                                </div>
                            </a>
                            <a title="Deletar" onclick="deleteItem(this)" data-route="{{route('setting.waiter.delete')}}" data-id="{{ $waiter->id }}" class="mx-1">
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
                            if (data == 'success') {
                                swalWithBootstrapButtons.fire(
                                    'Deletado!',
                                    'item deletado com successo!',
                                    "success"
                                );

                                setTimeout(() => {window.location.reload();}, 1800);
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
    <div class="modal fade" id="addWaiter" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addWaiterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWaiterLabel">Registrar Novo Garçom</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('setting.waiter.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="form-group col-md-10">
                                <input type="text" class="form-control" name="name" placeholder="Nome Completo">
                            </div>
                            <div class="form-group col-md-10">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="form-group col-md-10">
                                <input type="text" class="form-control" name="user" placeholder="Usuario de login">
                            </div>
                            <div class="form-group col-md-10">
                                <input type="password" class="form-control" name="password" placeholder="Senha">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-orange">Cadastrar Admin</button>
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