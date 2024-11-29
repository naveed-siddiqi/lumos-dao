'use client'

import React, { useEffect, useState } from 'react'
import { BsChevronDown, BsChevronRight, BsGithub, BsTwitterX } from 'react-icons/bs';
import { IoMdCopy, IoMdMenu } from "react-icons/io";
import Alert from '../components/alert/Alert';
import { API_URL, stellarExpert, xrpExplorer } from '@/app/data/constant';
import { addDelegate, fArr, paginate } from '@/app/core/core';
import {isChain, fAddr, getAllProposal, getAllUsersTx, getCommentNum, getDaoDelegatee, getDaoInfo, getDaoJoinedDate, getDaoJoinedWithInfo, getDaoMetadata, getProposal, getProposalVoterInfo, getUserComment, getUserInfo, getUserMeta } from '@/app/core/getter';
import DaoCard from '@/app/components/dao-card/DaoCard';
import { stopTalking, talk } from '@/app/components/alert/swal'; 
import { PiWifiXLight } from 'react-icons/pi';
import DaoCardLoader from '../components/dao-card-loader/DaoCardLoader';
import AlertLoader from '../components/alert-loader/AlertLoader';
import CommentLoader from '../components/comments-loader/CommentLoader';
import DelegateLoader from '../components/delegate-loader/DelegateLoader';

let uWallet = ""// Use your actual URL or replace with the desired URL
let actions = ""
let txInfo = []
var userInfo = null; var user_delegates = []
let hasLoad = false;
let msgLinkAddress = ''

const UserProfile = () => {

    const [mobileNav, setMobileNav] = useState(false)
    const [selectedTab, setSelectedTab] = useState();
    const [msg, setMsg] = useState("")
    const [alertType, setAlertType] = useState("")
    const [daoArr, setDaoArr] = useState([])
    const [loading, setLoading] = useState(true)
    const [empty, setEmpty] = useState(false)
    const [network, setNetwork] = useState(false)
    const [userDropdown, setUserDropdown] = useState(false)
    
    
    useEffect(() => {
        window.E = (id) => document.getElementById(id)     
        window.walletAddress = localStorage.getItem('selectedWallet') || ""
        msgLinkAddress = walletAddress
        uWallet = walletAddress
        actions = (new URLSearchParams(new URL(window.location.href).search).get('a')) || null
        //to reclaim delegation
        window.reclaimDelegate = async (del_address, dao, index) => {
            const id = talk("Reclaiming voting power from " + fAddr(del_address, 6))
            const res = await addDelegate({
                delegatee: uWallet,
                del_address:del_address,
                dao: dao
            })
            if (res !== false) {
                stopTalking(3, talk("Reclaimed voting power from " + fAddr(del_address, 6), 'good', id))
                user_delegates[index] = null
                //shuffle array
                user_delegates = fArr(user_delegates);
                //reload results
                paginate('user_delegates_view', user_delegates, 20, drawDelegates)
                E('wallet_delegate_num').innerHTML = `${user_delegates.length}`
            } else {
                stopTalking(3, talk("Unable to reclaim voting power from " + fAddr(del_address, 6) + '<br>Something went wrong', 'fail', id))
            }
        }
        setSelectedTab(actions || 'activity') // Set default tab to 'activity' when component mounts up
        if(!hasLoad){
            hasLoad = true
            setUp()
        }
    },[])

    const setUp = async () => { 
        //set name
        E('wallet_name').innerHTML = uWallet
        E('wallet_name_short').innerHTML = E('wallet_name_drop').innerHTML =  fAddr(uWallet, 6)
         //load activity
        setTimeout(() => {
            loadActivity()
        }, 5)
        userInfo = await getUserInfo(uWallet); 
        const userMeta = await getUserMeta(uWallet)
        //setting up user meta info
        E('wallet_proposal_num_drop').innerHTML =   userMeta['proposals'].toLocaleString() 
        E('wallet_votes_num_drop').innerHTML =  userMeta['votes'].toLocaleString() 
        
        //set the user info
        if(userInfo.status) {
            //set the name
            userInfo = userInfo['user']
            E('user_name').innerHTML  = E('user_name_drop').innerHTML = userInfo['name'] || "User"
            E('user_bio').innerHTML = E('user_bio_drop').innerHTML = userInfo['bio'] || ""
            E('user_img').src = E('user_img_drop').src =  (userInfo['image'] !== "" ? userInfo['image'] : ("https://id.lobstr.co/" + uWallet + ".png")) + "?id=" + Math.random() * 100
            E('user_bg').backgroundImage = `url(${userInfo?.cover || ""})`
            //fix the socials
            if(userInfo['twitter'] != "") {
                E('user_twitter_drop').style.display = E('user_twitter_nav').style.display = 'flex'
                E('user_twitter_drop').onclick = E('user_twitter_nav').onclick = () => {window.open(userInfo['twitter_url'], 'blank')}
            }
             if(userInfo['github'] != "") {
                E('user_github_drop').style.display = E('user_github_nav').style.display = 'flex'
                E('user_github_drop').onclick = E('user_github_nav').onclick = () => {window.open(userInfo['github_url'], 'blank')}
            }
        }
        else {
            E('user_img').src = E('user_img_drop').src =   "https://id.lobstr.co/" + uWallet + ".png?id=" + Math.random() * 100
        }
        
        let joined = await getDaoJoinedDate(uWallet);
        if (joined != "") {
            joined = (new Date(joined)).toLocaleString()
            E('wallet_joined_date').innerHTML = "Member since " + joined  
        }
        
        //get user comments
        const comt = await getUserComment(uWallet)
        const [num, daos] = await getDaoJoinedWithInfo(uWallet)
        E('wallet_dao_num').innerHTML = E('wallet_dao_num_drop').innerHTML =  num.toLocaleString()
        E('wallet_dao_num_joined').innerHTML = E('wallet_dao_num_drop').innerHTML =  num.toLocaleString()
        const cnum = await getCommentNum(uWallet)
        E('wallet_comment_num').innerHTML = E('wallet_comment_num_drop').innerHTML= cnum.toLocaleString()  
        E('wallet_comment_num_cmt').innerHTML = E('wallet_comment_num_drop').innerHTML= cnum.toLocaleString()  
        //load comment
        setTimeout(() => {
            loadComments(comt)
        }, 10)
        //load daos
        setTimeout(() => {
            loadDao(daos)
            loadUserDelegates(daos)
        }, 50)
        
    }
    //load comment
    const loadComments = async (comt) => {
        if (comt.length > 0) {
            let props = []; let comments = []
            for (let i = 0; i < comt.length; i++) {
                const res = JSON.parse(comt[i])
                if (!props[res.proposal_id]) {
                    //hasnt loaded proposal data, load it
                    props[res.proposal_id] = await getProposal(res.proposal_id)
                    if (props[res.proposal_id] !== false) {
                        res['proposalName'] = props[res.proposal_id].name
                        res['voted'] = await getProposalVoterInfo(res.proposal_id * 1, uWallet)
                        res['voted'] = (res['voted'] == 0) ? "none" : (res['voted'] == 1) ? 'Yes' : 'No';
                    }
                } else {
                    if (props[res.proposal_id] !== false) {
                        res['proposalName'] = props[res.proposal_id].name
                        res['voted'] = await getProposalVoterInfo(res.proposal_id, uWallet)
                        res['voted'] = (res['voted'] == 0) ? "none" : (res['voted'] == 1) ? 'Yes' : 'No';
                    }
                }
                comments.push(res)
            }
            //run pagination
            paginate('wallet_my_comment', comments, 20, drawComment)
        } else {
            E('wallet_my_comment').innerHTML = 'You have not made any comments'
        }
    } 
    //load daos
    const loadDao = async (daos) => {  
        //load all the daos
        let tdaos = fArr(daos.map((e) => {
            return e.token
        }))
        let _daos = await getDaoInfo(tdaos, isChain(uWallet)); let daoView = []
        for (let i = 0; i < tdaos.length; i++) {
                if (_daos[tdaos[i]]["proposals"] != undefined) {
                    //append
                    const dao = _daos[tdaos[i]];
                    const props = await getAllProposal(dao.proposals, dao.token, dao.chain);
                    dao.active_proposals = 0;
                    for (let i = 0; i < dao.proposals.length; i++) {
                        if (props[dao.proposals[i]] != undefined && props[dao.proposals[i]] != "") {
                            if (
                                props[dao.proposals[i]].status != 0 &&
                                props[dao.proposals[i]].status != 2
                            ) {
                                dao.active_proposals++;
                            }
                        }
                    }
                    if (dao.joined === false || walletAddress == "") {
                    dao.ismember = false;
                    } else {
                    dao.ismember = true;
                    }
                    daoView.push(
                        {
                            id:dao.token,
                            banner:dao.cover,
                            logo:dao.image,
                            title:dao.name,
                            description:dao.description,
                            activeProposals:dao.active_proposals,
                            members:dao.members,
                            proposals:dao.proposals.length,
                            created:dao.created,
                            owner:dao.owner,
                            joined:dao.ismember,
                            issuer:dao.issuer,
                            code:dao.code,
                            chain:dao.chain
                        }
                    )
                }
            }
            setLoading(false)
            if (daos.length == 0) {
                setEmpty(true)
            } else {
                setDaoArr(daoView)
            }
    
    }
    //load user activity
    const loadActivity = async () => {
        //get all the tx
        txInfo = await getAllUsersTx(uWallet) 
        paginate('tx_info', txInfo, 10, drawExp)
    }
    //load user delegatess
    const loadUserDelegates = async (daos) => { 
        for(let i=0;i<daos.length;i++) {
            //fetch the delegatee info
            const delegate = await getDaoDelegatee(daos[i].token, uWallet,daos[i].chain)
            if(delegate.length > 0) {
                //append to prexisting delegates
                user_delegates.push({...daos[i], ...{delegate:delegate[0]} })
                //do the paginate text
                paginate('user_delegates_view', user_delegates, 20, drawDelegates)
            }
        }
        paginate('user_delegates_view', user_delegates, 20, drawDelegates)
        E('wallet_delegate_num').innerHTML = `${user_delegates.length}`
    }
    
    /* Draws */
    const drawExp = (txInfo) => {
        const tx = JSON.parse(txInfo);let link="";
        
        if(tx.data.length >= 56){
            link= `/dao/` + tx.data
        }
        else if(tx.data.toLowerCase().indexOf('proposal') > -1){
            link= `/dao/` + JSON.parse(tx.data || "{}").dao + "/proposal/" + JSON.parse(tx.data).proposal
        }
        else{
            link=tx.hash
        } 
        const params = {
            address:tx.signer,
            action:tx.action,
            date:(new Date(tx.date)).toLocaleString(),
            link:link,
            userLink:'/user/'+tx.signer,
            type:tx.type,
            hash:tx.hash || ""
        }
        const elem = `<div class='text-[12px] flex items-start justify-between border-[#EFEFEF] border-b p-3 rounded-[6px] my-3 flex-col md:items-center md:flex-row gap-3'>
                        <div class='flex items-center gap-2'>
                            <p class="text-[#027A48] bg-[#ECFDF3] py-[5px] px-[12px] rounded-full">${params.type}</p>
                            <a href='${params.userLink}'>${fAddr(params.address,6)}</a>
                            <a href="${params.link}">${params.action}</a>
                            <a style='display:${(params.hash != "") ? "" : 'none'}' target='_blank' href="${(isChain(tx.signer))=='stellar'?`${stellarExpert}/tx/`:`${xrpExplorer}/transactions/`}${params.hash}" class='text-blue-600 underline'>View on Explorer</a>
                        </div>
                        <div class='flex items-center gap-2'>
                            <p>${params.date}</p> 
                        </div>
                    </div>`
        return elem
    }
    const drawComment = (params, hide = false) => {
        const tm = `<div class='border-b pb-3'>
                    <div class='flex items-center justify-between mb-2'>
                        <div class='flex items-center gap-2'>
                            <img  src='${API_URL + "user_img&user=" + uWallet}' class='w-[40px] h-[40px] rounded-full' alt="" />
                            <p>${fAddr(uWallet, 5)}</p>
                        </div>
                        <p>${params.date}</p>
                    </div>
                    <p style='text-align:left'>${params.msg}</p>
        </div>`
        return tm
    }
    const drawDelegates = (params, index) => {
        return `    <div class="flex flex-col sm:flex-row justify-between sm:items-end gap-4 p-4">
                        <div class="flex flex-col gap-2">
                            <span class="text-sm text-secondary text-left">Delegates</span>
                            <div class="flex items-center gap-2">
                                <img src="${API_URL + 'user_img&user=' + params.delegate}" alt="Profile Image" class="w-[50px] rounded-full">
                                <div class="text-center">${fAddr(params.delegate, 7)}</div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-sm text-secondary text-left">DAO</span>
                            <div class="flex items-center gap-2">
                                <img src="${params.image}" alt="Profile Image" class="w-[50px] rounded-full">
                                <div class="text-center">${params.name}</div>
                            </div>
                        </div>
                        <div class="${!(walletAddress == uWallet) ? 'hidden' : ''}">
                            <button type="button" onclick='reclaimDelegate("${params.delegate}", "${params.token}", ${index})'
                                class="btn bg-red-600 text-white flex items-center gap-2 mb-0">
                                Reclaim Delegation
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                                    `
    }
    
   

  return (
    <div className='mb-[80px] helvetica-font'>
        {/* <div className='flex items-center gap-3 mb-5'>
            <p className='font-[600] text-[20px] text-gray-500'>User</p>
            <BsChevronRight />
            <p id='wallet_name' className='font-[500]'></p>
        </div> */}
        <div className="bg-cover h-[370px] rounded-none relative" id='user_bg' style={{transition:'backgroundImage 200ms'}}>
            <div className='text-white text-[12px] md:mx-[6.5rem] mx-[1rem] px-[1.5rem] mt-[2.3rem] mb-5 inline-flex py-2 items-center gap-1 bg-[#84848459] relative z-10 rounded-full'>
                <a href="/dao">Home </a>
                <BsChevronRight />
                <p id='wallet_name' className=''></p>
                {/* <p>Lumuos Domain Test</p> */}
            </div>
        </div>
        <div>
            <div className="flex items-start flex-col gap-3 md:ml-[6.5rem] mx-[1rem]">
                <div className='p-[4px] bg-[white] w-[85px] h-[85px] mt-[-40px] rounded-full relative z-[100]'>
                    <img className="w-full h-full rounded-full object-cover" id='user_img' alt="User profile Image" /> {/* Replace with the path to your logo */}
                </div>
            </div>
        </div>
        <IoMdMenu onClick={() => setMobileNav(true)} className='text-[26px] cursor-pointer mb-1 block lg:hidden' />
        <div className='flex items-start lg:gap-[1rem] h-full sm:px-[2rem] px-[0.5rem] py-[1.8rem]'>
            <div className={mobileNav ? `h-full w-full fixed top-0 left-0 z-[99]`:""} style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setMobileNav(false)}></div>
            <div className={mobileNav ? `fixed z-[100] left-0 top-0 flex justify-start py-8 flex-col border h-[100dvh] w-[350px] bg-white overflow-y-scroll` : `relative lg:flex justify-start py-8 flex-col h-full w-[30%] bg-white hidden`}>
                <div className='flex items-start justify-center gap-2 flex-col px-[15px] border-b border-[#E3E3E3] mx-3 pb-[2.5rem] pt-[1rem]'>
                    {/* <img id='user_img' className='rounded-full w-[100px] h-[100px] object-cover border' alt="" /> */}
                    <p  className='text-[22px] text-left' id='user_name'></p>
                    <div className='flex items-center gap-[3rem] mt-2'>
                        <div className='flex items-center justify-between bg-[#F6F6F8] w-[180px] rounded-[7px] py-1 px-2'>
                            <p id='wallet_name_short' className='text-[15px]'></p>
                            <BsChevronDown cursor="pointer" onMouseEnter={() => setUserDropdown(true)}/>
                        </div>
                        {/* <IoMdCopy onClick={() => {
                            navigator.clipboard.writeText(uWallet)
                            setMsg('Address copied successfully!')
                            setAlertType('success')
                        }} className='cursor-pointer text-[20px]' /> */}
                    </div>
                    {/* <p id='user_bio' className='text-sm'></p> */}
                </div>
                <div className='text-[#676565] mt-[2.5rem] mx-7 flex flex-col gap-2 text-[14px]'>
                    <div className='flex items-center gap-3'>
                        <img src="/images/calendar.svg" alt="" />
                        <p id='wallet_joined_date'></p>
                    </div>
                </div>
                <div className='mt-[6rem] mx-[24px]'>
                    <p className='text-[#B9B8B8] mb-[6px] text-[14px]'>ABOUT ME</p>
                    <p className='text-[13px]' id='user_bio'></p>
                </div>
                <div className='flex items-center justify-center mt-5 gap-3'>
                    <div className='bg-black p-[6px] rounded-full text-white cursor-pointer' style={{display:'none'}} id='user_github_nav'>
                        <BsGithub />
                    </div>
                    <div className='bg-black p-[6px] rounded-full text-white cursor-pointer' style={{display:'none'}} id='user_twitter_nav'>
                        <BsTwitterX />
                    </div>
                </div>
                <div className='mt-[5rem] mx-3 font-[400] text-left flex flex-col gap-1'>
                    {/* <button onClick={() => setSelectedTab('activity')} className={selectedTab === 'activity' ? `bg-[#FF7B1B] text-white w-full py-3 rounded-[8px] text-left pl-5` : `text-black w-full py-3 rounded-[8px] text-left pl-5`}>Activity</button> */}
                    <div className='cursor-pointer flex items-center justify-between text-black w-full py-[7px] rounded-[8px] text-left px-5'>
                        <p className=''>Total number of DAOs joined</p>
                        <p><span id='wallet_dao_num'></span></p>
                    </div>
                    <div className='cursor-pointer flex items-center justify-between text-black w-full py-[7px] rounded-[8px] text-left px-5'>
                        <p className=''>Total Number of Proposals</p>
                        <p><span></span></p>
                    </div>
                    <div className='cursor-pointer flex items-center justify-between text-black w-full py-[7px] rounded-[8px] text-left px-5'>
                        <p className=''>Total Number of Comments</p>
                        <p><span id='wallet_comment_num'></span></p>
                    </div>
                    <div className='cursor-pointer flex items-center justify-between text-black w-full py-[7px] rounded-[8px] text-left px-5'>
                        <p className=''>Total Number of Votes</p>
                        <p><span></span></p>
                    </div>
                    <a href={`/inbox?to=${msgLinkAddress}`} className='bg-[#FF7B1B] py-[10px] w-[90%] text-center block mx-auto rounded-[4px] text-white mt-[4rem]'>Message</a>
                    {/* <div onClick={() => setSelectedTab('delegate')} className={selectedTab === 'delegate' ? `cursor-pointer flex items-center justify-between bg-[#FF7B1B] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-between text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <button className=''>Delegates</button>
                        <p>(<span id='wallet_delegate_num'></span>)</p>
                    </div> */}
                </div>
                <p id='wallet_joined_date' className='mt-20 text-center text-gray-500'></p>

                {
                    <div className="absolute flex items-center justify-center top-[150px] w-full left-0 rounded-[20px]"
                        onMouseLeave={() => setUserDropdown(false)}
                        style={(userDropdown) ? {} : {display:'none'}}
                        >
                        <div className="bg-white rounded-lg shadow-lg p-4 max-w-xs w-full relative">
                            <div className="flex flex-col items-start">
                                <img id='user_img_drop' className='rounded-full w-[60px]' alt="" />
                                <h2 id='user_name_drop' className="text-lg"></h2>
                                <div className="text-gray-500 flex items-center mt-1 justify-between w-full">
                                    <span id='wallet_name_drop' className='block'></span>
                                    <IoMdCopy onClick={() => {
                                        navigator.clipboard.writeText(uWallet)
                                        setMsg('Address copied successfully!')
                                        setAlertType('success')
                                    }} className='cursor-pointer text-[20px]' />
                                </div>
                                <p id='user_bio_drop' className="text-sm text-gray-500 mt-2"></p>
                                <div className='flex items-center'>
                                    <BsTwitterX id='user_twitter_drop' style={{display:'none'}}/>
                                    <BsGithub id='user_github_drop' style={{display:'none'}} />
                                </div>
                            </div>
                            <div className="mt-4 flex justify-around text-sm">
                                <div className="text-center">
                                    <div>DAOs</div>
                                    <div>(<span id='wallet_dao_num_drop'></span>)</div>
                                </div>
                                <div className="text-center">
                                    <div>Proposals</div>
                                    <div>(<span id='wallet_proposal_num_drop'></span>)</div>
                                </div>
                                <div className="text-center">
                                    <div>Votes</div>
                                    <div>(<span id='wallet_votes_num_drop'></span>)</div>
                                </div>
                                <div className="text-center">
                                    <div>comments</div>
                                    <div>(<span id='wallet_comment_num_drop'></span>)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                }
            </div>

            {/* <UserProfileLoader mobileNav={mobileNav}/> */}
          
            <div className='lg:w-[70%] w-full py-[3rem] px-[1.5rem] bg-[#FFFFFF] text-[12px]'>
                <div className='flex items-center text-center'>
                    <p onClick={() => setSelectedTab('joined')} className={selectedTab === 'joined' ? 'text-[#000] text-[12px] px-[1rem] pb-2 cursor-pointer border-b border-[#FF7B1B]':'text-[#98A2B3] text-[12px] px-[1rem] pb-2 cursor-pointer border-b border-[#F0F2F5]'}>Joined(<span id='wallet_dao_num_joined'></span>)</p>
                    <p onClick={() => setSelectedTab('comments')} className={selectedTab === 'comments' ? 'text-[#000] text-[12px] px-[1rem] pb-2 cursor-pointer border-b border-[#FF7B1B]':'text-[#98A2B3] text-[12px] px-[1rem] pb-2 cursor-pointer border-b border-[#F0F2F5]'}>Comments(<span id='wallet_comment_num_cmt'></span>)</p>
                    <p onClick={() => setSelectedTab('delegate')} className={selectedTab === 'delegate' ? 'text-[#000] text-[12px] px-[1rem] pb-2 cursor-pointer border-b border-[#FF7B1B]':'text-[#98A2B3] text-[12px] px-[1rem] pb-2 cursor-pointer border-b border-[#F0F2F5]'}>Delegates(<span id='wallet_delegate_num'></span>)</p>
                    <p onClick={() => setSelectedTab('activity')} className={selectedTab === 'activity' ? 'text-[#000] text-[12px] px-[1rem] pb-2 cursor-pointer border-b border-[#FF7B1B]':'text-[#98A2B3] text-[12px] px-[1rem] pb-2 cursor-pointer border-b border-[#F0F2F5]'}>Activity</p>
                </div>

                <div id='wallet_my_dao' style={(selectedTab === 'joined')? {display:'grid'} : {display:'none'}}
                    className='lg:w-[70%] w-full px-[1rem] py-[3rem] md:grid-cols-2 grid-cols-1 gap-3 bg-[#FFFFFF]'>
                    {(loading) ? <>
                        <>
                            <center className='text-center'>
                                <DaoCardLoader />
                            </center>
                        </>
                    </>
                    : (network)?
                        <>
                            <div className='my-[10px] mx-auto w-full'>
                                <center className='flex flex-col items-center justify-center'>
                                    <PiWifiXLight className='text-[60px] mb-2 text-[#FF7B1B]'/>
                                    <p>Network Error</p>
                                </center>
                            </div>
                        </>
                    : (empty) ? 
                        <div style={{fontSize:'13px', margin:'60px 0px'}}>
                            <center>You have not joined any dao</center>
                        </div>
                        :
                        daoArr.map((dao, index) => {
                            return(
                                <DaoCard key={index} dao={dao} />
                            )
                        })
                    }
                </div>

                <div id='tx_info' style={(selectedTab === 'activity')? {display:'block'} : {display:'none'}}
                    className='w-full py-[3rem] text-[12px] text-center bg-[#FFFFFF]'>
                        {
                            [1,1,1].map(() => {
                                return(
                                    <AlertLoader />
                                )
                            })
                        }
                </div>

                <div id='wallet_my_comment' style={(selectedTab === 'comments')? {display:'block'} : {display:'none'}}
                    className='w-full py-[3rem] px-[1.5rem] bg-[#FFFFFF]'>
                        {
                            [1,1,1].map(() => {
                                return(
                                    <CommentLoader />
                                )
                            })
                        }
                </div>

                <div id='user_delegates_view' style={(selectedTab === 'delegate')? {display:'block'} : {display:'none'}}
                    className='w-full py-[3rem] px-[1.5rem] bg-[#FFFFFF]'>
                        {
                            [1,1,1].map(() => {
                                return(
                                    <DelegateLoader />
                                )
                            })
                        }
                </div>

            </div>
        </div>
        {
            msg && (
            <Alert msg={msg} alertType={alertType} setMsg={setMsg} />
            )
        }
    </div>
  )
}

export default UserProfile