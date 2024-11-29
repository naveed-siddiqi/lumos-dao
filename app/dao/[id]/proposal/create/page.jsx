"use client"
import { stopTalking, talk } from '@/app/components/alert/swal';
import { createTrustline, createProposal, N, uploadToIpfs } from '@/app/core/core';
import { getDao, getDaoInfo, getTokenUserBal, isBanned, isDocument, isMember, isProposalExists } from '@/app/core/getter';
import { API_URL } from '@/app/data/constant';
import dynamic from 'next/dynamic';
import Link from 'next/link'
import React, { useEffect, useMemo, useState } from 'react'
import { BsChevronBarRight, BsChevronRight, BsUpload } from 'react-icons/bs'
import { BiChevronDown } from 'react-icons/bi';
import 'react-quill/dist/quill.snow.css';
import SelectChain from '@/app/components/chain/SelectChain';
const ReactQuill = dynamic(() => import('react-quill'), { ssr: false });

let file = []; 
let hasJoined = null;
let _dao = "";
let dao = null;
const CreateProposal = () => {

  const [value, setValue] = useState('');
  const [selectedType, setSelectedType] = useState('Legacy');
  const [daoChain, setDaoChain] = useState({})
  async function setUp(){  
    setDaoChain({chain:CHAIN, name:(CHAIN=='stellar')?'Stellar':'XRPL'})
    
    dao = (await getDaoInfo([_dao], CHAIN))[_dao];
 
    E('dao_nav_link').innerText = dao ? dao.name : ""
    const daoToken = dao ? dao.token : ""
    E('dao_nav_link').href = "/dao/" + daoToken
  }

  const votingTypes = ["Token-Based", "Weighted", "Quadratic", "Approval", "Cumulative", "Range"]
  const [selectedVoteType, setSelectedVoteType] = useState(votingTypes[0])
  const [dropDown, setDropDown] = useState('')
  const [options, setOptions] = useState([]);

   // Function to add a new option (limited to 5)

   const handleAddOption = () => {
    if (options.length < 5) {
      setOptions([...options, ""]);
    }
  };

  // Function to handle changes in each input field
  const handleOptionChange = (index, value) => {
    const newOptions = [...options];
    newOptions[index] = value;
    setOptions(newOptions);
  };

  // Function to remove an option
  const handleRemoveOption = (index) => {
    const newOptions = options.filter((_, i) => i !== index);
    setOptions(newOptions);
  };


  /* Handles the Creation Scripts */
  const createProposals = async (e) => {
            e.preventDefault() //prevent the form from submitting itself
            let title = E('title').value.trim()
            const about = value
            const startDate = (new Date()).getTime() / 1000;
            // const startDate = (new Date(E('startDate').innerHTML)).getTime() / 1000;
            const voting_type = selectedVoteType === "Token-Based" ? 0 : selectedVoteType === "Weighted" ? 1 : selectedVoteType === "Quadratic" ? 2 : selectedVoteType === "Approval" ? 3 : selectedVoteType === "Cumulative" ? 4 : selectedVoteType === "Range" ? 5 : 100
            
            let voting_options;
            
            if (selectedType === "Legacy") {
                voting_options = {
                    0: "For",
                    1: "Against",
                    2: "Abstain"
                };
            } else if (selectedType === "Custom") {
                voting_options = options.reduce((acc, curr, idx) => {
                    acc[idx] = curr;
                    return acc;
                }, {});
            }
           
             if(title != ""){ 
                const id = talk("Getting ready")
                if(dao==null) dao = (await getDaoInfo([_dao], CHAIN))[_dao];
                if(await isBanned(dao.token, walletAddress, CHAIN)){stopTalking(0.1, id);return "";}
                //first check if he or she is a memeber
                E('create').disabled = true
                if(hasJoined == null || hasJoined === false) {
                    //get join state
                    const bal = await isMember(_dao, walletAddress, CHAIN);  
                    if(bal === false) { 
                        talk("You are not a member of this DAO<br><center>Joining DAO</center>", 'norm', id)
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
                            let ipfs
                            if(CHAIN != 'xrp'){
                              talk("Uploading proposal data", "norm", id) 
                              //check if files was selected, if it was processed it
                              ipfs = await uploadToIpfs({
                                  creator: walletAddress,
                                  dao:_dao,
                                  name:title,
                                  about:about,
                                  start:startDate,
                                  links:link,
                                  voting_type,
                                  voting_options
                              })
                            }else{ipfs=true}
                            if(ipfs !== false){
                                talk("Creating proposal", "norm", id)
                                const res = await createProposal({
                                    creator: walletAddress,
                                    dao:_dao,
                                    name:title,
                                    about:about,
                                    start:(new Date(startDate * 1E3)).toISOString(),
                                    links:link,
                                    ipfs,
                                    voting_type,
                                    voting_options
                                })
                                if(res !== false) {  
                                    if(N(res.status) != 3){ 
                                        stopTalking(4, talk("Proposal created successfully", 'good', id))
                                        setTimeout(() => {
                                           //redirect to proposal page
                                           const a_ = `/dao/${dao.token}/proposal/${res.status}` 
                                           window.location.assign(a_)
                                        },2000)
                                   } else {
                                        stopTalking(4, talk("Only admins can create proposal", 'fail', id))
                                   }
                                }
                                else {
                                    stopTalking(4, talk("Unable to create proposal<br>Try again later", 'fail', id))
                                }
                            }
                            else {
                                stopTalking(4, talk("Unable to upload proposal data<br>Network error", 'fail', id))
                            }
                            E('create').disabled = false
                        } 
                        //creates the proposal
                        const isProp = await isProposalExists(title, dao.domain)
                        if(isProp) {
                            //add random number to name
                            title += "_" + Math.floor(Math.random() * 100)
                        }
                        if(file.length > 0) {
                            //upload file and generate link
                            talk("Uploading proposal file", "norm", id)
                            console.log(dao.domain)
                            uploadProposalFiles(dao.domain, title, async (res, link) => {
                                if(res === true) {  
                                    //upload to ipfs
                                    createProp(link)
                                }
                                else if(res === false){
                                    stopTalking(4, talk("Unable to upload proposal file<br>Try again later", 'fail', id))
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
              const url = API_URL + "proposal_upload&dao=" + encodeURIComponent(dao.toLowerCase()) + "&proposal_name=" + encodeURIComponent(proposal) + "&num=" + file.length
              // Define the server endpoint (PHP file)
              xhr.open('POST', url, true);
              // Set up an event listener to handle the response
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {  
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
  useEffect(() => {
    /* Handles file upload */
   window.E = (id) => document.getElementById(id)     
   window.CHAIN = localStorage.getItem("LUMOS_CHAIN") || "stellar"
   _dao = (window.location.href).substring(window.location.href.lastIndexOf('dao/') + 4)
 
    _dao = _dao.substring(0, _dao.indexOf("/"))
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
    setUp()
    //to remove selected file
    window.removeFile = (id) => {
      file[id] = null; let files = []
      E('selectFileDisplay').innerHTML = ''
      for(let i=0;i<file.length;i++) {
          if(file[i] != null) {
              E('selectFileDisplay').appendChild(drawAddedFile(file[i].name, files.length))
              files.push(file[i])
          }
      }
      file = files;
    }  
    window.drawAddedFile = (filename, id) => {
      let tm = document.createElement('div')
      tm.innerHTML = `<div style='padding:5px 5px;display:flex;align-items:center;width:100%;overflow:hidden;text-overflow:ellipsis;border-bottom:1px solid rgba(0,0,0,.1);'>
      <span onclick='removeFile(${id})' class='fas fa-times' style='margin-right:10px;'></span> ${filename}</div>`
      return tm.firstElementChild
  }
  
  }, [])


  
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px] helvetica-font'>
      <SelectChain chain={daoChain.chain} name={daoChain.name} />
      <div className='flex items-start justify-between'>
        <div className='w-[49%]'>
          <div className='flex gap-1 items-center'>
            <a href='/dao'>Board</a>
            <BsChevronRight />
            <a id='dao_nav_link'></a>
            <BsChevronRight />
            <p className='bg-[#FFFAF5] py-2 px-4 rounded-full text-[#FF7B1B]'>Create Proposal</p>
          </div>
          <p className='text-[#5F6670] mt-4'>Enter the title and description of your proposal below...</p>
        </div>
        <div className='relative text-[14px] w-[200px]'>
          <div onClick={() => setDropDown(dropDown === "vote" ? '' : 'vote')} className='flex items-center justify-between bg-[#F6F6F8] p-2 rounded-[7px] cursor-pointer'>
            <p>{selectedVoteType} Voting</p>
            <img src="/images/chevron-down.svg" alt="" />
          </div>
          {dropDown === "vote" && (
            <div className='border border-[#D2D2D2] p-1 absolute w-full z-[100] bg-white rounded-[7px]'>
              {votingTypes.map((type, index) => (
                <p
                  key={index}
                  onClick={() => {
                    setSelectedVoteType(type);
                    setDropDown('');
                    localStorage.setItem('voteType', type);
                  }}
                  className={`text-[#344054] ${selectedVoteType === type ? 'bg-[#FF7B1B] text-white' : ''} hover:text-[#fff] hover:bg-[#FF7B1B] transition-all duration-300 cursor-pointer p-2 my-[2px] rounded-[7px]`}
                >
                  {type} Voting
                </p>
              ))}
            </div>
          )}
        </div>
      </div>

      <div className='bg-white p-5 lg:h-[500px] rounded-[6px] mt-5 flex items-start flex-col lg:flex-row gap-[1.5rem] justify-between w-full'>
        <div className='lg:w-[50%] w-[100%]'>
          <label className='text-[#344054] mb-1'>Proposal Title</label>
          <input id='title' type="text" placeholder='Type your input here' className='py-3 px-2 w-full border rounded-[6px] mb-5' />
          <label className='text-[#344054] mb-1'>Description</label>
          <ReactQuill theme="snow" placeholder='Enter a description...' value={value} onChange={setValue} className='h-[300px] rounded-[6px]' />
        </div>

        <div className='lg:w-[50%] w-[100%] lg:mt-0 mt-[5rem]'>
          <p className='text-[#344054]'>Additional Images/media</p>
          <button onClick={() => {
            document.querySelector('#selectFile').click()
          }} className='rounded-[6px] w-full h-[430px] flex flex-col items-center justify-center' style={{border:'2px solid #00000014'}}>
            <img src="/images/upload.svg" alt="" />
            <p className='text-[#667085]'><span className='text-[#6941C6]'>Browse files</span> or drag and drop</p>
            <p className='text-[#667085] text-[12px]'>SVG, PNG, JPG or GIF (max. 800x400px)</p>
          </button>
          <input type="file" name="" id="selectFile" style={{marginTop:'40px', display:'none'}} />
          <div id='selectFileDisplay' style={{ height:'100%', whiteSpace:'nowrap',overflow:'hidden', textOverflow:'ellipsis'}} />
        </div>
      </div>
      <div className='flex items-center justify-between bg-white mt-5 p-5 gap-5'>
        <div className='w-full'>
          <p className='text-[16px] fonnt-[500] text-[#344054] mb-1'>Start Date</p>
          <p id='startDate' className='border p-3 rounded-[6px]'>{new Date().toLocaleDateString()}</p>
        </div>
        <div className='w-full'>
          <p className='text-[16px] fonnt-[500] text-[#344054] mb-1'>End Date</p>
          <p className='border p-3 rounded-[6px]'>{new Date(new Date().setDate(new Date().getDate() + 5)).toLocaleDateString()}</p>
        </div>
      </div>

      <div onClick={() => setSelectedType('Legacy')} className={selectedType === "Legacy" ? 'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#FBE4BB] bg-[#FFFCF5] w-[830px] mt-[3rem]':'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#EAECF0] bg-[#FFF] w-[830px] mt-[3rem]'}>
        <div>
          <p className={selectedType === "Legacy" ? 'text-[#FF7B1B] font-[500] text-[14px]':'text-[#344054] font-[500] text-[14px]'}>Legacy</p>
          <p className={selectedType === "Legacy" ? 'text-[#FF7B1B] text-[14px]':'text-[14px] text-[#667085]'}>This allows voters to choose either “For” or “Against” the proposal or they can also “Abstain”.</p>
        </div>
        {
          selectedType === "Legacy" ? <img src="/images/check-mark.svg" alt="" /> : <img src="/images/empty-check.svg" alt="" />
        }
      </div>

      <div onClick={() => setSelectedType('Custom')} className={selectedType === "Custom" ? 'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#FBE4BB] bg-[#FFFCF5] w-[830px] mt-[1.2rem]':'cursor-pointer flex justify-between items-start p-3 rounded-[10px] border border-[#EAECF0] bg-[#FFF] w-[830px] mt-[1.2rem]'}>
        <div>
          <p className={selectedType === "Custom" ? 'text-[#FF7B1B] font-[500] text-[14px]':'text-[#344054] font-[500] text-[14px]'}>Custom</p>
          <p className={selectedType === "Custom" ? 'text-[#FF7B1B] text-[14px]':'text-[14px] text-[#667085]'}>This allows the voters to choose any of the custom options (i.e up to 5) you have inputed.</p>
        </div>
        {
          selectedType === "Custom" ? <img src="/images/check-mark.svg" alt="" /> : <img src="/images/empty-check.svg" alt="" />
        }
      </div>

      {
        selectedType === "Custom" &&
        <div>
<div className="w-[830px] flex flex-col gap-[4px] mt-7">
      {options.map((option, index) => (
        <div key={index} className="flex items-center">
          <div className="flex flex-col flex-1">
            <label className="text-[#344054] mb-1">Option {index + 1}</label>
            <input
              type="text"
              placeholder="Type your input here"
              className="py-3 px-2 w-full border rounded-[6px] mb-5"
              value={option}
              onChange={(e) => handleOptionChange(index, e.target.value)}
            />
          </div>
          <button
            onClick={() => handleRemoveOption(index)}
            className="ml-3 text-red-500 hover:text-red-700"
            title="Remove option"
          >
            ✖
          </button>
        </div>
      ))}
      {options.length < 5 && (
        <button
          onClick={handleAddOption}
          className="border border-[#EAECF0] rounded-[8px] py-3 w-[830px] text-[#FF7B1B]"
        >
          + Add
        </button>
      )}
    </div>

    </div>
  
      }

      <button id='create' onClick={($event) => {createProposals($event)}} className='cursor-pointer flex items-center gap-2 bg-[#DC6B19] text-white px-5 py-3 rounded font-[400] mt-[7rem]'>Create Proposal</button>
  </div>
  )
}

export default CreateProposal