'use client'

import React, { useEffect, useState } from 'react'
import { FiChevronDown } from 'react-icons/fi'
import { CiCirclePlus } from "react-icons/ci";
import Link from 'next/link';
import DaoCard from '../components/dao-card/DaoCard';
import {getAllProposal, getDao, getDaoMetadata, getVotingPower} from '../core/getter'
import { N } from '../core/core';
import { RiLoader4Fill } from 'react-icons/ri';
import DaoCardLoader from '../components/dao-card-loader/DaoCardLoader';
import DaoStatsLoader from '../components/dao-stats-loader/DaoStatsLoader';
import DaoStatsCard from '../components/dao-stats-card/DaoStatsCard';
 
 
let hasLoad = false
let prevDaoNum = 0;
let prevUsersNum = 0;
let daoArray = []
const Home = () => {


    const sortByArray = ['Proposals', 'date', 'num', 'active']
    const sortByChain = ['all','stellar', 'xrp']
    const [sortMethod, setSortMethod] = useState(sortByArray[0])
    const [sortChainMethod, setSortChainMethod] = useState(sortByChain[0])
    const [dropDown, setDropDown] = useState(false)
    const [loading, setLoading] = useState(true)
    const [empty, setEmpty] = useState(false)
    const [network, setNetwork] = useState(false)
    const [useCache, setCache] = useState(true)
    const [daoCardArray, setDaos] = useState([])
    const [viewType, setViewType] = useState('grid')
      

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
                    const daoKeys = [...daoMeta["daos"]['stellar'], ...daoMeta["daos"]['xrp']]
                    if(cache) {
                        prevDaoNum = daoKeys.length;
                        prevUsersNum = daoMeta["users"];
                    }
                    E("num_of_dao").innerHTML = daoKeys.length;
                    E("num_of_user").innerHTML = daoMeta["users"];
                    E("num_of_votes").innerHTML = daoMeta["votes"];
                    E("num_of_proposal").innerHTML = daoMeta["proposals"];
                    E('dao_change').innerHTML = ((daoKeys.length - prevDaoNum) > 0)?("+" + ((100/(prevDaoNum>0?prevDaoNum:1)) * (daoKeys.length - prevDaoNum)) + "%"):""
                    E('users_change').innerHTML = ((daoMeta["users"] - prevUsersNum) > 0)?("+" + ((100/(prevUsersNum>0?prevUsersNum:1)) * (daoMeta["users"] - prevUsersNum)) + "%"):""
                    //load individual dao data
                    if(!cache) {
                        if (daoMeta["daos"] != undefined) {
                            const daos = await getDao(daoMeta["daos"]);
                            if (daos.status) {
                                const daoViews = []
                                daoArray = []
                                for (let i = 0; i < daoKeys.length; i++) {
                                    if(!daos[daoKeys[i]])continue;
                                    if (daos[daoKeys[i]]["proposals"] != undefined) {
                                        //append
                                        
                                        const dao = daos[daoKeys[i]];
                                        const props = await getAllProposal(dao.proposals, dao.token, dao.chain);
                                        dao.active_proposals = 0;
                                        dao.proposals_no = 0
                                        for (let i = 0; i < dao.proposals.length; i++) {
                                            if (props[dao.proposals[i]] != undefined && props[dao.proposals[i]] != "") {
                                                if (
                                                props[dao.proposals[i]].status == 1
                                                ) {
                                                    dao.active_proposals++;
                                                }
                                                if(props[dao.proposals[i]].status != 0) {
                                                    dao.proposals_no++
                                                }
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
                                                banner:dao.cover + `?id=${Math.random()}`,
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
                                                code:dao.code,
                                                chain:dao.chain
                                            }
                                        )
                                        
                                    }
                                }
                                //save dao views to cache
                                
                                daoArray = daoViews
                                
                                localStorage.setItem("lumos_dao_main_page", JSON.stringify({daoViews}))
                                E("num_of_dao").innerHTML = daoViews.length;
                                if(daoViews.length > 0) {
                                    setDaos(daoViews)
                                    sortDaoChain(window.CHAIN)
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
                            //loading from cache
                            const daoViews = getFromCache()
                            if(daoViews !== false) {
                                setDaos(daoViews)
                                daoArray = daoViews
                                sortDaoChain(window.CHAIN)
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

    /** Sort Dao */
    const sortDaoChain = (chain) => {
        setSortChainMethod(chain)
        //sort it
        const daos = daoArray.filter((a) => {
        // Parse DAO data from data attribute
        //check sort type
        if (a.chain == chain) {
            return true;
        } else if(chain == 'all' || chain == ""){
            return true;
        }else {
            return false;
        }
    });
        //Reorder the children based on the sorted daos array
        setDaos(daos);
    };

    useEffect(() => {
        window.walletAddress = localStorage.getItem('selectedWallet') || ""
        indexMain(useCache)
    },[])
   
  return (
    <div className='md:mx-[6.5rem] mx-[1rem] mt-[50px] mb-[80px] helvetica-font'>
        <div className='md:mt-0 mt-10 flex md:items-center flex-col md:flex-row justify-between mb-5 gap-3'>
            <div className='flex items-center gap-1'>
                <h1 className='lg:text-[26px] font-[500] text-heading-color'>Platform Stats <span className='text-[12px]'>(Across all networks)</span> </h1>
                {  (useCache == true)?
                    <span className='bg-[#FF7B1C] rounded-[6px] text-[14px]' style={{padding:'5px 5px', color:'#fff', marginLeft:'10px'}}>
                        <RiLoader4Fill  className='animate-spin text-center'/>
                    </span>
                : <></>
                }
            </div>
                {/* <p className='text-text-color my-3'>Unlock the full potential of decentralized governance with LumosDAO's suite of features designed for efficiency, transparency, and community empowerment.</p> */}
            {/* <div className='inline-flex gap-5 hero-btns flex-col sm:flex-row'>
                <div className='bg-primary-color text-white px-6 py-3 rounded-full font-[500]'>Get Started</div>
            </div> */}
            <Link href="/create-dao/get-started" className='w-auto text-[13px] sm:text-[16px] cursor-pointer flex items-center justify-center gap-2 bg-[#FF7B1B] text-white px-5 py-2 rounded font-[400]'>
                <p>Create DAO</p>
                <CiCirclePlus />
            </Link>
        </div>
        <div className='w-[100%]'>
            <div className='grid lg:grid-cols-4 grid-cols-2 w-full gap-[0.5rem]'>
                {/* <DaoStatsLoader />
                <DaoStatsLoader />
                <DaoStatsLoader />
                <DaoStatsLoader /> */}
                <DaoStatsCard firstImg="/images/total.svg" cardTitle="Total DAOs" daoNumId="num_of_dao" secondImg="/images/rate.svg" daoChangeId="dao_change" />
                <DaoStatsCard firstImg="/images/user.svg" cardTitle="Users" daoNumId="num_of_user" secondImg="/images/rate.svg" daoChangeId="users_change" />
                <DaoStatsCard firstImg="/images/credit_color.svg" cardTitle="Proposals" daoNumId="num_of_proposal" secondImg="" daoChangeId="" />
                <DaoStatsCard firstImg="/images/vote.svg" cardTitle="Votes" daoNumId="num_of_votes" secondImg="" daoChangeId="" />
            </div>
            <div className='bg-white mt-[45px] p-5'>
                <div className='flex lg:items-center justify-between flex-col lg:flex-row gap-5 items-start'>
                    <div className='flex items-center'>
                        <p className='lg:text-[30px] text-[20px] font-[500] text-heading-color'>Active DAOs</p>
                        {  (useCache)?
                            <span className='bg-[#FF7B1C] rounded-[6px] text-[14px]' style={{padding:'5px 10px', color:'#fff', marginLeft:'10px'}}>
                                <RiLoader4Fill  className='animate-spin text-center'/>
                            </span>
                        : <></>
                        }
                    </div>
                    <div className='flex sm:items-center gap-4 flex-col sm:flex-row items-start'>
                        <div className='flex items-center gap-3'>
                            {/* <p>Sort By</p> */}
                            {/* <div className='flex items-center gap-4 border p-[6px]'>
                                <img src="/images/block.svg" alt=""  className='cursor-pointer'/>
                                <img src="/images/list.svg" alt="" onClick={() => setViewType('list')} className='cursor-pointer'/>
                            </div> */}
                            <img src="/images/filter.svg" alt="" className='cursor-pointer'/>
                            <div className='border p-2 rounded-[10px] flex items-center justify-between relative cursor-pointer w-[100px]' onClick={() => setDropDown( dropDown === 'sort' ? false : 'sort')}>
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
                            <div className='border p-2 rounded-[10px] flex items-center justify-between relative cursor-pointer w-[100px]' onClick={() => setDropDown( dropDown === 'chain' ? false : 'chain')}>
                                <p className='capitalize text-[13px]'>{sortChainMethod}</p>
                                <FiChevronDown className='cursor-pointer' />
                                {
                                    dropDown ==='chain' &&
                                    <div className='top-11 left-0 border absolute z-50 bg-white rounded-[10px] w-full'>
                                        {sortByChain.map((item, index) => (
                                            <div key={index} onClick={() => sortDaoChain(item)} className='capitalize hover:bg-gray-100 text-[13px] p-2 cursor-pointer'>{item}</div>
                                        ))}
                                    </div>
                                }
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id='dao_view' className='grid lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-[0.8rem] mt-10'>
                    {(loading) ? 
                    <>
                        <DaoCardLoader />
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
                                // <DaoCardLoader />
                            )
                        })
                    }
                </div>
            </div>
        </div>
    </div>
  )
}

export default Home