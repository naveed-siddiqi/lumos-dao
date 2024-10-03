'use client'

import React, { useEffect, useState } from 'react'
import { MdOutlinePlayCircleFilled, MdHowToVote, MdShowChart } from "react-icons/md";
import { PiNetworkFill } from "react-icons/pi";
import { FaRegUser } from "react-icons/fa";
import { BsChevronDown, BsChevronRight } from 'react-icons/bs';
import Link from 'next/link';


const Docs = () => {

    const [selectedTab, setSelectedTab] = useState();
    useEffect(() => {
        setSelectedTab('getting-started') // Set default tab to 'activity' when component mounts up
    },[])

    const [dropDown, setDropDown] = useState(false);

  return (
    <div className='px-[3rem] my-[80px]'>
        <div className='flex items-start gap-[1rem] h-full'>
            <div className='lg:flex justify-start py-8 flex-col border rounded-[8px] h-[100dvh] w-[25%] hidden'>
                <div className='mx-3 font-[500] text-left flex flex-col gap-1'>
                    <div onClick={() => setSelectedTab('getting-started')} className={selectedTab === 'getting-started' ? `cursor-pointer flex items-center justify-start bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <MdOutlinePlayCircleFilled />
                        <button className=''>Getting Started</button>
                    </div>
                    <div className='cursor-pointer flex flex-col items-start justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5'>
                        <div 
                            onClick={() => {
                            setDropDown(!dropDown)
                            }} className='flex items-center justify-between w-full'>
                            <div className='flex items-center gap-2'>
                                <PiNetworkFill />
                                <button className=''>How it works</button>
                            </div>
                            <BsChevronDown />
                        </div>
                        {
                            dropDown === true &&
                            <div className='ml-0'>
                                <p className={selectedTab === 'creating-proposals' ? `cursor-pointer flex flex-col items-start justify-start gap-2 bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex flex-col items-start justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`} onClick={() => setSelectedTab('creating-proposals')}>Creating Proposals</p>
                                <p className={selectedTab === 'creating-dao' ? `cursor-pointer flex flex-col items-start justify-start gap-2 bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex flex-col items-start justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`} onClick={() => setSelectedTab('creating-dao')}>Creating DAO</p>
                                <p className={selectedTab === 'voting' ? `cursor-pointer flex flex-col items-start justify-start gap-2 bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex flex-col items-start justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`}  onClick={() => setSelectedTab('voting')}>Voting</p>
                            </div>
                        }
                    </div>
                    <div onClick={() => setSelectedTab('dao-features')} className={selectedTab === 'dao-features' ? `cursor-pointer flex items-center justify-start gap-2 bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <MdShowChart />
                        <button className=''>DAO Features</button>
                    </div>
                    {/* <div onClick={() => setSelectedTab('user-features')} className={selectedTab === 'user-features' ? `cursor-pointer flex items-center justify-start gap-2 bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <FaRegUser />
                        <button className=''>User Features</button>
                    </div>
                    <div onClick={() => setSelectedTab('voting-power')} className={selectedTab === 'voting-power' ? `cursor-pointer flex items-center justify-start gap-2 bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <MdHowToVote />
                        <button className=''>Voting Power</button>
                    </div> */}
                </div>
                {/* <p className='mt-20 text-center text-gray-500'>Loading DAOS...</p> */}
            </div>
            {
                selectedTab === 'getting-started' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>Getting started: Connecting Wallet</p>
                    <p className='text-[#5E5A5A]'>
                        To get started on LumosDAO, visit <Link href="https://app.lumosdao.com/">app.lumosdao.com </Link>and click "Connect Wallet" in the top right corner. You can choose from three options:
                    </p>
                    <ul className='ml-10 my-3 list-decimal'>
                        <li> <span className='font-bold'>Lobstr extension</span> for Chrome.</li>
                        <li> <span className='font-bold'>Freighter wallet</span> for desktop.</li>
                        <li> <span className='font-bold'>WalletConnect</span>, which allows you to connect your mobile wallet by scanning a QR code.</li>
                    </ul>
                    <p>Simply select your preferred method and connect your wallet to begin using LumosDAO.</p>
                </div>
            }
            {
                selectedTab === 'voting' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>Voting:</p>
                    <p className='text-[#5E5A5A]'>
                        Once the proposal is approved, any member of the DAO can vote. Voters can also leave a reason for their vote and add comments after voting. Voting runs for 5 days by default.
                    </p>
                </div>
            }
            {
                selectedTab === 'creating-proposals' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>Creating Proposals:</p>
                    <p className='text-[#5E5A5A]'>
                        After setting up your DAO, click "Create Proposal." You can provide a title, description, and attach files (e.g., images, PDFs). Once submitted, the proposal is saved on IPFS and needs to be approved by the DAO owner or admin before voting begins.
                    </p>
                </div>
            }
            {
                selectedTab === 'dao-features' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>LumosDAO Features:</p>
                    <ol className='list-decimal grid gap-5'>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Multi-chain Support:</p>
                            <p className='text-[#5E5A5A]'>LumosDAO supports projects from various blockchains, including Stellar, Ripple XRPL, Solana, and Tonchain.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Easy DAO Setup:</p>
                            <p className='text-[#5E5A5A]'>Projects can set up their DAOs in under 2 minutes, with or without an existing token.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>6 Proposal Systems:</p>
                            <p className='text-[#5E5A5A]'>LumosDAO offers six different types of governance models, providing flexibility to DAO creators and participants.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Admin Controls:</p>
                            <p className='text-[#5E5A5A]'>DAO creators can add admins who can manage settings, edit TOML files, and moderate proposals.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Delegation of Voting Power:</p>
                            <p className='text-[#5E5A5A]'>Users can delegate their voting power to another DAO member and revoke it at any time.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>DAO Stats:</p>
                            <p className='text-[#5E5A5A]'>View important DAO information such as asset details, explorer links, top voters, and active proposals.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>IPFS Integration:</p>
                            <p className='text-[#5E5A5A]'>Proposal data is saved on IPFS, ensuring permanent storage on the blockchain.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Future Features:</p>
                            <p className='text-[#5E5A5A]'>Upcoming features include NFT staking and the LUMOS credits system, which will be introduced soon.</p>
                        </li>
                    </ol>
                </div>
            }
            {
                selectedTab === 'user-features' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>USER Features:</p>
                    <ol className='list-decimal grid gap-5'>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>User Explorer:</p>
                            <p className='text-[#5E5A5A]'>This feature maintains a record of all user activities, which are publicly visible on the user&apos;s profile for enhanced transparency.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Messaging:</p>
                            <p className='text-[#5E5A5A]'>Users can send private messages to different wallets, facilitating direct communication.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Linking Social Profiles:</p>
                            <p className='text-[#5E5A5A]'>Users can link their social media profiles with LumosDAO, integrating their social presence with their DAO activities.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Commenting:</p>
                            <p className='text-[#5E5A5A]'>After casting a vote on a proposal, users can add comments to provide further insights or opinions.</p>
                        </li>
                    </ol>
                </div>
            }
            {
                selectedTab === 'voting-power' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>Voting power:</p>
                    <p className='text-[#5E5A5A] mb-5'>How is voting power calculated?</p>
                    <p className='text-[#5E5A5A] ml-9 mb-3'>In LumosDAO, voting power is determined by combining scores from three categories: Token Holdings, DAO Activity, and Wallet Metrics. Here&apos;s a brief breakdown</p>
                    <ol className='list-decimal grid gap-5 ml-9'>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Token Holdings:</p>
                            <p className='text-[#5E5A5A]'>This score is based on the user's rank among token holders in the DAO, ranging from 1 to 5. Higher rankings (e.g., being one of the top 5 holders) receive higher scores.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>DAO Activity:</p>
                            <p className='text-[#5E5A5A]'>DAO Activity: This includes the number of proposals a user has voted on and the number of comments they've made on proposals, with more activity leading to higher scores.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Wallet Metrics:</p>
                            <p className='text-[#5E5A5A]'>This score considers the age of the userapos&apos;s account, their account balance, and the number of trades they have completed. More seasoned accounts with higher balances and more trades score higher.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Commenting:</p>
                            <p className='text-[#5E5A5A]'>After casting a vote on a proposal, users can add comments to provide further insights or opinions.</p>
                        </li>
                    </ol>
                    <p className='text-[#5E5A5A] mt-5'>The formula to calculate the voting power (VP) is a weighted sum:</p>
                    <p className='font-[500] my-3 text-[#1B1B1B]'>VP=(0.5×Token Holdings Score)+(0.25×DAO Activity Sub-score)+(0.25×Wallet Metrics Sub-score)VP=(0.5×Token Holdings Score)+(0.25×DAO Activity Sub-score)+(0.25×Wallet Metrics Sub-score)</p>
                    <p className='text-[#5E5A5A] mb-5'>Each category&apos;s contribution to the voting power is weighted differently, with Token Holdings having the highest impact (50%).</p>
                </div>
            }
            {
                selectedTab === 'creating-dao' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>Creating a DAO:</p>
                    <p className='text-[#5E5A5A] mb-5'>Once your wallet is connected, go to the LumosDAO homepage and click on "Create DAO." There are two options:</p>
                    <ol className='list-decimal grid gap-5 ml-9'>
                        <li>
                            {/* <p className='text-[18px] text-[#1B1B1B]'>For an Existing Project:</p> */}
                            <p className='text-[#5E5A5A] mb-7'>If your project already has a token issued on the blockchain, enter the <span className='font-bold'>asset code</span> and <span className='font-bold'>TOML URL</span> to fetch project details and create the DAO.</p>
                            {/* <p className='text-[#5E5A5A]'>Next, wrap your assets to convert Stellar-based assets to Soroban format. LumosDAO provides a one-click solution for this process, enabling you to complete the setup swiftly. Finally, click "Create DAO'' and confirm the transaction in your wallet</p> */}
                        </li>
                        <li>
                            {/* <p className='text-[18px] text-[#1B1B1B]'>For an Existing Project:</p> */}
                            <p className='text-[#5E5A5A]'>If you don't have an existing token, provide your project’s details (name, asset code, supply, description, logo, and cover photo). LumosDAO will mint the token, lock the issuing wallet, and generate the TOML file for you.</p>
                        </li>
                    </ol>
                </div>
            }
        </div>
    </div>
  )
}

export default Docs