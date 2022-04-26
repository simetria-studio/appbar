@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="logo-img mt-5">
            <img src="{{ url('assets/img/Camada x0020 2.png') }}" alt="">
        </div>
        <div class="sub-logo mt-4">
            <img src="{{ url('assets/img/Camada x0020 3.png') }}" alt="">
        </div>
        <div class="idade pt-5">
            <h1>informações atualizadas</h1>
        </div>
        <div class="mt-3">
            <div class="text-center">
                <a href="/inicio" class="btn btn-continuar">fechar</a>
            </div>
        </div>
    </div>
@endsection