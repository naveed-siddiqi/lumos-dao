@extends('layouts.app')

@section('content')
    <section class="squareCards">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div class="card-number">42</div>
                        <div class="card-heading">Number of DAOs</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div class="card-number">42</div>
                        <div class="card-heading">Number of users</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div class="card-number">42</div>
                        <div class="card-heading">Number of proposal</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="SQcardBox">
                        <div class="card-number">42</div>
                        <div class="card-heading">Number of votes</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="propFilter">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="propFilterInner">
                        <div class="heading">Proposals</div>
                        <div class="sort-by-filter">
                            Sort by
                            <select>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                            <a href="{{ route('dao.create') }}" class="btn btnCreate">
                                Create DAO <img class="plu" src="{{ asset('images/11.png') }}" alt="">
                            </a>
                        </div>
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
                                <img src="{{ asset('images/apple.png') }}" alt="Apple">
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
                                <img src="{{ asset('images/google.png') }}" alt="Google">
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
                                <img src="{{ asset('images/amazon.png') }}" alt="Amazon">
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
