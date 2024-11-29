import React from 'react'
import Link from 'next/link'

const NotFound = () => {
  return (
    <div className="mt-[1rem] lg:mx-[7rem] md:mx-[4rem] mx-[1rem] bg-white h-[100dvh]">
        <div className='flex items-center justify-center gap-7 pt-[7rem]'>
            <div>
                <p className='text-[#ABABAB] text-[130px]'>404</p>
                <p className='text-[22px]'>Oh no, <br /> you found a wormhole in <br /> the DAO space!</p>
            </div>
            <img src="/images/page-not-found.svg" alt="" />
        </div>
    </div>
  )
}

export default NotFound