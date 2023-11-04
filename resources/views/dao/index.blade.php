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
                    <div  class="card-join">
                        <div style="display:none;" class="lblJoin">
                            <p class="mb-0">join</p>
                        </div>
                        <button id='dao_setting' style='display:none' type="button" data-bs-toggle="modal" data-bs-target="#myModal">
                        <div class="Deo_setting_btn">
                            <p class="mb-0">DAO Settings</p>
                        </div>
                         </button>

                        <div class="card-imgflex">
                            <img id='dao_image' src="{{ asset('images/demi.jpg') }}" alt="Image">
                            <div class="cardHeading">
                                <p id='dao_name' class="card-heading"></p>
                                <p id='dao_members' class="card-subheading"></p>
                            </div>
                        </div>
                        <div id='dao_about' class="card-paragraph">
                        </div>

                        <div class="d-flex flex-col-links">
                            <div class="card-small-div">
                                <span class="card-bold-word">Assets:</span>
                                <a id='asset_name' href="#" class="card-link" ><span id='dao_token_name'></span><img id='dao_token_img' src="{{ asset('images/topright.png') }}" style='max-width:50px;max-height:50px' alt=""></a>
                            </div>
                            <div class="card-small-div">
                                <span class="card-bold-word">Website:</span>
                                <a id='dao_website' target='_blank' href="#" class="card-link"></a>
                            </div>
                            <div class="card-small-div">
                                <span class="card-bold-word">Toml url:</span>
                                <a id='dao_token_url' target='_blank' href="#" class="card-link"></a>
                            </div>
                            <div style="margin-left:20px;" class="d-flex align-items-center gap-3 py-3">
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
    </section>
    <section class="approveWallet">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center gap-2">
                         <h2 class="heading">Approved Wallets </h2>
                    <button style="margin-bottom: 0.5rem;" type="button" class="border-0 bg-transparent d-flex align-items-center py-1 justify-content-center  text-secondary" data-toggle="tooltip" data-placement="right" title="Approved wallets are managed by the project team and listed in the project's toml file. They ensure transparency in governance and decision-making.">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                      </svg>
                    </button>
                    </div>

                </div>
            </div>
            <div class="addressLink">
                <div class="row" style='flex-direction:column'>
                    <div class="col-lg-4 col-md-12 col-sm-12" style='width:100%'>
                        <strong class="text-success">Issuing Address</strong>
                        <div class="column-content">
                            <p id='dao_token_issuer'></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12" style='width:100%'>
                        <strong class="text-success">Distributing Address</strong>
                        <div class="column-content">
                            <p id='dao_token_distributing'></p>
                        </div>
                    </div>
                     <div id='dao_others_address' class="col-lg-4 col-md-12 col-sm-12" style='width:100%;display:none' >
                        <strong class="text-success">Others</strong>
                        
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
                                <button style="margin-bottom: 0.5rem;" type="button" class="border-0 bg-transparent d-flex align-items-center py-1 justify-content-center  text-secondary" data-toggle="tooltip" data-placement="right" title="Browse through the proposals created by DAO members. Each proposal represents an idea or initiative that the community can vote on.">
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
                <div  class="proposal_right_card_container" id="proposal_views">
                    <div style='font-size:20px; margin:60px;'><center>Loading Proposals...</center></div>
                </div>
                     <div style="margin: top 15px; " class="proposal_status-card">
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
                                        <button id='dao_save_addr_add' class='Deo_setting_btn' style='position:relative;margin-right:15px'>Add</button>
                                        <button id='dao_save_addr_cancel' class='Deo_setting_btn' style='position:relative;background:none;
                                        border:1px solid #333257;color:#333257'>Cancel</button>
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
                     <button id='dao_save_button' class="btn assetSearch">Save</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </section>
    <script>
        /* INDEX FUNCTIONS GO HERE */
        var dao;
        /* RETRIEVE THE DAO SPECIFIC INFORMATION */
        const indexMain = async () => { 
           let _dao = (window.location + "").substring((window.location + "").lastIndexOf("/") + 1)
           dao = await getDao(_dao) ;  
           if(dao['proposals'] != undefined) {
               setUp(); 
               //check if this asset was hosted here
               if(dao.toml.DOCUMENTATION.ORG_URL.indexOf("<?php echo $_SERVER['HTTP_HOST']; ?>") > -1 ) {
                   //check if its an approved wallet
                   if(dao.issuer == walletAddress || dao.toml.ACCOUNTS.includes(walletAddress)) E('dao_setting').style.display = 'block'
               }
               //load info of all the proposals
               let prop;
               if(dao.proposals != undefined){
                   if(dao.proposals.length > 0) {
                        E('proposal_views').innerHTML = ""
                        const tmr = setInterval(async () => {
                        prop = dao.proposal_list.pop()
                            if(prop != undefined && prop != "") {
                                prop = await getProposal(prop)  
                                if(prop['name'] != undefined) {
                                    //append 
                                    E('proposal_views').appendChild(drawProposal(prop))
                                }
                            }
                            //stop timer if all dao data has been read
                            if(dao.proposal_list.length == 0) clearInterval(tmr)
                        }, 5)
                   }
                   else {
                       E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No proposal created yet<br>Be the first to create a proposal.</center></div>"
                   }
               }
               else {
                   E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No proposal created yet<br>Be the first to create a proposal.</center></div>"
               }
           }
        }
        const setUp = async () => {
            if(dao['proposals'] != undefined) {
               E('dao_name').innerHTML = E('dao_name_head').innerHTML = E('dao_save_name').innerHTML = dao.name || "no name"
               E('dao_about').innerHTML = E('dao_save_about').innerHTML = dao.description || "Your friendly Lumos DAO community"
               E('dao_members').innerHTML = dao.members.toLocaleString() + ((dao.members * 1 > 1) ? " members" : " member")
               //get token info name
               E('dao_token_name').innerHTML = E('dao_save_code').innerHTML =  dao.code
               //get asset info from toml
               if(dao.url != ""){
                   const aToml = dao.toml
                   E('dao_token_url').innerHTML = E('dao_save_toml').innerHTML = E('dao_token_url').href = E('dao_save_toml_url').href = dao.url
                   E('dao_website').innerHTML = E('dao_website').href = E('dao_save_domain').innerHTML = E('dao_save_domain_href').href = (aToml.DOCUMENTATION != undefined) ? aToml.DOCUMENTATION.ORG_URL : ""
                   if(aToml.CURRENCIES){ 
                       E('dao_token_img').src = E('dao_save_img').src = E('dao_image').src = (dao.image || "") + "?id=" + Math.random() * 1000
                       E('dao_token_issuer').innerHTML = E('dao_token_distributing').innerHTML = dao.issuer || ""
                    } 
                    //load approved address
                    E('dao_save_address').innerHTML = ""
                    E('dao_save_address').appendChild(drawAddress(dao.issuer))
                    if(aToml.ACCOUNTS) {
                        let flg = false;
                        //get account names if it exist
                        if(!aToml.WALLET_NAMES) {aToml.WALLET_NAMES = []} //not defined yet, define it
                        for(let i=0;i<aToml.ACCOUNTS.length;i++) {
                            //don't redraw the issuer
                            if(aToml.ACCOUNTS[i]){
                                E('dao_others_address').innerHTML = "<strong class='text-success'>" + (aToml.WALLET_NAMES[aToml.ACCOUNTS[i]] || 'Others') + "</strong>"
                                E('dao_save_address').appendChild(drawAddress(aToml.ACCOUNTS[i], (aToml.WALLET_NAMES[aToml.ACCOUNTS[i]] || 'Others')))
                                E('dao_others_address').appendChild(drawOtherAddress(aToml.ACCOUNTS[i]))
                                flg = true
                            } 
                        }
                        if(flg) E('dao_others_address').style.display = 'block' //show others
                    }
                    E('dao_save_address_view').style.display = 'none'
                    
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
                let h = prop.voters.length.toLocaleString() + ((prop.voters.length * 1 > 1) ? " members" : " member")
                _div.innerHTML = ` <div class="row">
                    <div class="cardEndDiv">
                        <div class="col-12">
                            <a href="/proposal/${prop.proposalId}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center cardEndDetail_container">
                                        <div class="cardEndDetail">
                                            <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image">
                                            <div class="text">Created by: ${n}</div>
                                        </div>
    
                                    <div class="text">
                                            <span>Proposal ID:</span>
                                            <span>${prop.proposalId}</span>
                                        </div>
    
                                    <div class="small-card">
                                        <div class="small-card-text">${(prop.executed) ? "Ended" : "Active"}</div>
                                    </div>
                                </div>
                                <div class="cardendHeading">
                                    <h2 class="heading">Incentivized Referral Program</h2>
                                    <div class="paragraph">
                                        <p>${prop.description}</p>
                                    </div>
                                </div>
                                <div class="carendBottom d-flex align-items-center">
                                <div class="small-card">
                                    <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                    <div class="small-card-text">Yes</div>
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
                return _diV.firstElementChild
                    
            }
        const drawAddress = (addr, name = "") => {
            let tm = document.createElement('div')
            tm.innerHTML = `<div class="column-content">${name}<br><span>${addr.substring(0, 8) + "..." + addr.substring(addr.length - 8)}</span></div>`
            return tm.firstElementChild
        }
        const drawOtherAddress = (addr) => {
            let tm = document.createElement('div')
            tm.innerHTML = `<div class="column-content"><p>${addr}</p></div>`
            return tm.firstElementChild
        } 
        indexMain() //run the main function
    </script>
@endsection
