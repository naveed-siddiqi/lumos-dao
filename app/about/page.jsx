"use client"

import React from 'react'

const About = () => {
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px]'>
        <p className='font-[500] text-[40px] mb-5'>About LumosDAO</p>
        <div className='flex flex-col gap-8'>
            <div>
              <p className='font-bold'>History</p>
              <p>
                LumosDAO was conceived in mid-2023, with the initial concept taking shape during our participation in the <span className='font-bold'>Stellar Startup Camp</span> . This experience allowed us to refine our ideas and lay the groundwork for development, earning us an honorable mention in the camp. Development of the platform began in August 2023. Following this, we entered the <span>Stellar Community Fund (SCF)</span> and emerged as the winners of Round 21. In July 2024, we launched the <span className='font-bold'>LumosDAO beta</span> . As we grew throughout 2024, we expanded our vision to support multiple blockchain networks, including <span className='font-bold'>Ripple XRPL</span> , <span className='font-bold'>Solana</span>, and <span className='font-bold'>Tonchain</span>, among others.
              </p>
            </div>
            <div>
              <p className='font-bold'>What is Lumos DAO?</p>
              <p>LumosDAO is a multi-chain platform that empowers projects to create and manage their decentralized organizations (DAOs) across a wide range of supported blockchain networks. With a streamlined setup process, any project can establish a DAO on LumosDAO in less than two minutes.</p>
            </div>
            <p>Our platform offers six unique proposal systems and a suite of advanced features designed to meet the needs of both DAO creators and members, enhancing governance efficiency and transparency.</p>
            
            <div>
              <p className='font-bold'>Our Vision</p>
              <p>We aim to become the leading DAO platform, hosting thousands of projects across various blockchain networks. Our goal is to build a thriving ecosystem where decentralized governance becomes the standard for blockchain-based projects.</p>
            </div>
        </div>
    </div>
  )
}

export default About