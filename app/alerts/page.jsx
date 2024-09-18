'use client'
import React, { useEffect, useMemo } from 'react'
import {  paginate } from '../core/core';
import { fAddr, getAllUserAlerts } from '../core/getter';

let hasLoad = false;
const AlertPage = () => {

  const main = async () => {
    //fetch the alert 
    if(!hasLoad){ 
      hasLoad = true  
      const alerts = await getAllUserAlerts()
      if(alerts !== false) {
          //do the pagination
          paginate('alert_view', alerts, 10, drawAlert)
          //reset the alert num to zero
          E('nav_user_alert_num').innerText = 0
      }
    }
  }

  /* DRAWS */
  const drawAlert = (param) => {
      param = JSON.parse(param)
      const view = `<div class='flex items-start justify-between bg-[#EFF2F6] p-3 rounded-[6px] my-3 flex-col md:items-center md:flex-row gap-3'>
                  <div class='gap-2 '>
                    <p class='text-blue-600'>
                    ${param.title}
                    </p>
                    <div class='flex items-center '>
                        <a href="${param.link}"> ${fAddr(param.other, 8) + " " + param.action}</a>
                      </div>
                </div>
                <div class='flex items-center gap-2'>
                    <p>${new Date(param.date).toLocaleString()}</p> 
                </div>
            </div>`
      return view;
  }

  useEffect(() => {
    main()
  }, [])
  return (
    <div className='px-[3rem] my-[80px]'>
      <p className='font-[500] mb-5 text-[26px]'>LumenDAO Notifications</p>
      <div id='alert_view' className='p-4 rounded-[6px] bg-white'>
       <center style={{margin:'auto',marginTop:'20px'}}>Fetching data...</center>
      </div>
    </div>
  )
}

export default AlertPage