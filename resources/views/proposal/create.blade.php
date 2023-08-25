@extends('layouts.app')

@section('content')
    <section class="leadingBoard">
        <div class="container">
            <div class="row">
                <div class="col-12 ">
                    <div class="heading-board">
                        <p class="headingBoard">Board</p>
                        <span class="rightArrow"> > </span>
                        <p class="headingBoard"> Apple</p>
                        <span class="rightArrow"> > </span>
                        <p class="apple-text">Create proposal</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form method="POST" action="{{ route('dao.proposal.store', $dao->id) }}">
        @csrf
        <section class="proposalText">
            <div class="container">
                <div class="row">
                    <div class="innerPropText">
                        <div class="col-12 ">
                            <div class="warning-box">
                                <span class="warning-icon"><img src="{{ asset('images/war.png') }}" alt=""></span>
                                <p>You need to have a minimum of {{$dao->required_tokens}} {{$dao->asset}} in order to submit a proposal.</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="textProp">
                                {{-- <h2>Proposal Title</h2> --}}
                                <input class="input-filed" type="text" placeholder="Proposal Title" name="title" value="{{ old('title') }}">
                                <textarea class="input-filed" placeholder="Tell more about your proposal (optional)" name="about">{{ old('about') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- <section class="optionsDiv">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Options</h4>
                    </div>
                </div>
                <div class="optionsInnerDiv">
                    <div class="row">
                        <div class="col-12">
                            <form class="optionsForm">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Option 1</label>
                                    <input type="text" placeholder="Enter Option" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3 disable">
                                    <label for="exampleInputPassword1" class="form-label ">Option 2</label>
                                    <input type="text" placeholder="Revoke Proposal" class="form-control option2"
                                        id="exampleInputPassword1">
                                </div>
                                <button type="" class="btn btn-most"> <img src="{{ asset('images/+.png') }}" alt=""> Most
                                    recent</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <section class="dateSection">
            <div class="container">
                <div class="innerDate">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="startDate">Start date</label>
                            <input id="startDate" class="form-control" type="date" name="start_date" value="{{ old('start_date') }}" />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="endDate">End date</label>
                            <input id="endDate" class="form-control" type="date" disabled/>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            {{-- <div class="warning-box warRed">
                                <span class="warning-icon"><img src="{{ asset('images/warRed.png') }}" alt=""></span>
                                <p>You dont have enough balance to create a proposal</p>
                            </div> --}}
                            @if ($errors->any())
                                <div class="warning-box warRed">
                                    <span class="warning-icon"><img src="{{ asset('images/warRed.png') }}" alt=""></span>
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-2 mt-3">
                    <div class="col-12 propbtn">
                        <button class="cardendBtn">Create Proposal</button>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
