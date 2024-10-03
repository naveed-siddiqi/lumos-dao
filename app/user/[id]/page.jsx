'use client'

import React, { useEffect, useState } from 'react'
import { BsChevronDown, BsChevronRight, BsGithub, BsTwitterX } from 'react-icons/bs';
import { IoMdCopy, IoMdMenu } from "react-icons/io";
import Alert from '../../components/alert/Alert';
import { API_URL, stellarExpert } from '@/app/data/constant';
import { addDelegate, fArr, paginate } from '@/app/core/core';
import { fAddr, getAllProposal, getAllUsersTx, getCommentNum, getDao, getDaoDelegatee, getDaoJoinedDate, getDaoJoinedWithInfo, getDaoMetadata, getProposal, getProposalVoterInfo, getUserComment, getUserInfo, getUserMeta } from '@/app/core/getter';
import DaoCard from '@/app/components/dao-card/DaoCard';
import { stopTalking, talk } from '@/app/components/alert/swal';
import { BiCopy } from 'react-icons/bi';

let uWallet = ""// Use your actual URL or replace with the desired URL
let actions = ""
let txInfo = []
var userInfo = null; var user_delegates = []
let hasLoad = false;

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
        uWallet = (window.location.href.substring(window.location.href.lastIndexOf("/") + 1)) || walletAddress; // Use your actual URL or replace with the desired URL
        uWallet = (uWallet.indexOf('?') > -1) ? uWallet.substring(0, uWallet.indexOf('?')) : uWallet;
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
        //E('user_inbox').onclick = () => {window.location.assign("/inbox?to=" + uWallet)}
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
            E('user_name').innerHTML  = E('user_name_drop').innerHTML = userInfo['name'] || ""
            E('user_bio').innerHTML = E('user_bio_drop').innerHTML = userInfo['bio'] || ""
            E('user_img').src = E('user_img_drop').src =  (userInfo['image'] !== "" ? userInfo['image'] : ("https://id.lobstr.co/" + uWallet + ".png")) + "?id=" + Math.random() * 100
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
            E('wallet_joined_date').innerHTML = "Member since " + joined //E('wallet_joined_date_res').innerHTML = 
        }
        
        //get user comments
        const comt = await getUserComment(uWallet)
        const [num, daos] = await getDaoJoinedWithInfo(uWallet)
        E('wallet_dao_num').innerHTML = E('wallet_dao_num_drop').innerHTML =  num.toLocaleString()
        const cnum = await getCommentNum(uWallet)
        E('wallet_comment_num').innerHTML = E('wallet_comment_num_drop').innerHTML= cnum.toLocaleString()  //E('wallet_comment_num_res').innerHTML = E('wallet_comment_num_res_short').innerHTML =  '(' + cnum.toLocaleString() + ')'
         
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
        const actual_daos = await getDaoMetadata()
        if(actual_daos !== false){
            let tdaos = fArr(daos.map((e) => {
                if(actual_daos['daos'].includes(e.token)){
                    return e.token
                }
            }))
            let _daos = await getDao(tdaos); let daoView = []
            for (let i = 0; i < tdaos.length; i++) {
                if (_daos[tdaos[i]]["proposals"] != undefined) {
                    //append
                    const dao = _daos[tdaos[i]];
                    const props = await getAllProposal(dao.proposals, dao.token);
                    dao.active_proposals = 0;
                    for (let i = 0; i < dao.proposals.length; i++) {
                    if (
                        props[dao.proposals[i]].status != 0 &&
                        props[dao.proposals[i]].status != 2
                    ) {
                        dao.active_proposals++;
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
                            code:dao.code
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
        else {
            setNetwork(true)
            setLoading(false)
        }
    
    }
    //load user activity
    const loadActivity = async () => {
        //get all the tx
        txInfo = await getAllUsersTx(walletAddress) 
        paginate('tx_info', txInfo, 10, drawExp)
    }
    //load user delegatess
    const loadUserDelegates = async (daos) => { 
        for(let i=0;i<daos.length;i++) {
            //fetch the delegatee info
            const delegate = await getDaoDelegatee(daos[i].token, uWallet)
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
        if(tx.data.length == 56){
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
            hash:tx.hash || ""
        }
        const elem = `<div class='flex items-start justify-between bg-[#EFF2F6] p-3 rounded-[6px] my-3 flex-col md:items-center md:flex-row gap-3'>
                        <div class='flex items-center gap-2 text-blue-600 font-[600]'>
                            <a href='${params.userLink}'>${fAddr(params.address,6)}</a>
                            <a href="${params.link}">${params.action}</a>
                        </div>
                        <div class='flex items-center gap-2'>
                            <p>${params.date}</p> 
                            <a style='display:${(params.hash != "") ? "" : 'none'}' target='_blank' href="${stellarExpert}/tx/${params.hash}" class='text-blue-600 underline'>View on Explorer</a>
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
        // let th = `<div class="text-left comment form-control border-0 h-auto px-0 sm:px-4 py-2 w-full bg-[#EFF2F6]" style='display:${(hide == true) ? 'none' : ""}'>
        //             <p style="color:#6c757d !important; mb-2 class="Explorer_p my-auto">
        //                 <a class="Explorer_p_a" href=""><span class="block">${params.proposalName || ""}</span></a>
        //                 ${params.msg || ""}
        //             </p>
        //             <div class="rounded-[12px] form-control border-0 h-auto px-0 sm:px-4 py-2 flex flex-col md:flex-row items-center justify-between w-full bg-white">
        //                 <div class="flex gap-3 items-center">
        //                     <img class="w-[40px] h-[40px] rounded-full" src="${API_URL + 'user_img&user=' + uWallet}" alt="Profile Image">
        //                     <p class="Explorer_p my-auto text-[#0075FB]">${fAddr(uWallet, 7)} voted 
        //                         <span class="Explorer_p_a text-black">${params.voted || "none"}</span> on proposal 
        //                         <a class="Explorer_p_a" href=""><span>${params.proposalName || ""}</span></a> 
        //                     </p>
        //                 </div>
        //                 <p class="Explorer_span block">${params.date || ""}</p>
        //             </div>
        //         </div>

        //         `
        // return th
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
    <div className='px-[3rem] my-[80px]'>
        <div className='flex items-center gap-3 mb-5'>
            <p className='font-[600] text-[20px] text-gray-500'>User</p>
            <BsChevronRight />
            <p id='wallet_name' className='font-[500]'></p>
        </div>
        <IoMdMenu onClick={() => setMobileNav(true)} className='text-[26px] cursor-pointer mb-1 block lg:hidden' />
        <div className='flex items-start lg:gap-[2rem] h-full'>
            <div className={mobileNav ? `h-full w-full fixed top-0 left-0 z-[99]`:""} style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setMobileNav(false)}></div>
            <div className={mobileNav ? `fixed z-[100] left-0 top-0 flex justify-start py-8 flex-col border h-[100dvh] w-[350px] bg-white` : `relative lg:flex justify-start py-8 flex-col border rounded-[8px] h-[100dvh] w-[25%] bg-white hidden`}>
                <div className='flex items-center justify-center gap-2 flex-col'>
                    <img id='user_img' className='rounded-full w-[100px] h-[100px] object-cover border' alt="" />
                    <p id='user_name'></p>
                    <div className='flex items-center gap-[3rem] mt-4'>
                        <div className='flex items-center gap-2'>
                            <p id='wallet_name_short'></p>
                            <BsChevronDown cursor="pointer" onMouseEnter={() => setUserDropdown(true)}/>
                        </div>
                        <IoMdCopy onClick={() => {
                            navigator.clipboard.writeText(uWallet)
                            setMsg('Address copied successfully!')
                            setAlertType('success')
                        }} className='cursor-pointer text-[20px]' />
                    </div>
                    <p id='user_bio' className='text-sm'></p>
                </div>
                <div className='flex items-center justify-center mt-5 gap-3'>
                    <div className='bg-black p-[6px] rounded-full text-white cursor-pointer' style={{display:'none'}} id='user_github_nav'>
                        <BsGithub />
                    </div>
                    <div className='bg-black p-[6px] rounded-full text-white cursor-pointer' style={{display:'none'}} id='user_twitter_nav'>
                        <BsTwitterX />
                    </div>
                </div>
                <div className='mt-[5rem] mx-3 font-[500] text-left flex flex-col gap-1'>
                    <button onClick={() => setSelectedTab('activity')} className={selectedTab === 'activity' ? `bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left pl-5` : `text-black w-full py-3 rounded-[8px] text-left pl-5`}>Activity</button>
                    <div onClick={() => setSelectedTab('joined')} className={selectedTab === 'joined' ? `cursor-pointer flex items-center justify-between bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-between text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <button className=''>Joined</button>
                        <p>(<span id='wallet_dao_num'></span>)</p>
                    </div>
                    <div onClick={() => setSelectedTab('comments')} className={selectedTab === 'comments' ? `cursor-pointer flex items-center justify-between bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-between text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <button className=''>Comments</button>
                        <p>(<span id='wallet_comment_num'></span>)</p>
                    </div>
                    <div onClick={() => setSelectedTab('delegate')} className={selectedTab === 'delegate' ? `cursor-pointer flex items-center justify-between bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-between text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <button className=''>Delegates</button>
                        <p>(<span id='wallet_delegate_num'></span>)</p>
                    </div>
                </div>
                <p id='wallet_joined_date' className='mt-20 text-center text-gray-500'></p>

                {
                    

                        <div className="absolute flex items-center justify-center top-[230px] left-0 right-[-60px] rounded-[20px]"
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
            <div id='tx_info' style={(selectedTab === 'activity')? {display:'block'} : {display:'none'}}
            className='border lg:w-[75%] w-full py-[3rem] rounded-[8px] text-center bg-[#FFFFFF]'>
                <center style={{margin:'auto',marginTop:'20px'}}>Loading records..</center>
            </div>
            <div id='wallet_my_dao' style={(selectedTab === 'joined')? {display:'grid'} : {display:'none'}}
            className='border lg:w-[75%] w-full py-[3rem] rounded-[8px] text-center lg:grid-cols-2 grid-cols-1 gap-3 bg-[#FFFFFF]'>
                {(loading) ? <>
                    <center className='text-center'>Fetching dao..</center>
                </>
                : (network)?
                    <>
                    <div style={{fontSize:'20px', margin:'60px 0px'}}>
                        <center>Network error</center>
                    </div>
                    </>
                 : (empty) ? 
                    <div style={{fontSize:'20px', margin:'60px 0px'}}>
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
            <div id='wallet_my_comment' style={(selectedTab === 'comments')? {display:'block'} : {display:'none'}}
            className='border lg:w-[75%] w-full py-[2rem] px-8 rounded-[8px] text-center bg-[#FFFFFF]'>
                Fetching comments..
            </div>
            <div id='user_delegates_view' style={(selectedTab === 'delegate')? {display:'block'} : {display:'none'}}
            className='border lg:w-[75%] w-full py-[3rem] rounded-[8px] text-center bg-[#FFFFFF]'>
                Fetching delegates
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