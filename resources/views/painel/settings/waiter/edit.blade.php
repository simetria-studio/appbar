@extends('layouts.app')

@section('content')
<form method="POST" class="edit-form" action="{{ route('setting.waiter.update', $waiter->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center">
        <div class="form-group col-12 col-md-6">
            <input type="text" class="form-control" name="name" value="{{$waiter->name}}" placeholder="Nome Completo">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="form-group col-12 col-md-6">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{$waiter->email}}">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="form-group col-12 col-md-6">
            <input type="text" class="form-control" name="user" placeholder="Usuario de login" value="{{$waiter->user}}">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="form-group col-12 col-md-6">
            <input type="password" class="form-control" name="password" placeholder="Senha">
        </div>
    </div>

    <div class="row mt-3 justify-content-center">
        <div class="col-6 col-md-4">
                <button type="submit" class="btn btn-orange">Alterar Registro</button>
        </div>
        <div class="col-6 col-md-4">
                <a href="{{ route('setting.waiter') }}"><button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Fechar e Não Salvar</button></a>
        </div>
    </div>
</form>
@endsection
