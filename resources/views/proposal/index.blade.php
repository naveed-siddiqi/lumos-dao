@extends('layouts.app')

@section('content')
    <section class="leadingBoard">
        <div class="container">
            <div class="row">
                <div class="col-12 ">
                    <div class="heading-board">
                        <a class="headingBoard" href="{{ route('explore') }}">Explore</a>
                        <span class="rightArrow"> > </span>
                        <a id='dao_name' class="headingBoard"></a>
                        <span class="rightArrow"> > </span>
                        <p class="apple-text">proposal Info</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="progeBarWhite">
                    <h1 id='prop_name'></h1>
                    <div class="col-12">
                        <span id='prop_vote_power' style='font-weight:bold;display:none'></span>
                        <div class="progresInner">
                            <div class="ProgText">
                                <div class="left d-flex align-items-baseline justify-content-center gap-2">
                                    <p>Yes</p>
                                    <button id='prop_vote_yes_action' class="btn" style='border:2px solid #ffa101;display:none' data-bs-toggle="modal" data-bs-target="#reasonVote">Vote</button>
                                    <div id='prop_final_result_yes' style='display:none !important' class="d-flex align-items-center justify-content-center ProgFinal-text">
                                        Final Result
                                    </div>
                                </div>
                                <div class="right ">
                                    <div class="d-flex align-items-baseline justify-content-center gap-2">
                                        <span style="font-family: 'MontSem';" class="">Voting Power:</span>
                                        <span id='prop_yes_voting_power'></span>
                                    </div>
                                    <div class="d-flex align-items-baseline justify-content-end gap-2">
                                        <span style="font-family: 'MontSem';" class="">Votes:</span>
                                        <span id='prop_yes_votes'></span>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-bar">
                                <div id='prop_yes_bar' class="progress" style='width:0px;transition: all 400ms'></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progresInner">
                            <div class="ProgText">
                                <div class="left d-flex align-items-baseline justify-content-center gap-2">
                                    <p>No</p>
                                   
                                    <button id='prop_vote_no_action' class="btn" style='border:2px solid #ffa101;display:none' data-bs-toggle="modal" data-bs-target="#reasonVoteNo">Vote</button>
                                    <div id='prop_final_result_no' style='display:none !important;border-color:#02C17C;color:#02C17C' class="d-flex align-items-center justify-content-center ProgFinal-text" >
                                        Final Result
                                    </div>
                                </div>
                                <div class="right">
                                        <div class="d-flex align-items-baseline justify-content-center gap-2">
                                            <span style="font-family: 'MontSem';" class="">Voting Power:</span>
                                            <span id='prop_no_voting_power'></span>
                                        </div>
                                        <div class="d-flex align-items-baseline justify-content-end gap-2 text-sm">
                                            <span style="font-family: 'MontSem';" class="">Votes:</span>
                                            <span id='prop_no_votes'></span>
                                        </div>
                                </div>
                            </div>
                            <div class="progress-bar">
                                <div id='prop_no_bar' class="progress-NO" style='width:0px; transition: all 400ms'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

 <div class="modal fade" id="reasonVote" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content cardEndDiv p-0 fa-ctn fa-modal-content">
            <div class="d-flex justify-content-end w-100">
                <button type="button" class="close p-3 pb-0 m-0 border-0 bg-transparent" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 pt-0 w-100 font-sm">
                <p class="">Reason</p>
                <form class="d-flex flex-column align-items-left justify-content-start gap-3" onsubmit='voteWithReasons(event)'>
                    <div class="">
                        <input type="radio" id="1" name="reasons" value="1">
                        <label class="font-sm" for="">Alignment with Project Goals</label>
                    </div>
                    <div class="">
                        <input type="radio" id="2" name="reasons" value="2">
                        <label class="font-sm" for="">Beneficial Impact</label>
                    </div>
                    <div class="">
                        <input type="radio" id="3" name="reasons" value="3">
                        <label class="font-sm" for="">Feasibility and Sustainability</label>
                    </div>
                    <div class="">
                        <input type="radio" id="otherReason" name="reasons" value="other">
                        <label class="font-sm" for="">Other</label>
                    </div>
                    <div id="otherReasonCtn">
                        <label class="font-sm" for="">Mention the Reason here:</label>
                        <input class="form-control" type="text" name='other_reasons' maxlength="50">
                        <div class="text-end">
                            <small class="text-danger text-left w-100 font-sm">-Max 50 characters</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-end gap-3 modal-footer m-0 p-0 py-3 px-3 w-100">
                        <button type="submit" class="btn btn-danger text-white font-sm">Confirm</button>
                    </div>
                </form>
            </div>

            
        </div>
    </div>
</div>
 <div class="modal fade" id="reasonVoteNo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content cardEndDiv p-0 fa-ctn fa-modal-content">
            <div class="d-flex justify-content-end w-100">
                <button type="button" class="close p-3 pb-0 m-0 border-0 bg-transparent" data-dismiss="modal"
                    data-bs-target="#reasonVoteNo" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 pt-0 w-100 font-sm">
                <p class="">Reason</p>
                <form class="d-flex flex-column align-items-left justify-content-start gap-3" onsubmit='voteWithReasonsNo(event)'>
                    <div class="">
                        <input type="radio" id="1" name="reasonsNo" value="1">
                        <label class="font-sm" for="">Lack of Alignment with Goals</label>
                    </div>
                    <div class="">
                        <input type="radio" id="2" name="reasonsNo" value="2">
                        <label class="font-sm" for="">High budget</label>
                    </div>
                    <div class="">
                        <input type="radio" id="3" name="reasonsNo" value="3">
                        <label class="font-sm" for="">Feasibility Concerns</label>
                    </div>
                    <div class="">
                        <input type="radio" id="otherReasonNo" name="reasonsNo" value="other">
                        <label class="font-sm" for="">Other</label>
                    </div>
                    <div id="otherReasonCtnNo">
                        <label class="font-sm" for="">Mention the Reason here:</label>
                        <input class="form-control" type="text" maxlength="50" name='other_reasons_no'>
                        <div class="text-end">
                            <small class="text-danger text-left w-100 font-sm">-Max 50 characters</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-end gap-3 modal-footer m-0 p-0 py-3 px-3 w-100">
                        <button type="submit" class="btn btn-danger text-white font-sm">Confirm</button>
                    </div>
                </form>
            </div>

            
        </div>
    </div>
</div>


    <section class="DescPer">
        <div class="container">
            <div class="row">
                <div class="DescPerSec">
                    <h1>Description</h1>
                    <div class="col-12">
                        <p id='prop_about'></p>
                    </div>
                </div>
            </div>
    </section>
    <section class="DescPer">
        <div class="container">
            <div class="row">
                <div class="DescPerSec">
                    <h1>Share</h1>
                    <div class="col-12 progresInner p-1 p-sm-4">
                    <div class="w-100 mx-auto row flex-nowrap flex-column flex-lg-row">
                    <div class="row col gap-2">
                            <div class="col d-flex align-items-center justify-content-center flex-column gap-1">
<<<<<<< HEAD
                                <button class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-primary">
=======
                                <button onclick='shareFunctions()' class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-primary">
>>>>>>> 9270b47 (added new UI updates)
                                    <img class="share-social-img w-100 h-100" src="{{asset('/images/facebook.png')}}" alt="">
                                </button>
                                <span class="font-xs text-primary">Facebook</span>
                            </div>
                            <div class="col d-flex align-items-center justify-content-center flex-column gap-1">
<<<<<<< HEAD
                                <button class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-info">
=======
                                <button onclick='shareFunctions("linkedin")' class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-info">
>>>>>>> 9270b47 (added new UI updates)
                                    <img class="share-social-img w-100 h-100" src="{{asset('/images/linkedin.png ')}}" alt="">
                                </button>
                                <span class="font-xs text-info">Linkedin</span>
                            </div>
                            <div class="col d-flex align-items-center justify-content-center flex-column gap-1">
<<<<<<< HEAD
                                <button class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-success">
=======
                                <button onclick='shareFunctions("whatsapp")' class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-success">
>>>>>>> 9270b47 (added new UI updates)
                                    <img class="share-social-img w-100 h-100" src="{{asset('/images/whatsapp.png')}}" alt="">
                                </button>
                                <span class="font-xs text-success">Whatsapp</span>
                            </div>
                            <div class="col d-flex align-items-center justify-content-center flex-column gap-1">
<<<<<<< HEAD
                                <button class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-secondary">
=======
                                <button onclick='shareFunctions("twitter")' class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-secondary">
>>>>>>> 9270b47 (added new UI updates)
                                    <img class="share-social-img w-100 h-100" src="{{asset('/images/x.webp')}}" alt="">
                                </button>
                                <span class="font-xs text-black">X</span>
                            </div>
                            <div class="col d-flex align-items-center justify-content-center flex-column gap-1">
<<<<<<< HEAD
                                <button class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-danger">
=======
                                <button onclick='shareFunctions("reddit")' class="btn btn-block share-social-img d-flex align-items-center justify-content-center p-1 border border-danger">
>>>>>>> 9270b47 (added new UI updates)
                                    <img class="share-social-img w-100 h-100" src="{{asset('/images/Reddit.png ')}}" alt="">
                                </button>
                                <span class="font-xs text-danger">Reddit</span>
                            </div>
                        </div>
                        <!-- Input for copying link -->
                        <div class="col">
                            <div
                                class="bg-white input-group mb-3 d-flex align-items-center justify-content-start form-control border text-secondary w-100 flex-nowrap">
                                <input type="text" id="shareLink"
                                    class="bg-transparent border-0 text-secondary d-block flex-grow-1"
                                    value="https://example.com/your-gig" readonly>
                                <div class="input-group-append w- text-end">
<<<<<<< HEAD
                                    <button class="btn text-secondary">
                                        <p class="font-xs font-medium mb-0 whitespace-nowrap">Copy <span class="d-none d-sm-block" >Link</span></p>
=======
                                    <button class="btn text-secondary" onclick='copyLink(E("shareLink").value)'>
                                        <p class="font-xs font-medium mb-0 whitespace-nowrap d-flex align-items-center justify-content-center gap-1">Copy <span class="d-none d-sm-block" >Link</span></p>
>>>>>>> 9270b47 (added new UI updates)
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="DescPer" id='attached_files'>
        <div class="container">
            <div class="row">
                <div style="gap:50px;" class="DescPerSec d-flex align-items-center ">
                    <h1>Attached files</h1>
                    <div id='prop_links' class="d-flex align-items-start justify-content-center gap-4 ">
                       
                    </div>

                </div>
            </div>
    </section>

    <section class="PropId">
        <div class="container">
            <div class="row">
                <div class="PropIdInner">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <h6>Proposal ID</h6>
                            <p id='prop_id'></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 Due">
                            <h6>Duration</h6>
                            <p id='prop_duration'></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 Due1">
                            <h6>Status</h6>
                            <p id='prop_status'></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <h6>Total voters</h6>
                            <p id='prop_total_voters'></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <h6>Total voting power</h6>
                            <p id='prop_total_voting_power'></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <h6>Proposer</h6>
                            <p id='prop_creator'></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ProposalTable">
        <div class="container">
            <div class="row">
                <div class="InnerTable" >
                    <h3>Votes</h3>
                    <div class="col-12" style="transition:all 500ms;overflow:auto;">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th clas="" scope="col">
                                    <div class="d-flex align-items-center">
                                        <span class="font-sm font-medium">Address</span>
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The public Stellar wallet address that cast this vote.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </button>
                                    </div>

                                </th>
                                <th clas="" scope="col">
                                    <div class="d-flex align-items-center">
                                        <span class="font-sm font-medium">Token holdings</span>
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The public Stellar wallet address that cast this vote.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </button>
                                    </div>

                                </th>
                                     <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <span class="font-sm font-medium">Vote</span>
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The decision made by the user: Yes or No.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                   <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <span class="font-sm font-medium">Voting Power</span>
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The influence of this vote, determined by a calculated voting power algorithm. Learn more">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                    <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <span class="font-sm font-medium">Reason</span>
                                    </div>
                                </th>
                                    <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <span class="font-sm font-medium">Date</span>
                                    </div>
                                </th>
                                </tr>
                            </thead>
                            <tbody id='voters_info'>
                                    
                                
                            </tbody>
                            
                        </table>
                        <div class='d-flex' style='flex-direction:row-reverse'>
                                <button id='next_voter_info' class='btn' style='display:none'>Next</button>
                                <button id='pre_voter_info' class='btn' style='display:none'>Prev</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
    <section class="DescPer">
        <div class="container">
            <div style="text-align:right;" class="pb-3">
                <button id='add_comment' class=" add-comments-btn " style='display:none;margin-left:auto' type="button">Add Comments</button>
            </div>
            <div id='prop_comment_box' class="row" style='margin-bottom:20px;display:none' >
                <div class="DescPerSec">
                    <textarea id='prop_comment_msg' style='height:150px; width:100%;border:none;outline:none' placeholder='Comment here'></textarea>
                    <button id='prop_send_comment' class="btn" style='padding:5px 15px;background:#333257;color:#fff'> 
                        Send
                    </button>
                    <button onclick='E("prop_comment_box").style.display = "none"' class="btn" style='padding:5px 15px;'> 
                        Cancel
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="DescPerSec">
                    <h1>Comments</h1>
                    <div id='prop_comment_view'></div>
                    <a  id='prop_see_more_comment' class=" see-more-comment-btn" style='display:none; cursor:pointer'>
                        See all Comments
                    </a>
                </div>
            </div>
    </section>
    <script>
        var otherReason = document.getElementById('otherReason');
        var otherReasonCtn = document.getElementById('otherReasonCtn');
        var otherReasonNo = document.getElementById('otherReasonNo');
        var otherReasonCtnNo = document.getElementById('otherReasonCtnNo');
        otherReasonCtn.style.display = 'none';
        otherReasonCtnNo.style.display = 'none';
        
        otherReason.addEventListener('input', function() {
            if (otherReason.checked) {
                otherReasonCtn.style.display = 'block';
            } else {
                otherReasonCtn.style.display = 'none';
            }
        });
        
        otherReasonNo.addEventListener('input', function() {
            if (otherReasonNo.checked) {
                otherReasonCtnNo.style.display = 'block';
            } else {
                otherReasonCtnNo.style.display = 'none';
            }
        });
    </script>
    <script>
    var prop;var dao = {};var groupInfo;
    var propId = ("{{ $prop['proposal_id'] }}");propId = propId.trim() * 1;
    var vote_power;
    var voterInfo;
    var daoDelegatee;
    var voterDelegator = [];
    var vote_type = null; 
    var voter_info_page = 1;
    var voter_page_segment = 10;
        const setUp = async () =>{  
            //get prop metadata
            prop = (await getAllPropInfo(propId, "{{ $prop['dao_id'] }}"))[propId]; //display the voters info
            //display info
            E('prop_name').innerText = prop.title || ""
            E('prop_about').innerText = prop.description || ""
            //get prop info on chain
            await loadGroupInfo()
            prop = {...(groupInfo.proposal), ...prop};  
            E('prop_status').innerText = (prop.status == 4) ? "Ended" : (prop.status == 0) ? "Inactive" : (prop.status == 1) ? "Active": (prop.status == 2) ? "Rejected" : "Funded"
            //set up vote info
            dao.token = "{{ $prop['dao_id'] }}"
            setUpVote(prop)
            //get dao info
            dao = (await getAlldaoInfo("{{ $prop['dao_id'] }}"))["{{ $prop['dao_id'] }}"];  
            E('dao_name').innerText = dao.name
            E('dao_name').href = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/dao/" + dao.token
            const delimtr = "https://" + dao.name.toLowerCase().trim() + ".lumosdao.io"
            const links = (prop.links || "").trim().split("," + delimtr);  
            let filename; E('prop_links').innerHTML = ""
            for(let i=0;i<links.length;i++) {
                if(links[i] != "") {
                    links[i] = links[i].replace(delimtr, "")
                    if(links[i].substring(links[i].length - 1) == ',') {
                        links[i] = links[i].substring(0, links[i].length - 1)
                    }
                    filename = links[i].substring(links[i].lastIndexOf('/') + 1);
                    E('prop_links').innerHTML += ` <h6 style="color:#00b2fb;"><a target='_blank' href="${delimtr + links[i]}">${filename}</a></h6>`
                }
            }
            if( E('prop_links').innerHTML == "") {
                E('attached_files').style.display = 'none'
            }
            //display metadat
            E('prop_id').innerText = 'PROP_' + propId
            E('prop_duration').innerText = '5 days'
            E('prop_creator').innerText = prop.creator.substring(0, 5) + "..." + prop.creator.substring(prop.creator.length - 3)
            E('shareLink').value = window.location.href
            loadComment()
            
        }
        const loadGroupInfo = async () => {groupInfo = await getProposalGroupInfo({
                propId:"{{ $prop['dao_id'] }}",
                voter:walletAddress,
                dao:prop.dao
            })
        }
        const setUpVote = async () => {
            //voting results
            E('prop_yes_votes').innerText = prop.yes_votes || 0
            E('prop_yes_voting_power').innerText = (N(prop.yes_voting_power)/(floatingConstant))
            if((prop.yes_votes + prop.no_votes) > 0){
                const tmp = (N(prop.yes_votes) * (N(prop.yes_voting_power)/(floatingConstant))) + (N(prop.no_votes) * (N(prop.no_voting_power)/(floatingConstant)))
                E('prop_yes_bar').style.width = (Math.floor((100 / (tmp)) * (N(prop.yes_votes) * (N(prop.yes_voting_power)/(floatingConstant)))) + "%") || "0px"
                E('prop_no_bar').style.width = (Math.floor((100 / (tmp)) * (N(prop.no_votes) * (N(prop.no_voting_power)/(floatingConstant)))) + "%") || "0px"
            }
            else {
                E('prop_yes_bar').style.width =  "0px"
                E('prop_no_bar').style.width = "0px"
            }
            E('prop_no_votes').innerText = prop.no_votes || 0
            E('prop_no_voting_power').innerText = (N(prop.no_voting_power)/(floatingConstant))
            E('prop_total_voters').innerText = (prop.no_votes + prop.yes_votes)
            E('prop_total_voting_power').innerText = N(prop.yes_voting_power + prop.no_voting_power) / floatingConstant
                
            //populate for testing
            const bal = await getTokenUserBal(prop.dao, walletAddress);  
            if(bal !== false) {
                E('prop_vote_power').innerText = "Current voting power: " + vote_power
                //can vote, and has joined
                const my_vote = groupInfo.voter_type; 
                daoDelegatee = groupInfo.delegatee; 
                //reset buttons
                E('prop_vote_yes_action').style.display = 'none'
                E('prop_vote_no_action').style.display = 'none'
                E('prop_vote_yes_action').disabled = false
                E('prop_vote_no_action').disabled = false
                 
                if(prop.status == 1) {
                    if(my_vote == 0 && daoDelegatee.length < 1) {
                        if(!prop.executed) {
                            //has not voted, show both vote buttons
                            E('prop_vote_yes_action').style.display = 'block'
                            E('prop_vote_no_action').style.display = 'block'
                            //hide comment button
                            E('add_comment').style.display = 'none'
                        }
                    }
                    else if(my_vote == 1 && daoDelegatee.length < 1) {
                            //voted yes
                            E('prop_vote_yes_action').style.display = 'block'
                            E('prop_vote_yes_action').innerText = 'Voted'
                            E('prop_vote_yes_action').disabled = true
                            //show add comment button
                            E('add_comment').style.display = 'flex'
                        }
                    else if(my_vote == 2 && daoDelegatee.length < 1) {
                            //voted yes
                            E('prop_vote_no_action').style.display = 'block'
                            E('prop_vote_no_action').innerText = 'Voted'
                            E('prop_vote_no_action').disabled = true
                            //show comment button
                             E('add_comment').style.display = 'flex'
                        }
                    else {
                            //has delegated voting power
                            E('prop_vote_yes_action').style.display = 'block'
                            E('prop_vote_no_action').style.display = 'block'
                            E('prop_vote_no_action').innerText = 'Delegated'
                            E('prop_vote_yes_action').innerText = 'Delegated'
                            E('prop_vote_no_action').disabled = true
                            E('prop_vote_yes_action').disabled = true
                            //hide comment button
                            E('add_comment').style.display = 'none'
                        }
                }
                else {
                    //proposal no longer active
                    E('prop_vote_yes_action').style.display = 'none'
                    E('prop_vote_no_action').style.display = 'none'
                    E('prop_vote_no_action').disabled = true
                    E('prop_vote_yes_action').disabled = true
                    //hide comment button
                    E('add_comment').style.display = 'none'
                }
                E('prop_vote_yes_action').onclick = async () => {
                    //store the vote type
                    vote_type = 1
                }
                E('prop_vote_no_action').onclick = async () => {
                    //store the vote type
                    vote_type = 2
                }
                //configure add comment button action
                E('add_comment').onclick = () => {
                    E('prop_comment_box').style.display = 'block'
                    E('prop_comment_msg').value = ""
                }
                E('prop_send_comment').onclick = sendComment
            }
            voterInfo = await getProposalVotersInfo(propId, dao.token)
            voter_info_page
            loadVoterInfo()
            //configure the buttons
            E('next_voter_info').onclick = () => {
                if(voter_info_page < voterInfo.length / voter_page_segment){
                  loadVoterInfo(voter_info_page + 1)
                  voter_info_page++
                }
            }
            E('pre_voter_info').onclick = () => {
                if(voter_info_page > 1){
                  loadVoterInfo(voter_info_page - 1)
                  voter_info_page--
                }
            }
        }
        const loadComment = async () => {
            //read comments
            E('prop_comment_view').innerHTML = "<center>Loading comments...</center>"
            const comments = await getProposalComment(propId, "{{ $prop['dao_id'] }}")
            if(comments !== false) {
                if(comments.length > 0) {
                    E('prop_comment_view').innerHTML = ""
                    let tmp;
                    for(let i=0;i<comments.length && i < 5;i++) { 
                         tmp = JSON.parse(comments[i]) //convert to json
                         E('prop_comment_view').appendChild(drawVoterComment({
                             voter:tmp.address,
                             msg:tmp.msg,
                             date:tmp.date
                         })) 
                    }
                    if(comments.length > 5) {
                        //show the see more button
                        E('prop_see_more_comment').style.display = 'flex'
                        //do the function
                        E('prop_see_more_comment').onclick = () => {
                            E('prop_comment_view').innerHTML = ""
                            let tmp;
                            for(let i=0;i<comments.length;i++) { 
                                tmp= JSON.parse(comments[i]) //convert to json
                                E('prop_comment_view').appendChild(drawVoterComment({
                                     voter:tmp.address,
                                     msg:tmp.msg,
                                     date:tmp.date
                                 })) 
                            }
                            E('prop_see_more_comment').style.display = 'none'
                        }
                    }
                }
                else {
                    E('prop_comment_view').innerHTML = "<center>No comments yet.<br>Be the first to comment</center>"
                }
            }
            else {
                //show network error msg
                E('prop_comment_view').innerHTML = "<center>Unable to load comments<br> Network error </center>"
            }
        }
        const sendComment = async () => {
            const msg = E('prop_comment_msg').value.trim()
            if(msg != "") {
                E('prop_send_comment').disabled = true //disable button
                const id = talk('Sending comment')
                if(await isBanned(dao.token, walletAddress)){stopTalking(0.1, id);return ""}
                const res = await sendProposalComment(propId, dao.token, msg, walletAddress); 
                if(res  === 1) {
                    stopTalking(4, talk("Commented", 'good', id))
                    E("prop_comment_box").style.display = "none"
                    loadComment()
                }
                else {
                    stopTalking(4, talk("Something went wrong<br>Try again", 'fail', id))
                }
                E('prop_send_comment').disabled = false //eable button
            }
           
        }
        const loadVoterInfo = (page = 1) => {
            //to do pagination, segment is 10
            const start_index = (page - 1) * voter_page_segment;
            const end_index = start_index +  voter_page_segment
            //reset view
            E('voters_info').innerHTML = ""
            for(let i=start_index; i<end_index && i < voterInfo.length;i++) {
                E('voters_info').innerHTML += drawVotersInfo({
                    voter:voterInfo[i].voter,
                    vote_type:voterInfo[i].vote_type,
                    voting_power:voterInfo[i].voting_power,
                    voting_reason:voterInfo[i].reasons || "",
                    is_delegated:voterInfo[i].delegated,
                    time:voterInfo[i].time
                })
            }
            
            if(end_index >= voterInfo.length) {
                //hide next button
                E('next_voter_info').style.display = 'none'
            }
            else {
                E('next_voter_info').style.display = 'block'
            }
            if(start_index == 0) {
                //hide next button
                E('pre_voter_info').style.display = 'none'
            }
            else {
                E('pre_voter_info').style.display = 'block'
            }
            //handle empty voters
            if(E('voters_info').firstElementChild == null) {
                //show empty view
                E('voters_info').innerHTML = `<tr>
                                    <td></td>
                                    <td><center style="margin:50px;width:100%">Nothing to show</center></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>`
            }
            
        }
        const voteWithReasons = (e) => {
           event.preventDefault(); // Prevent form submission (since we're handling it manually)
           // Get the selected radio option
           const selectedOption = document.querySelector('input[name="reasons"]:checked');
           if (selectedOption) {
                // If a radio option is selected
                const selectedValue = selectedOption.value;
                let reason;
                // Determine the reason based on the selected option value
                switch (selectedValue) {
                    case '1':
                        reason = "Alignment with Project Goals";
                        break;
                    case '2':
                        reason = "Beneficial Impact";
                        break;
                    case '3':
                        reason = "Feasibility and Sustainability";
                        break;
                    case 'other':
                        // If "Other" option is selected, get the text input value
                        reason = document.querySelector('input[name="other_reasons"]').value;
                        break;
                    default:
                        reason = "";
                }
                //hide modal
                 E('reasonVote').click()
                 vote(1, reason)
           } else {
                stopTalking(2, talk("Please select a reason", 'fail'))
           }
        }
        const voteWithReasonsNo = (e) => {
           event.preventDefault(); // Prevent form submission (since we're handling it manually)
           // Get the selected radio option
           const selectedOption = document.querySelector('input[name="reasonsNo"]:checked');
           if (selectedOption) {
                // If a radio option is selected
                const selectedValue = selectedOption.value;
                let reason;
                // Determine the reason based on the selected option value
                switch (selectedValue) {
                    case '1':
                        reason = "Lack of Alignment with Goals";
                        break;
                    case '2':
                        reason = "High budget";
                        break;
                    case '3':
                        reason = "Feasibility Concerns";
                        break;
                    case 'other':
                        // If "Other" option is selected, get the text input value
                        reason = document.querySelector('input[name="other_reasons_no"]').value;
                        break;
                    default:
                        reason = "";
                }
                //hide modal
                E('reasonVoteNo').click()
                vote(2, reason)
           } else {
                stopTalking(2, talk("Please select a reason", 'fail'))
           }
        }
        async function vote(voteType = 1, reason = "") {
            //disable the two buttons
            E('prop_vote_yes_action').style.display = 'none'
            E('prop_vote_no_action').style.display = 'none'
            //calculate the voting power
            let vote_label;
            (voteType == 1) ? vote_label = "yes" : vote_label = "no"
            //fetch voting power
            const id = talk("Fetching voting power")
            if(await isBanned(dao.token, walletAddress)){stopTalking(0.1, id);return ""}
            vote_power = await getVotingPower({
                     asset:dao.code, address:dao.issuer, dao: dao.token
            }, walletAddress)
            if(vote_power !== false){
                const delegators = await getDaoDelegators(dao.token, walletAddress)
                vote_power *= 1;
                if(delegators.length > 0) {
                    //using delegated power, 
                    talk('Using delegated voting power', 'norm', id)
                    let i=0;
                    delegators.forEach(async (_delegator) => {
                        talk("Fetching voting power of delegator <br>" + fAddr(_delegator, 10), "norm", id)
                        const _res =  (await getVotingPower({
                                         asset:dao.code, address:dao.issuer, dao: dao.token
                        }, _delegator))
                        if(_res !== false) {  
                            vote_power += (_res * 1);
                        }
                        else {
                            stopTalking(1.5, talk("Unable to fetch voting power<br>Network error<br><br>Skipping delegator", 'warn', id))
                        }
                        //check if its the last delegator
                        i++
                        if(i >= delegators.length) {start_voting()}
                    })
                }else{start_voting()}
                
                async function start_voting() { 
                    talk("Voting " + vote_label + " on this proposal", "norm", id)
                    const res = await voteProposal({
                        proposalId: propId,
                        voters: walletAddress,
                        vote_type:voteType,
                        voting_power:vote_power,
                        name:prop.name,
                        reason:reason,
                        owner:prop.creator,
                        daoId:"{{ $prop['dao_id'] }}"
                    })
                    if(res) {
                        if(res.status == 'voted') {
                            stopTalking(4, talk("You have voted " + vote_label + " on this proposal", 'good', id))
                        }
                        else if(res.status == 'hasvoted') {
                            stopTalking(4, talk("You have already voted " + vote_label + " on this proposal", 'warn', id))
                        }
                        else if(res.status == 'lowbal') {
                            stopTalking(4, talk("You don't have sufficient DAO asset balance to make this vote", 'fail', id))
                        }
                        else if(res.status == 'lowbal') {
                            stopTalking(4, talk("This proposal does not accep vote at this time", 'fail', id))
                        }
                        else if(res.status == 'inactive') {
                            stopTalking(4, talk("This proposal is not active", 'fail', id))
                        }
                        else if(res.status == 'ended') {
                            stopTalking(4, talk("This proposal has ended", 'fail', id))
                        }
                        else  {
                            stopTalking(4, talk("Something went wrong", 'fail', id))
                        }
                        await loadGroupInfo()
                        //reset the votes
                        setUpVote()
            }
                    else {
                        //something went wrong
                        stopTalking(4, talk("Something went wrong<br>Try again later", 'fail', id))
                        E('prop_vote_yes_action').style.display = 'block'
                        E('prop_vote_no_action').style.display = 'block'
            }
                    }
                
            }
            else {
                //something went wrong
                stopTalking(4, talk("Unable to fetch voting power<br>Network error", 'fail', id))
                E('prop_vote_yes_action').style.display = 'block'
                E('prop_vote_no_action').style.display = 'block'
            }
        }
        //handles social media shares
        const shareFunctions = (type = 'fb') => {
            const msg = `New proposal on ${dao.name} DAO👇 ${prop.title} `
            const title = `LumosDao Proposal ${prop.name}`
            const url = window.location.href;
            let shareUrl;
            if(type == "fb") {
                // Construct the Facebook share URL with parameters
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(msg)}`;
            }
            else if(type == 'linkedin'){
                // Construct the LinkedIn share URL with parameters
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}&summary=${encodeURIComponent(msg)}`;
            }
            else if(type == 'whatsapp') {
                shareUrl = `https://wa.me/?text=${msg + '\n' + url}`;
            }
            else if(type == 'twitter') {
                shareUrl = `https://twitter.com/intent/tweet?text=${msg}&url=${url}`;
            }
            else if(type == 'reddit') {
                // Construct the Reddit share URL
                shareUrl = `https://www.reddit.com/r/${msg}/submit?title=${title}&url=${url}`;
            }
            //Open the Facebook share dialog in a new window
            window.open(shareUrl, '_blank');
            
        }
        const drawVotersInfo = (params = {}) => {
            return `<tr>
                                    <td>${params.voter.substring(0,4) + '...' + params.voter.substring(params.voter.length - 4)}</td>
                                    <td>${(params.vote_type == 1) ? "Yes" : "No"}</td>
                                    <td>${N(params.voting_power) / floatingConstant} <span style='${(params.is_delegated == true) ? '' : 'display:none;'}background:dodgerblue;padding:5px;border-radius:5px;color:#fff;font-size:13px'>delegated</span></td>
                                    <td>${params.voting_reason}</td>
                                    <td>${(new Date(N(params.time) * 1000)).toLocaleString()}</td>
                                </tr>`

        }
        const drawVoterComment = (params = {}) => { 
            let tm = document.createElement('div')
            tm.innerHTML = `<div  class="col-12">
                          <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between gap-2 w-100">
                       <div class="d-flex align-items-center justify-center gap-2">
                            <img style="width:40px; height:40px; border-radius:50%;display:non e" src="${API_URL + 'user_img&user=' + params.voter}" alt="">
                            <span>${fAddr(params.voter, 6)}</span>
                        </div>
                        <p class="Explorer_span d-block">${(new Date(params.date)).toLocaleString()}</p>
                       </div>
                        </div>
                        <div style="border-bottom: 1px solid #e5e7eb; " class="col-12 my-2">
                            <p>
                                ${params.msg}
                            </p>
                        </div>
                    </div>
                    `
            return tm.firstElementChild
        }
        /* Initialize page */ 
        setUp()
        
    </script>
    <script>
        var otherReason = document.getElementById('otherReason');
        var otherReasonCtn = document.getElementById('otherReasonCtn');
        var otherReasonNo = document.getElementById('otherReasonNo');
        var otherReasonCtnNo = document.getElementById('otherReasonCtnNo');
        otherReasonCtn.style.display = 'none';
        otherReasonCtnNo.style.display = 'none';
        
        otherReason.addEventListener('input', function() {
            if (otherReason.checked) {
                otherReasonCtn.style.display = 'block';
            } else {
                otherReasonCtn.style.display = 'none';
            }
        });
        
        otherReasonNo.addEventListener('input', function() {
            if (otherReasonNo.checked) {
                otherReasonCtnNo.style.display = 'block';
            } else {
                otherReasonCtnNo.style.display = 'none';
            }
        });
</script>
@endsection