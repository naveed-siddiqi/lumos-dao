'use client'

import Image from "next/image";
import CoreFeatureCard from "./components/core-feature-card/CoreFeatureCard";
import WhyChooseLumos from "./components/why-choose-lumos/WhyChooseLumos";
// Import Swiper React components
import { Swiper, SwiperSlide } from 'swiper/react';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';

import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { IoChevronBackOutline } from "react-icons/io5";
import { IoChevronForward } from "react-icons/io5";
import Link from "next/link";
import { useEffect } from "react";
import { useRouter } from 'next/navigation';


export default function Home() {
  const router = useRouter()

  useEffect(() => {
    const user = localStorage.getItem("LUMOS_WALLET") || ""
    if(user){
      router.replace('/dao')
    }
    console.log(user);
  },[])

  const logos = ['/images/Stellar-logo.png', '/images/lumenswap-logo-1.png', '/images/authentic-payment.png', '/images/dicinu-logo.png', '/images/fred-energy-logo.png']
  const coreFeatures = [
    {
      img: '/images/dao-create.svg',
      text: 'DAO Creation',
    },
    {
      img: '/images/asset-creation.svg',
      text: 'Asset Creation',
    },
    {
      img: '/images/proposal-creation.svg',
      text: 'Proposal Creation',
    },
    {
      img: '/images/voting.svg',
      text: 'Voting',
    },
    {
      img: '/images/asset-wrapping.svg',
      text: 'Asset Wrapping',
    },
    {
      img: '/images/voting-power.svg',
      text: 'Voting Power Delegation',
    },
    {
      img: '/images/dao-admin.svg',
      text: 'DAO Admin Tools',
    },
    {
      img: '/images/defi.svg',
      text: 'DEFI (Upcoming)',
    }
  ]

  let gamesCarouselSettings = {
    dots: false,
    infinite: true,
    autoplay: true,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 1,
    initialSlide: 0,
    loop:true,
    autoplaySpeed: 3000,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 900,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 700,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          initialSlide: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ]
  };

  const whyChooseUs = [
    {
      img: '/images/dao-creators.png',
      title: 'DAO Creators',
      info:['Advance governance mechanism','DAO management tools','Low fees','Set up a DAO in seconds']
    },
    {
      img: '/images/dao-members.svg',
      title: 'DAO Members',
      info:['Easy DAO Participation','Voting Power Delegation','Messaging','DEFI (Coming Soon)']
    }
  ]

  return (
    <div className='mt-[150px]'>
      <main className='flex lg:items-start items-start justify-between mx-auto lg:flex-row flex-col-reverse md:px-[5rem] px-[1rem]'>
          <div className='lg:w-[40%] lg:mt-0 mt-10'>
              <h1 className='lg:text-[50px] md:text-[38px] sm:text-[30px] text-[26px] font-[600] text-heading-color'>Decentralized Governance made simple</h1>
              <p className='text-text-color my-3'>Unlock the full potential of decentralized governance with LumosDAO's suite of features designed for efficiency, transparency, and community empowerment.</p>
              <div className='inline-flex gap-5 hero-btns flex-col sm:flex-row'>
                  <Link href="#trusted" className='bg-[#DC6B19] text-white px-5 py-[10px] rounded font-[500]'>Learn More</Link>
              </div>
          </div>
          <div>
              <video controls className='lg:w-[600px] h-[500px] mt-[-8rem] mx-auto'>
                <source src="/images/Lumos-DAO-explainer.mp4" type="video/mp4" />
              </video>
          </div>
      </main>
      <div className="mt-[10rem] px-[3rem]" id="trusted">
        <p className="text-center font-[700] md:text-[40px] mb-10 text-[26px]">Trusted By</p>
        <div className="flex items-center justify-center">
          <Swiper
            autoplay={{
                delay: 0,
                disableOnInteraction: false,
            }}
            breakpoints={{
                0:{
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                640: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            }}
                loop={true}
                speed={2000}
                slidesPerView={3}
                spaceBetween={30}
                navigation={{nextEl: ".next-button", prevEl:".prev-button"}}
                pagination={false}
                modules={[Navigation, Pagination, Autoplay]}
                className="mySwiper"
            >
              {
                logos.map((item, index) => {
                  return(
                    <SwiperSlide key={index}>
                      <Image src={item} width={150} height={150} className="mx-auto" alt="Trusted logo" />
                    </SwiperSlide>
                  )
                })
              }
          </Swiper>
        </div>
      </div>
      <div className="mt-[10rem] md:px-[3rem] px-[1rem]">
        <div className="lg:w-[75%] w-[100%] mx-auto">
          <p className="text-center font-[700] md:text-[40px] mb-5 text-[26px]">Core Features</p>
          <p className="text-center md:text-[18px]">Unlock the full potential of decentralized governance with LumosDAO's suite of features designed for efficiency, transparency, and community empowerment. Explore our core functionalities that set the foundation for democratic decision-making.</p>
        </div>
        <div className="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-10 mt-[4rem]">
          {
            coreFeatures.map((item, index) => {
              return(
                <CoreFeatureCard key={index} img={item.img} text={item.text} />
              )
            })
          }
        </div>
      </div>
      <div className="mt-[10rem] md:px-[3rem] px-[1rem]">
        <div className="lg:w-[75%] w-[100%] mx-auto">
          <p className="text-center font-[700] md:text-[40px] mb-5 text-[22px]">Why Choose LumosDAO?</p>
          <p className="text-center md:text-[18px]">LumosDAO offers a range of benefits tailored to meet the needs of both DAO members and creators, ensuring a robust, transparent, and user-friendly platform for decentralized governance.</p>
        </div>
        <div className="flex items-center justify-center mt-[4rem] gap-[8rem] md:flex-row flex-col">
          {
            whyChooseUs.map((item, index) => {
              return(
                <WhyChooseLumos key={index} img={item.img} info={item.info} title={item.title} />
              )
            })
          }
        </div>
      </div>
      <div className='bg-[#f3f4f6] py-[5rem] flex items-start justify-between mx-auto lg:flex-row flex-col-reverse md:px-[3rem] px-[1rem] mt-[150px]'>
          <div className='lg:w-[50%] lg:mt-0 mt-10 text-center'>
            <h1 className='lg:text-[42px] md:text-[38px] sm:text-[30px] text-[26px] font-[700] text-heading-color'>Get in touch</h1>
            <p className='text-text-color my-3'> <span className="font-[600]">Email Us:</span> For detailed inquiries or support, drop us an email at info@lumosdao.io we'll get back to you as soon as possible.</p>
            <p className='text-text-color my-3'> <span className="font-[600]">Reach Out on X.com:</span> For quick questions or to follow our updates, message us directly at <span className="font-[600]">@DAOLumos.</span> Let's start a conversation!</p>
          </div>
          <Image src='/images/get-in-touch.svg' width={600} height={400} />
      </div>
    </div>
  );
}
