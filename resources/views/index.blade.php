@extends('layouts.app')

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
                        <div id='num_of_dao' class="card-number"></div>
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
                        <div id='num_of_user' class="card-number"></div>
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
                        <div id='num_of_proposal' class="card-number"></div>
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
                        <div id='num_of_votes' class="card-number"></div>
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
                            <select>
                                <option disabled selected value value="">Sort by Proposals</option>
                                <option value="asc">Date added</option>
                                <option value="desc">Number of Proposals</option>
                            </select>
                            <a href="{{ route('dao.create') }}" class="btn btnCreate">
                                Create DAO <img class="plu" src="{{ asset('images/11.png') }}" alt="">
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
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card-join cardShow">
                        <a href="{{ route('dao', 1) }}" class="text-decoration-none">
                            <div class="lblJoin">
                                <p class="mb-0">join</p>
                            </div>
                            <div style="margin: -20px !important;" class="">
                                <img  class="h-100 w-100 rounded" src="https://plus.unsplash.com/premium_photo-1700984292453-732e26d205fa?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8" alt="">
                            </div>
                            <div class="card-imgflex">
                                <img src="{{ asset('images/demi.jpg') }}" alt="Apple">
                            </div>
                            <div class="cardHeading">
                                    <p class="card-heading">Apple</p>
                             </div>
                            <div class="card-paragraph">
                                A tech giant renowned for its iconic products like iPhones, iPads, and Macs, Apple combines cutting-edge technology with elegant design to shape the consumer electronics industry.
                            </div>

                           <div class="d-flex justify-content-center align-items-center gap-2">
                           <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active propsal</p>
                           </div>
                            <div class="d-flex justify-content-between">
                                <div class="card-small-div cardShowSmall w-100">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                                <div class="card-small-div cardShowSmall w-100">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card-join cardShow">
                        <a href="{{ route('dao', 1) }}" class="text-decoration-none">
                            <div class="lblJoin">
                                <p class="mb-0">join</p>
                            </div>
                            <div style="margin: -20px !important;" class="">
                                <img  class="h-100 w-100 rounded" src="https://plus.unsplash.com/premium_photo-1700984292453-732e26d205fa?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8" alt="">
                            </div>
                            <div class="card-imgflex">
                                <img src="{{ asset('images/demi.jpg') }}" alt="Google">
                               
                            </div>
                            <div class="cardHeading">
                                    <p class="card-heading">Google</p>
                                </div>
                            <div class="card-paragraph">
                                Google offers a range of services including its renowned search engine, Google Search, along with popular platforms like Google Maps, Gmail, and YouTube, revolutionizing the way people access information and connect online.
                            </div>

                            <div class="d-flex justify-content-center align-items-center gap-2">
                           <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active propsal</p>
                           </div>

                            <div class="d-flex justify-content-around">
                                <div class="card-small-div cardShowSmall w-100">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                                <div class="card-small-div cardShowSmall w-100">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card-join cardShow">
                        <a href="{{ route('dao', 1) }}" class="text-decoration-none">
                            <div class="lblJoin">
                                <p class="mb-0">join</p>
                            </div>
                            <div style="margin: -20px !important;" class="">
                                <img  class="h-100 w-100 rounded" src="https://plus.unsplash.com/premium_photo-1700984292453-732e26d205fa?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyfHx8ZW58MHx8fHx8" alt="">
                            </div>
                            <div class="card-imgflex">
                                <img src="{{ asset('images/demi.jpg') }}" alt="Amazon">
                            </div>
                            <div class="cardHeading">
                                    <p class="card-heading">Amazon</p>
                                </div>
                            <div class="card-paragraph">
                                The world's largest online retailer, Amazon has transformed the retail landscape with its vast product selection, convenient shopping experience, and fast delivery services.
                            </div>

                            <div class="d-flex justify-content-center align-items-center gap-2">
                           <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active propsal</p>
                           </div>

                            <div class="d-flex justify-content-around">
                                <div class="card-small-div cardShowSmall w-100">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                                <div class="card-small-div cardShowSmall w-100">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row" id='daoView'>
                <div style='font-size:20px; margin:60px 0px; '><center>Getting DAOs...</center></div>
            </div>
        </div>
    </section>
    <script>
        /* INDEX FUNCTIONS GO HERE */
        /* RETRIEVE THE DAO GENERAL INFORMATION */
        const indexMain = async () => {   
            const daoMeta = await getDaoMetadata() 
            if(daoMeta.length == 0 || daoMeta == []) {
                //empty results
                E('num_of_dao').innerHTML = E('num_of_user').innerHTML = E('num_of_votes').innerHTML = E('num_of_proposal').innerHTML = '0'
                E('daoView').innerHTML = "<center>Be the first to create a DAO</center>"
            }
            else {
                E('num_of_dao').innerHTML = daoMeta['dao']
                E('num_of_user').innerHTML = daoMeta['users']
                E('num_of_votes').innerHTML = daoMeta['votes']
                E('num_of_proposal').innerHTML = daoMeta['proposal']
                //load individual dao data
                let atoken 
                if(daoMeta['daos'] != undefined){
                    if(daoMeta['daos'].length > 0) {
                        E('daoView').innerHTML = "<center>Loading DAOs...</center>"
                        const tmr = setInterval(async () => {
                            let dao = daoMeta['daos'].pop(); 
                            if(dao != undefined && dao != "") {
                                dao = await getDao(dao)  
                                if(dao['proposals'] != undefined) {
                                    //append
                                    const hasJoined = await getTokenUserBal(dao.token, walletAddress)
                                    if(hasJoined === false) {dao.ismember = false}else{dao.ismember = true}
                                    if(E('daoView').innerHTML == "Loading DAOs..."){E('daoView').innerHTML = ""}
                                    E('daoView').appendChild(drawDaoDiv(dao))
                                }
                            }
                            //stop timer if all dao data has been read
                            if(daoMeta['daos'].length == 0) clearInterval(tmr)
                        }, 5)
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
        const joinDao = async (event, code, issuer, name) => {
            event.stopPropagation(); 
            const id = talk('Joining ' + name + ' dao')
            const res = await createTrustline(code, issuer, walletAddress)
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
        function drawDaoDiv(daoParams){
            let _div = document.createElement('div');
            _div.innerHTML = `<div class="col-lg-4 col-md-6 col-sm-12" style='margin-bottom:20px'>
                    <div class="card-join cardShow">
                            <div class="lblJoin" style='cursor:pointer' onclick="${(daoParams.owner == walletAddress) ? "Owner" : (!daoParams.ismember) ? "joinDao(event,'" +  daoParams.code + "','" + daoParams.issuer + "','" + daoParams.name + "')" : ""}">
                                <p class="mb-0">${(daoParams.owner == walletAddress) ? "Owner" : (daoParams.ismember) ? "Joined" : "Join"}</p>
                            </div>
                        <a href="/dao/${daoParams.token || ""}" class="text-decoration-none">
                            <div class="card-imgflex">
                                <img src="${daoParams.image + "?id=" + Math.random() }" alt="StellarBuds">
                                <div class="cardHeading">
                                    <p class="card-heading">${daoParams.name || ""}</p>
                                </div>
                            </div>
                            <div class="card-paragraph">
                               ${daoParams.description || ""}
                            </div>

                            <div class="cardCircle">
                                <p>${daoParams.active_proposals || 0}</p>
                            </div>
                            <p class="circleP">Active proposal</p>

                            <div class="d-flex justify-content-around">
                                <div class="card-small-div cardShowSmall">
                                    <p class="card-bold-word">${daoParams.members || 0}</p>
                                    <p class="card-link">Members</p>
                                </div>
                                <div class="card-small-div cardShowSmall">
                                    <p class="card-bold-word">${daoParams.proposals.length || 0}</p>
                                    <p class="card-link">Proposals</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>`
            return _div.firstElementChild
        }
        indexMain() //run main function
    </script>
@endsection
