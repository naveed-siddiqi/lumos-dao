"use client"
import { stopTalking, talk } from '@/app/components/alert/swal';
import { createTrustline, createProposal, N, uploadToIpfs } from '@/app/core/core';
import { getDao, getTokenUserBal, isBanned, isDocument, isProposalExists } from '@/app/core/getter';
import { API_URL } from '@/app/data/constant';
import dynamic from 'next/dynamic';
import Link from 'next/link'
import React, { useEffect, useMemo, useState } from 'react'
import { BsChevronBarRight, BsChevronRight, BsUpload } from 'react-icons/bs'
import 'react-quill/dist/quill.snow.css';
const ReactQuill = dynamic(() => import('react-quill'), { ssr: false });

let file = []; 
let hasJoined = null;
let _dao = "";
let dao = null;
const CreateProposal = () => {

  const [value, setValue] = useState('');
  
  async function setUp(){
    dao = (await getDao([_dao]))[_dao];
    E('dao_nav_link').innerText = dao.name
    E('dao_nav_link').href = "/dao/" + dao.token
  }

  /* Handles the Creation Scripts */
  const createProposals = async (e) => {
            e.preventDefault() //prevent the form from submitting itself
            let title = E('title').value.trim()
            const about = value
            const startDate = (new Date(E('startDate').innerHTML)).getTime() / 1000;
             if(title != ""){ 
                const id = talk("Getting ready")
                const dao = (await getDao([_dao]))[_dao];
                if(await isBanned(dao.token, walletAddress)){stopTalking(0.1, id);return "";}
                //first check if he or she is a memeber
                E('create').disabled = true
                if(hasJoined == null || hasJoined === false) {
                    //get join state
                    const bal = await getTokenUserBal(_dao, walletAddress);  
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
                            talk("Uploading proposal data", "norm", id) 
                            //check if files was selected, if it was processed it
                            const ipfs = await uploadToIpfs({
                                creator: walletAddress,
                                dao:_dao,
                                name:title,
                                about:about,
                                start:startDate,
                                links:link,
                            })
                            if(ipfs !== false){
                                talk("Creating proposal", "norm", id)
                                const res = await createProposal({
                                    creator: walletAddress,
                                    dao:_dao,
                                    name:title,
                                    about:about,
                                    start:(new Date(startDate * 1E3)).toISOString(),
                                    links:link,
                                    ipfs
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
    <div className='px-[3rem] mt-[50px] mb-[80px]'>
      <div className='flex gap-1 items-center'>
        <a href='/dao'>Board</a>
        <BsChevronRight />
        <a id='dao_nav_link'></a>
        <BsChevronRight />
        <p className='font-[600]'>Create proposal</p>
      </div>
      <div className='flex items-center justify-between gap-9 mt-7'>
        <p>Enter the title and description of your proposal below. Feel free to attach files (limited to .png and .pdf formats). For guidance, check out our proposal example <Link href="#" className='text-blue-600'>Learn more</Link> </p>
        <select className='py-3 px-3 border rounded-[6px]'>
          <option value="">Single Governance</option>
          <option value="">Date Added</option>
          <option value="">Number of Proposals</option>
          <option value="">Active Proposals</option>
        </select>
      </div>
      <div className='bg-white p-5 h-[500px] rounded-[6px] mt-5 flex items-start flex-col lg:flex-row justify-between w-full'>
        <div className='w-full'>
          <div className='max-w-[800px]'>
            <input id='title' type="text" placeholder='Proposal Title' className='py-3 px-2 w-full border rounded-[6px] mb-5' />
             <ReactQuill theme="snow" value={value} onChange={setValue} className='h-[300px]' />
          </div>
        </div>
        <div>
          <button onClick={() => {
            document.querySelector('#selectFile').click()
          }} className='rounded-[6px] w-[110px] flex items-center justify-between px-[8px] py-[4px]' style={{border:'2px solid #00000014'}}>
              <BsUpload />
              Add file
          </button>
          <input type="file" name="" id="selectFile" style={{marginTop:'40px', display:'none'}} />
          <div id='selectFileDisplay' style={{ height:'100%', whiteSpace:'nowrap',overflow:'hidden', textOverflow:'ellipsis'}}>
          </div>
        </div>
      </div>
      <div className='flex items-center justify-between bg-white mt-5 p-5 gap-5'>
        <div className='w-full'>
          <p className='text-[20px] fonnt-[500] mbb-1'>Start Date</p>
          <p id='startDate' className='border p-3 rounded-[6px]'>{new Date().toLocaleDateString()}</p>
        </div>
        <div className='w-full'>
          <p className='text-[20px] fonnt-[500] mb-1'>End Date</p>
          <p className='border p-3 rounded-[6px]'>{new Date(new Date().setDate(new Date().getDate() + 5)).toLocaleDateString()}</p>
        </div>
      </div>
      <button id='create' onClick={($event) => {createProposals($event)}} className='cursor-pointer flex items-center gap-2 bg-[#DC6B19] text-white px-5 py-3 rounded font-[500] mt-2'>Create Proposal</button>
    </div>
  )
}

export default CreateProposal