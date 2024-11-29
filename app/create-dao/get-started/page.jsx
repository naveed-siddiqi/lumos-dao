import React from 'react'
import Link from 'next/link'

const page = () => {
  return (
    <div className="mt-[1rem] lg:mx-[7rem] md:mx-[4rem] mx-[1rem] bg-white text-center h-[100dvh] helvetica-font">
        <p className='pt-[6rem] font-[500] text-[22px]'>Get Started</p>
        <p className='text-[#52606D] lg:w-[30%] md:w-[60%] w-[90%] mx-auto mt-[14px] mb-[4rem]'>Let's help you create your decentralised organisation on Lumos in these four easy steps.</p>
        <div className='grid lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-2 justify-center flex-col lg:px-[7rem] md:px-[5rem] sm:px-[3rem] px-[1rem]'>
            <div className='border border-[#F0F2F5] text-left py-3 pl-4'>
                <p className='mb-2 text-[17px]'>Step 1:</p>
                <div className='flex items-center gap-[6px] text-[17px]'>
                    <img src="/images/project-type.svg" alt="" />
                    <p>Select project type</p>
                </div>
            </div>
            <div className='border border-[#F0F2F5] text-left py-3 pl-4'>
                <p className='mb-2 text-[17px]'>Step 2:</p>
                <div className='flex items-center gap-[6px] text-[17px]'>
                    <img src="/images/describe.svg" alt="" />
                    <p>Describe your DAO</p>
                </div>
            </div>
            <div className='border border-[#F0F2F5] text-left py-3 pl-4'>
                <p className='mb-2 text-[17px]'>Step 3:</p>
                <div className='flex items-center gap-[6px] text-[17px]'>
                    <img src="/images/share.svg" alt="" />
                    <p>Share your DAO</p>
                </div>
            </div>
        </div>
        <Link className='bg-[#FF7B1B] text-white w-[500px] mx-auto mt-[20rem] block py-[12px] rounded-[4px]' href="/create-dao/project-type">Proceed</Link>
    </div>
  )
}

export default page