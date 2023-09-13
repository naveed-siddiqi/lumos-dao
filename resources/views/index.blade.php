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
                        <div class="card-number">42</div>
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
                        <div class="card-number">42</div>
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
                        <div class="card-number">42</div>
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
                        <div class="card-number">42</div>
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

    <section class="propFilter">
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

    <section class="cardDisplay">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card-join cardShow">
                        <a href="{{ route('dao', 1) }}" class="text-decoration-none">
                            <div class="lblJoin">
                                <p class="mb-0">join</p>
                            </div>
                            <div class="card-imgflex">
                                <img src="{{ asset('images/demi.jpg') }}" alt="StellarBuds">
                                <div class="cardHeading">
                                    <p class="card-heading">StellarBuds</p>
                                </div>
                            </div>
                            <div class="card-paragraph">
                                A community-driven initiative bringing together cannabis enthusiasts to discuss cultivation, legalization, and responsible usage.
                            </div>

                            <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active proposal</p>

                            <div class="d-flex justify-content-around">
                                <div class="card-small-div cardShowSmall">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                                <div class="card-small-div cardShowSmall">
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
                            <div class="card-imgflex">
                                <img src="{{ asset('images/demi.jpg') }}" alt="EcoVibe">
                                <div class="cardHeading">
                                    <p class="card-heading">EcoVibe</p>
                                </div>
                            </div>
                            <div class="card-paragraph">
                                Join hands with us to promote eco-friendly practices, share sustainable living tips, and collectively work towards a greener planet.
                            </div>

                            <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active proposal</p>

                            <div class="d-flex justify-content-around">
                                <div class="card-small-div cardShowSmall">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                                <div class="card-small-div cardShowSmall">
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
                            <div class="card-imgflex">
                                <img src="{{ asset('images/demi.jpg') }}" alt="CryptoCrafters">
                                <div class="cardHeading">
                                    <p class="card-heading">CryptoCrafters</p>
                                </div>
                            </div>
                            <div class="card-paragraph">
                                An open community of blockchain enthusiasts, artists, and developers exploring the intersection of crypto and creativity.
                            </div>

                            <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active proposal</p>

                            <div class="d-flex justify-content-around">
                                <div class="card-small-div cardShowSmall">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                                <div class="card-small-div cardShowSmall">
                                    <p class="card-bold-word">17,23</p>
                                    <p class="card-link">Members</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
