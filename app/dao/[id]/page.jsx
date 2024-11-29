"use client"

import Link from 'next/link'
import React, { useEffect, useMemo, useState } from 'react'
import { BsChevronBarRight, BsLinkedin, BsChevronRight, BsDiscord, BsInstagram, BsReddit, BsTelegram, BsTwitterX, BsWhatsapp } from 'react-icons/bs'
import { AiOutlinePlusCircle } from "react-icons/ai";
import { IoMdCheckmark } from "react-icons/io";
import { MdFingerprint } from "react-icons/md";
import { IoFingerPrintOutline } from "react-icons/io5";
import { useParams } from 'next/navigation';
import { PiDotsThree, PiPencil } from 'react-icons/pi';
import { BiCopy, BiDotsVerticalRounded } from "react-icons/bi";
import Image from 'next/image';
import { FaFacebook } from 'react-icons/fa';
import { fAddr, fNum, getAlldaoInfo, getAllDelegates, getAllProposal, getDaoDelegatee, getDaoUsersP, getDaoWithoutMeta, getLocked, getMarketCap, getRedditOauthUri, getTokenUserBal, getUsersDao, isBanned, readAssetToml } from '@/app/core/getter';
import { drawAdminUser, drawDelegateinfo, drawDelegateModal, drawDelegateSearchResult, drawMember, drawOtherAddress, drawProposal, drawProposalReview, drawTopVoters, drawUser } from '@/app/core/draw';
import { addAdmin, leaveDao, addDelegate, banDaoMember, claimJoiningBonus, copyLink, createTrustline, executeProposal, fArr, getDaoFirst, isSafeToml, lockIssuer, N, optimizeImg, paginate, reclaimJoiningBonus, removeDaoAdmin, setJoiningBonus, setProposalSetting, unbanDaoMember, validateImageUpload, validateImageUploadSilently } from '@/app/core/core';
import { stopTalking, talk } from '@/app/components/alert/swal';
import { API_URL, firebaseConfig, networkWalletUsed, stellarExpert, xrpExplorer } from '@/app/data/constant'; 
/* SOCIALS */
import { TwitterAuthProvider, getAuth, signInWithPopup } from "firebase/auth";
import { initializeApp } from "firebase/app"; 
import { LoginButton } from '@telegram-auth/react';
import SelectChain from '@/app/components/chain/SelectChain';
import { RiVerifiedBadgeFill } from 'react-icons/ri';
 
// Initialize Firebase
const app = initializeApp(firebaseConfig);
 

let dao;
let daoUsers;
let daoDelegatee = [];
let proposals = [];
let is_Admin = false;
let inbox_link = '/inbox'
let logoSaveImg = null
let hasLoad = false 
let hasDaoLoadFirst = false
  
  
const AboutDAO = () => {

  const [selectedTab, setSelectedTab] = useState('proposals') 
  const [daoChain, setDaoChain] = useState({})
  const [modal, setModal] = useState('')
  const [edit, setEdit] = useState('') 
  const [delegators, setDelegators] = useState(false)
  const [innerDelegates, setInnerDelegatees] = useState([])
 
  /* RETRIEVE THE DAO SPECIFIC INFORMATION */
  const indexMain = async () => {
    let _dao =  (window.location.href.substring(window.location.href.lastIndexOf("/") + 1)) || ""
    //fetch dao meta first
    dao = (await getAlldaoInfo(_dao))[_dao];  
    setDaoChain({chain:dao.chain, name:(dao.chain=='stellar')?'Stellar':'XRPL'})
    //load dao meta function first
    setUp('meta')
    //get onchain info
    dao = {...((await getDaoWithoutMeta((dao.chain=='stellar')?[_dao]:[dao.ipfs], dao.chain))[0]), ... dao};
    //show share on first load, only for owner
    is_Admin = dao.admins.includes(walletAddress) || (dao.owner == walletAddress)
    //dao.owner = walletAddress
    if(dao.owner == walletAddress) {showDaoShareOnFirst(dao.token)}
    E('dao_save_toml').innerHTML = E('dao_save_toml').href = dao.url
    dao.toml = await readAssetToml(dao.url, dao.chain)
    setUp(); 
    inbox_link += "?dao=" + _dao + "&name=" + dao.name
    E('tab3').innerText = "Members (" + dao.members + ")"
    if (dao.admins.includes(walletAddress) || dao.owner == walletAddress) {  
      E('tab5').style.display = 'flex'
    }
    //show proposal review only if admin
    if (dao['proposals'] != undefined) {
        //load info of all the proposals
        if (dao.proposals.length > 0) {
            //get all propsoal ifo
            const props = await getAllProposal(dao.proposals, dao.token, dao.chain);
            if(props.status) { 
                let temPropView = document.createElement('div') //hold proposal views, till they are done loading
                let temRePropView = document.createElement('div') //hold proposal views, till they are done loading
                for(let i=0;i<dao.proposals.length;i++) {
                    const prop = props[dao.proposals[i]];  
                    if (prop != undefined && prop != "") {
                        prop.status = Number(prop.status);  
                        if (prop['title'] != undefined) {
                            prop.proposalId = dao.proposals[i]; //attach id
                            proposals[prop.proposalId] = prop
                            if (prop.status != 0 && prop.status != 2) {
                                //append 
                                prop.first = (temPropView.innerHTML == "")
                                temPropView.appendChild(drawProposal(prop, is_Admin))
                            }
                            //append based on review  
                            if (prop.status == 0) {  
                                prop.first = (temRePropView.innerHTML == "")
                                temRePropView.appendChild(drawProposalReview(prop, is_Admin))
                            }
                          
                        }
                    }
                } 
                E('proposal_views').innerHTML = temPropView.innerHTML;
                E('proposal_review').innerHTML = temRePropView.innerHTML;
                if (temPropView.firstElementChild == null) {
                    E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No record found.</center></div>"
                    E('proposal_views').setAttribute('data', 'empty')
                }
                if (temRePropView.firstElementChild == null) {
                    E('proposal_review').innerHTML = "<div style='font-size:20px; margin:60px;'><center>Nothing found.</center></div>"
                }
                //show proposals counts
                E('tab1_count').innerHTML = "(" + temPropView.children.length + ")"
                E('tab5').innerHTML = "Proposals In Review (" + temRePropView.children.length + ")"
                temPropView = temRePropView = null
            }
        } else {
            E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No proposal created yet<br>Be the first to create a proposal.</center></div>"
            E('proposal_review').innerHTML = "<div style='font-size:20px; margin:60px;'><center>Nothing found.</center></div>"
        }
    }
    else {
        E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No proposal created yet<br>Be the first to create a proposal.</center></div>"
            E('proposal_review').innerHTML =  "<div style='font-size:20px; margin:60px;'><center>No record found.</center></div>"
    }
    
    E('leaveDao').onclick = async () => {
        const id = talk("Getting ready")
        //first burn all the tokens
        const bal = await getTokenUserBal(dao.token, walletAddress, CHAIN)
        if (bal > 0) {
            talk("First burning asset balance", 'norm', id)
            //burn tokens first
            await burnToken(bal, code, issuer)
        }
        talk("Leaving Dao", 'norm', id)
        const res = await leaveDao(dao.code, dao.issuer, _dao, dao.name)
        if (res.status === true) {
            talk("You have left this Dao", 'good', id)
            //hide button
            E('leaveDao').style.display = 'none'
            E('joinDao').style.display = 'block'
            dao['joined'] = false
            daoUsers[daoUsers.indexOf(walletAddress)] = null //remove the user
            daoUsers = fArr(daoUsers)
            loadUsers()
            setUp()
        } else {
            talk("Something went wrong", 'fail', id)
        }
        stopTalking(4, id)

    }
    E('joinDao').onclick = async () => {
        const id = talk('Joining dao')
        const res = await createTrustline(dao.code, dao.issuer, walletAddress, dao.name, dao.token)
        if(res === false) {
            talk('Something went wrong<br>This may be due to network error', 'fail', id)
        }
        else {
            talk('Joined successfully', 'good', id)
            //remove the  button
            E('joinDao').style.display = 'none'
            E('leaveDao').style.display = 'block'
            dao['joined'] = true
            daoUsers.push(walletAddress) //add new users
            loadUsers()
            setUp()
        }
        stopTalking(4, id) 
    }
    //load users
    E('dao_users').innerHTML = `<center style='margin: 40px 20px'>Loading members</center>`
    daoUsers = await getUsersDao(dao.token);
    daoDelegatee = await getAllDelegates(dao.token)
    setTimeout(loadUsers, 50)
    setTimeout(loadDelegatee, 50)
  }
  /* Show dao share first time */
  const showDaoShareOnFirst = async (daoId) => {
    //check if user is connecting for the first time
    if(hasDaoLoadFirst) return;
    hasDaoLoadFirst = true;console.log(daoId)
    if(daoId != ""){
      const isDaoNew = await getDaoFirst(daoId)
      if(isDaoNew == false) return
      if(isDaoNew['status']) {
        if(isDaoNew['new'] == 1) {
            setModal('socials')
            E('shareLink').innerHTML = window.location.href
            return;
        }
      }
    }
  }
  /** Load dao info 
  * @params {type all|meta|chain}
  **/
  const setUp = async (type = 'all') => {  
    if (dao['token'] != undefined) {
        E('dao_name').innerHTML = E('dao_name_head').innerHTML = E('dao_save_name').innerHTML = E('user_delegate_dao_name').innerHTML = dao.name || "no name"
        E('dao_about').innerHTML = E('dao_save_about').innerHTML = dao.description || "Your friendly Lumos DAO community"
        //get token info name
        E('dao_token_name').innerHTML = E('dao_save_code').innerHTML = E('asset_info_name').innerHTML = dao.code
        E('dao_token_url').innerHTML = E('dao_token_url').href = dao.url
        E('dao_explorer_stellar').href = E('asset_name').href = (dao.chain == 'stellar')?stellarExpert + '/asset/' + dao.code + '-' + dao.issuer:`${xrpExplorer}/token/${dao.code}.${dao.issuer}`
        E('dao_explorer_stellar').innerText = (dao.chain == 'stellar')?"Stellar.expert":`XrpScan`
        const coverImgx = (dao.cover != "" && dao.cover) ? dao.cover : (dao.img || "")
        if(!(E('dao_cover_image').style.backgroundImage.indexOf(coverImgx) > -1)){
          E('dao_cover_image').style.backgroundImage = 'url(' + coverImgx + "?id=" + Math.random() + ')'
        }
        E('dao_save_img').src = E('dao_image').src = E('asset_info_img').src = (dao.image || "")   
        E('createProposal').href = `/dao/${dao.token}/proposal/create`
        if(dao.proposal_settings) {
            if(dao.proposal_settings == 1) {
                E('dao_setting_proposal_every').checked = true
                E('createProposal').style.display = ""
            }
            else {
                E('dao_setting_proposal_admin').checked = true
                //check if its an admin
                if (dao.owner == walletAddress || dao.admins.includes(walletAddress)) {  
                    E('createProposal').style.display = ""
                }
            }
        }  
            
        if(dao.dao_bonus) {
            if(dao.dao_bonus.budget > 0) {
                //has been set
                E('is_dao_bonus_set').checked =  true
                E('dao_bonus_view').style.display = ''
                E('dao_bonus_name').innerText = dao.code
                E('dao_bonus_balance').innerText = (N(dao.dao_bonus.balance) / 1E7).toLocaleString()
                E('dao_bonus_budget').innerText = (N(dao.dao_bonus.budget) / 1E7).toLocaleString()
                if(!dao.dao_bonus.members.includes(walletAddress)) {
                    //shows the claim bonus button
                    if(dao['joined']){
                        E('dao_bonus').style.display = ""
                    }
                    E('dao_bonus').onclick = async (e) => {
                        E('dao_bonus').disabled = true
                        const id = talk('Claiming joining bonus successfully', 'norm')
                        const res = await claimJoiningBonus({
                            owner:walletAddress,
                            dao:dao.token,
                        })
                        if(res !== false) {
                            E('dao_bonus').disabled = false
                            if(res.status === 'true') {
                                E('dao_bonus').style.display = 'none'
                                stopTalking(3, talk('Claimed joining bonus successfully', 'good', id))
                            }
                            else if(res.status === 'claim') {
                                stopTalking(3, talk('Already claimed the bonus', 'fail', id))
                            }
                            else if(res.status === 'nofunds') {
                                stopTalking(3, talk('Insufficient bonus balance available', 'fail', id))
                            }
                            else {
                                stopTalking(3, talk('Unable to claim joining bonus<br>Something went wrong<br>', 'fail', id))
                            }
                        }
                        else {
                            talk("Unable to claim joining bonus<br>Something went wrong<br>","fail", id)
                            E('dao_bonus').disabled = false
                            stopTalking(2, id) 
                        }
                    }
                }
            }
            else {
                E('is_dao_bonus_set').checked =  false
                E('dao_bonus_view').style.display = 'none'
            }
        }
        //set on click for this function
        E('is_dao_bonus_set').oninput = (e) => {  
            if(E('is_dao_bonus_set').checked) {
                E('dao_bonus_view').style.display = ''
                E('dao_bonus_name').innerText = dao.code
                E('dao_bonus_balance').innerText = (N(dao.dao_bonus.balance) / 1E7).toLocaleString()
                E('dao_bonus_budget').innerText = (N(dao.dao_bonus.budget)/ 1E7).toLocaleString()
            }
            else {
                E('dao_bonus_view').style.display = 'none'
            }
        }
        //check if ts a member of this dao
        const isMember = dao['joined']; 
        if(dao.owner != walletAddress && dao.owner){ 
            if (isMember !== false) {
                E('leaveDao').style.display = 'block'
                E('joinDao').style.display = 'none'
            } else {
                E('leaveDao').style.display = 'none'
                E('joinDao').style.display = 'block'
            }      
        }
        else {
            //hide both buttons
            E('leaveDao').style.display = 'none'
            E('joinDao').style.display = 'none'
        }
        //get asset info from toml
        if (dao.url != "" ) {
            dao.toml =  dao.toml || {}
            const aToml = dao.toml || {}
            aToml.DOCUMENTATION = aToml.DOCUMENTATION || {}
            //we are giving preference to the db first before the toml
            aToml.DOCUMENTATION.ORG_URL = dao.website || aToml.DOCUMENTATION.ORG_URL || ""
            aToml.DOCUMENTATION.ORG_TWITTER = dao.twitter_url || aToml.DOCUMENTATION.ORG_TWITTER ||  ""
            aToml.DOCUMENTATION.ORG_TELEGRAM = dao.telegram_url || aToml.DOCUMENTATION.ORG_TELEGRAM ||  ""
            aToml.DOCUMENTATION.ORG_REDDIT = dao.reddit_url || aToml.DOCUMENTATION.ORG_REDDIT ||  ""
            aToml.DOCUMENTATION.ORG_INSTAGRAM = aToml.DOCUMENTATION.ORG_INSTAGRAM || ""
            aToml.DOCUMENTATION.ORG_DISCORD = aToml.DOCUMENTATION.ORG_DISCORD ||  ""
            
            if(type == 'all' || type == 'chain') {
                E('dao_website').innerHTML = E('dao_website').href = E('dao_save_domain').innerHTML = E('dao_save_website').innerText = (aToml.DOCUMENTATION != undefined) ? aToml.DOCUMENTATION.ORG_URL : ""
                const temp = (dao.owner || "")
                E('dao_others_address').innerHTML = ""
                E('dao_others_address').appendChild(drawOtherAddress(temp, 'DAO Creator'))
    
                //check if its an approved wallet
                if (dao.owner == walletAddress || dao.admins.includes(walletAddress)) { 
                    E('dao_setting').style.display = 'block'
                    E('dao_set_cover').style.display = 'block'
                }
                if (dao.owner == walletAddress){  
                    E('is_dao_bonus_parent').style.display = ''
                }
                //load approved address
                E('dao_admin_lists').innerHTML = ""
                //load admin list
                for (let i = 0; i < dao.admins.length; i++) {
                    if (dao.admins[i] != null) {
                        E('dao_admin_lists').innerHTML += drawAdminUser({
                            user: dao.admins[i]
                        })
                        E('dao_others_address').appendChild(drawOtherAddress(dao.admins[i], "Admin"))
                    }
                }
                if (E('dao_admin_lists').innerHTML == "") {
                    E('dao_admin_lists').parentElement.style.display = 'none'
                } else {
                    E('dao_admin_lists').parentElement.style.display = ''
                }
                //show top voters
                //sort in descending order
                dao.top_voters.sort((a, b) => N(b.vote - a.vote));
                if (dao.top_voters.length > 0) {
                    E('topVotersView').innerHTML = ""
                    for (let i = 0; i < dao.top_voters.length && i < 5; i++) {
                        E('topVotersView').appendChild(drawTopVoters(dao.top_voters[i]))
                    }
                    E('topVoters').style.display = "block"
                } else {
                    E('topVotersView').innerHTML = "<center style='margin-top:40px'>Nothing to show</center>"
                }
                //display links
                const socials = aToml.DOCUMENTATION
                if (socials.ORG_TWITTER != "") {
                    E('dao_twitter').href = socials.ORG_TWITTER
                    E('dao_twitter').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_twitter').parentElement.style.display = 'none'
                }
                if(dao.twitter != "") {
                    E('dao_save_twitter_div').innerHTML = "Connected"
                    E('dao_save_twitter').disabled = true
                }
                if (socials.ORG_TELEGRAM != "") {
                    E('dao_telegram').href = socials.ORG_TELEGRAM
                    E('dao_telegram').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_telegram').parentElement.style.display = 'none'
                } //hide the icon
                if(dao.telegram != "") {
                    E('dao_save_telegram').innerHTML = `<img class="w-img border"   alt="">
                    <div id='dao_save_telegram_div'  class="font-medium text-muted ml-2">Connected</div>`
                    E('dao_save_telegram').disabled = true
                }
                if (socials.ORG_REDDIT != "") {
                    E('dao_reddit').href = socials.ORG_REDDIT
                    E('dao_reddit').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_reddit').parentElement.style.display = 'none'
                } //hide the icon
                if(dao.reddit != "") {
                    E('dao_save_reddit_div').innerHTML = "connected"
                    E('dao_save_reddit').disabled = true
                }
                
                if (socials.ORG_INSTAGRAM != "") {
                    E('dao_instagram').href = socials.ORG_INSTAGRAM
                    E('dao_instagram').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_instagram').parentElement.style.display = 'none'
                } //hide the icon
    
                if (socials.ORG_DISCORD != "") {
                    E('dao_discord').href = socials.ORG_DISCORD
                    E('dao_discord').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_discord').parentElement.style.display = 'none'
                } //hide the icon
            }
        }
        //check if locked
        const isLocked = await getLocked(dao.issuer, dao.chain)
        if(!isLocked) {
            //show the locked msg
            // E('dao_unverify_badge').style.display = ""
            E('dao_verify_badge').style.display = "none" //hide the verify badge
            E('dao_asset_buy').style.display = 'none !important' //hide the buy buttons
        }
        else {
            E('dao_verify_badge').style.display = ""
            // E('dao_unverify_badge').style.display = "none" //hide the unverify badge
            E('dao_asset_buy').style.display = "" //show the buy button
        }
        if(!dao.issuer == walletAddress){
            //hide the verify message
            E('dao_verify_warn').style.display = "none"
        }
        E('dao_save_about').style.display = 'block'
        E('addAdminInputField').style.display = "none" //hide the add admin input field
        E('addNewAdmin').style.display = "none" //hide the add admin input field
        E('dao_save_image_edit').value = [] //reset file upload
        E('dao_save_button').disabled = false //enable save button
        //The api can cause a 31.s sec delay so put it last
        if(type == 'all') {
            const info = await getMarketCap({
                code:dao.code, issuer:dao.issuer, chain:dao.chain
            })
            
            E('asset_info_holders').innerHTML = fNum(info.holders || 0)
            E('asset_info_market').innerHTML = '$' + fNum((info.cap || 0))
            E('asset_info_supply').innerHTML = fNum((info.supply) || 0)
            E('price_change').innerHTML = "$" + fNum((info?.price_change || 0).toFixed(3))
            if(dao.chain == 'stellar'){
                E('asset_info_xmagnetic_link').style.display = 'none'
            }else{
                E('asset_info_lobstr_link').style.display = 'none'
                E('asset_info_lumen_link').style.display = 'none'
                E('asset_info_scouply_link').style.display = 'none'
            }
            E('asset_info_lobstr_link').href = `https://lobstr.co/trade/native/${dao.code}:${dao.issuer}`
            E('asset_info_lumen_link').href = `https://obm.lumenswap.io/swap/XLM/${dao.code}-${dao.issuer}`
            E('asset_info_scouply_link').href = `https://scopuly.com/trade/${dao.code}-XLM/${dao.issuer}/native`   
            E('asset_info_xmagnetic_link').href = `https://xmagnetic.org/dex/${dao.code}+${dao.issuer}+XRP?network=${((networkWalletUsed != 'TESTNET')?"MAINNET":"TESTNET").toLowerCase()}`   
              
        }
    }
  }
  const modifyDao = (domain, assetName, type, value, callback) => {
    // Create an HTTP request
    domain = new URL(domain).hostname.split('.')[0]
    const xhr = new XMLHttpRequest();
    const url = API_URL + `modify${type}&name=` + assetName + "&value=" + encodeURIComponent(value) + "&domain=" + domain + "&dao=" + dao.token 
    // Define the server endpoint (PHP file)
    xhr.open('POST', url, true);
    // Set up an event listener to handle the response
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText == "1") {
                callback(true)
            } else {
                callback(false)
            }
        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            callback(false)
        }
    };
    // Send the FormData object with the image
    xhr.send();
  }
  const modifyAssetImg = (assetName, callback) => {
    const fileInput = E('dao_save_image_edit');
    const formData = new FormData(); // Create a FormData object
    // Add the selected file to the FormData object
    formData.append('file', logoSaveImg);
    // Create an HTTP request
    const xhr = new XMLHttpRequest();
    const url = API_URL + "upload&name=" + assetName + ".png"
    // Define the server endpoint (PHP file)
    xhr.open('POST', url, true);
    // Set up an event listener to handle the response
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText)
            if (xhr.responseText == "1") {
                callback(true)
            } else {
                callback(false)
            }
        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            callback(false)
        }
    };
    // Send the FormData object with the image
    xhr.send(formData);
  }
  //to oauth socials
  const saveSocials = async(type, user) => {
    if(type == 'twitter') {
        const provider = new TwitterAuthProvider(); 
        const auth = getAuth();
        signInWithPopup(auth, provider)
        .then(async (result) => { 
            const user = result.user
            //save the refresh token
            try {
                if(user.refreshToken) {
                    const id = talk('Connecting twitter')
                    //modify the toml first
                    const shareUri = 'https://x.com/' + result._tokenResponse.screenName
                    modifyDao(dao.url, dao.code, 'social', JSON.stringify({
                            twitter:shareUri
                        }), async (status) => {
                            if (status) {
                                //save back the results
                                dao.toml.DOCUMENTATION.ORG_TWITTER = shareUri
                                const url = API_URL + "twitter_auth&dao=" + dao.token  + "&code=" + encodeURIComponent(user.refreshToken) 
                                const response = await fetch(url);
                                if (!response.ok) {
                                  throw new Error("Network response was not ok");
                                }
                                const res = await response.json();
                                if(res.status) {
                                    dao.twitter = user.refreshToken
                                    setUp()
                                    talk("Twitter connected successfully", "good", id)
                                    stopTalking(3, id)
                                }
                                else {
                                    talk("Unable to connect twitter account<br>Something went wrong<br>This may be due to network error","fail", id)
                                    stopTalking(3, id)
                                }
                            } else {
                                talk("Unable to connect twitter account<br>Something went wrong<br>This may be due to network error","fail", id)
                                stopTalking(3, id)
                            }
                    })
                }
                else {
                    stopTalking(3, talk('Something went wrong', 'fail'))
                }
            } catch (error) { console.log(error)
                stopTalking(2.5, talk("Unable to connect twitter", 'fail'))
            }
        }).catch((error) => {
          console.log(error) 
        });
    }
    else if(type == 'telegram') {
        try {
                if(user.id) {
                    const id = talk('Connecting telegram')
                    //modify the toml first
                    const shareUri = 'https://t.me/' + user.username
                    modifyDao(dao.url, dao.code, 'social', JSON.stringify({
                            telegram:shareUri
                        }), async (status) => {
                            if (status) {
                                //save back the results
                                dao.toml.DOCUMENTATION.ORG_TELEGRAM = shareUri
                                const url = API_URL + "telegram_auth&dao=" + dao.token  + "&id=" + encodeURIComponent(user.id) 
                                const response = await fetch(url);
                                if (!response.ok) {
                                  throw new Error("Network response was not ok");
                                }
                                const res = await response.json();
                                if(res.status) {
                                    dao.telegram = user.id
                                    setUp()
                                    talk("Telegram connected successfully", "good", id)
                                    stopTalking(3, id)
                                }
                                else {
                                    talk("Unable to connect telegram account<br>Something went wrong<br>This may be due to network error","fail", id)
                                    stopTalking(3, id)
                                }
                            } else {
                                talk("Unable to connect telegram account<br>Something went wrong<br>This may be due to network error","fail", id)
                                stopTalking(3, id)
                            }
                    })
                }
                else {
                    stopTalking(3, talk('Something went wrong', 'fail'))
                }
            } catch (error) { console.log(error)
                stopTalking(2.5, talk("Unable to connect telegram", 'fail'))
            }
    }
    else if(type == 'reddit') {  
        window.location.href = getRedditOauthUri(dao.token, (new URL(dao.url).hostname.split('.')[0]))
    }
  }

  //to search 
  const searchAdminUser = () => {
    const search = E('dao_search_admin_result')
    search.innerHTML = ""
    const addr = E('dao_search_admin').value.trim()
    if (addr != "") {
        for (let i = 0; i < daoUsers.length; i++) {
            if (daoUsers[i] == addr) {
                //present 
                search.innerHTML = drawUser({
                    user: daoUsers[i]
                })
            }
        }
        if (search.innerHTML == "") {
            search.innerHTML = ` 
                    <center style='margin:40px'>Nothing found</center> 
                    `
            E('dao_admin_rules').style.display = 'none'
        } else {
            E('dao_admin_rules').style.display = 'flex'
        }
        E('addNewAdmin').style.display = ''
    } else {
        E('addNewAdmin').style.display = 'none'
    }
  }
  const verifyTheDao = async () => {
    //to verify the dao
    if(dao.issuer == walletAddress) {
        const id = talk('Locking issuing wallet')
        const res = await lockIssuer({
            issuer:dao.issuer,
            daoName:dao.name,
            dao:dao.token
        })
        if(res.status !== false) {
            stopTalking(3, talk('Issuing wallet locked', 'good', id))
            setUp()
        }
        else {
            stopTalking(3, talk('Unable to lock issuing wallet<br>' + res.msg, 'fail', id))
        }
    }
    else {
        stopTalking(3, talk('You must call this function from the issuing wallet', 'fail'))
    }
  }
  const loadUsers = async (page = 1) => {
    //format array
    const usersArray = [];
    for (let i = 0; i < daoUsers.length; i++) {
      //if(daoUsers[i] != walletAddress){
        usersArray.push({
          member: daoUsers[i],
          isBan: dao.ban_members.includes(daoUsers[i]),
          isAdmin: is_Admin
        })  
      //}
    }
    dao.members = usersArray.length
    E('tab3').innerText = "Members (" + usersArray.length + ")"
    E('dao_members').innerHTML = dao.members.toLocaleString() + (( dao.members > 1) ? " members" : " member")
    //to do pagination, segment is 20
    paginate('dao_users', usersArray, 20, drawMember)
  }
  const loadDelegatee = async () => {
    //get dao delegates keys
    const delegateKeys = Object.keys(daoDelegatee)
    if (delegateKeys.length > 0) {   
        let delegateCount = 0;
        E('user_delegates_view').innerHTML = ""
        for (let i = 0; i < delegateKeys.length; i++) {
            const key = delegateKeys[i]
            if (daoDelegatee[key].length > 0) {
                delegateCount++
                const otherslen = daoDelegatee[key].length - 1; 
                //show
                E('user_delegates_view').innerHTML += drawDelegateinfo({
                    delegator: daoDelegatee[key][0],
                    delegatee:key,
                    others: (otherslen > 0) ? (("+" + otherslen) + ((otherslen > 1) ? " others" : " other")) : ""
                })
            }
        }
        E('user_delegates_no').innerText = delegateCount
        if (E('user_delegates_view').innerHTML != "") {
            E('user_delegates').style.display = "" //show
        }
    } else {
        E('user_delegates').style.display = "none" //hide
    }
  }
  const searchDelegate = () => {
    const _delegatee = E('dao_delegate_search').value.trim()
    E('searchDelegateResults').innerHTML = ""
    if (_delegatee != "") {
        //loop through users 
        for (let i = 0; i < daoUsers.length; i++) {
            if (daoUsers[i].indexOf(_delegatee) > -1 && daoUsers[i] != walletAddress) {
                //show
                E('searchDelegateResults').innerHTML += drawDelegateSearchResult({
                    user: daoUsers[i],
                    type: ((daoDelegatee[daoUsers[i]] || []).includes(walletAddress)) ? 2 : 1
                })
            }
        }
        if (E('searchDelegateResults').innerHTML == "") {
            E('searchDelegateResults').innerHTML = `<center style='margin: 40px 20px'>Nothing found</center>`
        }
        E('user_delegates_search').style.display = "" //show
    } else {
        E('user_delegates_search').style.display = "none" //show
    }
  }
  //share functions for dao
  const shareFunctions = (type = 'fb') => {  
    const msg = `New Dao on Lumsdao.io ${dao.name} `
    const title = `LumosDao Dao ${dao.name}`
    const url =  E('shareLink').innerHTML;
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
        shareUrl = `https://wa.me/?text=${encodeURIComponent(msg) + '\n' + encodeURIComponent(url)}`;
    }
    else if(type == 'twitter') {
        shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(msg)}&url=${encodeURIComponent(url)}`;
    }
    else if(type == 'reddit') {
        // Construct the Reddit share URL
        shareUrl = `https://www.reddit.com/r/${encodeURIComponent(msg)}/submit?title=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`;
    }
    //Open the Facebook share dialog in a new window
    window.open(shareUrl, '_blank');
    
  }

  useEffect(() => {
    window.E = (id) => document.getElementById(id)     
    window.walletAddress = localStorage.getItem('selectedWallet') || ""
    window.CHAIN = localStorage.getItem("LUMOS_CHAIN") || "stellar"
  
    /* Top level function. Do not remove */
    window.toggleMemberModal = (m, event) => {
        if(E(m).style.display == 'none'){
        E(m).style.display = 'flex'
        }
        else {
        E(m).style.display = 'none'
        } 
        event.stopPropagation();
        E(m).onclick = (event) => {
            event.stopPropagation();
        }
    }
    window.removeAdmin = async (user, event) => {
        //to remove admin
        if (walletAddress == dao.owner) {
            event.target.disabled = true
            //call trustline function
            const id = talk("Removing admin", "norm") 
            //save the address to the toml
            const res = await removeDaoAdmin({
                admin: user,
                dao: dao.token,
                daoName: dao.name
            })
            if (res !== false) {
                stopTalking(3, talk("Admin removed successfully", "good", id))
                dao.admins[dao.admins.indexOf(user)] = null
                setUp()
            } else {
                talk("Unable to remove admin<br>Something went wrong<br>This may be due to network error", "fail",
                    id)
                stopTalking(3, id)
            }
            event.target.disabled = false
        } else {
            const msg = "Only the owner can do this";
            stopTalking(4, talk(msg, 'fail'))
        }
    }
    window.banMember = async (user, id, event) => {
        //to ban a member
        E(id).style.display = 'none'
        if (is_Admin) {
            if (user != dao.owner) {
                if (user != walletAddress) {
                    event.target.disabled = true
                    const id = talk('Banning member ' + fAddr(user, 10))
                    const res = await banDaoMember({
                        user: user,
                        dao: dao.token,
                        url: dao.url
                    })
                    event.target.disabled = false
                    if (res.status === "true") {
                        stopTalking(3, talk("Banned member " + fAddr(user, 10), "good", id))
                        //remove from banned list
                        dao.ban_members.push(user)
                        loadUsers()
                    } else if (res.status === "false") {
                        stopTalking(3, talk("Unable to ban member " + fAddr(user, 10) + "<br>Something went wrong",
                            "fail", id))
                    } else if (res === 2) {
                        stopTalking(3, talk("Unable to perform this operation because you are not an admin", "fail",
                            id))
                    } else if (res === 3) {
                        stopTalking(3, talk("Network error", "fail", id))
                    } else if (res === 4) {
                        stopTalking(3, talk("Unable to perform this operation because your account has been banned",
                            "fail", id))
                    } else {
                        stopTalking(3, talk("Unable to ban member " + fAddr(user, 10) + "<br>Something went wrong",
                            "fail", id))
                    }
                } else {
                    stopTalking(3, talk("You cannot ban yourself", "fail"))
                }
            } else {
                stopTalking(3, talk("You cannot ban the creator of this DAO", "fail"))
            }
        } else {
            stopTalking(3, talk("Only an admin can do this", "fail"))
        }
    }
    window.unbanMember = async (user, id, event) => {
        //to ban a member
        E(id).style.display = 'none'
        if (is_Admin) {
            if (user != walletAddress) {
                event.target.disabled = true
                const id = talk('Removing ban from member ' + fAddr(user, 10))
                const res = await unbanDaoMember({
                    user: user,
                    dao: dao.token,
                    url: dao.url
                })
                event.target.disabled = false
                if (res.status === "true") {
                    stopTalking(3, talk("Unbanned member " + fAddr(user, 10), "good", id))
                    //add to  banned list
                    dao.ban_members[dao.ban_members.indexOf(user)] = null
                    loadUsers()
                } else if (res.status === "false") {
                    stopTalking(3, talk("Unable to unban member " + fAddr(user, 10) + "<br>Something went wrong",
                        "fail", id))
                } else if (res === 2) {
                    stopTalking(3, talk("Unable to perform this operation because you are not an admin", "fail",
                        id))
                } else if (res === 4) {
                    stopTalking(3, talk("Unable to perform this operation because your account has been banned",
                        "fail", id))
                } else if (res === 3) {
                    stopTalking(3, talk("Network error", "fail", id))
                } else {
                    stopTalking(3, talk("Unable to unban member " + fAddr(user, 10) + "<br>Something went wrong",
                        "fail", id))
                }
            } else {
                stopTalking(3, talk("You can't unban yourself", "fail"))
            }
        } else {
            stopTalking(3, talk("Only an admin can do this", "fail"))
        }
    }
    window.approveProposal = async (prop = {}, _id = "", event) => {
        //to approve a proposal
        prop = proposals[prop]
        event.stopPropagation()
        if (prop.budget > 0) {
            //budget admin
            if (walletAddress == dao.owner) {
                await aP()
            } else {
                stopTalking(3, talk("Only the DAO owner can approve a budgeted proposal", 'warn'))
            }
        } else {
            //not a budgt proposal, check if admin
            if (is_Admin) {
                await aP()
            } else {
                stopTalking(3, talk("Only the DAO owner or an admin can approve proposals", 'warn'))
            }
        }

        async function aP() {
            //actual approval
            const id = talk("Accepting proposal")
            const res = await executeProposal({
                propId: prop.proposalId,
                status: 1,
                creator:prop.creator,
                daoId:dao.token,
                _type: 2
            })
            if (res !== false) {
                if (res.status === "done") {
                    talk("Proposal accepted", 'good', id)
                    stopTalking(3, id)
                    prop.status = 1n;
                    proposals[prop.proposalId] = prop
                    //draw it in the confirm section
                    const elem = E('proposal_review')
                    elem.removeChild(E(_id))
                    E('tab5').innerHTML = "Proposals In Review (" + elem.children.length + ")"
                    if (elem.firstElementChild == null) {
                        elem.innerHTML =  "<div style='font-size:20px; margin:60px;'><center>No record found.</center></div>"
                    }
                    if (E('proposal_views').getAttribute('data') == 'empty') {
                        E('proposal_views').innerHTML = ""
                    }
                    E('proposal_views').insertBefore(drawProposal(prop), E('proposal_views').firstElementChild)
                    E('tab1_count').innerHTML = "(" + E('proposal_views').children.length + ")"
                    
                } else if (res.status == "lowvotes") {
                    stopTalking(3, talk("Unable to accept a proposal with no votes", 'fail', id))
                } else if (res.status == "executed") {
                    stopTalking(3, talk("Proposal has already been executed", 'fail', id))
                } else if (res.status == "notauth") {
                    stopTalking(3, talk("You are not authorized to do this<br>You are no longer an admin",
                        'fail', id))
                } else {
                    stopTalking(3, talk("Unable to approve proposal", 'fail', id))
                }
            } else {
                stopTalking(3, talk("Something went wrong", 'fail', id))
            }
        }
    }
    window.rejectProposal = async (prop = {}, _id = "", event) => {
        //to approve a proposal
        prop = proposals[prop]
        event.stopPropagation()
        if (walletAddress == dao.owner || is_Admin) {
            await aP()
        } else {
            stopTalking(3, talk("You are not authorized to do this", 'warn'))
        }


        async function aP() {
            //actual approval
            const id = talk("Rejecting proposal")
            const res = await executeProposal({
                propId: prop.proposalId,
                status: 2,
                _type: 0,
                creator:prop.creator,
                daoId:dao.token
            })
            if (res !== false) {
                if (res.status === 'done') {
                    stopTalking(3, talk("Proposal rejected", 'good', id))
                    prop.status = 2n;
                    prop.executed = true
                    proposals[prop.proposalId] = prop
                    //draw it in the confirm section
                    const elem = E('proposal_review')
                    elem.removeChild(E(_id))
                    //set the new proposal review no
                    E('tab5').innerHTML = "Proposals In Review (" + elem.children.length + ")"
                    if (elem.firstElementChild == null) {
                        elem.innerHTML = "<div style='font-size:20px; margin:60px;'><center>No record found.</center></div>"
                    }
                } else if (res.status == "executed") {
                    stopTalking(3, talk("Proposal has already been executed", 'fail', id))
                } else if (res.status == "notauth") {
                    stopTalking(3, talk("You are not authorized to do this<br>You are no longer an admin",
                        'fail', id))
                } else {
                    stopTalking(3, talk("Unable to reject proposal<br>Something went wrong", 'fail', id))
                }
            } else {
                stopTalking(3, talk("Unable to reject proposal", 'fail', id))
            }
        }
    }
    window.addUserDelegate = async (type = 1, delegatee) => {
        //to add or remove a delegate
        let id;
        const but = E(delegatee + '_delegate')
        //check if the user has delegated to another user
        const delegators = await getDaoDelegatee(dao.token, walletAddress, CHAIN)
        console.log(delegators)
        if(!delegators.includes(delegatee) && delegators.length > 0){
            stopTalking(3, talk("You have delegate your voting power", 'fail'))
            return ""
        }
        const del_address = delegatee
        if (await isBanned(dao.token, walletAddress, CHAIN)) {
            stopTalking(3, talk("You have been banned from this dao", 'fail'))
            return ""
        }
        //check if user has joined the dao
        if ((await getTokenUserBal(dao.token, walletAddress, CHAIN)) === false) {
            stopTalking(3, talk("You are not a member of this dao", 'fail'))
            return ""
        }
        but.disabled = true  
        if (type == 1) {
            id = talk("Delegating voting power to " + fAddr(delegatee, 6))
        } else {
            id = talk("Reclaiming voting power from " + fAddr(delegatee, 6))
            delegatee = walletAddress
        }
        const res = await addDelegate({
            delegatee: delegatee,
            del_address:del_address,
            dao: dao.token
        })
        but.disabled = false
        if (res !== false) {
            daoDelegatee[delegatee] = daoDelegatee[delegatee] || []
            if (type == 1) {
                stopTalking(3, talk("Delegated voting power to " + fAddr(delegatee, 6), 'good', id))
                daoDelegatee[delegatee].push(walletAddress)
            } else {
                stopTalking(3, talk("Reclaimed voting power from " + fAddr(del_address, 6), 'good', id))
                daoDelegatee[del_address][daoDelegatee[del_address].indexOf(walletAddress)] = null 
                daoDelegatee[del_address] = fArr(daoDelegatee[del_address])
            }
            //reload results
            loadDelegatee()
            //hide delegate search results
            E('user_delegates_search').style.display = "none"
        } else {
            if (type == 1) {
                stopTalking(3, talk("Unable to delegate voting power to " + fAddr(delegatee, 6) +
                    '<br>Something went wrong', 'fail', id))
            } else {
                stopTalking(3, talk("Unable to reclaim voting power from " + fAddr(del_address, 6) +
                    '<br>Something went wrong', 'fail', id))
            }
        }
    }
    window.setUpDelegateModal = (delegatee) => {
        //show all its delegators
        const delegators = daoDelegatee[delegatee]
        const tempDelegators = []
        for (let i = 0; i < delegators.length; i++) {
            if (delegators[i] != "") {
                tempDelegators.push({
                    user:delegators[i]
                })
            }
        } 
        console.log(tempDelegators)
        setInnerDelegatees(tempDelegators)
        setDelegators(true)
    }
    if(!hasLoad){
      hasLoad=true
      indexMain()

      //to save cover image
      E('dao_set_cover').onclick = async () => {
        validateImageUploadSilently( async (e, imgUrl) => {
            if(e != null) {
                //optimize the image
                optimizeImg(imgUrl, 0.9).then((img) => {
                      //save the cover photo
                      E('dao_set_cover').disabled = true
                      const id = talk('Updating cover photo')
                      const formData = new FormData(); // Create a FormData object
                      // Add the selected file to the FormData object
                      formData.append('cover', img);
                      // Create an HTTP request
                      const xhr = new XMLHttpRequest();
                      const url = API_URL + "upload_cover&name=" + (dao.code+''+dao.owner) + ".png&dao_id=" + dao.token
                      // Define the server endpoint (PHP file)
                      xhr.open('POST', url, true);
                      // Set up an event listener to handle the response
                      xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) { 
                            E('dao_set_cover').disabled = false
                            const res = JSON.parse(xhr.responseText)
                            if (res['status']) {
                                stopTalking(2, talk('Cover photo uploaded successfully','good', id))
                                //change the image
                                E('dao_cover_image').style.backgroundImage = 'url(' + imgUrl + ')'
                            }
                            else if(res['img'] === false){
                                stopTalking(2, talk('Unsupported image','fail', id))
                            }
                            else {
                                stopTalking(2, talk('Unable to change cover image<br>Try again later','fail', id))
                            }
                        }
                        else if (xhr.readyState === 4 && xhr.status !== 200) {
                            E('dao_set_cover').disabled = false
                            stopTalking(2, talk('Network error','fail', id))
                        }
                      };
                    // Send the FormData object with the image
                    xhr.send(formData);
                })
                    
            }
        })
      }
      //to save the changes to the toml file
      E('dao_save_button').onclick = async () => {
        //to update the dao toml file
        if (await isBanned(dao.token, walletAddress, CHAIN)) {
            return ""
        }
        const fileInput = E('dao_save_image_edit');
        const saveDesc = (id = null) => {
            const desc = (E('dao_save_about_edit')) ? E('dao_save_about_edit').value.trim() : ""
            if (desc != "") {
                if (isSafeToml(desc)) {
                    (id != null) ? talk("Saving description", "norm", id): id = talk("Saving description")
                    modifyDao(dao.url, dao.code, 'about', desc, async (status) => {
                        if (status) {
                            talk("Description updated successfully", "good", id)
                            //hiding the input element
                            setEdit("")
                            //save back the results
                            E('dao_save_about_edit').value = ""
                            E('dao_save_about').innerHTML = E('dao_about').innerHTML = desc
                            dao.description = desc
                            talk("Saved successfully", 'good', id)
                            saveWeb(id)
                        } else {
                            talk("Unable to update description<br>Something went wrong<br>This may be due to network error", "fail", id)
                            saveWeb(id)
                        }
                    })
                } else {
                    const msg = "Invalid characters(\") present in description.<br> Please remove it and try again";
                    (id != null) ? talk(msg, 'fail', id): id = talk(msg, 'fail')
                    saveWeb(id)
                }
            } else {
                saveWeb(id)
            }

        }
        const saveWeb = (id = null) => {
            const web = (E('dao_save_website_edit')) ? E('dao_save_website_edit').value.trim() : ""
            if (web != "") {
                if (isSafeToml(web)) {
                    (id != null) ? talk("Saving website", "norm", id): id = talk("Saving website")
                    modifyDao(dao.url, dao.code, 'website', web, async (status) => {
                        if (status) {
                            talk("Website updated successfully", "good", id)
                            //hiding the input element
                            setEdit("")
                            //save back the results
                            E('dao_save_website_edit').value = ""
                            //hiding the input element
                            E('dao_website').innerHTML = E('dao_website').href = E('dao_save_website').innerHTML = E('dao_save_domain').innerText = E('dao_save_domain').href = web
                            dao.website = dao.toml.DOCUMENTATION.ORG_URL = web
                            talk("Saved successfully", 'good', id)
                            saveProposal(id)
                        } else {
                            talk("Unable to update website<br>Something went wrong<br>This may be due to network error", "fail", id)
                            saveProposal(id)
                        }
                    })
                } else {
                    const msg = "Invalid characters(\") present in website.<br> Please remove it and try again";
                    (id != null) ? talk(msg, 'fail', id): id = talk(msg, 'fail')
                    saveProposal(id)
                }
            } else {
                saveProposal(id)
            }

        }
        const saveProposal = async (id=null) => {
            //check if proposal setting changed
            let proposal_setting = dao.proposal_settings;
            if(E('dao_setting_proposal_every').checked) {
                proposal_setting = 1
            }
            else if(E('dao_setting_proposal_admin').checked){
              proposal_setting = 2
            }
            if(proposal_setting != dao.proposal_settings) {
                (id != null) ? talk('Setting proposal settings', 'norm', id): id = talk('Setting proposal settings')
                //save the changes
                const res = await setProposalSetting({
                    owner:walletAddress,
                    dao:dao.token,
                    setting:proposal_setting
                })
                if(res !== false) {
                    dao.proposal_settings = proposal_setting
                    talk('Proposal setting changed successfully', 'good', id)
                    saveDaoBonus(id)
                }
                else {
                    talk("Unable to set proposal settings<br>Something went wrong<br>","fail", id)
                    saveDaoBonus(id)
                }
            }
            else {
                saveDaoBonus(id)
            }
        }
        const saveDaoBonus = async (id=null) => {
            //check if bonus is set
            const budget = E('rewardBalance').value * 1 || 0;
            const amount = E('rewardAmount').value * 1 || 0;
            if(E('is_dao_bonus_set').checked && amount > 0) {  
                //get reward amount and reward budget
                (id != null) ? talk('Setting Joining bonus', 'norm', id): id = talk('Setting Joining bonus');
                if(amount > 0) {
                    //save the changes
                    const res = await setJoiningBonus({
                        owner:walletAddress,
                        dao:dao.token,
                        budget,
                        amount, 
                        type:1 
                    }) 
                    if(res !== false) {
                        E('dao_save_button').disabled = false
                        if(res.status === 'true') { 
                            dao.dao_bonus.balance = N(dao.dao_bonus.balance) + (budget * 10000000) 
                            dao.dao_bonus.budget = (amount + 10000000)
                            E('dao_bonus_balance').innerText = N(dao.dao_bonus.balance / 10000000).toLocaleString()
                            E('dao_bonus_budget').innerText =  N(dao.dao_bonus.budget / 10000000).toLocaleString()
                            stopTalking(3, talk('Joining bonus set successfully', 'good', id))
                            E('dao_bonus').style.display = ""
                        }
                        else if(res.status === 'notauth') {
                            stopTalking(3, talk('Only the dao owner can do this', 'fail', id))
                        }
                        else if(res.status === 'notexist') {
                            stopTalking(3, talk('This dao does not exists', 'fail', id))
                        }
                        else {
                            stopTalking(3, talk('Unable to set joining bonus<br>Something went wrong<br>', 'fail', id))
                        }
                    }
                    else {
                        talk("Unable to set joining bonus<br>Something went wrong<br>","fail", id)
                        E('dao_save_button').disabled = false
                        stopTalking(2, id) 
                    }
                }
                else {
                    stopTalking(3, talk('values cannot be empty', 'warn', id))
                    E('dao_save_button').disabled = false
                }
            }
            else if(!E('is_dao_bonus_set').checked && dao.dao_bonus.budget > 0) {   
                //get reward amount and reward budget
                (id != null) ? talk('Removing joining bonus', 'norm', id): id = talk('Removing joining bonus');
                //save the changes
                const res = await reclaimJoiningBonus({
                    owner:walletAddress,
                    dao:dao.token,
                })
                if(res !== false) {
                    E('dao_save_button').disabled = false
                    if(res.status === 'true') {
                        dao.dao_bonus.balance = 0
                        dao.dao_bonus.budget = 0
                        E('dao_bonus_balance').innerText = '0'
                        E('dao_bonus_budget').innerText = '0'
                        stopTalking(3, talk('Removed joining bonus successfully', 'good', id))
                        E('dao_bonus').style.display = "none"
                    }
                    else if(res.status === 'notauth') {
                        stopTalking(3, talk('Only the dao owner can do this', 'fail', id))
                    }
                    else if(res.status === 'notexist') {
                        stopTalking(3, talk('This dao does not exists', 'fail', id))
                    }
                    else {
                        stopTalking(3, talk('Unable to remove joining bonus<br>Something went wrong<br>', 'fail', id))
                    }
                }
                else {
                    talk("Unable to remove joining bonus<br>Something went wrong<br>","fail", id)
                    E('dao_save_button').disabled = false
                    stopTalking(2, id) 
                }
            }
            else {
                E('dao_save_button').disabled = false;
                (id != null) ? stopTalking(1, id) : "";
            }
        }
        if (fileInput.files.length !== 0) {
            E('dao_save_button').disabled = true
            const id = talk("Saving new image")
            modifyAssetImg(dao.code + dao.issuer, async (status) => {
                if (status) {
                    talk("Image updated successfully", "good", id)
                    E('dao_save_image_edit').value = [] //resetting image upload
                } else {
                    talk("Unable to modify image<br>Something went wrong<br>This may be due to network error",
                        "fail", id)
                }
                //time to mint the asset
                await new Promise((resolve) => setTimeout(resolve, 1000));
                saveDesc(id)
            })
        } else {
            saveDesc()
        }
      }
      //to add dao admins
      E('manageAdminConfirm').onclick = async () => {
        const addr = E('dao_search_admin').value.trim()
        if (walletAddress == dao.owner) {
            if (addr != "") {
                if (addr !== dao.owner || true) {
                    if (isSafeToml(addr)) {
                        //check if its already an admin
                        if (dao.admins.includes(addr)) {
                            stopTalking(3, talk("Already an admin", 'warn'));
                            return;
                        }
                        E('manageAdminConfirm').disabled = true
                        //call trustline function
                        const id = talk("Checking address", "norm")
                        await new Promise((resolve) => setTimeout(resolve, 500));
                        talk("Adding admin", "norm", id)
                        if ((await getTokenUserBal(dao.token, addr, CHAIN)) !== false) {
                            //add admin on chain
                            const res = await addAdmin({
                                admin: addr,
                                dao: dao.token,
                                daoName: dao.name
                            })
                            if (res !== false) {
                                stopTalking(3, talk("Admin added successfully", "good", id))
                                dao.admins.push(addr)
                                setUp()
                            } else {
                                talk("Unable to add admin<br>Something went wrong<br>This may be due to network error",
                                    "fail", id)
                                stopTalking(3, id)
                            }
                            E('manageAdminConfirm').disabled = false
                        } else {
                            const msg =
                                "This address is not a memeber of this DAO<br>Please establish a trustline and try again";
                            stopTalking(4, talk(msg, 'fail', id))
                        }
                    } else {
                        const msg =
                            "Invalid characters(\") present in the name.<br> Please remove it and try again";
                        stopTalking(4, talk(msg, 'fail'))
                    }
                } else {
                    const msg = "The Dao onwer is already an admin";
                    stopTalking(4, talk(msg, 'fail'))
                }
            } else {
                const msg = "Empty field present";
                stopTalking(4, talk(msg, 'fail'))
            }
        } else {
            const msg = "Only the owner can do this";
            stopTalking(4, talk(msg, 'fail'))
        }
      }

      validateImageUpload('dao_save_image_edit', 'dao_save_img', 2, (e, url) => {
        optimizeImg(url, 0.9, 400, 400).then((img) => { 
            //update upload file
            logoSaveImg = img
          })
      }) 

      E('manageAdminCheck').oninput = (e) => {
        if(E('manageAdminCheck').checked) {
            E('manageAdminConfirm').style.display = 'flex'
            }
            else{
            E('manageAdminConfirm').style.display = 'none'
            }
        }
       }
       E('view_my_delegate').href=`/user/${walletAddress}?a=delegate`
  }, [])

  useMemo(() => {
      if(modal == 'daoSettings') { setUp()}
  }, [modal])

  const [isChecked, setIsChecked] = useState(false);

  const toggleSwitch = () => {
    setIsChecked(!isChecked);
  };


  return (
    <div className='mb-[5rem] helvetica-font'>
      <SelectChain chain={daoChain.chain} name={daoChain.name} />
      <div className="w-[100%] mx-auto overflow-hidden">
        <div className="bg-cover h-[450px] rounded-none relative" id='dao_cover_image' style={{transition:'backgroundImage 200ms'}}>
            <div className='text-white md:text-[17px] text-[12px] md:mx-[6.5rem] mx-[1rem] px-[1.5rem] mt-[2.3rem] mb-5 inline-flex py-2 items-center gap-1 bg-[#84848459] relative z-10 rounded-full'>
                <a href="/dao">Home </a>
                <BsChevronRight />
                <p id='dao_name_head'></p>
            </div>
            <div className='top-0 h-full w-full absolute daoBg md:pr-[6.5rem] px-[1rem] flex gap-7 pb-[2rem] justify-end items-end text-white'>
                <div className='hidden md:flex flex-col gap-3'>
                    <p>Assets</p>
                    <p id='dao_token_name' className='mr-4'></p>
                </div>
                <div className='hidden md:flex flex-col gap-1'>
                    <p>Website</p>
                    <a id='dao_website' href="#" className='mt-2 block overflow-hidden'></a>
                </div>
                <div className='hidden md:flex flex-col gap-1'>
                    <p>Toml url</p>
                    <a id='dao_token_url' href="#" className='mt-2 block overflow-hidden'></a>
                </div>
                <div className='hidden md:flex flex-col gap-1'>
                    <p>Explorer</p>
                    <a id='dao_explorer_stellar' href='#' className='mt-2 block'></a>
                </div>
            </div>
          {/* Background image */}
        </div>
        <div className="py-4">
            <div className="flex items-start flex-col gap-3 md:ml-[6.5rem] mx-[1rem]">
                <a id='asset_name' href="#" className='p-[4px] bg-[white] md:w-[125px] md:h-[125px] h-[95px] w-[95px] mt-[-65px] rounded-full relative z-[100]'>
                    <div id='dao_verify_badge' className='bg-white p-[3px] rounded-full absolute top-0 right-[5px] text-[22px]'>
                        <RiVerifiedBadgeFill className='text-[#FF7B1C]'/>
                    </div>
                    <img className="w-full h-full rounded-full object-cover" id='dao_image' alt="LumosDAO logo" /> {/* Replace with the path to your logo */}
                </a>
                {/* <h1 className="text-lg font-semibold">{dao.title}</h1> */}
            </div>
            <div className='bg-white md:mt-[4rem] mt-[1.2rem] md:mx-[6.5rem] mx-[1rem] py-6 px-6'>
                <div className='flex justify-between'>
                    <div>
                        <h3 id='dao_name' className="text-lg font-semibold"></h3>
                        <p id='dao_members' className="text-gray-600"></p>
                    </div>
                    <div className='flex items-center gap-3 justify-start'>
                        <div className="card-imgflex-social-link bg-[#000] p-[6px] text-white rounded-full" style={{display:'none'}}>
                            <a id='dao_twitter' href="">
                                <BsTwitterX />
                            </a>
                        </div>
                        <div className="card-imgflex-social-link bg-[#EA0C5F] p-[6px] text-white rounded-full" style={{display:'none'}}>
                            <a id='dao_instagram' href="">
                                <BsInstagram />
                            </a>
                        </div>
                        <div className="card-imgflex-social-link bg-[#5D6BF3] p-[6px] text-white rounded-full" style={{display:'none'}}>
                            <a id='dao_discord' href="">
                                <BsDiscord />
                            </a>
                        </div>
                        <div className="card-imgflex-social-link bg-[#FF4500] p-[6px] text-white rounded-full" style={{display:'none'}}>
                            <a id='dao_reddit' href="">
                                <BsReddit />
                            </a>
                        </div>
                        <div className="card-imgflex-social-link bg-[#3AABE1] p-[6px] text-white rounded-full" style={{display:'none'}}>
                            <a id='dao_telegram' href="">
                                <BsTelegram />
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <p id='dao_about' className="my-7 text-gray-700"></p>
                    <div className='flex items-center gap-3'>
                        <button style={{display:'none'}} id='dao_bonus' className="px-4 py-2 text-white rounded-[4px] bg-[#FF7B1B] relative">
                            Claim bonus
                        </button>
                        <button style={{display:'none'}} id='dao_set_cover' className="px-4 py-2 text-white rounded-[4px] bg-[#FF7B1B] relative">
                            Set Cover
                        </button>
                        <button style={{display:'none'}} onClick={() => {setModal('daoSettings')}} id='dao_setting' className="px-4 py-2 text-white rounded-[5px] bg-[#FF7B1B] ml-2 relative z-[2]" >
                            Dao Settings
                        </button>
                        <button style={{display:'none'}} id='leaveDao' className="px-4 py-2 bg-orange-500 text-white rounded-[4px] hover:bg-orange-600">
                            Leave Dao
                        </button>
                        <button style={{display:'none'}} id='joinDao' className="px-4 py-2 bg-orange-500 text-white rounded-[4px] hover:bg-orange-600">
                            + Join Dao
                        </button>
                    </div>
                </div>
            </div>
            <div className='bg-white mt-[4rem] md:mx-[6.5rem] mx-[1rem] py-6 px-6'>
                <div className='flex justify-between flex-col'>
                    <div>
                        <h3 className="text-md font-[400]">DAO Admins.</h3>
                    </div>
                    <div className='grid grid-cols-3 gap-3'>
                        {/* <div className='flex items-start gap-3'>
                            <img src="" alt="" />
                            <div>
                                <p>GBGF6Z33IHG5IJ...W5U3EQBBJHDRIX</p>
                                <p>DAO Creator</p>
                            </div>
                        </div> */}
                        <div id='dao_others_address' style={{display:'flex'}}>
            
                        </div>
                    </div>
                </div>
            </div>
          <div className="mt-4 grid xl:grid-cols-4 md:grid-cols-2 grid-cols-1 items-start gap-3 flex-col ">
            {/* <div className='bg-[#EFF2F6] py-3 px-5 font-[600] rounded-[6px] w-full'>
              <p>Website</p>
              <a id='dao_website' href="#" className='text-blue-500 mt-2 block overflow-hidden'></a>
            </div>
            <div className='bg-[#EFF2F6] py-3 px-5 font-[600] rounded-[6px] w-full'>
              <p>Toml url:</p>
              <a id='dao_token_url' href="#" className='text-blue-500 mt-2 block overflow-hidden'></a>
            </div>
            <div className='bg-[#EFF2F6] py-3 px-5 font-[600] rounded-[6px] w-full'>
              <p>Explorer:</p>
              <a id='dao_explorer_stellar' href='#' className='text-blue-500 mt-2 block'></a>
            </div> */}
          </div>
          <div id='dao_verify_warn' className="alert alert-danger m-0 p-2 text-xs w-100" role="alert" style={{display:'none'}}>
                To verify your DAO and Assets,add a distributing wallet and lock your asset issuing account. <a href="#" 
                onClick={($event) => {verifyTheDao()}}>Verify now</a>                   
          </div>
          <div className='flex items-center gap-3 justify-start'>
              <div className="card-imgflex-social-link bg-[#000] p-[6px] text-white rounded-full" style={{display:'none'}}>
                  <a id='dao_twitter' href="">
                    <BsTwitterX />
                  </a>
              </div>
              <div className="card-imgflex-social-link bg-[#EA0C5F] p-[6px] text-white rounded-full" style={{display:'none'}}>
                  <a id='dao_instagram' href="">
                     <BsInstagram />
                  </a>
              </div>
              <div className="card-imgflex-social-link bg-[#5D6BF3] p-[6px] text-white rounded-full" style={{display:'none'}}>
                  <a id='dao_discord' href="">
                     <BsDiscord />
                  </a>
              </div>
              <div className="card-imgflex-social-link bg-[#FF4500] p-[6px] text-white rounded-full" style={{display:'none'}}>
                  <a id='dao_reddit' href="">
                     <BsReddit />
                  </a>
              </div>
              <div className="card-imgflex-social-link bg-[#3AABE1] p-[6px] text-white rounded-full" style={{display:'none'}}>
                  <a id='dao_telegram' href="">
                     <BsTelegram />
                  </a>
              </div>
          </div>
        </div>
      </div>
    
      <div className='flex items-start gap-2 md:mx-[6.5rem] mx-[1rem] sm:p-[1rem] py-[1rem] px-[0.5rem] flex-col lg:flex-row bg-white'>
        <div className='lg:w-[70%] w-full'>
          <div className='flex items-center font-[400]'>
            <button className={ selectedTab === "proposals" ? `border-b border-gradient px-6 py-2 text-[#000000] text-[12px]` : `text-[#98A2B3] px-6 py-2 border-b text-[12px]`} onClick={() => setSelectedTab('proposals')}>Proposals <span id='tab1_count'></span></button>
            <button id='tab3' className={ selectedTab === "members" ? `border-b border-gradient px-6 py-2 text-[#000000] text-[12px]` : `text-[#98A2B3] px-6 py-2 border-b text-[12px]`} onClick={() => setSelectedTab('members')}>Members</button>
            <button className={ selectedTab === "delegates" ? `border-b border-gradient px-6 py-2 text-[#000000] text-[12px]` : `text-[#98A2B3] px-6 py-2 border-b text-[12px]`} onClick={() => setSelectedTab('delegates')}>Delegates</button>
            <button id='tab5' style={{display:'none'}} className={ selectedTab === "review" ? `border-b border-gradient px-6 py-2 text-[#000000] text-[12px]` : `text-[#98A2B3] px-6 py-2 border-b text-[12px]`} onClick={() => setSelectedTab('review')}>Proposals In Review</button>
          </div>
          {
           <div id='proposal_views' style={(selectedTab === 'proposals') ? {}: {display:'none'}} >
           </div>
          }
          {
           <div id='proposal_review' style={(selectedTab === 'review') ? {}: {display:'none'}} >
           </div>
          }
          {
            <div id='dao_users' style={(selectedTab === 'members') ? {}: {display:'none'}} className="p-6 bg-[#F9FAFB] rounded-lg mt-4 grid gap-5">
              
            </div>
          }
          {
            
            <div style={(selectedTab === 'delegates') ? {}: {display:'none'}} >
              <div className='gap-4 bg-[#F9FAFB] w-full p-4 rounded-[6px] mt-4'>
                <div  className='gap-4 flex items-end w-full rounded-[6px]'>
                    <div className='w-full'>
                    <div className='flex items-center justify-between w-full mb-2'>
                      <p>Add Delegate:</p>
                      <a id='view_my_delegate' className='cursor-pointer text-blue-500'>View my delegates</a>
                    </div>
                    <input onInput={($event) =>{searchDelegate($event)}} id='dao_delegate_search' type="text" placeholder='Wallet Address here' className='w-full outline-none border p-3 rounded-[6px]' />
                  </div>
                  <button onInput={($event) =>{searchDelegate($event)}} className='bg-[#DC6B19] px-5 py-3 rounded-[8px] text-white'>Search</button>
                </div>
                <div className="my-4" style={{display:'none'}} id='user_delegates_search'>
                    <div className="mb-2">
                      <span className="text-sm text-green-600 text">Member found</span>
                    </div>
                    <div style={{overflow:'auto', maxHeight:'300px'}} id='searchDelegateResults'>
                    </div>
                </div>
              </div>
              <div id='user_delegates' className='bg-white w-full mt-5 p-4 rounded-[6px]'>
                <div className='w-full flex items-center justify-between mb-5'>
                  <p><span id='user_delegates_no'></span> Delegates on <span id='user_delegate_dao_name' className='text-[#DC6B19]'></span> </p>
                  <p>Delegated by</p>
                </div>
                <div id='user_delegates_view' className='flex flex-col gap-3'>
                  
                </div>
              </div>
            </div>
          }
        </div>

        <div className='lg:w-[30%] flex flex-col w-full'>
            <div className='mb-5 flex justify-between'>
                <p></p>
                <a id='createProposal' href="#" className='bg-[#FF7B1C] px-3 py-2 rounded-[6px] text-white text-[14px] flex items-center gap-2'>
                    <p>Create Proposal</p>
                    <AiOutlinePlusCircle />
                </a>
            </div>
          <div className="p-6 bg-[#F9FAFB] rounded-lg">
            <div className="">
              <div>
                <h2 className="text-lg">Asset</h2>
                <div className="flex items-center mb-5 mt-3">
                    <img id='asset_info_img'
                    className="w-[30px] h-[30px] rounded-full"
                    alt="DAO"
                    />
                    <div className="ml-3">
                        <h3 id='asset_info_name' className="font-[400]"></h3>
                    </div>
                    <div className='text-[#00C241] bg-[#E7F6EC] px-3 py-1 rounded-full flex gap-1 ml-4'>
                        <img src="/images/rate.svg" alt="" />
                        <p id='price_change'></p>
                    </div>
                </div>
              </div>
              <div className="text-sm flex items-center justify-between my-10">
                <div className='text-center'>
                  <p>Marketcap</p>
                  <p id='asset_info_market' className='mt-2 font-[500]'></p>
                </div>
                <div className='text-center'>
                  <p>Holders</p>
                  <p id='asset_info_holders' className='mt-2 font-[500]'></p>
                </div>
                <div className='text-center'>
                  <p>Supply</p>
                  <p id='asset_info_supply' className='mt-2 font-[500]'></p>
                </div>
              </div>
            </div>
            <div id='dao_asset_buy' className="mt-6 flex gap-3 justify-between" style={{display:'none'}}>
              <a id='asset_info_lobstr_link' href="#" className="bg-[#D9D9D9] text-[#000] text-[14px] rounded-[10px] w-full text-center py-[10px] transition-all">Lobstr</a>
              <a id='asset_info_lumen_link' className="border border-[#D9D9D9] text-[#000] text-[14px] rounded-[10px] w-full py-[10px] text-center transition-all">Lumenswap</a>
              <a id='asset_info_scouply_link' className="border border-[#D9D9D9] text-[#000] text-[14px] rounded-[10px] w-full py-[10px] text-center transition-all">Scopuly</a>
              <a id='asset_info_xmagnetic_link' className="border border-[#D9D9D9] text-[#000] text-[14px] rounded-[10px] w-full py-[10px] text-center transition-all">Xmagnetic</a>
            </div>
          </div>
          <div id='topVoters' className="p-3 bg-[#F9FAFB] rounded-lg mt-5">
            <div className="mt-4">
              <div className='flex items-center justify-between mb-5'>
                <p className="font-[400] text-[16px]">Top Voters</p>
                {/* <p className="text-[18px]">Participated in Proposal</p> */}
              </div>
              <div id='topVotersView'></div>
              
            </div>
          </div>
        </div>
      </div>
      {
        <div style={(modal === 'daoSettings') ? {}: {display:'none'}}> 
         <div className="h-full w-full fixed top-0 left-0 z-[99]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setModal('')}></div>
          <div className="bg-white md:w-[700px] w-[80%] h-[90dvh] overflow-y-scroll flex flex-col items-start justify-center fixed top-[50%] left-[50%] px-[40px] py-[2rem] z-[100] login-modal" 
            style={(modal === 'daoSettings') ? {transform: "translate(-50%, -50%)"}: {display:'none', transform: "translate(-50%, -50%)"}}>
            <div className='flex items-start gap-[2rem] flex-col w-full mt-[20rem]'>
                
                {/* <div className='p-[4px] bg-[white]  mt-[-65px] rounded-full relative z-[100]'>
                    <img className="w-full h-full rounded-full object-cover" id='dao_image' alt="LumosDAO logo" />
                </div> */}

                <div className='w-[100px] h-[100px] rounded-full mx-auto relative'>
                    <img id='dao_save_img' className='object-cover rounded-full h-full w-full' src="" alt="Project logo" />
                    <div className='p-2 bg-[#F0F0F0] absolute bottom-[-10px] right-[-10px] cursor-pointer border-4 rounded-full border-white'>
                        <img src='/images/edit.svg' className='' onClick={() => {E('dao_save_image_edit').click()}} />
                    </div>
                    <input id='dao_save_image_edit' type='file' style={{visibility:'hidden'}} />
                </div>
                <div className='text-[14px] grid grid-cols-2 gap-4'>
                    <div>
                        <p>Project Name:</p>
                        <p id='dao_save_name'>USD Coin</p>
                    </div>
                    <div>
                        <p>Asset Code:</p>
                        <p id='dao_save_code'></p>
                    </div>
                    <div>
                        <p>Home domain:</p>
                        <p><a id='dao_save_domain' target='_blank' className='text-blue-600'></a></p>
                    </div>
                    <div>
                        <p>TOML:</p>
                        <p><a id='dao_save_toml' target='_blank' className='text-blue-600'></a></p>
                    </div>
                </div>
                {/* <table className='text-[14px]'>
                    <tbody>
                        <tr>
                            <td className='font-[500] w-[120px]'>Project Name:</td>
                            <td id='dao_save_name' className='pl-[2rem]'>USD Coin</td>
                        </tr>
                        <tr>
                            <td className='py-2 font-[500]'>Asset Code:</td>
                            <td id='dao_save_code' className='pl-[2rem]'></td>
                        </tr>
                        <tr>
                            <td className='py-2 font-[500] w-[130px]'>Home domain:</td>
                            <td className='pl-[2rem]'><a id='dao_save_domain' target='_blank' className='text-blue-600'></a></td>
                        </tr>
                        <tr>
                            <td className='font-[500] py-3'>TOML:</td>
                            <td  className='pl-[2rem]'>
                              <a id='dao_save_toml' target='_blank' className='text-blue-600'></a>
                            </td>
                        </tr>
                    </tbody>
                </table> */}
            </div>
            <div className='mt-10 w-full'>
              <label className='flex items-center gap-1 mb-1'>Description: <PiPencil className='cursor-pointer text-[18px]' onClick={() => setEdit( edit === 'description' ? '' : 'description')}/> </label>
              {
                <>
                <div style={(edit === 'description') ? {}: {display:'none'}} className='flex items-center gap-2'>
                  <input id='dao_save_about_edit' type="text" placeholder='Description' className='border outline-none py-2 px-[6px] rounded-[6px] w-full'/>
                </div>
                <p style={(edit !== 'description') ? {}: {display:'none'}} id='dao_save_about'>Testing</p>
                </>
              }
            </div>
            <div className='mt-10 w-full'>
              <label className='flex items-center gap-1 mb-1'>Website: <PiPencil className='cursor-pointer text-[18px]' onClick={() => setEdit( edit === 'website' ? '' : 'website')}/> </label>
              {
                <>
                <div style={(edit === 'website') ? {}: {display:'none'}} className='flex items-center gap-2 w-full'>
                  <input id='dao_save_website_edit' type="text" placeholder='Website URL' className='border outline-none py-2 px-[6px] rounded-[6px] w-full'/>
                </div>
                <p style={(edit !== 'website') ? {}: {display:'none'}} id='dao_save_website'></p>
                </>
              }
            </div>
            <div className='mt-10 w-full'>
              <label className='flex items-center gap-1 mb-1'>Social Profile</label>
              <div className='flex items-center justify-between gap-5 w-full'>
                <div onClick={() => {
                     saveSocials("twitter")
                }} id='dao_save_twitter' style={{cursor:'pointer'}} className='flex justify-center items-center gap-1 bg-[#000] text-white py-2 px-4 rounded-[6px] w-full text-center'>
                  <BsTwitterX />
                  <p id='dao_save_twitter_div'>Connect X</p>
                </div>
                <div id='dao_save_telegram' className='flex items-center gap-1 bg-[#1DA1F2] text-white py-2 px-4 rounded-[6px] w-full text-center'>
                      <LoginButton
                        botUsername={process.env.NEXT_PUBLIC_TELEGRAM_BOT_USERNAME}
                        buttonSize="medium"  
                        cornerRadius={5}  
                        showAvatar={true} 
                        lang="en"
                        onAuthCallback={(user) => {
                          saveSocials('telegram',user)
                       }}
                    />
                </div>
                <div onClick={() => {
                     saveSocials("reddit")
                }} id='dao_save_reddit'  style={{cursor:'pointer'}} className='flex justify-center items-center gap-1 bg-[#FF5700] text-white py-2 px-4 rounded-[6px] w-full text-center'>
                  <BsReddit />
                  <p id='dao_save_reddit_div'>Connect Reddit</p>
                </div>
              </div>
            </div>

            <div className='mt-10'>
              <p className='mb-[6px]'>Who can create proposals?</p>
              <div>
                <input id='dao_setting_proposal_every' type="radio" name="create_proposal" className='mr-[6px]' />
                <label>Everyone</label>
              </div>
              <div>
                <input id='dao_setting_proposal_admin' type="radio" name="create_proposal" className='mr-[6px]' />
                <label>Only DAO Admins</label>
              </div>
            </div>
            <div id='dao_admin_lists'>

            </div>
            <div className='mt-10 w-full border-b pb-5'>
              <label className='flex items-center gap-1'>Add Admins: <PiPencil className='cursor-pointer'  onClick={() => {
                if(E('addAdminInputField').style.display == 'none'){E('addAdminInputField').style.display='flex'}
                else {E('addAdminInputField').style.display='none'}
                }}/>
             </label>

                <div id='addAdminInputField' className='text-[13px] w-full flex-col'>
                  <div className='flex items-start gap-2 flex-col w-full'>
                    <input onInput={($event) => {searchAdminUser($event)}} id="dao_search_admin"  type="text" placeholder='Address' className='border outline-none py-2 px-[6px] rounded-[6px] w-full' />
                    <button onClick={($event) => {searchAdminUser($event)}} className='bg-[#FFF9F5] text-[#FF7B1B] py-2 px-4 rounded-[10px]'>Add Admin</button>
                  </div>
                  <div id='addNewAdmin' className='mt-4'>
                    <p className='mb-1'>Address found:</p>
                    <div id='dao_search_admin_result'  className=' gap-1 w-full'>
                    
                    </div>
                    <div className='flex items-center justify-between'>
                      <div className='flex items-center gap-3 mt-3' id='dao_admin_rules'>
                        <input type="checkbox" id='manageAdminCheck' />
                        <p>I've read and agree to the <span className='underline text-blue-400 cursor-pointer'>terms and condition</span> </p>
                      </div>
                      <button id='manageAdminConfirm' className='bg-[#DC3446] py-2 px-2 rounded-[6px] mt-2 text-white' style={{display:'none'}}>Approve</button>
                    </div>
                  </div>
                </div>
             </div>

            <div className='w-full' id='is_dao_bonus_parent'>
              <div className='mt-10 flex items-center justify-between'>
                <div>
                    <p className='flex items-center gap-1'>DAO Joining Bonus</p>
                    <p className='text-[#828282] w-[60%] font-[300] text-[14px]'>Give a bonus to new members as they join in order to incentivise them to invite more people</p>
                </div>
                {/* <input id='is_dao_bonus_set'  type="checkbox" /> */}
                <label className="relative inline-block w-14 h-8 cursor-pointer">
                <input
                    type="checkbox"
                    id='is_dao_bonus_set'
                    checked={isChecked}
                    onChange={toggleSwitch}
                    className="sr-only"
                />
                <div
                    className={`w-full h-full rounded-full transition duration-300 ${
                    isChecked ? "bg-[#FF7B1B]" : "bg-gray-300"
                    }`}
                ></div>
                <div
                    className={`absolute top-1 left-1 w-6 h-6 bg-white rounded-full shadow-md transition-transform duration-300 transform ${
                    isChecked ? "translate-x-6" : ""
                    }`}
                ></div>
                </label>
              </div>
              <div id='dao_bonus_view' className="mt-5 flex-wrap w-100 gap-3 w-full" >
                <div className='flex gap-3'>
                    <div className="balance text-xs text-[#9C9C9C]"><span id='dao_bonus_name'></span> bonus balance : <span id='dao_bonus_balance' style={{fontSize: 'small', color:'#9c9a9a'}}></span></div>
                    <div className="balance text-xs text-[#9C9C9C]"><span id='dao_bonus_name'></span> Reward per member : <span id='dao_bonus_budget' style={{fontSize: 'small', color:'#9c9a9a'}}></span></div>
                </div>
                <div className="flex flex-col my-5 w-full" style={{marginTop:'10px'}}>
                    <p for="rewardBalance" className="text-[14px] text-muted">Add to bonus balance</p>
                    <input type="number" className='border outline-none py-2 px-[6px] rounded-[6px] w-full' id="rewardBalance" placeholder="Enter amount" />
                </div>
                <div className="flex flex-col mb-3 w-full">
                    <label for="rewardAmount" className="text-[14px] text-muted">Set reward (per member)</label>
                    <input type="number" className='border outline-none py-2 px-[6px] rounded-[6px] w-full' id="rewardAmount" placeholder="Enter amount" />
                </div>
              </div>
            </div>
            <div className='mt-10'>
              <button id='dao_save_button' className='bg-[#FF7B1B] text-white py-2 px-5 rounded-[5px]'>Save Settings</button>
            </div>
          </div>
        </div>
      }

{
        <div style={(modal === 'socials') ? {}: {display:'none'}}>
            <div className="h-full w-full fixed top-0 left-0 z-[99]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setModal(false)}></div>
            <div className="bg md:w-[600px] w-[80%] flex flex-col items-center justify-center fixed top-[50%] left-[50%] pb-[4rem] rounded-[15px] z-[100] login-modal" 
             style={(modal === 'socials') ? {transform: "translate(-50%, -50%)"}: {display:'none', transform: "translate(-50%, -50%)"}}>
              <div className="bg-white rounded-lg shadow-lg md:w-[700px] w-full p-6">
                <div className="flex justify-between items-center border-b">
                  <h2 className="text-xl">Share DAO</h2>
                  <button onClick={() => setModal('')} className="text-gray-500 hover:text-gray-700">
                    &times;
                  </button>
                </div>
                <div className="mt-4 text-center">
                  <h3 className="text-lg font-medium">Invite your community</h3>
                  <p className="text-sm text-gray-600">
                    Your members are the backbone of your project, fueling collaboration, decision-making, and growth. Connect, collaborate, and create a vibrant ecosystem together.
                  </p>
                </div>
                <div className="my-8 flex justify-between">
                  {/* Social Media Icons */}
                  <button onClick={() => {shareFunctions()}} className="text-blue-600 hover:opacity-75">
                    <FaFacebook className='text-[40px]'/>
                  </button>
                  <button onClick={() => {shareFunctions("linkedin")}} className="text-blue-500 hover:opacity-75">
                    <BsLinkedin className='text-[40px]'/>
                  </button>
                  <button onClick={() => {shareFunctions("whatsapp")}} className="text-green-500 hover:opacity-75">
                    <BsWhatsapp className='text-[40px]'/>
                  </button>
                  <button onClick={() => {shareFunctions("twitter")}} className="text-black hover:opacity-75">
                    <BsTwitterX className='text-[40px]'/>
                  </button>
                  <button onClick={() => {shareFunctions("reddit")}}  className="text-orange-600 hover:opacity-75">
                    <BsReddit className='text-[40px]'/>
                  </button>
                </div>
                <div className="mt-4">
                    <p>Copy Text</p>
                  <div className="bg-gray-100 text-gray-700 rounded-lg flex items-center justify-between p-2">
                    <p id="shareLink" className="truncate" ></p>
                    <button onClick={() => {copyLink(E("shareLink").innerHTML)}} className="text-gray-500 hover:text-gray-700">
                      <BiCopy />
                    </button>
                  </div>
                </div>
              </div>
            </div>
        </div>
      }


      {
            delegators &&
            <div>
                <div className="h-full w-full fixed top-0 left-0 z-[99]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setDelegators(false)}></div>
                <div className="bg-white md:w-[600px] w-[80%] flex flex-col items-start fixed top-[50%] left-[50%] pb-[1rem] rounded-[15px] z-[100] login-modal" style={{ transform: "translate(-50%, -50%)" }}>
                    <div className='flex items-center justify-between pt-3 px-6 w-full border-b'>
                        <p className='text-[22px] font-[500]'>Delegators</p>
                        <p onClick={() => setDelegators(false)} className='text-gray-500 text-[28px] cursor-pointer'>&times;</p>
                    </div>
                    <div className='flex items-start justify-start flex-col gap-5 px-[20px] mb-3 pb-4 w-full'>
                       {
                        innerDelegates.map((item, index) => (
                            <div  key={index} className='flex items-center gap-2 mb-1 text-[14px] my-3'>
                            <img src={API_URL + "user_img&user=" + item.user} alt="" className='w-[30px] rounded-full' />
                                <p>{item.user}</p>
                            </div>
                        ))
                       } 
                      
                    </div>
                </div>
            </div>
        }

    </div>
  )
}

export default AboutDAO


 