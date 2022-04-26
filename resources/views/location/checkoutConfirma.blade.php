@extends('layouts.main')
@section('content')
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="w-75">
            <div class="text-center mb-4">
                <img class="img-fluid" src="{{ asset('assets/img/logo-simples.png')}}" alt="">
            </div>
            <div class="mt-5">
                <div class="row justify-content-center">
                    @php
                        $data = date('Y-m-d H:i:s');
                        if($OrderFlow->status == 1) $OrderFlow->updated_at;

                        $since_start = getTimeDiff($data, $OrderFlow->created_at);
                        $seconds = $since_start->days * 24 * 60;
                        $seconds += $since_start->h * 3600;
                        $seconds += $since_start->i * 60;
                        $seconds += $since_start->s;
                    @endphp
                    <div class="col-12 wait-timer my-3 text-center text-size-2" data-auto_timer="{{$OrderFlow->status == 1 ? 'false' : 'true'}}" data-start_time="{{ $seconds }}">
                        {{str_pad($since_start->h, 2, '0', STR_PAD_LEFT) }}:{{str_pad($since_start->i, 2, '0', STR_PAD_LEFT) }}:{{str_pad($since_start->s, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="col-12 text-size-2 text-orange my-3 text-center">AGUARDE A VALIDAÇÃO DO GARÇOM</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.reload();
        }, 60000)
    </script>
@endsection
