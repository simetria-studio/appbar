@extends('layouts.app')


@section('content')
<form method="POST" class="edit-form" action="{{ route('table.update.unity', $unity->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="name" value="{{$unity->name}}" placeholder="Nome da Unidade">
        </div>
        <div class="form-group col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" name="zip_code" value="{{$unity->zip_code}}" placeholder="CEP">
                <div class="input-group-append">
                    <button type="button" class="btn btn-dark btn-search-cep"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="state" value="{{$unity->state}}" placeholder="Estado">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="city" value="{{$unity->city}}" placeholder="Cidade">
        </div>
        <div class="form-group col-md-6">
            <input type="text" class="form-control" name="address2" value="{{$unity->address2}}" placeholder="Bairro">
        </div>
        <div class="form-group col-md-9">
            <input type="text" class="form-control" name="address" value="{{$unity->address}}" placeholder="Endereço">
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control" name="number" value="{{$unity->number}}" placeholder="Nº">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
                <button type="submit" class="btn btn-orange">Alterar Unidade</button>
        </div>
        <div class="col-md-6">
                <a href="{{ route('table') }}"><button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Fechar e Não Salvar</button></a>
        </div>
    </div>
</form>
@endsection
