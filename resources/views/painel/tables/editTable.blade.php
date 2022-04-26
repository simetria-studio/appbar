@extends('layouts.app')


@section('content')
<form method="POST" class="edit-form" action="{{ route('table.update', $table->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="form-group col-12 col-md-6">
            <input type="text" class="form-control" name="name" value="{{$table->name}}" placeholder="Nome da Mesa">
        </div>
        <div class="form-group col-12 col-md-6">
            <select name="unity_id" class="form-control">
                @forelse ($unities as $unity)
                    <option value="{{$unity->id}}" @if($unity->id == $table->unity_id) selected @endif>{{$unity->name}}</option>
                @empty
                    <option value="">Sem Unidade Cadastrada</option>
                @endforelse
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
                <button type="submit" class="btn btn-orange">Alterar Mesa</button>
        </div>
        <div class="col-md-6">
                <a href="{{ route('table') }}"><button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange">Fechar e Não Salvar</button></a>
        </div>
    </div>
</form>
@endsection
