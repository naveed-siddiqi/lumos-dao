import React from 'react'

const CommentLoader = () => {
  return (
    <div class="border-b pb-3 my-2">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                {/* <!-- User Image --> */}
                <div class="w-[40px] h-[40px] rounded-full bg-gray-200 animate-pulse"></div>
                {/* <!-- User Wallet --> */}
                <p class="bg-gray-200 h-4 w-[80px] rounded animate-pulse"></p>
            </div>
            {/* <!-- Date --> */}
            <p class="bg-gray-200 h-4 w-[60px] rounded animate-pulse"></p>
        </div>
        {/* <!-- Message --> */}
        <p class="bg-gray-200 h-4 w-full rounded animate-pulse"></p>
    </div>
  )
}

export default CommentLoader