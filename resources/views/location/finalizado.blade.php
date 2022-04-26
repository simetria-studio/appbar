@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">HOME</h2>
        </div>

        <div class="text-center mt-3 mb-4">
            <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
        </div>

        <div class="mt-3">
            <div class="row justify-content-center">
                <div class="col-10 text-center text-orange">
                    <h2 class="text-size-2">CLIENTE LIBERADO</h2>
                </div>
                <div class="col-10 text-center">
                    @php
                        $user_name = explode(' ', auth()->guard('cliente')->user()->name);
                    @endphp
                    <h5>{{mb_convert_case($user_name[0], MB_CASE_UPPER)}}, VOCÊ É INCRIVEL, OBRIGADOPELA SUA VISITA!</h5>
                </div>

                <div class="col-10 text-center">
                    <h5>VOLTE SEMPRE!</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
