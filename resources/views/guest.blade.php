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
                    {{-- <div class="mainIntroBtn">
                        <a class="firstBtn" href="javascript:;">What is a DAO?</a>
                        <a class="SecondBtn" href="javascript:;" data-bs-toggle="modal" data-bs-target="#ConnectWallet">Launch your DAO</a>
                    </div> --}}
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
                        <h1>Why LumosDAO?</h1>
                        <p>LumosDAO shines with its fair decision-making system. We calculate voting power considering user activity, token holdings, and wallet factors, setting us apart from others. Plus, our easy platform welcomes all projects, making DAO creation hassle-free.</p>
                    </div>
                    {{-- <div class="sndIntroBtn">
                        <a class="bgBtn" href="javascript:;" data-bs-toggle="modal" data-bs-target="#ConnectWallet">Launch your DAO</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="thirdSec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="ScndIntro third">
                        <h1>For DAO Creators</h1>
                        <strong>1. Effortless DAO Creation:</strong> <p>Quickly set up your project's DAO, whether it's an existing Stellar token or a new token generated on LumosDAO.</p>
                        <strong>2. Fair Governance:</strong> <p>Ensure fair decision-making with a sophisticated voting power algorithm that considers user activity, token holdings, and wallet factors.</p>
                        <strong>3. Token Issuance:</strong> <p>Generate new tokens directly on LumosDAO and seamlessly set up their corresponding DAO.</p>
                        <strong>4. Transparency:</strong> <p>Highlight approved wallets in the project's toml, fostering transparency in governance.</p>
                        <strong>5. Customization:</strong> <p>Personalize your DAO with project details, logo, and description to reflect your identity.</p>
                    </div>
                    {{-- <div class="sndIntroBtn">
                        <a class="bgBtn tBg" href="javascript:;" data-bs-toggle="modal" data-bs-target="#ConnectWallet">Launch your DAO</a>
                    </div> --}}
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="thirdImg">
                        <img src="{{ asset('images/third.png') }}" alt="">
                    </div>
                    <div class="videoBox">
                        {{-- <video controls autoplay muted playsinline>
                            <source src="{{asset('video.mp4')}}" type="video/mp4">
                        </video> --}}
                        <iframe width="810" height="440" src="https://www.youtube.com/embed/Ast0ZsIsQl4?autoplay=1&controls=0">
                        </iframe>
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
                        <h1>For DAO Members:</h1>
                        <strong>1. Engagement:</strong> <p>Participate in discussions, vote on proposals, and influence your project's future.</p>
                        <strong>2. Transparent Proposals:</strong> <p>Explore proposals created by fellow members, each representing ideas for the community's consideration.</p>
                        <strong>3. Inclusive Decision-Making:</strong> <p>Experience a balanced voting system that factors in your activity and token holdings, ensuring your voice is heard.</p>
                        <strong>4. Transparency:</strong> <p>Get recognized as a top voter for your active participation in shaping the DAO's direction.</p>
                        <strong>5. Simple Interface:</strong> <p>Navigate a user-friendly platform that enables smooth interaction and engagement within your DAO.</p>
                    </div>
                    {{-- <div class="mainIntroBtn">
                        <a class="SecondBtn" href="javascript:;" data-bs-toggle="modal" data-bs-target="#ConnectWallet">Launch your DAO</a>
                    </div> --}}
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
