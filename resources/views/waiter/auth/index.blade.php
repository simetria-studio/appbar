@extends('layouts.waiter')
@section('content')
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="w-75">
            <div class="text-center mb-4">
                <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
            </div>
            <div class="mt-5">
                <form id="form-login" action="{{ route('waiter.login') }}" method="POST">
                    @csrf
                    <div class="formulario">
                        <div class="inputs">
                            <input name="user" type="text" placeholder="USUARIO">
                        </div>
                        <div class="inputs mt-3">
                            <input name="password" type="password" placeholder="SENHA">
                        </div>
                        {{-- <div class="checkbox mt-3">
                            <input name="remember" type="checkbox">
                            <label for="remember">LEMBRAR ACESSO</label>
                        </div> --}}

                        <div class="d-flex mt-3">
                            <button type="button" id="btn-login" class="btn btn-block btn-c-orange">ENTRAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
