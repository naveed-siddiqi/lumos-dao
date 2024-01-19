@extends('layouts.app')

@section('content')
<main class="content proposal-inbox mt-5 border-0">
    <div class="container heading">
        <div class="Platfarm-stats_title">
            <div class="heading">Inbox</div>
        </div>
    </div>
    <div class="container p-0">
        <div class="card-join cardShow p-0 border-0">
            <div class="row g-0">
                <div class="col-12 col-lg-5 col-xl-3 border-right-inbox font-xs">

                    <div class="px-4-inbox d-none d-md-block">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <input type="text" class="form-control h-auto py-2 my-3" placeholder="Search...">
                            </div>
                        </div>
                    </div>

                    <a href="#" class="list-group-item list-group-item-action border-0 my-2">
                        <div class="d-flex align-items-start gap-3">
                            <img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1"
                                alt="Vanessa Tucker" width="40" height="40">
                            <div class="flex-grow-1 ml-3">
                                Vanessa Tucker
                                <div class="small">
                                    <span class="fas fa-circle chat-online"></span> Online</div>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0">
                        <div class="d-flex align-items-start gap-3">
                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="rounded-circle mr-1"
                                alt="William Harris" width="40" height="40">
                            <div class="flex-grow-1 ml-3">
                                William Harris
                                <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                            </div>
                        </div>
                    </a>
                    <hr class="d-block d-lg-none mt-1 mb-0">
                </div>
                <div class="col-12 col-lg-7 col-xl-9">
                    <div class="py-2 px-4-inbox border-bottom d-none d-lg-block">
                        <div class="d-flex align-items-center py-1 gap-3">
                            <div class="position-relative">
                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                    class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                            </div>
                            <div class="flex-grow-1 pl-3">
                                <strong>Sharon Lessman</strong>
                                <div class="text-muted small"><em>Typing...</em></div>
                            </div>
                            <div>
                                <button class="btn btn-lg p-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-more-horizontal feather-lg">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg></button>
                            </div>
                        </div>
                    </div>

                    <div style="min-height: 60vh;" class="position-relative font-xs">
                        <div class="chat-messages p-4">


                            <div class="chat-message-right mb-4">
                                <div>
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                        class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">2:41 am</div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3 inbox-msg">
                                    <div class="font-weight-bold-inbox mb-1">You</div>
                                    Morbi finibus, lorem id placerat ullamcorper, nunc enim ultrices massa, id dignissim
                                    metus urna eget purus.
                                </div>
                            </div>

                            <div class="chat-message-left pb-4">
                                <div>
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">2:42 am</div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3 inbox-msg">
                                    <div class="font-weight-bold-inbox mb-1">Sharon Lessman</div>
                                    Sed pulvinar, massa vitae interdum pulvinar, risus lectus porttitor magna, vitae
                                    commodo lectus mauris et velit.
                                    Proin ultricies placerat imperdiet. Morbi varius quam ac venenatis tempus.
                                </div>
                            </div>

                            <div class="chat-message-right mb-4">
                                <div>
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                        class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">2:43 am</div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3 inbox-msg">
                                    <div class="font-weight-bold-inbox mb-1">You</div>
                                    Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.
                                </div>
                            </div>

                            <div class="chat-message-left pb-4">
                                <div>
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2">2:44 am</div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3 inbox-msg">
                                    <div class="font-weight-bold-inbox mb-1">Sharon Lessman</div>
                                    Sit meis deleniti eu, pri vidit meliore docendi ut, an eum erat animal commodo.
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="flex-grow-0 py-3-inbox px-4-inbox border-top-inbox">
                        <div class="input-group d-flex align-items-center gap-4">
                            <input type="text" class="form-control rounded" placeholder="Type your message">
                            <div class="d-flex align-items-center mt-2">
                                <button class="btn btn-success px-3 py-2">Send</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection