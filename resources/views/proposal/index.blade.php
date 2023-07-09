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
                    <h1>Expansion of LumosDAO Community</h1>
                    <div class="col-12">
                        <div class="progresInner">
                            <div class="ProgText">
                                <div class="left">
                                    <p>Yes</p>
                                </div>
                                <div class="right">
                                    <p>3 LUMOS | 50%</p>
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
                                    <p>No</p>
                                </div>
                                <div class="right">
                                    <p>3 LUMOS | 50%</p>
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
                        <p>We propose an initiative to expand and strengthen the LumosDAO community, fostering greater engagement, collaboration, and participation. Our goal is to attract new members, promote awareness of LumosDAO's capabilities, and enhance the overall user experience within the platform.</p>
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
                                    <th scope="col">Address</th>
                                    <th scope="col">Vote</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>Yes</td>
                                    <td>1 LUMOS</td>
                                    <td>3 months ago</td>
                                </tr>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>No</td>
                                    <td>1 LUMOS</td>
                                    <td>3 months ago</td>
                                </tr>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>No</td>
                                    <td>1 LUMOS</td>
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
                                    <td>1 LUMOS</td>
                                    <td>3 months ago</td>
                                </tr>
                                <tr>
                                    <td>GCXY...VTJ6</td>
                                    <td>No</td>
                                    <td>1 LUMOS</td>
                                    <td>3 months ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
