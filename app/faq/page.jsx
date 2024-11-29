import React from 'react'

const FAQ = () => {
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px] helvetica-font'>
        <p className='font-[500] text-[40px] mb-10'>FAQs</p>
        <div className='flex flex-col gap-12'>
        <div>
            <p className='font-[600] mb-4'>What is LumosDAO?</p>
            <p>LumosDAO is a platform that facilitates the creation and management of decentralized autonomous organizations (DAOs) on the Stellar blockchain.</p>
        </div>
        <div>
            <p className='font-[600] mb-4'>How can I create a DAO on LumosDAO?</p>
            <p>To create a DAO, simply log in to LumosDAO with your Stellar wallet, click on 'Create DAO,' and follow the prompts.</p>
        </div>
        <div>
            <p className='font-[600] mb-4'>What is the cost to create a DAO on LumosDAO?</p>
            <p>DAO creators are required to pay a one-time fee of 10,000 LUMOS tokens for DAO creation.</p>
        </div>
        <div>
            <p className='font-[600] mb-4'>How do I join a DAO on LumosDAO?</p>
            <p>Members can join a DAO by confirming the transaction on the Stellar network. Some DAOs may require you to own a certain number of a project's native tokens.</p>
        </div>
        <div>
            <p className='font-[600] mb-4'>How do the votes work in a DAO?</p>
            <p>DAO members can vote on various proposals. The votes are transparently signed on the Stellar blockchain.</p>
        </div>
        <div>
            <p className='font-[600] mb-4'>What is the purpose of the LUMOS token?</p>
            <p>The LUMOS token is used for DAO creation and will be used for voting and accessing future platform features.The LUMOS token is used for DAO creation and will be used for voting and accessing future platform features.</p>
        </div>
        <div>
            <p className='font-[600] mb-4'>What is the total supply of LUMOS tokens?</p>
            <p>The total supply of LUMOS tokens is 10 billion.</p>
        </div>
        <div>
            <p className='font-[600] mb-4'>What upcoming features does LumosDAO have?</p>
            <p>Upcoming features include a dedicated forum, crowdfunding feature, Airdrops and Bounty panel, and the choice between light and dark themes.</p>
        </div>
        </div>
    </div>
  )
}

export default FAQ