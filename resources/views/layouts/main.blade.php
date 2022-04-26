<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ url('assets/img/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Inline&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0ab2bcde1c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('assets/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/idade/main.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/menu.min.css') }}">

    <title>CELEIRO DO MALTE</title>
</head>

<body>
    <div class="cookie-idade d-flex align-items-center">
        <div class="container d-flex flex-column align-items-center">
            <div><img class="img-fluid" src="{{ asset('assets/img/logo.png') }}" alt=""></div>
            <div class="cookie-title my-3 text-center">
                <h4 class="text-white">VOCÊ É MAIOR DE</h4>
                <h3 class="text-orange">18 ANOS?</h3>
            </div>
            <div class="btns">
                <button type="button" class="btn btn-c-white btn-no-cookie-idade">NÃO</button>
                <button type="button" class="btn btn-c-orange btn-yes-cookie-idade">SIM</button>
            </div>
        </div>
    </div>

    @if (Request::is('store/login') == false && Request::is('store/register') == false && Request::is('/') == false)
        <div id="nav" class="wrapcircles closed">
            <div class="circle c-1"><a class="link" href="{{ route('perfil') }}"></a></div>
            <div class="circle c-2"><a class="link" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></a></div>
            <div class="circle c-3"><a class="link" href="{{ route('home') }}"></a></div>
            <div id="click" class="circle c-5"><span><a class="link"></a></span></div>
        </div>
    @endif

    @yield('content')

    <form id="logout-form" action="{{ route('store.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @if (!Cart::isEmpty())
        @if (Request::is('comanda') == false && Request::is('comanda/*') == false && Request::is('mesa') == false && Request::is('mesa/*') == false)
            <div class="float-btn">
                <a href="{{ route('pre.checkout') }}"> <span
                        class="span-cart">{{ \Cart::getTotalQuantity() }}</span>
                    <button class="btn btn-cart"><i class="fas fa-shopping-cart icon"></i>
                    </button>
                </a>
            </div>
        @endif
    @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/valida_cpf_cnpj.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.stopwatch.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="{{ url('assets/js/jquery.maskMoney.min.js') }}"></script>
    {{-- <script src="{{ url('assets/js/qr-scanner.min.js') }}"></script>
    <script src="{{ url('assets/js/qr-scanner-worker.min.js') }}"></script> --}}
    <script type="module" src="{{ url('assets/js/code.js') }}"></script>
    <script src="{{ url('assets/js/script.js') }}"></script>
    <script type="text/javascript">
        $(document).on('click', '.btn-open-lr', function() {
            $('.aba-lr').css({
                'width': '320px'
            });
        });
        $(document).on('click', '.btn-close-lr', function() {
            $('.aba-lr').css({
                'width': '0'
            });
        });

        $('#buscar').on('click', function() {
            $value = $('#cep').val();
            $.ajax({
                type: 'get',
                url: '{{ route('address.cep') }}',
                data: {
                    'search': $value
                },
                success: function(data) {
                    console.log(data);
                    $('#endereco').val(data.street);
                    $('#bairro').val(data.district);
                    $('#cidade').val(data.city);
                    $('#estado').val(data.uf);
                }
            });
        })
    </script>

    @if(Session::has('success'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'success',
                title: "{{Session::get('success')}}",

            }).then((value) => {
                // location.reload();
            }).catch(swal.noop);
        </script>
    @endif
    @if(Session::has('error'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'error',
                title: "{{Session::get('error')}}",

            }).then((value) => {
                // location.reload();
            }).catch(swal.noop);
        </script>
    @endif
    @if(Session::has('info'))
        <script type="text/javascript">
            Swal.fire({
                icon: 'info',
                title: "{{Session::get('info')}}",

            }).then((value) => {
                // location.reload();
            }).catch(swal.noop);
        </script>
    @endif
    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.1.3/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.1.3/firebase-analytics.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
          apiKey: "AIzaSyCcTnukB7zVZVr3T-Pk6-Lptswge0BDOXg",
          authDomain: "quitanda-online.firebaseapp.com",
          projectId: "quitanda-online",
          storageBucket: "quitanda-online.appspot.com",
          messagingSenderId: "316733871101",
          appId: "1:316733871101:web:6445d114c0ad3a53b73f94",
          measurementId: "G-VS0W8T8NRJ"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
      </script>
</body>

</html>
