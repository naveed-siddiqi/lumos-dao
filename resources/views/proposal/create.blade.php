@extends('layouts.app')

@section('content')
    <section class="leadingBoard">
        <div class="container">
            <div class="row">
                <div class="col-12 ">
                    <div class="heading-board">
                        <p class="headingBoard">Board</p>
                        <span class="rightArrow"> > </span>
                        <p class="headingBoard">{{$dao['name']}}</p>
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

    <form onsubmit='createProposals(event)'>
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
                                <p>You need to have a minimum of in order to submit a proposal.</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="col-8">
                            <div class="textProp">
                                {{-- <h2>Proposal Title</h2> --}}
                                <input class="input-filed" id='title' type="text" required placeholder="Proposal Title" name="title" value="{{ old('title') }}">
                                <textarea class="input-filed" id='about' required placeholder="Tell more about your proposal (optional)" name="about">{{ old('about') }}</textarea>
                            </div>
                            
                        </div>
                            <div class="col-4 text-end ">
                             <label class="custom-file-input-attach">
                                <input id='selectFile' type="file" multiple>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 2H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM5 18v-2h2v2H5zM5 15v-2h2v2H5zM5 12V9h2v3H5zM5 8V6h2v2H5zM18 15h-2v-2h2v2zM18 12h-2V9h2v3zM18 8h-2V6h2v2zM18 5h-2V3h2v2z"/>
                                </svg>
                               <p style="white-space:nowrap;" class="">Add files</p>
                            </label>
                            <div id='selectFileDisplay' style='width:100%;height:100%;white-space: nowrap;overflow:hidden; text-overflow:ellipsis'>
                                
                            </div>
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
                            <input id="startDate" class="form-control" type="date" name="start_date" value="<?php echo date('Y-m-d'); ?>" disabled/>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="endDate">End date</label>
                            <input id="endDate" class="form-control" value="<?php echo date('Y-m-d', time() + 432000); ?>" type="date" disabled/>
                        </div>
                    </div>

                </div>
                <div class="row mb-2 mt-3">
                    <div class="col-12 propbtn">
                        <button id='create' class="cardendBtn">Create Proposal</button>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <script>
    var file = [];  
    var hasJoined = null;
            
        /* Handles the Creation Scripts */
        const createProposals = async (e) => {
            e.preventDefault() //prevent the form from submitting itself
            let title = E('title').value.trim()
            const about = E('about').value.trim()
            const startDate = (new Date(E('startDate').value)).getTime() / 1000;
            if(title != ""){
                //first check if he or she is a memeber
                const id = talk("Getting ready")
                E('create').disabled = true
                if(hasJoined == null || hasJoined === false) {
                    //get join state
                    const bal = await getTokenUserBal('{{$dao['asset']}}', walletAddress);  
                    if(bal === false) {
                        talk("You are not a member of this DAO<br><center>Joining DAO</center>", 'norm', id)
                        const dao = await getDao("{{$dao['asset']}}");
                        const res = await createTrustline(dao.code, dao.issuer, walletAddress, dao.name, dao.token)
                        if(res !== false) {
                            hasJoined = true
                        }
                        else{
                            hasJoined = false
                            stopTalking(4, talk('Unable to join DAO<br>Try again later', 'fail', id))
                        }
                    }
                    else{hasJoined = true}
                }
                if(hasJoined){
                    if(about != ""){
                        //declare create prop function
                        const createProp = async (link) => {
                            talk("Creating proposal", "norm", id)
                            const res = await createProposal({
                                creator: walletAddress,
                                dao:'{{$dao['asset']}}',
                                name:title,
                                about:about,
                                start:startDate,
                                links:link
                            })
                            if(res) {  
                                stopTalking(4, talk("Proposal created successfully", 'good', id))
                                setTimeout(() => {
                                   //redirect to proposal page
                                   window.location = "{{ route('dao.proposal', ['proposal_id' => " ", 'dao_id'=> $dao['asset']]) }}" + res.status
                                },2000)
                            }
                            else {
                                stopTalking(4, talk("Unable to create proposal<br>Try again later", 'fail', id))
                            }
                            E('create').disabled = false
                        }
                        //creates the proposal
                        const isProp = await isProposalExists(title, "{{$dao['name']}}")
                        if(isProp) {
                            //add random number to name
                            title += "_" + Math.floor(Math.random() * 100)
                        }
                        //check if files was selected, if it was processed it
                        if(file.length > 0) {
                            //upload file and generate link
                            talk("Uploading proposal file", "norm", id)
                            uploadProposalFiles("{{$dao['name']}}", title, async (res, link) => {
                                if(res === true) {  
                                    createProp(link)
                                }
                                else if(res === false){
                                    stopTalking(4, talk("Unable to upload proposal file<br>TTry again later", 'fail', id))
                                    E('create').disabled = false
                                }
                                else {
                                    //percentage loading
                                    talk("Uploading proposal file " + res + "%", "norm", id, res * 1)
                                }
                            })
                        }
                        else {
                            createProp("")
                        }
                }
                    else {
                        stopTalking(4, talk("Proposal must have a description", 'fail'))
                    }
                }
                else{E('create').disabled = false}
            }
            else {
                stopTalking(4, talk("Title cannot be empty", 'fail'))
            }
            
        }
        /* Uploads the proposal files */
        const uploadProposalFiles = (dao, proposal, callback) => { 
              const formData = new FormData(); // Create a FormData object
              // Add the selected file to the FormData object
              for (let i = 0; i < file.length; i++) {
                formData.append('files' + i, file[i]);
              }
               
              proposal = proposal.trim().replace(/ /g, "")
              // Create an HTTP request
              const xhr = new XMLHttpRequest();
              const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=proposal_upload&dao=" + encodeURIComponent(dao.toLowerCase()) + "&proposal_name=" + encodeURIComponent(proposal) + "&num=" + file.length
              console.log(url) 
              // Define the server endpoint (PHP file)
              xhr.open('POST', url, true);
              // Set up an event listener to handle the response
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) { console.log(xhr.responseText)
                const res = JSON.parse(xhr.responseText)
                    if (res.status == "1") {callback(true, res.links)}else{callback(false)}
                }
                else if (xhr.readyState === 4 && xhr.status !== 200) {
                    callback(false)
                }
              };
              xhr.upload.addEventListener("progress", function(event) {
                    if (event.lengthComputable) {
                        callback(Math.round((event.loaded / event.total) * 100))
                    }
                });
             // Send the FormData object with the image
              xhr.send(formData);
            }
    
    
        /* Handles file upload */
        E('selectFile').onchange = (event) => {
                const fileInput = E('selectFile');
                if(file.length === 0){E('selectFileDisplay').innerHTML = ""}
                  // Check if a file is selected
                  if (fileInput.files.length === 0) {
                    stopTalking(4, talk("Please select a file.", "warn"));
                    return;
                  }
                  
                  //Only five files allowed
                  for(let i=0;i<fileInput.files.length;i++){
                      // Check the file size (max size: 3MB)
                      const maxSize = 5 * 1024 * 1024; // 3MB in bytes
                      if (fileInput.files[i].size > maxSize) {
                        stopTalking(4, talk("One of the selected file size exceeds the maximum allowed (5MB).", "warn"));
                        continue;
                      }
                      // Check if the selected file is an image or doc
                      if (!(fileInput.files[i].type.startsWith('image/') || isDocument(fileInput.files[i]))) {
                        stopTalking(4, talk("One of the files selected is not an image or a document file.", "warn"));
                        continue;
                      }
                      
                      
                      //using src
                      E('selectFileDisplay').appendChild(drawAddedFile(fileInput.files[i].name, file.length))
                      
                     
                     file.push(fileInput.files[i])
                  }
           }
    
           const drawAddedFile = (filename, id) => {
               let tm = document.createElement('div')
               tm.innerHTML = `<div style='padding:5px 5px;display:flex;align-items:center;width:100%;overflow:hidden;text-overflow:ellipsis;border-bottom:1px solid rgba(0,0,0,.1);'>
               <span onclick='removeFile(${id})' class='fas fa-times' style='margin-right:10px;'></span> ${filename}</div>`
               return tm.firstElementChild
           }
           //to remove selected file
           const removeFile = (id) => {
               file[id] = null; let files = []
               E('selectFileDisplay').innerHTML = ''
               for(let i=0;i<file.length;i++) {
                   if(file[i] != null) {
                       E('selectFileDisplay').appendChild(drawAddedFile(file[i].name, files.length))
                       files.push(file[i])
                   }
               }
               file = files;
               console.log(file)
           }
    </script>
@endsection
