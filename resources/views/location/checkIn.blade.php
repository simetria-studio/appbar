@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">CHECK-IN</h2>
        </div>

        <div class="mt-3">
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    @php
                        $user_name = explode(' ', auth()->guard('cliente')->user()->name);
                    @endphp
                    <h3>OLÁ, {{mb_convert_case($user_name[0].(count($user_name) > 0 ? ' '.($user_name[(count($user_name) - 1)]) : ''), MB_CASE_UPPER)}}</h3>
                </div>
                <div class="col-10 text-center">
                    <h3>CPF: <span class="text-orange">{{auth()->guard('cliente')->user()->cpf}}</span></h3>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="row justify-content-center">
                <div class="col-10">
                    <select id="unidade" class="form-control select-custom">
                        <option value="">Selecione uma Unidade</option>
                        @foreach ($unities as $unity)
                            <option value="{{$unity->id}}" data-dados="{{$unity}}">{{$unity->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="row justify-content-center" id="unidade-info"></div>
        </div>

        <div class="mt-5 btn-check-in d-none">
            <div class="row justify-content-center">
                <div class="col-10 d-flex p-0">
                    <button type="button" class="btn btn-block btn-c-location-c btn-c-orange" data-route="{{route('mesa')}}" id="btnCheckIn">CHECK-IN</button>
                </div>
            </div>
        </div>
    </div>
@endsection
