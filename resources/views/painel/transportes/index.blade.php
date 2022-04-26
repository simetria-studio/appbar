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

<div class="my-4 float-right">
    <button data-toggle="modal" data-target="#addTransportes" class="btn btn-add"><i class="fas fa-plus"></i>Adicionar</button>
</div>

<div>
    <table class="table table-dark">
            <thead>
                <tr class="table-th">
                        <th>Nº</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Bairro</th>
                        <th scope="col">Valor de Entrega</th>
                        <th scope="col">Tempo de Entrega</th>
                        <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transportes as $transporte)
                    <tr class="table-tr">
                            <th>{{ $transporte->id }}</th>
                            <td>{{ $transporte->estado }}</td>
                            <td>{{ $transporte->cidade }}</td>
                            <td>{{ $transporte->bairro }}</td>
                            <td>{{  'R$ '.number_format($transporte->valor_frete, 2, ',', '.') }}</td>
                            <td>{{ $transporte->tempo_entrega }}</td>
                            <td>
                                <div class="icons d-flex justify-content-around">
                                    <a href="{{ url('/painel/transportes-id/'. $transporte->id) }}">
                                        <div class="edit">
                                                <i class="far fa-edit"></i>
                                        </div>
                                    </a>
                                    <a onclick="deleteItem(this)" data-id="{{ $transporte->id }}">
                                        <div class="trash">
                                                <i class="far fa-trash-alt"></i>
                                        </div>
                                    </a>
                                </div>
                            </td>
                    </tr>
                @endforeach
            </tbody>
    </table>
</div>
<style>
    .modal-backdrop.show{
    display: none !important;
}
</style>
{{-- modal --}}
<div class="modal " id="addTransportes" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addTransportesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransportesLabel">Adicionar Transportes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('/painel/cadastrarTransporte') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <select class="form-control" name="estado">
                                <option value="">- Selecione um Estado -</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control" name="cidade">
                                <option value="">- Selecione uma Cidade -</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control bairro_select" name="bairro">
                                <option value="">- Selecione um Bairro -</option>
                            </select>
                            <input type="text" class="form-control bairro_input d-none" placeholder="Nome do bairro">
                        </div>

                        <div class="form-group col-md-3">
                            <input type="text" class="form-control" id="sellprice" name="valor_frete" placeholder="Valor do transporte">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control" name="tempo_entrega" placeholder="Tempo de entrega">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-orange">Cadastrar Transporte</button>
                        </div>
                        <div class="col-md-6">
                                <button type="button" data-dismiss="modal" aria-label="Close"
                                    class="btn btn-orange">Fechar e Não Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    function deleteItem(e) {
        let id = e.getAttribute('data-id');
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
                        url: '{{url('painel/transportadorDelete')}}/' + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (data) {
                            if (data.success) {
                                swalWithBootstrapButtons.fire(
                                    'Deletado!',
                                    'Tranporte foi deletado!',
                                    "success"
                                );
                            }
                        }
                    });
                }
                location.reload();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Transportadora está seguro!)',
                    'error'
                );
            }
        });
    }
</script>
@endsection
