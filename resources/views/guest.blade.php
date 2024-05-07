@extends('layouts.app')
@section('content')
<style>
        .panel-heading {
            width: auto;
            max-width: 100%;
            color:black;
            align-self: center;
            margin-top: 0;
            margin-bottom: 16px;
            font-family: 'MontBold';
            font-size: 50px;
            font-weight: 800;
            line-height: 70px;
            position: static;
        }

        /* .container {
            padding: 0px 200px;
        } */

        .font-semibold {
            font-family: 'MontSem';
        }

        .panel-paragraph {
            max-width: 1200px;
            text-align: left;
            align-self: center;
            margin-bottom: 8px;
            position: static;
            overflow: visible;
        }

        .btn {
            display: inline-block;
            font-family: 'MontSem';
            line-height: 1.5;
            color: white;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background: linear-gradient(to right, #FFA500, #FF4500, #FF0000);
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        *,
        *::before,
        *::after {
            -webkit-box-sizing: padding-box;
            box-sizing: padding-box;
        }

        .section-landing {
            margin-top: 150px;
        }

        .tickerwrapper {
            position: relative;
            top: 50px;
            left: 0%;
            background: #fff;
            width: 99.9%;
            height: 100px;
            overflow: hidden;
            cursor: pointer;
        }

        ul.list {
            position: relative;
            display: inline-block;
            list-style: none;
            padding: 0;
            margin: 0px 50px;
        }

        ul.list.cloned {
            position: absolute;
            top: 0px;
            left: 0px;
        }

        ul.list li {
            float: left;
            padding-left: 100px;
        }

        .lnd-slider-img {
            border-radius: 10px !important;
            box-shadow: 20px gray;
            border: 1px #cccccc solid;
        }

        .slider-container {
            max-width: 800px;
        }

        .description-container {
            position: absolute;
            bottom: 0;
            width: fit-content;
            right: 0%;
            margin-right: auto;
            max-width: 500px;
            margin-top: 0px;
        }

        .logo-lumos-font {
            color: black;
            margin-top: 20px;
            font-family: 'MontBold';
        }

        .slick-prev,
        .slick-next {
            background-color: gray;
            border-radius: 50%;
            top: 102%;
        }

        .slick-prev:hover {
            background-color: red !important;
        }

        .slick-next:hover {
            background-color: red !important;
        }

        .paragraph-slider {
            font-family: 'MontReg';
        }

        .heading-slider {
            font-family: 'MontBold';
        }

        .why-choose {
            display: flex;
            margin: 50px 0px;
        }

        .heading-2.ranking {
            width: auto;
            text-align: left;
            font-size: 30px;
            line-height: 35px;
            font-family: 'MontSem';
        }

        .why-choose li {
            font-family: 'MontReg';
            margin-top: 10px;
            flex-direction: column;
        }

        strong {
            font-family: 'MontSem';
        }

        .content-panel-getintouch.background-gradient-dark {
            min-height: auto;
            background: #f3f4f6;
            justify-content: center;
            align-items: center;
            padding-top: 160px;
            padding-bottom: 160px;
            display: flex;
        }

        .content-panel-getintouch {
            width: 100%;
            height: auto;
            min-height: 100svh;
            color: #2e2a33;
            background-color: #fff;
            margin-top: auto;
            padding: 80px 48px;
            font-family: Mulish, sans-serif;
            font-size: 18px;
            line-height: 28px;
            display: block;
            overflow: hidden;
        }

        .panel-text {
            max-width: 940px;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding-bottom: 0;
            display: flex;
        }

        .panel-paragraph.git {
            text-align: center;
        }

        .panel-paragraph {
            max-width: 1200px;
            text-align: left;
            align-self: center;
            margin-bottom: 8px;
            position: static;
            overflow: visible;
        }

        .video-lnd {
            width: 600px;
            height: 100%;
            max-width: 600px;
            height: 450px;
        }

        .relative {
            position: relative;
        }

        .isolate {
            isolation: isolate;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .bg-gray-900 {
            background-color: #1f2937;
        }

        .py-24 {
            padding-top: 6rem;
            padding-bottom: 6rem;
        }

        .sm\:py-32 {
            padding-top: 8rem;
            padding-bottom: 8rem;
        }

        .absolute {
            position: absolute;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .-z-10 {
            z-index: -10;
        }

        .h-full {
            height: 100%;
        }

        .w-full {
            width: 100%;
        }

        .object-cover {
            object-fit: cover;
        }

        .object-right {
            object-position: right;
        }

        .md\:object-center {
            object-position: center;
        }

        .hidden {
            display: none;
        }

        .-top-10 {
            top: -2.5rem;
        }

        .right-1/2 {
            right: 50%;
        }

        .mr-10 {
            margin-right: 2.5rem;
        }

        .block {
            display: block;
        }

        .transform-gpu {
            transform: translateZ(0);
        }

        .blur-3xl {
            filter: blur(1.875rem);
        }

        .aspect-[1097/845] {
            padding-bottom: 77.13%;
        }

        .w-[68.5625rem] {
            width: 1097px;
        }

        .bg-gradient-to-tr {
            background-image: linear-gradient(to top right, #ff4694, #776fff);
        }

        .opacity-20 {
            opacity: 0.2;
        }

        .clip-path {
            clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%);
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .max-w-7xl {
            max-width: 87.5rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .lg\:px-8 {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .text-4xl {
            font-size: 2.25rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .tracking-tight {
            letter-spacing: -0.025em;
        }

        .text-white {
            color: #fff;
        }

        .sm\:text-6xl {
            font-size: 3.75rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .text-lg {
            font-size: 1.125rem;
        }

        .leading-8 {
            line-height: 2rem;
        }

        .text-gray-300 {
            color: #d1d5db;
        }

        .mt-16 {
            margin-top: 4rem;
        }

        .grid {
            display: grid;
        }

        .max-w-2xl {
            max-width: 36rem;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .sm\:mt-20 {
            margin-top: 5rem;
        }

        .lg\:max-w-none {
            max-width: none;
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .lg\:gap-8 {
            gap: 2rem;
        }

        .flex {
            display: flex;
        }

        .gap-x-4> :not([hidden])~ :not([hidden]) {
            margin-left: 1rem;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }


        .p-6 {
            padding: 1.5rem;
        }

        .ring-1 {
            border-width: 1px;
        }

        .ring-inset {
            box-shadow: inset 0 0 0 var(--ring-inset-shadow-width, 0) var(--ring-inset-shadow-color, #000000);
        }

        .ring-white/10 {
            --ring-color: #fff;
            --ring-offset-shadow-color: #000000;
            --ring-inset-shadow-color: #000000;
            --ring-shadow-width: 3px;
        }

        .h-7 {
            height: 1.75rem;
        }

        .w-5 {
            width: 1.25rem;
        }

        .flex-none {
            flex: none;
        }

        .text-indigo-400 {
            color: #7f9cf5;
        }

        .viewBox {
            fill: currentColor;
            height: 1em;
            width: 1em;
        }

        .fill {
            fill: currentColor;
        }

        .clip-rule {
            fill-rule: evenodd;
        }

        .aria-hidden {
            border: 0;
            clip: rect(0 0 0 0);
            -webkit-clip-path: inset(50%);
            clip-path: inset(50%);
            height: 1px;
            overflow: hidden;
            position: absolute;
            white-space: nowrap;
            width: 1px;
        }

        .path1 {
            fill-rule: evenodd;
        }

        .M2 {
            fill: #fff;
        }

        .cls1 {
            fill-rule: evenodd;
        }

        .M3 {
            fill: #6e768f;
        }

        .M4 {
            fill: #9b9b9b;
        }

        .M5 {
            fill: #e0e0e0;
        }

        .M6 {
            fill: #fff;
        }

        .cls2 {
            fill-rule: evenodd;
        }

        .M1 {
            fill: #000;
        }

        .M7 {
            fill: #777;
        }

        .clip-rule {
            fill-rule: evenodd;
        }

        .flex {
            display: flex;
        }

        .gap-x-4> :not([hidden])~ :not([hidden]) {
            margin-left: 1rem;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .bg-white-5 {
            background-color: rgba(255, 255, 255, 0.100);
        }

        .p-6 {
            padding: 2.5rem;
        }

        .ring-1 {
            border-width: 1px;
        }

        .ring-inset {
            box-shadow: inset 0 0 0 var(--ring-inset-shadow-width, 0) var(--ring-inset-shadow-color, #000000);
        }

        .h-7 {
            height: 1.75rem;
        }

        .w-5 {
            width: 1.25rem;
        }

        .flex-none {
            flex: none;
        }

        .text-indigo-400 {
            color: #7f9cf5;
        }

        .fill {
            fill: currentColor;
        }

        .clip-rule {
            fill-rule: evenodd;
        }

        .why-choose-lumos img {
            border: 2px #dc6b19 solid;
            border-radius: 50%;
            width: 300px;
            height: 300px;
            margin: auto;
            object-fit: contain;
            box-shadow: 0 4px 6px rgba(255, 0, 0, 0.5);
            margin: 30 0px;
        }

        .feature-luma {
            background: #ffa50024;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            border: 1px solid #dc6b19;
        }

        .feature-luma img {
            border-radius: 50%;
            width: 100%;
            height: 100%;
            padding: 30px;
        }

        .feature-luma-ctn h4 {
            font-family: 'MontReg';
            font-size: 20px;
            color: black;
        }

        .feature-luma-ctn {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin: 100px 0px;
        }
        .panel-image{
            width: 100%;
            height: 100%;
            max-width: 1000px;
            height: 500px;
        }
        .color-landing{
            color:black;
        }
        @media(max-width:1200px) {
            .feature-luma-ctn {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1rem;
                margin: 100px 0px;
            }

            .container {
                padding: 0px 30px;
            }
        }

        @media (max-width: 900px) {
            .description-container {
                position: static;
                margin-top: 20px;
            }

            .feature-luma-ctn {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
                margin: 100px 0px;
            }
        }

        @media (max-width:600px) {
            .why-choose {
                flex-direction: column;
            }
            .container {
                padding: 0px 20px;
            }
            .feature-luma-ctn {
                display: grid;
                grid-template-columns: repeat(1, minmax(0, 1fr));
                gap: 1rem;
                margin: 100px 0px;
            }

            .video-lnd {
                width: 100%;
                height: 100%;
                max-width: 600px;
                height: 250px;
            }

            .panel-heading {
                font-size: 40px;
                line-height: 50px;
            }

            .section-landing {
                margin-top: 20px;
            }

            .panel-paragraph.git {
                text-align: start;
            }

            .panel-heading {
                align-self: start;
            }

            .content-panel-getintouch.background-gradient-dark {
                padding-top: 20px;
                padding-bottom: 20px;
            }
        }
    </style>
<main>
        <div class="container section-landing">
            <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center gap-5">
                <div class="">
                    <h2 class="panel-heading w-75">Decentralized Governance made simple </h2>
                    <p class="panel-paragraph w-75">Unlock the full potential of decentralized governance witr
                        LumosDAO's suite of features designed for efficiency, transparency, and community empowerment.
                    </p>
                    <button style="background: #DC6B19 !important;" class="btn">Learn more</button>
                </div>
                <div class="html-embed w-embed w-iframe">
                    <video class="video-lnd" controls>
                        <source src="{{ asset('images/raza_rizvi91-v2.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
        <div class="container section-landing">
            <h2 class="panel-heading text-center">Trusted By</h2>
            <div class="tickerwrapper">
                <ul class='list'>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/transistor-logo-gray-900.svg"
                            alt="Transistor" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/reform-logo-gray-900.svg"
                            alt="Reform" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple"
                            width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/savvycal-logo-gray-900.svg"
                            alt="SavvyCal" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/statamic-logo-gray-900.svg"
                            alt="Statamic" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/transistor-logo-gray-900.svg"
                            alt="Transistor" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/reform-logo-gray-900.svg"
                            alt="Reform" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple"
                            width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/savvycal-logo-gray-900.svg"
                            alt="SavvyCal" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/statamic-logo-gray-900.svg"
                            alt="Statamic" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/transistor-logo-gray-900.svg"
                            alt="Transistor" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/reform-logo-gray-900.svg"
                            alt="Reform" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple"
                            width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/savvycal-logo-gray-900.svg"
                            alt="SavvyCal" width="158" height="48">
                    </li>
                    <li class='listitem'>
                        <img class=" " src="https://tailwindui.com/img/logos/158x48/statamic-logo-gray-900.svg"
                            alt="Statamic" width="158" height="48">
                    </li>
                </ul>
            </div>
        </div>

        <div class="container section-landing">
            <div style="margin-top:50px;" class="container section-landing w-75 mx-auto">
                <div class="text-sm-center">
                    <h2 class="panel-heading">Core Features</h2>
                    <p class="panel-paragraph text-sm-center w-100 w-sm-75 mx-auto">Unlock the full potential of
                        decentralized
                        governance
                        with LumosDAO's suite of features designed for efficiency, transparency, and community
                        empowerment.
                        Explore our core functionalities that set the foundation for democratic decision-making.</p>
                </div>
            </div>
            <div class="feature-luma-ctn">
                <div class="bg-white shadow p-5 rounded-xl box-shadow">
                    <div class="feature-luma mx-auto">
                        <img class="mx-auto" src="{{ asset('images/undraw_voting_nvu7.svg') }}" alt="">
                    </div>
                    <h4 class="my-3 text-center">DAO Creation</h4>
                </div>
                <div class="bg-white shadow p-5 rounded-xl box-shadow">
                    <div class="feature-luma mx-auto">
                        <img class="mx-auto" src="{{ asset('images/undraw_voice_assistant_nrv7.svg') }}" alt="">
                    </div>
                    <h4 class="my-3 text-center">Asset Creation</h4>
                </div>
                <div class="bg-white shadow p-5 rounded-xl box-shadow">
                    <div class="feature-luma mx-auto">
                        <img class="mx-auto" src="{{ asset('images/undraw_gravitas_d-3-ep.svg') }}" alt="">
                    </div>
                    <h4 class="my-3 text-center">Proposal Creation</h4>
                </div>
                <div class="bg-white shadow p-5 rounded-xl box-shadow">
                    <div class="feature-luma mx-auto">
                        <img class="mx-auto" src="{{ asset('images/undraw_development_re_g5hq.svg') }}" alt="">
                    </div>
                    <h4 class="my-3 text-center">Voting</h4>
                </div>
                <div class="bg-white shadow p-5 rounded-xl box-shadow">
                    <div class="feature-luma mx-auto">
                        <img class="mx-auto" src="{{ asset('images/undraw_designer_re_5v95.svg') }}" alt="">
                    </div>
                    <h4 class="my-3 text-center">Asset Wrapping</h4>
                </div>
                <div class="bg-white shadow p-5 rounded-xl box-shadow">
                    <div class="feature-luma mx-auto">
                        <img class="mx-auto" src="{{ asset('images/undraw_design_tools_-42-tf.svg') }}" alt="">
                    </div>
                    <h4 class="my-3 text-center">Voting Power Delegation</h4>
                </div>
                <div class="bg-white shadow p-5 rounded-xl box-shadow">
                    <div class="feature-luma mx-auto">
                        <img class="mx-auto" src="{{ asset('images/undraw_creation_re_d1mi.svg') }}" alt="">
                    </div>
                    <h4 class="my-3 text-center">DAO Admin Tools</h4>
                </div>
                <div class="bg-white shadow p-5 rounded-xl box-shadow">
                    <div class="feature-luma mx-auto">
                        <img class="mx-auto" src="{{ asset('images/undraw_creation_re_d1mi.svg') }}" alt="">
                    </div>
                    <h4 class="my-3 text-center">DEFI (Upcoming)</h4>
                </div>
            </div>
        </div>
        <section class="container">
            <div class="container section-landing mx-auto">
                <div class="text-sm-center">
                    <h2 class="panel-heading">Why Choose LumosDAO?</h2>
                    <p class="panel-paragraph text-sm-center w-100 w-sm-75 mx-auto">LumosDAO offers a range of benefits
                        tailored to meet
                        the needs of both DAO members and creators, ensuring a robust, transparent, and user-friendly
                        platform for decentralized governance.</p>
                </div>
            </div>
            <div class="d-flex flex-column flex-lg-row align-items-center justify-content-around container my-5">
                <div class="why-choose-lumos">
                    <img class="" src="{{ asset('images/undraw_About_me_re_82bv.png') }}" alt="">
                    <div class="">
                        <ul class="my-5">
                            <li>
                                <h5 class="font-semibold color-landing  my-3">For DAO Creators</h5>
                            </li>
                            <li class="d-flex gap-3 my-2">
                                <svg class="h-6 w-5 flex-none text-danger" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Advance governance mechanism
                            </li>
                            <li class="d-flex gap-3 my-2">
                                <svg class="h-6 w-5 flex-none text-danger" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                DAO management tools
                            </li>
                            <li class="d-flex gap-3 my-2">
                                <svg class="h-6 w-5 flex-none text-danger" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Low fees
                            </li>
                            <li class="d-flex gap-3 my-2">
                                <svg class="h-6 w-5 flex-none text-danger" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Set up a DAO in seconds
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="why-choose-lumos">
                    <img class="" src="{{ asset('images/undraw_voting_nvu7.svg') }}" alt="">
                    <div class="">
                        <ul class="my-5">
                            <li>
                                <h5 class="font-semibold color-landing my-3">For DAO Members</h5>
                            </li>
                            <li class="d-flex gap-3 my-2">
                                <svg class="h-6 w-5 flex-none text-danger" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Easy DAO Participation
                            </li>
                            <li class="d-flex gap-3 my-2">
                                <svg class="h-6 w-5 flex-none text-danger" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Voting Power Delegation
                            </li>
                            <li class="d-flex gap-3 my-2">
                                <svg class="h-6 w-5 flex-none text-danger" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Messaging
                            </li>
                            <li class="d-flex gap-3 my-2">
                                <svg class="h-6 w-5 flex-none text-danger" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                DEFI (Coming Soon)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-panel-getintouch background-gradient-dark">
            <div class="container">
                <div class="flex flex-column flex-lg-row align-items-center justify-content-center">
                    <div class="">
                        <h2 class="panel-heading text-center">Get in touch</h2>
                        <p class="panel-paragraph git">
                            We're here to help and answer any questions you might have about LumosDAO. Whether you're
                            curious
                            about
                            decentralized governance, need assistance with the platform, or want to join our growing
                            community,
                            our team
                            is ready to connect with you.
                        </p>
                        <p class="panel-paragraph git">
                            <strong>Email Us:</strong>
                            For detailed inquiries or support, drop us an email at info@lumosdao.io we'll get back to
                            you as
                            soon as
                            possible.
                        </p>
                        <p class="panel-paragraph git">
                            <strong>Reach Out on X.com:</strong>
                            For quick questions or to follow our updates, message us directly at
                            <strong>@DAOLumos</strong>.
                            Let's start a
                            conversation!
                        </p>
                        <p class="panel-paragraph git">
                            We look forward to hearing from you and welcoming you to the LumosDAO community.
                        </p>
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <a style="background: #DC6B19 !important;" href="#" class="btn btnreg">Book a
                                demo</a>
                        </div>
                    </div>
                    <div class="">
                        <img class="panel-image" src="{{ asset('images/undraw_contact_us_re_4qqt.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </section>
    </main> 

@endsection

@push('scripts')
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Slick slider
    $('.slider').slick({
        fade: true,
        dots: true,
        infinite: true,
        speed: 500,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: true,
    });

    // Define descriptions
    var descriptions = [{
            heading: "Seamless DAO Creation",
            paragraph: "Instantly establish your DAO with customizable governance structures to suit your community’s unique needs."
        },
        {
            heading: "Transparent Proposal & Voting",
            paragraph: "Facilitate democratic decisions with our transparent proposal submission and voting mechanism, ensuring every voice is heard."
        },
        {
            heading: "Flexible Voting Power Delegation",
            paragraph: "Empower members to delegate their voting rights, enhancing participation and inclusivity within your DAO."
        },
        {
            heading: "Efficient Budget Management",
            paragraph: "Manage your DAO’s finances with clarity. Propose, vote, and allocate funds transparently within the platform."
        }
    ];

    // Update descriptions on slider change
    $('.slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $('#heading').text(descriptions[nextSlide].heading);
        $('#paragraph').text(descriptions[nextSlide].paragraph);
    });

    // Trigger 'beforeChange' event manually to display description on page load
    var currentSlide = $('.slider').slick('slickCurrentSlide');
    $('#heading').text(descriptions[currentSlide].heading);
    $('#paragraph').text(descriptions[currentSlide].paragraph);
});


var $tickerWrapper = $(".tickerwrapper");
var $list = $tickerWrapper.find("ul.list");
var $clonedList = $list.clone();
var listWidth = 10;

$list.find("li").each(function(i) {
    listWidth += $(this, i).outerWidth(true);
});

var endPos = $tickerWrapper.width() - listWidth;

$list.add($clonedList).css({
    "width": listWidth + "px"
});

$clonedList.addClass("cloned").appendTo($tickerWrapper);
var infinite = new TimelineMax({
    repeat: -1,
    paused: true
});
var time = 40;

infinite
    .fromTo($list, time, {
        rotation: 0.01,
        x: 0
    }, {
        force3D: true,
        x: -listWidth,
        ease: Linear.easeNone
    }, 0)
    .fromTo($clonedList, time, {
        rotation: 0.01,
        x: listWidth
    }, {
        force3D: true,
        x: 0,
        ease: Linear.easeNone
    }, 0)
    .set($list, {
        force3D: true,
        rotation: 0.01,
        x: listWidth
    })
    .to($clonedList, time, {
        force3D: true,
        rotation: 0.01,
        x: -listWidth,
        ease: Linear.easeNone
    }, time)
    .to($list, time, {
        force3D: true,
        rotation: 0.01,
        x: 0,
        ease: Linear.easeNone
    }, time)
    .progress(1).progress(0)
    .play();
$tickerWrapper.on("mouseenter", function() {
    infinite.pause();
}).on("mouseleave", function() {
    infinite.play();
});
</script>
@endpush