import Link from 'next/link'
import React from 'react'

const Footer = () => {
  return (
    // <div className='py-[1.5rem] px-[3rem] flex items-center justify-between flex-col gap-5 lg:flex-row text-[14px] lg:text-[16px]'>
    //     <div className='flex items-center gap-5'>
    //         <p className='border-r pr-5'>Built on Stellar</p>
    //         <p className='text-[#f39c12]'>Lumos DAO</p>
    //     </div>
    //     <div className='grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-5'>
    //       <Link href="/explorer" className='border-r pr-5'>Explorer</Link>
    //       <Link href="/about" className='border-r px-5'>About</Link>
    //       <Link href="/terms-and-conditions" className='border-r px-5'>Terms</Link>
    //       <Link href="/privacy-policy" className='border-r px-5'>Policy</Link>
    //       <Link href="/faq" className='border-r px-5'>FAQs</Link>
    //       <Link href="https://github.com/naveed-siddiqi/lumos-dao" className='border-r px-5'>Github</Link>
    //       <Link href="/docs" className='pl-5'>Docs</Link>
    //     </div>
    // </div>
    <footer className="flex items-center justify-between flex-col sm:flex-row mt-10 lg:px-[7rem] md:px-[4rem] px-[1rem pb-8 pt-16 helvetica-font">
      <div className="flex items-center gap-1">
        <p className='text-[#919191] text-[13px]'>Built on</p>
        <img src="/images/stellar_footer.svg" className='w-[55px]' alt="" />
      </div>
      <div className="flex gap-4 my-9 sm:my-0 text-[13px]">
        <Link href="/explorer" className='text-[#919191]'>Explorer</Link>
        <Link href="/about" className='text-[#919191]'>About</Link>
        <Link href="/faq" className='text-[#919191]'>FAQs</Link>
        <Link target='_blank' href="https://docs.lumosdao.org/" className='text-[#919191]'>Docs</Link>
        <Link target='_blank' href="/LumosDAOWhitepaper.pdf" className='text-[#919191]'>Whitepaper</Link>
      </div>
      <div className="flex gap-4 text-[13px]">
        <Link href="/terms-and-conditions" className='text-[#919191]'>Terms</Link>
        <Link href="/privacy-policy" className='text-[#919191]'>Policy</Link>
      </div>
    </footer>
  )
}

export default Footer