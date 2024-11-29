import React from 'react'
import { BsChevronDown } from 'react-icons/bs'
import { IoMdCopy } from 'react-icons/io'

const UserProfileLoader = ({mobileNav}) => {
  return (
    <div
        className={
            mobileNav
            ? `fixed z-[100] left-0 top-0 flex justify-start py-8 flex-col border h-[100dvh] w-[350px] bg-white overflow-y-scroll helvetica-font`
            : `relative lg:flex justify-start py-8 flex-col h-full w-[30%] bg-white hidden helvetica-font`
        }
        >
        <div className="flex items-start justify-center gap-2 flex-col px-[15px] border-b border-[#E3E3E3] mx-3 pb-[2.5rem] pt-[1rem]">
            <div
            id="user_img"
            className="rounded-full w-[100px] h-[100px] bg-gray-200 animate-pulse object-cover border"
            ></div>
            <p className="text-[22px] text-left bg-gray-200 h-6 w-2/3 rounded animate-pulse"></p>
            <div className="flex items-center gap-[3rem] mt-2">
            <div className="flex items-center justify-between bg-[#F6F6F8] w-[180px] rounded-[7px] py-1 px-2">
                <p className="text-[15px] bg-gray-200 h-4 w-1/2 rounded animate-pulse"></p>
                <BsChevronDown cursor="pointer" />
            </div>
            </div>
            <p className="text-sm bg-gray-200 h-4 w-full rounded animate-pulse"></p>
        </div>

        <div className="text-[#676565] mt-[2.5rem] mx-7 flex flex-col gap-2 text-[14px]">
            <div className="flex items-center gap-3">
            <div className="bg-gray-200 w-8 h-8 rounded animate-pulse"></div>
            <p className="bg-gray-200 h-4 w-1/2 rounded animate-pulse"></p>
            </div>
        </div>

        <div className="mt-[6rem] mx-[24px]">
            <p className="text-[#B9B8B8] mb-[6px] text-[14px]">ABOUT ME</p>
            <p className="text-[13px] bg-gray-200 h-5 w-full rounded animate-pulse"></p>
        </div>

        <div className="flex items-center justify-start mt-5 gap-3 ml-[24px]">
            <div className="bg-gray-200 w-10 h-10 rounded-full animate-pulse"></div>
            <div className="bg-gray-200 w-10 h-10 rounded-full animate-pulse"></div>
        </div>

        <div className="mt-[5rem] mx-3 font-[400] text-left flex flex-col gap-1">
            <div className="cursor-pointer flex items-center justify-between bg-gray-200 h-8 w-full rounded-[8px] animate-pulse"></div>
            <div className="cursor-pointer flex items-center justify-between bg-gray-200 h-8 w-full rounded-[8px] animate-pulse"></div>
            <div className="cursor-pointer flex items-center justify-between bg-gray-200 h-8 w-full rounded-[8px] animate-pulse"></div>
            <div className="cursor-pointer flex items-center justify-between bg-gray-200 h-8 w-full rounded-[8px] animate-pulse"></div>
            <a href="#" className="cursor-pointer flex items-center justify-between bg-gray-200 h-8 w-full rounded-[8px] animate-pulse mt-8"></a>
        </div>

        <p className="mt-20 text-center text-gray-500 bg-gray-200 h-4 w-1/2 mx-auto rounded animate-pulse"></p>

        {/* <div className="absolute flex items-center justify-center top-[150px] w-full left-0 rounded-[20px]">
            <div className="bg-white rounded-lg shadow-lg p-4 max-w-xs w-full relative">
                <div className="flex flex-col items-start">
                    <div className="rounded-full w-[60px] h-[60px] bg-gray-200 animate-pulse"></div>
                    <h2 className="text-lg bg-gray-200 h-5 w-1/2 rounded animate-pulse"></h2>
                    <div className="text-gray-500 flex items-center mt-1 justify-between w-full">
                        <span className="block bg-gray-200 h-4 w-1/3 rounded animate-pulse"></span>
                        <IoMdCopy className="cursor-pointer text-[20px]" />
                    </div>
                    <p className="text-sm text-gray-500 mt-2 bg-gray-200 h-4 w-full rounded animate-pulse"></p>
                    <div className="flex items-center gap-2">
                        <div className="bg-gray-200 w-6 h-6 rounded-full animate-pulse"></div>
                        <div className="bg-gray-200 w-6 h-6 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div> */}
    </div>

  )
}

export default UserProfileLoader