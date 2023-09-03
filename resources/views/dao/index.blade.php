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
                            <p class="mb-0">DAO Settings</p>
                        </div>
                         </button>

                        <div class="card-imgflex">
                            <img src="{{ asset('images/demi.jpg') }}" alt="Image">
                            <div class="cardHeading">
                                <p class="card-heading">Apple</p>
                                <p class="card-subheading">6,296 members</p>
                            </div>
                        </div>
                        <div class="card-paragraph">Apple is a decentralized exchange built on the Stellar network that
                            allows you to swap and trade assets using a friendly, minimal interface.
                        </div>

                        <div class="d-flex flex-col-links">
                            <div class="card-small-div">
                                <span class="card-bold-word">Assets:</span>
                                <a href="#" class="card-link">AAPL<img src="{{ asset('images/topright.png') }}" alt=""></a>
                            </div>
                            <div class="card-small-div">
                                <span class="card-bold-word">Website:</span>
                                <a href="#" class="card-link">apple.com</a>
                            </div>
                            <div style="margin-left:20px;" class="d-flex align-items-center gap-3 py-3">
                                <div class="card-imgflex-social-link ">
                                    <a href="">
                                    <img src="{{ asset('images/twiter.png') }}" alt="">
                                    </a>
                                </div>
                                <div class="card-imgflex-social-link">
                                    <a href="">
                                    <img  src="{{ asset('images/instagram.jpeg') }}" alt="">
                                </a> 
                                </div>
                               <div class="card-imgflex-social-link">
                                 <a href="">
                                    <img  src="{{ asset('images/discord.png') }}" alt="">
                                </a>
                               </div>
                               
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
                    <div class="d-flex align-items-center gap-2">
                         <h2 class="heading">Approve Wallet </h2>
                    <button style="margin-bottom: 0.5rem;" type="button" class="border-0 bg-transparent d-flex align-items-center py-1 justify-content-center  text-secondary" data-toggle="tooltip" data-placement="right" title="Tooltip on top">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                      </svg>
                    </button>
                    </div>
                   
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
                            <div class="d-flex align-items-center gap-2">
                                <h2 class="heading">Proposals</h2>
                                <button style="margin-bottom: 0.5rem;" type="button" class="border-0 bg-transparent d-flex align-items-center py-1 justify-content-center  text-secondary" data-toggle="tooltip" data-placement="right" title="Tooltip on top">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                </button>
                            </div>
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
                            <div class="d-flex align-items-start justify-content-start gap-2">
                               <h2 class="heading">Top Voters</h2> 
                               <button style="margin-bottom: 0.5rem;" type="button" class="border-0 bg-transparent d-flex align-items-center  justify-content-center  text-secondary" data-toggle="tooltip" data-placement="right" title="Tooltip on top">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                </button>
                            </div>
                                
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
                                        <div class="d-flex align-items-center gap-2 EditModal-title">
                                                <span   class="asset-stellar-p w-60">Project Name:</span>
                                                <span class="asset-details-text w-40">LUSOMDAO</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 EditModal-title">
                                                <span class="asset-stellar-p w-60">Asset Code:</span>
                                                    <span class="asset-details-text w-40">LSP</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 EditModal-title">
                                                <span style=" font-family: 'MontReg';" class="asset-stellar-p w-60">Home Domian:</span>
                                                    <a style="text-decoration:none; color:blue;" href="">
                                                    <span style="color: #578aff;" class="asset-details-text w-40">lumenswap.io</span>
                                                 </a>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 EditModal-title">
                                                <span style=" font-family: 'MontReg';" class="asset-stellar-p w-60">Toml:</span>
                                                    <a style="text-decoration:none; color:blue;" href="">
                                                    <span style="color: #578aff;" class="asset-details-text w-40">LUMOSDAO</span>
                                                 </a>
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
                                        <span style="font-family:'MontReg';" class="asset-details-text ">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Non inventore repudiandae consequuntur alias impedit! Et eaque ex quam deserunt mollitia quidem nobis quasi reiciendis exercitationem at, ducimus incidunt aliquid sed?</span>
                            </div>
                            <div class="">
                                    <div class="d-flex align-items-center asset-stellar-p">Approved Wallets:
                                            <div style="margin-left:12px;"  class="modal_edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                                     <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                 </svg>
                                             </div>
                                    </div>
                                </div>
                                <div class="">
                                <div class="d-flex align-items-center justify-content-between gap-3 py-2 modal-code-editor-container">
                                        <div class="column-content">
                                            <span>QWIQWIBQ.......QWIQHI</span>

                                        </div>
                                        <div class="column-content">
                                            <span>QWIQWBQ.......QWIQHI</span>

                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between gap-3 py-2 modal-code-editor-container">
                                        <div class="column-content">
                                            <span>QWIQWBQ.......QWIQHQ</span>

                                        </div>
                                        <div class="column-content">
                                            <span>QWIQWBBQ.......QWIBXQ</span>

                                        </div>
                                    </div>
                                </div>

                        </div>
                        <div class="">
                        <div class="asset-stellar-p">Social Profile:
                              <div class="container socail-profile">
                                    <div class="row gap-4">
                                         <div class="d-flex align-items-center gap-1 col-sm ">
                                            <div class="card-imgflex-social-link">
                                                <label for="">
                                                <img  src="{{ asset('images/instagram.jpeg') }}" alt="">
                                                </label>
                                            </div>
                                            <div class="socail-profile">
                                                <input type="text" id="facebook" name="facebook">
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1 col-sm">
                                            <div class="card-imgflex-social-link">
                                                <label for="">
                                                <img  src="data:image/jpeg;base64,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" alt="">
                                                </label>
                                            </div>
                                            <div class="socail-profile">
                                                <input type="text" id="facebook" name="facebook">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gap-4">
                                         <div class="d-flex align-items-center gap-1 col-sm">
                                            <div class="card-imgflex-social-link">
                                                <label for="">
                                                <img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFwAAABcCAMAAADUMSJqAAAAZlBMVEX///8AAADS0tL09PT8/Pzs7Oz39/dxcXG4uLiQkJA3NzdERETw8PDj4+NhYWEhISEmJianp6fd3d3AwMCYmJhqamp/f39TU1MUFBSxsbGenp7IyMiHh4d4eHgPDw8/Pz8uLi5LS0tKhQpiAAAEQklEQVRoga1Z63qqMBAURLxV0apVW6v4/i95vspOSMhsLnjmX9Nkgc3O7MXJrNBRTrLxKUfX1evPRcB6tu2NHLxUsnDSjc8zbdc7ObgxKxfd+iHP+Nr350/AMdMc23M5tLAXv7q1a9njKvu2GbaXcubbXe4csyIPLK7JtvE+w4squ+Uve20le2eJtuHcs/cf+aIfa8lEbJptBOGq9v/XvefF/s83dyHH9C67P/QHn+y1p+z/jNuu1sG9334UQRlW9ICDrWzVeHH27w/KcIvZRmjttQ0f5P7wQhEF2xck2lzIex6tparp1ppKPTXpg/AU2nTy70QIUPwGjiFmw1dTd5tae+1W+AxwMZMgbCIy9ENcJ0S9a0erVh6/UTYY/PqviY/WHHqOfpp5jcZ/TYTCgp6Ayqbom1ygI7RPOc+IDYlYJtg2Cma/iBCAyJ1hWTAILaz86zmICY9/pf5YDlEwh6hw7CAgoD0NUVkF4kZGVFfap0j1qenkD6KejKhHsi+vdJKv3dl6gtxrPRHlTmb1IZnW0RO5514/luxjUrD13wkpEtKOVB9QWQUS2ZSonYf1VB+HRLZDVBGRVw7Hd7RBndcgkc2IOu9T/YUpQhwoTu0QBlEPk3Cqj0Mi+2GviSAXyKxxldUgCd2WOxBVoKb6BLQ+/0rbdn4Q+pYcoh572zm1NcHSREcPlL7uZYzBA9HRAwG+y+o4GDYBokZzfRR7wnGJw/Zt45OnH3TTwo/RcZgRJ4CoI9rrARYkNoRe97eNw8WOE4SooeI0DfXddwIqvMwER3AIEDW9pNAgLnaKqvV/kYA/XHwnIIrS22sN0EI7cVzJ2jgcdaI+3zaOVG8TtSZrYwAldHMmnviegtXGNiXqW8JePXrjbiu9e1/BtoUNRtTxCoauXp7RkJlJO9Y2GqobvoDNTEbWAQiJbZ8kGFFHOQZefdgPIjMTtb0OYHZxzkpx6hBV2ovcyanf1VfyLHvmVRFnJQFdvfFo6T7sBTgrs5gmU0uZjziDlZu58gwg2zgN1QqBaUGcl6NgvKtnpMRaurTDvUO9xveQCi9xctqzo/UCeE0+6EwcqGPaqJ8KcbezJ8ib1iI9iWuBPXnugkSRBnT1fPB0Jrch5E2Qdkz7lOkz+lHHxaQuo0DVoJaCiFKbqBJd4clpH4QByonb2MwkXJyCEqGuHt25kyQk1YYa36koX7irh1rZlhCjgeIUrWAkZNGoE6Lq7owN8IFKygqHqNtQAOf8NlSSnaieuIKBfNFfESY9GcjMhE6PEL9pui+342ihXAVhH4IwsSrGdjbc9IpTsDr5d0TUS2S4OVSwOnmAbyDSzlqxgYKlD/ANkFEYUR0FyxngG0DiSIV3sZaQGjNrbXDOpvx1+DkIwtyGG/nNBn5dhH9Bt+T8bXAg1gXy66cZLY3otue69Zfu1HqqT8Bdt76wfiYd19qUuvFi9g8Ygyg1+jrBOQAAAABJRU5ErkJggg==" alt="">
                                                </label>
                                            </div>
                                            <div class="socail-profile">
                                                <input type="text" id="facebook" name="facebook">
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1 col-sm">
                                            <div class="card-imgflex-social-link">
                                                <label for="">
                                                <img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAASFBMVEVHcEz/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/NAD/PwD/aDr/s5z/nH7/e1b/WyT/xLH/imj/4NX/8ev///9xkjBnAAAADHRSTlMAFFyk2vT9KO//iszHtZsMAAABSElEQVR4AWxSB7aDMAxjg6md7XD/m35s/PqTtmJkSImUMfxjnOZl3bZ1madx+MY+H/DGMe8f9Hiu0GE9x274C77w2hu+mb3x2X/zSDeQGsXYzk/Oh5hiLiQuT44TGlDgzFyvmkRxqsHaCXJASnxdTgSrmMzQgR2JTyQQzHeCLiE51oLIVjIOU0sTloxGPpjUQTkgcMEz+5KIpG0ei9IQHRa+DBwxOVDJMqzqXO/eqwHf77OOYZPN89pb68Na4fGmtkZQY9LSp1IbgW6Tk56MlIQAwix6s9CQWMQ3YRBBQZA8ATXks0yK6mE5WctCukzbqFSvHuYAk201BekLOpSDqD3ZVttWkpeYyZXiUpYqmMP7uFHHVWYtJKEed3NhKAUhReTFX3B2V44IXCwlOiDjX+PnpSUFGP6GK1kj5AllHEJZj8jMSzD7AwBb/yl65xYVzAAAAABJRU5ErkJggg==" alt="">
                                                </label>
                                            </div>
                                            <div class="socail-profile">
                                                <input type="text" id="facebook" name="facebook">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gap-4">
                                         <div class="d-flex align-items-center gap-1 col-sm">
                                            <div class="card-imgflex-social-link">
                                                <label for="">
                                                <img  src="data:image/png;base64,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" alt="">
                                                </label>
                                            </div>
                                            <div class="socail-profile">
                                                <input type="text" id="facebook" name="facebook">
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
    </div>
    </section>
@endsection
