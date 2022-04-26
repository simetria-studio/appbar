@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{url()->previous()}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">VOLTAR</h2>
        </div>

        <div class="my-3">
            <div class="row justify-content-center">
                <div class="row justify-content-center single">
                    <div class="col-6">
                        <div class="row descriptions">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="lupulo">
                                    <img src="{{ asset('assets/img/hop 1.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-12 text-center my-2">
                                <span class="amargor">ibu <br> (amargor)</span>
                                <span>{{ $product->bitterness }}</span>
                            </div>

                            <div class="col-12 d-flex justify-content-center">
                                <div class="lupulo">
                                    <img src="{{ asset('assets/img/hop 1.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-12 text-center my-2">
                                <span class="amargor">ABV <br> (TEOR ALCOÓLICO)</span>
                                <span>{{ $product->ibv }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="product col-6">
                        <img src="{{ asset('storage/produtos/' . $product->image) }}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="my-3">
            <div class="row justify-content-center">
                <div class="col-10 text-center text-orange">
                    <h1>{{ $product->name }} <br> {{ $product->resume }}</h1>
                </div>
                <div class="col-10 text-center mt-3">
                    <button class="btn btn-american-ipa">{{ $product->type }}</button>
                </div>

                <div class="col-10 desc text-center mt-5 font">
                    <p>Descrição</p>
                    <p>{!! $product->description !!}</p>
                </div>

                <div class="col-10">
                    <form action="{{route('mesa.produto.add')}}" method="post">
                        @csrf
                        <div class="preco-add">
                            <div class="text-center mt-5">
                                <h2 class="text-orange text-size-1">PREÇO/UNIT</h2>
                                <h2 class="text-size-2 text-orange">R$32,00</h2>
                            </div>
                            <div class="text-center btns-add-qty">
                                <div class="input-group">
                                    <div class="input-group-prepend"><button type="button" class="btn btn-qty" data-method="minus" data-target=".qty">-</button></div>
                                    <input class="text-center form-control qty" min="1" name="quantity" value="0" type="number">
                                    <div class="input-group-append"><button type="button" class="btn btn-qty" data-method="plus" data-target=".qty">+</button></div>
                                </div>
                            </div>
                            <div class="multiplicadores mt-3 d-flex">
                                <div>
                                    <button type="button" class="btn btn-qty" data-method="plus" data-qty="6" data-target=".qty">+ 06 <span>unid</span></button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-qty" data-method="plus" data-qty="12" data-target=".qty">+ 12 <span>unid</span></button>
                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->sellprice }}">
                                <input type="hidden" name="image" value="{{ $product->image }}">
                                <input type="hidden" name="bitterness" value="{{ $product->bitterness }}">
                                <input type="hidden" name="ibv" value="{{ $product->ibv }}">
                                <input type="hidden" name="type" value="{{ $product->type }}">
                                <input type="hidden" name="resume" value="{{ $product->resume }}">
                            </div>
                            <div class="mt-5 d-flex">
                                <button type="submit" class="btn btn-block btn-c-orange">ADICIONAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="my-5">
            <div class="row justify-content-center">
                <div class="col-10 d-flex p-0">
                    <a href="{{route('comanda')}}" class="btn btn-block btn-c-location-c btn-c-orange">COMANDA</a>
                </div>
            </div>
        </div>
    </div>
@endsection
