@extends('layouts.app')
@section('content')
<section>


    <div class="container">
        <div class="d-flex align-items-center justify-content-start flex-wrap mb-3">
            <a class="breadcrumbs" href="">
                Wallet
            </a>
            <span class="mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18px"
                    hiegth="18px">
                    <path fill-rule="evenodd"
                        d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            <a class="breadcrumbs active" href="" id='wallet_name'>
                
            </a>
        </div>
        <div class="">
            <button class="bg-none border-danger rounded px-2 d-block d-xl-none text-danger" id="sideover-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" width="25px" height="px">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                </svg>
            </button>
            <div class="">
                <div class="" id="sideover_menubar">
                    <button id="sideover_close_btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" width="25px" height="25px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </button>
                    <div class="tabs-logo">
                        <img class=""
                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Apple">
                    </div>
                    <div class="text-center w-100 card-join">
                        <div class="cardHeading text-center">
                            <span class="card-heading" id='wallet_name_short'></span>
                        </div>
                        <div class="card-paragraph text-center text-secondary" id='wallet_joined_date'>
                           
                        </div>
                    </div>
                    <div class="tab w-100 mt-5">
                        <button class="tablinks " onclick="openCity(event, 'London')"
                            id="defaultOpenMob">Activity</button>
                        <button class="tablinks " onclick="openCity(event, 'Paris')">Joined <span
                                id='wallet_dao_num'></span></button>
                        <button class="tablinks " onclick="openCity(event, 'Tokyo')">Comments <span
                                id='wallet_comment_num'></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div
                    class="col-sm-3 explorer_card d-none d-xl-flex justify-content-start m-0 align-items-start h-screen mt-4 sticky-top">
                    <div class="tabs-logo">
                        <img class=""
                            src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1599305445671-ac291c95aaa9?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Apple">
                    </div>
                    <div class="text-center w-100 card-join">
                        <div class="cardHeading text-center">
                            <span class="card-heading" id='wallet_name_short_res'></span>
                        </div>
                        <div class="card-paragraph text-center text-secondary" id='wallet_joined_date_res'>
                            <center class='cen' style='height:300px;'>Loading Daos...</center>
                        </div>
                    </div>
                    <div class="tab w-100 mt-5">
                        <button class="tablinks " onclick="openCity(event, 'London')" id="defaultOpen">Activity</button>
                        <button class="tablinks " onclick="openCity(event, 'Paris')">Joined <span id='wallet_dao_num_res'></span></button>
                        <button class="tablinks " onclick="openCity(event, 'Tokyo')">Comments <span id='wallet_comment_num_res'></span></button>
                    </div>
                </div>
                <div id="Paris" class="tabcontent col-sm">
                    <div class="row" id='wallet_my_dao'>
                        <center class='cen' style='margin:50px'>Loading Daos...</center>
                    </div>
                </div>
                <div id="London" class="tabcontent col-sm">
                    <div class="">
                        <div class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4 mt-4">
                            <div style='width:100%' id='tx_info'>
                                <center style='margin:20px'>Loading records..</center>
                            </div>
                            <div class='d-flex' style='flex-direction:row-reverse;width:100%'>
                                <button id='next_tx_info' class='btn' style='display:none'>Next</button>
                                <button id='pre_tx_info' class='btn' style='display:none'>Prev</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="Tokyo" class="tabcontent col-sm">
                    <div class="" >
                        <div class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4 mt-4" >
                            <div id='wallet_my_comment' style='width:100%'>
                                <center class='cen' style='margin:50px'>Loading Comments...</center>
                        </div>
                            <div class="card-join cardHeading" id='wallet_my_comment_butt' style='display:none'>
                                <button class="card-heading border-0 bg-transparent" id="viewAllComments">View All
                                    Comments</button>
                                <button class="card-heading border-0 bg-transparent" id="viewFewComments">View Few
                                    Comments</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div id="newYork1" class="tabcontent col-sm">
                    <div class="tab-pane explorer_card text-left h-auto px-3 px-sm-4 pt-4 pb-4 mt-4">
                        <div class="row mt-0 w-100">
                            <div class="cardEndDiv p-0">
                                <div class="">
                                    <div class="mb-2">
                                        <span class="text text-sm text-secondary text-start">Delegates</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="cardEndDetail">
                                            <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                alt="Profile Image" class="image">
                                            <div class="text text-center">FGDKXQTCPOJVVBBYTCPOJVVBBY2MRK2DXKZANU3I
                                            </div>
                                        </div>
                                        <div class="">
                                            <button type="button"
                                                class="btn btn-danger text-white text d-flex align-items-center gap-2 mb-0">
                                                Stop Delegation
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <style>
            .cen{display:flex;align-items:center;justify-content:center;}
        </style>
    </div>
</section>
<script>
    const uWallet = (new URL(window.location.href)).searchParams.get('x') || walletAddress; // Use your actual URL or replace with the desired URL
    let tx_page_segment = 10;
    let txInfo = []
    let tx_page = 1;
    
    const setUp = async () => {
        //set name
        E('wallet_name').innerHTML = uWallet
        E('wallet_name_short').innerHTML = E('wallet_name_short_res').innerHTML = uWallet.substring(0, 5) + "....." + uWallet.substring(uWallet.length - 5)
        let joined = await getDaoJoinedDate(uWallet);
        if(joined != "") {
            joined = (new Date(joined)).toLocaleString()
            E('wallet_joined_date').innerHTML = E('wallet_joined_date_res').innerHTML = "Member since " + joined
        }
         
        //get user comments
        const comt = await getUserComment(uWallet)
        const [num, daos] = await getDaoJoinedNum(uWallet)
        E('wallet_dao_num').innerHTML = E('wallet_dao_num_res').innerHTML = '(' + num + ')'
        const cnum = await getCommentNum(uWallet)
        E('wallet_comment_num').innerHTML = E('wallet_comment_num_res').innerHTML = '(' + cnum + ')'
        //load comment
        setTimeout(() => {loadComments(comt)}, 1000)
        //load daos
        setTimeout(() => {loadDao(daos)}, 1000)
        //load activity
        setTimeout(() => {loadActivity()}, 1000)
        
    }
    //load comment
    const loadComments = async(comt) => {
        E('wallet_my_comment_butt').style.display = 'none'
        let _commt = ""; 
        if(comt.length > 0) {
            let props = []
            for(let i=0;i<comt.length;i++) {
                 const res = JSON.parse(comt[i])
                if(!props[res.proposal_id]) {
                    //hasnt loaded proposal data, load it
                    props[res.proposal_id] = await getProposal(res.proposal_id)
                    if( props[res.proposal_id] !== false){ 
                        res['proposalName'] =  props[res.proposal_id].name
                        res['voted'] = await getProposalVoterInfo(res.proposal_id * 1, uWallet)
                        res['voted'] = (res['voted'] == 0) ? "none" : (res['voted'] == 1) ? 'Yes' : 'No';
                    }
                }
                else {
                    if( props[res.proposal_id] !== false){
                        res['proposalName'] =  props[res.proposal_id].name
                        res['voted'] = await getProposalVoterInfo(res.proposal_id, uWallet)
                        res['voted'] = (res['voted'] == 0) ? "none" : (res['voted'] == 1) ? 'Yes' : 'No';
                    }   
                }
                const commt = drawComment(res, (i > 4) ? true : false)
                _commt += commt
                if(i > 4) {
                    E('wallet_my_comment_butt').style.display = 'flex'
                }
            }
            //console.log(_commt)
            E('wallet_my_comment').innerHTML = _commt
        }
        else {
             E('wallet_my_comment').innerHTML = "<center class='cen' style='margin:50px'>You have not made any comments</center>"
        }
    }
    //load daos
    const loadDao = async(daos) => {
        //load all the daos
        let _daos = "";
        for(let i=0;i<daos.length;i++) {
            _daos += await drawDao((await getDao(daos[i])))
        }
        if(daos.length == 0) {
            E('wallet_my_dao').innerHTML = "<center class='cen' style='margin:50px'>You have not joined any dao</center>"
        }
        else {
            E('wallet_my_dao').innerHTML = _daos
        }
        
    }
    //load user activity
    const loadActivity = async () => {
        //get all the tx
        txInfo = await getUserTx(walletAddress)
        let j = []
        for(let i=txInfo.length-1; i> -1;i--){
            const t = JSON.parse(txInfo[i])
            if(t.action.toLowerCase().indexOf('joined dao') > -1) {
                if(!j.includes(t.signer)) {
                    //first
                    t.action = 'Joined LumosDao'
                    txInfo.splice(i+1, 0, JSON.stringify(t));
                    j.push(t.signer)
                }
            }
        }
        loadTxInfo()
            //configure the buttons
            E('next_tx_info').onclick = () => {
                if(tx_page < txInfo.length / tx_page_segment){
                  loadTxInfo(tx_page + 1)
                  tx_page++
                }
            }
            E('pre_tx_info').onclick = () => {
                if(tx_page > 1){
                  loadTxInfo(tx_page - 1)
                  tx_page--
                }
            }
    }
    const loadTxInfo = (page = 1) => {
            //to do pagination, segment is 10
            const start_index = (page - 1) * tx_page_segment;
            const end_index = start_index +  tx_page_segment
            //reset view
            E('tx_info').innerHTML = ""
            for(let i=start_index; i<end_index && i < txInfo.length;i++) { 
                E('tx_info').appendChild(drawExp({
                    address:JSON.parse(txInfo[i]).signer,
                    action:JSON.parse(txInfo[i]).action,
                    date:(new Date(JSON.parse(txInfo[i]).date)).toLocaleString(),
                    link:""
                }))
            }
            
            if(end_index >= txInfo.length) {
                //hide next button
                E('next_tx_info').style.display = 'none'
            }
            else {
                E('next_tx_info').style.display = 'block'
            }
            if(start_index == 0) {
                //hide next button
                E('pre_tx_info').style.display = 'none'
            }
            else {
                E('pre_tx_info').style.display = 'block'
            }
            //handle empty txs
            if(E('tx_info').firstElementChild == null) {
                //show empty view
                E('tx_info').innerHTML = `<center style="margin:50px;">No records yet</center>`
            }
            
        }
    //start
    setUp()
    
    const drawDao = async (daoParams = {}) => {
            const coverImgx = daoParams.image.replace((daoParams.code + daoParams.owner), "cover_" + (daoParams.code + daoParams.owner)); 
            const isCoverValid = await isImageURLValid(coverImgx)
            const defCoverImg = 'https://images.unsplash.com/photo-1513151233558-d860c5398176?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            
            let tm = `<div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card-join cardShow mt-4">
                                <a href="{{ route('dao', '') }}/${daoParams.token || ""}" class="text-decoration-none">
                                    <div class="lblJoin">
                                        <p class="mb-0">Joined</p>
                                    </div>
                                    <div style="margin: -20px !important;" class="">
                                        <img class="h-100 w-100 rounded-md"
                                            src="${((isCoverValid) ? coverImgx : defCoverImg) + "?id=" + Math.random() }"
                                            alt="">
                                    </div>
                                    <div class="card-joined text-center">
                                        <img class=""
                                            src="${daoParams.image + "?id=" + Math.random() }"
                                            alt="Apple">
                                    </div>
                                    <div class="cardHeading text-left">
                                        <span class="card-heading">${daoParams.name || ""}</span>
                                    </div>
                                    <div class="card-paragraph text-left">
                                         ${daoParams.description || ""}
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <div class="cardCircle">
                                            <p>${daoParams.active_proposals || 0}</p>
                                        </div>
                                        <p class="circleP">Active ${(daoParams.proposals || 0) > 1 ? "proposal" : "proposals"}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">${daoParams.members || 0}</p>
                                            <p class="card-link">${(daoParams.members || 0) > 1 ? "Members" : "Member"}</p>
                                        </div>
                                        <div class="card-small-div cardShowSmall w-100">
                                            <p class="card-bold-word">LSP</p>
                                            <p class="card-link">Assests</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>`
                        
        
        return tm
                
    }
    const drawExp = (params = {}) => {
        let tm = `<div
                    class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                    <p class="Explorer_p my-auto">${params.address.substring(0, 5) + "....." + params.address.substring(params.address.length - 5)} <a
                            class="Explorer_p_a" h ref="${params.link}"><span class="">${params.action}</span></a> </p>
                    <p class="Explorer_span d-block">${params.date}</p>
                </div>`
        let th = document.createElement('div')
        th.innerHTML = tm
        return th.firstElementChild
    }
    const drawComment = (params, hide=false) => { 
        let th = `<div class="comment form-control border-0 h-auto px-sm-4 py-2  w-100" style='display:${(hide == true) ? 'none': ""}'>
                                <p class="Explorer_p my-auto">
                                    <a class="Explorer_p_a" href=""><span class="d-block">${params.proposalName || ""}</span></a>
                                    ${params.msg || ""}
                                </p>
                                <div
                                    class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100 bg-white">
                                    <p class="Explorer_p my-auto">${uWallet.substring(0, 5) + "....." + uWallet.substring(uWallet.length - 5)} voted <span
                                            class="Explorer_p_a">${params.voted || "none"}</span> on
                                        proposal <a class="Explorer_p_a" href=""><span class="">${params.proposalName || ""}</span></a> </p>
                                    <p class="Explorer_span d-block">${params.date || ""}</p>
                                </div>
                            </div>
                         `
         
        return th           
    }
    /* Page Utilities */
    {
let sideOverBtn = document.getElementById('sideover-btn');
let sideOverCloseBtn = document.getElementById('sideover_close_btn');
let sideOver = document.getElementById('sideover_menubar');
sideOver.style.display = 'none';
sideOverBtn.addEventListener('click', () => {
    sideOver.style.display = 'block';
    document.getElementById("defaultOpenMob").click();
});
sideOverCloseBtn.addEventListener('click', () => {
    sideOver.style.display = 'none';
});

function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();


document.addEventListener('DOMContentLoaded', function() {
    var comments = document.querySelectorAll('.comment');
    var viewAllButton = document.getElementById('viewAllComments');
    var viewFewButton = document.getElementById('viewFewComments');
    viewFewButton.style.display = 'none';

    // Hide comments after the first four initially
    for (var i = 5; i < comments.length; i++) {
        comments[i].style.display = 'none';
    }

    viewAllButton.addEventListener('click', function() {
        // Show all comments
        for (var i = 5; i < comments.length; i++) {
            comments[i].style.display = 'block';
        }
        // Hide the "View All Comments" button and show the "View Few Comments" button
        viewAllButton.style.display = 'none';
        viewFewButton.style.display = 'block';
    });

    viewFewButton.addEventListener('click', function() {
        // Hide comments after the first four
        for (var i = 5; i < comments.length; i++) {
            comments[i].style.display = 'none';
        }
        // Show the "View All Comments" button and hide the "View Few Comments" button
        viewAllButton.style.display = 'block';
        viewFewButton.style.display = 'none';
    });
});
}
</script>
@endsection




