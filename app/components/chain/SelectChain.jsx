'use client'

import React, { useEffect, useState } from 'react'

const SelectChain = ({chain, name}) => {
    const [flag, setFlag] = useState(true)
    
    const check = () =>{
       const walletAddress = localStorage.getItem('selectedWallet') || ""
       const CHAIN = (localStorage.getItem('LUMOS_CHAIN') || "").toLowerCase()
       //check if connected
       if(walletAddress != ""){
            if(chain && chain != ""){
                if(CHAIN == chain){
                    setFlag(true)
                }
                else{
                    setFlag(false)
                }
            }
        }
        else{setFlag(true)}
    }
    useEffect(() => {
      //get the connected chain
      check()
    },[])

    useEffect(() => {
       check()
    }, [chain])

  return (
    <>
    {!flag && 
        <div className='fixed top-[0px] z-[1000] left-[0px] flex items-center helvetica-font'
        style={{width:'100vw', height:'100vh', justifyContent:'center', background:'rgba(0,0,0,.3)'}}>
            <div class="w-full max-w-xs p-4 mb-4 text-black-500 bg-white shadow dark:text-gray-400" role="alert">
                 <span>The connected chain does not support this action.<br/>
                 Please <span className='text-blue-500' style={{cursor:'pointer'}}
                 onClick={() => {
                    localStorage.setItem('selectedWallet', "")
                    localStorage.setItem('LUMOS_WALLET', "")
                    localStorage.setItem('LUMOS_CHAIN', '')
                    window.location.reload()
                 }}>switch to {name}</span></span>
            </div>
        </div>
    }
    </>
  )
}

export default SelectChain