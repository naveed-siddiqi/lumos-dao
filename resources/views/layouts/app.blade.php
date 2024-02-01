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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        crossorigin="anonymous"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.time()) }}">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
@include('components.scripts')
<body class="DOA">
    <section>
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <div class="d-flex align-items-center ">
                        <img src="{{ asset('images/Image.png') }}" alt="">
                        <h3 class="logo-lumos-font">
                            LUMOS DAO
                        </h3>
                    </div>

                </a>
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
                            <a class="nav-link" href="https://github.com/naveed-siddiqi/lumos-dao"
                                target="_blank">Github</a>
                        </li>
                    </ul>

                    @if (isset($_COOKIE['public']))
                    <span class="mx-3">
                        <svg width="25px" height="25px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                    </svg>

                    </span>
                    <div class="profile-dropdown">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle hide-arrow" type="button" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-icon">
                                    <img src="https://id.lobstr.co/{{$_COOKIE['public']}}.png" alt="Profile Icon">
                                    <code
                                        class="profile-name">{{ substr($_COOKIE['public'], 0, 4) . '...' . substr($_COOKIE['public'], -5) }}</code>
                                    <span class="arrowdown"><img src="{{ asset('images/Layer 3.png') }}" alt=""></span>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="javascript:;"
                                        onclick="copy('{{$_COOKIE['public']}}')"><i class="fa fa-copy"></i> Copy
                                        address</a></li>
                                        <li><a class="dropdown-item" href="{{ route('lumosdao-joined') }}">Profile</a></li>

                                <li><button id="settingProBtn" type="button" data-toggle="modal"
                                        data-target="#exampleModalCenter" class="dropdown-item">Settings</button></li>
                                        <li><a class="dropdown-item" href="{{ url('wallet/disconnect') }}">Disconnect</a></li>

                            </ul>
                        </div>
                    </div>
                    <section>

                    </section>
                    @else
                    <div class="loginBox">
                        <button class="btn btnReg" data-bs-toggle="modal" data-bs-target="#ConnectWallet">Connect
                            Wallet</button>
                    </div>
                    @endif
                    <div class="themeSwitcher">
                        <input type="checkbox" class="checkbox" id="checkbox">
                        <label for="checkbox" class="checkbox-label">
                            <img class="fa-moon" src="{{ asset('images/light.png') }}" alt="">
                            <img class="fa-sun" src="{{ asset('images/dark.png') }}" alt="">
                            <span class="ball"></span>
                        </label>
                    </div>
                </div>

            </div>
        </nav>
    </section>
    <section>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content fa-modal-content p-0 m-0">
                    <div class="container">
                        <ul class="nav nav-tabs fa-nav-tabs" id="myTabs">
                            <li class="">
                                <a class="nav-link fa-nav-link active" id="tab1" data-bs-toggle="tab"
                                    href="#profile">Profile</a>
                            </li>
                            <li class="">
                                <a class="nav-link fa-nav-link" id="tab2" data-bs-toggle="tab"
                                    href="#security">Security</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active fa-ctn" id="profile">
                                <div class="w-100 h-100 fa-profile-sett d-flex flex-column gap-3 pb-4 pt-2">
                                    <div class="form-group">
                                        <label for="">
                                            <span class="asset-details-label">Display Name (Optional):</span>
                                        </label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">
                                            <span class="asset-details-label">Bio:</span>
                                        </label>
                                        <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
                                    </div>
                                    <div class="row m-0 gap-2">
                                        <div class="d-flex align-items-center gap-1 col-sm form-control">
                                            <a class="d-flex align-items-center gap-1 col-sm text-black text-decoration-none"
                                                href="">
                                                <div class="card-imgflex-social-link">
                                                    <label for="">
                                                        <img class="w-img"
                                                            src="/images/x-logo-twitter-elon-musk_dezeen_2364_col_0-1.webp"
                                                            alt="">
                                                    </label>
                                                </div>
                                                <span><small>Instagram</small></span>
                                            </a>
                                        </div>

                                        <div class="d-flex align-items-center gap-1 col-sm form-control">
                                            <a class="d-flex align-items-center gap-1 col-sm text-black text-decoration-none"
                                                href="">

                                                <div class="card-imgflex-social-link">
                                                    <label for="">
                                                        <img class="w-img" src="/images/LinkedIn_icon.svg.png" alt="">
                                                    </label>
                                                </div>
                                                <span><small>LinkedIn</small></span>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center gap-1 col-sm form-control">
                                            <a class="d-flex align-items-center gap-1 col-sm text-black text-decoration-none"
                                                href="">

                                                <div class="card-imgflex-social-link">
                                                    <label for="">
                                                        <img class="w-img" src="/images/github.png" alt="">
                                                    </label>
                                                </div>
                                                <span><small>Github</small></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group my-2 d-flex flex-column justify-content-start">
                                        <label for="">
                                            <span class="asset-details-label">Display Image:</span>
                                        </label>
                                        <div class="container_custom_file_input w-50">
                                            <div class="custom-file" style="position: relative;">
                                                <input type="file" class="custom-file-input" id="customFile">
                                                <label class="custom-file-label" for="customFile">
                                                    <span>Browse <br> Computer</span>
                                                    <div class="">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            width="24px">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 d-flex align-items-center justify-content-end my-2">
                                    <button class="btn btn-warning text-end">Save</button>
                                </div>
                            </div>
                            <div class="tab-pane fade fa-ctn" id="security">
                                <h1 class="my-2">Enable two-factor authentication </h1>
                                <ol class="d-flex flex-column align-items-center justify-content-start gap-4">
                                    <li>
                                        Download and install an authentication app on your phone. We recommend Twilio
                                        Authy, Microsoft Authenticator, and Duo.

                                    </li>
                                    <li>
                                        Using the app, scan the QR code or manually enter the following code:
                                        EZXEEZY6CNTXKRTW
                                        Continue
                                    </li>
                                </ol>
                                <div class="w-100 d-flex align-items-center justify-content-center">
                                    <img src="data:image/png;base64,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"
                                        alt="">
                                </div>
                                <div class="w-100 d-flex align-items-center justify-content-end">
                                    <button class="btn btn-success text-end">Continue</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    

    {{-- <script src="{{ asset('js/custom.js?v='.time()) }}"></script> --}}
    <script src="{{ asset('js/wallet.js?v='.time()) }}"></script>
    <script src="{{ asset('js/sandox.js?v='.time()) }}"></script>
    <script>
    const checkbox = document.getElementById('checkbox');
    var settingProBtn = document.getElementById('settingProBtn');


    settingProBtn.addEventListener('click', function() {

    });
    const body = document.body;

    // Function to set the mode based on user preference stored in localStorage
    function setModePreference() {
        const isDarkMode = localStorage.getItem('darkMode') === 'true';

        if (isDarkMode) {
            body.classList.add('dark-mode');
            checkbox.checked = true;
        } else {
            body.classList.add('light-mode');
            checkbox.checked = false;
        }
    }

    // Function to toggle the mode and update localStorage
    function toggleMode() {
        if (body.classList.contains('dark-mode')) {
            body.classList.remove('dark-mode');
            body.classList.add('light-mode');
            localStorage.setItem('darkMode', 'false');
        } else {
            body.classList.remove('light-mode');
            body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'true');
        }
    }

    checkbox.addEventListener('change', toggleMode);
    setModePreference(); // Call this function to set the initial mode based on localStorage
    </script>
    {{-- <script>
        @if (!isset($_COOKIE['public']))
            $(window).load(function() {
                $('#ConnectWallet').modal('show');
            });
        @endif
    </script> --}}
</body>

</html>