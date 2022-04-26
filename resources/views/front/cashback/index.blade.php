@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="text-center mt-5">
            <a href="{{route('home')}}"><img src="{{asset('assets/img/arrow-left.png')}}" alt=""></a>
            <h2 class="ms-2 inline-block text-white">CASHBACK</h2>
        </div>

        <div class="mt-3">
            <div class="row justify-content-center">
                <div class="col-8 showcase-cashback">
                    <span>R$</span>
                    <h2>250,00</h2>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="row justify-content-center">
                <div class="col-10 text-center">
                    <h2>EXTRATO</h2>
                </div>
                <div class="col-10">
                    <div class="row justify-content-center">
                        <div class="col-4 p-0 me-1 d-flex"><button type="button" class="btn btn-block btn-c-orange">RECEBEU</button></div>
                        <div class="col-4 p-0 ms-1 d-flex"><button type="button" class="btn btn-block btn-c-white">PAGOU</button></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 chashback-extract">
            <div class="row">
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-4 d-flex align-items-center motivo text-orange">RECEBEU</div>
                        <div class="col-6">
                            <div class="text-center valor text-orange">
                                R$ 25,00
                            </div>
                            <div class="text-center data">
                                Data 12/10/2021
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-3 linha-horizontal"></div>

                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-4 d-flex align-items-center motivo text-orange">RECEBEU</div>
                        <div class="col-6">
                            <div class="text-center valor text-orange">
                                R$ 10,00
                            </div>
                            <div class="text-center data">
                                Data 20/10/2021
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-3 linha-horizontal"></div>

                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-4 d-flex align-items-center motivo">PAGOU</div>
                        <div class="col-6">
                            <div class="text-center valor">
                                R$ 10,00
                            </div>
                            <div class="text-center data">
                                Data 20/10/2021
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-3 linha-horizontal"></div>
            </div>
        </div>
    </div>
@endsection
