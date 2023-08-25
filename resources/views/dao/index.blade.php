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
                    <div  class="card-join">
                        <div style="display:none;" class="lblJoin">
                            <p class="mb-0">join</p>
                        </div>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#myModal">
                        <div class="Deo_setting_btn">
                            <p class="mb-0">Deo settings</p>
                        </div>
                         </button>

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
                        <a href="{{ route('dao.proposal.create', 1) }}" style="width:200px; whitespace:no-wrap; "  class="btn btnCreate">
                            Create Proposal <img class="plu" src="{{ asset('images/11.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="endedCard">
        <div class="container">
            <div class="d-flex proposal_card_container">
                <div  class="proposal_right_card_container">
                <div class="row">
                <div class="cardEndDiv">
                    <div class="col-12">
                        <a href="{{ route('dao.proposal', [1,1]) }}" class="text-decoration-none">
                            <div class="d-flex justify-content-between align-items-center cardEndDetail_container">
                                    <div class="cardEndDetail">
                                        <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image">
                                        <div class="text">ByGBV6...SYEN</div>
                                    </div>

                                <div class="text">
                                        <span>Proposal ID:</span>
                                        <span>ByGBV6...SYEN</span>
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
                            <div class="carendBottom d-flex align-items-center">
                            <div class="small-card">
                                <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                <div class="small-card-text">Yes</div>
                            </div>
                            <div class="text">
                                    <span>Voted by:</span>
                                   <span>123 members</span>
                                </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="cardEndDiv">
                    <a href="{{ route('dao.proposal', [1,1]) }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between align-items-center cardEndDetail_container">
                            <div class="cardEndDetail">
                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image">
                                <div class="text">ByGBV6...SYEN</div>
                            </div>
                            <div class="">
                                <div class="text">
                                    <span>Proposal ID:</span>
                                   <span>ByGBV6...SYEN</span>
                                </div>
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
                        <div class="carendBottom d-flex align-items-center">
                            <div class="small-card">
                                <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                <div class="small-card-text">Yes</div>
                            </div>
                            <div class="text">
                                    <span>Voted by:</span>
                                   <span>123 members</span>
                                </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="cardEndDiv">
                    <a href="{{ route('dao.proposal', [1,1]) }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between align-items-center cardEndDetail_container">
                            <div class="cardEndDetail">
                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image">
                                <div class="text">ByGBV6...SYEN</div>
                            </div>
                            <div class="">
                                <div class="text">
                                    <span>Proposal ID:</span>
                                   <span>ByGBV6...SYEN</span>
                                </div>
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
                        <div class="carendBottom d-flex align-items-center">
                            <div class="small-card">
                                <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                <div class="small-card-text">Yes</div>
                            </div>
                            <div class="text">
                                 <span>Voted by:</span>
                                   <span>123 members</span>
                                </div>
                        </div>
                    </a>
                </div>
            </div>
                </div>
                     <div style="margin: top 15px; " class="proposal_status-card">
                        <div class="proposal_status-SideCard">
                                <h2 class="heading">Top Voters</h2>
                                <div class="paragraph">
                                    <p>Partipacipated <br> in Proposal</p>
                                </div>
                        </div>
                        <div class="">
                        <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">ByGBV6...SYEN</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">12</h2>
                                </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">ByGBV6...SYEN</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">9</h2>
                                </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">ByGBV6...SYEN</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">25 </h2>
                                </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">ByGBV6...SYEN</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">12 </h2>
                                </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">ByGBV6...SYEN</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">2</h2>
                                </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">ByGBV6...SYEN</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">32</h2>
                                </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">ByGBV6...SYEN</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">16</h2>
                                </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">ByGBV6...SYEN</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">12</h2>
                                </div>
                        </div>
                        </div>
                    </div>


            </div>

            <div class="container mt-5">


        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content proposal_modal-content">

                    <div class="proposal_modal-body">
                        <div class="">
                            <div class="d-flex justify-content-between">
                                <div style="position:relative; width:100px; height:100px;" class=" ">
                                    <div class="modal_edit_btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </div>
                                    <img style="width:100px; height: 100px; border-radius:50%;" src="https://images.unsplash.com/photo-1692823548942-99c19544da10?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1952&q=80" alt="">

                                </div>
                                <div class="">
                                        <div class="d-flex align-items-center gap-2">
                                                <span class="asset-stellar-p">Project Name:</span>
                                                <span class="asset-details-text">LUSOMDAO</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                                <span class="asset-stellar-p">Asset code:</span>
                                                    <span class="asset-details-text">LSP</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                                <span class="asset-stellar-p">Toml:</span>
                                                    <a style="text-decoration:none; color:blue;" href=""><span class="asset-details-text">lumenswap.io</span> </a>
                                        </div>
                                </div>
                                <div class=""></div>
                                <div class=""></div>

                            </div>
                            <div class="py-4">
                                    <div class="d-flex align-items-center asset-stellar-p">Description:
                                            <div style="margin-left:12px;"  class="modal_edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                                     <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                 </svg>
                                             </div>
                                    </div>
                                        <span class="asset-details-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Non inventore repudiandae consequuntur alias impedit! Et eaque ex quam deserunt mollitia quidem nobis quasi reiciendis exercitationem at, ducimus incidunt aliquid sed?</span>
                            </div>
                            <div class="">
                                    <div class="d-flex align-items-center asset-stellar-p">Approved walllets:
                                            <div style="margin-left:12px;"  class="modal_edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                                     <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                 </svg>
                                             </div>
                                    </div>
                                </div>
                                <div class="">
                                <div class="d-flex align-items-center justify-content-between py-2 modal-code-editor-container">
                                        <div class="column-content">
                                            <span>QWIQWIBQ.......QWIQHI</span>

                                        </div>
                                        <div class="column-content">
                                            <span>QWIQWBQ.......QWIQHI</span>

                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between py-2 modal-code-editor-container">
                                        <div class="column-content">
                                            <span>QWIQWBQ.......QWIQHQ</span>

                                        </div>
                                        <div class="column-content">
                                            <span>QWIQWBBQ.......QWIBXQ</span>

                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </section>
@endsection
