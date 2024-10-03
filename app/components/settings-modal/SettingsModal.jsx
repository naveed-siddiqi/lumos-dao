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

const SettingsModal = ({setSettings}) => {

    const [selectedTab, setSelectedTab] = useState('profile')
    const [isTwitterAuth, setTwitterAuth] = useState(false)
    const [isGithubAuth, setGithubAuth] = useState(false)
    const [isFirst, setFirst] = useState(false)
    
        const saveUserInfo = async () => {
            //get the user info
            const userDispName = E('user_display_save_name').value
            const userDispBio = E('user_display_save_bio').value
            
            try {
                 if(userDispName != "" && userDispBio != "") {
                    const id = talk('Saving user info')
                    //check if the url is http and from this domain
                    const url = API_URL + "modify_user&user=" + walletAddress  + "&name=" + encodeURIComponent(userDispName) + "&bio=" + encodeURIComponent(userDispBio)
                    const response = await fetch(url);
                    if (!response.ok) {
                      
                    }
                    const res = await response.json();
                    if(res.status) {
                        //save image if present
                        if(user_disp_image != null) {
                            talk('Saving the image', 'norm', id)
                            const formData = new FormData(); // Create a FormData object
                            // Add the selected file to the FormData object
                            formData.append('file', user_disp_image);
                            // Create an HTTP request
                            const xhr = new XMLHttpRequest();
                            const url = API_URL + "upload_user_img&name=" + walletAddress + ".png&user=" + walletAddress
                            // Define the server endpoint (PHP file)
                            xhr.open('POST', url, true);
                            // Set up an event listener to handle the response
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    console.log(xhr.responseText)
                                    if (xhr.responseText == "1") {
                                        stopTalking(2, talk('Profile saved successfully', 'good', id))
                                        const img = URL.createObjectURL(user_disp_image)
                                        E('nav_user_disp_img').src = img
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
                        }
                    }
                    else {
                        stopTalking(2, talk('Unable to save profile', 'fail', id))
                    }
                }
                else {return 2}
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
                    }
                }
                get2FaCodeURI()
            }
            loadUser()
            //setup the disp image
            //validate the image upload
            validateImageUpload('user_display_save_img', 'user_display_save_img_o', 1, (e, url) => { 
                if(e != null) {
                    //optimize the image
                    optimizeImg(url, 0.9, 400, 400).then((img) => { 
                        //update upload file
                        user_disp_image = img
                    })
                    
                }
            })
             
        }, [])

  return (
    <div>
        <div className="h-full w-full fixed top-0 left-0 z-[99]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setSettings(false)}></div>
        <div className="z-[100] fixed top-[3%] md:w-[600px] w-[85%] translate-x-[-50%] left-[50%] h-full outline-none overflow-x-hidden overflow-y-auto">
            <div class="sm:h-[calc(100%-3rem)] w-full my-6 relative">
                <div class="max-h-full overflow-hidden border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <div className='flex items-start w-full gap-4 px-4 pt-4 mb-4'>
                        <p className='cursor-pointer' onClick={() => setSelectedTab('profile')}>Profile</p>
                        <p className='cursor-pointer' onClick={() => setSelectedTab('security')}>Security</p>
                    </div>
                    <div class="flex-auto overflow-y-auto relative p-4  border-t">

                        {
                            selectedTab === 'profile' &&
                            <div className='w-full'>
                                <div className='w-full p-4'>
                                    <p className='mb-1'>Display Name(optional):</p>
                                    <input id='user_display_save_name' type="text" className='outline-none border p-3 rounded-[6px] w-full bg-[#EFF2F6]'/>
                                </div>
                                <div className='w-full p-4'>
                                    <p className='mb-1'>BIO:</p>
                                    <textarea id='user_display_save_bio'  className='outline-none border p-3 rounded-[6px] w-full bg-[#EFF2F6]' rows="2" ></textarea>
                                </div>
                                <div className='flex items-center gap-3 w-full p-4'>
                                {
                                    (isTwitterAuth == true)? 
                                        <button className='border border-gray-500 bg-[#EFF2F6] text-[20px] flex items-center w-full p-2 rounded-[6px]'>
                                            <BsTwitterX className='text-[26px] mr-1'/>
                                            Connected
                                        </button>
                                        :
                                        <button  onClick={()=>{authTwitter()}} className='border border-gray-500 bg-[#EFF2F6] text-[20px] flex items-center w-full p-2 rounded-[6px]'>
                                            <BsTwitterX className='text-[26px] mr-1'/>
                                            x.com
                                        </button>
                                }
                                {
                                    (isGithubAuth == true)? 
                                    <button className='border border-gray-500 text-[20px] bg-[#EFF2F6] flex items-center w-full p-2 rounded-[6px]'>
                                        <VscGithub className='text-[26px] mr-1' /> Connected
                                    </button>
                                    :
                                    <button onClick={()=>{authGithub()}} className='border border-gray-500 text-[20px] bg-[#EFF2F6] flex items-center w-full p-2 rounded-[6px]'>
                                        <VscGithub className='text-[26px] mr-1' /> github
                                    </button>
                                }
                                </div>
                                <div className=' w-full p-4'>
                                    <p className='mb-3 font-[500]'>Display Image:</p>
                                    <div className='font-[500] bg-[#EFF2F6] cursor-pointer py-6 relative h-full border rounded-[8px] flex items-center flex-col justify-center'>
                                        <input  id='user_display_save_img' type="file" className='absolute bg-transparent opacity-0 h-full outline-none p-3 border rounded-[8px] w-full'/>
                                        <div id='user_display_save_img_o' style={{maxWidth:'50px', maxHeight:'50px'}}>Browse Computer</div>
                                        <BsUpload className='text-[24px]'/>
                                    </div>
                                </div>
                                <div style={{display:'flex', alignItems:'center', justifyContent:'flex-end', marginTop:'10px'}}>
                                    {
                                        (isFirst)?<button onClick={()=>{skipUserInfo()}} className='border border-gray-600 bg-green-600 px-5 py-2 rounded-[6px] text-white block mr-4'>I'll do it later</button>
                                        :<></>
                                    }
                                    <button onClick={()=>{saveUserInfo()}} className='bg-green-600 px-5 py-2 rounded-[6px] text-white block mr-4'>Save</button>
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
                                <button className='bg-green-600 px-5 py-2 rounded-[6px] text-white block ml-auto mr-4' onClick={() => reg2FaCode()}>Continue</button>
                            </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>
  )
}

export default SettingsModal