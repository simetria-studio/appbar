@extends('layouts.main')
@section('content')
<section class="container mt-5">
      <div class="d-flex flex-column justify-content-center">
            <div class="mx-auto logo">
                  <img src="{{ url('assets/img/logo.svg') }}" alt="Logo">
            </div>
            <div class="text-uppercase mx-auto mt-3">
                  <h1>Em breve novo site</h1>
            </div>
            <div class="text-uppercase mx-auto text-center text-white mid-text mt-5">
                  <p>
                        Mais aconchegante que a nossa casa, só mesmo a sua. Por isso, toda a qualidade do Celeiro
                        do
                        Malte vai até aí.
                  </p>
            </div>
            <div class="text-uppercase mx-auto text-center low-text col-md-6 col-10 mt-2">
                  <p class="my-auto">
                        Se você tem mais de 18 anos faça o pré cadastro e garanta 10% de desconto na primeira
                        compra.
                  </p>
            </div>
      </div>
      <form action="{{ url('user-store') }}" method="POST">
            @csrf
            <div class="d-flex flex-column align-items-center mx-auto text-center mt-4 form">

                  <div class="form-group col-md-4 col-10 mt-2">

                        <input type="text" class="form-control" name="name" placeholder="Nome:">

                  </div>
                  <div class="form-group col-md-4 col-10 mt-2">

                        <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                              placeholder="Whatsapp com dd:">

                  </div>
                  <div class="form-group col-md-4 col-10 mt-2">

                        <input type="email" class="form-control" name="email" placeholder="E-mail:">

                  </div>
                  <div class="col-md-4 col-10 mt-2 mb-4">
                        <button class="btn btn-env">CADASTRAR E GANHAR 10%</button>
                  </div>

            </div>
      </form>
</section>
@endsection