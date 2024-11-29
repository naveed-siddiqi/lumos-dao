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
import { useEffect, useState } from "react";
import { useRouter } from 'next/navigation';
import { BiSend } from "react-icons/bi";
import { FaRegMessage } from "react-icons/fa6";
import { IoMdClose } from "react-icons/io";
import { getAllChats } from "./core/getter";
import { sendChatBotMsg } from "./core/core";
import localFont from 'next/font/local';

// Load Open Sauce Sans from the local `public/fonts` directory
const openSauceSans = localFont({
  src: [
    {
      path: '../public/font/OpenSauceSans/OpenSauceSans-Light.ttf',
      weight: '300',
      style: 'light',
    },
    {
      path: '../public/font/OpenSauceSans/OpenSauceSans-Regular.ttf',
      weight: '400',
      style: 'normal',
    }
  ],
  variable: '--font-open-sauce-sans',
});

export default function Home() {
  const router = useRouter()
  const [openChat, setOpenChat] = useState(false)
  const [userChatSession, setChatSessionId] = useState("")
  const [chatContent, setChatContent] = useState([])
  const [isLoadingChat, setIsLoading] = useState(false)
  useEffect(() => {
    const user = localStorage.getItem("LUMOS_WALLET") || ""
    //first fetch all the chats
    setChatSessionId(localStorage.getItem('LUMOS_CHAT_SESSION_ID') || (Math.floor(Math.random() * 1E14 * Math.random()) + "u_v"))
    if(user){
      router.replace('/dao')
    }
  },[])

  const logos = ['/images/Stellar-logo.png', '/images/lumenswap-logo-1.png', '/images/authentic-payment.png', '/images/dicinu-logo.png', '/images/fred-energy-logo.png']
  const supportedNetworks = ['/images/solana.svg', '/images/eth.svg', '/images/ton.svg', '/images/ava.svg']
  
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
  /** FOR CHAT */

  //load previous chat session
  const loadAllChats = async () => {
    const chats = await getAllChats(userChatSession)
    if(chats){
      if(chats.length > 0) {
        chats.sort((b, a) => Number(b.id) - Number(a.id))
        console.log(chats)
        setChatContent(chats)
      }
    }
  }
  //send a new chat message
  const sendChat = async () => {
    if(!isLoadingChat){
      //do if is not loading chat
      const msg = E('chatMessage').value.trim()
      E('chatMessage').value = ""
      setIsLoading(true)
      const myMessage = {
        type:'me', date:Date(), msg, id:Math.random() * 100
      }
      setChatContent([...chatContent, ...[myMessage]])
      if(msg){
        const reply = await sendChatBotMsg(userChatSession, msg)
        if(reply !== false) {
          //add response to new array
          const replyMessage = {
            type:'other', date:Date(), msg:reply,
          }
          //check if my msg has add to chat content
          if(!chatContent.includes(myMessage)) setChatContent([...chatContent, ...[myMessage], ...[replyMessage]])
          if(chatContent.includes(myMessage)) setChatContent([...chatContent, ...[replyMessage]])
          
        }
      }
      setIsLoading(false)
    }
  }
  useEffect(() => {
    if(userChatSession != ""){
      localStorage.setItem('LUMOS_CHAT_SESSION_ID', userChatSession)
    }
    loadAllChats()
  }, [userChatSession])

  return (
    <div className='bg-[#FCFCFE]'>
      <main className='text-white topBg flex lg:items-start items-center text-center justify-center mx-auto flex-col md:px-[5rem] px-[1rem] pt-[3rem]'>
          <div className='text-center lg:mt-0 mt-10'>
              <h1 className='w-full lg:w-[50%] mx-auto lg:text-[50px] md:text-[38px] sm:text-[30px] text-[30px] font-[400] text-heading-color mt-[2rem] leading-[50px]'>Decentralized Governance made <span className="text-[#FFDD60]">simple</span></h1>
              <p className={`helvetica-font font-[300] w-full lg:w-[65%] mx-auto text-text-color mt-[30px] mb-6 leading-[1.6] tracking-[1px] text-[16px]`}>Unlock the full potential of decentralized governance with LumosDAO's suite of features designed for efficiency, transparency, and community empowerment.</p>
              <div className='inline-flex gap-5 hero-btns flex-col sm:flex-row'>
                  {/* <Link href="#trusted" className='bg-[#FF7B1C] text-white px-5 py-[7px] rounded-[15px] font-[400]'>Enter App</Link> */}
                  <a href="/dao" className={`bg-[#FF7B1B] text-white px-8 py-[10px] rounded-[12px] font-[400] leading-[1.6] helvetica-font`}>Enter App</a>
                  <Link href="#trusted" className={`border border-[#FF7B1B] text-white px-5 py-[10px] rounded font-[400] leading-[1.6] helvetica-font`}>Learn More</Link>
              </div>
          </div>
          <div className="xl:w-[1000px] w-[93%] mx-auto videoBg xl:h-[500px] h-[300px] mt-[3rem] relative">
            <div className="xl:w-[950px] w-[90%] mx-auto h-full bg-white absolute bottom-[-4rem] left-0 right-0">
              <video className='w-[100%] h-[100%] object-contain' controls>
                <source src="/images/lumos-dao-vid.mp4" type="video/mp4" />
              </video>
            </div>
          </div>
          {/* <video controls className='lg:w-[600px] h-[500px] mt-[1rem] mx-auto'>
            <source src="/images/lumos-dao-vid.mp4" type="video/mp4" />
          </video> */}
          {/* <div>
          </div> */}
      </main>

      <div className="mt-[10rem] lg:px-[7rem] md:px-[4rem] px-[1rem]">
        <p className="text-[#817E7E] tracking-[10px] text-[14px]">SUPPORTED NETWORKS</p>
        <div className="flex items-center justify-center mt-5">
          {/* <div className="flex gap-[100px]"> */}
            <img src="/images/stellar.svg" className="md:mr-9 mr-5 md:w-[100px] w-[75px]" alt="Supported Networks" />
            <img src="/images/ripple.svg" className="md:w-[100px] w-[75px]" alt="Supported Networks" />
          {/* </div> */}
          <Swiper
            autoplay={{
                delay: 0,
                disableOnInteraction: false,
            }}
            breakpoints={{
                0:{
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
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
                supportedNetworks.map((item, index) => {
                  return(
                    <SwiperSlide key={index}>
                      <img src={item} className="md:w-[100px] w-[85px] mx-auto" alt="Supported Networks" />
                    </SwiperSlide>
                  )
                })
              }
          </Swiper>
        </div>
      </div>

      <div>        
        <div className="mt-[10rem] lg:px-[7rem] md:px-[4rem] px-[1rem]">
          <p className="text-[#817E7E] tracking-[10px] md:text-[19px] text-[14px]">MEET LUMOS</p>
          <p className="md:text-[40px] text-[25px] lg:w-[75%] w-full my-5 tracking-[1.5px]">Lumos DAO is committed to revolutionizing <span className="gradient-text">governance</span> in the decentralized world.</p>
          <p className={`text-[#000] lg:w-[58%] md:w-[70%] w-full md:text-[16px] text-[16px] tracking-[0.5px] leading-[26px] font-[300] helvetica-font`}>We offer users a comprehensive suite of tools designed to enhance efficiency, promote transparency, and empower communities to take control of their decision-making processes.</p>
        </div>
        <img src="/images/Mesh%20Landscape.png" alt="" />
      </div>

      <div className="text-center">
        <p className="gradient-text lg:text-[46px] text-[30px] mt-8">$10,181,595.03</p>
        <p className="text-[#817E7E] md:tracking-[10px] tracking-[3px] leading-[2] md:text-[14px] text-[12px]">TOTAL VALUE OF <br className="hidden lg:block"/> PROJECTS</p>
      </div>

      <section className="my-[10rem]">
        <div className="text-center lg:w-[58%] md:w-[70%] w-[90%] mx-auto mb-10">
          <p className="text-[#817E7E] tracking-[10px] text-[15px] mb-2">FEATURES</p>
          <p className={`text-[#000] leading-2 text-[13px] md:text-[16px] tracking-[0.5px] leading-[1.6] font-[300] helvetica-font`}>Unlock the full potential of decentralized governance with LumosDAO's suite of features designed for efficiency, transparency, and community empowerment. Explore our core functionalities that set the foundation for democratic decision-making</p>
        </div>

        <div className="flex flex-col md:flex-row items-center justify-between bg-white xl:w-[1200px] lg:max-w-[1200px] mx-auto mt-5">
          <div className="md:w-[70%] lg:w-[48%] w-[95%] p-[4rem] pt-[4rem] pb-[10px] px-[1rem]">
            <p className="text-[#817E7E] md:tracking-[10px] tracking-[4px] md:text-[14px] text-[12px]">DAO CREATION</p>
            <p className="text-[#011635] md:text-[28px] text-[22px] my-[6px] tracking-[0.5px]">Launch Your <span className="gradient-text">DAO</span> Seamlessly</p>
            <p className={`text-[#000] md:text-[16px] text-[13px] tracking-[0.5px] leading-[1.6] font-[300] helvetica-font`}>Easily set up and launch decentralized autonomous organizations (DAOs) with customizable structures to manage communities or projects on the blockchain</p>
            <p className={`text-[#D83111] mt-[4rem] tracking-[0.5px] leading-[1.6] helvetica-font`}>Launch Dao</p>
          </div>
          <img src="/images/Frame.png" className="lg:w-[400px] md:w-[300px] w-[270px] ml-auto md:ml-0" alt="" />
        </div>

        <div className="flex flex-col-reverse md:flex-row items-center justify-between bg-white xl:w-[1200px] lg:max-w-[1200px] mx-auto my-10">
          <img src="/images/form.png" className="lg:w-[400px] md:w-[300px] w-[270px] mr-auto md:mr-0" alt="" />
          <div className="md:w-[70%] lg:w-[48%] w-[95%] p-[4rem] pt-[4rem] pb-[10px] px-[1rem] text-right">
            <p className="text-[#817E7E] md:tracking-[10px] tracking-[4px] md:text-[14px] text-[12px]">ASSET CREATION</p>
            <p className="text-[#011635] md:text-[28px] text-[22px] my-[6px] tracking-[0.5px]">Tokenize and Manage <span className="gradient-text">Assets</span></p>
            <p className={`text-[#000] md:text-[16px] text-[13px] helvetica-font tracking-[0.5px] font-[300] leading-[1.6]`}>Create and tokenize digital assets, providing a secure and efficient way to represent ownership and value within your DAO ecosystem.</p>
            <p className={`text-[#D83111] mt-[4rem] helvetica-font tracking-[0.5px] leading-[1.6]`}>Create Asset</p>
          </div>
        </div>

        <div className="flex flex-col lg:flex-row items-center gap-5 xl:w-[1200px] lg:max-w-[1200px] mx-auto">
          <div className="flex items-start justify-between bg-white xl:w-[1200px] lg:max-w-[1200px] mx-auto flex-col md:flex-row">
            <div className="p-[2rem]">
              <p className="text-[#817E7E] md:tracking-[10px] tracking-[4px] md:text-[14px] text-[12px]">VOTING</p>
              <p className="text-[#011635] md:text-[28px] text-[22px] my-[8px] tracking-[0.5px]">Secure & Transparent <span className="gradient-text">Voting</span></p>
              <p className={`text-[#000] md:text-[14px] text-[13px] helvetica-font tracking-[0.5px] font-[300] leading-[1.6]`}>Implement a reliable and decentralized voting system, allowing members to participate in decision-making with transparency and trust.</p>
              <p className={`text-[#D83111] mt-[4rem] helvetica-font tracking-[0.5px] leading-[1.6]`}>Explore voting system</p>
            </div>
            <img src="/images/Frame-2.png" className="w-[120px] ml-auto md:ml-0" alt="" />
          </div>

          <div className="flex flex-col-reverse md:flex-row items-center justify-between bg-white xl:w-[1200px] lg:max-w-[1200px] mx-auto my-10">
            <img src="/images/Frame-3.png" className="md:w-[120px] w-[220px] mr-auto md:mr-0" alt="" />
            <div className="p-[2rem] text-right">
              <p className="text-[#817E7E] md:tracking-[10px] tracking-[4px] md:text-[14px] text-[12px]">ASSET WRAPPING</p>
              <p className="text-[#011635] md:text-[28px] text-[22px] my-[8px] tracking-[0.5px]">Unlock Cross-Chain <span className="gradient-text">Liquidity</span></p>
              <p className={`text-[#000] md:text-[14px] text-[13px] helvetica-font tracking-[0.5px] font-[300] leading-[1.6]`}>Wrap assets into tokens compatible with multiple blockchains, expanding liquidity and utility within decentralized ecosystems.</p>
              <p className={`text-[#D83111] mt-[4rem] helvetica-font tracking-[0.5px] leading-[1.6]`}>Wrap Asset</p>
            </div>
          </div>
        </div>

        <div className="flex flex-col md:flex-row items-center justify-between bg-white xl:w-[1200px] lg:max-w-[1200px] mx-auto mt-5">
          <div className="md:w-[70%] lg:w-[48%] w-[95%] p-[4rem] pt-[4rem] pb-[10px] px-[1rem]">
            <p className="text-[#817E7E] md:tracking-[10px] tracking-[4px] md:text-[14px] text-[12px]">PROPOSAL CREATION</p>
            <p className="text-[#011635] md:text-[28px] text-[22px] my-[6px] tracking-[0.5px]">Submit <span className="gradient-text">Proposals</span> with Ease</p>
            <p className={`text-[#000] md:text-[16px] text-[13px] helvetica-font tracking-[0.5px] font-[300] leading-[1.6]`}>Empower DAO members to create and submit proposals for new initiatives, changes, or policies, fostering collaborative governance.</p>
            <p className={`text-[#D83111] mt-[4rem] helvetica-font tracking-[0.5px] leading-[1.6]`}>Create Proposal</p>
          </div>
          <img src="/images/Frame-4.png" className="lg:w-[400px] md:w-[300px] w-[270px] ml-auto md:ml-0" alt="" />
        </div>

        <div className="flex flex-col-reverse md:flex-row items-center justify-between bg-white xl:w-[1200px] lg:max-w-[1200px] mx-auto my-10">
          <img src="/images/Frame-5.png" className="lg:w-[400px] md:w-[300px] w-[270px] mr-auto md:mr-0" alt="" />
          <div className="md:w-[70%] lg:w-[48%] w-[95%] p-[4rem] pt-[4rem] pb-[10px] px-[1rem] text-right">
            <p className="text-[#817E7E] md:tracking-[10px] tracking-[4px] md:text-[14px] text-[12px]">VOTING POWER DELEGATION</p>
            <p className="text-[#011635] md:text-[28px] text-[22px] my-[6px] tracking-[0.5px]">Delegate <span className="gradient-text">Voting</span> Power Effortlessly</p>
            <p className={`text-[#000] md:text-[16px] text-[13px] helvetica-font tracking-[0.5px] font-[300] leading-[1.6]`}>Allow DAO members to delegate their voting power to trusted representatives, ensuring efficient governance and active participation.</p>
            <p className={`text-[#D83111] mt-[4rem] helvetica-font tracking-[0.5px] leading-[1.6]`}>Get started</p>
          </div>
        </div>

        <div className="flex flex-col lg:flex-row items-center gap-5 xl:w-[1200px] lg:max-w-[1200px] mx-auto">
          <div className="flex flex-col md:flex-row items-start justify-between bg-white xl:w-[1200px] lg:max-w-[1200px] mx-auto">
            <div className="p-[2rem]">
              <p className="text-[#817E7E] tracking-[10px] text-[14px]">DAO ADMIN TOOLS</p>
              <p className="text-[#011635] text-[22px] my-[8px] tracking-[0.5px]"> Administer Your <span className="gradient-text">DAO</span> with Control</p>
              <p className={`text-[#000] text-[14px] helvetica-font tracking-[0.5px] font-[300] leading-[1.6]`}>Manage your DAO with advanced tools, including governance settings, member permissions, and operational controls for smooth administration.</p>
              <p className={`text-[#D83111] mt-[4rem] helvetica-font tracking-[0.5px] leading-[1.6]`}>Explore Defi</p>
            </div>
            <img src="/images/Frame-6.png" className="w-[150px] ml-auto md:ml-0" alt="" />
          </div>

          <div className="flex flex-col-reverse md:flex-row items-start justify-between bg-white xl:w-[1200px] lg:max-w-[1200px] mx-auto">
            <img src="/images/Frame-7.png" className="w-[120px] mr-auto md:mr-0" alt="" />
            <div className="p-[2rem] text-right">
              <p className="text-[#817E7E] tracking-[10px] text-[14px]">DEFI</p>
              <p className="text-[#011635] text-[22px] my-[8px] tracking-[0.5px]"> Integrate <span className="gradient-text">DeFi</span> for Asset Growth</p>
              <p className={`text-[#000] text-[14px] helvetica-font tracking-[0.5px] font-[300] leading-[1.6]`}>Tap into decentralized finance (DeFi) to enhance your DAO’s assets through staking, lending, yield farming, and more, maximizing value and returns.</p>
              <p className={`text-[#D83111] mt-[4rem] helvetica-font tracking-[0.5px] leading-[1.6]`}>Explore Defi</p>
            </div>
          </div>
        </div>
      </section>

      <section>
        <div className="text-center lg:w-[50%] md:w-[70%] w-[90%] mx-auto mb-10">
          <p className="text-[#817E7E] tracking-[10px] text-[14px] mb-2">WHY US</p>
          <p className={`text-[#000] leading-2 text-[13px] md:text-[16px] font-[300] tracking-[0.5px] leading-[1.6] helvetica-font`}>LumosDAO offers a range of benefits tailored to meet the needs of both DAO members and creators, ensuring a robust, transparent, and user-friendly platform for decentralized governance.</p>
        </div>
        <div className="tracking-[0.5px] flex items-center justify-center gap-5 xl:w-[1200px] lg:max-w-[1200px] mx-auto p-3 flex-col md:flex-row">
          <div className="bg-[#492F8A] rounded-[10px] pt-[4rem] pb-[0.5rem] pl-[1rem] w-[90%] md:w-[500px] h-[500px]">
            <img src="/images/FrameG2.png" alt="" className="w-[300px] ml-auto" />
            <div className="text-white pl-5 mt-[2.4rem]">
              <p>For DAO <span className="gradient-text text-[18px]">Creators</span></p>
              <ul className="pl-[1.8rem] text-[14px] list-decimal font-[300] mt-3 grid gap-2 helvetica-font">
                <li>Advance governance mechanism</li>
                <li>DAO Management tools</li>
                <li>Low fees</li>
                <li>Setup a DAO in seconds</li>
              </ul>
            </div>
          </div>
          <div className="bg-[#fff] rounded-[10px] pt-[4rem] pb-[0.5rem] pl-[1rem] w-[90%] md:w-[500px] h-[500px]">
            <img src="/images/FrameG.png" alt="" className="w-[300px] mr-auto" />
            <div className="text-black pl-5 mt-[2.4rem]">
              <p>For DAO <span className="gradient-text text-[18px]">Creators</span></p>
              <ul className="pl-[1.8rem] text-[14px] font-[300] list-decimal mt-3 grid gap-2 helvetica-font">
                <li>Easy DAO Participation</li>
                <li>Voting Power Delegation</li>
                <li>Messaging</li>
                <li>DEFI (Coming Soon)</li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      {
        openChat ?
        <div>
          <div id="chat-container" class="fixed bottom-4 right-4 w-96 z-[100000] text-[12px]">
              <div class="bg-white shadow-md rounded-lg max-w-lg w-full">
                  <div class="p-3 border-b bg-[#FFA056] text-white rounded-t-lg flex justify-between items-center">
                      <p class="text-md font-semibold">Customer Support</p>
                      <button onClick={() => setOpenChat(false)} class="text-white">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                          </svg>
                      </button>
                  </div>
                  <div id="chatbox" class="p-4 h-[400px] overflow-y-auto">
                    {/* <!-- Chat messages will be displayed here --> */}

                  {
                    chatContent.map((chat, index) => (
                      chat?.type === 'other' ? (
                        <div className="mb-3">
                          <p key={index} className="bg-gray-200 text-gray-700 rounded-b-lg rounded-tr-lg py-2 px-4 inline-block max-w-[80%] break-words">
                            {chat?.msg}
                          </p>
                        </div>
                      ) : chat?.type === 'me'? (
                        <div className="mb-3 text-right">
                          <p key={index} className="bg-[#FFA056] text-white rounded-b-lg rounded-tl-lg py-2 px-4 inline-block max-w-[80%] break-words text-left">
                            {chat?.msg}
                          </p>
                        </div>
                      ): (<></>)
                    ))
                  }

                  {
                    isLoadingChat &&
                    <div class='bg-gray-200 text-gray-700 rounded-b-lg rounded-tr-lg py-[10px] px-[10px] p-2 mt-2 mx-1 w-[13.5%] mr-auto flex gap-1 items-center'>
                        <div class='h-[6px] w-[6px] bg-black rounded-full animate-bounce [animation-delay:-0.9s]'></div>
                        <div class='h-[6px] w-[6px] bg-black rounded-full animate-bounce [animation-delay:-0.45s]'></div>
                        <div class='h-[6px] w-[6px] bg-black rounded-full animate-bounce'></div>
                    </div>
                  }

                    <div class="mb-2">
                      {
                        chatContent.length == 0 ?
                        <p className="bg-gray-200 text-gray-700 rounded-lg py-2 px-4 inline-block">
                          Hello From Lumos DAO<br/>
                          How can i help you today?
                        </p>
                        :
                        <></>
                      }
                    </div>

                  </div>
                  <div class="p-4 border-t flex">
                      <input 
                        onKeyDown={($event) => {
                          if($event.keyCode == 13){
                            sendChat()
                          }
                        }} 
                       id='chatMessage' type="text" placeholder="Type a message" class="w-full px-3 py-2 border rounded-l-md focus:outline-none" />
                      <button onClick={sendChat} class="bg-[#FFA056] text-white px-4 py-2 rounded-r-md hover:bg-[#e6904e] transition duration-300"><BiSend /></button>
                  </div>
              </div>
        
          </div>
        </div>
        :
        <p onClick={() => setOpenChat(true)} className="fixed right-[20px] bottom-[20px] text-white bg-[#FFA056] p-[12px] text-[20px] rounded-full cursor-pointer z-[100000]"><FaRegMessage /></p>
      }
    </div>
  );
}
