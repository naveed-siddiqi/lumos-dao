@extends('layouts.app')

@section('content')
    <section class="leadingBoard">
        <div class="container">
            <div class="row">
                <div class="col-12 ">
                    <div class="heading-board">
                        <p class="headingBoard">Board</p>
                        <span class="rightArrow"> > </span>
                        <p id='dao_name' class="headingBoard"></p>
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
                                    <button id='prop_vote_yes_action' class="btn" style='border:2px solid #ffa101;display:none'>Vote</button>
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
                                    <button id='prop_vote_no_action' class="btn" style='border:2px solid #ffa101;display:none'>Vote</button>
                                    <div id='prop_final_result_no' style='display:none !important;border-color:grey;color:grey' class="d-flex align-items-center justify-content-center ProgFinal-text" >
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
                    <div class="col-12" style='transition:all 500ms'>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th clas="" scope="col">
                                        <div class="d-flex align-items-center">
                                            <span>Address</span>
                                            <button  type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="The public Stellar wallet address that cast this vote.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
                                        </div>

                                    </th>
                                    <th scope="col">
                                    <div class="d-flex align-items-center">
                                            <span>Vote</span>
                                            <button  type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="The decision made by the user: Yes or No.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
                                        </div>
                                    </th>
                                    <th scope="col">
                                    <div class="d-flex align-items-center">
                                            <span>Voting Power</span>
                                            <button  type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="The influence of this vote, determined by a calculated voting power algorithm. Learn more">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
                                        </div>
                                    </th>
                                    <th scope="col">
                                    <div class="d-flex align-items-center">
                                            <span>Date</span>
                                            <button  type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="The timestamp indicating when this vote was cast.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
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
    var prop;var dao;
    var propId = ("{{ $prop['proposal_id'] }}");propId = propId.trim() * 1;
    var vote_power;
    var voterInfo;
    var voter_info_page = 1;
    var voter_page_segment = 10;
        const setUp = async () =>{  
            //get dao info
            dao = await getDao("{{ $prop['dao_id'] }}");
            E('dao_name').innerText = dao.name
            //get prop info
            prop = await getProposal(propId); console.log(prop)
            //display info
            E('prop_name').innerText = prop.title || ""
            E('prop_about').innerText = prop.description || ""
            const delimtr = "https://" + dao.name.toLowerCase().replace(/ /g,"") + ".lumosdao.io"
            const links = (prop.links || "").trim().split("," + delimtr)
            let filename;
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
            //display metadat
            E('prop_id').innerText = 'PROP_' + propId
            E('prop_duration').innerText = '5 days'
            E('prop_status').innerText = prop.status || "Unsure"
            E('prop_creator').innerText = prop.creator.substring(0, 5) + "..." + prop.creator.substring(prop.creator.length - 3)
            //display the voters info
            setUpVote(prop)
        }
        const setUpVote = async (prop = null) => {
            (prop == null) ? prop = await getProposal(propId) : ""
            voterInfo = await getProposalVotersInfo(propId)
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
            E('prop_total_voters').innerText = prop.voters
            E('prop_total_voting_power').innerText = N(prop.yes_voting_power + prop.no_voting_power) / floatingConstant
                
            //populate for testing
            const bal = await getTokenUserBal(prop.dao, walletAddress);  
            if(bal !== false) {
                //voting power
                vote_power = await getVotingPower({
                    asset:dao.code, address:dao.issuer, dao: dao.token
                }, walletAddress)
                E('prop_vote_power').innerText = "Current voting power: " + vote_power
                //can vote, and has joined
                const my_vote = await getProposalVoterInfo(propId, walletAddress)
                //reset buttons
                E('prop_vote_yes_action').style.display = 'none'
                E('prop_vote_no_action').style.display = 'none'
                E('prop_vote_yes_action').disabled = false
                E('prop_vote_no_action').disabled = false
                
                if(my_vote == 0) {
                    //has not voted, show both vote buttons
                    E('prop_vote_yes_action').style.display = 'block'
                    E('prop_vote_no_action').style.display = 'block'
                    //hide comment button
                    E('add_comment').style.display = 'none'
                }
                else if(my_vote == 1) {
                    //voted yes
                    E('prop_vote_yes_action').style.display = 'block'
                    E('prop_vote_yes_action').innerText = 'Voted'
                    E('prop_vote_yes_action').disabled = true
                    //show add comment button
                     E('add_comment').style.display = 'flex'
                }
                else if(my_vote == 2) {
                    //voted yes
                    E('prop_vote_no_action').style.display = 'block'
                    E('prop_vote_no_action').innerText = 'Voted'
                    E('prop_vote_no_action').disabled = true
                    //show comment button
                     E('add_comment').style.display = 'flex'
                }
                E('prop_vote_yes_action').onclick = async () => {await vote(1)}
                E('prop_vote_no_action').onclick = async () => {await vote(2)}
                //configure add comment button action
                E('add_comment').onclick = () => {
                    E('prop_comment_box').style.display = 'block'
                    E('prop_comment_msg').value = ""
                }
                E('prop_send_comment').onclick = sendComment
            }
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
                             msg:tmp.msg
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
                                     msg:tmp.msg
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
                const id = talk('Commenting')
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
                                </tr>`
            }
            
        }
        async function vote(voteType = 1) {
            //calculate the voting power
            let vote_label;
            (voteType == 1) ? vote_label = "yes" : vote_label = "no"
            const id = talk("Voting " + vote_label + " on this proposal")
            //disable the two buttons
            E('prop_vote_yes_action').style.display = 'none'
            E('prop_vote_no_action').style.display = 'none'
            const res = await voteProposal({
                proposalId: propId,
                voters: walletAddress,
                vote_type:voteType,
                voting_power:vote_power
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
        const drawVotersInfo = (params = {}) => {
            return `<tr>
                                    <td>${params.voter.substring(0,4) + '...' + params.voter.substring(params.voter.length - 4)}</td>
                                    <td>${(params.vote_type == 1) ? "Yes" : "No"}</td>
                                    <td>${N(params.voting_power) / floatingConstant}</td>
                                    <td>${(new Date(N(params.time) * 1000)).toLocaleString()}</td>
                                </tr>`

        }
        const drawVoterComment = (params = {}) => {
            let tm = document.createElement('div')
            tm.innerHTML = `<div  class="col-12">
                          <div class="col-12">
                        <div class="d-flex align-items-center justify-center gap-2">
                            <img style="width:40px; height:40px; border-radius:50%;display:none" alt="">
                            <span>${params.voter.substring(0,4) + '...' + params.voter.substring(params.voter.length - 4)}</span>
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
        loadComment()
    </script>
@endsection
