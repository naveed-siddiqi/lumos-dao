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
                        <p class="apple-text">proposal Info</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="progeBarWhite">
                    <div class="d-flex align-items-center justify-content-between">
                         <h1>Expansion of LumosDAO Community</h1>
                         <div class="d-flex align-items-baseline justify-content-center gap-2">
                                        <span style="font-family: 'MontSem';" class="text-secondary">Voting Power:</span>
                                        <span class="text-secondary">4.85</span>
                                    </div>
                    </div>
                   
                    <div class="col-12">
                        <div class="progresInner">
                            <div class="ProgText">
                                <div class="left d-flex align-items-baseline justify-content-center gap-2">
                                    <div class="">
                                       <button class="ProgText-btn"><p>Yes</p></button> 
                                    </div>
                                    
                                    
                                </div>
                                
                            </div>
                            <div class="progress-bar">
                                <div class="progress"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progresInner">
                            <div class="ProgText">
                                <div class="left">
                                <button class="ProgText-btn"><p>No</p></button> 
                                </div>
                               
                            </div>
                            <div class="progress-bar">
                                <div class="progress"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="DescPer">
        <div class="container">
            <div class="row">
                <div class="DescPerSec">
                    <h1>Description</h1>
                    <div class="col-12">
                        <p>
                                Aquarius provide rewards to liquidity pairs inside their rewards zone. Any pool can become incentivized if the liquidity pair can reach 0.5% in votes. I propose that we bribe the community to vote for the NUNA/AQUA liquidity pair.
                                <p>300K per week is around the minimum allowed according to Aquarius</p><br><br><br>
                                <p>For more information on Aquarius rewards and bribes: https://medium.com/aquarius-aqua</p>
                                </p>
                    </div>
                </div>
            </div>
    </section>


    <section class="PropId">
        <div class="container">
            <div class="row">
                <div class="PropIdInner">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <h6>Proposal ID</h6>
                            <p>QmZqfaSz...pMfBKmjh</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 Due">
                            <h6>Duration</h6>
                            <p>5 days</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 Due1">
                            <h6>Status</h6>
                            <p>Ended</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <h6>Total voter</h6>
                            <p>6</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <h6>Total votes</h6>
                            <p>6 LUMOS</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <h6>Proposer</h6>
                            <p>GBV6...SYEN</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ProposalTable">
        <div class="container">
            <div class="row">
                <div class="InnerTable">
                    <h3>Votes</h3>
                    <div class="col-12">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th clas="" scope="col">
                                        <div class="d-flex align-items-center">
                                            <span>Address</span> 
                                            <button  type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
                                        </div>
                                             
                                    </th>
                                    <th scope="col">
                                    <div class="d-flex align-items-center">
                                            <span>Vote</span> 
                                            <button  type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
                                        </div>
                                    </th>
                                    <th scope="col">
                                    <div class="d-flex align-items-center">
                                            <span>Voting Power</span> 
                                            <button  type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
                                        </div>
                                    </th>
                                    <th scope="col">
                                    <div class="d-flex align-items-center">
                                            <span>Date</span> 
                                            <button  type="button" class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary " data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>Yes</td>
                                    <td>24</td>
                                    <td>3 months ago</td>
                                </tr>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>No</td>
                                    <td>24</td>
                                    <td>3 months ago</td>
                                </tr>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>No</td>
                                    <td>24</td>
                                    <td>3 months ago</td>
                                </tr>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>Yes</td>
                                    <td>1 LUMOS</td>
                                    <td>3 months ago</td>
                                </tr>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>Yes</td>
                                    <td>43</td>
                                    <td>3 months ago</td>
                                </tr>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>No</td>
                                    <td>98</td>
                                    <td>3 months ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="DescPer">
        <div class="container">
            <div style="text-align:right;" class="pb-3">
                <button style="border:1px solid #e5e7eb; background-color:white; padding:8px; border-radius:10px;font-weight:500; " type="button">Add Comments</button>
            </div>
            <div class="row">
                <div class="DescPerSec">
                    <h1>Comments</h1>
                    <div  class="col-12">
                          <div class="col-12">
                        <div class="d-flex align-items-center justify-center gap-2">
                            <img style="width:40px; height:40px; border-radius:50%;" src="https://images.unsplash.com/photo-1683009680116-b5c04463551d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwcm9maWxlLXBhZ2V8MTh8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="">
                            <span>BQEH.....OHBPS</span>
                        </div>
                        </div>
                        <div style="border-bottom: 1px solid #e5e7eb; " class="col-12 my-2">
                            <p>We propose an initiative to expand and strengthen the LumosDAO community, fostering greater engagement, collaboration, and participation. Our goal is to attract new members, promote awareness of LumosDAO's capabilities, and enhance the overall user experience within the platform.</p>
                        </div>
                    </div>
                    <div class="col-12">
                          <div class="col-12">
                        <div class="d-flex align-items-center justify-center gap-2">
                            <img style="width:40px; height:40px; border-radius:50%;" src="https://images.unsplash.com/photo-1683009680116-b5c04463551d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwcm9maWxlLXBhZ2V8MTh8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="">
                            <span>BQEH.....OHBPS</span>
                        </div>
                        </div>
                        <div style="border-bottom: 1px solid #e5e7eb; " class="col-12 my-2">
                            <p>We propose an initiative to expand and strengthen the LumosDAO community, fostering greater engagement, collaboration, and participation. Our goal is to attract new members, promote awareness of LumosDAO's capabilities, and enhance the overall user experience within the platform.</p>
                        </div>
                    </div>
                        <a style="color:black; text-decoration:none; font-weight:500; display:flex; align-items:center; justify-content:center;" href="">
                            See all Comments
                        </a>
                </div>
            </div>
    </section>
@endsection
