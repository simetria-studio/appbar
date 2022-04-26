@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">MESA</h2>
        </div>

        <div class="mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    <h3>SELECIONE SUA MESA</h3>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="row justify-content-center">
                <div class="col-10">
                    <select id="mesa" class="form-control select-custom select-custom-mesa">
                        <option value="">Mesa</option>
                        @foreach ($tables as $table)
                            <option value="{{$table->code}}" data-dados="{{$table}}">{{$table->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-5 btn-avancar d-none">
            <div class="row justify-content-center">
                <div class="col-10 d-flex p-0">
                    <button type="button" class="btn btn-block btn-c-location-c btn-c-orange" data-routes="{{json_encode(['home' => route('mesa.home'), 'pedido' => route('gerarComanda')])}}" id="btnAvancar">AVANÇAR</button>
                </div>
            </div>
        </div>
    </div>
@endsection
