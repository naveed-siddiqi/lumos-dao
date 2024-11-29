import React from 'react'

const AlertLoader = () => {
  return (
    <div className="text-[12px] flex items-start justify-between border-b border-[#EFEFEF] p-3 my-3 flex-col md:items-center md:flex-row gap-3 overflow-x-auto animate-pulse">
        {/* Left Section */}
        <div className="flex items-center gap-2">
            {/* Transaction Type Skeleton */}
            <div className="bg-[#ECFDF3] py-[5px] px-[12px] rounded-full w-[100px] h-[20px]"></div>
            {/* User Link Skeleton */}
            <div className="bg-gray-300 w-[120px] h-[20px] rounded"></div>
            {/* Action Link Skeleton */}
            <div className="bg-gray-300 w-[80px] h-[20px] rounded"></div>
            {/* Explorer Link Skeleton */}
            <div className="bg-gray-300 w-[150px] h-[20px] rounded"></div>
        </div>

        {/* Right Section */}
        <div className="flex items-center gap-2">
            {/* Date Skeleton */}
            <div className="bg-gray-300 w-[100px] h-[20px] rounded"></div>
        </div>
    </div>
  )
}

export default AlertLoader