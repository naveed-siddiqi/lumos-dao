@extends('layouts.app')
@section('content')
<section>

    <?php /* Load userinfo */
    $path = substr(__FILE__, 0, strpos(__FILE__, 'storage'));
    require("$path.well-known/config.php");
    require("$path.well-known/db.php");
    $parts = explode("/", $_SERVER['REQUEST_URI']);
    // Get the last part which is the Stellar address
    $uAddress = end($parts);
    if($uAddress){
        $user = $uAddress;
        $query = "SELECT * FROM users WHERE wallet='$user'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            $user =  mysqli_fetch_array($result);
        }
        else{$user = array();}
        }
    ?>
    <div class="container">
        <div class="d-flex align-items-center justify-content-start flex-wrap mb-3">
            <a class="breadcrumbs" href="">
                User
            </a>
            <span class="mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18px"
                    hiegth="18px">
                    <path fill-rule="evenodd"
                        d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                        clip-rule="evenodd" />
                </svg>
            </span>
<<<<<<< HEAD
            <a class="breadcrumbs active" href="" id='wallet_name'>

            </a>
=======
            <a class="breadcrumbs active" href="" id='wallet_name'></a>
>>>>>>> 9270b47 (added new UI updates)
        </div>
        <div class="">
            <button class="bg-none border-danger rounded px-2 d-block d-xl-none text-danger" id="sideover-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" width="25px" height="px">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                </svg>
            </button>
            <div class="">
                <div class="" id="sideover_menubar">
                    <button id="sideover_close_btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" width="25px" height="25px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </button>
                    <div class="tabs-logo">
                        <img class="" id='user_img_short'
                            src="<?php if(isset($user['image'])){echo $user['image'] . '?id=' . rand();}else {echo 'https://id.lobstr.co/'. $_COOKIE['public'] . '.png?id=' . rand();} ?>"
                            alt="Apple">
                    </div>
                    <div class="text-center w-100 card-join pt-4">
                        <div class="cardHeading text-center">
                            <span class="card-heading" id='wallet_name_short'> </span>
                        </div>
                        <div class="card-paragraph text-center text-secondary line-climb-3" id='wallet_joined_date'>

                        </div>
                    </div>
                    <div class="tab w-100 mt-5">
                        <button class="tablinks " onclick="openCity(event, 'London')"
                            id="defaultOpenMob">Activity</button>
                        <button class="tablinks " onclick="openCity(event, 'Paris')">Joined <span
                                id='wallet_dao_num'></span></button>
                        <button class="tablinks " onclick="openCity(event, 'Tokyo')">Comments <span
                                id='wallet_comment_num'></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div
                    class="col-sm-3 explorer_card d-none d-xl-flex justify-content-start m-0 align-items-start h-screen mt-4 sticky-top">
                    <div class="tabs-logo">
                        <img class=""
                            id='user_img'
                            src="<?php if(isset($user['image'])){echo $user['image'] . '?id=' . rand();}else {echo 'https://id.lobstr.co/'. $_COOKIE['public'] . '.png?id=' . rand();} ?>"
                            alt="Apple">
                    </div>
                    <div class="text-center w-100 card-join py-3">
<<<<<<< HEAD
                        <div class="card-heading">Handshake</div>
                        <div class="cardHeading text-center d-flex align-items-center justify-content-center gap-2">
                            <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="font-medium" id='wallet_name_short_res'></span>
                            </button>
                            <div class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                <div class="">
                    <div class="">
                        <img style="width: 50px !important; height: 50px !important; justify-content: left;" class="w-img mr-auto"
                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Apple">
                    </div>
                    <div class="text-start w-100 card-join py-2">
                        <div class="font-medium">Handshake</div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="cardHeading text-left d-flex align-items-center justify-content-left gap-3 ml-0 text-secondary">
                                <span class="font-normal">SDAF....AJAF</span>
                                <span>
                                    <svg width="20px" heigth="20px " xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button class="btn p-0 m-0">
                                    <img class="w-img-user" src="{{asset('/images/x.webp')}}" alt="">
                                </button>
                                <button class="btn p-0 m-0">
                                    <img class="w-img-user" src="{{asset('/images/download.jpeg')}}" alt="">
                                </button>
                                <button class="btn p-0 m-0">
                                    <img class="w-img-user" src="{{asset('/images/download.png')}}" alt="">
                                </button>
                                <button class="btn p-0 m-0">
                                    <img class="w-img-user" src="{{asset('/images/Reddit.png')}}" alt="">
                                </button>
                            </div>
                        </div>
                        <div class="asset-details-text mt-3 line-climb-3 font-normal text-secondary">Lorem ipsum dolor sit amet consectetur,
                            adipisicing elit. Optio eos quibusdam dolores quia, temporibus incidunt, quod iure
                            doloremque ut necessitatibus officiis, error reiciendis cum. Ex accusantium incidunt veniam
                            delectus quam.</div>
                        <div class="border-t font-sm d-flex align-items-center justify-content-between mt-4">
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <span>DAOs</span>
                                <span>3</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <span>Proposals</span>
                                <span>304</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <span>Votes</span>
                                <span>23</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <span>comments</span>
                                <span>1</span>
=======
                        <div class="card-heading" id='user_name'><?php 
                                            if(isset($user['name'])) {
                                                if($user['name'] != "") {
                                                    echo $user['name'];
                                                }
                                            }
                                        ?>
                        </div>
                        <div class="cardHeading text-center d-flex align-items-center justify-content-center gap-2">
                            <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" aria-haspopup="true"
                                aria-expanded="false">
                                <span class="font-medium" id='wallet_name_short_res'>
                                        
                                </span>
                            </button>
                            <div class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                <div class="">
                    <div class="">
                        <img style="width: 50px !important; height: 50px !important; justify-content: left;" class="w-img mr-auto"
                            id = "user_img_long"
                            src="<?php if(isset($user['image'])){echo $user['image'] . '?id=' . rand();}else {echo 'https://id.lobstr.co/'. $_COOKIE['public'] . '.png?id=' . rand();} ?>"
                            alt="Apple" 
                            >
                    </div>
                    <div class="text-start w-100 card-join py-2">
                        <div class="font-medium" id='user_name_short'>
                            <?php 
                                            if(isset($user['name'])) {
                                                if($user['name'] != "") {
                                                    echo $user['name'];
                                                }
                                            }
                                        ?>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="cardHeading text-left d-flex align-items-center justify-content-left gap-3 ml-0 text-secondary">
                                <span class="font-normal" id='wallet_name_main'></span>
                                <span  style='cursor:pointer'>
                                    <svg width="20px" heigth="20px " xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button class="btn p-0 m-0" id='user_twitter_nav' style='display:none'>
                                    <img class="w-img-user" src="{{asset('/images/x.webp')}}" alt="">
                                </button>
                                <button class="btn p-0 m-0" id='user_github_nav' style='display:none'>
                                    <img class="w-img-user" src="{{asset('/images/github.png')}}" alt="">
                                </button>
                                <button class="btn p-0 m-0" style='display:none'>
                                    <img class="w-img-user" src="{{asset('/images/download.png')}}" alt="">
                                </button>
                                <button class="btn p-0 m-0" style='display:none'>
                                    <img class="w-img-user" src="{{asset('/images/Reddit.png')}}" alt="">
                                </button>
                            </div>
                        </div>
                        <div class="asset-details-text mt-3 line-climb-3 font-normal text-secondary" id='user_bio_short'><?php 
                    if(isset($user['bio'])) {
                        if($user['bio'] != "") {
                            echo $user['bio'];
                        }
                    }
                ?></div>
                        <div class="border-t font-sm d-flex align-items-center justify-content-between mt-4">
                            <div class="d-flex align-items-center justify-content-center flex-column" style='margin-left:10px'>
                                <span>DAOs</span>
                                <span id='wallet_dao_num_res_short'>0</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center flex-column" style='margin-left:10px'>
                                <span>Proposals</span>
                                <span id='wallet_proposal_num_res_short'>0</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center flex-column" style='margin-left:10px'>
                                <span>Votes</span>
                                <span id='wallet_votes_num_res_short'>0</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center flex-column" style='margin-left:10px'>
                                <span>comments</span>
                                <span id='wallet_comment_num_res_short'>0</span>
>>>>>>> 9270b47 (added new UI updates)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD
                            <span>
=======
                            <span onclick='copyWalletAddress()'>
>>>>>>> 9270b47 (added new UI updates)
                            <svg width="20px" heigth="20px " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                            </svg>
                            </span>
                        </div>
<<<<<<< HEAD
                        <div class="asset-details-text mt-2 line-climp-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Optio eos quibusdam dolores quia, temporibus incidunt, quod iure doloremque ut necessitatibus officiis, error reiciendis cum. Ex accusantium incidunt veniam delectus quam.</div>
                        <div class="d-flex align-items-center justify-content-center mt-4">
                           <button class="btn">
                           <img class="w-img" src="{{asset('/images/x.webp')}}" alt="">
                           </button>
                           <button class="btn">
                           <img class="w-img" src="{{asset('/images/download.jpeg')}}" alt="">
                           </button>
                           <button class="btn">
                           <img class="w-img" src="{{asset('/images/download.png')}}" alt="">
                           </button>
                           <button class="btn">
=======
                        <div class="asset-details-text mt-2 line-climp-3" id='user_bio'>
                            <?php 
                                if(isset($user['bio'])) {
                                    if($user['bio'] != "") {
                                        echo $user['bio'];
                                    }
                                }
                            ?>
                        </div>
                         <div class="">
                            <button class="btn btn-success my-2" id='user_inbox'>Send Message</button>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mt-4">
                           <button class="btn" id='user_twitter_nav_short' style='display:none'>
                           <img class="w-img" src="{{asset('/images/x.webp')}}" alt="">
                           </button>
                           <button class="btn" id='user_github_nav_short' style='display:none'>
                           <img class="w-img" src="{{asset('/images/github.png')}}" alt="">
                           </button>
                           <button class="btn" style='display:none'>
                           <img class="w-img" src="{{asset('/images/download.png')}}" alt="">
                           </button>
                           <button class="btn" style='display:none'>
>>>>>>> 9270b47 (added new UI updates)
                           <img class="w-img" src="{{asset('/images/Reddit.png')}}" alt="">
                           </button>
                        </div>
                    </div>
                    <div class="tab w-100 mt-5">
                        <button class="tablinks " onclick="openCity(event, 'London')" id="defaultOpen">Activity</button>
                        <button class="tablinks " onclick="openCity(event, 'Paris')">Joined <span
                                id='wallet_dao_num_res'></span></button>
                        <button class="tablinks " onclick="openCity(event, 'Tokyo')">Comments <span
                                id='wallet_comment_num_res'></span></button>
                        <button class="tablinks " onclick="openCity(event, 'newYork1')">Delegates <span
<<<<<<< HEAD
                                id='wallet_comment_num_res'></span></button>
=======
                                id='wallet_delegate_num_res'></span></button>
>>>>>>> 9270b47 (added new UI updates)
                    </div>
                    <div class="card-paragraph text-center text-secondary line-climb-3 h-100 d-flex align-items-end justify-content-end flex-grow-1" id='wallet_joined_date_res'>
                            <center class='cen' style='height:300px;'>Loading Daos...</center>
                        </div>
                </div>
                <div id="Paris" class="tabcontent col-sm">
                    <div class="row" id='wallet_my_dao'>
                        <center class='cen' style='margin:50px'>Loading Daos...</center>
                    </div>
                </div>
                <div id="London" class="tabcontent col-sm">
                    <div class="">
                        <div class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4 mt-4">
                            <div style='width:100%' id='tx_info'>
                                <center style='margin:20px'>Loading records..</center>
                            </div>
                            <div class='d-flex' style='flex-direction:row-reverse;width:100%'>
                                <button id='next_tx_info' class='btn' style='display:none'>Next</button>
                                <button id='pre_tx_info' class='btn' style='display:none'>Prev</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="Tokyo" class="tabcontent col-sm">
                    <div class="">
                        <div class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4 mt-4">
                            <div id='wallet_my_comment' style='width:100%'>
                                <center class='cen' style='margin:50px'>Loading Comments...</center>
                            </div>
                            <div class="card-join cardHeading" id='wallet_my_comment_butt' style='display:none'>
                                <button class="card-heading border-0 bg-transparent" id="viewAllComments">View All
                                    Comments</button>
                                <button class="card-heading border-0 bg-transparent" id="viewFewComments">View Few
                                    Comments</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="newYork1" class="tabcontent col-sm">
                    <div class="tab-pane explorer_card text-left h-auto px-3 px-sm-4 pt-4 pb-4 mt-4">
                        <div class="row mt-0 w-100">
                            <div class="cardEndDiv p-0">
<<<<<<< HEAD
                                <div class="w-100">
                                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-end gap-4">
                                        <div class="d-flex flex-column gap-2">
                                            <span class="text text-sm text-secondary text-start">Delegates</span>
                                            <div class="cardEndDetail">
                                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                    alt="Profile Image" class="image">
                                                <div class="text text-center">FGDKXQ.....ZANU3I
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <span class="text text-sm text-secondary text-start">DAO</span>
                                            <div class="cardEndDetail">
                                                <img src="{{ asset('/images/apple.png') }}"
                                                    alt="Profile Image" class="image">
                                                <div class="text text-center">APPle</div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <button type="button"
                                                class="btn btn-danger text-white text d-flex align-items-center gap-2 mb-0">
                                                Stop Delegation
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
=======
                                <div class="w-100" id='user_delegates_view'>
                                    <center style='margin: 40px 20px'>Loading delegates...</center>
                                    <!--<div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-end gap-4">-->
                                    <!--    <div class="d-flex flex-column gap-2">-->
                                    <!--        <span class="text text-sm text-secondary text-start">Delegates</span>-->
                                    <!--        <div class="cardEndDetail">-->
                                    <!--            <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"-->
                                    <!--                alt="Profile Image" class="image">-->
                                    <!--            <div class="text text-center">FGDKXQ.....ZANU3I-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--    <div class="d-flex flex-column gap-2">-->
                                    <!--        <span class="text text-sm text-secondary text-start">DAO</span>-->
                                    <!--        <div class="cardEndDetail">-->
                                    <!--            <img src="{{ asset('/images/apple.png') }}"-->
                                    <!--                alt="Profile Image" class="image">-->
                                    <!--            <div class="text text-center">APPle</div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--    <div class="">-->
                                    <!--        <button type="button"-->
                                    <!--            class="btn btn-danger text-white text d-flex align-items-center gap-2 mb-0">-->
                                    <!--            Stop Delegation-->
                                    <!--            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"-->
                                    <!--                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">-->
                                    <!--                <path stroke-linecap="round" stroke-linejoin="round"-->
                                    <!--                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />-->
                                    <!--            </svg>-->
>>>>>>> 9270b47 (added new UI updates)

                                    <!--        </button>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <style>
        .cen {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        </style>
    </div>
</section>
<script>
<<<<<<< HEAD
const uWallet = (new URL(window.location.href)).searchParams.get('x') ||
walletAddress; // Use your actual URL or replace with the desired URL
let tx_page_segment = 10;
let txInfo = []
let tx_page = 1;
=======
const uWallet = (window.location.href.substring(window.location.href.lastIndexOf("/") + 1)) || walletAddress; // Use your actual URL or replace with the desired URL
let tx_page_segment = 10;
let txInfo = []
let tx_page = 1;
var userInfo = null; var user_delegates = []
>>>>>>> 9270b47 (added new UI updates)

const setUp = async () => {
    //set name
    E('wallet_name').innerHTML = uWallet
<<<<<<< HEAD
    E('wallet_name_short').innerHTML = E('wallet_name_short_res').innerHTML = uWallet.substring(0, 5) +
        "....." + uWallet.substring(uWallet.length - 5)
    let joined = await getDaoJoinedDate(uWallet);
    if (joined != "") {
        joined = (new Date(joined)).toLocaleString()
        E('wallet_joined_date').innerHTML = E('wallet_joined_date_res').innerHTML = "Member since " + joined
    }

    //get user comments
    const comt = await getUserComment(uWallet)
    const [num, daos] = await getDaoJoinedNum(uWallet)
    E('wallet_dao_num').innerHTML = E('wallet_dao_num_res').innerHTML = '(' + num + ')'
    const cnum = await getCommentNum(uWallet)
    E('wallet_comment_num').innerHTML = E('wallet_comment_num_res').innerHTML = '(' + cnum + ')'
    //load comment
    setTimeout(() => {
        loadComments(comt)
    }, 1000)
    //load daos
    setTimeout(() => {
        loadDao(daos)
    }, 1000)
    //load activity
    setTimeout(() => {
        loadActivity()
    }, 1000)

=======
    E('wallet_name_short').innerHTML = E('wallet_name_short_res').innerHTML = E('wallet_name_main').innerHTML =  uWallet.substring(0, 5) + "....." + uWallet.substring(uWallet.length - 5)
    E('user_inbox').onclick = () => {window.location.href = "{{route('proposal.inbox')}}" + "?to=" + uWallet}
    //load activity
    setTimeout(() => {
        loadActivity()
    }, 5)
    userInfo = await getUserInfo(uWallet); 
    const userMeta = await getUserMeta(uWallet)
    //setting up user meta info
    E('wallet_proposal_num_res_short').innerHTML =  '(' + userMeta['proposals'].toLocaleString() + ')'
    E('wallet_votes_num_res_short').innerHTML =  '(' + userMeta['votes'].toLocaleString() + ')'
    
    //set the user info
    if(userInfo.status) {
        //set the name
        userInfo = userInfo['user']
        E('user_name').innerHTML  = E('user_name_short').innerHTML = userInfo['name'] || ""
        E('user_bio').innerHTML = E('user_bio_short').innerHTML = userInfo['bio'] || ""
        E('user_img').src = E('user_img').src = E('user_img_long').src =  (userInfo['image'] || ("https://id.lobstr.co/" + uWallet + ".png")) + "?id=" + Math.random() * 100
        //fix the socials
        if(userInfo['twitter'] != "") {
            E('user_twitter_nav_short').style.display = E('user_twitter_nav').style.display = 'flex'
            E('user_twitter_nav_short').onclick = E('user_twitter_nav').onclick = () => {window.open(userInfo['twitter_url'], 'blank')}
        }
         if(userInfo['github'] != "") {
            E('user_github_nav_short').style.display = E('user_github_nav').style.display = 'flex'
            E('user_github_nav_short').onclick = E('user_github_nav').onclick = () => {window.open(userInfo['github_url'], 'blank')}
        }
    }
    let joined = await getDaoJoinedDate(uWallet);
    if (joined != "") {
        joined = (new Date(joined)).toLocaleString()
        E('wallet_joined_date').innerHTML = E('wallet_joined_date_res').innerHTML = "Member since " + joined
    }
    //get user comments
    const comt = await getUserComment(uWallet)
    const [num, daos] = await getDaoJoinedWithInfo(uWallet)
    
    E('wallet_dao_num').innerHTML = E('wallet_dao_num_res').innerHTML = E('wallet_dao_num_res_short').innerHTML =  '(' + num.toLocaleString() + ')'
    const cnum = await getCommentNum(uWallet)
    E('wallet_comment_num').innerHTML = E('wallet_comment_num_res').innerHTML = E('wallet_comment_num_res_short').innerHTML =  '(' + cnum.toLocaleString() + ')'
    
    //load comment
    setTimeout(() => {
        loadComments(comt)
    }, 10)
    //load daos
    setTimeout(() => {
        loadDao(daos)
        loadUserDelegates(daos)
    }, 50)
    
>>>>>>> 9270b47 (added new UI updates)
}
//load comment
const loadComments = async (comt) => {
    E('wallet_my_comment_butt').style.display = 'none'
    let _commt = "";
    if (comt.length > 0) {
        let props = []
        for (let i = 0; i < comt.length; i++) {
            const res = JSON.parse(comt[i])
            if (!props[res.proposal_id]) {
                //hasnt loaded proposal data, load it
                props[res.proposal_id] = await getProposal(res.proposal_id)
                if (props[res.proposal_id] !== false) {
                    res['proposalName'] = props[res.proposal_id].name
                    res['voted'] = await getProposalVoterInfo(res.proposal_id * 1, uWallet)
                    res['voted'] = (res['voted'] == 0) ? "none" : (res['voted'] == 1) ? 'Yes' : 'No';
                }
            } else {
                if (props[res.proposal_id] !== false) {
                    res['proposalName'] = props[res.proposal_id].name
                    res['voted'] = await getProposalVoterInfo(res.proposal_id, uWallet)
                    res['voted'] = (res['voted'] == 0) ? "none" : (res['voted'] == 1) ? 'Yes' : 'No';
                }
            }
            const commt = drawComment(res, (i > 4) ? true : false)
            _commt += commt
            if (i > 4) {
                E('wallet_my_comment_butt').style.display = 'flex'
            }
        }
        //console.log(_commt)
        E('wallet_my_comment').innerHTML = _commt
    } else {
        E('wallet_my_comment').innerHTML =
            "<center class='cen' style='margin:50px'>You have not made any comments</center>"
    }
}
//load daos
<<<<<<< HEAD
const loadDao = async (daos) => {
    //load all the daos
    let _daos = "";
    for (let i = 0; i < daos.length; i++) {
        _daos += await drawDao((await getDao(daos[i])))
    }
    if (daos.length == 0) {
        E('wallet_my_dao').innerHTML =
            "<center class='cen' style='margin:50px'>You have not joined any dao</center>"
    } else {
        E('wallet_my_dao').innerHTML = _daos
=======
const loadDao = async (daos) => {  
    //load all the daos
    const actual_daos = await getDaoMetadata()
    let tdaos = fArr(daos.map((e) => {
        if(actual_daos['daos'].includes(e.token)){
            return e.token
        }
    }))
    let _daos = await getDao(tdaos); let daoView = ""
    for (let i = 0; i < tdaos.length; i++) {
        daoView += await drawDao(_daos[tdaos[i]])
    }
    if (daos.length == 0) {
        E('wallet_my_dao').innerHTML = "<center class='cen' style='margin:50px'>You have not joined any dao</center>"
    } else {
        E('wallet_my_dao').innerHTML = daoView
>>>>>>> 9270b47 (added new UI updates)
    }

}
//load user activity
const loadActivity = async () => {
    //get all the tx
    txInfo = await getAllUsersTx(walletAddress)
    let j = []
    for (let i = txInfo.length - 1; i > -1; i--) {
        const t = JSON.parse(txInfo[i])
        if (t.action.toLowerCase().indexOf('joined dao') > -1) {
            if (!j.includes(t.signer)) {
                //first
                t.action = 'Joined LumosDao'
                txInfo.splice(i + 1, 0, JSON.stringify(t));
                j.push(t.signer)
            }
        }
    }
    loadTxInfo()
    //configure the buttons
    E('next_tx_info').onclick = () => {
        if (tx_page < txInfo.length / tx_page_segment) {
            loadTxInfo(tx_page + 1)
            tx_page++
        }
    }
    E('pre_tx_info').onclick = () => {
        if (tx_page > 1) {
            loadTxInfo(tx_page - 1)
            tx_page--
        }
    }
}
const loadTxInfo = (page = 1) => {
    //to do pagination, segment is 10
    const start_index = (page - 1) * tx_page_segment;
    const end_index = start_index + tx_page_segment
    //reset view
    E('tx_info').innerHTML = ""
    //console.log(txInfo)
    for (let i = start_index; i < end_index && i < txInfo.length; i++) {
        E('tx_info').appendChild(drawExp({
            address: JSON.parse(txInfo[i]).signer,
            action: JSON.parse(txInfo[i]).action,
            date: (new Date(JSON.parse(txInfo[i]).date)).toLocaleString(),
<<<<<<< HEAD
            link: ""
=======
            link:window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/" + JSON.parse(txInfo[i]).data,
            hash:JSON.parse(txInfo[i]).hash || ""
>>>>>>> 9270b47 (added new UI updates)
        }))
    }

    if (end_index >= txInfo.length) {
        //hide next button
        E('next_tx_info').style.display = 'none'
    } else {
        E('next_tx_info').style.display = 'block'
    }
    if (start_index == 0) {
        //hide next button
        E('pre_tx_info').style.display = 'none'
    } else {
        E('pre_tx_info').style.display = 'block'
    }
    //handle empty txs
    if (E('tx_info').firstElementChild == null) {
        //show empty view
        E('tx_info').innerHTML = `<center style="margin:50px;">No records yet</center>`
    }

}
<<<<<<< HEAD
//start
setUp()

const drawDao = async (daoParams = {}) => {
    const coverImgx = daoParams.image.replace((daoParams.code + daoParams.owner), "cover_" + (daoParams.code +
        daoParams.owner));
    const isCoverValid = await isImageURLValid(coverImgx)
    const defCoverImg =
        'https://images.unsplash.com/photo-1513151233558-d860c5398176?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'

=======
//load user delegatess
const loadUserDelegates = async (daos) => {
    for(let i=0;i<daos.length;i++) {
        //fetch the delegatee info
        const delegate = await getDaoDelegatee(daos[i].token, uWallet)
        if(delegate.length > 0) {
            //append to prexisting delegates
            user_delegates.push({...daos[i], ...{delegate:delegate[i]} })
            //do the paginate text
            paginate('user_delegates_view', user_delegates, 20, drawDelegates)
        }
    }
    paginate('user_delegates_view', user_delegates, 20, drawDelegates)
    E('wallet_delegate_num_res').innerHTML = `(${user_delegates.length})`
}
//to reclaim delegation
const reclaimDelegate = async (del_address, dao, index) => {
    const id = talk("Reclaiming voting power from " + fAddr(del_address, 6))
    const res = await addDelegate({
        delegatee: uWallet,
        del_address:del_address,
        dao: dao
    })
    if (res !== false) {
        stopTalking(3, talk("Reclaimed voting power from " + fAddr(del_address, 6), 'good', id))
        user_delegates[index] = null
        //shuffle array
        user_delegates = fArr(user_delegates);
        //reload results
        paginate('user_delegates_view', user_delegates, 20, drawDelegates)
        E('wallet_delegate_num_res').innerHTML = `(${user_delegates.length})`
    } else {
        stopTalking(3, talk("Unable to reclaim voting power from " + fAddr(del_address, 6) + '<br>Something went wrong', 'fail', id))
    }
}
const copyWalletAddress = () => {
    copyLink(uWallet)
}
//start
setUp()

const drawDao = async (daoParams = {}) => {  
    //fetch all the active proposals
    if(daoParams.proposals.length > 0) {
        const props = await getAllProposal(daoParams.proposals, daoParams.token)
        daoParams.active_proposals = 0
        for(let i=0;i<daoParams.proposals.length;i++) {
            if(props[daoParams.proposals[i]].status == 1) {
                daoParams.active_proposals++
            }   
        }
    }
>>>>>>> 9270b47 (added new UI updates)
    let tm = `<div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card-join cardShow mt-4">
                                <a href="{{ route('dao', '') }}/${daoParams.token || ""}" class="text-decoration-none">
                                    <div class="lblJoin">
                                        <p class="mb-0">Joined</p>
                                    </div>
                                    <div style="margin: -20px !important;" class="">
                                        <img style="height:200px;object-fit:cover;" class="w-100 rounded-md"
                                            src="${daoParams.cover}"
                                            alt="">
                                    </div>
                                    <div class="card-joined text-center">
                                        <img class=""
                                            src="${daoParams.image}"
                                            alt="Apple">
                                    </div>
                                    <div class="cardHeading text-left">
                                        <span class="card-heading">${daoParams.name || ""}</span>
                                    </div>
                                    <div style="min-height:140px;" class="card-paragraph text-left line-climb-3">
                                         ${daoParams.description || ""}
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <div class="cardCircle">
                                            <p>${daoParams.active_proposals || 0}</p>
                                        </div>
                                        <p class="circleP">Active ${(daoParams.proposals || 0) > 1 ? "proposal" : "proposals"}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">${daoParams.members || 0}</p>
                                            <p class="card-link">${(daoParams.members || 0) > 1 ? "Members" : "Member"}</p>
                                        </div>
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">${daoParams.code}</p>
                                            <p class="card-link">Assest</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>`


    return tm

}
const drawExp = (params = {}) => {
<<<<<<< HEAD
    let tm = `<div
=======
      let tm = `<div
>>>>>>> 9270b47 (added new UI updates)
                    class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                    <p class="Explorer_p my-auto">${params.address.substring(0, 5) + "....." + params.address.substring(params.address.length - 5)} <a
                            class="Explorer_p_a" href="${params.link}"><span class="">${params.action}</span></a> </p>
                    <div class="d-flex align-items-center justify-content-end gap-2">
                    <p class="Explorer_span d-block">${params.date}</p>
                   <div class="Explorer_p_a my-auto" style='display:${(params.hash != "") ? "" : 'none'}'><a target='_blank' href="https://testnet.steexp.com/tx/${params.hash}">View on Explorer</a></div>
                    </div>
                </div>`
<<<<<<< HEAD
    let th = document.createElement('div')
    th.innerHTML = tm
    return th.firstElementChild
}
const drawComment = (params, hide = false) => {
    let th = `<div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100" style='display:${(hide == true) ? 'none': ""}'>
                                <p class="Explorer_p my-auto">
=======
        let th = document.createElement('div')
        th.innerHTML = tm
        return th.firstElementChild
    
}
const drawComment = (params, hide = false) => {
    let th = `<div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100" style='display:${(hide == true) ? 'none': ""}'>
                                <p style="color:#6c757d !important; font-family:'MontReg" class="Explorer_p my-auto">
>>>>>>> 9270b47 (added new UI updates)
                                    <a class="Explorer_p_a" href=""><span class="d-block">${params.proposalName || ""}</span></a>
                                    ${params.msg || ""}
                                </p>
                                <div
                                    class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                   <div class="d-flex gap-3 align-items-center">
                                   <img class="w-img" src="${API_URL + 'user_img&user=' + uWallet}"
                                        alt="Profile Image" class="image">
                                    <p class="Explorer_p my-auto">${fAddr(uWallet, 7)} voted <span
                                            class="Explorer_p_a">${params.voted || "none"}</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">${params.proposalName || ""}</span></a> </p>
                                   </div>
                                    <p class="Explorer_span d-block">${params.date || ""}</p>
                                </div>
                            </div>
                         `

    return th
}
<<<<<<< HEAD
=======
const drawDelegates = (params, index) => {
    return `    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-end gap-4">
                                        <div class="d-flex flex-column gap-2">
                                            <span class="text text-sm text-secondary text-start">Delegates</span>
                                            <div class="cardEndDetail">
                                                <img src="${API_URL + "user_img&user=" + params.delegate}"
                                                    alt="Profile Image" class="image">
                                                <div class="text text-center">${fAddr(params.delegate, 7)}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <span class="text text-sm text-secondary text-start">DAO</span>
                                            <div class="cardEndDetail">
                                                <img src="${params.image}"
                                                    alt="Profile Image" class="image">
                                                <div class="text text-center">${params.name}</div>
                                            </div>
                                        </div>
                                        <div class="${!(walletAddress == uWallet) ? 'd-none' : ''}">
                                            <button type="button" onclick='reclaimDelegate("${params.delegate}", "${params.token}", ${index})'
                                                class="btn btn-danger text-white text d-flex align-items-center gap-2 mb-0">
                                                Reclaim Delegation
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>

                                            </button>
                                        </div>
                                    </div>
                                `
}
>>>>>>> 9270b47 (added new UI updates)
/* Page Utilities */
{
    let sideOverBtn = document.getElementById('sideover-btn');
    let sideOverCloseBtn = document.getElementById('sideover_close_btn');
    let sideOver = document.getElementById('sideover_menubar');
    sideOver.style.display = 'none';
    sideOverBtn.addEventListener('click', () => {
        sideOver.style.display = 'block';
        document.getElementById("defaultOpenMob").click();
    });
    sideOverCloseBtn.addEventListener('click', () => {
        sideOver.style.display = 'none';
    });

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    document.getElementById("defaultOpen").click();


    document.addEventListener('DOMContentLoaded', function() {
        var comments = document.querySelectorAll('.comment');
        var viewAllButton = document.getElementById('viewAllComments');
        var viewFewButton = document.getElementById('viewFewComments');
        viewFewButton.style.display = 'none';

        // Hide comments after the first four initially
        for (var i = 5; i < comments.length; i++) {
            comments[i].style.display = 'none';
        }

        viewAllButton.addEventListener('click', function() {
            // Show all comments
            for (var i = 5; i < comments.length; i++) {
                comments[i].style.display = 'block';
            }
            // Hide the "View All Comments" button and show the "View Few Comments" button
            viewAllButton.style.display = 'none';
            viewFewButton.style.display = 'block';
        });

        viewFewButton.addEventListener('click', function() {
            // Hide comments after the first four
            for (var i = 5; i < comments.length; i++) {
                comments[i].style.display = 'none';
            }
            // Show the "View All Comments" button and hide the "View Few Comments" button
            viewAllButton.style.display = 'block';
            viewFewButton.style.display = 'none';
        });
    });
}
</script>
@endsection