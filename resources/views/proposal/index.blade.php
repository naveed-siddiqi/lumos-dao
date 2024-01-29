@extends('layouts.app')

@section('content')
<section class="leadingBoard">
    <div class="container">
        <div class="row">
            <div class="col-12 ">
                <div class="heading-board">
                    <p class="headingBoard">Board</p>
                    <span class="rightArrow"> > </span>
                    <p class="headingBoard"> StellarBuds</p>
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
                <button data-toggle="modal" data-target="#reasonVote" class="m-0 p-0 bg-transparent w-100 border-0">
                    <div class="col-12">
                        <div class="progresInner">
                            <div class="ProgText">
                                <div class="left d-flex align-items-baseline justify-content-center gap-2">
                                    <p>Yes</p>
                                    <div class="d-flex align-items-center justify-content-center ProgFinal-text">
                                        Final Result
                                    </div>
                                </div>
                                <div class="right ">
                                    <div class="d-flex align-items-baseline justify-content-center gap-2">
                                        <span style="font-family: 'MontSem';" class="">Voting Power:</span>
                                        <span>4.85</span>
                                    </div>
                                    <div class="d-flex align-items-baseline justify-content-end gap-2">
                                        <span style="font-family: 'MontSem';" class="">Votes:</span>
                                        <span>4.85</span>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-bar">
                                <div class="progress"></div>
                            </div>
                        </div>
                    </div>
                </button>
                <button data-toggle="modal" data-target="#reasonVoteNo" class="m-0 p-0 bg-transparent w-100 border-0">
                    <div class="col-12">
                        <div class="progresInner">
                            <div class="ProgText">
                                <div class="left">
                                    <p>No</p>
                                </div>
                                <div class="right">
                                    <div class="d-flex align-items-baseline justify-content-center gap-2">
                                        <span style="font-family: 'MontSem';" class="">Voting Power:</span>
                                        <span>4.85</span>
                                    </div>
                                    <div class="d-flex align-items-baseline justify-content-end gap-2 text-sm">
                                        <span style="font-family: 'MontSem';" class="">Votes:</span>
                                        <span>4.85</span>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-NO"></div>
                            </div>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="reasonVote" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content cardEndDiv p-0 fa-ctn fa-modal-content">
            <div class="d-flex justify-content-end w-100">
                <button type="button" class="close p-3 pb-0 m-0 border-0 bg-transparent" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 pt-0 w-100 font-sm">
                <p class="">Reason</p>
                <form class="d-flex flex-column align-items-left justify-content-start gap-3" action="">
                    <div class="">
                        <input type="radio" id="1" name="reasons" value="1">
                        <label class="font-sm" for="">Alignment with Project Goals</label>
                    </div>
                    <div class="">
                        <input type="radio" id="2" name="reasons" value="2">
                        <label class="font-sm" for="">Beneficial Impact</label>
                    </div>
                    <div class="">
                        <input type="radio" id="3" name="reasons" value="3">
                        <label class="font-sm" for="">Feasibility and Sustainability</label>
                    </div>
                    <div class="">
                        <input type="radio" id="otherReason" name="reasons" value="other">
                        <label class="font-sm" for="">Other</label>
                    </div>
                    <div id="otherReasonCtn">
                        <label class="font-sm" for="">Mention the Reason here:</label>
                        <input class="form-control" type="text" maxlength="50">
                        <div class="text-end">
                            <small class="text-danger text-left w-100 font-sm">-Max 50 characters</small>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center justify-content-end gap-3 modal-footer m-0 p-0 py-3 px-3 w-100">
                <button type="button" class="btn btn-danger text-white font-sm">Confirm</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="reasonVoteNo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content cardEndDiv p-0 fa-ctn fa-modal-content">
            <div class="d-flex justify-content-end w-100">
                <button type="button" class="close p-3 pb-0 m-0 border-0 bg-transparent" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 pt-0 w-100 font-sm">
                <p class="">Reason</p>
                <form class="d-flex flex-column align-items-left justify-content-start gap-3" action="">
                    <div class="">
                        <input type="radio" id="1" name="reasonsNo" value="1">
                        <label class="font-sm" for="">Lack of Alignment with Goals</label>
                    </div>
                    <div class="">
                        <input type="radio" id="2" name="reasonsNo" value="2">
                        <label class="font-sm" for="">High budget</label>
                    </div>
                    <div class="">
                        <input type="radio" id="3" name="reasonsNo" value="3">
                        <label class="font-sm" for="">Feasibility Concerns</label>
                    </div>
                    <div class="">
                        <input type="radio" id="otherReasonNo" name="reasonsNo" value="other">
                        <label class="font-sm" for="">Other</label>
                    </div>
                    <div id="otherReasonCtnNo">
                        <label class="font-sm" for="">Mention the Reason here:</label>
                        <input class="form-control" type="text" maxlength="50">
                        <div class="text-end">
                            <small class="text-danger text-left w-100 font-sm">-Max 50 characters</small>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center justify-content-end gap-3 modal-footer m-0 p-0 py-3 px-3 w-100">
                <button type="button" class="btn btn-danger text-white font-sm">Confirm</button>
            </div>
        </div>
    </div>
</div>
<section class="DescPer">
    <div class="container">
        <div class="row">
            <div class="DescPerSec">
                <h1>Description</h1>
                <div class="col-12">
                    <p>We propose an initiative to expand and strengthen the LumosDAO community, fostering greater
                        engagement, collaboration, and participation. Our goal is to attract new members, promote
                        awareness of LumosDAO's capabilities, and enhance the overall user experience within the
                        platform.</p>
                </div>
            </div>
        </div>
</section>
<section class="DescPer">
    <div class="container">
        <div class="row">
            <div style="gap:50px;" class="DescPerSec d-flex align-items-center ">
                <h1>Attached files</h1>
                <div class="d-flex align-items-start justify-content-center gap-4 ">
                    <h6 style="color:#00b2fb;">Document 1.pdf</h6>
                    <h6 style="color:#00b2fb;">Document 2.pdf</h6>
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
                        <h6>Total voters</h6>
                        <p>6</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <h6>Total voting power</h6>
                        <p>19.5</p>
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
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The public Stellar wallet address that cast this vote.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </button>
                                    </div>

                                </th>
                                <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <span>Vote</span>
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The decision made by the user: Yes or No.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <span>Voting Power</span>
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The influence of this vote, determined by a calculated voting power algorithm. Learn more">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <span>Reason</span>
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The influence of this vote, determined by a calculated voting power algorithm. Learn more">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col">
                                    <div class="d-flex align-items-center">
                                        <span>Date</span>
                                        <button type="button"
                                            class="border-0 bg-transparent d-flex align-items-start justify-content-center px-2 text-secondary "
                                            data-toggle="tooltip" data-placement="top"
                                            title="The timestamp indicating when this vote was cast.">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
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
                                <td>2 <span class="badge badge-pill bg-info">delegated</span> </td>
                                <td>Lorem ipsum dolor sit amet. </td>
                                <td>3 months ago</td>
                            </tr>
                            <tr>
                                <td>GCXY...VTJ6</td>
                                <td>No</td>
                                <td>2.5</td>
                                <td>Lorem ipsum dolor sit amet. </td>
                                <td>3 months ago</td>
                            </tr>
                            <tr>
                                <td>GCXY...VTJ6</td>
                                <td>No</td>
                                <td>3</td>
                                <td>Lorem ipsum dolor sit amet. </td>
                                <td>3 months ago</td>
                            </tr>
                            <tr>
                                <td>GCXY...VTJ6</td>
                                <td>Yes</td>
                                <td>3.5</td>
                                <td>Lorem ipsum dolor sit amet. </td>
                                <td>3 months ago</td>
                            </tr>
                            <tr>
                                <td>GCXY...VTJ6</td>
                                <td>Yes</td>
                                <td>4</td>
                                <td>Lorem ipsum dolor sit amet. </td>
                                <td>3 months ago</td>
                            </tr>
                            <tr>
                                <td>GCXY...VTJ6</td>
                                <td>No</td>
                                <td>4.5</td>
                                <td>Lorem ipsum dolor sit amet. </td>
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
            <button class=" add-comments-btn " type="button">Add Comments</button>
        </div>
        <div class="row">
            <div class="DescPerSec">
                <h1>Comments</h1>
                <div class="col-12">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-center gap-2">
                            <img style="width:40px; height:40px; border-radius:50%;"
                                src="https://images.unsplash.com/photo-1683009680116-b5c04463551d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwcm9maWxlLXBhZ2V8MTh8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60"
                                alt="">
                            <span>BQEH.....OHBPS</span>
                        </div>
                    </div>
                    <div style="border-bottom: 1px solid #e5e7eb; " class="col-12 my-2">
                        <p>We propose an initiative to expand and strengthen the LumosDAO community, fostering greater
                            engagement, collaboration, and participation. Our goal is to attract new members, promote
                            awareness of LumosDAO's capabilities, and enhance the overall user experience within the
                            platform.</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-center gap-2">
                            <img style="width:40px; height:40px; border-radius:50%;"
                                src="https://images.unsplash.com/photo-1683009680116-b5c04463551d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwcm9maWxlLXBhZ2V8MTh8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60"
                                alt="">
                            <span>BQEH.....OHBPS</span>
                        </div>
                    </div>
                    <div style="border-bottom: 1px solid #e5e7eb; " class="col-12 my-2">
                        <p>We propose an initiative to expand and strengthen the LumosDAO community, fostering greater
                            engagement, collaboration, and participation. Our goal is to attract new members, promote
                            awareness of LumosDAO's capabilities, and enhance the overall user experience within the
                            platform.</p>
                    </div>
                </div>
                <a class=" see-more-comment-btn" href="">
                    See all Comments
                </a>
            </div>
        </div>
</section>
<script>
var otherReason = document.getElementById('otherReason');
var otherReasonCtn = document.getElementById('otherReasonCtn');
var otherReasonNo = document.getElementById('otherReasonNo');
var otherReasonCtnNo = document.getElementById('otherReasonCtnNo');
otherReasonCtn.style.display = 'none';
otherReasonCtnNo.style.display = 'none';

otherReason.addEventListener('input', function() {
    if (otherReason.checked) {
        otherReasonCtn.style.display = 'block';
    } else {
        otherReasonCtn.style.display = 'none';
    }
});

otherReasonNo.addEventListener('input', function() {
    if (otherReasonNo.checked) {
        otherReasonCtnNo.style.display = 'block';
    } else {
        otherReasonCtnNo.style.display = 'none';
    }
});
</script>
@endsection