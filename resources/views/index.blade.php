@extends('layouts.app')
<?php
    //load the dao meta funtion to avoid lag in frontend
    $path = substr(__FILE__, 0, strpos(__FILE__, 'storage'));
    require("$path.well-known/config.php");
    require("$path.well-known/db.php");
    if(isset($_COOKIE['wallet'])){
        $user = $_COOKIE['wallet'];
        $res = array(); 
        //get number of users
        $query = "SELECT * FROM daos ORDER BY ID DESC";
	    $result = mysqli_query($conn, $query);
	    $a_user = "";
	    $res['daos'] = mysqli_num_rows($result);
	    $i=0; 
	    if(mysqli_num_rows($result)>0){
	        while($row= mysqli_fetch_array($result)){
	            $user = explode(",", $row['users'] . "," . $row['issuer']);
	            foreach($user as $id) { 
                    $id = preg_replace('/[^0-9a-zA-Z]+/', '', $id);
                    if($id != "") {
                        if(!(strpos($a_user, $id) > -1)) {
                            //add and count
                            $a_user .= $id;
                            $i++;
                        }
                    }
                }
            }
	    }
	    $res['users'] = $i;
	    $query = "SELECT * FROM proposals";
	    $result = mysqli_query($conn, $query);
	    $i = mysqli_num_rows($result);
	    $res['proposals'] = $i;
    }
?>
@section('content')
    <section class="squareCards">
        <div class="container">
            <div class="row">
                <div class="Platfarm-stats_title">
                        <div class="heading">Platform Stats</div>
                       <p class="text-muted">Discover the impressive reach of LumosDAO through key statistics: from the number of thriving DAOs to engaged users, proposals submitted, and the collective voice of votes cast.</p>
                    </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div id='num_of_dao' class="card-number"><?php echo number_format($res['daos']); ?></div>
                        <div class="card-heading d-flex gap-1">
                            <span>Number of DAOs</span>
                            <button type="button" class="border-0 bg-transparent d-flex align-items-center justify-content-center text-secondary" data-toggle="tooltip" data-placement="right" title="Count of active community-driven organizations">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div id='num_of_user' class="card-number"><?php echo number_format($res['users']); ?></div>
                        <div class="card-heading d-flex gap-1">
                            <span>Number of users</span>
                            <button type="button" class="border-0 bg-transparent d-flex align-items-center justify-content-center text-secondary" data-toggle="tooltip" data-placement="top" title="Total members contributing their voice">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div id='num_of_proposal' class="card-number"><?php echo number_format($res['proposals']); ?></div>
                        <div class="card-heading d-flex gap-1">
                          <span>  Number of proposals</span>
                          <button type="button" class="border-0 bg-transparent d-flex align-items-center justify-content-center text-secondary" data-toggle="tooltip" data-placement="top" title="Total ideas and initiatives suggested">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div id='num_of_votes' class="card-number">0</div>
                        <div class="card-heading d-flex gap-1">
                            <span>Number of votes</span>
                            <button type="button" class="border-0 bg-transparent d-flex align-items-center justify-content-center text-secondary" data-toggle="tooltip" data-placement="top" title="Sum of democratic decisions cast">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id='daoViewHead' class="propFilter">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="propFilterInner justify-content-end">

                        <div class="sort-by-filter">
                            <span class="sort-by">Sort by</span>
                            <select oninput='sortDao(event)'>
                                <option disabled selected value value="">Sort by Proposals</option>
                                <option value="date">Date added</option>
                                <option value="num">Number of Proposals</option>
                                <option value="active">Active Proposals</option>
                            </select>
                            <a href="{{ route('dao.create') }}" class="btn btnCreate">
                                Create DAO <img class="plu" src="{{ asset('images/11.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="Platfarm-stats_title">
                        <div class="heading">Active DAOs</div>
                       <p class="text-muted">Browse through the list of active DAOs on LumosDAO, each with its own projects, members, and proposals.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id='daoViewParent' class="cardDisplay">
        <div class="container">
            <div class="row" id='daoView'>
                <div style='font-size:20px; margin:60px 0px; '><center>Getting DAOs...</center></div>
            </div>
        </div>
    </section>
    <script>
        /* INDEX FUNCTIONS GO HERE */
        /* RETRIEVE THE DAO GENERAL INFORMATION */
        const indexMain = async () => {   
            const daoMeta = await getDaoMetadata(); 
            if(daoMeta.length == 0 || daoMeta == []) {
                //empty results
                E('num_of_dao').innerHTML = E('num_of_user').innerHTML = E('num_of_votes').innerHTML = E('num_of_proposal').innerHTML = '0'
                E('daoView').innerHTML = "<center>Be the first to create a DAO</center>"
            }
            else {
                E('num_of_dao').innerHTML = daoMeta['daos'].length
                E('num_of_user').innerHTML = daoMeta['users'] 
                E('num_of_votes').innerHTML = daoMeta['votes']
                E('num_of_proposal').innerHTML = daoMeta['proposals']
                //load individual dao data
                let atoken 
                if(daoMeta['daos'] != undefined){
                    if(daoMeta['daos'].length > 0) {
                        E('daoView').innerHTML = "<center>Loading DAOs...</center>"
                         const daos = await getDao(daoMeta['daos'])
                         if(daos.status) {
                             for(let i=0;i<daoMeta['daos'].length;i++) {
                                 if(daos[daoMeta['daos'][i]]['proposals'] != undefined) {
                                    //append
                                    const dao = daos[daoMeta['daos'][i]];
                                    if(dao.joined === false) {dao.ismember = false}else{dao.ismember = true}
                                    if(E('daoView').innerHTML == "<center>Loading DAOs...</center>"){E('daoView').innerHTML = ""}
                                    E('daoView').appendChild(await drawDaoDiv(dao))
                                }
                             }
                         }
                    }
                    else{
                        E('daoView').innerHTML = "<div style='font-size:20px; margin:60px 0px; '><center>No DAO created yet<br>Be the first to create a DAO.</center></div>"
                    }
                }
                else {
                     E('daoView').innerHTML = "<div style='font-size:20px; margin:60px 0px;'><center>No DAO created yet<br>Be the first to create a DAO.</center></div>"
                }
            }
        }
        
        /** To Join Dao 
         * @params {daoAddress} String
        **/
        const joinDao = async (event, code, issuer, name, daoId) => {
            event.stopPropagation(); 
            const id = talk('Joining ' + name + ' dao')
            const res = await createTrustline(code, issuer, walletAddress, name, daoId)
            if(res === false) {
                talk('Something went wrong<br>This may be due to network error', 'fail', id)
            }
            else {
                talk('Joined ' + name + ' successfully', 'good', id)
                //show that it has joined
                const elem = event.target
                if(elem.nodeName == 'DIV') {
                    elem.innerHTML = '<p class="mb-0">Joined</p>'
                }
                else {
                   elem.innerHTML = 'Joined' 
                }
            }
            stopTalking(4, id) 
        } 
        /* UTILS *.
        /** Sort Dao */
        const sortDao = (event) => {
            const sortType = event.target.value
            const daoView = E('daoView');
            const daos = Array.from(daoView.children);
            //sort it
            daos.sort((a, b) => {
                // Parse DAO data from data attribute
                const daoA = JSON.parse(a.getAttribute('data') || '{}');
                const daoB = JSON.parse(b.getAttribute('data') || '{}');
                //check sort type
                if (sortType === 'date') {
                    // Convert created dates to Date objects for comparison
                    const dateA = daoA.created * 1;
                    const dateB = daoB.created * 1;
                    // Sort by date (newest to oldest)
                    return dateB - dateA;
                }
                else if (sortType === 'num') {
                    //proposals comparison
                    const propA = daoA.proposals * 1;
                    const propB = daoB.proposals * 1;
                    // Sort by date (much to least)
                    return propB - propA;
                }
                else if (sortType === 'active') {
                    // Convert created dates to Date objects for comparison
                    const actA = daoA.active * 1;
                    const actB = daoB.active * 1;
                    // Sort by date (much to least)
                    return actB - actA;
                }
                //for no sort type founds
                return 0;
            });
           //Reorder the children based on the sorted daos array
           daos.forEach(dao => daoView.appendChild(dao));
        }
        
        /* DRAWA */
        async function drawDaoDiv(daoParams){ 
            let _div = document.createElement('div');
            const coverImgx =  daoParams.cover
            //fetch all the active proposals
            if(daoParams.proposals.length > 0) {
                const props = await getAllProposal(daoParams.proposals, daoParams.token)
                daoParams.active_proposals = 0
                for(let i=0;i<daoParams.proposals.length;i++) {
                    if(props[daoParams.proposals[i]].status == 1) {
                        daoParams.active_proposals++
                    }   
                }
            }
            const sortDetails = {
                created: N(daoParams.created),
                active: N(daoParams.active_proposals),
                proposals:daoParams.proposals.length
            }
            _div.innerHTML = `<div class="col-lg-4 col-md-6 col-sm-12 mb-3"'>
                    <div class="card-join cardShow" onclick='window.location = "{{ route('dao', '') }}/${daoParams.token || ""}"' style='cursor:pointer'>
                            <div class="lblJoin" style='cursor:pointer' onclick="${(daoParams.owner == walletAddress) ? "Owner" : (!daoParams.ismember) ? "joinDao(event,'" +  daoParams.code + "','" + daoParams.issuer + "','" + daoParams.name + "','" + daoParams.token + "')" : ""}">
                                <p class="mb-0">${(daoParams.owner == walletAddress) ? "Owner" : (daoParams.ismember) ? "Joined" : "Join"}</p>
                            </div>
                            <div style="margin: -20px !important;   height: 250px;overflow-y: hidden;" class="">
                                <img style="object-fit:cover;" class="h-100 w-100 rounded o" src="${coverImgx}" alt="">
                            </div>
                            <div class="card-imgflex">
                                <img src="${daoParams.image + "?id=" + Math.random() }" alt="Apple">
                            </div>
                            <div class="cardHeading">
                                    <p class="card-heading">${daoParams.name || ""}</p>
                             </div>
                            <div class="card-paragraph line-climb-3">
                                ${daoParams.description || ""}
                            </div>

                           <div class="d-flex justify-content-center align-items-center gap-2">
                           <div class="cardCircle">
                                <p>${daoParams.active_proposals || 0}</p>
                            </div>
                            <p class="circleP">Active ${(daoParams.active_proposals || 0) > 1 ? "proposal" : "proposals"}</p>
                           </div>
                            <div class="d-flex justify-content-between">
                                <div class="card-small-div cardShowSmall w-100">
                                    <p class="card-bold-word">${daoParams.members || 0}</p>
                                    <p class="card-link">${(daoParams.members || 0) > 1 ? "Members" : "Member"}</p>
                                </div>
                                <div class="card-small-div cardShowSmall w-100">
                                    <p class="card-bold-word">${daoParams.proposals.length || 0}</p>
                                    <p class="card-link">${(daoParams.proposals.length || 0) > 1 ? "Proposal" : "Proposals"}</p>
                                </div>
                            </div>
                    
                    </div>
                </div>
                `
            _div.firstElementChild.setAttribute('data', JSON.stringify(sortDetails))
            return _div.firstElementChild
        }
        indexMain() //run main function
    </script>
@endsection