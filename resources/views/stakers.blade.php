<?php

$wallet_connected = true;

$minDope = 1000;

if (isset($_COOKIE['wallet'])) {

    $dope_balance = dopeBalance($_COOKIE['public']);

} else {

    $dope_balance = 0;

}

$insufficient_dope = $dope_balance < $minDope ? true : false;

$site_url = url('');

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dope Credits</title>

    <!-- bootstrap 5 -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"

        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- paralucemnt font use -->

    <link href="//db.onlinewebfonts.com/c/c1d440b87551df56c26f7e478436b8ce?family=ParalucentW00-Heavy" rel="stylesheet"

        type="text/css" />

    <!-- font awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- custome style -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"

        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="

        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <link rel="stylesheet" href="{{ asset('css/style.css?' . filemtime('css/style.css')) }}">

    <link rel="icon" type="image/png" href="{{ url('images/favicon.png') }}">



    <style>

        .search {

            position: relative;

            box-shadow: 0 0 40px rgba(51, 51, 51, .1);

            transform: scale(0.8)



        }



        .search input {



            height: 60px;

            text-indent: 25px;

            border: 2px solid #d6d4d4;





        }





        .search input:focus {



            box-shadow: none;

            border: 2px solid blue;





        }



        .search .fa-search {



            position: absolute;

            top: 20px;

            left: 16px;



        }



        .search button {



            position: absolute;

            top: 5px;

            right: 5px;

            height: 50px;

            width: 110px;

            background: blue;



        }

    </style>

</head>



<body>



    <!-- mainSection -->

    <section class="bg-main">

        <div class="container-fluid">

            <!-- navbar -->

            <div class="row">

                <div class="mainNavbar">

                    <nav>

                        <div class="logo">

                            <a href="{{$site_url}}">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo Image">
                            </a>

                        </div>

                        <div class="hamburger">

                            <div class="line1"></div>

                            <div class="line2"></div>

                            <div class="line3"></div>

                        </div>

                        <ul class="nav-links">

                            <li><a href="{{ url('stakers') }}">Stakers</a></li>

                            <li><a href="#">Whitepaper</a></li>

                            <li><a href="https://stellar.expert/explorer/public/asset/DOPE-GAXI2WKTSYXLMMZWVY77NB4OLEKGDQ4IXKXD4UGXD7IW2XYMBPLW6PRZ-1"

                                    target="_blank">Token explorer</a></li>

                            <li><a href="<?= $site_url ?>#about">About</a></li>

                        </ul>

                        <div class="wallet-btn">

                            <a href="#"

                                class="btn dope mt-0 {{ isset($_COOKIE['public']) ? 'dropdown-toggle' : '' }}"

                                @if (!isset($_COOKIE['public'])) data-bs-toggle="modal" 

                                data-bs-target="#ConnectWallet" 

                                @else

                                data-bs-toggle="dropdown"

                                data-bs-auto-close="inside" aria-expanded="false" @endif>

                                {{-- <img src="{{ asset('images/key.png') }}" alt=""> --}}



                                @if (isset($_COOKIE['wallet']))

                                    <img id='walletImage' src="{{ asset('images/key.png') }}" alt="">

                                    {{-- 'images/' . $_COOKIE['wallet'] . '.png') }}" --}}

                                @else

                                    <img id='walletImage' alt="">

                                @endif



                                {{-- <p id="topWallet"> --}}

                                {{ isset($_COOKIE['public']) ? substr($_COOKIE['public'], 0, 4) . '...' . substr($_COOKIE['public'], -5) : 'Connect Wallet' }}

                                {{-- </p> --}}





                            </a>



                            <!-- modal wallet -->

                            

                            <!-- modal wallet -->



                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableOutside">

                                <li><a class="dropdown-item" href="{{ url('wallet/disconnect') }}">Disconnect</a></li>

                            </ul>



                        </div>

                    </nav>

                </div>



                <div class="row mb-5">

                    <div class="col-12 text-center">

                        <h2>Staking Stats</h2>

                    </div>

                    <div class="col-md-3">Total Staked : <span class="text-info">{{ $totalStake }} $DOPE</span></div>

                    <div class="col-md-3">Total Stakers : <span class="text-info">{{ count($stakers) }} </span></div>

                    <div class="col-md-6 col-6">

                        <form action="{{ url('stakers') }}" method="get">

                            <div class="search">

                                <i class="fa fa-search"></i>

                                <input type="text" class="form-control" name="search" placeholder="Search Wallet Address">

                                <button class="btn btn-primary">Search</button>

                            </div>

                        </form>

                    </div>

                </div>



                <div class="row">

                    <div class="col-12">

                        <table class="table table-bordered text-break">

                            <thead>

                                <tr>

                                    <th>Wallet Address</th>

                                    <th>Staked Dope</th>

                                    <th>Reward Date</th>

                                    <th>Transaction</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($stakers as $stake)

                                    <tr>

                                        <td>{{ $stake->public }}</td>

                                        <td>{{ $stake->amount }}</td>

                                        <td>{{ date('d F Y', strtotime($stake->created_at.'+30 days')) }}</td>

                                        <td><a href="https://stellar.expert/explorer/public/tx/{{ $stake->transaction_id }}"

                                                target="_blank" rel="noopener noreferrer">View Transaction</a></td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- mainSection -->



    <!-- bootstrap 5 js -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"

        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"

        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">

    </script>

    <!-- custome js -->

    @include('components.scripts')

    {{-- <script src="{{ asset('js/custom.js?' . filemtime('js/custom.js')) }}"></script>

    <script src="{{ asset('js/wallet.js?' . filemtime('js/wallet.js')) }}"></script>

    <script src="{{ asset('js/sandox.js?' . filemtime('js/sandox.js')) }}"></script> --}}

</body>



</html>

