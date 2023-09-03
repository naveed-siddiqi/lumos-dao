@extends('layouts.app')

@section('content')
    <section class="squareCards">
        <div class="container">
            <div class="row">
                <div class="Platfarm-stats_title">
                        <div class="heading">Platfarm Stats</div>
                       <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque quos, quibusdam itaque voluptatibus reprehenderit sint odio architecto officia necessitatibus ducimus voluptates deleniti nam perspiciatis rerum, animi numquam. Deserunt, nihil magnam.</p>
                    </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div class="card-number">42</div>
                        <div class="card-heading d-flex gap-1">
                            <span>Number of DAOs</span>
                            <button type="button" class="border-0 bg-transparent d-flex align-items-center justify-content-center text-secondary" data-toggle="tooltip" data-placement="right" title="Tooltip on top">
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
                            <button type="button" class="border-0 bg-transparent d-flex align-items-center justify-content-center text-secondary" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
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
                          <span>  Number of proposal</span>
                          <button type="button" class="border-0 bg-transparent d-flex align-items-center justify-content-center text-secondary" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
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
                            <button type="button" class="border-0 bg-transparent d-flex align-items-center justify-content-center text-secondary" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
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
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                            <a href="{{ route('dao.create') }}" class="btn btnCreate">
                                Create DAO <img class="plu" src="{{ asset('images/11.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="Platfarm-stats_title">
                        <div class="heading">Active DAOs</div>
                       <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. A Deserunt, nihil magnam Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi placeat sed corporis esse at animi fugit qui magni, natus odit amet necessitatibus iure labore sapiente mollitia minima, nisi nam ullam..</p>
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
                                <img src="{{ asset('images/demi.jpg') }}" alt="Apple">
                                <div class="cardHeading">
                                    <p class="card-heading">Apple</p>
                                </div>
                            </div>
                            <div class="card-paragraph">
                                A tech giant renowned for its iconic products like iPhones, iPads, and Macs, Apple combines cutting-edge technology with elegant design to shape the consumer electronics industry.
                            </div>

                            <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active propsal</p>

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
                                <img src="{{ asset('images/demi.jpg') }}" alt="Google">
                                <div class="cardHeading">
                                    <p class="card-heading">Google</p>
                                </div>
                            </div>
                            <div class="card-paragraph">
                                Google offers a range of services including its renowned search engine, Google Search, along with popular platforms like Google Maps, Gmail, and YouTube, revolutionizing the way people access information and connect online.
                            </div>

                            <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active propsal</p>

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
                                <img src="{{ asset('images/demi.jpg') }}" alt="Amazon">
                                <div class="cardHeading">
                                    <p class="card-heading">Amazon</p>
                                </div>
                            </div>
                            <div class="card-paragraph">
                                The world's largest online retailer, Amazon has transformed the retail landscape with its vast product selection, convenient shopping experience, and fast delivery services.
                            </div>

                            <div class="cardCircle">
                                <p>15</p>
                            </div>
                            <p class="circleP">Active propsal</p>

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
