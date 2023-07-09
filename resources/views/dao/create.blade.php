@extends('layouts.app')

@section('content')
    <section class="assetCode">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form>
                        <div class="assetInput">
                            <label for="exampleInputEmail1" class="form-label">Assest Code</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="assetInput">
                            <label for="exampleInputPassword1" class="form-label">Home Domain</label>
                            <input type="text" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" class="btn assetSearch">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="project_Description ">
        <div class="container">
            <div class="row project_Description_content">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="pro_dec">
                        <div class="frDiv">
                            <label class="label">Project</label>
                            <label class="label">Ticker</label>
                            <label class="label">Home Domain</label>
                            <label class="label">Holders</label>
                            <label class="label">Tokens Required to Create Proposal</label>
                        </div>
                        <div class="ScDiv">
                            <p>Lumos DAO</p>
                            <p>LUMOS</p>
                            <p>LumosDAO.io</p>
                            <p>999</p>
                            <input type="number" placeholder="Enter Amount" class="form-control">
                        </div>
                    </div>

                    <div class=" wallet_Dec d-flex">
                        <label class="label" for="">Approved Wallets </label>
                        <p>*Check the wallets that you want to make vissible. *</p>
                    </div>
                    <div class="checkboxWallet">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <label class="col-form-label text-break">GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P (<span class="text-success">connected</span>)</label>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <input type="text" class="wallet-name form-control mb-1" placeholder="Wallet name">
                            </div>
                        </div>
                        <div class="approved-wallets form-group row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <input type="checkbox" id="wallet1">
                                <label for="wallet1" class="col-form-label text-break">GASLDFKOERTJHPAO9345734H23JKLKJMV7</label>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <input type="text" class="wallet-name form-control mb-1 d-none" placeholder="Wallet name">
                            </div>
                        </div>
                        <div class="approved-wallets form-group row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <input type="checkbox" id="wallet2">
                                <label for="wallet2" class="col-form-label text-break">GASLDFKOERTJHPAO9345734H23JKLKJMV7</label>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <input type="text" class="wallet-name form-control mb-1 d-none" placeholder="Wallet name">
                            </div>
                        </div>
                        <div class="approved-wallets form-group row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <input type="checkbox" id="wallet3">
                                <label for="wallet3" class="col-form-label text-break">GASLDFKOERTJHPAO9345734H23JKLKJMV7</label>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <input type="text" class="wallet-name form-control d-none" placeholder="Wallet name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 order1">
                    <div class="gray-div-logo">
                        <p>Project Logo</p>
                        <img src="{{ asset('images/Layer 10.png') }}" alt="Image">
                    </div>
                </div>
            </div>
            <div class="row project_Description_content">
                <div class="col-12 text-center">
                    <button class="btn btnCreateD">
                        <p>Create DAO</p>
                        <p class="lumostext">(10,000 LUMOS)</p>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="errorDao d-none">
        <div class="container">
            <div class="innerError">
                <div class="row">
                    <div class="col-12">
                        <div class="emoiDiv">
                            <img src="{{ asset('images/emoji.png') }}" alt="">
                            <p>Your Wallet is not aproved in the TOML</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="guideWallet">
                            <p><span><img src="{{ asset('images/dot.png') }}" alt=""></span>Add you wallter
                                address here: example.com/.well-known/stellar.toml, OR</p>
                            <p><span><img src="{{ asset('images/dot.png') }}" alt=""></span>Try again with
                                any other approved account.</p>
                        </div>
                        <div class="guideLink">
                            <h6>Tutorial</h6>
                            <p><a href="">Click here </a>to learn how to approve you Stellar walltet address
                                through toml.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
