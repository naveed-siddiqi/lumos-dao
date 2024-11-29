'use client'

import Link from 'next/link'
import React, { useEffect, useMemo, useState } from 'react'
import { fAddr, getTx, isChain } from '../core/getter';
import { stellarExpert, xrpExplorer, TOML_URL } from '../data/constant';
import { paginate } from '../core/core';


let txInfo = []
let hasLoad = false;

const Explorer = () => {
     
    const setUp = async () => {
        if(!hasLoad){
            hasLoad = true
            //get all the tx
            txInfo = await getTx()
            paginate('tx_info', txInfo, 10, drawExp)
        }
    }
    
    const drawExp = (txInfo) => {
        const tx = JSON.parse(txInfo);let link="";
        if(tx.data.length >= 56){
            link=  `/dao/` + tx.data
        }
        else if(tx.data.toLowerCase().indexOf('proposal') > -1){
            link=  `/dao/` + JSON.parse(tx.data || "{}").dao + "/proposal/" + JSON.parse(tx.data).proposal
        }
        else{
            link=tx.hash
        } 
        const params = {
            address:tx.signer,
            action:tx.action,
            date:(new Date(tx.date)).toLocaleString(),
            link:link,
            userLink:'/user/'+tx.signer,
            type:tx.type,
            hash:tx.hash || ""
        }
        const elem = `<div class='text-[12px] flex items-start justify-between border-[#EFEFEF] border-b p-3 rounded-[6px] my-3 flex-col md:items-center md:flex-row gap-3'>
                        <div class='flex items-center gap-2'>
                            <p class="text-[#027A48] bg-[#ECFDF3] py-[5px] px-[12px] rounded-full">${params.type}</p>
                            <a href='${params.userLink}'>${fAddr(params.address,6)}</a>
                            <a href="${params.link}">${params.action}</a>
                            <a style='display:${(params.hash != "") ? "" : 'none'}' target='_blank' href="${(isChain(tx.signer))=='stellar'?`${stellarExpert}/tx/`:`${xrpExplorer}/transactions/`}${params.hash}" class='text-blue-600 underline'>View on Explorer</a>
                        </div>
                        <div class='flex items-center gap-2'>
                            <p>${params.date}</p> 
                        </div>
                    </div>`
        return elem
    }
    
    useEffect(() => {
        setUp()
    }, [])

  return (
    <div className='lg:px-[3rem] px-[1rem] mb-[80px] mt-[40px] helvetica-font'>
        <p className='text-[28px] font-[600] text-center mt-[4rem] mb-5'>LumosDAO Explorer</p>
        <div id='tx_info' className='p-4 rounded-[6px] bg-white'>
             <center style={{margin:'auto',marginTop:'20px'}}>Loading records..</center>
        </div>
    </div>
  )
}

export default Explorer