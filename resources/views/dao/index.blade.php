@extends('layouts.app')
 
@section('content')
<section class="leadingBoard">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading-board">
                        <p class="headingBoard">Board</p>
                        <span class="rightArrow"> > </span>
                        <p id='dao_name_head' class="apple-text"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section class="main-card-link">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div  class="card-join w-100">
                        <div style="display:none;" class="lblJoin">
                            <p class="mb-0">join</p>
                        </div>
                        <button id='dao_setting' style='display:none' type="button" data-bs-toggle="modal" data-bs-target="#myModal">
                        <div class="Deo_setting_btn">
                            <p class="mb-0">DAO Settings</p>
                        </div>
                         </button>
                         <div style="margin:-45px -20px -30px !important; height:230px;" class="">
                                <img id='dao_cover_image' style="object-fit: cover; object-fit:center;" class="h-100 w-100 rounded object-cover" data="https://images.unsplash.com/photo-1513151233558-d860c5398176?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                        <div class="card-imgflex mt-1">
                            <img id='dao_image' data="{{ asset('images/demi.jpg') }}" alt="">
                            <div class="cardHeading mt-4 py-2">
                                <p id='dao_name' class="card-heading whitespace-nowrap"></p>
                                <p id='dao_members' class="card-subheading whitespace-nowrap"></p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-3 py-3 w-100 mt-4">
                            <button id='manageAdminBut' class="btn btn-success whitespace-nowrap" data-toggle="modal"
                                data-target="#manageAdmin">Manage
                                Admins</button>
                            <a id='inbox' href="{{route('proposal.inbox')}}">
                                <button class="btn btn-secondary">Send message</button>
                            </a>
                            <button class='btn btn-danger whitespace-nowrap' id='leaveDao' style='border:2px solid red;display:no ne'>Leave Dao</button>
                        </div>
                        </div>
                        <div id='dao_about' class="card-paragraph whitespace-nowrap">
                        </div>

                       <div class="">
                            <div class="d-flex">
                                <div class="card-small-div">
                                    <span class="card-bold-word whitespace-nowrap">Assets:</span>
                                    <a id='asset_name' href="#" target='_blank' class="card-link whitespace-nowrap d-flex align-items-center gap-3" ><span id='dao_token_name'></span><img id='dao_token_img' src="{{ asset('images/topright.png') }}" style='' alt=""></a>
                                </div>
                                <div class="card-small-div flex-column align-items-start">
                                    <span class="card-bold-word whitespace-nowrap">Website:</span>
                                    <a id='dao_website' target='_blank' href="#" class="card-link whitespace-nowrap d-inline-block text-truncate"></a>
                                </div>
                                <div class="card-small-div flex-column align-items-start">
                                    <span class="card-bold-word whitespace-nowrap">Toml url:</span>
                                    <a id='dao_token_url' target='_blank' href="#" class="card-link whitespace-nowrap text-truncate"></a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 py-3">
                                <div class="card-imgflex-social-link " style='display:none'>
                                    <a id='dao_twitter' href="">
                                        <img src="{{ asset('images/twiter.png') }}" alt="">
                                    </a>
                                </div>
                                <div class="card-imgflex-social-link" style='display:none'>
                                    <a id='dao_instagram' href="">
                                    <img  src="{{ asset('images/instagram.jpeg') }}" alt="">
                                </a>
                                </div>
                               <div class="card-imgflex-social-link" style='display:none'>
                                 <a id='dao_discord' href="">
                                    <img  src="{{ asset('images/discord.png') }}" alt="">
                                </a>
                               </div>
                               <div class="card-imgflex-social-link" style='display:none'>
                                 <a id='dao_reddit' href="">
                                   <img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAASFBMVEVHcEz/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/NAD/PwD/aDr/s5z/nH7/e1b/WyT/xLH/imj/4NX/8ev///9xkjBnAAAADHRSTlMAFFyk2vT9KO//iszHtZsMAAABSElEQVR4AWxSB7aDMAxjg6md7XD/m35s/PqTtmJkSImUMfxjnOZl3bZ1madx+MY+H/DGMe8f9Hiu0GE9x274C77w2hu+mb3x2X/zSDeQGsXYzk/Oh5hiLiQuT44TGlDgzFyvmkRxqsHaCXJASnxdTgSrmMzQgR2JTyQQzHeCLiE51oLIVjIOU0sTloxGPpjUQTkgcMEz+5KIpG0ei9IQHRa+DBwxOVDJMqzqXO/eqwHf77OOYZPN89pb68Na4fGmtkZQY9LSp1IbgW6Tk56MlIQAwix6s9CQWMQ3YRBBQZA8ATXks0yK6mE5WctCukzbqFSvHuYAk201BekLOpSDqD3ZVttWkpeYyZXiUpYqmMP7uFHHVWYtJKEed3NhKAUhReTFX3B2V44IXCwlOiDjX+PnpSUFGP6GK1kj5AllHEJZj8jMSzD7AwBb/yl65xYVzAAAAABJRU5ErkJggg==" alt="">
                                </a>
                               </div>
                               <div class="card-imgflex-social-link" style='display:none'>
                                 <a id='dao_telegram' href="">
                                      <img src="data:image/jpeg;base64,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" alt="">
                                </a>
                               </div>
                               
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="manageAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content cardEndDiv p-0 fa-ctn fa-modal-content">
                <div class="d-flex align-items-center justify-content-end w-100">
                <button type="button" class="close p-3 pb-0 m-0 border-0 bg-transparent" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body px-4 py-0 w-100">
                    <div class="form-group">
                        <label for="">
                            <span class="asset-details-label mb-0">Add new admin:</span>
                        </label>
                        <div class="d-flex flex-column flex-md-row align-items-end gap-2">
                            <input oninput='searchAdminUser()' id="dao_search_admin" type="text" class="form-control h-auto mt-1">
                            <button onclick='searchAdminUser()' class="btn btn-secondary px-2 py-1.5"><small>Search</small></button>
                        </div>
                    </div>
                    <div id='addNewAdmin' class="m-0 mt-0 mt-md-5 p-0" style='display:none'>
                        <p class="mb-0 text-success manage-admin-heading">Address founded</p>
                        <div
                            class="d-flex flex-column align-items-center justify-content-between gap-1 mb-2 new-admin-ctn">
                            <div id='dao_search_admin_result' style='width:100%;max-height:300px;overflow:auto'>
                                
                            </div>
                            <!--<div class="d-flex flex-column flex-md-row align-items-start align-md-items-center gap-1 w-100">-->
                            <!--    <img class="" src="{{asset('/images/discord.png')}}" alt="">-->
                            <!--    <p id='dao_search_admin_found' class="mb-0  column-content text-truncate text-break text-wrap"></p>-->
                            <!--</div>-->
                            <div class="mb-3" id='dao_admin_rules'>
                                <span class="text new-admin-note">
                                    <strong class="text-danger">Note:</strong>
                                    Before you confirm, make sure to read the admin authorities.
                                </span>
                                <div class="text-left w-100 d-flex flex-column flex-md-row align-items-start align-md-items-center justify-content-between mt-3 px-1.5 px-md-0">
                                    <div class="d-flex align-items-center justify-content-start px-0 px-md-3">
                                        <input id="manageAdminCheck" type="checkbox">
                                        <label class="new-admin-note" for="">I have read the admin authorities</label>
                                    </div>
                                    <button id="manageAdminConfirm" class="btn btn-success text-white text mt-2 mt-md-0"><small>Confirm</small></button>
                                </div>
                            </div>

                            <div class="d-flex align-items-end justify-content-end gap-2 mb-0 w-100">
                            </div>
                        </div>

                    </div>
                    <div class="m-0 py-2 p-0">
                        <p class="mb-0 text-danger manage-admin-heading">All Admins</p>
                        <div id='dao_admin_lists' style='width:100%;max-height:300px;overflow:auto'>
                                
                        </div>
                        <!--<div-->
                        <!--    class="d-flex flex-column align-items-center justify-content-between gap-1 mb-2 new-admin-ctn">-->
                        <!--    <div class="d-flex flex-column flex-md-row align-items-start align-md-items-center gap-1 w-100">-->
                        <!--        <img class="" src="{{asset('/images/discord.png')}}" alt="">-->
                        <!--        <p class="mb-0  column-content text-truncate inline-block text-break text-wrap">FGDKXQTCPOJVVBBYSNADBDSJBASD2MRK2DXKZANU3I</p>-->
                        <!--    </div>-->
                        <!--    <div class="d-flex align-items-start align-md-items-end justify-content-start justify-content-md-end gap-2 mt-2 w-100">-->
                        <!--        <button class="btn btn-danger text-white text "><small>Remove</small></button>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end gap-3 modal-footer m-0 p-0 py-3 px-3 w-100">
                    <button type="button" class="btn btn-warning text ">Save</button>
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
                    <h2 class="heading">DAO Admins</h2>
                    <button style="margin-bottom: 0.5rem;" type="button"
                        class="border-0 bg-transparent d-flex align-items-center py-1 justify-content-center  text-secondary"
                        data-toggle="tooltip" data-placement="right"
                        title="Approved wallets are managed by the project team and listed in the project's toml file. They ensure transparency in governance and decision-making.">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" width="22px" height="22px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
        <div class="addressLink">
            <div class="row" id='dao_others_address'>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <strong class="text-success">DAO Creator</strong>
                    <div class="column-content">
                        <p id='dao_token_creator'></p>
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
                        <a id='createProposal' href="{{ route('dao.proposal.create', 'PROPOSAL_CREATE') }}" style="width:200px; whitespace:no-wrap;display:none;margin-left:auto; "  class="btn btnCreate">
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
            <div class="proposal_right_card_container">
                <div class="">
                    <ul class="nav nav-tabs pro-nav-tabs" id="myTabs">
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link active" id="tab1" data-toggle="tab"
                                href="#content1">Proposals</a>
                        </li>
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link" id="tab2" data-toggle="tab" href="#content2">Bulletins</a>
                        </li>
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link" id="tab3" data-toggle="tab" href="#content3">Members</a>
                        </li>
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link" id="tab4" data-toggle="tab" href="#content4">Delegates</a>
                        </li>
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link" id="tab5" data-toggle="tab" href="#content5">Proposals in
                                Review</a>
                        </li>
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link" id="tab6" data-toggle="tab" href="#content6">Proposal
                                Funds</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="content1">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                    <div class="col-12" id="proposal_views">
                                        <div style='font-size:20px; margin:60px;'><center>Loading Proposals...</center></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="tab-pane fade show" id="content2">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                <div class="d-flex flex-column align-items-end gap-2 px-1">
                                        <div class="form-group w-100">
                                           <div class="d-flex align-items-center justify-content-between">
                                           <label for="">
                                                <span class="asset-details-label whitespace-nowrap">Add Bulletin:</span>
                                            </label>
                                            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#addPollingModal">Add Polls</button>
                                           </div>
                                            <textarea type="text" class="form-control h-auto" rows="4"></textarea>
                                        </div>
                                        <div class="">
                                            <button type="button" class="btn btnCreate border-0 mb-1 mt-0">
                                                <p class="mb-0 text-white">Submit</p>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <div class="d-flex flex-wrap justify-content-between">
                                            <div class="cardEndDetail">
                                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                    alt="Profile Image" class="image">
                                                <div class="text text-center">FGDKXQTCP.....DXKZANU3I
                                                </div>
                                            </div>
                                            <div class="text text-muted">12/02/2023</div>
                                        </div>
                                        <div class="bultin_description text">
                                            <p>We will introduce an incentivized referral program, rewarding existing
                                                LumosDAO members for bringing in new users. This program will encourage
                                                community growth while rewarding loyal members who contribute to
                                                expanding
                                                our user base.</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-start gap-3 bullet-icon">
                                            <button id="like"
                                                class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start gap-3">
                                                <i id="like-icn" class="fa fa-thumbs-o-up"></i>
                                                <span class="text text-muted">Like</span>
                                            </button>
                                            <button id="dislike"
                                                class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start gap-3">
                                                <i id="dislike-icn" class="fa fa-thumbs-o-down"></i><span
                                                    class="text text-muted">Dislike</span>
                                            </button>
                                            <button id="comment"
                                                class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start gap-3">
                                                <i id="" class="fa fa-comment-o "></i><span
                                                    class="text text-muted">Comment</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bullet-icon">
                                        <div id="commentSec" class="cardEndDetail">
                                            <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                alt="Profile Image" class="image w-img">
                                            <div id="comment-pl" class="column-content">
                                                <div class="text">
                                                    <p class="text font-weight-bold">Admin</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- commnets -->
                                    <div id="comment-box" style="width: 90%; margin-right:auto;margin-left:40px;"
                                        class="d-flex align-items-end gap-4 mt-5">
                                        <div class="form-group w-100">
                                            <label for="">
                                                <span class="asset-details-label whitespace-nowrap">Write a
                                                    comment:</span>
                                            </label>

                                            <div class="form-control d-flex align-items-center justify-content-between">
                                                <input id="comment-input" type="text" placeholder="Great...."
                                                    class="border-0 bg-transparent text w-100 h-100">
                                                <button id="comment-send" type="button" class="btn border-0 mb-1">
                                                    <svg class="text-secondary" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="m2 21l21-9L2 3v7l15 2l-15 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="row">
                                            <div class="poll-card cardEndDiv">
                                                <div class="">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="cardEndDetail d-flex justify-content-between gap-3">
                                                            <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                                alt="Profile Image" class="image w-img">
                                                            <div class="text text-center">
                                                                FGDKXQTCP.....DXKZANU3I
                                                            </div>
                                                        </div>
                                                        <div class="text text-muted">12/02/2023|05:23 pm</div>
                                                    </div>
                                                    <div class="text m-4">
                                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Reiciendis
                                                            quis dolore, quidem saepe facere assumenda aperiam,
                                                            quibusdam
                                                            pariatur fugiat illum sunt natus, eum consectetur.
                                                            Exercitationem
                                                            excepturi, quos consectetur error itaque explicabo harum
                                                            corrupti,
                                                            quibusdam ipsam voluptatibus similique modi dignissimos?
                                                            Excepturi
                                                            sequi, ad dolores minus tempore sunt quod iste autem nulla.
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="options">

                                                    <div class="option option-1">
                                                        <div class="analytic">
                                                            <div class="bar"></div>
                                                            <div class="percent">50%</div>
                                                        </div>
                                                        <div class="input">
                                                            <input class="poll-input" type="radio" id="option-1"
                                                                name="option" hidden>
                                                            <label class="option-lable" for="option-1">1. Java&nbsp;<i
                                                                    class="fa fa-check tick" aria-hidden="true"></i>
                                                            </label>
                                                        </div>

                                                    </div>

                                                    <div class="option option-2">
                                                        <div class="analytic">
                                                            <div class="bar"></div>
                                                            <div class="percent">50%</div>
                                                        </div>
                                                        <div class="input">
                                                            <input class="poll-input" type="radio" id="option-2"
                                                                name="option" hidden>
                                                            <label class="option-lable" for="option-2">2. Python&nbsp;<i
                                                                    class="fa fa-check tick"
                                                                    aria-hidden="true"></i></label>
                                                        </div>
                                                    </div>

                                                    <div class="option option-3">
                                                        <div class="analytic">
                                                            <div class="bar"></div>
                                                            <div class="percent">50%</div>
                                                        </div>
                                                        <div class="input">
                                                            <input class="poll-input" type="radio" id="option-3"
                                                                name="option" hidden>
                                                            <label class="option-lable" for="option-3">3.
                                                                JavaScript&nbsp;<i class="fa fa-check tick"
                                                                    aria-hidden="true"></i></label>
                                                        </div>
                                                    </div>

                                                    <div class="option option-4">
                                                        <div class="analytic">
                                                            <div class="bar"></div>
                                                            <div class="percent">50%</div>
                                                        </div>
                                                        <div class="input">
                                                            <input class="poll-input" type="radio" id="option-4"
                                                                name="option" hidden>
                                                            <label class="option-lable" for="option-4">4. Don't
                                                                Judge&nbsp;<i class="fa fa-check tick"
                                                                    aria-hidden="true"></i></label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal fade" id="addPollingModal" tabindex="-1" aria-labelledby="addPollingModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header px-4 py-1">
                                            <h2 class="heading" id="addPollingModal">Add Polls</h2>
                                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="p-4">
                                        <div id="poll">
                                            <label for=""><p class="m-0 p-0">Write a question?</p></label>
                                            <textarea class="form-control h-auto mb-2" name="" id="" cols="30" rows="2" placeholder="Write Question here:"></textarea>
                                            <form class="" id="pollForm">
                                                <div class="poll-option d-flex align-items-center justify-content-between gap-2">
                                                    <input class="pollingInput" type="text" name="option[]" placeholder="Option 1">
                                                </div>
                                                <div class="poll-option d-flex align-items-center justify-content-between gap-2">
                                                    <input class="pollingInput" type="text" name="option[]" placeholder="Option 2">
                                                </div>
                                                <button class="btn btn-secondary mt-2" type="button" id="addOption">Add Option</button>
                                            </form>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancle</button>
                                            <button type="button" class="btn btn-warning">Submit</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                            </div>   
                        </div>
                        <div class="tab-pane fade" id="content3">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                    <div class="d-flex flex-column gap-4">
                                        <div id="memberList" class="d-flex justify-content-between">
                                            <div class="cardEndDetail d-flex justify-content-between gap-3">
                                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                    alt="Profile Image" class="image w-img">
                                                <div class="text text-center">
                                                    FGDKXQTCPDXKZANU3IFGDKXQTCPDXKZANU3I
                                                </div>
                                            </div>
                                            <div class="member-ban-ctn">
                                                <button id="memBan-btn" class="btn p-0">
                                                    <div class="text text-muted">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            width="20px" height="20px">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                        </svg>
                                                    </div>
                                                </button>
                                                <div class="member-ban-modal">
                                                    <button class="btn">Ban member</button>
                                                    <button class="btn">Messeage</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content4">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                    <div class="d-flex align-items-end gap-4">
                                        <div class="form-group w-100">
                                            <label for="">
                                                <span class="asset-details-label whitespace-nowrap">Wallet
                                                    Address:</span>
                                            </label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="">
                                            <button type="button" class="btn btnCreate border-0 mb-1">
                                                <p class="mb-0 text-white">Search</p>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <div class="mb-2">
                                            <span class="text-sm text-success text">Member founded</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="cardEndDetail">
                                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                    alt="Profile Image" class="image">
                                                <div class="text text-center">FGDKXQTCPOJVVBBYTCPOJVVBBY2MRK2DXKZANU3I
                                                </div>
                                            </div>
                                            <div class="">
                                                <button type="button"
                                                    class="btn btn-success text-white text d-flex align-items-center gap-2 mb-0">
                                                    Confirm Delegation
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" width="20px" height="20px">
                                                        <path fill-rule="evenodd"
                                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content5">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                    <div class="col-12 pb-3">
                                        <a href="http://127.0.0.1:8000/dao/1/proposal/1" class="text-decoration-none">
                                            <div
                                                class="d-flex justify-content-between align-items-md-center cardEndDetail_container">
                                                <div class="text">
                                                    <span>Created by:</span>
                                                    <span>ByGBV6...SYEN</span>
                                                </div>

                                                <div class="text">
                                                    <span>Proposal ID:</span>
                                                    <span>ByGBV6...SYEN</span>
                                                </div>

                                                <div class="small-card">
                                                    <div class="small-card-text">Pending</div>
                                                </div>
                                            </div>
                                            <div class="cardendHeading">
                                                <h2 class="heading">Incentivized Referral Program</h2>
                                                <div class="paragraph">
                                                    <p>We will introduce an incentivized referral program, rewarding
                                                        existing
                                                        LumosDAO members for bringing in new users. This program will
                                                        encourage
                                                        community growth while rewarding loyal members who contribute to
                                                        expanding
                                                        our user base.</p>
                                                </div>
                                            </div>
                                            <div
                                                class="carendBottom d-flex align-items-center justify-content-between w-100">
                                                <div class="d-flex align-items-center justify-content-end gap-3">
                                                    <button type="button"
                                                        class="btn btn-success text-white text d-flex align-items-center gap-2 mb-0">
                                                        Approve
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-danger text-white text d-flex align-items-center gap-2 mb-0">
                                                        Reject
                                                    </button>
                                                </div>
                                                <div class="text d-none">
                                                    <span>Voted by:</span>
                                                    <span>123 members</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12 p-3 border-top">
                                        <a href="http://127.0.0.1:8000/dao/1/proposal/1" class="text-decoration-none">
                                            <div
                                                class="d-flex justify-content-between align-items-md-center cardEndDetail_container">
                                                <div class="text">
                                                    <span>Created by:</span>
                                                    <span>GBEE...FSH8OJ</span>
                                                </div>

                                                <div class="text">
                                                    <span>Proposal ID:</span>
                                                    <span>ByGBV6...SYEN</span>
                                                </div>

                                                <div class="small-card">
                                                    <div class="small-card-text">Pending</div>
                                                </div>
                                            </div>
                                            <div class="cardendHeading">
                                                <h2 class="heading">Incentivized Referral Program</h2>
                                                <div class="paragraph">
                                                    <p>We will introduce an incentivized referral program, rewarding
                                                        existing
                                                        LumosDAO members for bringing in new users. This program will
                                                        encourage
                                                        community growth while rewarding loyal members who contribute to
                                                        expanding
                                                        our user base.</p>
                                                </div>
                                            </div>
                                            <div
                                                class="carendBottom d-flex align-items-center justify-content-between w-100">
                                                <div class="d-flex align-items-center justify-content-end gap-3 d-none">
                                                    <button type="button"
                                                        class="btn btn-success text-white text d-flex align-items-center gap-2 mb-0">
                                                        Approve
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-danger text-white text d-flex align-items-center gap-2 mb-0">
                                                        Reject
                                                    </button>
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
                        </div>
                        <div class="tab-pane fade" id="content6">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                    <div class="col-12">
                                        <a href="http://127.0.0.1:8000/dao/1/proposal/1" class="text-decoration-none">
                                            <div
                                                class="d-flex justify-content-between align-items-center cardEndDetail_container">
                                                <div class="text">
                                                    <span>Created by: GBEE...FSH8OJ</span>
                                                    <span>ByGBV6...SYEN</span>
                                                </div>

                                                <div class="text">
                                                    <span>Proposal ID:</span>
                                                    <span>ByGBV6...SYEN</span>
                                                </div>

                                                <div class="small-card">
                                                    <div class="small-card-text">Signatures (2/3)</div>
                                                </div>
                                            </div>
                                            <div class="cardendHeading">
                                                <h2 class="heading">A Decentralized initiative for Sustainable
                                                    Development</h2>
                                                <div class="paragraph">
                                                    <p>We will introduce an incentivized referral program, rewarding
                                                        existing
                                                        LumosDAO members for bringing in new users. This program will
                                                        encourage
                                                        community growth while rewarding loyal members who contribute to
                                                        expanding
                                                        our user base.</p>
                                                </div>
                                            </div>
                                            <div class="carendBottom d-flex align-items-center justify-content-between">
                                                <div class="text">
                                                    <span class="heading"><small>Requested Budget:</small></span>
                                                    <span>200,000 SHAKE</span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <button type="button"
                                                        class="btn btn-success text-white text d-flex align-items-center gap-2 mb-0">
                                                        Confirm
                                                    </button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
          <div class="d-flex flex-column tweet-ctn">
          <div style="margin-top: 40px; max-height:500px; overflow-y:scroll" class="proposal_status-card w-100 py-3 example">
                <div class="proposal_status-SideCard sticky top-0">
                    <div class="d-flex align-items-start justify-content-start gap-2">
                        <h2 class="heading">Tweets</h2>
                        <button style="margin-bottom: 0.5rem;" type="button"
                            class="border-0 bg-transparent d-flex align-items-center  justify-content-center  text-secondary"
                            data-toggle="tooltip" data-placement="right"
                            title="Discover the active members of this DAO who consistently participate in voting on proposals. Their engagement drives the decision-making process.">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" width="22px" height="22px">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-3 border rounded p-3">
                    <div class="card-imgflex justify-content-between card-join">
                        <div class="card-imgflex">
                            <img class="w-img" src="{{asset('/images/discord.png')}}" alt="Image">
                            <div class="cardHeading">
                                <span class="card-heading"><small>Artisan Lsut</small></span>
                                <p class="card-subheading">@asrtlust</p>
                            </div>
                        </div>
                        <img style="object-fit: contain !important;" class="w-img" src="/images/blank-twitter.png"
                            alt="">
                    </div>
                    <p class="my-2">
                        <small>This <span class="text-info">line</span> of text is meant to be treated as fine print
                            <span class="text-info">Lorem ipsum</span> dolor sit, amet consectetur adipisicing elit.
                            Aspernatur, molestiae..</small>
                    </p>
                    <div class="d-flex justify-content-between">
                        <small class="text-secondary">12 days ago</small>
                        <small class="text-secondary">Retweeted by justin</small>
                    </div>
                </div>
                <div class="mt-3 border rounded p-3">
                    <div class="card-imgflex justify-content-between card-join">
                        <div class="card-imgflex">
                            <img class="w-img" src="{{asset('/images/discord.png')}}" alt="Image">
                            <div class="cardHeading">
                                <span class="card-heading"><small>Artisan Lsut</small></span>
                                <p class="card-subheading">@asrtlust</p>
                            </div>
                        </div>
                        <img style="object-fit: contain !important;" class="w-img" src="/images/blank-twitter.png"
                            alt="">
                    </div>
                    <p class="my-2">
                        <small>This <span class="text-info">line</span> of text is meant to be treated as fine print
                            <span class="text-info">Lorem ipsum</span> dolor sit, amet consectetur adipisicing elit.
                            Aspernatur, molestiae..</small>
                    </p>
                    <div class="d-flex justify-content-between">
                        <small class="text-secondary">12 days ago</small>
                        <small class="text-secondary">Retweeted by justin</small>
                    </div>
                </div>
                <div class="mt-3 border rounded p-3">
                    <div class="card-imgflex justify-content-between card-join">
                        <div class="card-imgflex">
                            <img class="w-img" src="{{asset('/images/discord.png')}}" alt="Image">
                            <div class="cardHeading">
                                <span class="card-heading"><small>Artisan Lsut</small></span>
                                <p class="card-subheading">@asrtlust</p>
                            </div>
                        </div>
                        <img style="object-fit: contain !important;" class="w-img" src="/images/blank-twitter.png"
                            alt="">
                    </div>
                    <p class="my-2">
                        <small>This <span class="text-info">line</span> of text is meant to be treated as fine print
                            <span class="text-info">Lorem ipsum</span> dolor sit, amet consectetur adipisicing elit.
                            Aspernatur, molestiae..</small>
                    </p>
                    <div class="d-flex justify-content-between">
                        <small class="text-secondary">12 days ago</small>
                        <small class="text-secondary">Retweeted by justin</small>
                    </div>
                </div>

            </div>

                
                     <div id='topVoters' style="margin: top 15px; disp lay:none" class="proposal_status-card w-100">
                        <div class="proposal_status-SideCard">
                            <div class="d-flex align-items-start justify-content-start gap-2">
                               <h2 class="heading">Top Voters</h2>
                               <button style="margin-bottom: 0.5rem;" type="button" class="border-0 bg-transparent d-flex align-items-center  justify-content-center  text-secondary" data-toggle="tooltip" data-placement="right" title="Discover the active members of this DAO who consistently participate in voting on proposals. Their engagement drives the decision-making process.">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                </button>
                            </div>

                                <div class="paragraph">
                                    <p>Participated <br> in Proposal</p>
                                </div>
                        </div>
                        <div id='topVotersView' class="">
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
            <div class="">


        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content proposal_modal-content">

                    <div class="proposal_modal-body">
                        <div class="">
                            <div class="d-flex justify-content-between">
                                <div style="position:relative; width:100px; height:100px;" class=" ">
                                    <div class="modal_edit_btn" onclick='enableEdit("image")' style='cursor:pointer'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </div>
                                    <img style="width:100px; height: 100px; border-radius:50%;" id='dao_save_img' alt="Dao">
                                    <input id='dao_save_image_edit' type='file' style='visibility:hidden' />
                                </div>
                                <div class="">
                                        <div class="d-flex align-items-center gap-2 EditModal-title">
                                                <span   class="asset-stellar-p w-60">Project Name:</span>
                                                <span class="asset-details-text w-40" id='dao_save_name'></span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 EditModal-title">
                                                <span class="asset-stellar-p w-60">Asset Code:</span>
                                                    <span class="asset-details-text w-40" id='dao_save_code'></span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 EditModal-title">
                                                <span style=" font-family: 'MontReg';" class="asset-stellar-p w-60">Home Domian:</span>
                                                    <a style="text-decoration:none; color:blue;" id='dao_save_domain_href' href="">
                                                    <span style="color: #578aff;" class="asset-details-text w-40" id='dao_save_domain'></span>
                                                 </a>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 EditModal-title">
                                                <span style=" font-family: 'MontReg';" class="asset-stellar-p w-60">Toml:</span>
                                                    <a style="text-decoration:none; color:blue;" id='dao_save_toml_url' href="">
                                                    <span style="color: #578aff;" class="asset-details-text w-40" id='dao_save_toml'></span>
                                                 </a>
                                        </div>
                                </div>
                                <div class=""></div>
                                <div class=""></div>

                            </div>
                            <div class="py-4">
                                    <div class="d-flex align-items-center asset-stellar-p">Description:
                                            <div style="margin-left:12px;cursor:pointer"  class="modal_edit" onclick='enableEdit("about")'>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                                     <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                 </svg>
                                             </div>
                                    </div>
                                         <div style="font-family:'MontReg';" id='dao_save_about' class="asset-details-text "></div>
                                         <input class='form-control' placeholder='Description....' id='dao_save_about_edit' style='display:none' />
                                   
                            </div>
                            <div class="">
                                    <div class="d-flex align-items-center asset-stellar-p">Approved Wallets:
                                            <div style="margin-left:12px;"  class="modal_edit" onclick='enableEdit("address")'>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24px">
                                                     <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                 </svg>
                                             </div>
                                    </div>
                                </div>
                                <div class="">
                                <div id='dao_save_address' class="d-flex align-items-center justify-content-between gap-3 py-2 modal-code-editor-container">
                                        
                                         
                                </div>
                                    <div id='dao_save_address_view'>
                                        <input class='form-control' placeholder='Wallet name....' id='dao_save_address_name_edit' style='margin-bottom:10px'/>
                                        <input class='form-control' placeholder='Wallet address....' id='dao_save_address_edit' style='margin-bottom:10px'/>
                                        <div class="d-flex align-items-center justify-content-end w-100">
                                        <button id='dao_save_addr_add' class='Deo_setting_btn px-4' style='position:relative;margin-right:15px'>Add</button>
                                        <button id='dao_save_addr_cancel' class='Deo_setting_btn py-0' style='position:relative;background:none;
                                                border:1px solid #333257;color:#333257'>Cancel</button>
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
                                                <input id='dao_save_insta' type="text" name="facebook">
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1 col-sm">
                                            <div class="card-imgflex-social-link">
                                                <label for="">
                                                 <img src="data:image/jpeg;base64,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" alt="">
                                                </label>
                                            </div>
                                            <div class="socail-profile">
                                                <input id='dao_save_tele' type="text" name="facebook">
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
                                                <input type="text" id='dao_save_twitter' name="facebook">
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-1 col-sm">
                                            <div class="card-imgflex-social-link">
                                                <label for="">
                                                <img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAASFBMVEVHcEz/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/NAD/PwD/aDr/s5z/nH7/e1b/WyT/xLH/imj/4NX/8ev///9xkjBnAAAADHRSTlMAFFyk2vT9KO//iszHtZsMAAABSElEQVR4AWxSB7aDMAxjg6md7XD/m35s/PqTtmJkSImUMfxjnOZl3bZ1madx+MY+H/DGMe8f9Hiu0GE9x274C77w2hu+mb3x2X/zSDeQGsXYzk/Oh5hiLiQuT44TGlDgzFyvmkRxqsHaCXJASnxdTgSrmMzQgR2JTyQQzHeCLiE51oLIVjIOU0sTloxGPpjUQTkgcMEz+5KIpG0ei9IQHRa+DBwxOVDJMqzqXO/eqwHf77OOYZPN89pb68Na4fGmtkZQY9LSp1IbgW6Tk56MlIQAwix6s9CQWMQ3YRBBQZA8ATXks0yK6mE5WctCukzbqFSvHuYAk201BekLOpSDqD3ZVttWkpeYyZXiUpYqmMP7uFHHVWYtJKEed3NhKAUhReTFX3B2V44IXCwlOiDjX+PnpSUFGP6GK1kj5AllHEJZj8jMSzD7AwBb/yl65xYVzAAAAABJRU5ErkJggg==" alt="">
                                                </label>
                                            </div>
                                            <div class="socail-profile">
                                                <input type="text" id='dao_save_reddit' name="facebook">
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
                                                <input type="text" id='dao_save_discord' name="facebook">
                                            </div>
                                        </div>


                                    </div>



                              </div>
                        </div>
                        
                        
                    </div>
                    <div class="d-flex justify-content-end">
                    <button id='dao_save_button' class="btn assetSearch w-25">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
   <script>
// Get references to DOM elements
const btnLike = document.getElementById('like');
const likeIcon = document.getElementById('like-icn');
const btnDisLike = document.getElementById('dislike');
const disLikeIcon = document.getElementById('dislike-icn');
const comment = document.getElementById('comment');
const commentBox = document.getElementById('comment-box');
const commentPlate = document.getElementById('comment-pl');
const commentSec = document.getElementById('commentSec');
const commentInput = document.getElementById('comment-input');
const commentSend = document.getElementById('comment-send');
const memBanBtn = document.getElementById('memBan-btn');
const memberBanModal = document.querySelector('.member-ban-modal');
var memberList = document.getElementById('memberList');
const manageAdminCheck = document.getElementById('manageAdminCheck');
const manageAdminConfirm = document.getElementById('manageAdminConfirm');
document.addEventListener('DOMContentLoaded', function() {
  const pollForm = document.getElementById('pollForm');
  const addOptionButton = document.getElementById('addOption');

  addOptionButton.addEventListener('click', function() {
    const optionContainer = document.createElement('div');
    optionContainer.classList.add('d-flex', 'align-items-center', 'gap-2');

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'option[]';
    input.classList ="pollingInput";
    input.placeholder = `Option ${document.querySelectorAll('.pollingInput').length + 1}`;

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.classList.add('removeOption' , 'btn' ,'text-danger', 'd-flex' ,'align-items-center');
    removeButton.innerHTML = `<i style="font-size:20px" class="fa">&#xf014;</i>`;
    removeButton.addEventListener('click', function() { 
      optionContainer.remove();
      updateAddOptionButton();
    });

    optionContainer.appendChild(input);
    optionContainer.appendChild(removeButton);
    pollForm.insertBefore(optionContainer, addOptionButton);
    updateAddOptionButton();
  });

  pollForm.addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(pollForm);
    const options = [];
    for (const value of formData.getAll('option[]')) {
      options.push(value);
    }
    console.log('Submitted Options:', options);
    // You can send the options to your server or perform other actions here
  });

  function updateAddOptionButton() {
    const optionInputs = document.querySelectorAll('.pollingInput');
    if (optionInputs.length >= 4) {
      addOptionButton.style.display = 'none';
    } else {
      addOptionButton.style.display = 'block';
    }
  }
});



manageAdminConfirm.classList.add('d-none');
manageAdminCheck.addEventListener('click', function() {
    if (manageAdminCheck.checked) {
        manageAdminConfirm.classList.remove('d-none');
    } else {
        manageAdminConfirm.classList.add('d-none');
    }
});


memBanBtn.classList.add('d-none');
commentBox.classList.add('d-none');
commentSec.classList.add('d-none');
memberBanModal.classList.add('d-none');
btnLike.addEventListener('click', function() {
    btnLike.classList.toggle('like-active');
    likeIcon.classList.add('fa-thumbs-up');
    btnDisLike.classList.remove('like-active');
    disLikeIcon.classList.remove('fa-thumbs-down');
});

btnDisLike.addEventListener('click', function() {
    btnDisLike.classList.toggle('like-active');
    disLikeIcon.classList.add('fa-thumbs-down');
    btnLike.classList.remove('like-active');
    likeIcon.classList.remove('fa-thumbs-up');
});

comment.addEventListener('click', function() {
    commentBox.classList.toggle('d-none');
});

commentSend.addEventListener('click', function() {
    commentSec.classList.remove('d-none');
    let newComment = document.createElement('small');
    newComment.textContent = commentInput.value;
    commentPlate.appendChild(newComment);
    commentInput.value = '';
});

document.addEventListener('click', function(event) {
    if (!memberBanModal.contains(event.target) && !memBanBtn.contains(event.target)) {
        memberBanModal.classList.add('d-none');
    }
});

memberBanModal.addEventListener('click', function(event) {
    event.stopPropagation();
});
memBanBtn.addEventListener('click', function() {
    memberBanModal.classList.toggle('d-none');
});

memberList.addEventListener('mouseover', function() {
    memBanBtn.classList.remove('d-none');
});

memberList.addEventListener('mouseout', function() {
    memBanBtn.classList.add('d-none');
});
const options = document.querySelectorAll('.poll-input')
const analytics = document.querySelectorAll('.analytic')

votingData = {
    'option-1': 1,
    'option-2': 2,
    'option-3': 1,
    'option-4': 3
}

const getTotalVotes = () => {
    let totalVotes = 0
    for (i = 1; i <= 4; i++) {
        totalVotes += votingData[`option-${i}`]
    }
    return totalVotes
}

const displayResult = () => {
    var total = 0
    var widths = []
    options.forEach(option => {
        var ID = option.id
        option.parentNode.parentNode.querySelector('.percent').textContent = Math.floor(votingData[ID] /
            getTotalVotes() * 100) + '%'
        option.parentNode.parentNode.querySelector('.bar').style.width = Math.floor(votingData[ID] /
            getTotalVotes() * 100) + '%'
        total += Math.floor(votingData[ID] / getTotalVotes() * 100)
        widths.push(Math.floor(votingData[ID] / getTotalVotes() * 100))
    })
    options.forEach(option => {
        if (total < 100) {
            var min = Math.min(widths[0], widths[1], widths[2], widths[3])
            min += (100 - total)
        }
        option.parentNode.parentNode.querySelector('.analytic').style.display = 'block'
    })

}

const disableOptions = () => {
    options.forEach(option => {
        option.disabled = true
    })
}

options.forEach(option => {
    option.addEventListener('click', e => {
        e.preventDefault()
        option.style.color = 'display:none;'
        var option_id = e.target.id
        votingData[option_id] += 1

        var analytic = e.target.parentNode.parentNode.querySelector('.analytic')
        var bar = analytic.querySelector('.bar')
        bar.style.backgroundColor = 'skyblue'
        var percent = analytic.querySelector('.percent')
        e.target.parentNode.parentNode.querySelector('.tick').style.display = 'inline'
        displayResult()
        disableOptions()
    })
})
</script>
    <script>
        /* INDEX FUNCTIONS GO HERE */
        var dao;var daoUsers;
        /* RETRIEVE THE DAO SPECIFIC INFORMATION */
        const indexMain = async () => { 
           let _dao = (window.location + "").substring((window.location + "").lastIndexOf("/") + 1)
           dao = await getDao(_dao) ;  
           daoUsers = await getDaoUsersP(dao.name); 
           E('inbox').href += "?dao=" + _dao + "&name=" + dao.name
           E('createProposal').href = E('createProposal').href.replace('PROPOSAL_CREATE', `${dao.name}:${dao['token']}`)
           E('createProposal').style.display = 'block'
           //check if ts a member of this dao
           const isMember = await getTokenUserBal(dao.token, walletAddress)
           if(isMember !== false && dao.owner != walletAddress) {
              E('leaveDao').style.display = 'block'
           }
           else {
              E('leaveDao').style.display = 'none'
           }
           E('asset_name').href = 'https://stellar.expert/explorer/testnet/asset/' + dao.code + "-" + dao.issuer 
           if(dao['proposals'] != undefined) {
               setUp(); 
               //check if this asset was hosted here 
               if(dao.toml.DOCUMENTATION.ORG_URL.indexOf("<?php echo $_SERVER['HTTP_HOST']; ?>") > -1 ) {
                   //check if its an approved wallet
                   if(dao.issuer == walletAddress || dao.toml.ACCOUNTS.includes(walletAddress)){
                       E('dao_setting').style.display = 'block'
                       E('manageAdminBut').style.display = 'block'
                   } 
               }
              
               //load info of all the proposals
               let prop; 
               if(dao.proposals != undefined){
                   if(dao.proposals.length > 0) {  
                        //declaring the function
                        const dispProposal = async () => {
                            prop = dao.proposals.pop(); 
                            if(prop != undefined && prop != "") {
                                let propId = prop;  
                                prop = await getProposal(prop);
                                if(prop['name'] != undefined) {
                                    prop.proposalId = propId; //attach id
                                    //append 
                                    temPropView.appendChild(drawProposal(prop)) 
                                }
                            }
                            //stop timer if all dao data has been read
                            if(dao.proposals.length != 0) {setTimeout(dispProposal, 5)}else{E('proposal_views').innerHTML = temPropView.innerHTML;temPropView.innerHTML = "";temPropView = null}
                        }
                        let temPropView = document.createElement('div') //hold proposal views, till they are done loading
                        const tmr = setTimeout(dispProposal, 10)
                   }
                   else { 
                       E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No proposal created yet<br>Be the first to create a proposal.</center></div>"
                   }
               }
               else {
                   E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No proposal created yet<br>Be the first to create a proposal.</center></div>"
               }
           }
           E('leaveDao').onclick = async() => {
              const id = talk("Getting ready")
              //first burn all the tokens
              const bal = await getTokenUserBal(dao.token, walletAddress)
              if(bal > 0) {
                 talk("First burning asset balance", 'norm', id)
                 //burn tokens first
                 await burnToken(bal, code, issuer)
              }
              talk("Leaving Dao", 'norm', id)
              const res = await leaveDao(dao.code, dao.issuer, _dao, dao.name)
              if(res.status === true) {
                  talk("You have left this Dao", 'good', id)
                  //hide button
                  E('leaveDao').style.display = 'none'
              }
              else {
                  talk("Something went wrong", 'fail', id)
              }
              stopTalking(4, id)
                  
           }
        }
        const setUp = async () => {
            if(dao['proposals'] != undefined) {
               E('dao_name').innerHTML = E('dao_name_head').innerHTML = E('dao_save_name').innerHTML = dao.name || "no name"
               E('dao_about').innerHTML = E('dao_save_about').innerHTML = dao.description || "Your friendly Lumos DAO community"
               E('dao_members').innerHTML = dao.members.toLocaleString() + ((dao.members > 1) ? " members" : " member")
               //get token info name
               E('dao_token_name').innerHTML = E('dao_save_code').innerHTML =  dao.code
               //get asset info from toml
               if(dao.url != ""){
                   const aToml = dao.toml
                   E('dao_token_url').innerHTML = E('dao_save_toml').innerHTML = E('dao_token_url').href = E('dao_save_toml_url').href = dao.url
                   E('dao_website').innerHTML = E('dao_website').href = E('dao_save_domain').innerHTML = E('dao_save_domain_href').href = (aToml.DOCUMENTATION != undefined) ? aToml.DOCUMENTATION.ORG_URL : ""
                   if(aToml.CURRENCIES){ 
                       const imgx = (dao.image || "");const coverImgx = imgx.replace((dao.code + dao.owner), "cover_" + (dao.code + dao.owner)); 
                       const isCoverValid = await isImageURLValid(coverImgx)
                       if(isCoverValid) {E('dao_cover_image').src = coverImgx + "?id=" + Math.random() * 1000}
                       E('dao_token_img').src = E('dao_save_img').src = E('dao_image').src = (dao.image || "") + "?id=" + Math.random() * 1000
                       //verify cover image
                       const temp = (dao.owner || "")
                       E('dao_others_address').innerHTML = ""
                       E('dao_others_address').appendChild(drawOtherAddress(temp, 'DAO Creator'))
                                
                    } 
                    //load approved address
                    E('dao_save_address').innerHTML = ""
                    E('dao_save_address').appendChild(drawAddress(dao.issuer))
                    if(aToml.ACCOUNTS) {
                        let flg = false;
                        E('dao_admin_lists').innerHTML = ""
                        //get account names if it exist
                        if(!aToml.WALLET_NAMES) {aToml.WALLET_NAMES = []} //not defined yet, define it
                        console.log(aToml.ACCOUNTS)
                        for(let i=0;i<aToml.ACCOUNTS.length;i++) {
                            //don't redraw the issuer
                            if(aToml.ACCOUNTS[i]){
                                E('dao_others_address').appendChild(drawOtherAddress(aToml.ACCOUNTS[i], aToml.WALLET_NAMES[aToml.ACCOUNTS[i]]))
                                //if admin
                                if(aToml.WALLET_NAMES[aToml.ACCOUNTS[i]] == 'admin') {
                                    E('dao_admin_lists').innerHTML += drawAdminUser({user:aToml.ACCOUNTS[i]})
                                }
                                else {
                                    E('dao_save_address').appendChild(drawAddress(aToml.ACCOUNTS[i], (aToml.WALLET_NAMES[aToml.ACCOUNTS[i]] || 'Others')))
                                }
                                flg = true
                            } 
                        }
                    }
                    if(E('dao_admin_lists').innerHTML == "") {
                        E('dao_admin_lists').parentElement.style.display = 'none'
                    }
                    E('dao_save_address_view').style.display = 'none'
                    //show top voters
                    //console.log(dao.top_voters)
                    //sort in descending order
                    dao.top_voters.sort((a, b) => N(b.vote - a.vote));
                    if(dao.top_voters.length > 0) {
                        E('topVotersView').innerHTML = ""
                        for(let i =0;i<dao.top_voters.length && i < 20;i++) {
                            E('topVotersView').appendChild(drawTopVoters(dao.top_voters[i]))
                        }
                        E('topVoters').style.display = "block"
                    }
                    else {
                        E('topVoters').style.display = "block"
                    }
                    //display links
                    const socials = aToml.DOCUMENTATION
                    if(socials.ORG_TWITTER != "") {
                        E('dao_twitter').href = E('dao_save_twitter').value = socials.ORG_TWITTER
                        E('dao_twitter').parentElement.style.display = 'flex' //show the icon
                    }else{E('dao_twitter').parentElement.style.display = 'none'} //hide the icon
                    
                    if(socials.ORG_TELEGRAM != "") {
                        E('dao_telegram').href = E('dao_save_tele').value = socials.ORG_TELEGRAM
                        E('dao_telegram').parentElement.style.display = 'flex' //show the icon
                    }else{E('dao_telegram').parentElement.style.display = 'none'} //hide the icon
                    
                    if(socials.ORG_REDDIT != "") {
                        E('dao_reddit').href = E('dao_save_redit').value = socials.ORG_REDDIT
                        E('dao_reddit').parentElement.style.display = 'flex' //show the icon
                    }else{E('dao_reddit').parentElement.style.display = 'none'} //hide the icon
                    
                    if(socials.ORG_INSTAGRAM != "") {
                        E('dao_instagram').href = E('dao_save_insta').value = socials.ORG_INSTAGRAM
                        E('dao_instagram').parentElement.style.display = 'flex' //show the icon
                    }else{E('dao_instagram').parentElement.style.display = 'none'} //hide the icon
                    
                     if(socials.ORG_DISCORD != "") {
                        E('dao_discord').href = E('dao_save_discord').value = socials.ORG_DISCORD
                        E('dao_discord').parentElement.style.display = 'flex' //show the icon
                    }else{E('dao_discord').parentElement.style.display = 'none'} //hide the icon
               }
               E('dao_save_about_edit').style.display = 'none'
               E('dao_save_about').style.display = 'block'
               E('dao_save_image_edit').value = []  //reset file upload
               E('dao_save_about_edit').value = "" //reset description
               E('dao_save_address_edit').value = "" //reset approved address
               E('dao_save_address_name_edit').value = "" //reset approved address
               E('dao_save_button').disabled = false //enable save button
               E('dao_save_addr_add').disabled = false
               E('dao_save_addr_cancel').disabled = false
            }
        }
        //to enableEdit
        const enableEdit = (type) => {
            if(type == 'image') {
                //open select image
                validateImageUpload('dao_save_image_edit', 'dao_save_img', 2)
                E('dao_save_image_edit').click()
            }
            else if(type == 'about') {
                //make about div editable
                E('dao_save_about_edit').style.display = 'block'
                E('dao_save_about').style.display = 'none'
                E('dao_save_about_edit').value = E('dao_save_about').innerText
            }
            else if(type == 'address') {
                //make about div editable
                E('dao_save_address_view').style.display = 'block'
            }
        }
        //to save the changes to the toml file
        E('dao_save_button').onclick = async () => {
            //to update the dao toml file
            const fileInput = E('dao_save_image_edit');
            const saveSocials = async (id = null) => {
                //get all socials
                const insta = E('dao_save_insta').value.trim()
                const twitter = E('dao_save_twitter').value.trim()
                const tele = E('dao_save_tele').value.trim()
                const reddit = E('dao_save_reddit').value.trim()
                const discord = E('dao_save_discord').value.trim()
                if(insta != "" || twitter != "" || tele != "" || reddit != "" || discord != "") {
                    if(isSafeToml(insta) && isSafeToml(twitter) && isSafeToml(tele) && isSafeToml(reddit) && isSafeToml(discord)){
                        await new Promise((resolve) => setTimeout(resolve, 1000));
                        (id != null) ? talk("Saving social media links", "norm", id) : id = talk("Saving social media links")
                        modifyDao(dao.url, dao.code, 'social', insta+"||$$"+twitter+"||$$"+tele+"||$$"+reddit+"||$$"+discord, async (status) => {
                            if(status) {
                                talk("Socials updated successfully", "good", id)
                                //save back the results
                                dao.toml.DOCUMENTATION.ORG_TWITTER = twitter
                                dao.toml.DOCUMENTATION.ORG_INSTAGRAM = insta
                                dao.toml.DOCUMENTATION.ORG_TELEGRAM = tele
                                dao.toml.DOCUMENTATION.ORG_REDDIT = reddit
                                dao.toml.DOCUMENTATION.ORG_DISCORD = discord
                                setUp()
                                stopTalking(3, id)
                            }
                            else {
                                talk("Unable to update social media links<br>Something went wrong<br>This may be due to network error", "fail", id)
                                stopTalking(3, id)
                                E('dao_save_button').disabled = false
                            }
                        })
                    }
                    else {
                        const msg  = "Invalid characters(\") present in the social media links.<br> Please remove it and try again";
                        (id != null) ? talk(msg,'fail', id) : id = talk(msg, 'fail')
                        stopTalking(3, id)
                        E('dao_save_button').disabled = false
                    }
                }
                else {
                    if(id != null) stopTalking(1, id)
                    setUp()
                }
                
            }
            const saveDesc = (id = null) => {
                const desc = E('dao_save_about_edit').value.trim()
                if(desc != "") {
                    if(isSafeToml(desc)){
                        (id != null) ? talk("Saving description", "norm", id) : id = talk("Saving description")
                        modifyDao(dao.url, dao.code, 'about', desc, async (status) => {
                            if(status) {
                                talk("Description updated successfully", "good", id)
                                //resetting description input
                                E('dao_save_about_edit').value = ""
                                //hiding the input element
                                E('dao_save_about_edit').style.display = 'none'
                                E('dao_save_about').style.display = 'block'
                                //save back the results
                                dao.description = desc
                                saveSocials(id)
                            }
                            else {
                                talk("Unable to update description<br>Something went wrong<br>This may be due to network error", "fail", id)
                                stopTalking(3, id)
                                E('dao_save_button').disabled = false
                            }
                        })
                    }
                    else {
                        const msg  = "Invalid characters(\") present in description.<br> Please remove it and try again";
                        (id != null) ? talk(msg,'fail', id) : id = talk(msg, 'fail')
                        stopTalking(3, id)
                        E('dao_save_button').disabled = false
                    }
                }
                else {
                    saveSocials(id)
                }
                
            }
            if(fileInput.files.length !== 0) {
                E('dao_save_button').disabled = true
                const id = talk("Saving new image")
                modifyAssetImg(dao.code + dao.issuer, async (status) => {
                    if(status) {
                        talk("Image updated successfully", "good", id)
                        E('dao_save_image_edit').value = [] //resetting image upload
                    }
                    else {
                        talk("Unable to modify image<br>Something went wrong<br>This may be due to network error", "fail", id)
                    }
                    //time to mint the asset
                    await new Promise((resolve) => setTimeout(resolve, 1000));
                    saveDesc(id)
                })
            }
            else {saveDesc()}
        }
        //to hide the save address input field
        E('dao_save_addr_cancel').onclick = () => {
            E('dao_save_address_view').style.display = 'none'
        }
        //to add the address
        E('dao_save_addr_add').onclick = async () => {
             const addr = E('dao_save_address_edit').value.trim()
             const addr_name = E('dao_save_address_name_edit').value.trim()
             if(addr != "" && addr_name) {
                 if(isSafeToml(addr) && isSafeToml(addr_name)) {
                    E('dao_save_addr_add').disabled = true
                    E('dao_save_addr_cancel').disabled = true
                    //call trustline function
                   const id = talk("Checking address", "norm")
                   await new Promise((resolve) => setTimeout(resolve, 1000));
                   if((await getTokenUserBal(dao.token, addr)) !== false) {
                       //save the address to the toml
                       modifyDao(dao.url, dao.code, 'address', addr + "|@$$@|" + addr_name, async (status) => {
                            if(status) {
                                talk("Address approved successfully", "good", id)
                                //resetting description input
                                E('dao_save_address_edit').value = ""
                                //save back the results
                                if(dao.toml.ACCOUNTS != undefined) {dao.toml.ACCOUNTS = []}
                                if(dao.toml.WALLET_NAMES != undefined) {dao.toml.WALLET_NAMES = []}
                                if(!dao.toml.ACCOUNTS.includes(addr)) {dao.toml.ACCOUNTS.push(addr)}
                                dao.toml.WALLET_NAMES[addr] = addr_name
                                setUp()
                                stopTalking(3, id)
                            }
                            else {
                                talk("Unable to approve address<br>Something went wrong<br>This may be due to network error", "fail", id)
                                stopTalking(3, id)
                            }
                            E('dao_save_addr_add').disabled = false
                            E('dao_save_addr_cancel').disabled = false
                        })
                   }
                   else {
                       const msg  = "This address has not established a trustline yet<br>Please establish a trustline and try again";
                       stopTalking(4, talk(msg,'fail', id))
                   }
                 }   
                 else {
                     const msg  = "Invalid characters(\") present in description.<br> Please remove it and try again";
                     stopTalking(4, talk(msg,'fail'))
                 }
             }
             else {
                  const msg  = "Empty field present";
                  stopTalking(4, talk(msg,'fail'))
             }
        }
        //to add dao admins
        E('manageAdminConfirm').onclick = async () => {
             const addr = E('dao_search_admin').value.trim()
             const addr_name = "Admin"
             if(addr != "" && addr_name) {
                 if(isSafeToml(addr) && isSafeToml(addr_name)) {
                    E('manageAdminConfirm').disabled = true
                    //call trustline function
                   const id = talk("Checking address", "norm")
                   await new Promise((resolve) => setTimeout(resolve, 1000));
                   if((await getTokenUserBal(dao.token, addr)) !== false) {
                       //save the address to the toml
                       modifyDao(dao.url, dao.code, 'address', addr + "|@$$@|" + addr_name, async (status) => {
                            if(status) {
                                talk("Admin added successfully", "good", id)
                                //resetting description input
                                E('dao_search_admin').value = ""
                                //save back the results
                                if(dao.toml.ACCOUNTS != undefined) {dao.toml.ACCOUNTS = []}
                                if(dao.toml.WALLET_NAMES != undefined) {dao.toml.WALLET_NAMES = []}
                                if(!dao.toml.ACCOUNTS.includes(addr)) {dao.toml.ACCOUNTS.push(addr)}
                                dao.toml.WALLET_NAMES[addr] = addr_name
                                setUp()
                                stopTalking(3, id)
                            }
                            else {
                                talk("Unable to set admin<br>Something went wrong<br>This may be due to network error", "fail", id)
                                stopTalking(3, id)
                            }
                            E('manageAdminConfirm').disabled = false
                        })
                   }
                   else {
                       const msg  = "This address is not a memeber of this DAO<br>Please establish a trustline and try again";
                       stopTalking(4, talk(msg,'fail', id))
                   }
                 }   
                 else {
                     const msg  = "Invalid characters(\") present in description.<br> Please remove it and try again";
                     stopTalking(4, talk(msg,'fail'))
                 }
             }
             else {
                  const msg  = "Empty field present";
                  stopTalking(4, talk(msg,'fail'))
             }
        }
        //to search dao admin
        const searchAdminUser = () => {
            const search = E('dao_search_admin_result')
            search.innerHTML = "" 
            const addr = E('dao_search_admin').value.trim()
            if(addr != "") {
                for(let i=0;i<daoUsers.length;i++) {
                    if(daoUsers[i] == addr) {  
                        //present 
                        search.innerHTML = drawUser({
                            user:daoUsers[i] 
                        })
                    }
                }
                if(search.innerHTML == "") {
                    search.innerHTML = ` 
                    <center style='margin:40px'>Nothing found</center> 
                    `
                    E('dao_admin_rules').style.display = 'none'
                }
                else {
                    E('dao_admin_rules').style.display = ''
                }
                E('addNewAdmin').style.display = ''
            }
            else {
                E('addNewAdmin').style.display = 'none'
            }
        }
        const modifyAssetImg = (assetName, callback) => {
              const fileInput = E('dao_save_image_edit');
              const formData = new FormData(); // Create a FormData object
             // Add the selected file to the FormData object
              formData.append('file', fileInput.files[0]);
              // Create an HTTP request
              const xhr = new XMLHttpRequest();
             const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=upload&name=" + assetName + ".png"
              // Define the server endpoint (PHP file)
              xhr.open('POST', url, true);
              // Set up an event listener to handle the response
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) { console.log(xhr.responseText)
                    if (xhr.responseText == "1") {callback(true)}else{callback(false)}
                }
                else if (xhr.readyState === 4 && xhr.status !== 200) {
                    callback(false)
                }
              };
             // Send the FormData object with the image
              xhr.send(formData);
        }
        const modifyDao = (domain, assetName, type, value, callback) => {  
              // Create an HTTP request
              domain = new URL(domain).hostname.split('.')[0]
              const xhr = new XMLHttpRequest();
              const url = window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=modify${type}&name=` + assetName + "&value=" + encodeURIComponent(value) + "&domain=" + domain
              console.log(url)
              // Define the server endpoint (PHP file)
              xhr.open('POST', url, true);
              // Set up an event listener to handle the response
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {  
                    if (xhr.responseText == "1") {callback(true)}else{callback(false)}
                }
                else if (xhr.readyState === 4 && xhr.status !== 200) {
                    callback(false)
                }
              };
              // Send the FormData object with the image
              xhr.send();
        }
      
        //Listen for modal up and reload details
        const observer = new MutationObserver((mutationsList, observer) => {
          for (const mutation of mutationsList) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
              // Check if the 'display' property has changed
              const currentDisplay = E('myModal').style.display;
              if (currentDisplay === 'none') {
                setUp()
              }else {setUp()}
            }
          }
        });
        // Start observing the target element
        observer.observe(E('myModal'), { attributes: true, attributeFilter: ['style'] });
        const drawProposal = (prop) => {
                let _div = document.createElement('div')
                let n = prop.creator.substring(0,4) + "..." + prop.creator.substring(prop.creator.length - 5)
                let h = prop.voters + ((prop.voters > 1) ? " members" : " member")
                _div.innerHTML = ` <div class="row">
                    <div class="cardEndDiv">
                        <div class="col-12">
                            <a href="{{ route('dao.proposal', ['proposal_id' => " ", "dao_id"=> $dao_id]) }}${prop.proposalId}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center cardEndDetail_container">
                                        <div class="cardEndDetail">
                                            <img style='display:none' alt="Profile Image" class="image">
                                            <div class="text">Created by: ${n}</div>
                                        </div>
    
                                    <div class="text">
                                            <span>Proposal ID:</span>
                                            <span>PROP_${prop.proposalId}</span>
                                        </div>
    
                                    <div class="small-card">
                                        <div class="small-card-text">${(prop.status == 0) ? "Ended" : "Active"}</div>
                                    </div>
                                </div>
                                <div class="cardendHeading">
                                    <h2 class="heading">${prop.name}</h2>
                                    <div class="paragraph">
                                        <p>${prop.description}</p>
                                    </div>
                                </div>
                                <div class="carendBottom d-flex align-items-center">
                                <div class="small-card" style='display:${(prop.status == 0) ? "" : "none"}'>
                                    <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                    <div class="small-card-text">${(prop.yes_votes > prop.no_votes) ? "Yes" : "No"}</div>
                                </div>
                                <div class="text">
                                        <span>Voted by:</span>
                                       <span>${h}</span>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>`
                return _div.firstElementChild
                    
            }
        const drawAddress = (addr, name = "") => {
            let tm = document.createElement('div')
            tm.innerHTML = `<div class="column-content">${name}<br><span>${fAddr(addr, 8)}</span></div>`
            return tm.firstElementChild
        }
        const drawOtherAddress = (addr, addrName) => {
            let tm = document.createElement('div')
            tm.innerHTML = `<div class="col-lg-4 col-md-12 col-sm-12">
                    <strong class="text-success" style='text-transform:capitalize'>${addrName}</strong>
                    <div class="column-content">
                        <p>${fAddr(addr)}</p>
                    </div>
                </div>`
            return tm.firstElementChild
        } 
        const drawTopVoters = (param = {voter:"", vote:""}) => {
            let tm = document.createElement('div')
            tm.innerHTML = ` <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img style='display:none' src="" alt="">
                                    <span class="">${param.voter.substring(0, 6) + "..." + param.voter.substring(param.voter.length - 6)}</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">${param.vote}</h2>
                                </div>
                        </div>`
            return tm.firstElementChild
        }
        const drawUser = (params) => {
            return `<div class="d-flex flex-column flex-md-row align-items-start align-md-items-center gap-1 w-100">
                                <img class="" src="{{asset('/images/discord.png')}}" alt="">
                                <p id='dao_search_admin_found' class="mb-0  column-content text-truncate text-break text-wrap">
                                ${params.user.substring(0,14) + "..." + params.user.substring(params.user.length-14)}</p>
                            </div>`
        }
        const drawAdminUser = (params) => {
            return `<div
                            class="d-flex flex-column align-items-center justify-content-between gap-1 mb-2 new-admin-ctn">
                            <div class="d-flex flex-column flex-md-row align-items-start align-md-items-center gap-1 w-100">
                                <img class="" src="{{asset('/images/discord.png')}}" alt="">
                                <p class="mb-0  column-content text-truncate inline-block text-break text-wrap">
                                 ${params.user.substring(0,14) + "..." + params.user.substring(params.user.length-14)}</p>
                            </div>
                            <div class="d-flex align-items-start align-md-items-end justify-content-start justify-content-md-end gap-2 mt-2 w-100">
                                <button class="btn btn-danger text-white text "><small>Remove</small></button>
                            </div>
                        </div>`
        }
        indexMain() //run the main function
    </script>
@endsection