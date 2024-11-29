'use client'

import React, { useEffect, useMemo, useState } from 'react'
import Image from 'next/image'
import Link from 'next/link'
import { FiCopy } from 'react-icons/fi'
import Alert from '../alert/Alert'
import { fAddr, fNum, getUserInfo } from '@/app/core/getter'
import { API_URL, BACKEND_API } from '@/app/data/constant' 
import { BiMenu } from 'react-icons/bi'
import { IoIosInfinite } from "react-icons/io";
import { getUsersFirst } from '@/app/core/core'


let hasLoad = false;
let hasLoadUserFirst = false;
let currentLocation;

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
    currentLocation = window.location.pathname
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
    //do the connect wallet listener
    setInterval((e) => {
      if(window.TRIGGER_CONNECT_WALLET) {
        setConnectWallet(true)
        window.TRIGGER_CONNECT_WALLET = false
      }
    }, 500)
  }, [user])

  //if(user != "") {auth2Fa(user)} //check for 2faa
  return (
    <div className={mobileMenu ? 'flex items-center justify-between fixed w-full md:px-[6.5rem] px-[1rem] py-3 bg-white z-[1100] helvetica-font' : 'flex items-center justify-between md:px-[6.5rem] px-[1rem] py-3 bg-white helvetica-font'}>
      {
        user ?
        <div className='flex items-center justify-between w-full'>
          <div className='flex items-center gap-[2rem]'>
            <a href='/dao' className='flex items-end gap-1 border-r pr-[26px]'>
              <Image
                src="/images/Image.png"
                width={50}
                height={50}
                className='w-[50px] h-[50px] object-contain'
                alt="Picture of the logo"
              />
              <p className='font-[500] lg:text-[17px] text-[#141B34] hidden md:block'>LUMOS DAO</p>
              {/* <p className='bg-red-500 py-[2px] px-[6px] rounded-[6px] text-white'>v2.0</p> */}
            </a>
            <div className='hidden md:flex items-center gap-10'>
              {
                user && (
                  <div className='flex items-center gap-10 '>
                    <a href='#' className={currentLocation.includes("/nft") ? 'flex items-center gap-[6px] bg-[#F6F6F8] rounded-[8px] text-[15px] py-2 px-2 text-[#FF7B1B]':'flex items-center gap-[6px] text-[15px] rounded-[8px] py-2 px-2 text-[#5F6670]'}>
                      {
                        currentLocation?.includes('/nft') ?
                        <img src="/images/nft.svg" alt="" />
                        :
                        <img src="/images/nft-plain.svg" alt="" />
                      }
                      <p>NFT staking</p>
                    </a>
                    <a href='/inbox' className={currentLocation.includes("/inbox") ? 'flex items-center gap-[6px] bg-[#F6F6F8] rounded-[8px] text-[15px] py-2 px-2 text-[#FF7B1B]':'flex items-center gap-[6px] text-[15px] rounded-[8px] py-2 px-2 text-[#5F6670]'}>
                      {
                        currentLocation?.includes('/inbox') ?
                        <img src="/images/inbox-colored.svg" alt="" />
                        :
                        <img src="/images/inbox.svg" alt="" />
                      }
                      <p>Inbox</p>
                      <p id='nav_user_inbox' className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_inbox'] || 0)}</p>
                    </a>
                    <a href='/alerts' className={currentLocation.includes("/alert") ? 'flex items-center gap-[6px] bg-[#F6F6F8] rounded-[8px] text-[15px] py-2 px-2 text-[#FF7B1B]':'flex items-center gap-[6px] text-[15px] rounded-[8px] py-2 px-2 text-[#5F6670]'}>
                      <img src="/images/alert.svg" alt="" />
                      <p>Alert</p>
                      <p id='nav_user_alert_num' className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_alert'] || 0)}</p>
                    </a>
                    <a href='#' className={currentLocation.includes("/credit") ? 'flex items-center gap-[6px] bg-[#F6F6F8] rounded-[8px] text-[15px] py-2 px-2 text-[#FF7B1B]':'flex items-center gap-[6px] text-[15px] rounded-[8px] py-2 px-2 text-[#5F6670]'}>
                      <img src="/images/credit.svg" alt="" />
                      <p>Credits</p>
                    </a>
                  </div>
                )
              }
              
              {
                !user && (
                  <div className='font-[600] flex items-center gap-3'>
                    <a href='/dao' className='bg-[#FF7B1B] text-white px-[40px] py-2 rounded-[12px]'>Enter App</a>
                  </div>
                )
              }
            </div>
          </div>
          <div>
            {
              user &&
              <div className='relative' onMouseLeave={() => setUserDropdown(false)}>
                <div className='flex items-center gap-4 bg-[#F6F6F8] rounded-[8px] py-2 pl-2 pr-4' onMouseEnter={() => setUserDropdown(true)}>
                  <div className='flex items-center gap-2'>
                    <img id='user_nav_img' src={API_URL + "user_img&user=" + user} className='rounded-full w-[20px] h-[20px] object-cover' alt="" />
                    <p className='cursor-pointer text-[#141B34] text-[12px]'>{fAddr(user, 6)}</p>
                  </div>
                  <img src="/images/chevron-down.svg" alt="" />
                </div>
                {
                  userDropdown && (
                    <div
                      className='text-[14px] absolute z-[1002] w-[184px] flex items-start rounded-md gap-2 flex-col border shadow-lg right-0 top-[38px] bg-white shadow-[0px 2px 4px rgba(0, 0, 0, 0.1)]'
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
                        localStorage.setItem('LUMOS_CHAIN', '')
                        //disconnect from xama
                        window.location.assign("/")
                      }}>Disconnect</p>
                    </div>
                  )
                }
              </div>
            }
          </div>
        </div>
        :
        <div className='flex items-center gap-3 justify-between w-full'>
          <a href='/' className='flex items-end gap-1'>
            <Image
              src="/images/Image.png"
              width={50}
              height={50}
              className='w-[50px] h-[50px] object-contain'
              alt="Picture of the logo"
              />
            <p className='font-[500] text-[#141B34] lg:text-[20px]'>LUMOS DAO</p>
            {/* <p className='bg-red-500 py-[2px] px-[6px] rounded-[6px] text-white'>v2.0</p> */}
          </a>
          <div className='md:flex hidden items-center gap-3'>
            {
              currentLocation !== "/" ?
              <button onClick={() => {
                setConnectWallet(true)
                setMobileMenu(false)
              }} className='bg-[#F6F6F8] text-[#141B34] px-5 py-2 rounded font'>Connect Wallet</button>
              :
              <a href='/dao' onClick={() => setMobileMenu(false)} className='bg-[#FF7B1B] text-white px-[40px] py-2 rounded-[12px]'>Enter App</a>
            }
          </div>
        </div>
      }

      {
        mobileMenu ?
        <div onClick={() => setMobileMenu(false)} className='cursor-pointer block md:hidden px-2 py-[10px] bg-[#F6F6F8] rounded-[6px] ml-[6px]'>
            <img src='/images/close.svg'/>
        </div>
        :
        <div onClick={() => setMobileMenu(true)} className='cursor-pointer block md:hidden px-2 py-[10px] bg-[#F6F6F8] rounded-[6px] ml-[6px]'>
            <img src='/images/menu.svg'/>
        </div>
      }

    {
      mobileMenu && 
      <div className='flex md:hidden items-center flex-col gap-10 fixed bg-white w-[100%] left-[50%] right-[50%] top-[70px] translate-x-[-50%] z-[1000]'>
          {
            user && (
              <>
                <div className="h-[100dvh] w-full fixed top-0 left-0" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setMobileMenu(false)}></div>
                <div className='flex flex-col items-center gap-3 bg-white z-[1001] w-full py-5 px-[15px] rounded-b'>
                  <a onClick={() => setMobileMenu(false)} href='#' className={currentLocation.includes("/nft") ? 'flex items-center gap-[6px] bg-[#F6F6F8] justify-center text-[15px] py-2 px-2 text-[#FF7B1B] border-b w-full text-center mt-[5px]':'flex items-center justify-center gap-[6px] text-[15px] py-2 px-2 text-[#5F6670] border-b w-full mt-[5px]'}>
                    {
                      currentLocation?.includes('/nft') ?
                      <img src="/images/nft.svg" alt="" />
                      :
                      <img src="/images/nft-plain.svg" alt="" />
                    }
                    <p>NFT staking</p>
                  </a>
                  <a onClick={() => setMobileMenu(false)} href='/inbox' className={currentLocation.includes("/inbox") ? 'flex items-center justify-center gap-[6px] bg-[#F6F6F8] text-[15px] py-2 px-2 text-[#FF7B1B] border-b w-full text-center mt-[5px]':'flex items-center justify-center gap-[6px] text-[15px] py-2 px-2 text-[#5F6670] border-b w-full text-center mt-[5px]'}>
                    {
                      currentLocation?.includes('/inbox') ?
                      <img src="/images/inbox-colored.svg" alt="" />
                      :
                      <img src="/images/inbox.svg" alt="" />
                    }
                    <p>Inbox</p>
                    <p id='nav_user_inbox' className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_inbox'] || 0)}</p>
                  </a>
                  <a onClick={() => setMobileMenu(false)} href='/alerts' className={currentLocation.includes("/alert") ? 'flex items-center justify-center gap-[6px] bg-[#F6F6F8] text-[15px] py-2 px-2 text-[#FF7B1B] border-b w-full text-center mt-[5px]':'flex items-center justify-center gap-[6px] text-[15px] py-2 px-2 text-[#5F6670] border-b w-full text-center mt-[5px]'}>
                    {
                      currentLocation?.includes('/alert') ?
                      <img src="/images/alert-color.svg" alt="" />
                      :
                      <img src="/images/alert.svg" alt="" />
                    }
                    <p>Alert</p>
                    <p id='nav_user_alert_num' className='bg-[#FFA502] py-[1px] px-[5px] mb-[15px] text-[12px] rounded-full text-white'>{fNum(userData['unread_alert'] || 0)}</p>
                  </a>
                  <a onClick={() => setMobileMenu(false)} href='#' className={currentLocation.includes("/credit") ? 'flex items-center justify-center gap-[6px] bg-[#F6F6F8] text-[15px] py-2 px-2 text-[#FF7B1B] border-b w-full text-center mt-[5px]':'flex items-center justify-center gap-[6px] text-[15px] py-2 px-2 text-[#5F6670] border-b w-full text-center mt-[5px]'}>
                    <img src="/images/credit.svg" alt="" />
                    <p>Credits</p>
                  </a>
                </div>
              </>
            )
          }
          {
            !user && (
              <div className='flex items-center gap-3 py-4'>
                {
                  currentLocation === "/dao" ?
                  <button onClick={() => {
                    setConnectWallet(true)
                    setMobileMenu(false)
                  }} className='bg-[#F6F6F8] text-[#141B34] px-5 py-2 rounded font'>Connect Wallet</button>
                  :
                  <a href='/dao' onClick={() => setMobileMenu(false)} className='bg-[#FF7B1B] text-white px-[40px] py-2 rounded-[12px]'>Enter App</a>
                }
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
