'use client'

import Link from 'next/link'
import React, { useEffect, useMemo, useState } from 'react'
import { fAddr, getTx } from '../core/getter';
import { stellarExpert, TOML_URL } from '../data/constant';
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
        if(tx.data.length == 56){
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
            hash:tx.hash || ""
        }
        const elem = `<div class='flex items-start justify-between bg-[#EFF2F6] p-3 rounded-[6px] my-3 flex-col md:items-center md:flex-row gap-3'>
                <div class='flex items-center gap-2 text-blue-600 font-[600]'>
                    <a href='${params.userLink}'>${fAddr(params.address,6)}</a>
                    <a href="${params.link}">${params.action}</a>
                </div>
                <div class='flex items-center gap-2'>
                    <p>${params.date}</p> 
                    <a style='display:${(params.hash != "") ? "" : 'none'}' target='_blank' href="${stellarExpert}/tx/${params.hash}" class='text-blue-600 underline'>View on Explorer</a>
                </div>
            </div>`
        return elem
    }
    
    useEffect(() => {
        setUp()
    }, [])

  return (
    <div className='lg:px-[3rem] px-[1rem] mb-[80px] mt-[40px]'>
        <p className='text-[28px] font-[600] text-center mt-[4rem] mb-5'>LumosDAO Explorer</p>
        <div id='tx_info' className='p-4 rounded-[6px] bg-white'>
             <center style={{margin:'auto',marginTop:'20px'}}>Loading records..</center>
        </div>
    </div>
  )
}

export default Explorer