'use client'

import { API_URL, firebaseConfig } from '@/app/data/constant';
import Link from 'next/link'
import React, { useEffect, useState } from 'react'
import { BsTwitterX, BsUpload } from 'react-icons/bs'
import { VscGithub } from "react-icons/vsc";
import { stopTalking, talk } from '../alert/swal';
import { getAuth, signInWithPopup, TwitterAuthProvider } from 'firebase/auth';
import { initializeApp } from "firebase/app";  
import { getGithubUri, getUserInfo } from '@/app/core/getter';
import { optimizeImg, validateImageUpload } from '@/app/core/core';
import QRCode from 'qrcode';
// Initialize Firebase
const app = initializeApp(firebaseConfig);
 
var user_disp_image = null; 
var user_cover_image = null; 

const SettingsModal = ({setSettings}) => {

    const [selectedTab, setSelectedTab] = useState('profile')
    const [isTwitterAuth, setTwitterAuth] = useState(false)
    const [isGithubAuth, setGithubAuth] = useState(false)
    const [isFirst, setFirst] = useState(false)
    const [userInfo, setUserInfo] = useState({})
    const [uploadedImg, setUploadedImg] = useState()
    const [coverImg, setCoverImg] = useState()
    
        const saveUserInfo = async () => {
            //get the user info
            const userDispName = E('user_display_save_name').value
            const userDispBio = E('user_display_save_bio').value
            
            try {
                 if(true) {
                    const id = talk('Saving user info')
                    //check if the url is http and from this domain
                    const url = API_URL + "modify_user&user=" + walletAddress  + "&name=" + encodeURIComponent(userDispName) + "&bio=" + encodeURIComponent(userDispBio)
                    const response = await fetch(url);
                    if (!response.ok) {
                      
                    }
                    const res = await response.json();
                    if(res.status) {
                        //save image if present
                        if(user_disp_image != null || user_cover_image != null) {
                            talk('Saving the image', 'norm', id)
                            const formData = new FormData(); // Create a FormData object
                            // Add the selected file to the FormData object
                            if(user_disp_image) formData.append('file', user_disp_image);
                            if(user_cover_image) formData.append('cover', user_cover_image);
                            // Create an HTTP request
                            const xhr = new XMLHttpRequest();
                            const url = API_URL + "upload_user_img&name=" + walletAddress + ".png&user=" + walletAddress
                            // Define the server endpoint (PHP file)
                            xhr.open('POST', url, true);
                            // Set up an event listener to handle the response
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    console.log(xhr.responseText)
                                    if (xhr.responseText.indexOf("1") > -1) {
                                        stopTalking(2, talk('Profile saved successfully', 'good', id))
                                        if(user_disp_image){
                                            const img = URL.createObjectURL(user_disp_image)
                                            const navUserDispImg = E('nav_user_disp_img');
                                            if (navUserDispImg) {
                                                navUserDispImg.src = img;
                                            } else {
                                                console.warn('Element with ID "nav_user_disp_img" not found');
                                            }
                                        }
                                        //hide the modal and do the celebration effect
                                        setSettings(false)
                                    } else {
                                        stopTalking(2, talk('Unable to save image', 'fail', id))
                                    }
                                } else if (xhr.readyState === 4 && xhr.status !== 200) {
                                     stopTalking(2, talk('Unable to save image', 'fail', id))
                                }
                            };
                            // Send the FormData object with the image
                            xhr.send(formData);
                        }
                        else {
                            stopTalking(2, talk('Saved successfully', 'good', id))
                            //hide the modal and do the celebration effect
                            setSettings(false)
                        }
                    }
                    else {
                        stopTalking(2, talk('Unable to save profile', 'fail', id))
                    }
                }
                else {
                    stopTalking(2, talk('Name field cannot be empty', 'fail', id))
                    return 2
                }
            } catch (error) { console.log(error)
                stopTalking(2, talk('Unable to save profile', 'fail', id))
            }
            
        }
        const authTwitter = () => {
            if(isTwitterAuth){return;}
            const provider = new TwitterAuthProvider(); 
            const auth = getAuth(); 
            signInWithPopup(auth, provider)
            .then(async (result) => { 
                const user = result.user
                //save the refresh token
                 try {
                     if(user.refreshToken) {
                        const shareUri = 'https://x.com/' + result._tokenResponse.screenName
                        const id = talk('Connecting twitter')
                        const url = API_URL + "user_twitter_auth&user=" + walletAddress  + "&code=" + encodeURIComponent(user.refreshToken) + "&url=" + encodeURIComponent(shareUri)
                        const response = await fetch(url);
                        if (!response.ok) {
                           throw new Error("Network response was not ok");
                        }
                        const res = await response.json();
                        if(res.status) {
                            setTwitterAuth(true)
                            talk("Twitter connected successfully", "good", id)
                            stopTalking(3, id)
                        }
                        else {
                            setTwitterAuth(false)
                            talk("Unable to connect twitter account<br>Something went wrong<br>This may be due to network error","fail", id)
                            stopTalking(3, id)
                        }
                    }
                    else {
                        stopTalking(3, talk('Something went wrong', 'fail'))
                    }
                } catch (error) { console.log(error)
                    stopTalking(2.5, talk("Unable to connect twitter", 'fail'))
                }
            }).catch((error) => {
              console.log(error) 
            });
        }
        const authGithub = () => {
            if(isGithubAuth){return;}
            window.open(getGithubUri(walletAddress), '_blank')
        }
        const skipUserInfo = () => {
            setSettings(false)
        }
        /* 2 FACTOR AUTHENTICATION */
        const get2FaCodeURI = async () => {
            if(walletAddress != "") {
                try {
                    const response = await fetch(API_URL + `get_2fa&user=` + walletAddress + "&id=" + Math.random());
                    if (!response.ok) {
                    throw new Error("Network response was not ok");
                    }
                    let res = await response.json();
                    if(res.uri != "") {
                        E('2fa_bar_code').innerHTML = ""
                        QRCode.toDataURL(E("2fa_bar_code"), res.uri, {
                            width:200,
                            height:200,
                            color: {
                                dark:"#000000"
                            }
                        }, (err, url) => {});
                        E('2fa_bar_code').setAttribute('data', 'shown') 
                        E('2fa_auth_code').setAttribute('data', res.secret) 
                    }
                } catch (error) { console.log(error)
                    return "";
                }
            }
        }
        const reg2FaCode = async () => {
            //check if the input field has shown
            if(E('2fa_bar_code').getAttribute('data') === 'shown') {
                E('2fa_bar_code').style.display = 'none'
                E('2fa_auth_code').style.display = 'block'
                E('2fa_auth_msg').innerText = "Please input the OTP showing in your authenticator app"
                E('2fa_bar_code').setAttribute('data', 'otp') //switch to showing otp
            }
            else if (E('2fa_bar_code').getAttribute('data') === 'otp') {
                //verify otp
                try {
                    const code = E('2fa_auth_code').value.trim()
                    const key = E('2fa_auth_code').getAttribute('data') || ""
                    //console.log(key, code)
                    const id = talk('Verifying OTP')
                    const response = await fetch(API_URL + `verify_2fa&code=${code}&key=${key}&user=` + walletAddress + "&id=" + Math.random());
                    if (!response.ok) {
                    stoptalking(3, talk('Network error', 'fail', id))
                    }
                    let res = await response.json();
                    //console.log(res)
                    if(res.status === true) {
                        stopTalking(3, talk('2-Factor authentication enabled', 'good', id))
                        E('2fa_bar_code').style.display = ''
                        E('2fa_auth_code').style.display = 'none'
                        E('2fa_auth_msg').innerText = "Using the app, scan the QR code to continue"
                        E('2fa_bar_code').setAttribute('data', 'shown') //switch to showing otp
                    }
                    else {
                        stopTalking(3, talk('OTP has expired or is invalid', 'fail', id))
                    }
                } catch (error) { console.log(error)
                    return "";
                }
            }
        }

        useEffect(() => {
            //load user profile
            window.walletAddress = localStorage.getItem('selectedWallet') || ""
            window.E = (id) => document.getElementById(id)
            //check if user is connecting for the first time
            const isFirstTimeWallet = localStorage.getItem("lumos_first_time") || ""
            if(isFirstTimeWallet === "true") {
                //show the popup
                localStorage.setItem("lumos_first_time", "false")
                setFirst(true)
            }
            const loadUser = async () =>{
                const user = await getUserInfo(walletAddress)
                if(user !== false) {
                    if(user.status) {
                        const usr = user.user
                        //checking for user auth
                        if(usr['twitter'] && usr['twitter'] != "") {
                            setTwitterAuth(true)
                        }
                        //checking for github auth
                        if(usr['github'] && usr['github'] != "") {
                            setGithubAuth(true)
                        }
                        //set the user name and bio and img
                        setUserInfo(usr)
                        console.log(usr);
                        
                        E('user_display_save_bio').value = usr?.bio
                        E('user_display_save_name').value = usr?.name
                    }
                }
                get2FaCodeURI()
            }
            loadUser()
            //setup the disp image
            //validate the image upload
            validateImageUpload('user_display_save_img', 'user_display_image', 2, (e, url) => { 
                if(e != null) {
                    //optimize the image
                    optimizeImg(url, 0.9, 400, 400).then((img) => { 
                        //update upload file
                        user_disp_image = img
                        setUploadedImg(true)
                    })
                    
                }
            })
            //validate the cover image upload
            validateImageUpload('user_cover_save_img', 'user_cover_image', 2, (e, url) => { 
                if(e != null) {
                    //optimize the image
                    optimizeImg(url, 0.9, 400, 400).then((img) => { 
                        //update upload file
                        user_cover_image = img
                        setCoverImg(true)
                    })
                    
                }
            })
             
        }, [])

  return (
    <div>
        <div className="h-full w-full fixed top-0 left-0 z-[1000]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setSettings(false)}></div>
        <div className="z-[1001] fixed top-[-0.5%] md:w-[500px] w-[85%] translate-x-[-50%] left-[50%] h-full outline-none overflow-x-hidden overflow-y-auto helvetica-font">
            <div className="sm:h-[calc(100%-3rem)] w-full my-6 relative">
                <div className="max-h-full overflow-hidden border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-[11px] outline-none text-current">
                    <div className='flex items-start w-full gap-4 px-4 pt-4 mb-4 text-[13px]'>
                        <p className={selectedTab === 'profile' ? 'cursor-pointer text-[#FF7B1B]' : `cursor-pointer`} onClick={() => setSelectedTab('profile')}>Profile</p>
                        <p className={selectedTab === 'security' ? 'cursor-pointer text-[#FF7B1B]' : `cursor-pointer`} onClick={() => setSelectedTab('security')}>Security</p>
                    </div>
                    <div className="flex-auto overflow-y-auto relative p-4  border-t">
                        {
                            selectedTab === 'profile' &&
                            <div className='w-full'>
                                <div className='w-full px-4 py-2 text-[13px]'>
                                    <p className='mb-1'>Display Name:</p>
                                    <input id='user_display_save_name' type="text" placeholder='Jack Peters' className='outline-none border border-[#D0D5DD] p-2 rounded-[6px] w-full bg-[#fff]'/>
                                </div>
                                <div className='w-full px-4 py-2 text-[13px]'>
                                    <p className='mb-1'>BIO:</p>
                                    <textarea id='user_display_save_bio' className='resize-none outline-none border p-3 rounded-[6px] border-[#D0D5DD] w-full bg-[#fff] text-[#667085]' placeholder='Enter a description...' rows="3" ></textarea>
                                </div>
                                <div className='flex items-center gap-3 w-full pb-4 px-4 pt-2'>
                                {
                                    (isGithubAuth == true)? 
                                    <button className='border border-[#D0D5DD] text-center text-[20px] bg-[#F9FAFB] flex justify-center items-center w-full p-2 rounded-[6px]'>
                                        <img src="/images/github.svg" className='mr-1' alt="" />
                                        Connected
                                    </button>
                                    :
                                    <button onClick={()=>{authGithub()}} className='text-center border border-[#D0D5DD] text-[20px] bg-[#F9FAFB] flex justify-center items-center w-full p-2 rounded-[6px]'>
                                        <img src="/images/github.svg" className='mr-1' alt="" />
                                    </button>
                                }
                                {
                                    (isTwitterAuth == true)? 
                                        <button className='text-center border border-[#D0D5DD] bg-[#F9FAFB] text-[20px] flex justify-center items-center w-full p-2 rounded-[6px]'>
                                            <img src="/images/tweeter-bird.svg" className='mr-1' alt="" />
                                            Connected
                                        </button>
                                        :
                                        <button  onClick={()=>{authTwitter()}} className='text-center border border-[#D0D5DD] bg-[#F9FAFB] text-[20px] flex justify-center items-center w-full p-2 rounded-[6px]'>
                                            <img src="/images/tweeter-bird.svg" className='mr-1' alt="" />
                                        </button>
                                }
                                </div>
                                <div className='w-full px-4 py-2 text-[13px]'>
                                    <div className='mb-3'>
                                        <p className=''>Display Image:</p>
                                        <p className='text-[#667085]'>This will be displayed on your profile.</p>
                                    </div>
                                    <div className='bg-[#fff] cursor-pointer py-6 relative h-[200px] border border-[#EAECF0] rounded-[8px] flex items-center flex-col justify-center'>
                                        <input  id='user_display_save_img' type="file" className='absolute bg-transparent opacity-0 h-full outline-none p-3 border rounded-[8px] w-full'/>
                                        <img id='user_display_image' className='h-[150px] absolute' alt="" />
                                        {
                                            uploadedImg !== true &&
                                            <div className='cursor-pointer text-center h-[70px] flex flex-col items-center' id='user_display_save_img_o' >
                                                <img src="/images/upload.svg" alt="" />
                                                <p className='text-[#667085]'><span className='text-[#0051E8]'>Browse files</span> or drag and drop</p>
                                                <p className='text-[#667085] text-[12px]'>SVG, PNG, JPG or GIF (max. 800x400px)</p>
                                            </div>
                                        }
                                    </div>
                                </div>
                                <div className='w-full px-4 py-2 text-[13px] mt-[0.5rem]'>
                                    <div className='mb-3'>
                                        <p className=''>Cover Photo:</p>
                                        <p className='text-[#667085]'>This will be displayed on your profile.</p>
                                    </div>
                                    <div className='bg-[#fff] cursor-pointer py-6 relative h-[200px] border border-[#EAECF0] rounded-[8px] flex items-center flex-col justify-center'>
                                        <input  id='user_cover_save_img' type="file" className='absolute bg-transparent opacity-0 h-full outline-none p-3 border rounded-[8px] w-full'/>
                                        <img id='user_cover_image' className='h-[150px] absolute' alt="" />
                                        {
                                            coverImg !== true &&
                                            <div className='cursor-pointer text-center h-[70px] flex flex-col items-center' id='' >
                                                <img src="/images/upload.svg" alt="" />
                                                <p className='text-[#667085]'><span className='text-[#0051E8]'>Browse files</span> or drag and drop</p>
                                                <p className='text-[#667085] text-[12px]'>SVG, PNG, JPG or GIF (max. 800x400px)</p>
                                            </div>
                                        }
                                    </div>
                                </div>
                                <div style={{display:'flex', alignItems:'center', gap:'20px', padding:'16px', justifyContent:'flex-end', marginTop:'10px'}}>
                                    <button onClick={()=>{saveUserInfo()}} className='bg-[#FF7B1B] px-5 py-2 rounded-[6px] text-white block w-full'>Save</button>
                                    {
                                        (isFirst)?<button onClick={()=>{skipUserInfo()}} className='border border-[#5F6670] px-5 py-2 rounded-[6px] block w-full text-[#5F6670]'>I'll do it later</button>
                                        :<></>
                                    }
                                </div>
                            </div>
                        }
                            <div style={( selectedTab === "security") ?
                                {}
                                : {display:'none'}
                            } className='w-full p-4'>
                                <p className='font-[600] text-[20px] mb-4'>Enable two-factor authentication</p>
                                <p>1.Download and install an authentication app on your phone. We recommend Twilio Authy, Microsoft Authenticator, and Duo.</p>
                                <canvas id='2fa_bar_code' className='mx-auto my-6'></canvas>
                                
                                <span id='2fa_auth_msg' style={{display:'none'}}></span>
                                <input id='2fa_auth_code' type="text" style={{display:'none'}} className='outline-none border p-3 rounded-[6px] w-full my-5' placeholder='Code...' />
                                <button className='bg-[#FF7B1B] w-full px-5 py-2 rounded-[6px] text-white block ml-auto mr-4' onClick={() => reg2FaCode()}>Continue</button>
                            </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>
  )
}

export default SettingsModal