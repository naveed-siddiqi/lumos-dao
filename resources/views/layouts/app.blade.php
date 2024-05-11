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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
@include('components.scripts')
<body class="DOA">
    <section id='main_header_div'>
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <div class="d-flex align-items-end gap-2">
                        <img style="width: 50px;" src="{{ asset('images/Image.png') }}" alt="">
                        <h3 class="font-bold logo-lumos-font">
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
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto gap-5">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('explore') }}">Explore</a>
                        </li>
                    </ul>
                    <div style="display: none;" id="alertCopied" class="alert alert-success position-fixed w-25 mt-5 right-0 text-center" role="alert">
                            <p class="p-0 m-0 text-success"> Copied!</p>
                        </div>
                    @if (isset($_COOKIE['public']))
                    <span class="mx-3">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('proposal.inbox')}}">Inbox <span class="text-danger" id='nav_user_inbox'>(<?php
                                    /* Load the unread messages number of this user */
                                    $path = substr(__FILE__, 0, strpos(__FILE__, 'storage'));
                                    require("$path.well-known/config.php");
                                    require("$path.well-known/db.php");
                                    if(isset($_COOKIE['public'])){
                                        $user = $_COOKIE['public'];
                                        $query = "SELECT * FROM message WHERE (receiver ='$user' OR receiver ='all') AND status <> 'read'";
                                	    $result = mysqli_query($conn, $query);
                                	    $res = mysqli_num_rows($result);
                                	    echo $res * 1;
                                    }
                                    else {echo 0;}
                                ?>)</span></a>
                            </li>
                            <li class="nav-item">
<<<<<<< HEAD
                                <a class="nav-link" href="{{route('pages.alert')}}">Alerts <span class="text-danger">(12)</span></a>
=======
                                <a class="nav-link" href="{{route('pages.alert')}}">Alerts <span class="text-danger" id='nav_user_alert_num'>(<?php
                                    /* Load the unread messages number of this user */
                                    if(isset($_COOKIE['public'])){
                                        $user = $_COOKIE['public'];
                                        $query = "SELECT * FROM alert WHERE user = '$user' AND status = 'unread'";
                                	    $result = mysqli_query($conn, $query);
                                	    echo json_encode(mysqli_num_rows($result) * 1);
                                    }
                                    else {echo 0;}
                                ?>)</span></a>
>>>>>>> 9270b47 (added new UI updates)
                            </li>
                        </ul>
                    </span>
                    <?php
                        /* Load userinfo */
                        if(isset($_COOKIE['public'])){
                            $user = $_COOKIE['public'];
                            $query = "SELECT * FROM users WHERE wallet='$user'";
                    	    $result = mysqli_query($conn, $query);
                    	    if(mysqli_num_rows($result)> 0){
                    	        $user =  mysqli_fetch_array($result);
                    	    }
                    	    else{$user = array();}
                        }
                    ?>
                    <div class="profile-dropdown">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle hide-arrow" type="button" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-icon">
                                    <img id='nav_user_disp_img' src="<?php if(isset($user['image'])){echo $user['image'] . '?id=' . rand();}else {echo 'https://id.lobstr.co/'. $_COOKIE['public'] . '.png?id=' . rand();} ?>" alt="Profile Icon">
                                    <code
                                        class="profile-name">{{ substr($_COOKIE['public'], 0, 4) . '...' . substr($_COOKIE['public'], -5) }}</code>
                                    <span class="arrowdown"><img src="{{ asset('images/Layer 3.png') }}" alt=""></span>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li onclick="copyAddress()"><a class="dropdown-item" href="javascript:;"
                                        onclick="copy('{{$_COOKIE['public']}}')"><i class="fa fa-copy"></i> Copy
                                        address</a></li>
                                        <li><a class="dropdown-item" href="{{route('user','')}}/<?php echo $_COOKIE['public']; ?>">Profile</a></li>

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
                        <button style=" background: #DC6B19 !important;" class="btn btnReg" data-bs-toggle="modal" data-bs-target="#ConnectWallet">Connect
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
                                        <input type="text" id='user_display_save_name' value='<?php if(isset($user['name'])){ echo $user['name']; } ?>' class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">
                                            <span class="asset-details-label">Bio:</span>
                                        </label>
                                        <textarea class="form-control" name="" id='user_display_save_bio' cols="30" rows="10"> <?php if(isset($user['bio'])){ echo $user['bio']; } ?></textarea>
                                    </div>
                                    <div class="row m-0 gap-2">
                                        <div class="d-flex align-items-center gap-1 col-sm form-control" onclick='authTwitter()'>
                                            <a class="d-flex align-items-center gap-1 col-sm text-black text-decoration-none" stye='cursor:pointer'>
                                                <div class="card-imgflex-social-link">
                                                    <label for="">
                                                        <img class="w-img"
                                                            src="{{asset('/images/x-logo-twitter-elon-musk_dezeen_2364_col_0-1.webp')}}"
                                                            alt="">
                                                    </label>
                                                </div>
                                                <span><small><?php
                                                    if(isset($user['twitter'])) {
                                                        if($user['twitter'] != "") {echo "Connected";}else{echo "x.com";}
                                                    }
                                                    else{echo "x.com";}
                                                ?></small></span>
                                            </a>
                                        </div>

                                        <div class="d-flex align-items-center gap-1 col-sm form-control" onclick='authLinkedIn()' style='display:none !important'>
                                            <a class="d-flex align-items-center gap-1 col-sm text-black text-decoration-none" style='cursor:pointer'
                                                >

                                                <div class="card-imgflex-social-link">
                                                    <label for="">
                                                        <img class="w-img" src="{{asset('/images/LinkedIn_icon.svg.png')}}" alt="">
                                                    </label>
                                                </div>
                                                <span><small><?php
                                                    if(isset($user['linkedin'])) {
                                                        if($user['linkedin'] != "") {echo "Connected";}else{echo "Linkedin";}
                                                    }
                                                    else{echo "Linkedin";}
                                                ?></small></span>
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center gap-1 col-sm form-control" onclick = 'authGithub()'>
                                            <a class="d-flex align-items-center gap-1 col-sm text-black text-decoration-none" style='cursor:pointer'
                                                >

                                                <div class="card-imgflex-social-link">
                                                    <label for="">
                                                        <img class="w-img" src="{{asset('/images/github.png')}}" alt="">
                                                    </label>
                                                </div>
                                                <span><small><?php
                                                    if(isset($user['github'])) {
                                                        if($user['github'] != "") {echo "Connected";}else{echo "Github";}
                                                    }
                                                    else{echo "Github";}
                                                ?></small></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group my-2 d-flex flex-column justify-content-start">
                                        <label for="">
                                            <span class="asset-details-label">Display Image:</span>
                                        </label>
                                        <div class="container_custom_file_input w-50">
                                            <div class="custom-file" style="position: relative;">
                                                <input type="file" id='user_display_save_img' class="custom-file-input" id="customFile">
                                                <label class="custom-file-label" for="customFile">
                                                    <span id='user_display_save_img_o' >Browse <br> Computer</span>
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
                                    <button class="btn btn-warning text-end" onclick='saveUserInfo()'>Save</button>
                                </div>
                            </div>
                            <div class="tab-pane fade fa-ctn" id="security">
                                <h1 class="my-2">Enable two-factor authentication </h1>
                                <ol class="d-flex flex-column align-items-center justify-content-start gap-4">
                                    <li>
                                        Download and install an authentication app on your phone. We recommend Twilio
                                        Authy, Microsoft Authenticator, and Duo.
                                    </li>
                                </ol>
                                <div id='2fa_bar_code' class="w-100 align-items-center justify-content-center" style='display:flex'>
                                    
                                </div>
                                <span id='2fa_auth_msg' style='display:none'></span>
                                <input class='form-control' placeholder='Code....' id='2fa_auth_code' style='display:none' />
                                <div class="w-100 d-flex align-items-center justify-content-end" style='margin-top:40px'>
                                    <button class="btn btn-success text-end" onclick='reg2FaCode()'>Continue</button>
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
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="left">
                        Built on Stellar <span class="logoTheme"> &nbsp; &nbsp;Lumos DAO</span>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="right">
                        <ul class="footer-links">
                            <li><a href="{{ route('page', 'lumosdao-explorer') }}">Explorer</a></li>
                            <li><a href="{{ route('page', 'about') }}">About</a></li>
                            <li><a href="{{ route('page', 'terms-and-conditions') }}">Terms</a></li>
                            <li><a href="{{ route('page', 'privacy-policy') }}">Policy</a></li>
                            <li><a href="{{ route('page', 'faq') }}">FAQs</a></li>
                            <li><a class="nav-link" href="https://github.com/naveed-siddiqi/lumos-dao" target="_blank">Github</a></li>
<<<<<<< HEAD
                            <li> <a class="nav-link" href="{{ route('page', 'how-it-works') }}">Docs</a></li>
=======
                            <li> <a class="nav-link" href="{{ route('page', 'docs') }}">Docs</a></li>
>>>>>>> 9270b47 (added new UI updates)
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @include('components.connectWallet')
    </script>
    <!-- for twitter -->
    <script type="module" async >
      // Import the functions you need from the SDKs you need
      import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
      import { TwitterAuthProvider, getAuth, signInWithPopup } from 'https://www.gstatic.com/firebasejs/10.11.1/firebase-auth.js' 
      window.TwitterAuthProvider = TwitterAuthProvider
      window.getAuth = getAuth
      window.signInWithPopup = signInWithPopup
      // Your web app's Firebase configuration
      // For Firebase JS SDK v7.20.0 and later, measurementId is optional
      const firebaseConfig = {
        apiKey: "AIzaSyAr6xctELroIg3emOorUQq8w81j5cLHbLE",
        authDomain: "lumosdao-fffb9.firebaseapp.com",
        projectId: "lumosdao-fffb9",
        storageBucket: "lumosdao-fffb9.appspot.com",
        messagingSenderId: "487527622972",
        appId: "1:487527622972:web:4c70fb14c02086fb30d639",
        measurementId: "G-6HM371W39R"
      };
     // Initialize Firebase
     const app = initializeApp(firebaseConfig);
     window.app = app
    </script>
    <script>
        isTwitterAuth = <?php if(isset($user['twitter'])){ if($user['twitter'] != "") {echo true;}else {echo 0;}}else{echo 0;} ?>;
        isLinkedInAuth = <?php if(isset($user['linkedin'])){ if($user['linkedin'] != "") {echo true;}else {echo 0;}}else{echo 0;} ?>;
        isGithubAuth = <?php if(isset($user['github'])){ if($user['github'] != "") {echo true;}else {echo 0;}}else{echo 0;} ?>;
        var user_disp_image = null;
        const saveUserInfo = async () => {
            //get the user info
            const userDispName = E('user_display_save_name').value
            const userDispBio = E('user_display_save_bio').value
            
            try {
                 if(userDispName != "" && userDispBio != "") {
                    const id = talk('Saving user info')
                    //check if the url is http and from this domain
                    const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=modify_user&user=" + walletAddress  + "&name=" + encodeURIComponent(userDispName) + "&bio=" + encodeURIComponent(userDispBio)
                    const response = await fetch(url);
                    if (!response.ok) {
                      
                    }
                    const res = await response.json();
                    if(res.status) {
                        //save image if present
                        if(user_disp_image != null) {
                            talk('Saving the image', 'norm', id)
                            const formData = new FormData(); // Create a FormData object
                            // Add the selected file to the FormData object
                            formData.append('file', user_disp_image);
                            // Create an HTTP request
                            const xhr = new XMLHttpRequest();
                            const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=upload_user_img&name=" + walletAddress + ".png&user=" + walletAddress
                            // Define the server endpoint (PHP file)
                            xhr.open('POST', url, true);
                            // Set up an event listener to handle the response
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    console.log(xhr.responseText)
                                    if (xhr.responseText == "1") {
                                        stopTalking(2, talk('Profile saved successfully', 'good', id))
                                        const img = URL.createObjectURL(user_disp_image)
                                        E('nav_user_disp_img').src = img
                                        //reload page for img saves
                                        window.location.reload()
                                    } else {
                                        stopTalking(2, talk('Unable to save image', 'fail', id))
                                    }
                                } else if (xhr.readyState === 4 && xhr.status !== 200) {
                                     stopTalking(2, talk('Unable to save image', 'fail', id))
                                }
                            };
                            // Send the FormData object with the image
                            xhr.send(formData);
                        }
                        else {
                            stopTalking(2, talk('Saved successfully', 'good', id))
                        }
                    }
                    else {
                        stopTalking(2, talk('Unable to save profile', 'fail', id))
                    }
                }
                else {return 2}
            } catch (error) { console.log(error)
                stopTalking(2, talk('Unable to save profile', 'fail', id))
            }
            
        }
        const authTwitter = () => {
            if(isTwitterAuth){return;}
            const provider = new TwitterAuthProvider(); 
            const auth = getAuth();
            signInWithPopup(auth, provider)
            .then(async (result) => { 
                const user = result.user
                //save the refresh token
                 try {
                     if(user.refreshToken) {
                        const shareUri = 'https://x.com/' + result._tokenResponse.screenName
                        const id = talk('Connecting twitter')
                        const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=user_twitter_auth&user=" + walletAddress  + "&code=" + encodeURIComponent(user.refreshToken) + "&url=" + encodeURIComponent(shareUri)
                        const response = await fetch(url);
                        if (!response.ok) {
                           throw new Error("Network response was not ok");
                        }
                        const res = await response.json();
                        if(res.status) {
                            talk("Twitter connected successfully", "good", id)
                            stopTalking(3, id)
                        }
                        else {
                            talk("Unable to connect twitter account<br>Something went wrong<br>This may be due to network error","fail", id)
                            stopTalking(3, id)
                        }
                    }
                    else {
                        stopTalking(3, talk('Something went wrong', 'fail'))
                    }
                } catch (error) { console.log(error)
                    stopTalking(2.5, talk("Unable to connect twitter", 'fail'))
                }
            }).catch((error) => {
              console.log(error) 
            });
        }
        const authLinkedIn = () => {
            if(isLinkedInAuth){return;}
            window.location.href = getLinkedInUri(walletAddress)
        }
        const authGithub = () => {
            if(isGithubAuth){return;}
            window.location.href = getGithubUri(walletAddress)
        }
        setTimeout(() => {
            //setup the disp image
            //validate the image upload
            validateImageUpload('user_display_save_img', 'user_display_save_img_o', 1, (e, url) => { 
                if(e != null) {
                    //optimize the image
                    optimizeImg(url, 0.9, 400, 400).then((img) => { 
                        //update upload file
                        user_disp_image = img
                    })
                    
                }
            })
            
            
        }, 100)
    </script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>

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
    @stack('scripts')


    {{-- <script src="{{ asset('js/custom.js?v='.time()) }}"></script> --}}
    <script src="{{ asset('js/wallet.js?v='.time()) }}"></script>
    <script src="{{ asset('js/sandox.js?v='.time()) }}"></script>
    <script>
    const checkbox = document.getElementById('checkbox');
    var settingProBtn = document.getElementById('settingProBtn');
    var alertCopied = document.getElementById('alertCopied');

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
    function copyAddress(){
        alertCopied.style.display = 'block';
        setTimeout(function() {
            alertCopied.style.display = 'none';
        }, 2000); 
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