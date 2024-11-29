"use client"


import React, { useEffect, useState } from 'react'
import Link from 'next/link'
import Alert from '../../components/alert/Alert';
import { useRouter } from 'next/navigation';
import { switchChain } from '@/app/core/core';

const page = () => {

    const [selectedBlockchain, setSelectedBlockchain] = useState('')
    const [msg, setMsg] = useState('')
    const [alertType, setAlertType] = useState("")
    const router = useRouter();

    const blockchains = [
        {
            name: 'stellar',
            icon: '/images/stellar-network.svg',
            extra: "L1 Blockchain",
            chainName: 'XLM'
        },
        {
            name: 'ripple',
            icon: '/images/xrp-network.svg',
            extra: "L1 Blockchain",
            chainName: 'XRP'
        }
    ]

    function hanndleNextBtnClick(){
        if(selectedBlockchain === ''){
            setMsg('Please select a blockchain')
            setAlertType('warning')
        } else {
            //check if selected chain is the right chain
            if(selectedBlockchain.name == 'stellar' && CHAIN != 'stellar') {
                //switch to stellar
                switchChain()
            }
            else if(selectedBlockchain.name == 'ripple' && CHAIN != 'xrp') {
                //switch to stellar
                switchChain()
            }
            else{
                router.push(`/create-dao/project-type`)
                // navigate to next page
            }
        }
    }

    useEffect(() => {
        if(window.CHAIN == 'stellar') {
            setSelectedBlockchain({name:'stellar'})
        }
        else if(window.CHAIN == 'xrp'){
            setSelectedBlockchain({name:'ripple'})
        }
    }, [])

  return (
    <div className="mt-[1rem] lg:mx-[7rem] md:mx-[4rem] mx-[1rem] bg-white text-center h-[100dvh] helvetica-font">
        <p className='pt-[6rem] font-[500] lg:text-[22px] text-[18px]'>Choose blockchain</p>
        <p className='text-[#52606D] lg:w-[53%] md:w-[70%] w-[90%] lg:text-[16px] text-[12px] mx-auto mt-[14px] mb-[4rem]'>The chain you choose is where your tokens and assets are stored. If you already have a token, choose the chain your token is minted on. This cannot be changed later</p>
        <div className='flex gap-2 justify-center flex-col sm:w-[400px] w-[95%]  mx-auto bg-[#F9FAFB] px-2 py-7 blockchain-div-container'>

            {
                blockchains.map((blockchain, index) => (
                    <div key={index} className='blockchain-div text-left py-3 px-2 flex items-center justify-between cursor-pointer' onClick={() => setSelectedBlockchain(blockchain)}>
                        <div className='flex items-center gap-[6px]'>
                            <img src={blockchain.icon} alt="" />
                            <div>
                                <p className='text-[14px]' style={{textTransform:'capitalize'}}>{blockchain.name} <span className='text-[#9293A0]'>{blockchain.chainName}</span> </p>
                                <p className='text-[#9293A0] text-[10px]'>{blockchain.extra}</p>
                            </div>
                        </div>
                        {
                            selectedBlockchain.name === blockchain.name ?
                            <img src="/images/check-mark.svg" alt="" />
                            :
                            <img src="/images/empty-check.svg" alt="" />
                        }
                    </div>
                ))
            }
        </div>
        <div className='flex items-center sm:w-[400px] w-[95%] mx-auto justify-between mt-7'>
            <Link href='/create-dao/get-started' className='flex items-center gap-5 bg-[#E6E7E8] text-[#141B34] rounded-[4px] px-6 py-2'>
                <img src="/images/arrow-left.svg" alt="" />
                <p>Back</p>
            </Link>
            <button onClick={hanndleNextBtnClick} className='flex items-center gap-5 bg-[#FF7B1B] text-[#fff] rounded-[4px] px-6 py-2'>
                <p>Next</p>
                <img src="/images/arrow-right.svg" alt="" />
            </button>
        </div>
        {
            msg && (
                <Alert msg={msg} alertType={alertType} setMsg={setMsg} />
            )
        }
    </div>
  )
}

export default page