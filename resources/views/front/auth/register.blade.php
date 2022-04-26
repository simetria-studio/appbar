@extends('layouts.main')
@section('content')
    <div class="container d-flex justify-content-center">
        <div class="w-75">
            <div class="text-center mt-5 mb-4">
                <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
            </div>
            <div class="mt-5">
                <form id="form-login" action="{{ route('store.register') }}" method="POST">
                    @csrf
                    <div class="formulario">
                        <div class="inputs mt-3">
                            <input type="text" name="name" placeholder="Seu Nome Completo">
                        </div>
                        <div class="inputs mt-3">
                            <input type="email" name="email" placeholder="Email Para Contato">
                        </div>
                        <div class="inputs mt-3">
                            <input name="cpf" class="cpf" type="text" placeholder="CPF">
                        </div>
                        <div class="inputs mt-3">
                            <input type="text" id="whatsapp" name="whatsapp" placeholder="Numero de Celular">
                        </div>
                        <div class="inputs mt-3">
                            <input type="password" name="password" placeholder="Senha">
                        </div>
                        <div class="inputs mt-3">
                            <input type="password" name="password_confirmation" placeholder="Confirmar Senha">
                        </div>

                        <div class="checkbox-terms mt-3">
                            <input name="terms" type="checkbox">
                            <div class="mx-2"><a target="_blank" href="#">ACEITO OS TERMOS E CONDIÇÕES</a></div>
                        </div>

                        <div class="d-flex mt-3">
                            <button type="button" id="btn-login" class="btn btn-block btn-c-orange">CADASTRAR</button>
                        </div>
                        <div class="text-center text-white mt-5">
                            JÁ POSSUI CADASTRO? <br>
                            <h4><a class="text-orange" href="{{ route('store.login') }}"> CLIQUE AQUI </a></h4>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
