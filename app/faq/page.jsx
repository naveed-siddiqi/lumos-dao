import React from 'react'

const FAQ = () => {
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px]'>
        <p className='font-[500] text-[40px] mb-10'>FAQs</p>
        <div className='flex flex-col gap-12'>
            <div>
                <p className='font-[600] mb-4'>What is LumosDAO?</p>
                <p>LumosDAO is a multi-chain platform that allows projects to easily create and manage decentralized autonomous organizations (DAOs) across various blockchain networks. It provides advanced governance tools and supports six different types of proposal systems, offering flexibility and ease of use for DAO creators and members.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>How can I create a DAO on LumosDAO?</p>
                <p>Creating a DAO on LumosDAO is simple and can be done in under 2 minutes. All you need to do is visit the LumosDAO platform, connect your wallet, and follow the guided steps to set up your DAO, including customizing governance settings and proposals.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>What is the cost to create a DAO on LumosDAO?</p>
                <p>While creating a DAO on LumosDAO is currently free (you only pay network transaction fees), in the future, there will be a small fee in $LUMOS tokens to perform actions like creating DAOs, proposals, and voting.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>How do I join a DAO on LumosDAO?</p>
                <p>To join a DAO on LumosDAO, you simply need to connect your wallet to the platform and participate in any DAO that is open to members. Once connected, you can engage in governance by voting on proposals or becoming a part of the community.</p>
            </div>
            {/* <div>
                <p className='font-[600] mb-4'>How do the votes work in a DAO?</p>
                <p>DAO members can vote on various proposals. The votes are transparently signed on the Stellar blockchain.</p>
            </div> */}
            <div>
                <p className='font-[600] mb-4'>What is the purpose of the LUMOS token?</p>
                <p>The LUMOS token is the utility token for the LumosDAO platform. It will be used to pay fees for creating DAOs, submitting proposals, and voting. By using LUMOS, participants can engage with the governance systems, and it helps maintain the sustainability of the platform by discouraging spam.</p>
            </div>
            {/* <div>
                <p className='font-[600] mb-4'>What is the total supply of LUMOS tokens?</p>
                <p>The total supply of LUMOS tokens is 10 billion.</p>
            </div> */}
            {/* <div>
                <p className='font-[600] mb-4'>What upcoming features does LumosDAO have?</p>
                <p>Upcoming features include a dedicated forum, crowdfunding feature, Airdrops and Bounty panel, and the choice between light and dark themes.</p>
            </div> */}
        </div>
    </div>
  )
}

export default FAQ
