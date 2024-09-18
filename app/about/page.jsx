"use client"

import React from 'react'

const About = () => {
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px]'>
        <p className='font-[500] text-[40px] mb-5'>About</p>
        <div className='flex flex-col gap-8'>
            <p>Welcome to LumosDAO, a cutting-edge platform designed to fuel the growth of decentralized autonomous organizations (DAOs) on the Stellar blockchain.</p>
            <p>At LumosDAO, we provide an easy-to-use interface for DAO creators. Our users can seamlessly log in through their Stellar wallets, like Freighter, Rabet, or Xbull, and start creating their own DAOs. We leverage the power of the Stellar TOML files to fetch key information about your project, streamlining the DAO creation process.</p>
            <p>To create a DAO, creators need to pay a nominal one-time fee of 10,000 LUMOS, our native token. The LUMOS token, built on the Stellar network, is set to drive the LumosDAO ecosystem forward.</p>
            <p>We believe in transparent and democratic governance. Our platform enables DAO members to join any DAO, create proposals, vote, and participate in the decision-making process. All votes are immutably recorded on the Stellar blockchain, ensuring trust and transparency in our decentralized community.</p>
            <p>Looking ahead, we plan to introduce a suite of features designed to foster a vibrant LumosDAO community. A dedicated forum for open discussion, a safe crowdfunding mechanism, an Airdrops and Bounty panel, and the choice between a light and dark theme are all on the horizon.</p>
            <p>With a total supply of 10 billion LUMOS tokens, LumosDAO is ready to reshape the world of DAOs on the Stellar network. We invite you to join us in this exciting journey and experience the power of decentralized governance, all at your fingertips.</p>
        </div>
    </div>
  )
}

export default About