'use client'

import React, { useEffect, useState } from 'react'
import { MdOutlinePlayCircleFilled, MdHowToVote, MdShowChart } from "react-icons/md";
import { PiNetworkFill } from "react-icons/pi";
import { FaRegUser } from "react-icons/fa";
import { BsChevronDown, BsChevronRight } from 'react-icons/bs';


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
                    <div onClick={() => setSelectedTab('user-features')} className={selectedTab === 'user-features' ? `cursor-pointer flex items-center justify-start gap-2 bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <FaRegUser />
                        <button className=''>User Features</button>
                    </div>
                    <div onClick={() => setSelectedTab('voting-power')} className={selectedTab === 'voting-power' ? `cursor-pointer flex items-center justify-start gap-2 bg-[#DC6B19] text-white w-full py-3 rounded-[8px] text-left px-5` : `cursor-pointer flex items-center justify-start gap-2 text-black w-full py-3 rounded-[8px] text-left px-5`}>
                        <MdHowToVote />
                        <button className=''>Voting Power</button>
                    </div>
                </div>
                {/* <p className='mt-20 text-center text-gray-500'>Loading DAOS...</p> */}
            </div>
            {
                selectedTab === 'getting-started' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>Getting started:</p>
                    <p className='text-[#5E5A5A]'>
                        Connecting wallet: To begin using LumosDAO, please connect your Freighter wallet. If you have not yet installed the Freighter wallet extension, it is available for download from the Chrome Web Store. After installation, create your new Stellar wallet and link Freighter with LumosDAO.
                    </p>
                </div>
            }
            {
                selectedTab === 'voting' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>Voting:</p>
                    <p className='text-[#5E5A5A]'>
                        After a proposal is approved, DAO members may cast their votes. When voting, members have the option to provide a reason for their vote. This reason will be publicly displayed on the proposal page under the voters section.
                    </p>
                </div>
            }
            {
                selectedTab === 'creating-proposals' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>Creating Proposals:</p>
                    <p className='text-[#5E5A5A]'>
                        To create a proposal, you must first be a member of the DAO. Click "Join DAO" and confirm the transaction to become a member. After joining, navigate to the DAO page and select "Create Proposal". Enter the title and description of your proposal and attach any relevant documents (optional). Once approved, the voting on proposals will be open for 5 days. Please note that all proposals are subject to moderation by the DAO administrators.
                    </p>
                </div>
            }
            {
                selectedTab === 'dao-features' &&
                <div className='lg:w-[75%] px-[3rem]'>
                    <p className='text-[1.275rem] font-[500] mb-3 text-[#1B1B1B]'>DAO Features:</p>
                    <ol className='list-decimal grid gap-5'>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>TOML Generation and Hosting:</p>
                            <p className='text-[#5E5A5A]'>LumosDAO automatically generates and hosts the asset&apos;s TOML file. DAO creators can update the TOML details by navigating through the DAO settings.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Automatic Asset Wrapping:</p>
                            <p className='text-[#5E5A5A]'>This feature automatically converts Classic Stellar assets to Soroban, facilitating the setup of the DAO on LumosDAOThis feature automatically converts Classic Stellar assets to Soroban, facilitating the setup of the DAO on LumosDAO.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Bulletin:</p>
                            <p className='text-[#5E5A5A]'>DAO administrators can use this space to post project-related news and announcements. Additionally, they can conduct polls for community engagement.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Voting Power Delegation:</p>
                            <p className='text-[#5E5A5A]'>Users can delegate their voting power to another wallet within the same DAO, allowing another individual to make decisions on their behalf. This delegation can be revoked at any time by the delegator.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>File Attachments:</p>
                            <p className='text-[#5E5A5A]'>Proposal creators can attach relevant files to their proposals, including images, PDFs, or text files.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Proposal Moderation:</p>
                            <p className='text-[#5E5A5A]'>To prevent spam, all proposals are manually moderated by the DAO creators or administrators.</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>Admin and Roles:</p>
                            <p className='text-[#5E5A5A]'>The DAO creator can appoint multiple administrators and assign them specific roles, enhancing community management efficiency.</p>
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
                    <p className='text-[#5E5A5A] mb-5'>On the homepage, select “Create DAO”. There are two methods to establish a DAO for your project</p>
                    <ol className='list-decimal grid gap-5 ml-9'>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>For an Existing Project:</p>
                            <p className='text-[#5E5A5A] mb-7'>If your project already has a token on the Stellar blockchain, you will need to import it into LumosDAO. Begin by entering the asset code and the TOML URL of your asset, then click "Search". LumosDAO will retrieve all relevant data for the asset, such as logo, description, and home domain, from the TOML file.</p>
                            <p className='text-[#5E5A5A]'>Next, wrap your assets to convert Stellar-based assets to Soroban format. LumosDAO provides a one-click solution for this process, enabling you to complete the setup swiftly. Finally, click "Create DAO'' and confirm the transaction in your wallet</p>
                        </li>
                        <li>
                            <p className='text-[18px] text-[#1B1B1B]'>For an Existing Project:</p>
                            <p className='text-[#5E5A5A]'>If your project already has a token on the Stellar blockchain, you will need to import it into LumosDAO. Begin by entering the asset code and the TOML URL of your asset, then click "Search". LumosDAO will retrieve all relevant data for the asset, such as logo, description, and home domain, from the TOML file.</p>
                        </li>
                    </ol>
                </div>
            }
        </div>
    </div>
  )
}

export default Docs