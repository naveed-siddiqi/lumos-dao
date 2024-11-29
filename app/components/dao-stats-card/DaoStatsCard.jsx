import React from 'react'

const DaoStatsCard = ({firstImg, cardTitle, daoNumId, secondImg, daoChangeId}) => {
  return (
    <div className='text-left w-full px-6 pt-6 pb-9 border border-[#F0F2F5] bg-[#FFFFFF] helvetica-font'>
        <div className='flex items-center gap-2'>
            <div className='bg-[#FFF7F2] p-[10px] rounded-full'>
                <img src={firstImg} alt="" className='w-[14px] md:w-auto' />
            </div>
            <p className='font-[400] md:text-[20px] text-[14px]'>{cardTitle}</p>
        </div>
        <p  id={daoNumId} className='text-[#141B34] font-[500] md:text-[45px] text-[20px] mt-3'>--</p>
        {
            secondImg === "" ?
            null
            :
            <div className='bg-[#A7FFB726] inline-flex items-center gap-2 px-3 py-[6px] rounded-full'>
                <img src={secondImg} alt="" className='w-[14px] md:w-auto' />
                <p id={daoChangeId} className='text-[#00BB22] text-[12px]'></p>
            </div>

        }
    </div>
  )
}

export default DaoStatsCard