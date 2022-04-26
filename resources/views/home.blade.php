@extends('layouts.main')
@section('content')
    <div class="container d-flex justify-content-center">
        <div class="w-75">
            <div class="text-center mt-5 mb-4">
                <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
            </div>
            <div class="mt-5">
                <div class="row btn-home">
                    <div class="col-12 text-center text-white my-2">
                        @php
                            $user_name = explode(' ', auth()->guard('cliente')->user()->name);
                        @endphp
                        <h5>OLÁ, {{mb_convert_case($user_name[0].(count($user_name) > 0 ? ' '.($user_name[(count($user_name) - 1)]) : ''), MB_CASE_UPPER)}}</h5>
                    </div>

                    <div class="col-6 col-app-home my-3"><a class="btn btn-c-orange px-3 py-2" href="{{route('shop')}}">COMPRAR ONLINE</a></div>
                    <div class="col-6 col-app-home my-3"><a class="btn btn-c-orange px-3 py-2" href="{{route('checkIn')}}">COMPRAR NO LOCAL</a></div>
                    {{-- <div class="col-6 col-app-home my-3"><a class="btn btn-c-orange px-3 py-2" href="{{route('cashback')}}">SEU CASHBACK</a></div> --}}
                    <div class="col-12 col-app-home my-3"><a class="btn btn-c-orange px-3 py-2" href="{{route('perfil')}}">SEUS DADOS</a></div>

                    <div class="col-12 text-center my-3">
                        <a class="btn btn-c-orange logout px-3 py-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">SAIR DO APP</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
