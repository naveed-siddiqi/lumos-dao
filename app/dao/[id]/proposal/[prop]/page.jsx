"use client"

import { stopTalking, talk } from '@/app/components/alert/swal';
import { copyLink, createTrustline, fArr, N, paginate, sendProposalComment, voteProposal } from '@/app/core/core';
import { fAddr, getAlldaoInfo, getAllPropInfo, getDaoDelegators, getProposalComment, getProposalGroupInfo, getProposalVotersInfo, getTokenUserBal, getVotingPower, isBanned } from '@/app/core/getter';
import { floatingConstant, API_URL } from '@/app/data/constant';
import React, { useEffect, useState } from 'react'
import { BiLogoLinkedin } from 'react-icons/bi';
import { BsChevronRight, BsLinkedin, BsReddit, BsTwitterX, BsWhatsapp } from 'react-icons/bs'
import { FaFacebook } from 'react-icons/fa'
import { FaSquareXTwitter } from "react-icons/fa6";
import { MdOutlineWhatsapp } from 'react-icons/md';
import { RiWhatsappFill } from "react-icons/ri";

let prop;let dao;let groupInfo;
let propId = "";  
let daoId = "";  
let vote_power;
let voterInfo;
let daoDelegatee; 
let vote_type = 0;
let hasLoad = false
var voter_info_page = 1;
var voter_page_segment = 10;

const ProposalInfo = () => {
    const [addComments, setAdComments] = useState(false)
    const [votes, setVote] = useState('')
    const [other, setOther] = useState(false)
     

    const setUp = async () =>{
        //get prop metadata
        prop = (await getAllPropInfo(propId, daoId))[propId]; //display the voters info
        //display info
        E('prop_name').innerText = prop.title || ""
        E('prop_about').innerHTML = prop.description || ""
        //get prop info on chain
        await loadGroupInfo()
        prop = {...(groupInfo.proposal), ...prop};  
        E('prop_status').innerText = (prop.status == 4) ? "Ended" : (prop.status == 0) ? "Inactive" : (prop.status == 1) ? "Active": (prop.status == 2) ? "Rejected" : "Funded"
        //get dao info
        dao = (await getAlldaoInfo(daoId))[daoId];  
        E('dao_nav_link').innerText = dao.name
        E('dao_nav_link').href = "/dao/" + dao.token
        //set up vote info
        setUpVote()
        const delimtr = "https://" + (dao.domain).toLowerCase().trim() + ".lumosdao.io"
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
        E('prop_ipfs_link').innerText = "#" + propId
        E('prop_ipfs_link').href = `https://${prop.ipfs}.ipfs.w3s.link`
        if(prop.ipfs == "") {
            E('prop_ipfs_link').style.display = 'none'
        }
        E('prop_creator').href = "/user/"+prop.creator
        E('shareLink').innerText = window.location.href
        loadComment()
        
    }
    const setUpVote = async () => {
        //voting results
        //can vote, and has joined
        const my_vote = groupInfo.voter_type; 
        if(my_vote != 0){
            E('prop_yes_votes').innerText = prop.yes_votes || 0
            E('prop_yes_voting_power').innerText = (N(prop.yes_voting_power)/(floatingConstant))
            E('prop_no_votes').innerText = prop.no_votes || 0
            E('prop_no_voting_power').innerText = (N(prop.no_voting_power)/(floatingConstant))
            if((prop.yes_votes + prop.no_votes) > 0){
                const tmp = (N(prop.yes_votes) * (N(prop.yes_voting_power)/(floatingConstant))) + (N(prop.no_votes) * (N(prop.no_voting_power)/(floatingConstant)))
                E('prop_yes_bar').style.width = (Math.floor((100 / (tmp)) * (N(prop.yes_votes) * (N(prop.yes_voting_power)/(floatingConstant)))) + "%") || "0px"
                E('prop_no_bar').style.width = (Math.floor((100 / (tmp)) * (N(prop.no_votes) * (N(prop.no_voting_power)/(floatingConstant)))) + "%") || "0px"
            }
            else {
                E('prop_yes_bar').style.width =  "0px"
                E('prop_no_bar').style.width = "0px"
            }
        }
        E('prop_total_voters').innerText = (prop.no_votes + prop.yes_votes) || 0
        E('prop_total_voting_power').innerText = N(prop.yes_voting_power + prop.no_voting_power) / floatingConstant
            
        //populate for testing
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
                        E('add_comment').style.display =  'none'
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
        voterInfo = await getProposalVotersInfo(propId, dao.token)
        voter_info_page = 0
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

    const loadGroupInfo = async () => {
        groupInfo = await getProposalGroupInfo({
            propId,
            voter:walletAddress,
            dao:prop.dao
        })
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
    const voteWithReasonsYes = (e) => {
        e.preventDefault(); // Prevent form submission (since we're handling it manually)
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
            setVote("")
            vote(1, reason)
        } else {
             stopTalking(2, talk("Please select a reason", 'fail'))
        }
    }
    const voteWithReasonsNo = (e) => {
        e.preventDefault(); // Prevent form submission (since we're handling it manually)
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
             setVote("")
             vote(2, reason)
        } else {
             stopTalking(2, talk("Please select a reason", 'fail'))
        }
    }
    async function vote(voteType = 1, reason = "") {
         //disable the two buttons
         E('prop_vote_yes_action').style.display = 'none'
         E('prop_vote_no_action').style.display = 'none'
         const id = talk("Checking if you are a member")
         const bal = await getTokenUserBal(dao.token, walletAddress);  
         if(bal === false){  
             //has not joined, do trustline first
             talk("You are not a member of this DAO<br><center>Joining DAO</center>", 'norm', id)
             const res = await createTrustline(dao.code, dao.issuer, walletAddress, dao.name, dao.token)
             if(res === false){
                 stopTalking(4, talk('Unable to join DAO<br>Try again later', 'fail', id))
             }
             else {
                 stopTalking(4, talk('Joined DAO successfully', 'good', id))
             }
         }
         //calculate the voting power
         let vote_label;
         (voteType == 1) ? vote_label = "yes" : vote_label = "no"
         //fetch voting power
         talk("Fetching voting power", "norm", id)
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
                     daoId
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
                     prop = (await getAllPropInfo(propId, daoId))[propId]; //display the voters info
                     //get prop info on chain
                     await loadGroupInfo()
                     prop = {...(groupInfo.proposal), ...prop};  
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
    
    const sendComment = async () => {
        const msg = E('prop_comment_msg').value.trim()
        if(msg != "") {
            E('prop_send_comment').disabled = true //disable button
            const id = talk('Sending comment')
            if(await isBanned(dao.token, walletAddress)){stopTalking(0.1, id);return ""}
            const res = await sendProposalComment(propId, dao.token, msg, walletAddress); 
            if(res  === 1) {
                stopTalking(4, talk("Commented", 'good', id))
                setAdComments(false)
                loadComment()
            }
            else {
                stopTalking(4, talk("Something went wrong<br>Try again", 'fail', id))
            }
            E('prop_send_comment').disabled = false //eable button
        }
       
    }
    const loadComment = async () => {
        //read comments
        E('prop_comment_view').innerHTML = "<center>Loading comments...</center>"
        const comments = await getProposalComment(propId, daoId)
        if(comments !== false) {
            if(comments.length > 0) {
                let commentArr = [];
                for(let i=0;i<comments.length;i++) { 
                     const tmp = JSON.parse(comments[i]) //convert to json
                     commentArr.push(
                        {
                            voter:tmp.address,
                            msg:tmp.msg,
                            date:(new Date(tmp.date)).toLocaleDateString('en-us', { weekday:"short", year:"numeric", month:"short", day:"numeric"}) 
                        }
                     )
                 }
                paginate('prop_comment_view', commentArr, 20, drawVoterComment)
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
    const drawVoterComment = (params = {}) => {
        const tm = `<div class='border-b pb-3'>
                        <div class='flex items-center justify-between mb-2'>
                            <div class='flex items-center gap-2'>
                                <img  src='${API_URL + "user_img&user=" + params.voter}' class='w-[40px] h-[40px] rounded-full' alt="" />
                                <a className="text-blue-500" href='/user/${params.voter}'>${fAddr(params.voter)}</a>
                            </div>
                            <p>${params.date}</p>
                        </div>
                        <p>${params.msg}</p>
                    </div>`
                
        return tm 
    }
    const drawVotersInfo = (params = {}) => {
        const tm = `<tr class='bg-gray-100 rounded-[6px] py-4'>
                        <td class="px-4 py-2 text-sm font-[500] text-gray-700"><a href='/user/${params.voter}'>${fAddr(params.voter, 6)}</a></td>
                        <td class="px-4 py-2 text-sm font-[500] text-gray-700">${(params.vote_type == 1) ? "Yes" : "No"}</td>
                        <td class="px-4 py-2 text-sm font-[500] text-gray-700">${N(params.voting_power) / floatingConstant}
                          <span style='${(params.is_delegated == true) ? '' : 'display:none;'}background:dodgerblue;padding:5px;border-radius:5px;color:#fff;font-size:13px'>delegated</span>
                        </td>
                        <td class="px-4 py-2 text-sm font-[500] text-gray-700">
                          ${params.voting_reason.substring(0, 50)}
                        </td>
                        <td class="px-4 py-2 text-sm font-[500] text-gray-700">
                        ${(new Date(N(params.time) * 1000)).toLocaleString()}
                        </td>
                    </tr>`
                     return tm
    }
    const shareFunctions = (type = 'fb') => {
        const msg = `New proposal on ${dao.name} DAO ${prop.title} `
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
    
    useEffect(() => {
        window.E = (id) => document.getElementById(id)     
        window.walletAddress = localStorage.getItem('selectedWallet') || ""
        propId = window.location.href.substring(window.location.href.lastIndexOf("/") + 1);propId = propId.trim() * 1;
        daoId = window.location.href.substring(window.location.href.lastIndexOf("dao/") + 4);daoId = daoId.substring(0, daoId.indexOf("/"))

        if(!hasLoad) {
            hasLoad = true
            setUp()
        }
    }, [])
  return (
    <div className='px-[3rem] mb-[80px] mt-[40px]'>
        <div className='flex gap-1 items-center mb-4'>
            <a href='/dao' >Home</a>
            <BsChevronRight />
            <a id='dao_nav_link'></a>
            <BsChevronRight />
            <p className='font-[600]'>Proposal Info</p>
        </div>
        <div className='bg-white p-4 shadow rounded-[8px]'>
            <h2 id='prop_name' className="text-xl font-[500] mb-4"></h2>

            <div className="p-4 bg-[#EFF2F6] rounded-md mb-4">
                <div className="flex items-center justify-between mb-4">
                    <div className="flex items-center gap-2 mb-1">
                    <span className="text-lg font-medium">Yes</span>
                    <button style={{display:'none'}}  onClick={() => setVote("yes")} id='prop_vote_yes_action' className="bg-transparent border border-orange-400 text-orange-400 px-3 py-1 rounded">Vote</button>
                    </div>
                    <div>
                        <p className="text-right text-sm text-gray-500">Voting Power: <span id='prop_yes_voting_power'></span></p>
                        <p className="text-right text-sm text-gray-500">Votes: <span id='prop_yes_votes'></span></p>
                    </div>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-5">
                    <div id='prop_yes_bar' className="bg-[#198754] h-5 rounded-full" style={{ width: '0%' }}></div>
                </div>
            </div>

            <div className="p-4 bg-[#EFF2F6] rounded-md">
                <div className="flex items-center justify-between mb-4">
                    <div className="flex items-center gap-2 mb-1">
                    <span className="text-lg font-medium">No</span>
                    <button style={{display:'none'}} onClick={() => setVote("no")} id='prop_vote_no_action' className="bg-transparent border border-orange-400 text-orange-400 px-3 py-1 rounded">Vote</button>
                    </div>
                    <div>
                        <p className="text-right text-sm text-gray-500">Voting Power: <span id='prop_no_voting_power'></span></p>
                        <p className="text-right text-sm text-gray-500">Votes: <span id='prop_no_votes'></span></p>
                    </div>
                </div>
                <div className="w-full bg-gray-200 rounded-full h-5">
                    <div id='prop_no_bar' className="bg-[#198754] h-5 rounded-full" style={{ width: '0%' }}></div>
                </div>
            </div>
        </div>

        <div className='bg-white shadow pt-4 pb-6 px-4 mt-4 rounded-[8px]'>
            <p className='font-[500] text-xl mb-1'>Description</p>
            <p id='prop_about'></p>
        </div>

        <div id='attached_files' className='bg-white shadow pt-4 pb-6 px-4 mt-4 rounded-[8px]'>
            <p className='font-[500] text-xl mb-1'>Attached files:</p>
            <div id='prop_links' className="flex align-items-start justify-content-center gap-4 ">
                       
            </div>
        </div>

        <div className="p-4 bg-white rounded-[8px] shadow mt-4">
            <p className="mr-2 font-[500] text-xl">Share:</p>
            <div className='flex flex-col lg:flex-row items-center gap-10 bg-[#EFF2F6] p-4 rounded-[8px] mt-4'>
            <div className="my-8 grid lg:grid-cols-5 md:grid-cols-3 place-content-center place-items-center lg:w-[1200px]">
                  {/* Social Media Icons */}
                  <button onClick={() => {shareFunctions()}} className="text-blue-600 hover:opacity-75 border p-1 rounded-full border-blue-600 block">
                    <FaFacebook className='text-[40px]'/>
                  </button>
                  <button onClick={() => {shareFunctions("linkedin")}} className="text-white hover:opacity-75 border p-1 rounded-full border-blue-600">
                    <BiLogoLinkedin className='text-[40px] rounded-full bg-[#0866C2] p-1'/>
                  </button>
                  <button onClick={() => {shareFunctions("whatsapp")}} className="text-white hover:opacity-75 border p-1 rounded-full border-green-600">
                    <MdOutlineWhatsapp className='text-[40px] rounded-full bg-green-500  p-1'/>
                  </button>
                  <button onClick={() => {shareFunctions("twitter")}} className="text-white hover:opacity-75 border p-1 rounded-full border-black">
                    <BsTwitterX className='text-[40px] rounded-full bg-black p-1'/>
                  </button>
                  <button onClick={() => {shareFunctions("reddit")}} className="text-orange-600 hover:opacity-75 border p-1 rounded-full border-orange-600">
                    <BsReddit className='text-[40px]'/>
                  </button>
            </div>
            <div className='w-full flex items-center border rounded px-3 justify-between py-[6px]'>
                <p id='shareLink' className='w-[520px] overflow-x-hidden'></p>
                <button onclick={() => {copyLink(E("shareLink").value)}} className="ml-2 text-[14px] cursor-pointer">Copy Link</button>
            </div>
            </div>
        </div>

        <div className='bg-white shadow pt-4 pb-6 px-4 mt-4 rounded-[8px] grid lg:grid-cols-6 md:grid-cols-3 grid-cols-1 text-[14px] gap-5'>
            <div>
                <p className='font-[500]'>Proposal ID</p>
                <p id='prop_id' className='text-gray-400'></p>
            </div>
            <div>
                <p className='font-[500]'>Duration</p>
                <p  id='prop_duration' className='text-gray-400'></p>
            </div>
            <div>
                <p className='font-[500]'>Status</p>
                <p id='prop_status' className='text-gray-400'></p>
            </div>
            <div>
                <p className='font-[500]'>Total voters</p>
                <p id='prop_total_voters' className='text-gray-400'></p>
            </div>
            <div>
                <p className='font-[500]'>Total voting power</p>
                <p id='prop_total_voting_power' className='text-gray-400'></p>
            </div>
            <div>
                <p className='font-[500]'>Proposer</p>
                <a href="" id='prop_creator' className='text-blue-400'></a>
            </div>
            <div>
                <p className='font-[500]'>IPFS</p>
                <a target='_blank' id='prop_ipfs_link' className='text-blue-400'></a>
            </div>
        </div>

        <div className='bg-white shadow pt-4 pb-6 px-4 mt-4 rounded-[8px]'>
            <p className='font-[500] text-xl mb-3'>Votes</p>
            <table className='w-full text-left border-collapse'>
                <thead>
                    <tr className="bg-gray-100 rounded-[6px] py-4">
                        <th className="px-4 py-2 text-sm font-[500] text-gray-700">Address</th>
                        <th className="px-4 py-2 text-sm font-[500] text-gray-700">Vote</th>
                        <th className="px-4 py-2 text-sm font-[500] text-gray-700">Voting Power</th>
                        <th className="px-4 py-2 text-sm font-[500] text-gray-700">Reason</th>
                        <th className="px-4 py-2 text-sm font-[500] text-gray-700">Date</th>
                    </tr>
                </thead>
                <tbody id='voters_info'>
                   
                </tbody>
            </table>
            <div className='flex' style={{flexDirection:'row-reverse'}}>
                    <button id='next_voter_info' className='btn' style={{display:'none'}}>Next</button>
                    <button id='pre_voter_info' className='btn' style={{display:'none'}}>Prev</button>
            </div>
        </div>
        <div className='flex items-center justify-between mt-1'>
            <p></p>
            <p id='add_comment' className='border p-1 rounded-[4px] px-2 mt-2 cursor-pointer' onClick={() => setAdComments(true)}>Add Comments</p>
        </div>
        {
            addComments && 
            <div className='mt-4 bg-white shadow pt-4 pb-6 px-4 rounded-[8px]'>
                <textarea id='prop_comment_msg' className='w-full h-[160px] border outline-none p-3'></textarea>
                <div>
                    <button onClick={() => {sendComment()}} id='prop_send_comment' className='bg-[#343257] px-2 py-1 mr-2 text-white rounded-[6px]'>Send</button>
                    <button className='border px-2 py-1 mr-2 text-gray-500 rounded-[6px]' onClick={() => setAdComments(false)}>Cancel</button>
                </div>
            </div>
        }

        <div className='bg-white shadow pt-4 pb-6 px-4 mt-4 rounded-[8px]'>
            <p className='font-[500] text-xl mb-4'>Comments</p>
            <div id='prop_comment_view'>
                
            </div>
        </div>

        {
            votes === "yes" &&
            <div>
                <div className="h-full w-full fixed top-0 left-0 z-[99]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setVote(false)}></div>
                <div className="bg-white md:w-[600px] w-[80%] flex flex-col items-start fixed top-[50%] left-[50%] pb-[1rem] rounded-[15px] z-[100] login-modal" style={{ transform: "translate(-50%, -50%)" }}>
                    <div className='flex items-center justify-between pt-3 px-6 w-full'>
                        <p className='text-[20px] font-[500]'></p>
                        <p onClick={() => setVote(false)} className='text-gray-500 text-[28px] cursor-pointer'>&times;</p>
                    </div>
                    <form onSubmit={($event) => {voteWithReasonsYes($event)}}>
                    <div className='flex items-start justify-start flex-col px-[20px] border-b mb-3 pb-4 w-full'>
                        <p className='text-[20px] font-[500] mb-3'>Reason</p>
                        <div className='flex gap-2 mb-1 text-[14px]'>
                            <input type="radio" name='reasons'  value="1"/>
                            <p>Alignment with Project Goals</p>
                        </div>
                        <div className='flex gap-2 mb-1 text-[14px]'>
                            <input type="radio" name='reasons'  value="2"/>
                            <p>Beneficial Impact</p>
                        </div>
                        <div className='flex gap-2 mb-1 text-[14px]'>
                            <input type="radio" name='reasons'  value="3"/>
                            <p>Feasibility and Sustainability</p>
                        </div>
                        <div className='flex gap-2 mb-1 text-[14px]'>
                            <input type="radio" name='reasons'  value="other" onChange={e => setOther(true)}/>
                            <p>Other</p>
                        </div>
                        {
                            other &&
                            <div className='text-[14px] w-full'>
                                <p>Mention the Reason here:</p>
                                <input type="text" name='other_reasons' className='border border-blue-300 p-3 rounded-[6px] w-full'/>
                                <p className='text-end text-[#DC3446]'>-Max 50 characters</p>
                            </div>
                        }
                    </div>
                    <div className='flex justify-between w-full p-3'>
                        <p></p>
                        <button type='submit' className='py-[7px] rounded-[4px] bg-[#DC3446] px-3 block text-white'>Confirm</button>
                    </div>
                    </form>
                </div>
            </div>
        }
        {
            votes === "no" &&
            <div>
                <div className="h-full w-full fixed top-0 left-0 z-[99]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setVote(false)}></div>
                <div className="bg-white md:w-[600px] w-[80%] flex flex-col items-start fixed top-[50%] left-[50%] pb-[1rem] rounded-[15px] z-[100] login-modal" style={{ transform: "translate(-50%, -50%)" }}>
                    <div className='flex items-center justify-between pt-3 px-6 w-full'>
                        <p className='text-[20px] font-[500]'></p>
                        <p onClick={() => setVote(false)} className='text-gray-500 text-[28px] cursor-pointer'>&times;</p>
                    </div>
                    <form onSubmit={($event) => {voteWithReasonsNo($event)}}>
                    <div className='flex items-start justify-start flex-col px-[20px] border-b mb-3 pb-4 w-full'>
                        <p className='text-[20px] font-[500] mb-3'>Reason</p>
                        <div className='flex gap-2 mb-1 text-[14px]'>
                            <input type="radio" name='reasonsNo'  value="1" />
                            <p>Lack of Alignment with Goals</p>
                        </div>
                        <div className='flex gap-2 mb-1 text-[14px]'>
                            <input type="radio" name='reasonsNo'  value="2" />
                            <p>High budget</p>
                        </div>
                        <div className='flex gap-2 mb-1 text-[14px]'>
                            <input type="radio" name='reasonsNo'  value="3" />
                            <p>Feasibility Concerns</p>
                        </div>
                        <div className='flex gap-2 mb-1 text-[14px]'>
                            <input type="radio"  value="other" name='reasonsNo'  onChange={e => setOther(true)} />
                            <p>Other</p>
                        </div>
                        {
                            other &&
                            <div className='text-[14px] w-full'>
                                <p>Mention the Reason here:</p>
                                <input name='other_reasons_no' type="text" className='border border-blue-300 p-3 rounded-[6px] w-full'/>
                                <p className='text-end text-[#DC3446]'>-Max 50 characters</p>
                            </div>
                        }
                    </div>
                    <div className='flex justify-between w-full p-3'>
                        <p></p>
                        <button type='submit' className='py-[7px] rounded-[4px] bg-[#DC3446] px-3 block text-white'>Confirm</button>
                    </div>
                    </form>
                </div>
            </div>
        }
    </div>

    
  )
}

export default ProposalInfo