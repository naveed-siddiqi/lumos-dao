'use client'

import React, { useEffect, useMemo } from 'react'; 
import { stopTalking, talk } from '../components/alert/swal';
import { API_URL } from '../data/constant';

const TwoFactorAuth = () => {
 
  //to verify two factor authentication
  const verify2Fa = async () => {
    const code = E('2fa_otp_code').value;  
    if(code != "") { console.log(code)
        const id = talk('Authenticating...')
        try{
            const response = await fetch(API_URL + `login_2fa&code=${code}&user=` + walletAddress + "&id=" + Math.random());
            if (!response.ok) {
              stopTalking(3, talk('Network error', 'fail', id))
            }
            let res = await response.json();
            if(res.status === true) {
                stopTalking(3, talk('Authenticaticated', 'good', id))
                if(typeof window !== "undefined"){
                  //redirect to homepage
                  window.location.assign('/dao')
                }
            }
            else {
                stopTalking(3, talk('Authentication failed', 'fail', id))
            }
        }
        catch(e) { console.log(e)
            stopTalking(3, talk('Something went wrong', 'fail', id))
        }
    }
  }
  useEffect(() => {
    if(walletAddress == "") {
      if (typeof window !== "undefined") {
        //redirect to homepage
        // Code that uses the window object
        window.location.assign('/dao')
      }
    }
  }, [])
  return (
    <div className="flex justify-center items-center h-screen bg-gray-100 helvetica-font">
      <div className="w-full max-w-[350px]">
        <form className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
          <div className="mb-4">
            <h2 className="text-center text-3xl mb-4">Two Factor Authentication</h2>
            <input
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              id="2fa_otp_code"
              type="text"
              placeholder="Authentication code"
            />
          </div>
          <div className="flex items-center justify-center w-full">
            <button onClick={()=>{verify2Fa()}}
              className="bg-green-500 hover:bg-green-700 text-white w-full font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              type="button"
            >
              Approve
            </button>
          </div>
          <p className="text-gray-600 text-sm mt-4">
            Open your two-factor authenticator app or browser extension to view your authentication code.
          </p>
        </form>
      </div>
    </div>
  );
};

export default TwoFactorAuth;
