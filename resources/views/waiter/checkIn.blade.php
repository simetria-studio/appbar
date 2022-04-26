@extends('layouts.waiter')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <img src="{{asset('assets/img/logo-simples.png')}}" alt="">
        </div>

        <div class="mt-3">
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    @php
                        $user_name = explode(' ', auth()->guard('waiter')->user()->name);
                    @endphp
                    <h3>OLÁ, {{mb_convert_case($user_name[0].(count($user_name) > 0 ? ' '.($user_name[(count($user_name) - 1)]) : ''), MB_CASE_UPPER)}}</h3>
                </div>
                <div class="col-10 mt-5 text-center">
                    <h3>INFORME A UNIDADE PARA COMEÇAR O ATENDIMENTO</h3>
                </div>
            </div>
        </div>

        <form action="{{route('waiter.check_in')}}" method="post">
            @csrf
            <div class="mt-3">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <select name="unity_id" class="form-control select-custom">
                            <option value="">Selecione uma Unidade</option>
                            @foreach ($unities as $unity)
                                <option value="{{$unity->id}}">{{$unity->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="mt-5 btn-check-in">
                <div class="row justify-content-center">
                    <div class="col-10 d-flex p-0">
                        <button type="submit" class="btn btn-block btn-c-location-c btn-c-orange">CHECK-IN</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
