import React from 'react'

const DaoCardLoader = () => {
  return (
    <div className="mx-auto bg-white border border-[#E6E7E8] w-full md:max-w-[430px] overflow-hidden cursor-pointer">
        {/* Image Section */}
        <div className="relative">
            <div className="w-full h-32 sm:h-48 bg-gray-200 animate-pulse"></div>
        </div>

        {/* Content Section */}
        <div className="p-4">
            <div className="flex items-start flex-col gap-3">
                {/* Profile Image */}
                <div className="p-[4px] bg-white w-[70px] h-[70px] mt-[-50px] rounded-full relative z-[100]">
                    <div className="w-full h-full bg-gray-200 rounded-full animate-pulse"></div>
                </div>

                {/* Header */}
                <div className="flex items-center justify-between w-full">
                    <div className="h-5 w-1/2 bg-gray-200 animate-pulse"></div>
                    <div className="flex items-center gap-1 text-[#141B34] bg-[#F2F6FE] px-3 py-[5px] rounded-full">
                        <div className="w-5 h-5 bg-gray-200 rounded-full animate-pulse"></div>
                        <div className="h-3 w-10 bg-gray-200 animate-pulse"></div>
                    </div>
                </div>
            </div>

            {/* Description */}
            <div className="mt-3 space-y-2">
                <div className="h-4 bg-gray-200 animate-pulse w-full"></div>
                <div className="h-4 bg-gray-200 animate-pulse w-5/6"></div>
                <div className="h-4 bg-gray-200 animate-pulse w-4/6"></div>
            </div>

            {/* Footer */}
            <div className="mt-4 flex items-center gap-5 text-[14px] w-full text-[#141B34] capitalize">
                <div className="mt-2 flex gap-3 justify-between w-full">
                    {/* Members Skeleton */}
                    <div className="border border-[#DBDEE3] w-full p-2 rounded-[5px]">
                        <div className="h-4 bg-gray-200 animate-pulse w-1/3 mb-4"></div>
                        <div className="h-6 bg-gray-200 animate-pulse w-2/3"></div>
                    </div>
                    {/* Proposals Skeleton */}
                    <div className="border border-[#DBDEE3] w-full p-2 rounded-[5px]">
                        <div className="h-4 bg-gray-200 animate-pulse w-1/3 mb-4"></div>
                        <div className="h-6 bg-gray-200 animate-pulse w-2/3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  )
}

export default DaoCardLoader