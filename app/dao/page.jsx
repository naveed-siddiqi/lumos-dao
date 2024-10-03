'use client'

import React, { useEffect, useState } from 'react'
import { FiChevronDown } from 'react-icons/fi'
import { CiCirclePlus } from "react-icons/ci";
import Link from 'next/link';
import DaoCard from '../components/dao-card/DaoCard';
import {getAllProposal, getDao, getDaoMetadata} from '../core/getter'
import { N } from '../core/core';
 
 
let hasLoad = false
const Home = () => {


    const sortByArray = ['Sort by proposals', 'date', 'num', 'active']
    const [sortMethod, setSortMethod] = useState(sortByArray[0])
    const [dropDown, setDropDown] = useState(false)
    const [loading, setLoading] = useState(true)
    const [empty, setEmpty] = useState(false)
    const [network, setNetwork] = useState(false)
    const [useCache, setCache] = useState(true)
    const [daoCardArray, setDaos] = useState([])
      

    /* RETRIEVE THE DAO GENERAL INFORMATION */
    const indexMain = async (cache) => {
        if(!hasLoad) {
            hasLoad = true
            setLoading(cache)
            const daoMeta = await getDaoMetadata(cache);
            if(daoMeta !== false){
                if (daoMeta['daos'] == undefined) {
                    //empty results
                    E("num_of_dao").innerHTML =
                    E("num_of_user").innerHTML =
                    E("num_of_votes").innerHTML =
                    E("num_of_proposal").innerHTML = "0";
                    setLoading(false)
                    setEmpty(true)
                } 
                else {
                    E("num_of_dao").innerHTML = daoMeta["daos"].length;
                    E("num_of_user").innerHTML = daoMeta["users"];
                    E("num_of_votes").innerHTML = daoMeta["votes"];
                    E("num_of_proposal").innerHTML = daoMeta["proposals"];
                    //load individual dao data
                    if(!cache) {
                        if (daoMeta["daos"] != undefined) {
                            if (daoMeta["daos"].length > 0) {
                                const daos = await getDao(daoMeta["daos"]);
                                if (daos.status) {
                                    const daoViews = []
                                    for (let i = 0; i < daoMeta["daos"].length; i++) {
                                        if (daos[daoMeta["daos"][i]]["proposals"] != undefined) {
                                            //append
                                            const dao = daos[daoMeta["daos"][i]];
                                            const props = await getAllProposal(dao.proposals, dao.token);
                                            dao.active_proposals = 0;
                                            dao.proposals_no = 0
                                            for (let i = 0; i < dao.proposals.length; i++) {
                                                if (
                                                    props[dao.proposals[i]].status == 1
                                                ) {
                                                    dao.active_proposals++;
                                                }
                                                if(props[dao.proposals[i]].status != 0) {
                                                    dao.proposals_no++
                                                }
                                            }
                                            if (dao.joined === false || walletAddress == "") {
                                            dao.ismember = false;
                                            } else {
                                            dao.ismember = true;
                                            }
                                            daoViews.push(
                                                {
                                                    id:dao.token,
                                                    banner:dao.cover + "?id=" + Math.random(),
                                                    logo:dao.image,
                                                    title:dao.name,
                                                    description:dao.description,
                                                    activeProposals:dao.active_proposals,
                                                    members:dao.members,
                                                    proposals:dao.proposals_no,
                                                    created:N(dao.created),
                                                    owner:dao.owner,
                                                    joined:dao.ismember,
                                                    issuer:dao.issuer,
                                                    code:dao.code
                                                }
                                            )
                                        }
                                    }
                                    //save dao views to cache
                                    localStorage.setItem("lumos_dao_main_page", JSON.stringify({daoViews}))
                                    if(daoViews.length > 0) {
                                        setDaos(daoViews)
                                        setLoading(false)
                                        setEmpty(false)
                                    }
                                    else {
                                        setLoading(false)
                                        setEmpty(true)   
                                    }
                                }
                            } else {
                            setLoading(false)
                            setEmpty(true)
                            }
                        } 
                        else {
                            setLoading(false)
                            setEmpty(true)
                        }
                    }
                    else { 
                        //loading from cache
                        const daoViews = getFromCache()
                        if(daoViews !== false) {
                            setDaos(daoViews)
                            setLoading(false)
                            setEmpty(false)
                        }
                    }
                }
            }
            else {
                setLoading(false)
                setNetwork(true)
            }
            setCache(cache)
        }
        if(cache) {
            //run with cache
            hasLoad = false
            indexMain(false)
        }
    }
    /* Retrieve data from cache **/
    const getFromCache = () => {
        try{
          const data = JSON.parse(localStorage.getItem("lumos_dao_main_page") || '{}') || {}
          return data['daoViews'] || false
        }
        catch(e) {return false}
    }
    /** Sort Dao */
    const sortDao = (sortType) => {
        const daoView = E("dao_view");
        const daos = Array.from(daoView.children);
        //sort it
        daos.sort((a, b) => {
        // Parse DAO data from data attribute
        const daoA = JSON.parse(a.getAttribute("data") || "{}");
        const daoB = JSON.parse(b.getAttribute("data") || "{}");
        //check sort type
        if (sortType === "date") {
            // Convert created dates to Date objects for comparison
            const dateA = daoA.created * 1;
            const dateB = daoB.created * 1;
            // Sort by date (newest to oldest)
            return dateB - dateA;
        } else if (sortType === "num") {
            //proposals comparison
            const propA = daoA.proposals * 1;
            const propB = daoB.proposals * 1;
            // Sort by date (much to least)
            return propB - propA;
        } else if (sortType === "active") {
            // Convert created dates to Date objects for comparison
            const actA = daoA.active * 1;
            const actB = daoB.active * 1;
            // Sort by date (much to least)
            return actB - actA;
        }
        //for no sort type founds
        return 0;
        });
        //Reorder the children based on the sorted daos array
        daos.forEach((dao) => daoView.appendChild(dao));
    };

    useEffect(() => {
        window.walletAddress = localStorage.getItem('selectedWallet') || ""
        indexMain(useCache)
    },[])
   
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px]'>
        <div className='md:w-[50%] md:mt-0 mt-10 flex items-center'>
            <h1 className='lg:text-[26px] font-[500] text-heading-color mb-5'>Platform Stats <span className='text-[12px]'>(Across all networks)</span> </h1>
            {  (useCache == true)?
                <span className='bg-[#DC6B19] rounded-[6px] mb-5 text-[11px]' style={{padding:'5px 5px', color:'#fff', marginLeft:'10px'}}>Updating..</span>
            : <></>
            }
                {/* <p className='text-text-color my-3'>Unlock the full potential of decentralized governance with LumosDAO's suite of features designed for efficiency, transparency, and community empowerment.</p> */}
            {/* <div className='inline-flex gap-5 hero-btns flex-col sm:flex-row'>
                <div className='bg-primary-color text-white px-6 py-3 rounded-full font-[500]'>Get Started</div>
            </div> */}
        </div>
        <div className='w-[100%]'>
            <div className='grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 w-full gap-[3rem]'>
                <div className='text-center shadow-md w-full p-6 rounded-[10px]'>
                    <p  id='num_of_dao' className='text-[#f39c12] font-bold text-[34px]'>--</p>
                    <p className='text-[18px] font-[500]'>Number of DAOs</p>
                </div>
                <div className='text-center shadow-md w-full p-6 rounded-[10px]'>
                    <p id='num_of_user' className='text-[#f39c12] font-bold text-[34px]'>--</p>
                    <p className='text-[18px] font-[500]'>Number of users</p>
                </div>
                <div className='text-center shadow-md w-full p-6 rounded-[10px]'>
                    <p id='num_of_proposal' className='text-[#f39c12] font-bold text-[34px]'>--</p>
                    <p className='text-[18px] font-[500]'>Number of proposals</p>
                </div>
                <div className='text-center shadow-md w-full p-6 rounded-[10px]'>
                    <p id='num_of_votes' className='text-[#f39c12] font-bold text-[34px]'>--</p>
                    <p className='text-[18px] font-[500]'>Number of votes</p>
                </div>
            </div>
            <div className='flex lg:items-center justify-between mt-[100px] flex-col lg:flex-row gap-5 items-start'>
                <div className='flex items-center'>
                    <p className='lg:text-[30px] text-[20px] font-[500] text-heading-color'>Active DAOs</p>
                    {  (useCache)?
                        <span className='bg-[#DC6B19] rounded-[6px] text-[11px]' style={{padding:'5px 10px', color:'#fff', marginLeft:'10px'}}>Updating..</span>
                    : <></>
                    }
                </div>
                <div className='flex sm:items-center gap-4 flex-col sm:flex-row items-start'>
                    <div className='flex items-center gap-3'>
                        <p>Sort By</p>
                        <div className='border p-2 rounded-[10px] flex items-center justify-between relative cursor-pointer w-[200px]' onClick={() => setDropDown( dropDown === 'sort' ? false : 'sort')}>
                            <p className='capitalize text-[13px]'>{sortMethod}</p>
                            <FiChevronDown className='cursor-pointer' />
                            {
                                dropDown ==='sort' &&
                                <div className='top-11 left-0 border absolute z-50 bg-white rounded-[10px] w-full'>
                                    {sortByArray.map((item, index) => (
                                        <div key={index} onClick={() => sortDao(item)} className='capitalize hover:bg-gray-100 text-[13px] p-2 cursor-pointer'>{item}</div>
                                    ))}
                                </div>
                            }
                        </div>
                    </div>
                    <Link href="/create-dao" className='text-[13px] sm:text-[16px] cursor-pointer flex items-center gap-2 bg-[#DC6B19] text-white px-5 py-2 rounded font-[500]'>
                        <p>Create DAO</p>
                        <CiCirclePlus />
                    </Link>
                </div>
            </div>
            
            <div id='dao_view' className='grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-[1.5rem] mt-10'>
                {(loading) ? <>
                    <center>Fetching dao..</center>
                </>
                : (network)?
                    <>
                    <div style={{fontSize:'20px', margin:'60px 0px'}}>
                        <center>Network error</center>
                    </div>
                    </>
                 : (empty) ? 
                    <div style={{fontSize:'20px', margin:'60px 0px'}}>
                        <center>No DAO created yet<br />Be the first to create a DAO.</center>
                    </div>
                    :
                    daoCardArray.map((dao, index) => {
                        return(
                            <DaoCard key={index} dao={dao} />
                        )
                    })
                }
            </div>
        </div>
    </div>
  )
}

export default Home