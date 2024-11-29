import React from 'react'

const DaoStatsLoader = () => {
  return (
    <div className="text-left w-full px-6 pt-6 pb-9 border border-[#F0F2F5] bg-[#FFFFFF] helvetica-font">
        {/* Header Section */}
        <div className="flex items-center gap-2">
            {/* Icon Placeholder */}
            <div className="bg-[#FFF7F2] p-[10px] rounded-full">
                <div className="w-6 h-6 bg-gray-200 rounded-full animate-pulse"></div>
            </div>
            {/* Title Placeholder */}
            <div className="w-36 h-5 bg-gray-200 animate-pulse"></div>
        </div>

        {/* Number Placeholder */}
        <div className="mt-3">
            <div className="w-20 h-10 bg-gray-200 animate-pulse"></div>
        </div>

        {/* Rate Change Placeholder */}
        <div className="bg-[#A7FFB726] inline-flex items-center gap-2 px-3 py-[6px] rounded-full mt-3">
            <div className="w-5 h-5 bg-gray-200 rounded-full animate-pulse"></div>
            <div className="w-16 h-4 bg-gray-200 animate-pulse"></div>
        </div>
    </div>

  )
}

export default DaoStatsLoader