<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} - @yield('title')</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/badf7f3a33.js" crossorigin="anonymous"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        @yield('CSS')
    </head>

    <body class="overflow-hidden">
        <nav class="hidden position-relative d-flex flex-column justify-content-between p-3" id="sidebar">
            <div id="toggleNav" class="justify-content-center align-items-center">
                <i class="fas fa-lg fa-bars"></i>
            </div>
            <div id="navTop">
                <a href="#">
                    <div class="d-flex justify-content-center align-items-center flex-wrap border-bottom pb-5">
                        <i class="far fa-money-bill-alt fa-3x" id="logoIcon"></i>
                        <span class="ml-2" id="logotype">BitChest</span>
                    </div>
                </a>
                <ul class="my-5 p-0">
                    <a href="#">
                        <li class="sidebar-item d-flex align-items-center mb-2 active">
                            <i class="fab fa-lg fa-bitcoin"></i>
                            <span class="text-capitalize ml-2">Les cryptomonnaies</span>
                        </li>
                    </a>
                    <a href="#">
                        <li class="sidebar-item d-flex align-items-center mb-2">
                            <i class="fas fa-lg fa-wallet"></i>
                            <span class="text-capitalize ml-2">Mon portefeuille</span>
                        </li>
                    </a>
                    <a href="#">
                        <li class="sidebar-item d-flex align-items-center mb-2">
                            <i class="fas fa-lg fa-user-circle"></i>
                            <span class="text-capitalize ml-2">Mon compte</span>
                        </li>
                    </a>
                </ul>
                <div>
                    <span class="text-capitalize">Mon solde : </span>
                    <span id="balance">1227,48 €</span>
                </div>
            </div>
            <div id="navBottom" class="d-flex justify-content-between">
                <a href="#" class="flex-grow-1">
                    <div class="sidebar-item d-flex align-items-center">
                        <i class="fas fa-lg fa-sign-out-alt"></i>
                        <span class="text-capitalize ml-2">Déconnexion</span>
                    </div>
                </a>
                <div class="sidebar-item align-items-center justify-content-end flex-grow-1" id="closeNav">
                    <i class="fas fa-lg fa-times-circle"></i>
                    <span class="text-capitalize ml-2">Fermer</span>
                </div>
            </div>
        </nav>

        <main>
            <div class="container">
                @yield('content')
            </div>
        </main>

        {{-- Scripts --}}
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/script.js') }}"></script>
        @yield('JS')
    </body>
</html>
