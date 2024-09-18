'use client'

import React, { useEffect, useMemo, useState } from 'react'
import Image from 'next/image'
import Link from 'next/link'
import { FiCopy } from 'react-icons/fi'
import Alert from '../alert/Alert'
import { fAddr, fNum, getUserInfo } from '@/app/core/getter'
import { BACKEND_API } from '@/app/data/constant' 
import { BiMenu } from 'react-icons/bi'
import { IoIosInfinite } from "react-icons/io";
import { getUsersFirst } from '@/app/core/core'


let hasLoad = false;let hasLoadUserFirst = false
const Navbar = ({ setConnectWallet, setSettings, settings }) => {
  const [user, setUser] = useState(null)
  const [userData, setUserData] = useState({})
  let currentRoute = "";

  const [userDropdown, setUserDropdown] = useState(false)
  const [msg, setMsg] = useState("")
  const [alertType, setAlertType] = useState("")
  const [mobileMenu, setMobileMenu] = useState(false)

  const showWalletOnFirstConnect = async () => {
      //check if user is connecting for the first time
      if(hasLoadUserFirst) return;
      hasLoadUserFirst = true
      if(walletAddress != ""){
        const isUserNew = await getUsersFirst(walletAddress)
        if(isUserNew == false) {
          //reload the function again
          setTimeout(() => {hasLoadUserFirst = false;showWalletOnFirstConnect()}, 1000)
          return
        }
        if(isUserNew['status']) {
          if(isUserNew['new'] == 1) {
            //show the popup
            localStorage.setItem("lumos_first_time", "true")
            setSettings(true)
            return;
          }
        }
        else {
          if(isUserNew['new'] == undefined) {
            localStorage.setItem("lumos_first_time", "true")
            setSettings(true)
            return;
          }
        }
      }
  }
  const loadUser = async () => {
    if(walletAddress != ""){ 
      //check if its in homepage and redirect
      showWalletOnFirstConnect()
      if(!hasLoad){
          hasLoad = true
          const user = await getUserInfo(walletAddress)
          try{
            setUserData({
              image:"https://id.lobstr.co/" + walletAddress + ".png"
            })
            if(user !== false) {
              if(user.status){
                  user.user['image'] = (user.user['image'] !== "" ? user.user['image'] : ("https://id.lobstr.co/" + walletAddress + ".png"))
                  setUserData(user.user)
                  if(user.user['2fa_secret_key'] != '' && user.user['2fa_auth'] != 'true' && currentRoute != '/2fa') {
                      //redirect to 2fa page
                      window.location.assign('/2fa')
                  }
                  
              }
            }
          }
          catch(e){
              console.log(e)
              //retry in the next second
              //setTimeout(()=>{load(user)}, 1000)
          }
      }
      
    }
  }

  async function setupNotifications() {  
    try{
        if ('Notification' in window) {  
            if (window.Notification.permission === 'default') {
                await window.Notification.requestPermission();
            }
        }
        if ('serviceWorker' in navigator) {
            //subscribe to notifcations
            const service = await navigator.serviceWorker.register('/service-worker.js', {scope:'/'});
            //subscribe to the push request
            console.log("Subscribing to push notifications..");
            if(walletAddress != "" && service){
                const isSubscribe = localStorage.getItem(`lumos_notification_subscribe`) || "false"
                if(isSubscribe !== "true"){
                    const subscription = await service.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: urlBase64ToUint8Array(process.env.NEXT_PUBLIC_publicVapidKey),
                    });
                    const res = await fetch(`${BACKEND_API}/notifications/subscribe`, {
                        method: "POST",
                        body: JSON.stringify(
                            {
                                subscription,
                                userId:walletAddress
                            }),
                        headers: {
                          "content-type": "application/json",
                        },
                    });
                    if(res.ok) {
                        const resp = await res.json()
                        if(resp.status) {
                            //save to localstorage
                            localStorage.setItem(`lumos_notification_subscribe`,"true")
                        }
                }
                }
            }
        }
    }
    catch(e){console.log(e)}
  }
  function urlBase64ToUint8Array(base64String) {
    const padding = "=".repeat((4 - (base64String.length % 4)) % 4);
    const base64 = (base64String + padding)
      .replace(/\-/g, "+")
      .replace(/_/g, "/");

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
  }

  useEffect(() => {
    currentRoute = new URL(window.location.href).pathname;
    //check if its using wallet connect
    const walletType = localStorage.getItem('LUMOS_WALLET') || ""
    if(walletType == 'wallet_connect') {
      //check if connection has expired
      const session = localStorage.getItem('LUMOS_WALLET_CONNECT_EXPIRY') || 0
      if((new Date().getTime() / 1E3) > (session*1)){
          //has expired..
          localStorage.setItem('selectedWallet', '') 
          localStorage.setItem('LUMOS_WALLET', '') 
          localStorage.setItem('LUMOS_WALLET_CONNECT_EXPIRY', 0)
      }
    }
    window.walletAddress = localStorage.getItem('selectedWallet') || ""
    setUser(localStorage.getItem('selectedWallet'))
    loadUser()
    setupNotifications()
  }, [user])

   

  //if(user != "") {auth2Fa(user)} //check for 2faa
  return (
    <div className='flex items-center justify-between md:px-[3rem] px-[1rem] mt-3'>
      {
        user ?
        <a href='/dao' className='flex items-end gap-1'>
          <Image
            src="/images/Image.png"
            width={50}
            height={50}
            className='w-[50px] h-[50px] object-contain'
            alt="Picture of the logo"
          />
          <p className='font-[500] lg:text-[22px]'>LUMOS DAO</p>
          <p className='bg-red-500 py-[2px] px-[6px] rounded-[6px] text-white'>v2.0</p>
        </a>
        :
        <a href='/' className='flex items-end gap-1'>
          <Image
            src="/images/Image.png"
            width={50}
            height={50}
            className='w-[50px] h-[50px] object-contain'
            alt="Picture of the logo"
            />
          <p className='font-[500] lg:text-[22px]'>LUMOS DAO</p>
          <p className='bg-red-500 py-[2px] px-[6px] rounded-[6px] text-white'>v2.0</p>
        </a>
      }

      <BiMenu className='text-[30px] cursor-pointer block md:hidden' onClick={() => setMobileMenu(!mobileMenu)}/>

     <div className='hidden md:flex items-center gap-10'>
        {
          user && (
            <div className='flex items-center gap-10 '>
              <Link href='#'>NFT staking</Link>
              <div className='flex gap-[3px] items-center'>
                <Link href='/inbox'>Inbox</Link>
                <p id='nav_user_inbox' className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_inbox'] || 0)}</p>
              </div>
              <div className='flex gap-[3px] items-center'>
                <Link href='/alerts'>Alert</Link>
                <p id='nav_user_alert_num' className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_alert'] || 0)}</p>
              </div>
              <div className='flex gap-[3px] items-center'>
                <Link href='#'>Credits</Link>
                <IoIosInfinite className='text-[#FFA502] text-[25px]'/>
                {/* <p id='nav_user_inbox' className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_inbox'] || 0)}</p> */}
              </div>
            </div>
          )
        }
        {
          user &&
          <div className='relative' onMouseLeave={() => setUserDropdown(false)}>
            <div className='flex items-center gap-2' onMouseEnter={() => setUserDropdown(true)}>
              <img id='user_nav_img' src={userData['image'] || ""} className='rounded-full w-[30px]' alt="" />
              <p className='cursor-pointer'>{fAddr(user, 6)}</p>
            </div>
            {
              userDropdown && (
                <div
                  className='text-[14px] absolute z-[999] w-[200px] flex items-start rounded-md gap-2 flex-col border shadow-lg right-0 top-[22px] bg-white shadow-[0px 2px 4px rgba(0, 0, 0, 0.1)]'
                  onMouseEnter={() => setUserDropdown(true)}
                  onMouseLeave={() => setUserDropdown(false)}
                >
                  <div onClick={() => {
                    navigator.clipboard.writeText(user)
                    setMsg('Address copied successfully!')
                    setAlertType('success')
                    setUserDropdown(false)
                  }} className='cursor-pointer flex items-center gap-2 hover:bg-gray-100 w-full py-[7px] px-3'>
                    <FiCopy />
                    <p>Copy Address</p>
                  </div>
                  <Link href={`/user/${walletAddress}`} onClick={() => setUserDropdown(false)} className='hover:bg-gray-100 w-full py-[7px] px-3 block'>Profile</Link>
                  <Link href='#' onClick={() => {
                      setUserDropdown(false)
                      setSettings(!settings)
                    }} className='hover:bg-gray-100 w-full py-[7px] px-3 block'>Settings</Link>
                  <p className='cursor-pointer hover:bg-gray-100 w-full py-[7px] px-3 block' onClick={() => {
                    localStorage.setItem('selectedWallet', "")
                    localStorage.setItem('LUMOS_WALLET', "")
                    window.location.assign("/")
                  }}>Disconnect</p>
                </div>
              )
            }
          </div>
        }
        {
          !user && (
            <div className='font-[600] flex items-center gap-3'>
              <Link href='/'>Home</Link>
              <button onClick={() => setConnectWallet(true)} className='bg-[#DC6B19] text-white px-5 py-2 rounded font-[500]'>Connect Wallet</button>
            </div>
          )
        }
    </div>

    {
      mobileMenu && 
      <div className='flex md:hidden items-center flex-col gap-10 fixed bg-white w-[90%] p-7 left-[50%] right-[50%] top-[80px] translate-x-[-50%] z-[100]'>
          {
            user && (
              <div className='flex items-center flex-col gap-10'>
                <Link onClick={() => setMobileMenu(false)} href='/dao'>Home</Link>
                <div className='flex gap-[3px] items-center'>
                <Link onClick={() => setMobileMenu(false)} href='/inbox'>Inbox</Link>
                <p className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_inbox'] || 0)}</p>
                </div>
                <div className='flex gap-[3px] items-center'>
                  <Link onClick={() => setMobileMenu(false)} href='/alerts'>Alert</Link>
                  <p id='nav_user_alert_num' className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_alert'] || 0)}</p>
                </div>
              </div>
            )
          }
          {
            user &&
            <div className='relative' onMouseLeave={() => setUserDropdown(false)}>
              <div className='flex items-center gap-2' onMouseEnter={() => setUserDropdown(true)}>
                <img id='user_nav_img_other' src={userData['image'] || ""} className='rounded-full w-[30px]' alt="" />
                <p className='cursor-pointer'>{user}</p>
              </div>
              {
                userDropdown && (
                  <div
                    className='text-[14px] absolute w-[200px] flex items-start rounded-md gap-2 flex-col border shadow-lg right-0 top-[22px] bg-white shadow-[0px 2px 4px rgba(0, 0, 0, 0.1)]'
                    onMouseEnter={() => setUserDropdown(true)}
                    onMouseLeave={() => setUserDropdown(false)}
                  >
                    <div onClick={() => {
                      navigator.clipboard.writeText(user)
                      setMsg('Address copied successfully!')
                      setAlertType('success')
                      setUserDropdown(false)
                      setMobileMenu(false)
                    }} className='cursor-pointer flex items-center gap-2 hover:bg-gray-100 w-full py-[7px] px-3'>
                      <FiCopy />
                      <p>Copy Address</p>
                    </div>
                    <Link href='/user' onClick={() => {
                      setUserDropdown(false)
                      setMobileMenu(false)
                    }} className='hover:bg-gray-100 w-full py-[7px] px-3 block'>Profile</Link>
                    <Link id='nav_bar_settings' href='#' onClick={() => {
                        setUserDropdown(false)
                        setSettings(!settings)
                        setMobileMenu(false)
                      }} className='hover:bg-gray-100 w-full py-[7px] px-3 block'>Settings</Link>
                    <p className='cursor-pointer hover:bg-gray-100 w-full py-[7px] px-3 block' onClick={() => {
                      localStorage.setItem('selectedWallet', "")
                      localStorage.setItem('LUMOS_WALLET', "")
                      window.location.reload()
                    }}>Disconnect</p>
                  </div>
                )
              }
            </div>
          }
          {
            !user && (
              <div className='font-[600] flex items-center gap-3'>
                <Link href='/'>Home</Link>
                <button onClick={() => setConnectWallet(true)} className='bg-[#DC6B19] text-white px-5 py-2 rounded font-[500]'>Connect Wallet</button>
              </div>
            )
          }
      </div> 
    }

      {
        msg && (
          <Alert msg={msg} alertType={alertType} setMsg={setMsg} />
        )
      }
    </div>
  )
}

export default Navbar
