@extends('layouts.app')

@section('content')
    <section class="firstSection">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="mainIntro">
                        <h1>Build Better, <br>Together</h1>
                        <p>Welcome to LumosDAO - Revolutionizing Decentralized Governance on the Stellar Network. Create, manage, and participate in DAOs seamlessly, with transparency and efficiency.</p>
                    </div>
                    <div class="mainIntroBtn">
                        <a class="firstBtn" href="javascript:;">What is a DAO?</a>
                        <a class="SecondBtn" href="javascript:;">Launch your DAO</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="firstImg">
                        <img class="" src="{{ asset('images/image1.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ScndSection">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="scndImg">
                        <img src="{{ asset('images/scndImg.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="ScndIntro">
                        <h1>About Lumos DAO</h1>
                        <p>LumosDAO is a powerful and user-friendly platform designed to bridge Stellar-based projects with the world of decentralized autonomous organizations (DAOs). Our platform empowers DAO creators and members to actively participate in shaping the future of their projects. LumosDAO is more than just a platform—it's the catalyst for Stellar's decentralized revolution.</p>
                    </div>
                    <div class="sndIntroBtn">
                        <a class="bgBtn" href="javascript:;">Launch your DAO</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="thirdSec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="ScndIntro third">
                        <h1>The best way to<br>build your DAO</h1>
                        <p>With LumosDAO, creating and managing a DAO is simple and straightforward. Here are some features that set us apart:</p>

                        <strong>1. Seamless DAO Creation:</strong> <p>Set up your DAO within minutes using our intuitive interface. Pay a one-time fee with our native LUMOS tokens.</p>
                        <strong>2. Transparent Voting:</strong> <p>Empower your DAO members to propose and vote on initiatives. All votes are recorded on the Stellar blockchain for ultimate transparency.</p>
                        <strong>3. Coming Soon:</strong> <p>We're constantly innovating. Get ready for a dedicated discussion forum, crowdfunding features, Airdrops and Bounty panel, and customizable themes.</p>
                    </div>
                    <div class="sndIntroBtn">
                        <a class="bgBtn tBg" href="javascript:;">Launch your DAO</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="thirdImg">
                        <img src="{{ asset('images/third.png') }}" alt="">
                    </div>
                    <div class="videoBox">
                        <iframe width="" height="" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lastSec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="LastIn">
                        <img src="{{ asset('images/lastIn.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="ScndIntro Last">
                        <h1>LUMOS Token</h1>
                        <p>Our native LUMOS tokens are central to the LumosDAO ecosystem. With a total supply of 10 billion, LUMOS tokens are used for DAO creation, voting, and accessing future platform features. LumosDAO and the LUMOS token—designed to drive the Stellar DAO revolution.</p>
                    </div>
                    <div class="mainIntroBtn">
                        <a class="SecondBtn" href="javascript:;">Launch your DAO</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="homeFooter">
        <div class="container">
            <div class="row">
                <div class="firstRow">
                    <div class="col-12">
                        <div class="homeImag">
                            <img src="{{ asset('images/Layer 10.png') }}" alt="" srcset="">
                        </div>
                        <h3>The LumosDAO Newsletter</h3>
                        <p>DAO creation and management platform with no coding required</p>
                        <div class="subcscriptionBox">
                            <input type="email" class="email-input" placeholder="Type your email">
                            <button class="subscribe-btn">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="socialLinks">
                <div class="row">
                    <div class="col-12">
                        <a href="https://twitter.com/DAOLumos" target="_blank">
                            <img src="{{ asset('images/twitter.png') }}" alt="">
                        </a>
                        <a href="https://www.threads.net/@DAOLumos" target="_blank">
                            <img src="{{ asset('images/threads.png') }}" alt="">
                        </a>
                        <a href="https://medium.com/@DAOLumos" target="_blank">
                            <img src="{{ asset('images/medium.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
