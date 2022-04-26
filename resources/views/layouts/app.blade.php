<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Celeiro do Malte</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Inline&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('assets/css/painel.min.css') }}">

    <script src="https://kit.fontawesome.com/0ab2bcde1c.js" crossorigin="anonymous"></script>
</head>

<body class="antialiased">
    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="logo container">
                    <img src="{{ url('assets/img/logo.svg') }}" alt="">
                </div>
            </div>

            <ul class="list-unstyled components">

                <li>
                    <a href="{{ url('dashboard') }}">Dashboard</a>
                </li>
                <li>
                    <a href="{{ url('produtos') }}">Produtos</a>
                </li>
                <li>
                    <a href="{{ url('mesas') }}">Mesas</a>
                </li>
                <li>
                    <a href="{{ url('painel/pedidos') }}">Vendas</a>
                </li>
                <li>
                    <a href="{{ url('painel/transportes') }}">Transportes</a>
                </li>
                <li>
                    <a href="{{ url('clientes') }}">Clientes</a>
                </li>
                <li>
                    <a href="{{route('setting.waiter')}}">Garçons</a>
                </li>
                <li>
                    <a href="{{route('setting.admin')}}">Administradores</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light ">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <a href="{{ route('logout') }}" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                </div>
            </nav>
            <main class="container my-5">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('modal')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="{{ url('assets/js/jquery.maskMoney.min.js') }}"></script>
    <script src="{{ url('assets/js/painel.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
                    $('#sidebarCollapse').on('click', function () {
                        $('#sidebar').toggleClass('active');
                        $(this).toggleClass('active');
                    });
                });
    </script>
    @if(Session::has('success'))
    <script type="text/javascript">
        Swal.fire({
            icon: 'success',
            title: 'Muito bom!',
            text: "{{Session::get('success')}}",

        }).then((value) => {
            // location.reload();
        }).catch(swal.noop);
    </script>
    @endif

</body>

</html>
