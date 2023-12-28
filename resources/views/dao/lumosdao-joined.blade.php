@extends('layouts.app')
@section('content')
<section>


    <div class="container">
        <div class="d-flex align-items-center justify-content-start flex-wrap mb-3">
            <a class="breadcrumbs" href="">
                Wallet
            </a>
            <span class="mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18px"
                    hiegth="18px">
                    <path fill-rule="evenodd"
                        d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <a class="breadcrumbs active" href="">
                GAQMEPHTYAKLASDFJHAKLJDSFHA9FAUEWN2QBWU
            </a>
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
                        <img class=""
                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Apple">
                    </div>
                    <div class="text-center w-100 card-join">
                        <div class="cardHeading text-center">
                            <span class="card-heading">GJDBS.....KJKSHS</span>
                        </div>
                        <div class="card-paragraph text-center text-secondary">
                            Member since 15 Dec 2023
                        </div>
                    </div>
                    <div class="tab w-100 mt-5">
                        <button class="tablinks " onclick="openCity(event, 'London')"
                            id="defaultOpenMob">Activity</button>
                        <button class="tablinks " onclick="openCity(event, 'Paris')">Joined <span>(5)</span></button>
                        <button class="tablinks " onclick="openCity(event, 'Tokyo')">Comments <span>(15)</span></button>
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
                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Apple">
                    </div>
                    <div class="text-center w-100 card-join">
                        <div class="cardHeading text-center">
                            <span class="card-heading">GJDBS.....KJKSHS</span>
                        </div>
                        <div class="card-paragraph text-center text-secondary">
                            Member since 15 Dec 2023
                        </div>
                    </div>
                    <div class="tab w-100 mt-5">
                        <button class="tablinks " onclick="openCity(event, 'London')" id="defaultOpen">Activity</button>
                        <button class="tablinks " onclick="openCity(event, 'Paris')">Joined <span>(5)</span></button>
                        <button class="tablinks " onclick="openCity(event, 'Tokyo')">Comments <span>(15)</span></button>
                    </div>
                </div>
                <div id="Paris" class="tabcontent col-sm">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card-join cardShow mt-4">
                                <a href="http://127.0.0.1:8000/dao/1" class="text-decoration-none">
                                    <div class="lblJoin">
                                        <p class="mb-0">join</p>
                                    </div>
                                    <div style="margin: -20px !important;" class="">
                                        <img class="h-100 w-100 rounded-md"
                                            src="https://plus.unsplash.com/premium_photo-1700984292453-732e26d205fa?w=500&amp;auto=format&amp;fit=crop&amp;q=60&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8"
                                            alt="">
                                    </div>
                                    <div class="card-joined text-center">
                                        <img class=""
                                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            alt="Apple">
                                    </div>
                                    <div class="cardHeading text-left">
                                        <span class="card-heading">Apple</span>
                                    </div>
                                    <div class="card-paragraph text-left">
                                        A tech giant renowned for its iconic products like iPhones, iPads, and Macs,
                                        Apple

                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <div class="cardCircle">
                                            <p>15</p>
                                        </div>
                                        <p class="circleP">Active propsal</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">17,23</p>
                                            <p class="card-link">Members</p>
                                        </div>
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">LSP</p>
                                            <p class="card-link">Assests</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card-join cardShow mt-4">
                                <a href="http://127.0.0.1:8000/dao/1" class="text-decoration-none">
                                    <div class="lblJoin">
                                        <p class="mb-0">join</p>
                                    </div>
                                    <div style="margin: -20px !important;" class="">
                                        <img class="h-100 w-100 rounded-md"
                                            src="https://plus.unsplash.com/premium_photo-1700984292453-732e26d205fa?w=500&amp;auto=format&amp;fit=crop&amp;q=60&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8"
                                            alt="">
                                    </div>
                                    <div class="card-joined text-center">
                                        <img class=""
                                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            alt="Apple">
                                    </div>
                                    <div class="cardHeading text-left">
                                        <span class="card-heading">Apple</span>
                                    </div>
                                    <div class="card-paragraph text-left">
                                        A tech giant renowned for its iconic products like iPhones, iPads, and Macs,
                                        Apple

                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <div class="cardCircle">
                                            <p>15</p>
                                        </div>
                                        <p class="circleP">Active propsal</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">17,23</p>
                                            <p class="card-link">Members</p>
                                        </div>
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">LSP</p>
                                            <p class="card-link">Assests</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card-join cardShow mt-4">
                                <a href="http://127.0.0.1:8000/dao/1" class="text-decoration-none">
                                    <div class="lblJoin">
                                        <p class="mb-0">join</p>
                                    </div>
                                    <div style="margin: -20px !important;" class="">
                                        <img class="h-100 w-100 rounded-md"
                                            src="https://plus.unsplash.com/premium_photo-1700984292453-732e26d205fa?w=500&amp;auto=format&amp;fit=crop&amp;q=60&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8"
                                            alt="">
                                    </div>
                                    <div class="card-joined text-center">
                                        <img class=""
                                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            alt="Apple">
                                    </div>
                                    <div class="cardHeading text-left">
                                        <span class="card-heading">Apple</span>
                                    </div>
                                    <div class="card-paragraph text-left">
                                        A tech giant renowned for its iconic products like iPhones, iPads, and Macs,
                                        Apple

                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <div class="cardCircle">
                                            <p>15</p>
                                        </div>
                                        <p class="circleP">Active propsal</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">17,23</p>
                                            <p class="card-link">Members</p>
                                        </div>
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">LSP</p>
                                            <p class="card-link">Assests</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card-join cardShow mt-4">
                                <a href="http://127.0.0.1:8000/dao/1" class="text-decoration-none">
                                    <div class="lblJoin">
                                        <p class="mb-0">join</p>
                                    </div>
                                    <div style="margin: -20px !important;" class="">
                                        <img class="h-100 w-100 rounded-md"
                                            src="https://plus.unsplash.com/premium_photo-1700984292453-732e26d205fa?w=500&amp;auto=format&amp;fit=crop&amp;q=60&amp;ixlib=rb-4.0.3&amp;ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8"
                                            alt="">
                                    </div>
                                    <div class="card-joined text-center">
                                        <img class=""
                                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                            alt="Apple">
                                    </div>
                                    <div class="cardHeading text-left">
                                        <span class="card-heading">Apple</span>
                                    </div>
                                    <div class="card-paragraph text-left">
                                        A tech giant renowned for its iconic products like iPhones, iPads, and Macs,
                                        Apple

                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <div class="cardCircle">
                                            <p>15</p>
                                        </div>
                                        <p class="circleP">Active propsal</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">17,23</p>
                                            <p class="card-link">Members</p>
                                        </div>
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">LSP</p>
                                            <p class="card-link">Assests</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="London" class="tabcontent col-sm">
                    <div class="">
                        <div class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4 mt-4">
                            <div
                                class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                                <p class="Explorer_p my-auto">GAQM...QBWU voted <span class="Explorer_p_a">Yes</span> on
                                    proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a> </p>
                                <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                            </div>
                            <div
                                class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                                <p class="Explorer_p my-auto">GAQM...QBWU voted <span class="Explorer_p_a">Yes</span> on
                                    proposal <a href="" class="Explorer_p_a"><span class="">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a> </p>
                                <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                            </div>
                            <div
                                class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                                <p class="Explorer_p my-auto">GAQM...QBWU voted <span class="Explorer_p_a">Yes</span> on
                                    proposal <a href="" class="Explorer_p_a"><span class="">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a> </p>
                                <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                            </div>
                            <div
                                class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                                <p class="Explorer_p my-auto">GAQM...QBWU voted <span class="Explorer_p_a">Yes</span> on
                                    proposal <a href="" class="Explorer_p_a"><span class="">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a> </p>
                                <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                            </div>
                            <div
                                class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                                <p class="Explorer_p my-auto">GAQM...QBWU voted <span class="Explorer_p_a">Yes</span> on
                                    proposal <a href="" class="Explorer_p_a"><span class="">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a> </p>
                                <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="Tokyo" class="tabcontent col-sm">
                    <div class="">
                        <div class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4 mt-4">
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="comment form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="comment form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="comment form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tblockokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="comment form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tblockokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="comment form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tblockokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="comment form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>
                            <div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100">
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">Utilize $10,000 (in CIR
                                            tblockokens) for social media promotion.</span></a>
                                    Since there is little to no community for Circle on social media, I suggest that we
                                    spend a total of \ 10,000$ (in CIR tokens) for social media promotion. This includes
                                    reddit promotion, shoutouts from relevant instagram and tiktok influencers and
                                    promotion on Youtube.
                                </p>
                                <div
                                    class="comment form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">GAQM...QBWU voted <span
                                            class="Explorer_p_a">Yes</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">Utilize $10,000 (in CIR
                                                tokens) for social media promotion.</span></a> </p>
                                    <p class="Explorer_span d-block">17-09-300 | 9:23 pm</p>
                                </div>
                            </div>

                            <div class="card-join cardHeading">
                                <button class="card-heading border-0 bg-transparent" id="viewAllComments">View All
                                    Comments</button>
                                <button class="card-heading border-0 bg-transparent" id="viewFewComments">View Few
                                    Comments</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
<script>
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
</script>
@endsection