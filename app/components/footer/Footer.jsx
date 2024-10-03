import Link from 'next/link'
import React from 'react'

const Footer = () => {
  return (
    <div className='py-[1.5rem] px-[3rem] flex items-center justify-between flex-col gap-5 lg:flex-row text-[14px] lg:text-[16px]'>
        <div className='flex items-center gap-5'>
            <p className='border-r pr-5'>Built on Stellar</p>
            <p className='text-[#f39c12]'>Lumos DAO</p>
        </div>
        <div className='grid grid-cols-3 md:grid-cols-5 lg:grid-cols-8 gap-5'>
          <Link href="/explorer" className='border-r pr-5'>Explorer</Link>
          <Link href="/about" className='border-r px-5'>About</Link>
          <Link href="/terms-and-conditions" className='border-r px-5'>Terms</Link>
          <Link href="/privacy-policy" className='border-r px-5'>Policy</Link>
          <Link href="/faq" className='border-r px-5'>FAQs</Link>
          <Link href="https://github.com/naveed-siddiqi/lumos-dao" className='border-r px-5'>Github</Link>
          <Link href="/docs" className='pl-5'>Docs</Link>
          <Link href="/LumosDAOWhitepaper.pdf" className='pl-5'>Whitepaper</Link>
        </div>
    </div>
  )
}

export default Footer