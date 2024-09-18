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
  };
  useEffect(() => {
    window.walletAddress = localStorage.getItem('selectedWallet') || ""
  },[])
  return (
    <div data={sortDetails} className="mx-auto bg-white shadow-lg w-full md:max-w-[430px] rounded-lg overflow-hidden cursor-pointer" onClick={() => location.assign(`/dao/${dao.id}`)} >
      <div className="relative">
          <img
              className="w-full h-32 sm:h-48 object-cover"
              src={dao.banner} // Replace with the path to your image
              alt="LumosDAO"
          />
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
              <img className="w-[48px] h-[48px] mr-2 object-cover rounded-full mt-[-40px] relative z-[100]" src={dao.banner} alt="LumosDAO logo" /> {/* Replace with the path to your logo */}
              <h1 className="text-lg font-semibold">{dao.title}</h1>
          </div>
          <p className="mt-2 text-sm text-gray-600 h-[100px] overflow-y-scroll py-5">
              {dao.description}
          </p>
          <div className="mt-4">
              <div className="text-sm font-semibold text-center flex items-center justify-center gap-3 my-5"> 
                  <p className='h-[60px] w-[60px] flex items-center justify-center rounded-full text-[36px] bg-[#EFF2F6] text-[#f39c12]'>{dao.activeProposals}</p> 
                  <p className='text-[18px]'>Active proposals</p> 
              </div>
              <div className="mt-2 flex gap-3 justify-around">
                  <div className="text-center bg-[#EFF2F6] w-full py-2 rounded-[10px]">
                      <p className="text-lg font-bold text-[#f39c12]">{dao.members}</p>
                      <p className="text-xs text-gray-600 font-[600]">Members</p>
                  </div>
                  <div className="text-center bg-[#EFF2F6] w-full py-2 rounded-[10px]">
                      <p className="text-lg font-bold text-[#f39c12]">{dao.proposals}</p>
                      <p className="text-xs text-gray-600 font-[600]">Proposals</p>
                  </div>
              </div>
          </div>
      </div>
    </div>
  )
}

export default DaoCard