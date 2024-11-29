"use client"

import React, { useState } from 'react';
import Link from 'next/link';
import Alert from '../../components/alert/Alert';
import { useRouter } from 'next/navigation';

const Page = () => {
  const [selectedType, setSelectedType] = useState(null);
  const [msg, setMsg] = useState('');
  const [alertType, setAlertType] = useState('');
  const router = useRouter();

  const projectTypes = [
    {
      title: 'Existing token',
      image: '/images/existing.svg'
    },
    {
      title: 'New token',
      image: '/images/new.svg'
    }
  ];

  function handleNextBtnClick() {
    if (!selectedType) {
      setMsg('Please select a project type');
      setAlertType('warning');
      return;
    }
    // Store the selected project type in localStorage
    localStorage.setItem('projectType', selectedType);
    router.push('/create-dao/describe-dao');
  }

  return (
    <div className="mt-[1rem] lg:mx-[7rem] md:mx-[4rem] mx-[1rem] bg-white text-center h-[100dvh] helvetica-font">
      <p className="pt-[6rem] font-[500] lg:text-[22px] text-[18px]">Pick a project type</p>
      <p className="text-[#52606D] lg:w-[53%] md:w-[70%] w-[90%] lg:text-[16px] text-[12px] mx-auto mt-[14px] mb-[4rem]">
        If your project has a token already, you can easily continue with the “existing token” button. If not, we can help you mint a token quickly as you set up your DAO.
      </p>
      <div className="flex flex-col md:flex-row gap-5 justify-center items-center">
        {projectTypes.map((type, index) => (
          <div
            key={index}
            onClick={() => setSelectedType(type.title)}
            className={
              selectedType === type.title
                ? 'h-[200px] sm:w-[300px] w-[92%] bg-[#F9FAFB] border border-[#FF7B1B] cursor-pointer'
                : 'h-[200px] sm:w-[300px] w-[92%] bg-[#F9FAFB] border border-[#F0F2F5] cursor-pointer'
            }
          >
            <div className="flex items-end gap-2 p-2">
              <img src={type.image} alt={type.title} />
              <p className="font-[500] sm:text-[18px] text-[14px]">{type.title}</p>
            </div>
          </div>
        ))}
      </div>
      <div className="flex items-center md:w-[620px] w-[90%] mx-auto justify-between mt-7">
        <Link href="/create-dao/choose-blockchain" className="flex items-center gap-5 bg-[#E6E7E8] text-[#141B34] rounded-[4px] px-6 py-2">
          <img src="/images/arrow-left.svg" alt="Back" />
          <p>Back</p>
        </Link>
        <button onClick={handleNextBtnClick} className="flex items-center gap-5 bg-[#FF7B1B] text-[#fff] rounded-[4px] px-6 py-2">
          <p>Next</p>
          <img src="/images/arrow-right.svg" alt="Next" />
        </button>
      </div>
      {msg && <Alert msg={msg} alertType={alertType} setMsg={setMsg} />}
    </div>
  );
};

export default Page;
