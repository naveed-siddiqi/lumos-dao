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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <form method="POST" action="{{ route('dao.proposal.store', $dao->id) }}">
        @csrf
        <section class="proposalText">
            <div class="container">
                <div class="row">
                    <div class="Create-dao-section">
                    <p class="text-muted">
                                Enter the title and description of your proposal below. Feel free to attach files (limited to .png and .pdf formats). For guidance, check out our proposal example
                                  <a class="create-dao-link" href="#">
                                    Learn more
                                </a>
                            </p>
                    </div>
                    <div class="innerPropText">
                        <div style="display:none;" class="col-12 ">
                            <div  class="warning-box">
                                <span class="warning-icon"><img src="{{ asset('images/war.png') }}" alt=""></span>
                                <p>You need to have a minimum of {{$dao->required_tokens}} {{$dao->asset}} in order to submit a proposal.</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="col-8">
                            <div class="textProp">
                                {{-- <h2>Proposal Title</h2> --}}
                                <div class="d-flex gap-2 my-2">
                                <input class="input-filed border rounded" type="text" placeholder="Proposal Title" name="title" value="{{ old('title') }}">
                                <input class="input-filed border rounded" type="text" placeholder="Add Budget">
                                </div>
                                <textarea class="input-filed border rounded" placeholder="Tell more about your proposal (optional)" name="about">{{ old('about') }}</textarea>
                            </div>
                            
                        </div>
                            <div class="col-4 text-end ">
                             <label class="custom-file-input-attach">
                                <input type="file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 2H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM5 18v-2h2v2H5zM5 15v-2h2v2H5zM5 12V9h2v3H5zM5 8V6h2v2H5zM18 15h-2v-2h2v2zM18 12h-2V9h2v3zM18 8h-2V6h2v2zM18 5h-2V3h2v2z"/>
                                </svg>
                               <p style="white-space:nowrap;" class=""> Attach file</p>
                            </label>
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
