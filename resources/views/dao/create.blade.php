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
           <div style="margin-left: 0px !important;" class="assetInput">
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
                <!-- <button style="float: right;" type="button" id="openModalButton">
                     Steps Modal
                </button>
                <button style="float: right;" type="button" id="openShareModalButton">
                     share Modal
                </button> -->
                <!-- Modal no 1 steps -->
                <div id="myModal" class="modal">
                    <div class="coounter-modal">
                        <!-- Steps modal -->
                        <div class="modal-content p-4 d-flex align-items-center justify-content-center d-no ne">
                            <span class="modal-close" id="closeModalButton">&times;</span>
                            <nav class="mt-3 w-100 ">
                                <ul role="list" class="d-flex flex-column flex-sm-row align-items-center p-0">
                                    <li class="step_li">
                                        <div class="step_li_check">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="w-100 d-flex flex-column align-items-center justify-content-center mt-3">
                                            <div class="step_li_border"></div>
                                            <p class="loading-done !text-[#333] mt-2">Creating Toml</p>
                                            <p class="loading-pending !text-[#333] mt-2 d-none">Creating Toml</p>

                                        </div>
                                        
                                    </li>
                                    <li class="step_li">
                                        <div class="step_li_check">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="w-100 d-flex flex-column align-items-center justify-content-center mt-3">
                                            <div class="step_li_border"></div>
                                            <p class="loading !text-[#333] mt-2">Creating Toml</p>
                                            <p class="loading-pending !text-[#333] mt-2 d-none">Creating Toml</p>
                                        </div>
                                        
                                    </li>
                                    <li class="step_li">
                                        <div class="step_li_check">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="w-100 d-flex flex-column align-items-center justify-content-center mt-3">
                                            <div class="step_li_border-pending"></div>
                                            <p class="loading !text-[#333] mt-2 d-none">Creating Toml</p>
                                            <p class="loading-pending !text-[#333] mt-2">Creating Toml</p>

                                        </div>
                                        
                                    </li>
                                    <li class="step_li">
                                        <div class="step_li_check">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="w-100 d-flex flex-column align-items-center justify-content-center mt-3">
                                            <div class="step_li_border-pending"></div>
                                            <p class="loading !text-[#333] mt-2 d-none">Creating Toml</p>
                                            <p class="loading-pending !text-[#333] mt-2 ">Creating Toml</p>

                                        </div>
                                        
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!-- steps succes modal -->
                        <div class="modal-content w-auto p-4 d-flex align-items-center justify-content-center d-none">
                            <div class="step_success">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                               </svg>
                               <h1>
                                Awesome!
                               </h1>
                               <p>
                                Your DAO has been created successfully.
                               </p>
                               <button id="closeModalButtonOk" class="">
                                ok
                               </button>
                            </div>

                        </div>
                    </div>
                </div>
            <!-- ///////////////////step-end///////////////////////////// -->
            <div id="ShareModal" class="modal">
                    <div class="coounter-modal">
                        <!-- steps succes modal -->
                        <div class="share-modal-content bg-white w-auto d-flex align-items-center justify-content-center d-no ne">
                        <span class="modal-close" id="ShareModalButton">&times;</span>
                               <div class="">
                               <div class="d-flex align-items-center justify-content-start border-bottom pb-2">
                                    <div class="share-modal-img">
                                        <img src="https://images.unsplash.com/photo-1683009686716-ac2096a5a73b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8" alt="">
                                    </div>
                                    <div class="ml-1">
                                        <p class="p-0 m-0">Rocket</p>
                                        <span class="text-black-50 p-0 m-0">1 member</span>
                                    </div>
                                </div>
                                <div class="share-social-links">
                                    <p class="m-0 font-bold">Share link with the community</p>
                                    <ul class="d-flex align-items-start justify-content-start gap-3 m-0 p-0">
                                        <li>
                                        <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 256 256"><path fill="#1877F2" d="M256 128C256 57.308 198.692 0 128 0C57.308 0 0 57.307 0 128c0 63.888 46.808 116.843 108 126.445V165H75.5v-37H108V99.8c0-32.08 19.11-49.8 48.347-49.8C170.352 50 185 52.5 185 52.5V84h-16.14C152.958 84 148 93.867 148 103.99V128h35.5l-5.675 37H148v89.445c61.192-9.602 108-62.556 108-126.445"/><path fill="#FFF" d="m177.825 165l5.675-37H148v-24.01C148 93.866 152.959 84 168.86 84H185V52.5S170.352 50 156.347 50C127.11 50 108 67.72 108 99.8V128H75.5v37H108v89.445A128.959 128.959 0 0 0 128 256a128.9 128.9 0 0 0 20-1.555V165h29.825"/></svg>
                                        </button>
                                    </li>
                                        <li>
                                            <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 256 209"><path fill="#55acee" d="M256 25.45a105.04 105.04 0 0 1-30.166 8.27c10.845-6.5 19.172-16.793 23.093-29.057a105.183 105.183 0 0 1-33.351 12.745C205.995 7.201 192.346.822 177.239.822c-29.006 0-52.523 23.516-52.523 52.52c0 4.117.465 8.125 1.36 11.97c-43.65-2.191-82.35-23.1-108.255-54.876c-4.52 7.757-7.11 16.78-7.11 26.404c0 18.222 9.273 34.297 23.365 43.716a52.312 52.312 0 0 1-23.79-6.57c-.003.22-.003.44-.003.661c0 25.447 18.104 46.675 42.13 51.5a52.592 52.592 0 0 1-23.718.9c6.683 20.866 26.08 36.05 49.062 36.475c-17.975 14.086-40.622 22.483-65.228 22.483c-4.24 0-8.42-.249-12.529-.734c23.243 14.902 50.85 23.597 80.51 23.597c96.607 0 149.434-80.031 149.434-149.435c0-2.278-.05-4.543-.152-6.795A106.748 106.748 0 0 0 256 25.45"/></svg>
                                            </button>
                                        </li>
                                        <li>
                                        <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 256 256"><g fill="none"><rect width="256" height="256" fill="url(#skillIconsInstagram0)" rx="60"/><rect width="256" height="256" fill="url(#skillIconsInstagram1)" rx="60"/><path fill="#fff" d="M128.009 28c-27.158 0-30.567.119-41.233.604c-10.646.488-17.913 2.173-24.271 4.646c-6.578 2.554-12.157 5.971-17.715 11.531c-5.563 5.559-8.98 11.138-11.542 17.713c-2.48 6.36-4.167 13.63-4.646 24.271c-.477 10.667-.602 14.077-.602 41.236s.12 30.557.604 41.223c.49 10.646 2.175 17.913 4.646 24.271c2.556 6.578 5.973 12.157 11.533 17.715c5.557 5.563 11.136 8.988 17.709 11.542c6.363 2.473 13.631 4.158 24.275 4.646c10.667.485 14.073.604 41.23.604c27.161 0 30.559-.119 41.225-.604c10.646-.488 17.921-2.173 24.284-4.646c6.575-2.554 12.146-5.979 17.702-11.542c5.563-5.558 8.979-11.137 11.542-17.712c2.458-6.361 4.146-13.63 4.646-24.272c.479-10.666.604-14.066.604-41.225s-.125-30.567-.604-41.234c-.5-10.646-2.188-17.912-4.646-24.27c-2.563-6.578-5.979-12.157-11.542-17.716c-5.562-5.562-11.125-8.979-17.708-11.53c-6.375-2.474-13.646-4.16-24.292-4.647c-10.667-.485-14.063-.604-41.23-.604h.031Zm-8.971 18.021c2.663-.004 5.634 0 8.971 0c26.701 0 29.865.096 40.409.575c9.75.446 15.042 2.075 18.567 3.444c4.667 1.812 7.994 3.979 11.492 7.48c3.5 3.5 5.666 6.833 7.483 11.5c1.369 3.52 3 8.812 3.444 18.562c.479 10.542.583 13.708.583 40.396c0 26.688-.104 29.855-.583 40.396c-.446 9.75-2.075 15.042-3.444 18.563c-1.812 4.667-3.983 7.99-7.483 11.488c-3.5 3.5-6.823 5.666-11.492 7.479c-3.521 1.375-8.817 3-18.567 3.446c-10.542.479-13.708.583-40.409.583c-26.702 0-29.867-.104-40.408-.583c-9.75-.45-15.042-2.079-18.57-3.448c-4.666-1.813-8-3.979-11.5-7.479s-5.666-6.825-7.483-11.494c-1.369-3.521-3-8.813-3.444-18.563c-.479-10.542-.575-13.708-.575-40.413c0-26.704.096-29.854.575-40.396c.446-9.75 2.075-15.042 3.444-18.567c1.813-4.667 3.983-8 7.484-11.5c3.5-3.5 6.833-5.667 11.5-7.483c3.525-1.375 8.819-3 18.569-3.448c9.225-.417 12.8-.542 31.437-.563v.025Zm62.351 16.604c-6.625 0-12 5.37-12 11.996c0 6.625 5.375 12 12 12s12-5.375 12-12s-5.375-12-12-12v.004Zm-53.38 14.021c-28.36 0-51.354 22.994-51.354 51.355c0 28.361 22.994 51.344 51.354 51.344c28.361 0 51.347-22.983 51.347-51.344c0-28.36-22.988-51.355-51.349-51.355h.002Zm0 18.021c18.409 0 33.334 14.923 33.334 33.334c0 18.409-14.925 33.334-33.334 33.334c-18.41 0-33.333-14.925-33.333-33.334c0-18.411 14.923-33.334 33.333-33.334Z"/><defs><radialGradient id="skillIconsInstagram0" cx="0" cy="0" r="1" gradientTransform="matrix(0 -253.715 235.975 0 68 275.717)" gradientUnits="userSpaceOnUse"><stop stop-color="#FD5"/><stop offset=".1" stop-color="#FD5"/><stop offset=".5" stop-color="#FF543E"/><stop offset="1" stop-color="#C837AB"/></radialGradient><radialGradient id="skillIconsInstagram1" cx="0" cy="0" r="1" gradientTransform="matrix(22.25952 111.2061 -458.39518 91.75449 -42.881 18.441)" gradientUnits="userSpaceOnUse"><stop stop-color="#3771C8"/><stop offset=".128" stop-color="#3771C8"/><stop offset="1" stop-color="#60F" stop-opacity="0"/></radialGradient></defs></g></svg>
                                        </button>
                                    </li>
                                      <li>
                                        <button>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 256 258"><defs><linearGradient id="logosWhatsappIcon0" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#1FAF38"/><stop offset="100%" stop-color="#60D669"/></linearGradient><linearGradient id="logosWhatsappIcon1" x1="50%" x2="50%" y1="100%" y2="0%"><stop offset="0%" stop-color="#F9F9F9"/><stop offset="100%" stop-color="#FFF"/></linearGradient></defs><path fill="url(#logosWhatsappIcon0)" d="M5.463 127.456c-.006 21.677 5.658 42.843 16.428 61.499L4.433 252.697l65.232-17.104a122.994 122.994 0 0 0 58.8 14.97h.054c67.815 0 123.018-55.183 123.047-123.01c.013-32.867-12.775-63.773-36.009-87.025c-23.23-23.25-54.125-36.061-87.043-36.076c-67.823 0-123.022 55.18-123.05 123.004"/><path fill="url(#logosWhatsappIcon1)" d="M1.07 127.416c-.007 22.457 5.86 44.38 17.014 63.704L0 257.147l67.571-17.717c18.618 10.151 39.58 15.503 60.91 15.511h.055c70.248 0 127.434-57.168 127.464-127.423c.012-34.048-13.236-66.065-37.3-90.15C194.633 13.286 162.633.014 128.536 0C58.276 0 1.099 57.16 1.071 127.416Zm40.24 60.376l-2.523-4.005c-10.606-16.864-16.204-36.352-16.196-56.363C22.614 69.029 70.138 21.52 128.576 21.52c28.3.012 54.896 11.044 74.9 31.06c20.003 20.018 31.01 46.628 31.003 74.93c-.026 58.395-47.551 105.91-105.943 105.91h-.042c-19.013-.01-37.66-5.116-53.922-14.765l-3.87-2.295l-40.098 10.513l10.706-39.082Z"/><path fill="#FFF" d="M96.678 74.148c-2.386-5.303-4.897-5.41-7.166-5.503c-1.858-.08-3.982-.074-6.104-.074c-2.124 0-5.575.799-8.492 3.984c-2.92 3.188-11.148 10.892-11.148 26.561c0 15.67 11.413 30.813 13.004 32.94c1.593 2.123 22.033 35.307 54.405 48.073c26.904 10.609 32.379 8.499 38.218 7.967c5.84-.53 18.844-7.702 21.497-15.139c2.655-7.436 2.655-13.81 1.859-15.142c-.796-1.327-2.92-2.124-6.105-3.716c-3.186-1.593-18.844-9.298-21.763-10.361c-2.92-1.062-5.043-1.592-7.167 1.597c-2.124 3.184-8.223 10.356-10.082 12.48c-1.857 2.129-3.716 2.394-6.9.801c-3.187-1.598-13.444-4.957-25.613-15.806c-9.468-8.442-15.86-18.867-17.718-22.056c-1.858-3.184-.199-4.91 1.398-6.497c1.431-1.427 3.186-3.719 4.78-5.578c1.588-1.86 2.118-3.187 3.18-5.311c1.063-2.126.531-3.986-.264-5.579c-.798-1.593-6.987-17.343-9.819-23.64"/></svg> 
                                                                              
                                        </button>
                                    </li>
                                      <li>
                                        <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 256 256"><defs><linearGradient id="logosTelegram0" x1="50%" x2="50%" y1="0%" y2="100%"><stop offset="0%" stop-color="#2AABEE"/><stop offset="100%" stop-color="#229ED9"/></linearGradient></defs><path fill="url(#logosTelegram0)" d="M128 0C94.06 0 61.48 13.494 37.5 37.49A128.038 128.038 0 0 0 0 128c0 33.934 13.5 66.514 37.5 90.51C61.48 242.506 94.06 256 128 256s66.52-13.494 90.5-37.49c24-23.996 37.5-56.576 37.5-90.51c0-33.934-13.5-66.514-37.5-90.51C194.52 13.494 161.94 0 128 0Z"/><path fill="#FFF" d="M57.94 126.648c37.32-16.256 62.2-26.974 74.64-32.152c35.56-14.786 42.94-17.354 47.76-17.441c1.06-.017 3.42.245 4.96 1.49c1.28 1.05 1.64 2.47 1.82 3.467c.16.996.38 3.266.2 5.038c-1.92 20.24-10.26 69.356-14.5 92.026c-1.78 9.592-5.32 12.808-8.74 13.122c-7.44.684-13.08-4.912-20.28-9.63c-11.26-7.386-17.62-11.982-28.56-19.188c-12.64-8.328-4.44-12.906 2.76-20.386c1.88-1.958 34.64-31.748 35.26-34.45c.08-.338.16-1.598-.6-2.262c-.74-.666-1.84-.438-2.64-.258c-1.14.256-19.12 12.152-54 35.686c-5.1 3.508-9.72 5.218-13.88 5.128c-4.56-.098-13.36-2.584-19.9-4.708c-8-2.606-14.38-3.984-13.82-8.41c.28-2.304 3.46-4.662 9.52-7.072Z"/></svg>                                        
                                        </button>
                                    </li>
                                    </ul>
                                </div>
                                <div class="share-copy-links">
                                    <p>Copy URL</p>
                                    <ul class="d-flex align-items-center justify-centent-start gap-3 m-0 p-0">
                                        <li class="d-flex align-items-center justify-centent-start gap-1">
                                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M12.232 4.232a2.5 2.5 0 013.536 3.536l-1.225 1.224a.75.75 0 001.061 1.06l1.224-1.224a4 4 0 00-5.656-5.656l-3 3a4 4 0 00.225 5.865.75.75 0 00.977-1.138 2.5 2.5 0 01-.142-3.667l3-3z" />
                                            <path d="M11.603 7.963a.75.75 0 00-.977 1.138 2.5 2.5 0 01.142 3.667l-3 3a2.5 2.5 0 01-3.536-3.536l1.225-1.224a.75.75 0 00-1.061-1.06l-1.224 1.224a4 4 0 105.656 5.656l3-3a4 4 0 00-.225-5.865z" />
                                        </svg>
                                        <span>
                                            Lorem ipsum dolor sit.
                                        </span>
                                        </li>
                                        
                                        <li>
                                            <button class="copybutton">
                                                Copy
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="share-proceed">
                                    <button id="ShareModalButton">
                                        Proceed
                                    </button>
                                </div>
                               </div>
                        </div>
                    </div>
                </div>
            <!-- /////////////////share modal -->

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
                                    <div id='asset_o_upload_msg' class="logo-Img-container">
                                        <span class="" >Browse <br> Computer</span>
                                        <div class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="24px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </div>
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
        document.getElementById('openModalButton').addEventListener('click', function () {
            document.getElementById('myModal').style.display = 'block';
        });

        document.getElementById('closeModalButton').addEventListener('click', function () {
            document.getElementById('myModal').style.display = 'none';
        });
        document.getElementById('closeModalButtonOk').addEventListener('click', function () {
            document.getElementById('myModal').style.display = 'none';
        });
        document.getElementById('openShareModalButton').addEventListener('click', function () {
            document.getElementById('ShareModal').style.display = 'block';
        });

        document.getElementById('ShareModalButton').addEventListener('click', function () {
            document.getElementById('ShareModal').style.display = 'none';
        });
    </script>
 
@endsection
