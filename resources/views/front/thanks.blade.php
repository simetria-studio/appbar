@extends('layouts.main')

@section('content')
    <section class="container">
          <div class="d-flex flex-column justify-content-center">
                <div class="mx-auto mt-5">
                      <img src="{{ url('assets/img/logo2.svg') }}" alt="">
                </div>
                <div class="mx-auto mt-3">
                      <h1>PRONTO</h1>
                </div>
                <div class="mx-auto col-md-5 text-center text-white">
                      <p>você será avisado do lançamento do nosso app e poderá utilizar seu cupom!</p>
                </div>
                <div class="mx-auto col-md-5 text-center text-thanks">
                      <p class="my-auto">Acompanhe nossas redes</p>
                </div>
                <div class="d-flex mx-auto mt-3 icons">
                      <div class="face" id="face" onmousemove="face()" onmouseleave="faceOut()">
                         <a href="https://www.facebook.com/celeirodomaltecervejasartesanais" target="_blank">  <img src="{{ url('assets/img/face.svg') }}" alt=""></a>
                      </div>
                      <div class="insta" id="insta" onmousemove="insta()" onmouseleave="instaOut()">
                           <a href="https://www.instagram.com/celeirodomalte/" target="_blank"><img src="{{ url('assets/img/insta.svg') }}" alt=""></a>
                      </div>
                </div>
          </div>
    </section>

@endsection