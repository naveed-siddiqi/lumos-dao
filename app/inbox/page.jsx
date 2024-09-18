"use client"

import React, { useEffect, useState } from 'react'
import { API_URL, BACKEND_API, daoContractId } from '../data/constant';
import { io } from 'socket.io-client';
import { fAddr, getAllDaoUsers, getUserInfo } from '../core/getter';
import { stopTalking, talk } from '../components/alert/swal';
import { toElem } from '../core/core';
import { StrKey } from '@stellar/stellar-sdk';


var users = [];var messages = []; var users_conversation = [];var chatIndex = 0;var firstTimeLoad = true;var typingTmr; 
//GET PARAMS
const daoId = daoContractId  
let toWallet = ""; 
let userMeta = [];
let addr = ""
//SOCKET AND VARIABLES
let socket = null; //setting up the socket
let currentUser = ""; let _walletAddress = "";let dte = [0,0,0];
//CONST
const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const Inbox = () => {
   const [usersModal, setUsersModal] = useState(false)

    const setUp = async() => { 
        userMeta = await getAllDaoUsers();
        console.log(userMeta)
        let _usr = []
        if(userMeta) {
            _usr = userMeta.users;
        }
        socket = io(BACKEND_API)
        //set up the connect and disconnect
        socket.on('connect', () => {   
           //do the synchronizing
           socket.emit("register", {api_type:"main", id:addr || _walletAddress, dao:daoId, index:chatIndex}, async (res)=> { 
                if(res.status === true) {
                   //load the messages
                   await loadMessage(res.data)
                   firstTimeLoad = false
                   //check if there is a preset to address
                   //console.log(toWallet)
                   if(toWallet != "") { 
                       selectChat({
                           user:toWallet,
                           mdisplay:fAddr(toWallet, 5)
                       })
                   } 
                }
               else {
                   stopTalking(3, talk("Unable to connect to chat server<br>Please refresh this page", "fail"))
               }
           });
        })
        socket.on('disconnect', () => {   
           //turn off all online and typing flags
           for(let i=0;i<users_conversation.length;i++) {
               const res = users_conversation[i]
               users[res] = undefined //void, to allow reboot
               if(E(res + "_online")) {
                    E(res + '_online').style.display = 'none'
                    //remove the istyping tage,  
                    E(res + '_typing').style.display = 'none'
                }
           }
           E('chatHeadInfo').innerText = ''
        })
        //setting up for the receive message
        socket.on('msg', async (params) => { 
            if(params.msg) {
                params = JSON.parse(formatReadForBroadcast(params))
                ////console.log(params)
                //first check if the message has not been received before
                if(!messages['id']){messages['id'] = []}
                if(!messages['id'].includes(params.id)) {
                    //new messages
                    messages.push(JSON.stringify(params)); let u;
                    if(params.sender != _walletAddress) {u = params.sender}
                    else if(params.receiver != 'all') {u = params.receiver}
                    else {u = "Broadcast Messages"}
                    if(!messages[u]){messages[u] = []}
                    messages[u].push(JSON.stringify(params))
                    messages['id'].push(params.id)
                    chatIndex = params.id
                    await updateDisplay(params)
                    readAllMessages()
                }

            }
        })
        //setting up for the onread alerts
        socket.on('read', (params) => {   
            //update read status  
            if(!messages[params.reader]){messages[params.reader] = []} ; 
            for(let i=0;i<messages[params.reader].length; i++) {
                   const res = JSON.parse(messages[params.reader][i]);
                   if(res.id <= params.id){
                       if(res.sender == _walletAddress) {    
                           res.status = 'read'
                           messages[params.reader][i] = JSON.stringify(res)
                           //edit their info if present in chat display
                           if(E(res.id + 'date')) { 
                            E(res.id + 'date').style.fontWeight = 'bold'
                           }
                           const unread_num = (E('nav_user_inbox').innerHTML.replace(/[^0-9]/g, '') * 1) 
                           E('nav_user_inbox').innerHTML = `(${((unread_num - 1) > -1) ? (unread_num - 1) : 0 })`
                       }
                   }
           }
        })
        //setting up for online users
        socket.on('online', (params) => {    
           //update online status  
           if(E(params.user + "_online")) {
                E(params.user + '_online').style.display = 'block'
           }
           //check if user is in the current display
           if(params.user == currentUser) {
               E('chatHeadInfo').innerText = 'Online'
               //save user online status session
           }
           users[params.user] = 'online' 
        })
        //setting up for offline users
        socket.on('offline', (params) => {   
            //update online status  
            if(E(params.user + "_online")) {
                E(params.user + '_online').style.display = 'none'
                //remove the istyping tage, an offline user can't be typing
                E(params.user + '_typing').style.display = 'none'
            }
            //check if user is in the current display
            if(params.user == currentUser) {
                E('chatHeadInfo').innerText = 'Offline'
            }
            users[params.user] = 'offline' 
        })
        //setting up for typing users
        socket.on('typing', (params) => {    
            //update typing status  
            if(E(params.sender + "_typing")) {
                E(params.sender + '_typing').style.display = 'block'
            }
            //check if user is in the current display
            if(params.sender == currentUser) {
                E('chatHeadInfo').innerHTML = '<em>Typing...</em>'
            }
        })
        //setting up for not typing users
        socket.on('nottyping', (params) => {    
            //update typing status  
            if(E(params.sender + "_typing")) {
                E(params.sender + '_typing').style.display = 'none'
            }
            //check if user is in the current display
            if(params.sender == currentUser) {
                E('chatHeadInfo').innerText =  (users[params.sender]) ? users[params.sender] : ''
            }
        })
        if(_usr.length > 0) {
            users = _usr
           //draw the users list
           for(let i=0;i<users.length;i++) {
                if(users[i] != _walletAddress) {  
                   E('chatUsersList').innerHTML += await drawUser({
                       user:users[i],
                       mdisplay:fAddr(users[i], 5),
                   }, 'compose');
                } 
           }
           
        } 
   }
   const loadMessage = async (msgArr) => { 
       if(msgArr.length > 0) {
           let u='';
           if(firstTimeLoad){
               E('chatList').innerHTML = ''
               E('chatBody').innerHTML = `<center style='margin:auto;height:60vh;display:flex;align-items:center;justify-content:center'>Chat messages will appear here</center>`
               E('sendMessageField').style.display = 'none'
           }
           for(let i=msgArr.length -1;i>=0;i--) {
               //load only the messages
               const res = JSON.parse(msgArr[i])
               if(!messages['id']) {messages['id'] = []} //registering id
               if(!messages['id'].includes(res.id)){ 
                   if(res.sender != _walletAddress) {u = res.sender}
                   else if(res.receiver != 'all') {u = res.receiver}
                   else {u = "Broadcast Messages"} 
                   await addUser(res)
                   if(!messages[u]) {messages[u] = []} //registering messages
                   messages[u].push(formatReadForBroadcast(res))
                   messages['id'].push(res.id)
                   messages.push(msgArr[i])
                   //update the chat index
                   chatIndex = res.id; 
                   await updateDisplay(res)
               }
           }
           readAllMessages() //to read all unread messages in the display
       }
       else if(firstTimeLoad){ //if its a first time load
           E('chatBody').innerHTML = `<center style='margin:auto;height:60vh;display:flex;align-items:center;justify-content:center'>Chat messages will appear here</center>`
           E('chatHead').style.display = 'none !important'
           E('chatList').innerHTML = `<center style='margin:40px'>No chat started</center>`
           E('sendMessageField').style.display = 'none'
       }
   }
   const selectChat = async (chatParams) => {
       //To select a chat
       E('chatHead').style.display = ""
       E('chatHeadDisplay').innerText = (chatParams.user != 'Broadcast Messages')? await showUserInfo(chatParams.user,fAddr(chatParams.user, 6)) : chatParams.user;
       E('chatHeadImage').src = API_URL + "user_img&user=" + chatParams.user
       E('sendMessageField').style.display = ''
       //draw chat on
       let u;E('chatBody').innerHTML = '';dte = [0,0,0];let unread = false;let bunread = false; /*unread flag*/let msgId = 0;
       if(users[chatParams.user]) {
           E('chatHeadInfo').innerText = users[chatParams.user]
           if(E(chatParams.user + "_online")) {
                E(chatParams.user + '_online').style.display = (users[chatParams.user] == 'online') ? 'block' : 'none';
           }
       }
       else {
           //fetch status from server
           socket.emit('isonline', {api_type:"testing",user:chatParams.user}, (status) => {
               users[chatParams.user] = (status.status === true) ? 'online' : 'offline';
               E('chatHeadInfo').innerText = users[chatParams.user]
               if(E(chatParams.user + "_online")) {
                    E(chatParams.user + '_online').style.display = (status.status === true) ? 'block' : 'none';
               }
           })
       }
       currentUser = chatParams.user
       if(messages[chatParams.user]) {
           for(let i=0;i<messages[chatParams.user].length; i++) {
                   //load only the messages
                   const res = JSON.parse(messages[chatParams.user][i])
                   if(res.msg) {
                       const d = new Date(res.date)
                       u = {
                           type:'me', msg:res.msg, date:d,mdisplay:'', status:res.status, id:res.id
                       }
                       if(res.sender != _walletAddress) {
                           u.type = 'other'
                           u.mdisplay = res.sender.substring(0,5) + "..." + res.sender.substring(res.sender.length-6)
                       }
                       if(dte[0] != d.getDate() || dte[1] != d.getMonth() || dte[2] != d.getYear()) {
                           //draw the timeline
                           let day = days[d.getDay()];
                           let month = months[d.getMonth()];
                           let year = d.getFullYear();
   
                           E('chatBody').innerHTML += `
                           <center style='margin:10px 0px'>${day}, ${month} ${year}</center>
                           `
                           dte = [d.getDate(), d.getMonth(), d.getYear()]
                       }
                       //draw the chat
                       E('chatBody').innerHTML += drawChat(u)
                       if(res.status != 'read' && res.sender == currentUser && currentUser.indexOf('Broadcast') == -1) {
                           if(res.receiver == 'all') {bunread = true}
                           else{unread = true}
                           msgId = res.id; //saving the last msg id of the unread message
                       }
                   }
                   
       }
           //if there is an unread message, read it
           if(unread || bunread) {  
               socket.emit('read', {
                   api_type:"testing", sender:currentUser, msgId:msgId, signal:unread
               }, (status) => { 
                   if(status.status === true) {
                       //edit the changes in the array
                       for(let i=0;i<messages[chatParams.user].length; i++) {
                           const res = JSON.parse(messages[chatParams.user][i])
                           if(res.id <= msgId){
                               if(res.sender == currentUser) {
                                   res.status = 'read'
                                   messages[chatParams.user][i] = JSON.stringify(res)
                                   //subtract the equivalent in the inbox alert
                                   const unread_num = (E('nav_user_inbox').innerHTML.replace(/[^0-9]/g, '') * 1) 
                                   E('nav_user_inbox').innerHTML = `(${((unread_num - 1) > -1) ? (unread_num - 1) : 0 })`
                               }
                           }
                       }
                       //remove the unread msg tag
                       const userInfo = E(chatParams.user + '_info')
                       if(userInfo) {
                           userInfo.innerText = ''
                           userInfo.setAttribute('data', 0)
                       }
                       
                   }
               })            
       }
           E('chatBody').scrollTop = E('chatBody').scrollHeight
       }
       else {
           //empty chat
           E('chatBody').innerHTML = `
            <center style='margin:auto;height:60vh;display:flex;align-items:center;justify-content:center'>Start a new chat</center> 
           `   
       }
       //hide modal
       setUsersModal(false)
       E('chatMessage').focus()
       E('chatMessage').scrollIntoView()
   }
   const sendMessage = async () => {
       //check if any user has been place in focus
       if(currentUser != "") {
           //check if any inpput
           const msg = E('chatMessage').value
           E('chatMessage').value = "" //delete value
           if(msg != "") {
              const msgId =  Math.floor(Math.random() * 100000) + ""
              const p = {
                   msg:msg, date:(new Date(Date())), status:'notsent', id:msgId, sender:_walletAddress,
              }
              if(currentUser.indexOf('Broadcast') == -1) {
                   //personal message
                   p.receiver = currentUser;
                   socket.emit('msg', {api_type:"testing", msg:msg, receiver:currentUser}, (status) => {
                       //console.log(status)
                       if(status.status === true) {
                           //has sent
                           p.id = status.id;p.status = 'sent'
                           messages[currentUser][indx] = JSON.stringify(p)
                           messages['id'].push(status.id)
                           if(E(msgId + 'date')){
                               E(msgId + 'date').style.display = ''
                               E(msgId + 'date').innerText = (new Date(status.date)).toLocaleTimeString()
                               E(msgId + 'date').id = status.id + 'date' //change id
                           }
                       }
                       else if(status.status === 'logout') {
                            stopTalking(3, talk("You have been logged out of this chat.<br>This may be due to being logged in on another device", "fail"))
                       }
                   })
                   
              }
              else{
                  p.receiver = 'all'
                   socket.emit('broadcast', {api_type:"testing", msg:msg}, (status) => {
                       //console.log(status) 
                       if(status.status === true) { 
                           //has sent
                           p.id = status.id;p.status = 'sent'
                           messages[currentUser][indx] = JSON.stringify(p)
                           messages['id'].push(status.id)
                           if(E(msgId + 'date')){
                               E(msgId + 'date').style.display = ''
                               E(msgId + 'date').innerText = (new Date(status.date)).toLocaleTimeString()
                               E(msgId + 'date').id = status.id + 'date' //change id
                           }
                       }
                       else if(status.status === 'logout') {
                            stopTalking(3, talk("You have been logged out of this chat.<br>This may be due to being logged in on another device", "fail"))
                       } 
                   })   
              }
              //add messages to list
              if(!messages[currentUser]){messages[currentUser] = []}
              if(messages[currentUser].length == 0) {
                  //zero display
                  E('chatBody').innerHTML = ""
              }
              const d = (new Date(Date()))
              if(dte[0] != d.getDate() || dte[1] != d.getMonth() || dte[2] != d.getYear()) {
                   //draw the timeline
                   let day = days[d.getDay()];
                   let month = months[d.getMonth()];
                   let year = d.getFullYear();
                   E('chatBody').innerHTML += `
                   <center style='margin:10px 0px'>${day}, ${month} ${year}</center>
                   `
                   dte = [d.getDate(), d.getMonth(), d.getYear()]
              }
              E('chatBody').innerHTML += drawChat({
                 type:'me', msg:msg, date:(new Date(Date())), status:'notsent', id:msgId
              })
              //scroll to end
              E('chatBody').scrollTop = E('chatBody').scrollHeight
              //place chat user at top of list
              const _user = E(currentUser + '_user')
              if(_user) {
                  E('chatList').insertBefore(_user, E('chatList').firstElementChild);
              }
              
              if(!messages['id']){messages['id'] = []}
              messages[currentUser].push(JSON.stringify(p))
              const indx =  messages[currentUser].length - 1
              //add user if not present
              await addUser(p, false)
           }
       }
   }
   const updateDisplay = async (msgParams) => {  
       //This one updates the message display    
       if(msgParams.sender == currentUser) {
           //draw message in the message body
           const res=msgParams
           const d = new Date(res.date)
           const u = {
               type:'other', msg:res.msg, date:d, mdisplay: res.sender.substring(0,5) + "..." + res.sender.substring(res.sender.length-6), status:res.status, id:res.id
           }
           if(dte[0] != d.getDate() || dte[1] != d.getMonth() || dte[2] != d.getYear()) {
               //draw the timeline
               let day = days[d.getDay()];
               let month = months[d.getMonth()];
               let year = d.getFullYear();
               E('chatBody').innerHTML += `
               <center style='margin:10px 0px'>${day}, ${month} ${year}</center>
               `
               dte = [d.getDate(), d.getMonth(), d.getYear()]
           }
           let flg = false;
           E('chatBody').innerHTML += drawChat(u)
           E('chatBody').scrollTop = E('chatBody').scrollHeight
           if(E(currentUser + '_user')){
               E('chatList').insertBefore(E(currentUser + '_user'), E('chatList').firstElementChild);
               const userInfo = E(msgParams.sender + '_info')
               userInfo.innerText = msgParams.msg //display the user info message
           }
           else {
               //user is not present, draw user
               await addUser(msgParams, false)
           }
           
       }
       else { 
           if(msgParams.sender != _walletAddress) {msgParams.user = msgParams.sender}
           else if(msgParams.receiver != 'all') {msgParams.user = msgParams.receiver}
           else {msgParams.user = "Broadcast Messages"}
           
           if(!E(msgParams.user + '_user')) {
               //create the user
               await addUser(msgParams, false)
           }
           const userInfo = E(msgParams.user + '_info')
           //not opened, check if the sender is in the list
           if(userInfo){
               if(msgParams.sender != _walletAddress){
                   if(msgParams.status != 'read') {
                       let unreadMsg = ((userInfo.getAttribute('data') || '0') * 1) + 1
                       userInfo.innerText = unreadMsg + " unread messages"
                       userInfo.setAttribute('data', unreadMsg) //save unread messages
                   }
               }
               E('chatList').insertBefore(E(msgParams.user + '_user'), E('chatList').firstElementChild);
           }
       }
   }
   const doIsTyping = () => {
       //to handle is typing for non broadcast messages
       if(currentUser.indexOf('Broadcast') == -1) {
           socket.emit('typing', {api_type:"testing", receiver:currentUser}) //callback not needed
           //clear previous not typing timer
           try{clearInterval(typingTmr)}catch(e){} //catch any errors
           //start timer to send non typing, if no changes occurs within a 1.5 second
           typingTmr = setTimeout(() => {
               socket.emit('nottyping', {api_type:"testing",receiver:currentUser})
           }, 8000)
           
       }
   }
   
   /* UTILITIES */
   const readAllMessages = () => {
       //for current chat user only
       let unread = false;let bunread = false;let msgId;
       if(currentUser.indexOf('Broadcast') == -1 && currentUser != ""){
           for(let i=0;i<messages[currentUser].length; i++) {
               //load only the messages
               const res = JSON.parse(messages[currentUser][i])
               if(res.status != 'read' && res.sender == currentUser) {  
                   if(res.receiver == 'all') {bunread = true}
                   else{unread = true}
                   msgId = res.id; //saving the last msg id of the unread message
               }
            }
           if(unread || bunread) { //console.log(unread, bunread)
               socket.emit('read', {
                   api_type:"testing", sender:currentUser, msgId:msgId, signal:unread
               }, (status) => {  
                   if(status.status === true) {
                       //edit the changes in the array
                       for(let i=0;i<messages[currentUser].length; i++) {
                           const res = JSON.parse(messages[currentUser][i])
                           if(res.id <= msgId){
                               if(res.sender == currentUser) { 
                                   res.status = 'read'
                                   messages[currentUser][i] = JSON.stringify(res)
                                   const unread_num = (E('nav_user_inbox').innerHTML.replace(/[^0-9]/g, '') * 1) 
                                   E('nav_user_inbox').innerHTML = `(${((unread_num - 1) > -1) ? (unread_num - 1) : 0 })`
                               }
                           }
                       }
                       //remove the unread msg tag
                       const userInfo = E(currentUser + '_info')
                       if(userInfo) {
                           userInfo.innerText = ''
                           userInfo.setAttribute('data', 0)
                       }
                       
                   }
               })            
           }
       }
   }
   const formatReadForBroadcast = (params) => {
       if(params.receiver == 'all') {
           //broadcast message
           if(params.status.indexOf(_walletAddress.substring(0,15)) > -1) {
               params.status = 'read'
           }
           else {
               params.status = 'sent'
           }
       }
       return JSON.stringify(params)
   }
   const addUser = async (res, after = true) => {
       let u;
       if(res.sender != _walletAddress) {u = res.sender}
       else if(res.receiver != 'all') {u = res.receiver}
       else {u = "Broadcast Messages"}
       if(!users_conversation.includes(u)) {
           if(users_conversation.length == 0) {
               //empty chat list, clear the display view
               E('chatList').innerHTML = ""
           }
           //draw the chat
           res = toElem(await drawUser({
               user:u,
               mdisplay:(u != 'Broadcast Messages') ? u.substring(0,9) + "..." + u.substring(u.length-9) :u
           }));
           (after) ? E('chatList').appendChild(res) : E('chatList').insertBefore(res,  E('chatList').firstElementChild);
           users_conversation.push(u)
           if(!users[u]) {
               //get its online status
               socket.emit('isonline', {api_type:"testing", user:u}, (status) => {
                   users[u] = (status.status === true) ? 'online' : 'offline';
                   if(E(u + "_online")) {
                        E(u + '_online').style.display = (status.status === true) ? 'block' : 'none';
                   }
               })
           }
           else {
               if(E(u + "_online")) {
                    E(u + '_online').style.display = (users[u] == 'online') ? 'block' : 'none';
               }
           }
       }
   }
   const searchUser = async (e, type = 'chat') => {
       const value = e.target.value.trim() 
       let search; let list;
       if(type == 'chat') {
           search = E('searchList');
           list =   E('chatList');
       }
       else {
           search = E('chatUsersSearchList');
           list =   E('chatUsersList');
       }
       if(value == "") {
           search.style.display = 'none'
           list.style.display = ''
       }
       else { 
           search.style.display = ''
           list.style.display = 'none'
           search.innerHTML = ""
           for(let i=0;i<users.length;i++) {
               if(users[i].toLowerCase().indexOf(value.toLowerCase()) > -1 && users[i] != _walletAddress) {
                   //present 
                   search.innerHTML += await drawUser({
                       user:users[i], mdisplay:fAddr(users[i], 6)
                   }, 'search')
               }
           }
           if(search.innerHTML == "") {
               //new chat, draw the user,only if its a valid address
               if(StrKey.isValidEd25519PublicKey(value)){
                    //draw the user
                    search.innerHTML += await drawUser({
                        user:value, mdisplay:fAddr(value, 6) 
                    }, 'search')
               }
               else{
                    search.innerHTML = `
                    <center style='margin:40px'>Nothing found</center> 
                    `
               }
           }
       }
   }
   const showUserInfo = async (addr, addrDisp) => {
       //to show user info if present
       if(userMeta['users_info'][addr]) {
           return userMeta['users_info'][addr];
       }
       else {
           //fetch the user info
           const usr = await getUserInfo(addr)
           if(usr !== false) {
              if(usr.status) {
                  userMeta['users_info'][addr] = usr['user']['name']
                  return usr['user']['name']
              } 
              else {
                  userMeta['users_info'][addr] = fAddr(addr, 6) //default to address
              }
           }
           return addrDisp;
       }
   }
   const drawUser = async (params, type='chat') => {
       const d = await showUserInfo(params.user, params.mdisplay)
       return `<div  onclick='selectChat(${JSON.stringify(params)})' id='${(type == 'chat') ? params.user : Math.random()}_user' class='flex items-center gap-3 p-3 cursor-pointer hover:bg-gray-100'>
                    <div class='w-[30px]'>
                        <img src="${API_URL + "user_img&user=" + params.user}" class='w-full h-full object-cover rounded-[50px]' />
                    </div>
                    <div>
                        <p>${d}</p>
                        <div class="small" style='display:flex;align-items:center'>
                           <span id='${(type == 'chat') ? params.user : Math.random()}_online' class="fas fa-circle chat-online" style='margin-right:5px;display:none'></span>
                           <span id='${(type == 'chat') ? params.user : Math.random()}_info'></span>
                           <span id='${(type == 'chat') ? params.user : Math.random()}_typing' style='margin-left:5px;display:none'><em>Typing...</em></span>
                           </div>
                    </div>
                </div>`
   }
   const drawChat = (params) => {
    const bold = (params.status == 'read' && params.type == 'me') ? 'bold' : "";
    return ` <div class='w-[340px] flex justify-between ${(params.type == 'me') ? 'ml-auto' : 'mr-auto'}  my-2'>
                            <div class='bg-[#F8F9FA] rounded-[6px] w-[250px] mr-1 px-[16px] py-[8px]'>
                                <p class='text-[#1B1B1B] mb-1 text-left'>You</p>
                                <p class='text-[12px] text-left'>${params.msg}</p>
                            </div>
                            <div class='text-center flex flex-col justify-center items-center gap-1 mr-2'>
                                <img src="${API_URL + "user_img&user=" + walletAddress}" className='w-[10px] h-[10px] rounded-full' style=" width:30px; height:30px; border-radius:50% " alt="" />
                                <p id='${params.id}date' class='text-[12px]' style='display:${(params.status == 'notsent') ? 'none' : ''}; font-weight:${bold}'>
                                  ${params.date.toLocaleTimeString()}
                                </p>
                            </div>
                        </div>`
    }
    useEffect(() => {
        //configure all client rendering here to avoid server side error
        addr = (new URLSearchParams(window.location.search)).get("address");
        _walletAddress = addr || (localStorage.getItem('selectedWallet') || "")
        toWallet = (new URLSearchParams(window.location.search)).get("to") || "";
        window.selectChat = selectChat
        window.walletAddress = _walletAddress
        window.WALLET_TYPE = localStorage.getItem('LUMOS_WALLET') || ""  
        window.E = (id) => document.getElementById(id)     
        setUp()
    },[]) 
  return (
    <div className='px-[3rem] mb-[80px] mt-[40px]'>
        <p className='font-[500] mb-5 text-[26px]'>Inbox</p>
        <div className='border w-full flex items-start rounded-[8px] bg-white relative'>
            <div className='w-[25%] border-r h-[75dvh] overflow-y-scroll'>
                <div className='p-5'>
                    <input onInput={($event) => {searchUser($event)}} type="text" placeholder='Search...' className='border outline-none w-full p-[6px] rounded-[6px] bg-gray-100' />
                    <button onClick={() => setUsersModal(true)} className='bg-[#DC3446] py-[8px] px-4 text-white rounded-[6px] mt-3'>Compose</button>
                </div>
                <div id='searchList' style={{display:'none'}}>
                        
                </div>
                <div  id='chatList'>
                     
                </div>
            </div>
            <div className='w-[75%] h-[75dvh] overflow-y-scroll'>
                <div>
                    <div id='chatHead' className='flex items-center gap-3 p-3 border-b'>
                         <div className='flex items-center gap-3'>
                                    <div className='w-[30px]'>
                                        <img id='chatHeadImage' alt="" className='w-full h-full object-cover rounded-[50px]' />
                                    </div>
                                    <div className='text-[13px]'>
                                        <p id='chatHeadDisplay'></p>
                                        <p id='chatHeadInfo'></p>
                                    </div>
                        </div>
                    </div>
                </div>
                <div id='chatBody' className='text-center flex  h-[55dvh]' style={{flexDirection:'column', overflow:'auto'}}>
                     <center style={{margin:'auto',height:'60vh', display:'flex', alignItems:'center', justifyContent:'center'}}>Getting messages</center> 
                </div>
                <div id='sendMessageField'  className='flex px-6 py-4 border-t absolute w-[75%] bottom-0'>
                    <input  id='chatMessage' onInput={() => {doIsTyping()}} onKeyUp = {() => {if(event.keyCode == 13){sendMessage()}}} type="text" className='p-2 w-full rounded-[6px] border outline-none' placeholder='Type your message here' />
                    <button  onClick ={() => {sendMessage()}}  className='px-4 py-2 ml-2 rounded-[6px] text-white bg-green-700'>Send</button>
                </div>
            </div>
        </div>
            <div className="h-full w-full fixed top-0 left-0 z-[99]" 
                style={(usersModal) ? { background:"rgba(14, 14, 14, 0.58)" } : {display:'none'}} 
                onClick={() => setUsersModal(false)}></div>
                <div className="bg-white md:w-[800px] w-[80%] flex flex-col items-center justify-center fixed top-[50%] left-[50%] pb-[1rem] rounded-[15px] z-[100] login-modal"
                 style={(usersModal) ?{ transform: "translate(-50%, -50%)" }:{display:'none'}}>
                    <div className='w-full h-full'>
                            <div className='fixed p-5 border w-full bg-white'>
                                <input onInput={($event) => {searchUser($event, "users")}} type="text" placeholder='Search...' className='outline border-blue-500 p-2 rounded-[4px] w-full bg-transparent' />
                            </div>
                            <div className='h-[450px] w-full p-5 rounded-[8px] overflow-y-scroll mt-[5rem]'>
                                <div id='chatUsersList' className='flex flex-col gap-1'>
                                    
                                </div>
                                <div id='chatUsersSearchList' className='flex flex-col gap-1' style={{display:'none'}}>
                                </div>
                            </div>
                        </div>
                    </div>
            
    </div>
  )
}

export default Inbox