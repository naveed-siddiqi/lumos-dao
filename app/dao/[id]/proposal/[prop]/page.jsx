"use client"

import { stopTalking, talk } from '@/app/components/alert/swal';
import { copyLink, createTrustline, fArr, N, paginate, sendProposalComment, voteProposal } from '@/app/core/core';
import { fAddr, getAlldaoInfo, formatDate, getAllPropInfo, getUserInfo, getVotingResults, getAllProposal, getDaoDelegators, getProposalComment, getProposalGroupInfo, getProposalVotersInfo, getProposalVoterInfo, getTokenUserBal, getVotingPower, isBanned, isMember } from '@/app/core/getter';
import { floatingConstant, API_URL, PINNA_CLOUD } from '@/app/data/constant';
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
let selectedVoteType = window.localStorage.getItem('voteType')
let itemsPerPage = 10;


const ProposalInfo = () => {
    const [addComments, setAdComments] = useState(false)
    const [votes, setVote] = useState('')
    const [other, setOther] = useState(false)
    const [selectedType, setSelectedType] = useState('')
    const [voted, setVoted] = useState('')
    const [votingType, setVotingType] = useState(0);  // State to hold prop data
    const [votingLabel, setVotingLabel] = useState({});  // State to hold prop data

    const [selectedIndices, setSelectedIndices] = useState([]); // To store indices of selected options
    const [voteCounts, setVoteCounts] = useState([]); // To store indices of selected options
    const [sliderValues, setSliderValues] = useState({}); 

    const [selectedOptions, setSelectedOptions] = useState([]); // Array to store selected options
    const [votingResults, setVotingResults] = useState([]); // Array to store selected options
    const [hasVoted, setHasVoted] = useState(false); // Array to store selected options
    const [balanceToken, setBalanceToken] = useState(0); // Array to store selected options
    const [voteCounted, setVoteCounted] = useState(0); // Array to store selected options
    const [propComments, setPropComments] = useState([]); // Array to store selected options
    const [currentPage, setCurrentPage] = useState(1);
    const [propStatus, setPropStatus] = useState(100)
    const [currentUrl, setCurrentUrl] = useState("")

    const handleOptionMultiClick = (option, index) => {
        setSelectedOptions(prevOptions => {
            // Toggle option: add if not selected, remove if already selected
            if (prevOptions.includes(option)) {
                return prevOptions.filter(item => item !== option);
            } else {
                return [...prevOptions, option];
            }
        });

        setSelectedIndices(prevIndices => {
            // Toggle index: add if not selected, remove if already selected
            if (prevIndices.includes(index)) {
                return prevIndices.filter(i => i !== index);
            } else {
                return [...prevIndices, index];
            }
        });

    };


    const handleOptionClick = (option, index) => {
        if(votingType == 0 || votingType == 1){

            setSelectedType(option);
            
            // Set only one index in the selectedIndices array
        setSelectedIndices([index]); // Overwrite the array with the new index

        }else if(votingType == 3){

            setSelectedIndices(prevIndices => {
                // Toggle index: add if not selected, remove if already selected
                if (prevIndices.includes(index)) {
                    return prevIndices.filter(i => i !== index);
                } else {
                    return [...prevIndices, index];
                }
            });
        }

    };

    const handleInputChange = (index, event) => {
        const inputValue = +event.target.value;

        // Update the values array at the specific index
        setVoteCounts(prevValues => {
            const newValues = [...prevValues];
            newValues[index] = inputValue; // Set value at index
            return newValues;
        });

        // Update the indices array only if it's not already included
        setSelectedIndices(prevIndices => {
            if (!prevIndices.includes(index)) {
                return [...prevIndices, index];
            }
            return prevIndices;
        });
       

    };


    const handleSliderChange = (index, value) => {
        const validValue = isNaN(value) || value === null ? 0 : value;        

        setSliderValues(prevValues => ({
            ...prevValues,
            [index]: validValue,
        }));

        // Update indices and values arrays
        setSelectedIndices(prevIndices => {
            if (!prevIndices.includes(index)) {
                return [...prevIndices, index];
            }
            return prevIndices;
        });

        setVoteCounted(prevValues => {
            const newValues = [...prevValues];
            newValues[index] = validValue;
            return newValues;
        });         
        const v = voteCounted.filter(b => typeof(b) === "number");
        setVoteCounts(v.reverse())
       
    };

    const totalPages = Math.ceil(propComments.length / itemsPerPage);
  
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentComments = propComments.slice(indexOfFirstItem, indexOfLastItem);
  
    const handleNext = () => {
      if (currentPage < totalPages) {
        setCurrentPage(currentPage + 1);
      }
    };
  
    const handlePrev = () => {
      if (currentPage > 1) {
        setCurrentPage(currentPage - 1);
      }
    };
  
    
    const setUp = async () =>{
        if(window.CHAIN == "stellar"){
      //get prop metadata
      prop = (await getAllPropInfo(propId, daoId))[propId]; //display the voters info
     
        }else{
         prop = (await getAllProposal([propId], daoId, 'xrp'))[propId];
         setPropStatus(prop.status)
        }

        //display info
        E('prop_name').innerText = prop.title || ""
        E('prop_name').fontSize = '22px'
        E('prop_about').innerHTML = prop.description || ""
        E('prop_about').style.color = '#52606D'
        E('prop_about').style.fontSize = '14px'

        if(window.CHAIN == "stellar"){
        //get prop info on chain
        await loadGroupInfo()
        prop = {...prop, ...(groupInfo.proposal)}; 
        setPropStatus(Number(prop.status))
        }
        console.log(prop)

        setVotingType(prop.voting_type);
        setVotingLabel(JSON.parse(prop.voting_label));

        const voteResults = await getVotingResults(prop.voting_options, prop.voting_label)
        setVotingResults(voteResults)

        if(window.CHAIN == "stellar"){
            const votedUser = await getProposalVoterInfo(propId, walletAddress)
            const voted = votedUser.some(user => user.voter == walletAddress)
            E('prop_total_voters').innerText = votedUser.length.toLocaleString()
            setHasVoted(voted)

        }else{
            const voted = prop.ProposalVoter.some(w => w == walletAddress)
            E('prop_total_voters').innerText = prop.ProposalVoter.length.toLocaleString()
            setHasVoted(voted)
        }


        E('prop_status').innerText = (prop.status == 4) ? "Ended" : (prop.status == 0) ? "Inactive" : (prop.status == 1) ? "Active": (prop.status == 2) ? "Rejected" : "Funded"
        //get dao info
        dao = (await getAlldaoInfo(daoId))[daoId]; 

      const balance = await getTokenUserBal(dao.token, walletAddress, CHAIN)
       E('balance').innerHTML = Number(balance) || 0
    //    E('balanceT').innerText = Number(balance) || 0
    //    E('balance').style.fontSize = '28px'
       
       setBalanceToken(Number(balance))

        const delimtr = "https://" + (dao.domain).toLowerCase().trim() + ".testing.lumosdao.io"
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
        E('prop_ipfs_link').href = `${PINNA_CLOUD}/ipfs/${prop.ipfs}` 
        //caluclate the total no of voters and voting power
        let totalVotingPower = 0;
        for(let i=0;i<prop.voting_options.length;i++) { 
            totalVotingPower += N(prop.voting_options[i].voting_count)
        }
        E('prop_total_voting_power').innerText = totalVotingPower.toLocaleString()
        if(prop.ipfs == "") {
            E('prop_ipfs_link').style.display = 'none'
        }
        E('prop_creator').href = "/user/"+prop.creator
        // E('shareLink').innerText = window.location.href
        loadComment()
        
    }

    // const setUpVote = async () => {
    //     //voting results
    //     E('prop_yes_votes').innerText = prop.yes_votes || 0
    //     E('prop_yes_voting_power').innerText = (N(prop.yes_voting_power)/(floatingConstant))
    //     //can vote, and has joined
    //     const my_vote = groupInfo.voter_type; 
    //     if(my_vote != 0 || true){
    //         if((prop.yes_votes + prop.no_votes) > 0){
    //             const tmp = (N(prop.yes_votes) * (N(prop.yes_voting_power)/(floatingConstant))) + (N(prop.no_votes) * (N(prop.no_voting_power)/(floatingConstant)))
    //             E('prop_yes_bar').style.width = (Math.floor((100 / (tmp)) * (N(prop.yes_votes) * (N(prop.yes_voting_power)/(floatingConstant)))) + "%") || "0px"
    //             E('prop_no_bar').style.width = (Math.floor((100 / (tmp)) * (N(prop.no_votes) * (N(prop.no_voting_power)/(floatingConstant)))) + "%") || "0px"
    //         }
    //         else {
    //             E('prop_yes_bar').style.width =  "0px"
    //             E('prop_no_bar').style.width = "0px"
    //         }
    //     }
    //     E('prop_no_votes').innerText = prop.no_votes || 0
    //     E('prop_no_voting_power').innerText = (N(prop.no_voting_power)/(floatingConstant))
    //     E('prop_total_voters').innerText = (prop.no_votes + prop.yes_votes) || 0
    //     E('prop_total_voting_power').innerText = N(prop.yes_voting_power + prop.no_voting_power) / floatingConstant
            
    //     //populate for testing
    //     daoDelegatee = groupInfo.delegatee; 
    //     //reset buttons
    //     E('prop_vote_yes_action').style.display = 'none'
    //     E('prop_vote_no_action').style.display = 'none'
    //     E('prop_vote_yes_action').disabled = false
    //     E('prop_vote_no_action').disabled = false
    //      if(prop.status == 1) {
    //             if(my_vote == 0 && daoDelegatee.length < 1) {
    //                 if(!prop.executed) {
    //                     //has not voted, show both vote buttons
    //                     E('prop_vote_yes_action').style.display = 'block'
    //                     E('prop_vote_no_action').style.display = 'block'
    //                     //hide comment button
    //                     E('add_comment').style.display =  'none'
    //                 }
    //             }
    //             else if(my_vote == 1 && daoDelegatee.length < 1) {
    //                     //voted yes
    //                     E('prop_vote_yes_action').style.display = 'block'
    //                     E('prop_vote_yes_action').innerText = 'Voted'
    //                     E('prop_vote_yes_action').disabled = true
    //                     //show add comment button
    //                     E('add_comment').style.display = 'flex'
    //                 }
    //             else if(my_vote == 2 && daoDelegatee.length < 1) {
    //                     //voted yes
    //                     E('prop_vote_no_action').style.display = 'block'
    //                     E('prop_vote_no_action').innerText = 'Voted'
    //                     E('prop_vote_no_action').disabled = true
    //                     //show comment button
    //                      E('add_comment').style.display = 'flex'
    //                 }
    //             else { 
    //                     //has delegated voting power
    //                     E('prop_vote_yes_action').style.display = 'block'
    //                     E('prop_vote_no_action').style.display = 'block'
    //                     E('prop_vote_no_action').innerText = 'Delegated'
    //                     E('prop_vote_yes_action').innerText = 'Delegated'
    //                     E('prop_vote_no_action').disabled = true
    //                     E('prop_vote_yes_action').disabled = true
    //                     //hide comment button
    //                     E('add_comment').style.display = 'none'
    //                 }
    //         }
    //     else {
    //             //proposal no longer active
    //             E('prop_vote_yes_action').style.display = 'none'
    //             E('prop_vote_no_action').style.display = 'none'
    //             E('prop_vote_no_action').disabled = true
    //             E('prop_vote_yes_action').disabled = true
    //             //hide comment button
    //             E('add_comment').style.display = 'none'
    //         }
    //     E('prop_vote_yes_action').onclick = async () => {
    //             //store the vote type
    //             vote_type = 1
    //         }
    //     E('prop_vote_no_action').onclick = async () => {
    //             //store the vote type
    //             vote_type = 2
    //         }
    //     voterInfo = await getProposalVotersInfo(propId, dao.token)
    //     voter_info_page = 0
    //     loadVoterInfo()
    //     //configure the buttons
    //     E('next_voter_info').onclick = () => {
    //         if(voter_info_page < voterInfo.length / voter_page_segment){
    //           loadVoterInfo(voter_info_page + 1)
    //           voter_info_page++
    //         }
    //     }
    //     E('pre_voter_info').onclick = () => {
    //         if(voter_info_page > 1){
    //           loadVoterInfo(voter_info_page - 1)
    //           voter_info_page--
    //         }
    //     }
    // }

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
    /** To cast vote */
    const castVote = () => {
        /**
         * Do logic to get the voting option selected
         * and the value for each voting options 
         * based on the voting type
         */
        /** FOR USING VOTING POWER VOTING TYPE
         * Use this logic to get the voting powers
         * delegated to a wallet address
         * const delegators = await getDaoDelegators(dao.token, walletAddress)
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
             }
         */
        let votingPower = 3
        let voteCount = [];
        let voteLabel = [];
        let propVoteLabel = [];
        let credit = 100

        if(votingType == 0){
            const count = selectedIndices.map((n) => {
                return +balanceToken
            })
            voteCount = count
        }else if(votingType == 1){
              const count = selectedIndices.map((n) => {
                return +votingPower
            })
            voteCount = count
        }else if(votingType == 2){
            voteCount = voteCounts
        }else if(votingType == 3){
           const count = selectedIndices.map((n) => {
                return votingPower/selectedIndices.length
            })
            voteCount = count
        }else if(votingType == 4){
            const count = voteCounts.map((n) => {
                return (n/100)*credit
            })
            voteCount = count
        }else if(votingType == 5){
            voteCount = voteCounts
        }else{
            voteCount = [0]
        }

        for(let k in votingLabel){
            voteLabel.push(votingLabel[k])
        }

        for(let i = 0; i <= voteLabel.length - 1; i++){
            for(let j = 0; j <= selectedIndices.length - 1; j++){
               if(voteLabel.indexOf(voteLabel[i]) == selectedIndices[j] && !propVoteLabel.includes(voteLabel[i])){
                propVoteLabel.push(voteLabel[i])
               }

            }
        }

        const voteTypes = selectedIndices
        const voteCounts = voteCount       
        const voteLabels = propVoteLabel
        vote(voteTypes, voteCounts, voteLabels)  
    }

    async function vote(voteTypes=[], voteCounts=[], voteLabels=[]) {
         //disable the two buttons
         E('vote_large_button').disabled = true //disable the vote button
         const id = talk("Checking if you are a member")
         const isMem = await isMember(dao.token, walletAddress);  
         //check if the voter is a member of this dao
         if(isMem === false){  
             //has not joined, 
             talk("You are not a member of this DAO<br><center>Joining DAO</center>", 'norm', id)
             //Join the dao first
             const res = await createTrustline(dao.code, dao.issuer, walletAddress, dao.name, dao.token)
             if(res === false){
                 stopTalking(4, talk('Unable to join DAO<br>Try again later', 'fail', id))
                 return;
             }
             else {
                talk('Joined DAO successfully', 'good', id)
             }
         }

        /** Join if this member is not banned
         * Banned members are not allowed to vote
        **/
        if(await isBanned(dao.token, walletAddress)){stopTalking(0.1, id);return ""}
        if(voteCounts.length == voteTypes.length && voteLabels.length == voteCounts.length){
            talk("Voting " + voteLabels.join(", ") + " on this proposal", "norm", id)
            const res = await voteProposal({
                proposalId: propId,
                voters: walletAddress,
                vote_type:voteTypes,
                vote_label:voteLabels,
                voting_count:voteCounts,
                name:prop.name,
                reason:"",
                owner:prop.creator,
                daoId
            })
            if(res.status == true) {
                if(res.value == 'voted') {
                    stopTalking(4, talk("Voted successfully", 'good', id))
                }
                else if(res.value == 'hasvoted') {
                    stopTalking(4, talk("Already voted on this proposal", 'warn', id))
                }
                else if(res.value == 'lowbal') {
                    stopTalking(4, talk("You don't have sufficient DAO asset balance to make this vote", 'fail', id))
                }
                else if(res.value == 'lowbal') {
                    stopTalking(4, talk("This proposal does not accept vote at this time", 'fail', id))
                }
                else if(res.value == 'inactive') {
                    stopTalking(4, talk("This proposal is not active", 'fail', id))
                }
                else if(res.value == 'ended') {
                    stopTalking(4, talk("This proposal has ended", 'fail', id))
                }
                else  {
                    stopTalking(4, talk("Something went wrong", 'fail', id))
                }
                prop = (await getAllPropInfo(propId, daoId))[propId]; //display the voters info
                /** GET PROP INFO ON CHAIN AND DISPLAY THE RESULT  */
                // await loadGroupInfo()
                // prop = {...(groupInfo.proposal), ...prop};  
            }
            else {
                //something went wrong
                stopTalking(4, talk(`${res?.msg || "Something went wrong"}<br>Try again later`, 'fail', id))
            }
        }
        //enable the vote button again
        E('vote_large_button').disabled = false
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
                 setPropComments(commentArr)
                // paginate('prop_comment_view', commentArr, 20, drawVoterComment)
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
        setCurrentUrl(window.location.href); 

        if(!hasLoad) {
            hasLoad = true
            setUp()
        }
    }, [])

    const [rangeValue, setRangeValue] = useState(2);

    const handleChange = (e) => {
        setRangeValue(Number(e.target.value));
      };

    // const [showCommentBox, setShowCommentBox] = useState(false)


  return (
    <div className='mb-[80px] mt-[40px] helvetica-font'>
        {/* <div className='flex gap-1 items-center mb-4'>
            <a href='/dao' >Home</a>
            <BsChevronRight />
            <a id='dao_nav_link'></a>
            <BsChevronRight />
            <p className='font-[600]'>Proposal Info</p>
        </div> */}

        <div className='mb-[4rem] px-[1rem] lg:mx-[7rem] md:mx-[4rem] mx-[1rem] py-[1.8rem] bg-white'>

            {
                propStatus == 0 ?
                (
            <div className="flex justify-end pb-[15px]">
            <p className="text-end bg-[#ec1e1e] rounded-[5px] w-auto px-[10px] text-white/100">Proposal is not active and is awaiting admin approval</p>
            </div>
                )
                :
                null
            }

            <div className='flex items-start justify-between w-full'>
                <div className='w-[530px]'>
                    <p id='prop_name'></p>
                    {/* <p className='text-[#52606D]'>Use your tokens to vote on proposals that matter to you.</p> */}
                </div>
                <div className='text-center'>
                    <p>Available balance</p>
                    <p id="balance"></p>
                </div>
            </div>
            <div className='flex items-center text-[14px] mt-12 gap-1'>
                <p className='text-[#141B34]'>Vote type :</p>
                <p className='text-[#FF7B1B]'>{votingType == 0 ? "Token-Based" : votingType === 1 ? "Weighted" : votingType === 2 ? "Quadratic" : votingType === 3 ? "Approval" : votingType === 4 ? "Cumulative" : votingType === 5 ? "Range" : ""}</p>
            </div>
            <div className='flex justify-between items-start py-3 px-5 rounded-[10px] border border-[#FBE4BB] bg-[#FFF8EC] lg:w-[700px] w-[100%] mt-[1rem]'>
                <div>
                    <p className='text-[#FF7B1B] font-[400] text-[16px] mb-2'>Info:</p>
                   {
                    votingType == 0 ?
                    (<p className='text-[#FF7B1B] leading-6 text-[14px]'>You have total of <span>{balanceToken}</span> tokens available to vote on the proposal below. Your voting power is based on the number of tokens you hold. Distribute your tokens among the proposals as you see fit.</p>)
                    :
                    votingType == 1 ?
                    (<p className='text-[#FF7B1B] leading-6 text-[14px]'>Distibute your 100% voying power across options based on the tokens you hold</p>)
                    :
                    votingType == 2 ?
                    (<p className='text-[#FF7B1B] leading-6 text-[14px]'>You have <span>{balanceToken}</span> tokens available for voting. Distribute your votes across proposals, but remember the cost for each additional vote increases quadratically. </p>)
                    :
                    votingType == 3 ?
                    (<p className='text-[#FF7B1B] leading-6 text-[14px]'>You have 100% of your voting power to distribute equally among the options you approve of. Optionally, provide a reason for your vote. </p>)
                    
                    :votingType == 4 ?
                    (<p className='text-[#FF7B1B] leading-6 text-[14px]'>Distribute your available votes between the options below. You can assign multiple votes to the same option or split them. You have 100% of your voting power to distribute </p>)   
                    
                    :votingType == 5 ?
                    (<p className='text-[#FF7B1B] leading-6 text-[14px]'>Use this slider to assign a score for the proposal. The score represents how strongly you approve or disapprove the proposal, with higher scores indicating stronger approval. it starts with 1 and ends with 5 as its maximum count for each option.</p>)  
                    :null
                } 
                </div>
            </div>

{
    !hasVoted ? (
        <div>
        {
            votingType == 1 ?
            (<div className='mt-[2rem]'>
                <div className='bg-white border border-[#E7E7E7] text-center px-4 mt-4 rounded-[8px] grid lg:grid-cols-6 md:grid-cols-4 grid-cols-1 text-[14px] gap-5'>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>Percentage (%)</p>
                        <p className='text-gray-400'>Voting Power Count</p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>1-5%</p>
                        <p className='text-gray-400'>1 Voting Power</p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>6-10%</p>
                        <p className='text-gray-400'>2 Voting Power</p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>11-15%</p>
                        <p className='text-gray-400'>3 Voting Power</p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>16-20%</p>
                        <p className='text-gray-400'>4 Voting Power</p>
                    </div>
                    <div className='py-[5px]'>
                        <p className='font-[400] mb-2'>21%-Above</p>
                        <p className='text-gray-400'>5 Voting Power</p>
                    </div>
                </div>
            </div>)
            :
            null
        }


        <div className='text-[#52606D] font-[300] w-[750px] my-[3rem]'>
            <p id='prop_about'></p>
        </div>

        <div className='md:w-[350px] w-full'>
            <div className='flex items-center justify-between'>
                <p>Cast Vote</p>
                {
                    votingType == 1 ?
                    (<p className="text-[#FF7B1B]">Voting Power: <span>3</span> </p>)
                    :null
                }
                {
                    votingType == 4 ?
                   ( <p>% Left: <span className='text-[#FF7B1B]'>{100-(voteCounts.reduce((acc, val) => acc+val, 0))}%</span> </p>)
                   : null
                }
            </div>
            
           
            {votingType == 0 && (
        Object.keys(votingLabel).map((key) => {
            const option = votingLabel[key];
            const index = parseInt(key); 
            
            return (
                <div 
                   
                key={index}
                onClick={() => handleOptionClick(option, index)}
                    className={
                        selectedType === option 
                            ? 'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#FBE4BB] bg-[#FFFCF5] w-[100%] mt-[0.5rem]' 
                            : 'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#EAECF0] bg-[#FFF] w-[100%] mt-[0.5rem]'
                    }
                >
                    <div>
                        <p className={
                            selectedType === option 
                                ? 'text-[#FF7B1B] font-[400] text-[14px]' 
                                : 'text-[#344054] font-[400] text-[14px]'
                        }>
                            {option}
                        </p>
                    </div>
                    {selectedType === option 
                        ? <img src="/images/check-mark.svg" alt="Selected" /> 
                        : <img src="/images/empty-check.svg" alt="Not Selected" />
                    }
                </div>
            );
        })
    )}

{votingType == 3 && (
            Object.keys(votingLabel).map((key) => {
                const option = votingLabel[key];
                const index = parseInt(key);

                return (
                    <div
                        key={index}
                        onClick={() => handleOptionMultiClick(option, index)}
                        className={
                            selectedOptions.includes(option)
                                ? 'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#FBE4BB] bg-[#FFFCF5] w-[100%] mt-[0.5rem]'
                                : 'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#EAECF0] bg-[#FFF] w-[100%] mt-[0.5rem]'
                        }
                    >
                        <div>
                            <p className={
                                selectedOptions.includes(option)
                                    ? 'text-[#FF7B1B] font-[400] text-[14px]'
                                    : 'text-[#344054] font-[400] text-[14px]'
                            }>
                                {option}
                            </p>
                        </div>
                        {selectedOptions.includes(option)
                            ? <img src="/images/check-mark.svg" alt="Selected" />
                            : <img src="/images/empty-check.svg" alt="Not Selected" />
                        }
                    </div>
                );
            })
        )}


{votingType == 1 && (
        Object.keys(votingLabel).map((key) => {
            const option = votingLabel[key];
                const index = parseInt(key); 
            
            return (
                <div 
               
                    key={index}
                    onClick={() => handleOptionClick(option, index)}
                    className={
                        selectedType === option 
                            ? 'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#FBE4BB] bg-[#FFFCF5] w-[100%] mt-[0.5rem]' 
                            : 'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#EAECF0] bg-[#FFF] w-[100%] mt-[0.5rem]'
                    }
                >
                    <div>
                        <p className={
                            selectedType === option 
                                ? 'text-[#FF7B1B] font-[400] text-[14px]' 
                                : 'text-[#344054] font-[400] text-[14px]'
                        }>
                            {option}
                        </p>
                    </div>
                    {selectedType === option 
                        ? <img src="/images/check-mark.svg" alt="Selected" /> 
                        : <img src="/images/empty-check.svg" alt="Not Selected" />
                    }
                </div>
            );
        })
    )}

            {
                votingType == 4 ?
                (
                    <div className='mt-8'>
                        {Object.entries(votingLabel).map(([key, label], index) => (
                            <div key={key} className='my-5'>
                                <p className='text-[#344054]'>{label}</p>
                                <div className='border border-[#D0D5DD] mt-1 rounded-[8px] flex items-center justify-between py-[12px] px-2'>
                                    <input 
                                        type="number" 
                                        className='outline-none w-[90%]' 
                                        placeholder='0.0' 
                                        onChange={(e) => handleInputChange(index, e)}
                                    />
                                    <span className='text-[#344054]'>%</span>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : null
            }

            {/* {
                 
                 votingType == 2 ? 
                (<div className='mt-8'>
                    <div>
                        <p className='text-[#344054]'>For</p>
                        <div className='border border-[#D0D5DD] mt-1 rounded-[8px] flex items-center justify-between py-[12px] px-2'>
                            <input type="number" className='outline-none w-[90%]' placeholder='0.0' />
                        </div>
                    </div>
                    <div className='my-5'>
                        <p className='text-[#344054]'>Against</p>
                        <div className='border border-[#D0D5DD] mt-1 rounded-[8px] flex items-center justify-between py-[12px] px-2'>
                            <input type="number" className='outline-none w-[90%]' placeholder='0.0' />
                        </div>
                    </div>
                    <div>
                        <p className='text-[#344054]'>Abstain</p>
                        <div className='border border-[#D0D5DD] mt-1 rounded-[8px] flex items-center justify-between py-[12px] px-2'>
                            <input type="number" className='outline-none w-[90%]' placeholder='0.0' />
                        </div>
                    </div>
                </div>)
                :null
            } */}
            {
votingType == 2 ? 
(
    <div className='mt-8'>
        {Object.entries(votingLabel).map(([key, label], index) => (
            <div key={key} className='my-5'>
                <p className='text-[#344054]'>{label}</p>
                <div className='border border-[#D0D5DD] mt-1 rounded-[8px] flex items-center justify-between py-[12px] px-2'>
                    <input type="number" className='outline-none w-[90%]' placeholder='0.0' onChange={(e) => handleInputChange(index, e)}
                    />
                </div>
            </div>
        ))}
    </div>
) : null
}


{votingType == 5 ? (
            <div className='mt-8 w-full flex flex-col items-center'>
                {Object.entries(votingLabel).map(([key, label]) => (
                    <div key={key} className='w-full text-center my-5'>
                        <p className='text-[#9F9D99] mb-2 text-left'>{label}</p>
                        <div className="relative w-full">
                            <input
                                type="range"
                                min="0"
                                max="5"
                                value={sliderValues[key] || 0}
                                onChange={(e) => handleSliderChange(parseInt(key), parseInt(e.target.value))}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                            />
                            <div
                                className="absolute top-1/2 transform -translate-y-1/2 w-5 h-5 border-[#FF7B1B] border-2 bg-white rounded-full shadow pointer-events-none"
                                style={{ left: `calc(${(sliderValues[key] || 0) * 20}% - 10px)` }}
                            />
                        </div>
                        <span className="mt-1 text-black font-medium">{sliderValues[key] || 0}</span>
                    </div>
                ))}
             
            </div>
        ) : null}

            {
                propStatus !== 0 ?
                (
        <button id='vote_large_button' disabled={votingType == 4 ? ((voteCounts.reduce((acc, val) => acc+val, 0)) > 100) : false} onClick={() => castVote()} className={`py-[10px] w-full ${votingType == 4 ? ((voteCounts.reduce((acc, val) => acc+val, 0)) > 100 ? 'bg-[#cdab93] cursor-not-allowed': 'bg-[#FF7B1B] cursor-pointer'): "cursor-pointer bg-[#FF7B1B]"} rounded-[7px] text-white mt-[3rem]`}>Vote</button>
                )
                :
                null
            }
        </div>
    
    </div>)
    :
    (<p></p>)
}
           

           { hasVoted ? (
            <div className="mt-8 w-full">
            {votingResults.map((result, index) => (
              <div key={index} className="flex justify-between items-center border-b py-2">
                <span className="text-gray-700 font-semibold">{result.option}</span>
                <span className="text-orange-500 font-medium">{result.percentage}</span>
              </div>
            ))}
          </div>
           ) : null}    

            {
                voted &&
                <div class="mt-4 flex flex-col justify-between items-center gap-5 w-[750px] border-b pb-[2rem]">
                    <div class="w-full mb-[6px]">
                        <p class="text-[14px] mb-1">For</p>
                        <div class="w-full border border-[#9F9D99] bg-[#F9FAFB] px-4 pt-6 pb-4 rounded-[6px]">
                            <div class="flex w-full items-center gap-1">              
                                <div class="bg-[#F2F4F7] w-full rounded-md flex justify-between items-center">
                                    <div style={{width:'70%'}} class='cursor-pointer flex items-center justify-between bg-[#FF7B1B] w-full text-white py-[3px] rounded-md text-center'>
                                    </div>
                                </div>
                                <p class="text-[#344054] text-[14px]">70%</p>
                            </div>
                            <div class="text-[#5F6670] text-[13px] mt-2 flex items-center justify-between">
                                <p>85 votes</p>
                                <p>Voting power:</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full mb-[6px]">
                        <p class="text-[14px] mb-1">Against</p>
                        <div class="w-full border border-[#9F9D99] bg-[#F9FAFB] px-4 pt-6 pb-4 rounded-[6px]">
                            <div class="flex w-full items-center gap-1">              
                                <div class="bg-[#F2F4F7] w-full rounded-md flex justify-between items-center">
                                    <div style={{width:'50%'}}  class='cursor-pointer flex items-center justify-between bg-[#FF7B1B] w-full text-white py-[3px] rounded-md text-center'>
                                    </div>
                                </div>
                                <p class="text-[#344054] text-[14px]">50%</p>
                                </div>
                            <div class="text-[#5F6670] text-[13px] mt-2 flex items-center justify-between">
                                <p>85 votes</p>
                                <p>Voting power:</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full mb-[10px]">
                        <p class="text-[14px] mb-1">Abstain</p>
                        <div class="w-full border border-[#9F9D99] bg-[#F9FAFB] px-4 pt-6 pb-4 rounded-[6px]">
                            <div class="flex w-full items-center gap-1">              
                                <div class="bg-[#F2F4F7] w-full rounded-md flex justify-between items-center">
                                    <div style={{width:'30%'}}  class='cursor-pointer flex items-center justify-between bg-[#FF7B1B] w-full text-white py-[3px] rounded-md text-center'>
                                    </div>
                                </div>
                                <p class="text-[#344054] text-[14px]">30%</p>
                            </div>
                            <div class="text-[#5F6670] text-[13px] mt-2 flex items-center justify-between">
                                <p>85 votes</p>
                                <p>Voting power:</p>
                            </div>
                        </div>
                    </div>
                </div>
            }

            <div className='mt-[2rem]'>
                <div className='bg-white border border-[#E7E7E7] text-center px-4 mt-4 rounded-[8px] grid lg:grid-cols-7 md:grid-cols-4 grid-cols-1 text-[14px] gap-5'>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>Proposal ID</p>
                        <p id='prop_id' className='text-gray-400'></p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>Duration</p>
                        <p  id='prop_duration' className='text-gray-400'></p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>Status</p>
                        <p id='prop_status' className='text-gray-400'></p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>Total voters</p>
                        <p id='prop_total_voters' className='text-gray-400'></p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>Total voting power</p>
                        <p id='prop_total_voting_power' className='text-gray-400'></p>
                    </div>
                    <div className='border-r py-[5px]'>
                        <p className='font-[400] mb-2'>Proposer</p>
                        <a href="" id='prop_creator' className='text-blue-400'></a>
                    </div>
                    <div className='py-[5px]'>
                        <p className='font-[400] mb-2'>IPFS</p>
                        <a target='_blank' id='prop_ipfs_link' className='text-blue-400'></a>
                    </div>
                </div>
            </div>

            <div className='mt-[2rem]'>
                <p className="mb-[7px]">Share Link:</p>
                <div className='flex w-full items-center justify-between flex-col lg:flex-row gap-5'>
                    <div className='border border-[#CECECE] py-[2px] pr-[2px] pl-3 rounded-[5px] flex items-center justify-between w-[100%] lg;w-auto'>
                        <p className='text-[13px] mr-[3rem] overflow-hidden'>{currentUrl}</p>
                        <button className='bg-[#FF7B1B] py-2 px-4 rounded-r-[7px] text-[14px] text-white'>Copy Link</button>
                    </div>
                    <div className='flex items-center gap-5 w-full'>
                        <button onClick={() => {shareFunctions()}} className="text-blue-600 hover:opacity-75 border p-1 rounded-full border-blue-600 block">
                            <FaFacebook className='text-[20px]'/>
                        </button>
                        <button onClick={() => {shareFunctions("linkedin")}} className="text-white hover:opacity-75 border p-1 rounded-full border-blue-600">
                            <BiLogoLinkedin className='text-[20px] rounded-full bg-[#0866C2] p-1'/>
                        </button>
                        <button onClick={() => {shareFunctions("whatsapp")}} className="text-white hover:opacity-75 border p-1 rounded-full border-green-600">
                            <MdOutlineWhatsapp className='text-[20px] rounded-full bg-green-500  p-1'/>
                        </button>
                        <button onClick={() => {shareFunctions("twitter")}} className="text-white hover:opacity-75 border p-1 rounded-full border-black">
                            <BsTwitterX className='text-[20px] rounded-full bg-black p-1'/>
                        </button>
                        <button onClick={() => {shareFunctions("reddit")}} className="text-orange-600 hover:opacity-75 border p-1 rounded-full border-orange-600">
                            <BsReddit className='text-[20px]'/>
                        </button>
                    </div>
                </div>
            </div>

            <div className='bg-white mt-[2rem] pb-6 rounded-[8px]'>
                <p className='font-[400] mb-[7px]'>Votes..</p>
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

            <div className='mt-[2rem]'>
                <div className='flex items-center justify-between'>
                    <p>Comments</p>
                    <p  className='text-[#FF7B1B] rounded-[7px] border border-[#FF7B1B] px-[10px] font-[300]np py-[6px] cursor-pointer' onClick={() => setAdComments(true)}>+ Add comment</p>
                </div>
                <div id='prop_comment_view'></div>
               {
                propComments.length > 0 ?
                (
                    <div>
                  {currentComments.map((comment, index) => (
         <div key={index} className='flex justify-between mt-7'>
         <div>
             <div className='flex items-center gap-3'>
                 <img className='w-[35px] h-[35px] rounded-full' src="/images/user.png" alt="" />
                 <p className="text-[18px]">{comment.voter}</p>
             </div>
             <p className='ml-[3rem] text-[#393939]'>{comment.msg}</p>
         </div>
         <p className="text-[#393939]">{comment.date}</p>
     </div>
        ))}
        <div style={{ marginTop: '20px' }}>
        <button
          onClick={handlePrev}
          disabled={currentPage === 1}
          style={{
            backgroundColor: '#FF7B1B',
            color: 'white',
            border: 'none',
            padding: '10px 20px',
            marginRight: '10px',
            cursor: currentPage === 1 ? 'not-allowed' : 'pointer',
          }}
        >
          Prev
        </button>
        <button
          onClick={handleNext}
          disabled={currentPage === totalPages}
          style={{
            backgroundColor: '#FF7B1B',
            color: 'white',
            border: 'none',
            padding: '10px 20px',
            cursor: currentPage === totalPages ? 'not-allowed' : 'pointer',
          }}
        >
          Next
        </button>
      </div>
                </div>                
                )
                :null
               }
              
            </div>
            {
                addComments && 
                <div className='mt-4 bg-white pt-4 pb-6 px-4 rounded-[8px]'>
                    <textarea placeholder='Enter a comment' id='prop_comment_msg' className='resize-none w-full h-[160px] border outline-none p-3 rounded-[7px]'></textarea>
                    <div className='flex justify-end'>
                        <button onClick={() => {sendComment()}} id='prop_send_comment' className='bg-[#FF7B1B] px-2 py-1 mr-2 text-white rounded-[6px]'>Send</button>
                        <button className='border px-2 py-1 mr-2 text-[#FF7B1B] rounded-[6px]' onClick={() => setAdComments(false)}>Cancel</button>
                    </div>
                </div>
            }
            <div id='attached_files' className='bg-white pt-4 pb-6 px-4 mt-4'>
                <p className='font-[500] text-xl mb-1'>Attached files:</p>
                <div id='prop_links' className="flex align-items-start justify-content-center gap-4 ">
                        
                </div>
            </div>
        </div>

        {/* {
            addComments && 
            <div className='mt-4 bg-white shadow pt-4 pb-6 px-4 rounded-[8px]'>
                <textarea id='prop_comment_msg' className='w-full h-[160px] border outline-none p-3'></textarea>
                <div>
                    <button onClick={() => {sendComment()}} id='prop_send_comment' className='bg-[#343257] px-2 py-1 mr-2 text-white rounded-[6px]'>Send</button>
                    <button className='border px-2 py-1 mr-2 text-gray-500 rounded-[6px]' onClick={() => setAdComments(false)}>Cancel</button>
                </div>
            </div>
        } */}

        {/* <div className='bg-white shadow pt-4 pb-6 px-4 mt-4 rounded-[8px]'>
            <p className='font-[500] text-xl mb-4'>Comments</p>
            <div id='prop_comment_view'>
                
            </div>
        </div> */}

        {
            votes === "yes" &&
            <div>
                <div className="h-full w-full fixed top-0 left-0 z-[99]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setVote(false)}></div>
                <div className="bg-white md:w-[400px] w-[80%] flex flex-col items-start fixed top-[50%] left-[50%] pb-[1rem] z-[100] login-modal" style={{ transform: "translate(-50%, -50%)" }}>
                    <div className='flex items-center justify-between pt-3 px-6 w-full'>
                        <p className='text-[20px] font-[500]'></p>
                        <p onClick={() => setVote(false)} className='text-gray-500 text-[28px] cursor-pointer'>&times;</p>
                    </div>
                    <form className='w-full' onSubmit={($event) => {voteWithReasonsYes($event)}}>
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
                            <div className='text-[14px] w-full mt-2'>
                                <p>Mention the Reason here:</p>
                                <input type="text" name='other_reasons' className='border border-blue-300 p-3 rounded-[6px] w-full'/>
                                <p className='text-end text-[#DC3446]'>-Max 50 characters</p>
                            </div>
                        }
                    </div>
                    <div className='flex justify-between w-full p-3'>
                        <p></p>
                        <button type='submit' className='py-[7px] w-full rounded-[4px] bg-[#FF7B1B] px-3 block text-white'>Confirm</button>
                    </div>
                    </form>
                </div>
            </div>
        }
    
        {
            votes === "no" &&
            <div>
                <div className="h-full w-full fixed top-0 left-0 z-[99]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setVote(false)}></div>
                <div className="bg-white md:w-[400px] w-[80%] flex flex-col items-start fixed top-[50%] left-[50%] pb-[1rem] z-[100] login-modal" style={{ transform: "translate(-50%, -50%)" }}>
                    <div className='flex items-center justify-between pt-3 px-6 w-full'>
                        <p className='text-[20px] font-[500]'></p>
                        <p onClick={() => setVote(false)} className='text-gray-500 text-[28px] cursor-pointer'>&times;</p>
                    </div>
                    <form className='w-full' onSubmit={($event) => {voteWithReasonsNo($event)}}>
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
                        {/* <p></p> */}
                        <button type='submit' className='py-[7px] w-full rounded-[4px] bg-[#FF7B1B] px-3 block text-white'>Confirm</button>
                    </div>
                    </form>
                </div>
            </div>
        }
        
    </div>

    
  )
}

export default ProposalInfo