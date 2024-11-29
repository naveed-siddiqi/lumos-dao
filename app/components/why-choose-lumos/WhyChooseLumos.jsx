import Image from 'next/image'
import React from 'react'

const WhyChooseLumos = ({img, title, info}) => {
  return (
    <div className="flex flex-col items-center justify-center helvetica-font">
      <div className='w-[280px] h-[280px] mx-auto flex items-center justify-center mb-[1rem]'>
        <Image src={img} width={150} height={150} className='w-full h-full border border-red-500 rounded-full shadow-lg object-contain'/>
        </div>
      <div className="mt-10 text-left">
        <h3 className="text-lg font-semibold">{title}</h3>
        <ul className="list-none mt-4 text-gray-700">
            {
                info?.map((item, index) => {
                  return (
                    <li key={index} className="flex items-center mb-2">
                      <span className="text-red-500 mr-2">&#10003;</span>
                      {item}
                    </li>
                  )
                })
            }
        </ul>
      </div>
    </div>
  )
}

export default WhyChooseLumos