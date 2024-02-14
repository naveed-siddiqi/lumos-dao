@extends('layouts.app')

@section('content')
<main class="content proposal-inbox mt-5 border-0">
    <div class="container heading">
        <div class="Platfarm-stats_title">
            <div class="heading">Inbox</div>
        </div>
    </div>
    <div class="container p-0">
        <div class="card-join cardShow p-0 border-0">
            <div class="row g-0">
                <div class="col-12 col-lg-5 col-xl-3 border-right-inbox font-xs">

                    <div class="px-4-inbox d-none d-md-block">
                        <div class="d-flex flex-column align-items-start">
                            <div class="flex-grow-1 w-100 my-0">
                                <input oninput='searchUser(event)' type="text" class="form-control h-auto py-2 my-3" placeholder="Search...">
                            </div>
                            <div class="mt-0">
                                <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#usersModal">Compose</button>
                            </div>
                        </div>
                    </div>
                    <div id='searchList' style='display:none'>
                        
                    </div>
                    
                     <div id='chatList' style=''>
                        
                    </div>
                    <hr class="d-block d-lg-none mt-1 mb-0">
                </div><div class="col-12 col-lg-7 col-xl-9">
                     <div class="py-2 px-4-inbox border-bottom d-none d-lg-block" id='chatHead' style='display:none !important'>
                        <div class="d-flex align-items-center py-1 gap-3">
                            <div class="position-relative">
                                <img src="{{asset('/images/github-demi.png')}}"
                                    class="rounded-circle mr-1" alt="" width="40" height="40">
                            </div>
                            <div class="flex-grow-1 pl-3">
                                <strong id='chatHeadDisplay'>GDJKD...jHSU97</strong>
                                <div id='chatHeadInfo' class="text-muted small" style='text-transform:capitalize'></div>
                            </div>
                            <div>
                                <button class="btn btn-lg p-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-more-horizontal feather-lg">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg></button>
                            </div>
                        </div>
                    </div>

                      <div style="min-height: 60vh;" class="position-relative font-xs">
                        <div class="chat-messages p-4" id='chatBody'>
                            <center style='margin:auto;height:60vh;display:flex;align-items:center;justify-content:center'>Getting messages</center> 
                            <!-- <div class="chat-message-right mb-4">
                                <div>
                                    <img src="{{asset('/images/github-demi.png')}}"
                                        class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">2:41 am</div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3 inbox-msg">
                                    <div class="font-weight-bold-inbox mb-1">You</div>
                                    Morbi finibus, lorem id placerat ullamcorper, nunc enim ultrices massa, id dignissim
                                    metus urna eget purus.
                                </div>
                            </div>

                            <div class="chat-message-left pb-4">
                                <div>
                                    <img src="{{asset('/images/github-demi.png')}}"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">2:42 am</div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3 inbox-msg">
                                    <div class="font-weight-bold-inbox mb-1">GDJKD...jHSU97</div>
                                    Sed pulvinar, massa vitae interdum pulvinar, risus lectus porttitor magna, vitae
                                    commodo lectus mauris et velit.
                                    Proin ultricies placerat imperdiet. Morbi varius quam ac venenatis tempus.
                                </div>
                            </div> -->

                            </div>
                    </div>
                      <div class="flex-grow-0 py-3-inbox px-4-inbox border-top-inbox">
                        <div class="input-group d-flex align-items-center gap-4">
                            <input id='chatMessage'oninput='doIsTyping()' onkeyup = 'if(event.keyCode == 13){sendMessage()}' type="text" class="form-control rounded" placeholder="Type your message">
                            <div class="d-flex align-items-center mt-2">
                                <button onclick ='sendMessage()' class="btn btn-success px-3 py-2">Send</button>
                            </div>
                        </div>
                    </div>
  
                 
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="usersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
             <div class="modal-content">
                 <div class="flex-grow-1 my-0" style='margin-left:10px;margin-right:10px'>
                    <input oninput='searchUser(event, "users")' type="text" class="form-control h-auto py-2 my-3" placeholder="Search..."> 
                </div>
                <div id='chatUsersList' style='overflow:auto;max-height:400px'>
                    <a id='chatUserBroadcast'  href="#" class="list-group-item list-group-item-action border-0 my-2">
                        <div class="d-flex align-items-start gap-3">
                            <div class="flex-grow-1 ml-3">
                            <img src="{{asset('/images/github-demi.png')}}" 
                                    class="rounded-circle mr-1" alt="" width="40" height="40">
                                Broadcast message
                            </div>
                        </div> 
                    </a>
                </div>
                <div id='chatUsersSearchList' style='overflow:auto;max-height:400px;display:none'>
                </div>
             </div>
        </div>
    </div>
  
    <script src="https://cdn.socket.io/4.7.4/socket.io.min.js"></script> 
    <script>
        /* VARIABLES */
        var users = [];var messages = []; var users_conversation = [];var chatIndex = 0;var firstTimeLoad = true;var isADMIN = false;var typingTmr;
        //GET PARAMS
        const daoId = (new URLSearchParams(window.location.search)).get("dao");
        const daoName = (new URLSearchParams(window.location.search)).get("name");
        let addr = (new URLSearchParams(window.location.search)).get("address");
        //SOCKET AND VARIABLES
        const socket = io('https://173.212.232.150:443'); //setting up the socket
        var currentUser = ""; let _walletAddress = addr || walletAddress;let dte = [0,0,0];
        //CONST
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
           
        
        /* FUNCTIONS */
        const setUp = async() => { 
             //set up the connect and disconnect
             socket.on('connect', () => {  
                //do the synchronizing
                socket.emit("register", {id:addr || _walletAddress, dao:daoId, index:chatIndex}, (res)=> {
                    if(res.status === true) {
                        //load the messages
                        loadMessage(res.data)
                        firstTimeLoad = false
                        //console.log(res.data)
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
             socket.on('msg', (params) => { 
                 if(params.msg) {
                     params = JSON.parse(formatReadForBroadcast(params))
                     //console.log(params)
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
                         updateDisplay(params)
                         readAllMessages()
                     }

                 }
             })
             //setting up for the onread alerts
             socket.on('read', (params) => {  // console.log(params)
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
                            }
                        }
                }
             })
             //setting up for online users
             socket.on('online', (params) => {   //console.log(params)
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
             socket.on('offline', (params) => {   //console.log(params)
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
             socket.on('typing', (params) => {   //console.log(params)
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
             socket.on('nottyping', (params) => {   //console.log(params)
                 //update typing status  
                 if(E(params.sender + "_typing")) {
                     E(params.sender + '_typing').style.display = 'none'
                 }
                 //check if user is in the current display
                 if(params.sender == currentUser) {
                     E('chatHeadInfo').innerText =  (users[params.sender]) ? users[params.sender] : ''
                 }
             })
             const _usr = await getDaoUsersP(daoName); 
             isADMIN = await isAdmin(daoName)
             if(_usr.length > 0) {
                 users = _usr
                 if(isADMIN) {
                    //show broadcast message in compose field
                    E('chatUsersList').innerHTML = drawUser({
                            user:'Broadcast Messages',
                            mdisplay:'Broadcast Messages' 
                    }, 'compose')  
                } 
                //draw the users list
                for(let i=0;i<users.length;i++) {
                     if(users[i] != _walletAddress) {  
                        E('chatUsersList').innerHTML += drawUser({
                            user:users[i],
                            mdisplay:users[i].substring(0,9) + "..." + users[i].substring(users[i].length-9)
                        }, 'compose');
                     }
                }
                
             } 
        }
        const loadMessage = (msgArr) => {
            if(msgArr.length > 0) {
                let u='';
                if(firstTimeLoad){
                    E('chatList').innerHTML = ''
                    E('chatBody').innerHTML = `
                     <center style='margin:auto;height:60vh;display:flex;align-items:center;justify-content:center'>Chat messages will appear here</center> 
                    `
                }
                for(let i=msgArr.length -1;i>=0;i--) {
                    //load only the messages
                    const res = JSON.parse(msgArr[i])
                    if(!messages['id']) {messages['id'] = []} //registering id
                    if(!messages['id'].includes(res.id)){
                        if(res.sender != _walletAddress) {u = res.sender}
                        else if(res.receiver != 'all') {u = res.receiver}
                        else {u = "Broadcast Messages"} 
                        addUser(res)
                        if(!messages[u]) {messages[u] = []} //registering messages
                        messages[u].push(formatReadForBroadcast(res))
                        messages['id'].push(res.id)
                        messages.push(msgArr[i])
                        //update the chat index
                        chatIndex = res.id;
                        updateDisplay(res)
                    }
                }
                readAllMessages() //to read all unread messages in the display
            }
            else if(firstTimeLoad){ //if its a first time load
                E('chatBody').innerHTML = `
                 <center style='margin:auto;height:60vh;display:flex;align-items:center;justify-content:center'>Chat messages will appear here</center> 
                `
                E('chatHead').style.display = 'none !important'
                E('chatList').innerHTML = `
                     <center style='margin:40px'>No chat started</center> 
                `
            }
        }
        const selectChat = (chatParams) => {
            //To select a chat
            E('chatHead').style.display = ""
            E('chatHeadDisplay').innerText =(chatParams.user != 'Broadcast Messages')? chatParams.user.substring(0,9) + "..." + chatParams.user.substring(chatParams.user.length-9) : chatParams.user;
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
                socket.emit('isonline', {user:chatParams.user}, (status) => {
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
                if(unread || bunread) { console.log(unread, bunread)
                    socket.emit('read', {
                        sender:currentUser, msgId:msgId, signal:unread
                    }, (status) => { 
                        if(status.status === true) {
                            //edit the changes in the array
                            for(let i=0;i<messages[chatParams.user].length; i++) {
                                const res = JSON.parse(messages[chatParams.user][i])
                                if(res.id <= msgId){
                                    if(res.sender == currentUser) {
                                        res.status = 'read'
                                        messages[chatParams.user][i] = JSON.stringify(res)
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
            E('usersModal').click()
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
                        socket.emit('msg', {msg:msg, receiver:currentUser}, (status) => {
                            console.log(status)
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
                        socket.emit('broadcast', {msg:msg}, (status) => {
                            console.log(status) 
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
                   addUser(p, false)
                }
            }
        }
        const updateDisplay = (msgParams) => {  
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
                    addUser(msgParams, false)
                }
                
            }
            else {
                if(msgParams.sender != _walletAddress) {msgParams.user = msgParams.sender}
                else if(msgParams.receiver != 'all') {msgParams.user = msgParams.receiver}
                else {msgParams.user = "Broadcast Messages"}
                if(!E(msgParams.user + '_user')) {
                    //create the user
                    addUser(msgParams, false)
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
                socket.emit('typing', {receiver:currentUser}) //callback not needed
                //clear previous not typing timer
                try{clearInterval(typingTmr)}catch(e){} //catch any errors
                //start timer to send non typing, if no changes occurs within a 1.5 second
                typingTmr = setTimeout(() => {
                    socket.emit('nottyping', {receiver:currentUser})
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
                if(unread || bunread) { console.log(unread, bunread)
                    socket.emit('read', {
                        sender:currentUser, msgId:msgId, signal:unread
                    }, (status) => {  
                        if(status.status === true) {
                            //edit the changes in the array
                            for(let i=0;i<messages[currentUser].length; i++) {
                                const res = JSON.parse(messages[currentUser][i])
                                if(res.id <= msgId){
                                    if(res.sender == currentUser) { 
                                        res.status = 'read'
                                        messages[currentUser][i] = JSON.stringify(res)
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
        const addUser = (res, after = true) => {
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
                res = drawUser({
                    user:u,
                    mdisplay:(u != 'Broadcast Messages') ? u.substring(0,9) + "..." + u.substring(u.length-9) :u
                });
                (after) ? E('chatList').innerHTML += res : E('chatList').innerHTML = res + E('chatList').innerHTML ;
                users_conversation.push(u)
                if(!users[u]) {
                    //get its online status
                    socket.emit('isonline', {user:u}, (status) => {
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
        const searchUser = (e, type = 'chat') => {
            const value = e.target.value.trim().toLowerCase()
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
                        search.innerHTML += drawUser({
                            user:users[i], mdisplay:users[i].substring(0,9) + "..." + users[i].substring(users[i].length-9) 
                        }, 'search')
                    }
                }
                if(search.innerHTML == "") {
                    search.innerHTML = `
                    <center style='margin:40px'>Nothing found</center> 
                    `
                }
            }
        }
        const drawUser = (params, type='chat') => {  
            return `<a id='${(type == 'chat') ? params.user : Math.random()}_user' onclick='selectChat(${JSON.stringify(params)})' href="#" class="list-group-item list-group-item-action border-0 my-2">
                        <div class="d-flex align-items-start gap-3">
                            <div class="flex-grow-1 ml-3">
                            <img src="{{asset('/images/github-demi.png')}}"
                                    class="rounded-circle mr-1" alt="" width="40" height="40">
                                ${params.mdisplay}
                                <div class="small" style='display:flex;align-items:center'>
                                <span id='${(type == 'chat') ? params.user : Math.random()}_online' class="fas fa-circle chat-online" style='margin-right:5px;display:none'></span>
                                <span id='${(type == 'chat') ? params.user : Math.random()}_info'></span>
                                <span id='${(type == 'chat') ? params.user : Math.random()}_typing' style='margin-left:5px;display:none'><em>Typing...</em></span>
                                </div>
                            </div>
                        </div>
                    </a>`
                    //
        }
        const drawChat = (params) => {
            const bold = (params.status == 'read' && params.type == 'me') ? 'bold' : "";
            return `<div class="${(params.type == 'me') ? 'chat-message-right mb-4' : 'chat-message-left pb-4'} ">
                                <div>
                                    <img src="{{asset('/images/github-demi.png')}}"
                                        class="rounded-circle mr-1" alt="" width="40" height="40">
                                    <div id='${params.id}date' class="text-muted small text-nowrap mt-2" style='display:${(params.status == 'notsent') ? 'none' : ''}; font-weight:${bold}'>${params.date.toLocaleTimeString()}</div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3 inbox-msg">
                                    <div class="font-weight-bold-inbox mb-1">${(params.type == 'me') ? 'You' : params.mdisplay}</div>
                                     ${params.msg}
                                </div>
                            </div>`
        }
        //setUp
        setUp()
    </script>
</main>
@endsection



<!---->