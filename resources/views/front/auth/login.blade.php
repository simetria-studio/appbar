@extends('layouts.main')
@section('content')
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="w-75">
            <div class="text-center mb-4">
                <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
            </div>
            <div class="mt-5">
                <form id="form-login" action="{{ route('store.login') }}" method="POST">
                    @csrf
                    <div class="formulario">
                        <div class="inputs">
                            <input name="cpf" type="text" placeholder="CPF">
                        </div>
                        <div class="inputs mt-3">
                            <input name="password" type="password" placeholder="SENHA">
                        </div>
                        <div class="checkbox mt-3">
                            <input name="remember" type="checkbox">
                            <label for="remember">LEMBRAR ACESSO</label>
                        </div>

                        <div class="d-flex mt-3">
                            <button type="button" id="btn-login" class="btn btn-block btn-c-orange">ENTRAR</button>
                        </div>
                        <div class="text-center text-white mt-5">
                            NÃO POSSUI CADASTRO? <br>
                            <h4><a class="text-orange" href="{{ route('store.register') }}"> CLIQUE AQUI </a></h4>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
