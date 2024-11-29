import { createTrustline, N } from '@/app/core/core'; 
import { useRouter } from 'next/navigation';
import React, { useEffect } from 'react'
import { stopTalking, talk } from '../alert/swal';

const DaoCard = ({dao}) => {
  const router = useRouter();
  const sortDetails = JSON.stringify({
    created: N(dao.created),
    active: N(dao.active_proposals),
    proposals: dao.proposals,
  });

  /** To Join Dao
  * @params {daoAddress} String
  **/
  const joinDao = async (event, code, issuer, name, daoId) => {
    event.stopPropagation();
    if(!dao.joined){    
      if(dao.chain == CHAIN){
        const id = talk("Joining " + name + " dao");
        const res = await createTrustline(code, issuer, walletAddress, name, daoId);
        if (res === false) {
            talk(
                "Something went wrong<br>This may be due to network error",
                "fail",
                id
            );
            } else {
            talk("Joined " + name + " successfully", "good", id);
            //show that it has joined
            const elem = event.target;
            elem.innerHTML = "Member";
            dao.joined = true
            elem.onclick = null;
            //redirect to dao page
            window.location.assign(`/dao/${daoId}`)
        }
        stopTalking(4, id);
      }
      else {
        stopTalking(4, talk('Unsupported chain', 'fail'))
      }
    }
  };
  useEffect(() => {
    window.walletAddress = localStorage.getItem('selectedWallet') || ""
  },[])
  return (
    <div data={sortDetails} className="mx-auto bg-white border border-[#E6E7E8] w-full md:max-w-[430px] overflow-hidden cursor-pointer helvetica-font" onClick={() => location.assign(`/dao/${dao.id}`)} >
      <div className="relative">
          <img
              className="w-full h-32 sm:h-48 object-cover"
              src={dao.banner} // Replace with the path to your image
              alt="LumosDAO"
          />
          {/* <button className="absolute top-4 left-4 ml-[10px] bg-blue-400 text-white rounded-full px-3 py-1 text-xs font-bold">
             {(dao.chain!="")?dao.chain:"stellar"}
         </button> */}
          {(dao.owner == walletAddress) ?
          <button className="absolute top-4 right-4 bg-yellow-400 text-white rounded-full px-3 py-1 text-xs font-bold">
             Owner
         </button>:
         (!dao.joined) ?
          <button onClick={($event) => joinDao($event, dao.code, dao.issuer, dao.title, dao.id)} className="absolute top-4 right-4 bg-yellow-400 text-white rounded-full px-3 py-1 text-xs font-bold">
            Join
          </button>
          :
          <button className="absolute top-4 right-4 bg-yellow-400 text-white rounded-full px-3 py-1 text-xs font-bold">
            Member
          </button> 
         }
      </div>
      <div className="p-4">
          <div className="flex items-start flex-col gap-3">
            <div className='p-[4px] bg-[white] w-[70px] h-[70px] mt-[-50px] rounded-full relative z-[100]'>
              <img className="w-full h-full rounded-full object-cover" src={dao.logo} alt="LumosDAO logo" /> {/* Replace with the path to your logo */}
            </div>
              <div className='flex items-center justify-between w-full'>
                <h1 className="text-lg font-semibold">{dao.title}</h1>
                <div className="flex items-center gap-1 text-[#141B34] bg-[#F2F6FE] px-3 py-[5px] rounded-full">
                  <img src="/images/chain.svg" alt="" />
                  <p>{(dao.chain!="")?dao.chain:"Stellar"}</p>
                </div>
              </div>
          </div>
          <p className="text-sm text-gray-600 h-[100px] overflow-y-scroll pb-5 pt-3">
              {dao.description}
          </p>

          <div className="mt-4 flex items-center gap-5 text-[14px] w-full text-[#141B34] capitalize">

            {/* <div className="flex items-center gap-1">
              <img src="/images/token.svg" alt="" />
              <p>Token Based</p>
            </div> */}
              {/* <div className="text-sm font-semibold text-center flex items-center justify-center gap-3 my-5"> 
                  <p className='h-[60px] w-[60px] flex items-center justify-center rounded-full text-[36px] bg-[#EFF2F6] text-[#f39c12]'>{dao.activeProposals}</p> 
                  <p className='text-[18px]'>Active proposals</p> 
              </div> */}
              <div className="mt-2 flex gap-3 justify-between w-full">
                  <div className="border border-[#DBDEE3] w-full p-2 rounded-[10px]">
                      <p className="text-[#141B34] mb-7">Members</p>
                      <p className="ttext-[#141B34]">{dao.members}</p>
                  </div>
                  <div className="border border-[#DBDEE3] w-full p-2 rounded-[10px]">
                      <p className="text-[#141B34] mb-7">Proposals</p>
                      <p className="ttext-[#141B34]">{dao.proposals}</p>
                  </div>
              </div>
          </div>
      </div>
    </div>
  )
}

export default DaoCard