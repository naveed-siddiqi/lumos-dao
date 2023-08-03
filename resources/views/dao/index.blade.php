@extends('layouts.app')

@section('content')
    <section class="leadingBoard">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading-board">
                        <p class="headingBoard">Board</p>
                        <span class="rightArrow"> > </span>
                        <p class="apple-text">Apple</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="main-card-link">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-join">
                        <div class="lblJoin">
                            <p class="mb-0">join</p>
                        </div>
                        <div class="card-imgflex">
                            <img src="{{ asset('images/apple.png') }}" alt="Image">
                            <div class="cardHeading">
                                <p class="card-heading">Apple</p>
                                <p class="card-subheading">6,296 members</p>
                            </div>
                        </div>
                        <div class="card-paragraph">Apple is a decentralized exchange built on the Stellar network that
                            allows you to swap and trade assets using a friendly, minimal interface.
                        </div>

                        <div class="d-flex">
                            <div class="card-small-div">
                                <span class="card-bold-word">Assets:</span>
                                <a href="#" class="card-link">AAPL<img src="{{ asset('images/topright.png') }}" alt=""></a>
                            </div>
                            <div class="card-small-div">
                                <span class="card-bold-word">Website:</span>
                                <a href="#" class="card-link">apple.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="approveWallet">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="heading">Approve Wallet</h2>
                </div>
            </div>
            <div class="addressLink">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <strong class="text-success">Treasury</strong>
                        <div class="column-content">
                            <p>FGDKXQTCPOJVVBBY...2MRK2DXKZANU3I</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <strong class="text-success">Team</strong>
                        <div class="column-content">
                            <p>FGDKXQTCPOJVVBBY...2MRK2DXKZANU3I</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <strong class="text-success">Marketing</strong>
                        <div class="column-content">
                            <p>FGDKXQTCPOJVVBBY...2MRK2DXKZANU3I</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="propFilter">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="propFilterInner">
                        <div class="heading">Proposals</div>
                        <a href="{{ route('dao.proposal.create', 1) }}" class="btn btnCreate">
                            Create Proposal <img class="plu" src="{{ asset('images/11.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="endedCard">
        <div class="container">
            <div class="row">
                <div class="cardEndDiv">
                    <div class="col-12">
                        <a href="{{ route('dao.proposal', [1,1]) }}" class="text-decoration-none">
                            <div class="d-flex justify-content-between">
                                <div class="cardEndDetail">
                                    <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image">
                                    <div class="text">ByGBV6...SYEN</div>
                                </div>
                                <div class="small-card">
                                    <div class="small-card-text">Ended</div>
                                </div>
                            </div>
                            <div class="cardendHeading">
                                <h2 class="heading">Incentivized Referral Program</h2>
                                <div class="paragraph">
                                    <p>We will introduce an incentivized referral program, rewarding existing LumosDAO members for bringing in new users. This program will encourage community growth while rewarding loyal members who contribute to expanding our user base.</p>
                                </div>
                            </div>
                            <div class="carendBottom">
                                <div class="small-card">
                                    <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                    <div class="small-card-text">Yes</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="cardEndDiv">
                    <a href="{{ route('dao.proposal', [1,1]) }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between">
                            <div class="cardEndDetail">
                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image">
                                <div class="text">ByGBV6...SYEN</div>
                            </div>
                            <div class="small-card">
                                <div class="small-card-text">Ended</div>
                            </div>
                        </div>
                        <div class="cardendHeading">
                            <h2 class="heading">Incentivized Referral Program</h2>
                            <div class="paragraph">
                                <p>We will introduce an incentivized referral program, rewarding existing LumosDAO members for bringing in new users. This program will encourage community growth while rewarding loyal members who contribute to expanding our user base.</p>
                            </div>
                        </div>
                        <div class="carendBottom">
                            <div class="small-card">
                                <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                <div class="small-card-text">Yes</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="cardEndDiv">
                    <a href="{{ route('dao.proposal', [1,1]) }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between">
                            <div class="cardEndDetail">
                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image">
                                <div class="text">ByGBV6...SYEN</div>
                            </div>
                            <div class="small-card">
                                <div class="small-card-text">Ended</div>
                            </div>
                        </div>
                        <div class="cardendHeading">
                            <h2 class="heading">Incentivized Referral Program</h2>
                            <div class="paragraph">
                                <p>We will introduce an incentivized referral program, rewarding existing LumosDAO members for bringing in new users. This program will encourage community growth while rewarding loyal members who contribute to expanding our user base.</p>
                            </div>
                        </div>
                        <div class="carendBottom">
                            <div class="small-card">
                                <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                <div class="small-card-text">Yes</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <button class="cardendBtn">Load more</button>
                </div>
            </div>
        </div>
    </section>
@endsection
