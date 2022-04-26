@extends('layouts.app')

@section('content')
<form method="POST" class="edit-form" action="{{ route('setting.admin.update', $admin->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center">
        <div class="form-group col-12 col-md-6">
            <input type="text" class="form-control" name="name" value="{{$admin->name}}" placeholder="Nome Completo">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="form-group col-12 col-md-6">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{$admin->email}}">
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
                <a href="{{ route('setting.admin') }}"><button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Fechar e Não Salvar</button></a>
        </div>
    </div>
</form>
@endsection
