@extends('layouts.app')

@section('content')
    <section class="assetCode">
        <div class="container">
            <div class="row">
                <div class="Create-dao-section">
                    <h4>1.Create DAO for an existing Steller project</h4>
                    <p class="text-muted">Easily create a dedicated DAO for your existing token on Stellar. Build a hub for collaborative decision-making and project development.</p>
                </div>
                <div class="col-12">
                    <form action="{{ route('dao.search') }}">
                        @csrf
                        <div class="assetInput">
                            <div class=" d-flex align-items-start">
                               <label for="assetCode" class="form-label">Assest Code</label>
                                  <button style="padding-top:0.2rem;" type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="Asset code represents a unique identifier for your token within the Stellar network.">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                  </button>
                            </div>

                            <input type="text" class="form-control"  placeholder="LUMOS" id="assetCode"
                                aria-describedby="emailHelp" name="asset_code" value="{{Session::get('code')}}">
                        </div>
                        <div class="assetInput">
                            <div class="d-flex align-items-start">
                                 <label  for="homeDomain" class="form-label">Home Domain</label>
                            <button style="padding-top:0.2rem;" type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="Home domain is the URL where your asset's Stellar.toml file is hosted, containing essential information about your token.">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                  </button>
                            </div>

                            <input type="text" class="form-control" id="homeDomain" name="home_domain" placeholder="lumosdao.io" value="{{Session::get('domain')}}">
                        </div>
                        <button type="submit" class="btn assetSearch">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="container my-3">
       <div class="assetCode-deo-deatail ">
        <div class="d-flex flex-md-row flex-column align-items-start justify-content-between">
           <div class="w-100">
                <div class="d-flex align-items-center gap-2">
                    <span class="asset-stellar-p w-25 font-">Project</span>
                    <span class="create-dao-note text-secondary w-25">Lumos DAO</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="asset-stellar-p w-25">Ticker</span>
                    <span class="create-dao-note text-secondary w-25">LUMOS</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="asset-stellar-p w-25">Home domain</span>
                    <span class="create-dao-note text-secondary w-25">LumosDAO.io</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="asset-stellar-p w-25">Holders</span>
                    <span class="create-dao-note text-secondary w-25">999</span>
                </div> 
            </div>
            <div class="project-logo d-flex align-items-center justify-content-end">
                <div class="container_custom_file_input  mt-0 w-100">
                    <div class="w-100">
                    <div class="d-flex flex-column align-items-start gap-2 p-2 w-100">
                            <span class="asset-stellar-p text-left">Project Logo</span>
                            <div class="d-flex align-items-center justify-content-center w-100">
                                <img src="../images/Layer 10.png" alt="">
                            </div>
                            
                        </div>  
                    </div>
                </div>
            </div> 
        </div>
        <div class="">
            <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                <span class="asset-stellar-p">Approved wallets</span>
                <span class="create-dao-note text-muted">*Check the wallets that you make want to make visible.*</span>
            </div>
            <div class="my-3">
                <div class="d-flex flex-column align-items-start gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <input type="checkbox" id="wallet1" name="wallet1" value="wallet1">
                        <label for="wallet1" class="col-form-label text-break">GCEV7283NDSJKFHSD847437NBMA6R</label>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <input type="checkbox" id="wallet2" name="wallet2" value="wallet2">
                        <label for="wallet2" class="col-form-label text-break">GCEV283NDSJKFHSD847437NMA6R</label>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <input type="checkbox" id="wallet3" name="wallet3" value="wallet3">
                        <label for="wallet3" class="col-form-label text-break">GCEV283NDSJKFHSD847437NMA6R</label>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <input type="checkbox" id="wallet4" name="wallet4" value="wallet4">
                        <label for="wallet4" class="col-form-label text-break">GCEV283NDSJKFHSD847437NMA6R</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
            <button style="margin-left:0px !important;" type="submit" class="btn assetSearch">Create DAO</button>
            </div>
        </div>
            
          
       </div>
    </section>
    <section class="container">
            <div>
                <div class=" my-5">
                        <div class="Create-dao-section">
                            <h4>2.Create DAO for an new Steller project</h4>
                            <p class="text-muted">Start fresh by generating a new token on LumosDAO and instantly create its DAO. Foster community engagement, discussions, and decisions for your unique concept.
                                  {{-- <a class="create-dao-link" href="#">
                                    Learn more
                                </a> --}}
                            </p>
                        </div>
                </div>
            </div>
            <div class="mb-2">
            <span class="asset-stellar-p ">DAO Details:</span>
            </div>

            <div class="assetCode-deo-deatail">
                    <div class="d-flex align-items-center gap-2">
                        <span class="asset-stellar-p">Note:</span>
                            <span class="create-dao-note text-muted">Deposit 3 XLM in each of the wallets to cover the fees</span>
                    </div>
               <div  class="">
                    <div class="">

                        <div class="">
                            <div class="d-flex justify-content-between py-3">
                            <div class="d-flex align-items-center justify-content-start gap-3">
                                    <div class="d-flex align-items-center justify-content-start">
                                            <span class="asset-stellar-p">Issuing address:</span>
                                            <button type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center p-2 text-secondary" data-toggle="tooltip" data-placement="top" title="Issuing address is where new tokens are created and sent from. It's a crucial part of your token's ecosystem.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
                                    </div>
                                    <button style="font-weight: 500; background: transparent; font-family: 'MontSem';"  class="create-dao-link border-0 " data-bs-toggle="modal" data-bs-target="#ConnectWallet">Connect Wallet</button>
                                <!--<span class="asset-details-text text-secoundary">GCEV......MA6R</span>-->
                            </div>
                        </div>

                        <div  class="d-flex justify-content-between gap-3">

                            <div class="d-flex align-items-center justify-content-start gap-3">
                                <div class="d-flex align-items-center justify-content-start">
                                    <span class="asset-stellar-p ">Disturbing address:</span>
                                    <button type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center p-2 text-secondary" data-toggle="tooltip" data-placement="top" title="Distributing address is where tokens are sent to before being distributed to holders. It's essential for controlled distribution.">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                    </button>
                                </div>
                                <!--<button style="font-weight: 500; background: transparent; font-family: 'MontSem';"  class="create-dao-link border-0 " data-bs-toggle="modal" data-bs-target="#ConnectWallet">Connect Wallet</button>-->
                                <span class="asset-details-text text-secoundary">GCEV......MA6R</span>

                            </div>
                        </div>
                    </div>

               </div>
                    </div>

                    <div class="mt-5">
                <form action="">
                    <div class="grid-form">
                        <div class="form-group">
                            <label for="">
                                <span class="asset-stellar-p">Add logo:</span>
                            </label>
                            <div class="container_custom_file_input">
                                <div class="custom-file" style="position: relative;">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">
                                        <span>Browse <br> Computer</span>
                                        <div class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">
                                <span class="asset-details-label">Project name:</span>
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">
                                <span class="asset-details-label">Ticker:</span>
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">
                                <span class="asset-details-label">Supply:</span>
                            </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                        <button type="submit" class="btn deo-details_btn">
                            <span>Create DAO</span>
                        </button>

                        </div>
                    </div>
                </form>
             </div>
            </div>





        </section>


    @if (Session::has('toml'))
    <section class="project_Description ">
        <div class="container">
            <input type="text" id="dao-description" value="{{ Session::get('toml')['DOCUMENTATION']['ORG_DESCRIPTION'] }}" hidden />
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
                            <p id="dao-project"> {{ isset(Session::get('toml')['DOCUMENTATION']['ORG_NAME']) ? Session::get('toml')['DOCUMENTATION']['ORG_NAME'] : '-'}} </p>
                            <p id="dao-asset">{{ Session::get('code') }}</p>
                            <p id="dao-domain">{{ Session::get('domain') }}</p>
                            <p id="dao-holders">999</p>
                            <input type="number" placeholder="Enter Amount" class="form-control" id="required-tokens">
                        </div>
                    </div>

                    <div class="wallet_Dec d-flex">
                        <label class="label" for="">Approved Wallets </label>
                        <p>*Check the wallets that you want to make vissible. *</p>
                    </div>
                    <div class="checkboxWallet">
                        @isset(Session::get('toml')['ACCOUNTS'])
                            @foreach (Session::get('toml')['ACCOUNTS'] as $key => $account)
                            <div class="approved-wallets form-group row">
                                @php $connected_account = $_COOKIE['public']; @endphp
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="checkbox" id="wallet{{$key}}" value="{{$account}}" {{$account==$connected_account ? 'checked disabled' : ''}}>
                                    <label for="wallet{{$key}}" class="col-form-label text-break">
                                        {{$account}}
                                        @if($account==$connected_account) (<span class="text-success">connected</span>) @endif
                                    </label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <input type="text" class="wallet-name form-control mb-1 {{$account!=$connected_account ? 'd-none' : 'active'}}" placeholder="Wallet name">
                                </div>
                            </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 order1">
                    <div class="gray-div-logo">
                        {{-- <p>Project Logo</p> --}}
                        <img src="{{ Session::get('toml')['DOCUMENTATION']['ORG_LOGO'] }}" id="dao-logo" alt="Image">
                    </div>
                </div>
            </div>
            <div class="row project_Description_content">
                <div class="col-12 text-center">
                    <button class="btn btnCreateD" id="create-dao">
                        <p>Create DAO</p>
                        <p class="lumostext">(10,000 LUMOS)</p>
                    </button>
                    <button style="display: none" class="btn btnCreateD" id="loadStaking" disabled>
                        <div class="spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        Wait
                    </button>
                </div>
            </div>
        </div>
    </section>
    @elseif (Session::has('error_key'))
    <section class="errorDao">
        <div class="container">
            <div class="innerError">
                <div class="row">
                    <div class="col-12">
                        <div class="emoiDiv">
                            <img src="{{ asset('images/emoji.png') }}" alt="">
                            <p>
                                @if (Session::get('error_key') == 'blank')
                                Please fill both fileds
                                @elseif (Session::get('error_key') == 'domain')
                                The domain you entered is incorrect or not having a TOML
                                @elseif (Session::get('error_key') == 'permission')
                               <span class="text-danger"> Your Wallet is not aproved in the TOML</span>
                                @elseif (Session::get('error_key') == 'code')
                                The asset code is not exist in TOML
                                @endif
                            </p>
                        </div>
                    </div>
                    @if (Session::get('error_key') == 'permission')
                    <div class="col-12">
                        <div class="guideWallet">
                            <p><span><img src="{{ asset('images/dot.png') }}" alt=""></span>Add you wallter
                                address here: {{Session::get('domain')}}/.well-known/stellar.toml, OR</p>
                            <p><span><img src="{{ asset('images/dot.png') }}" alt=""></span>Try again with
                                any other approved account.</p>
                        </div>
                        <div class="guideLink">
                            <h6>Tutorial</h6>
                            <p><a href="javascript:;">Click here </a>to learn how to approve you Stellar walltet address
                                through toml.</p>
                        </div>
                    </div>
                    @endif
                   
                </div>
                <div style="margin-top: 40px;" class="">
                    <div class="d-flex align-items-center justify-content-start gap-2">
                        <div class="background-linear-gradient"></div>
                        <span class="create-dao-note text-muted">Add you waiter address here:example.com/.well-Known/stellar.toml.  OR</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-start gap-2 my-2">
                        <div class="background-linear-gradient"></div>
                        <span class="create-dao-note text-muted">Try again with any other approved you Stellar wallet address through toml.</span>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-start gap-2">
                    <span class="asset-stellar-p">Tutorial</span>
                    <span class="create-dao-note text-muted">
                            <a class="create-dao-link border-0" href="">Click here</a>
                            to learn how to approve you Stellar wallet address through toml.
                    </span>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection
