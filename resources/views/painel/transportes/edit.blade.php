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

<input type="hidden" class="transportes_json" value="{{json_encode($transportes)}}">

<div>
    <form method="POST" action="{{ url('/painel/transportadorEdit') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$transportes->id}}">
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
                <input type="text" class="form-control bairro_input d-none" value="{{$transportes->bairro}}" placeholder="Nome do bairro">
            </div>

            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="sellprice" name="valor_frete" value="{{number_format($transportes->valor_frete, 2, ',','.')}}" placeholder="Valor do transporte">
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control" name="tempo_entrega" value="{{$transportes->tempo_entrega}}" placeholder="Tempo de entrega">
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
@endsection