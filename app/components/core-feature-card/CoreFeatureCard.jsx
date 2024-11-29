import Image from 'next/image'
import React from 'react'

const CoreFeatureCard = ({img, text}) => {
  return (
    <div className='shadow-lg rounded-[10px] helvetica-font'>
        <div className='bg-[#ffa50024] p-[3rem] rounded-full mt-[2rem] w-[180px] h-[180px] mx-auto flex items-center justify-center mb-[1rem]'>
            <Image src={img} width={100} height={100}/>
        </div>
        <p className='text-center mb-[4rem] text-[20px] font-[500]'>{text}</p>
    </div>
  )
}

export default CoreFeatureCard