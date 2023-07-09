<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" crossorigin="anonymous"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.time()) }}">
</head>

<body class="DOA">
    <section>
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <svg class="hum" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                        </svg>
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('explore') }}">Explore</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('page', 'how-it-works') }}">How it works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Github</a>
                        </li>
                    </ul>
                    {{-- temporary --}}
                    {{-- @if (isset($_COOKIE['public'])) --}}
                    @if (Route::currentRouteName()!='home')
                    <div class="profile-dropdown">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle hide-arrow" type="button" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-icon">
                                    {{-- <img src="https://id.lobstr.co/{{$_COOKIE['public']}}.png" alt="Profile Icon">
                                    <code class="profile-name">{{ substr($_COOKIE['public'], 0, 4) . '...' . substr($_COOKIE['public'], -5) }}</code> --}}
                                    <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Icon">
                                    <code class="profile-name">GBZZV...DRW5P</code>
                                    <span class="arrowdown"><img src="{{ asset('images/Layer 3.png') }}" alt=""></span>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                {{-- {{ url('wallet/disconnect') }} --}}
                                <li><a class="dropdown-item" href="javascript:;">Disconnect</a></li>
                                <li><a class="dropdown-item" href="javascript:;" onclick="copy('GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P')"><i class="fa fa-copy"></i> Copy address</a></li>
                            </ul>
                        </div>
                    </div>
                    @else
                    <div class="loginBox">
                        {{-- data-bs-target="#ConnectWallet" --}}
                        <button class="btn btnReg" data-bs-toggle="modal">Connect Wallet</button>
                    </div>
                    @endif
                    <div class="themeSwitcher">
                        <input type="checkbox" class="checkbox" id="checkbox">
                        <label for="checkbox" class="checkbox-label">
                            <img class="fa-moon" src="{{ asset('images/dark.png') }}" alt="">
                            <img class="fa-sun" src="{{ asset('images/light.png') }}" alt="">
                            <span class="ball"></span>
                        </label>
                    </div>
                </div>

            </div>
        </nav>
    </section>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="left">
                        Built on Stellar <span class="logoTheme"> &nbsp; &nbsp;Lumos DAO</span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="right">
                        <ul class="footer-links">
                            <li><a href="{{ route('page', 'about') }}">About</a></li>
                            <li><a href="{{ route('page', 'terms-and-conditions') }}">Terms</a></li>
                            <li><a href="{{ route('page', 'privacy-policy') }}">Policy</a></li>
                            <li><a href="{{ route('page', 'faq') }}">FAQs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @include('components.connectWallet')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    @include('components.scripts')

    {{-- <script src="{{ asset('js/custom.js?v='.time()) }}"></script> --}}
    <script src="{{ asset('js/wallet.js?v='.time()) }}"></script>
    <script src="{{ asset('js/sandox.js?v='.time()) }}"></script>
    {{-- <script>
        @if (!isset($_COOKIE['public']))
            $(window).load(function() {
                $('#ConnectWallet').modal('show');
            });
        @endif
    </script> --}}
</body>

</html>
