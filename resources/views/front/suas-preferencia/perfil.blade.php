@extends('layouts.main')
@section('content')
    <div class="container perfil">
        <div class="text-center mt-4">
            <a href="{{route('home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">SEUS DADOS</h2>
        </div>

        <div class="mt-3 mb-5">
            <div class="row">
                <div class="col-12 avatar d-flex justify-content-center">
                    <div class="profile-photo btn-edit-img" @if (auth()->user()->profile_photo_path) style="background-image: url('{{asset('storage/profile_path/'.auth()->user()->profile_photo_path)}}');" @endif></div>
                </div>

                <div class="col-12 d-flex justify-content-center">
                    <div class="editar-foto">
                        <button class="btn btn-edit btn-edit-img">
                            <img src="{{ url('assets/img/edit.png') }}" alt="">
                        </button>
                    </div>
                    <input type="file" id="file-custom" data-route="{{route('perfil.photo.update')}}">
                </div>

                <div class="my-3 linha-horizontal"></div>

                <div class="d-flex my-3">
                    <a href="{{route('user.pedidos')}}" class="btn btn-block btn-c-orange">MEUS PEDIDOS</a>
                </div>

                <div class="my-3 linha-horizontal"></div>

                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-10">{{auth()->guard('cliente')->user()->name}}</div>
                        <div class="col-10">Email: {{auth()->guard('cliente')->user()->email}}</div>
                        <div class="col-10">CPF: {{auth()->guard('cliente')->user()->cpf}}</div>
                        <div class="col-10">WhatsApp: {{auth()->guard('cliente')->user()->whatsapp}}</div>
                        <div class="col-10 mt-3">
                            <a href="{{route('perfil.edit')}}" class="btn btn-edit d-flex justify-content-center">EDITAR <img src="{{ url('assets/img/edit.png') }}" alt=""></a>
                        </div>
                    </div>
                </div>

                <div class="my-3 linha-horizontal"></div>

                <div class="col-12 mb-5">
                    @if ($address)
                        <div class="row justify-content-center">
                            <div class="col-10">{{$address->endereco}}, {{$address->numero}} - {{$address->bairro}}</div>
                            <div class="col-10">{{$address->complemento}} {{$address->complemento && $address->ref ? ', ' : ''}} {{$address->ref}}</div>
                            <div class="col-10">{{$address->cidade}}/{{$address->estado}}</div>
                            <div class="col-10 mt-3">
                                <a href="{{route('address')}}" class="btn btn-edit d-flex justify-content-center">EDITAR <img src="{{ url('assets/img/edit.png') }}" alt=""></a>
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <div class="col-10 text-center"><h5>Você ainda não cadastrou um endereço</h5></div>
                            <div class="col-10 mt-3">
                                <a href="{{route('address')}}" class="btn btn-edit d-flex justify-content-center">EDITAR <img src="{{ url('assets/img/edit.png') }}" alt=""></a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
