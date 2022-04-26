@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('perfil')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">ALTERAR DADOS</h2>
        </div>

        <div class="mt-5 d-flex justify-content-center">
            <div class="w-75">
                <form  action="{{ route('perfil.update') }}" method="POST">
                    @csrf
                    <div class="formulario">
                        <div class="inputs mt-3">
                            <input type="text" name="name" value="{{auth()->guard('cliente')->user()->name}}">
                            @error('name')
                                <span class="invalid-feedbeck">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="inputs mt-3">
                            <input type="email" name="email" value="{{auth()->guard('cliente')->user()->email}}">
                            @error('email')
                                <span class="invalid-feedbeck">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="inputs mt-3">
                            <input type="text" id="whatsapp" name="whatsapp" value="{{auth()->guard('cliente')->user()->whatsapp}}">
                            @error('whatsapp')
                                <span class="invalid-feedbeck">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="inputs mt-3">
                            <input type="password" name="password" placeholder="Trocar Senha">
                            @error('password')
                                <span class="invalid-feedbeck">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="inputs mt-3">
                            <input type="password" name="password_confirmation" placeholder="Confirmar Senha">
                        </div>

                        <div class="d-flex mt-3">
                            <button type="submit" class="btn btn-block btn-c-orange">ATUALIZAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
