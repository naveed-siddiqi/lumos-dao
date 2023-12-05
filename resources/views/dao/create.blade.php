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
                    <form action="{{ route('dao.search') }}" onsubmit="event.preventDefault()">
                        @csrf
                        <div class="assetInput">
                            <div class=" d-flex align-items-start">
                               <label for="assetCode" class="form-label">Assest Code</label>
                                  <button style="padding-top:0.2rem;" type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="Asset code or the address represents a unique identifier for your token within the Stellar network.">
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
                                 <label  for="homeDomain" class="form-label">Asset Toml Url</label>
                            <button style="padding-top:0.2rem;" type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="This is the asset toml url link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                  </button>
                            </div>

                            <input type="text" class="form-control" id="assetUrl" name="home_domain" placeholder="https://asset-domain/.well-known/stellar.toml" value="">
                        </div>
                        
                        <button onclick='searchForAsset()' id='assetButton' class="btn assetSearch">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="container my-3">
        
       <div class="assetCode-deo-deatail " id='asset_s' style='display:none !important'>
           <div id='asset_s_msg' style='text-align:center; width:calc(100% - 30px);margin:10px 15px;'>
               This asset has been wrapped and therefore can be used
           </div>
           <div class="assetInput">
                            <div class="d-flex align-items-start">
                                 <label  for="homeDomain" class="form-label">DAO Name</label>
                            <button style="padding-top:0.2rem;" type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="The name of your DAO community">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                  </button>
                            </div>

                            <input type="text" class="form-control" id="dao_name" name="home_domain" placeholder="Name..." value="">
                </div>
                
                <div class="assetInput" style='margin-top:20px'>
                            <div class="d-flex align-items-start">
                                 <label  for="homeDomain" class="form-label">DAO Description</label>
                            <button style="padding-top:0.2rem;" type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="A brief description about your DAO community">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                  </button>
                            </div>

                            <input type="text" class="form-control" id="dao_about" name="home_domain" placeholder="Description..." value="">
                        </div>
                        
                    
            
            
        <div class="d-flex flex-md-row flex-column align-items-start justify-content-between" style='margin-top:30px'>
           <div class="w-100">
                <div class="d-flex align-items-center gap-2">
                    <span class="asset-stellar-p w-25 font-">Project</span>
                    <span id='asset_s_name' class="create-dao-note text-secondary w-25">Lumos DAO</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="asset-stellar-p w-25">Ticker</span>
                    <span id='asset_s_code' class="create-dao-note text-secondary w-25">LUMOS</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="asset-stellar-p w-25">Home domain</span>
                    <span id='asset_s_domain' class="create-dao-note text-secondary w-25">LumosDAO.io</span>
                </div>
                <div class="d-flex align-items-center gap-2" style='display:none !important'>
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
                                <img id='asset_s_img' src="" alt="" style='max-width:70px;max-height:70px'>
                            </div>
                            
                        </div>  
                    </div>
                </div>
            </div> 
            
        </div>
        <div class="" style='margin-top:20px; display:none !important'>
            <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                <span class="asset-stellar-p">Approved wallets</span>
                <span class="create-dao-note text-muted">*Check the wallets that you make want to give permission to.*</span>
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
             
            
        </div>
            
             <div class="text-center">
            <button style="margin-left:0px !important;" type="" id='createButton' onclick='createTheDao(event)' class="btn assetSearch">Create DAO</button>
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
                            <span class="create-dao-note text-muted">Deposit min 3 XLM in your wallets to cover the transaction fees</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="asset-stellar-p">Stellar Toml Url:</span>
                            <span class="create-dao-note text-muted" id='asset_o_toml'></span>
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
                                    <button style="font-weight: 500; background: transparent; font-family: 'MontSem';"  class="create-dao-link border-0 " data-bs-toggle="modal" data-bs-target="
                                        <?php
                                         if (!isset($_COOKIE['wallet'])) { echo "#ConnectWallet";}
                                        ?> 
                                    ">
                                        <?php
                                           if (isset($_COOKIE['wallet'])) {
                                              
                                              $prefix = substr($_COOKIE['public'], 0, 4);
                                              $suffix = substr($_COOKIE['public'], -4);

                                              // Create the formatted address
                                              echo $prefix . '...' . $suffix;
                                        }
                                        else {
                                            echo 'Connect Wallet';
                                        }
                                            
                                        ?>
                                        
                                        </button>
                                <!--<span class="asset-details-text text-secoundary">GCEV......MA6R</span>-->
                            </div>
                        </div>

                        <div  class="d-flex justify-content-between gap-3" style='display:none !important'>

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
                <form action="" onsubmit="event.preventDefault()">
                    <div class="grid-form">
                        <div class="form-group">
                            <label for="">
                                <span class="asset-stellar-p">Add logo:</span>
                            </label>
                            <div class="container_custom_file_input">
                                <div class="custom-file" style="position: relative;">
                                    <input type="file" id='asset_o_upload' class="custom-file-input">
                                    <label class="custom-file-label" for="customFile">
                                        <span id='asset_o_upload_msg'>Browse <br> Computer</span>
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
                                <span class="asset-details-label">DAO name:</span>
                            </label>
                            <input id='dao_o_name' type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">
                                <span  class="asset-details-label">Asset Code:</span>
                            </label>
                            <input id='asset_o_code' type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">
                                <span class="asset-details-label">Supply:</span>
                            </label>
                            <input id='asset_o_supply' type="text" class="form-control">
                        </div>
                        
                    </div>
                        <div class="form-group" style='margin-top:20px'>
                            <label for="">
                                <span class="asset-details-label">DAO description</span>
                            </label>
                            <input id='dao_o_about' type="text" class="form-control">
                        </div>
                        <div class="form-group">
                        <button id='createodao' type="" onClick= "createODao(event)" class="btn deo-details_btn" style='max-width:250px !important'>
                            <span>Create DAO</span>
                        </button>

                        </div>
                        <div style="grid-column: span 5 / span 5;" class="form-group">
                            <label for="">
                                <span class="asset-stellar-p">Add Cover Photo:</span>
                            </label>
                            <div class="container_custom_file_input">
                                <div class="custom-file" style="position: relative;">
                                    <input type="file" class="custom-file-input">
                                    <label class="custom-file-label py-4" for="customFile">
                                        <span>Add Cover</span>
                                        <div class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            </div>
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
       <script>
    let assetAddress = null; 
    let issueAddress = "";
    let assetUrl = null
        
        //This function search for assets
        const searchForAsset = async () => {
            const assetCode = E('assetCode').value.trim()
            const assetToml = E('assetUrl').value.trim()
            if(assetCode != "" && assetToml != "") {
                //check for insecure url
                if(assetToml.indexOf('http://') > -1 && assetToml.indexOf("<?php echo $_SERVER['HTTP_HOST']; ?>") == -1){
                    stopTalking(4, talk("Trying to load a toml file at an insecure address<br>Please use a secure address (https://)", "fail"))
                    return;
                }
                //get the toml
                E('assetButton').disabled = true //disable button
                E('asset_s').style.display = "none"
                const id = talk("Searching for Asset...")
                const tomlDetails = await readAssetToml(assetToml)
                if(tomlDetails !== false) {
                    let flg = false
                    //display information
                    if(tomlDetails.CURRENCIES){
                        for(let i=0; i<tomlDetails.CURRENCIES.length;i++) {
                            const cur = tomlDetails.CURRENCIES[i]
                            if(cur.code == assetCode) {
                                //have found our code
                                E('asset_s_name').innerHTML = cur.name || ""
                                E('dao_name').value = cur.name || ""
                                E('asset_s_code').innerHTML = cur.code || ""
                                E('asset_s_domain').innerHTML = (tomlDetails.DOCUMENTATION) ? tomlDetails.DOCUMENTATION.ORG_URL : ""
                                E('dao_about').value = cur.desc || ""
                                E('asset_s_img').src = cur.image || "{{ asset('images/topright.png') }}"
                                if(!(cur.issuer == undefined || cur.issuer == "")) {
                                    if(cur.issuer == walletAddress || tomlDetails.ACCOUNTS.includes(walletAddress) || true) {
                                        issueAddress = cur.issuer
                                        assetUrl = assetToml
                                    }
                                    else {
                                        stopTalking(4, talk("Your wallet address is not authorise to use this Asset", "fail"))
                                        flg = false
                                        stopTalking(1, id)
                                         E('assetButton').disabled = false
                                         return false;
                                    }
                                }
                                else {
                                    flg = false
                                    stopTalking(4, talk("Unable to find issuer address in Toml file", "fail"))
                                    stopTalking(4, id)
                                    E('assetButton').disabled = false
                                    return;
                                }
                                flg = true
                                break;
                            }
                        }
                    }
                    if(flg) {
                        //show div
                        await checkForAsset()
                        E('asset_s').style.display = "block"
                        talk("Asset found", "good", id)
                        stopTalking(4, id)
                    }
                    else {
                        stopTalking(4, talk("Unable to find asset in Toml file", "fail"))
                        stopTalking(4, id)
                    }
                }
                else {
                    stopTalking(4, talk("Unable to fetch Toml file<br> This can be due to network or bad Toml URL address", "fail"))
                    stopTalking(4, id)
                }
                
            }
            E('assetButton').disabled = false
           
        }
        //this functions verifies an asset
        const checkForAsset = async () => {
            const assetCode = E('assetCode').value.trim()
            if(assetCode != "" && issueAddress != "") {
                //disable button
                console.log(assetCode)
                const res = await verifyAsset({
                    code:assetCode, issuer:issueAddress,
                })
                if(res === false) {
                    //unwrapped token
                    E('asset_s_msg').innerHTML = `This asset has not been wrapped. Click on Wrap Asset`
                    E('asset_s_msg').style.color = 'dodgerblue'
                    E('createButton').innerText = 'Wrap Asset'
                    E('createButton').onclick = () => {wrapToken()}
                }
                else {
                    assetAddress = res
                    E('asset_s_msg').innerHTML = "This asset can be used"
                    E('asset_s_msg').style.color = 'forestgreen'
                    E('createButton').innerText = 'Create Dao'
                    E('createButton').onclick = (event) => {createTheDao(event)}
                } 
                E('assetButton').disabled = false
            }
        }
        //this function wraps the asset
        const wrapToken = async () => {
            const assetCode = E('assetCode').value.trim()
            if(assetCode != "" && issueAddress != "") {
                try{
                    E('assetButton').disabled = true
                    const id = talk("Wrapping Asset")
                    await new Promise((resolve) => setTimeout(resolve, 500));
                    const val = await wrapAsset(); 
                    if(val !== false) {
                        //make call to the main asset wrapping route
                        const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=wrapasset&code=" + assetCode + "&issuer=" + issueAddress + "&rand=" + Math.random()
                        fetch(url, {
                            method: 'GET', // *GET, POST, PUT, DELETE, etc.
                            mode: 'cors', // no-cors, *cors, same-origin
                            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                            headers: {
                              'Content-Type': 'application/json'
                            },
                        }).then((response) => response.json()
                            .then(async (data) => {  
                                await checkForAsset()
                                E('assetButton').disabled = false
                                if(data === 1 || data === 1) {
                                    talk("Wrapped Successfully", "good", id)
                                    stopTalking(3, id)
                                }
                                else {
                                    talk("Something went wrong", "fail", id)
                                    stopTalking(3, id)
                                }
                            }))
                            .catch(err => {
                                E('assetButton').disabled = false
                                talk("Something went wrong<br>This may be due to poor network", "fail", id)
                                stopTalking(3, id)
                            })
                    }
                    else {
                        E('assetButton').disabled = false
                        talk("Something went wrong", "fail", id)
                        stopTalking(3, id)
                    }
                }
                catch(e) { console.log(e)
                    E('assetButton').disabled = false
                    talk("Something went wrong", "fail", id)
                    stopTalking(3, id)
                }
            }
        }
        //this function creates the dao
        const createTheDao = async (event) => {
            event.preventDefault()
            const name = E('dao_name').value.trim()
            const desc = E('dao_about').value.trim()
            const _url = E('assetUrl').value.trim()
            if(name != "" && desc != "") {
                if(assetAddress != null) {
                    if(issueAddress == walletAddress) {
                        //disable button
                        E('createButton').disabled = true
                        const id = talk("Creating Dao...")
                        const res = await createDaos({
                            name:name,
                            about:desc,
                            token:assetAddress,
                            url:_url
                        })
                        console.log(res)
                        if(res === false) {
                            //unwrapped token
                            talk("Unable to create DAO<br>Something went wrong", "fail", id)
                            stopTalking(4, id)
                        }
                        else if(res.status === true){
                            let _a = assetAddress; assetAddress  = null
                            issueAddress = ""
                            assetUrl = ""
                            talk("Dao created successfuly", "good", id)
                            stopTalking(4, id)
                            await new Promise((resolve) => setTimeout(resolve, 1000));
                            window.location = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/dao/" + _a
                        }
                        else {
                            assetAddress = null
                            talk("This asset has already being used", "fail", id)
                            stopTalking(4, id)
                        }
                        E('createButton').disabled = false
                    }
                    else {
                        stopTalking(3, talk("You are not the issuer of this asset", "fail"))
                    }
                }
                else {
                    stopTalking(3, talk("This asset cannot be used", "fail"))
                }
            }
            else {
                stopTalking(3, talk("Empty field present", "fail"))
            }
        }
        
        //this function creates the dao based on the other type
        const createODao = async (event) => {
            event.preventDefault()
            const aCode = E('asset_o_code').value.trim()
            const aSupply = E('asset_o_supply').value.trim()
            const name = E('dao_o_name').value.trim()
            const about = E('dao_o_about').value.trim()
            const fileInput = E('asset_o_upload');
            if(aCode != "" && aSupply != "" && name != "" && about != "" && fileInput.files.length > 0) {
                if(isSafeToml(aCode) && isSafeToml(name) && isSafeToml(about)) {
                    //disable button
                    E('createodao').disabled = true
                    //check if subdomain exists
                    const isSub = await isSubDomainExists(name)
                    let tName = name.replace(/[^a-zA-Z0-9]/g,"").toLowerCase()
                    if(isSub) {
                        //add random number to name
                        tName += Math.floor(Math.random() * 100)
                    }
                    const id = talk("Creating Asset for DAO...")
                    let res = await deployStellarAsset(new SorobanClient.Asset(aCode, walletAddress))
                    if(res === false) {
                        //unwrapped token
                        talk("Unable to create Asset<br>Something went wrong", "fail", id)
                        stopTalking(4, id)
                    }
                    else if(res.status === true || res.msg == "simulation fail"){
                        assetAddress = res.value
                        if(res.msg == "simulation fail") assetAddress = await verifyAsset({code:aCode, issuer:walletAddress})
                        console.log(assetAddress)
                        talk("Asset created successfuly", "good", id)
                        //time to mint the asset
                        await new Promise((resolve) => setTimeout(resolve, 1000));
                        //creating the toml file
                        talk("Creating the Stellar toml file", "norm", id)
                        uploadTomlFile(encodeURIComponent(createAssetToml({
                            domain:tName,
                            name:name,
                            code:aCode,
                            about:about,
                            issuer:walletAddress,
                            image:window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/images/" + (aCode + walletAddress) + ".png"
                        })), tName, async (res, turl) => {
                            if(res == true) {
                                //upload the file
                                uploadAssetImg(aCode + walletAddress, tName, async (res, url) => {
                                    if(res == true) {
                                        //time to mint the asset
                                        talk("Created the Stellar toml file", "good", id)
                                        E('asset_o_toml').innerHTML = turl
                                        await new Promise((resolve) => setTimeout(resolve, 1000));
                                        talk("Minting suply", "norm", id)
                                        res = await mintToken(aSupply, aCode, walletAddress)
                                        if(res === false) {
                                            //unwrapped token
                                            talk("Unable to mint supply<br>Something went wrong", "fail", id)
                                            await new Promise((resolve) => setTimeout(resolve, 1000));
                                            talk("You can still create the DAO by using the first option<br> Just input the toml url and the asset code", "warn", id)
                                            E('createodao').disabled = false
                                            stopTalking(5, id)
                                        }
                                        else if(res.status != undefined){
                                            talk("Supply minted successfuly", "good", id)
                                            //time to extend the asset life
                                            await new Promise((resolve) => setTimeout(resolve, 1000));
                                            talk("Extending Asset life", "norm", id)
                                            await bumpContractInstance(assetAddress)
                                            talk("Creating the DAO", "norm", id)
                                            //create the dao 
                                            res = await createDaos({
                                                name:name,
                                                about:about,
                                                token:assetAddress,
                                                url:turl
                                            })
                                            console.log(res)
                                            if(res === false) {
                                                //unwrapped token
                                                E('createodao').disabled = false
                                                talk("Unable to create DAO<br>Something went wrong", "fail", id)
                                                stopTalking(4, id)
                                            }
                                            else if(res.status === true){
                                                let _a = assetAddress; assetAddress  = null
                                                E('createodao').disabled = false
                                                talk("Dao created successfuly", "good", id)
                                                stopTalking(4, id)
                                                await new Promise((resolve) => setTimeout(resolve, 1000));
                                                //redirect to dao page
                                                window.location = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/dao/" + _a
                                            }
                                            else {
                                                E('createodao').disabled = false
                                                assetAddress = null
                                                talk("This asset has already being used", "fail", id)
                                                stopTalking(4, id)
                                            }
                                        }
                                    }
                                    else {
                                         E('createodao').disabled = false
                                        talk("Unable to create Stellar file<br>Something went wrong", "fail", id)
                                        stopTalking(4, id)
                                    }
                                })
                            }
                            else {
                                 if(turl === "exists") {
                                    E('createodao').disabled = false
                                    talk("Dao with this name already exists<br>Please change the name", "fail", id)
                                }
                                else {
                                    E('createodao').disabled = false
                                    talk("Unable to create Stellar file<br>Something went wrong", "fail", id)
                                }
                                stopTalking(4, id)
                            }
                        })
                         
                    }
                    else {
                        E('createodao').disabled = false
                        assetAddress = null
                        if(res.msg != undefined){talk("This asset has already being  created", "fail", id)}
                        else {talk("Unable to create Asset<br>Something went wrong", "fail", id)}
                        stopTalking(4, id)
                    }
                    
                }
                else {
                    E('createodao').disabled = false
                    const msg  = "Invalid characters(\") present in the social media links.<br> Please remove it and try again";
                    stopTalking(4, talk(msg, "fail"))
                }
            }
            else {
                E('createodao').disabled = false
                stopTalking(3, talk("Empty field present", "fail"))
            }
        }
        
        const uploadAssetImg = (assetName, domain, callback) => {
              const formData = new FormData(); // Create a FormData object
            
              // Get the selected file input element
              const fileInput = E('asset_o_upload');
              // Check if a file is selected
              if (fileInput.files.length === 0) {
                alert("Please select a file.");
                return;
              }
              // Check the file size (max size: 3MB)
              const maxSize = 3 * 1024 * 1024; // 3MB in bytes
              if (fileInput.files[0].size > maxSize) {
                alert("File size exceeds the maximum allowed (3MB).");
                return;
              }
              // Check if the selected file is an image
              if (!fileInput.files[0].type.startsWith('image/')) {
                alert("Please select an image file.");
                return;
              }
              // Add the selected file to the FormData object
              formData.append('file', fileInput.files[0]);
              // Create an HTTP request
              const xhr = new XMLHttpRequest();
             const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=upload&name=" + assetName + ".png" + "&domain=" + domain
              // Define the server endpoint (PHP file)
              xhr.open('POST', url, true);
              // Set up an event listener to handle the response
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) { console.log(xhr.responseText)
                    if (xhr.responseText == "1") {callback(true, window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/images/" + assetName + ".png")}else{callback(false)}
                }
                else if (xhr.readyState === 4 && xhr.status !== 200) {
                    callback(false)
                }
              };
             // Send the FormData object with the image
              xhr.send(formData);
            }
        const uploadTomlFile = (asset, name, callback) => {
              const xhr = new XMLHttpRequest();
              const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=toml&asset=" + asset + "&value=" + name
              // Define the server endpoint (PHP file)
              xhr.open('GET', url, true);
              // Set up an event listener to handle the response
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {  
                    if (xhr.responseText == "1") {callback(true, "http://" + name +".<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/stellar.toml")}
                    else if(xhr.responseText == "0"){callback(true, "exists")}
                    else {callback(false)}
                }
                else if (xhr.readyState === 4 && xhr.status !== 200) {
                    callback(false)
                }
              };
             // Send the FormData object with the image
              xhr.send(); 
            }
        const createAssetToml = (asset) => {
            return `ACCOUNTS=[]\n\n[DOCUMENTATION]\nORG_NAME="${asset.name}"\nORG_URL="http://${asset.domain}.lumosdao.io"\nORG_DESCRIPTION="${asset.about}"\nORG_LOGO="${asset.image}"\nORG_TWITTER=""\nORG_INSTAGRAM=""\nORG_DISCORD=""\nORG_TELEGRAM=""\nORG_REDDIT=""\nORG_SUPPORT_EMAIL=""\n\n[[CURRENCIES]]\ncode="${asset.code}"\nissuer="${asset.issuer}"\ndisplay_decimals=1\nname="${asset.name}"\ndesc="${asset.about}"\nstatus="live"\nimage="${asset.image}"`
        } 
        
        //validate the image upload
        validateImageUpload('asset_o_upload', 'asset_o_upload_msg')
        // setTimeout(() => {
        //      bumpContractInstance(daoContractId)
        // }, 5000) 
        
    </script>
 
@endsection
