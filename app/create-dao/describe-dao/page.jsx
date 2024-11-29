"use client"

import React, { useEffect, useState } from 'react'
import Link from 'next/link'
import { IoCloseOutline } from 'react-icons/io5';
import * as StellarSdk from '@stellar/stellar-sdk'; 
import { createDaos, createTrustlineQuiet, deployStellarAsset, fundIssuer, isDao, isSafeToml, lockIssuerQuietly, mintToken, optimizeImg, validateImageUpload, verifyAsset, wrapAsset } from '../../core/core';
import { fAddr, isSubDomainExists, readAssetToml } from '../../core/getter';
import { API_URL, S, TOML_URL, xrp, xrpClient } from '../../data/constant';
import { stopTalking, talk } from '../../components/alert/swal';  

let projectType = '';
let assetAddress = null; 
let issueAddress = "";
let approveWallets = []
let assetUrl = null
let upload_file = null
let cover_upload = null;
let issuingkeyPair = ""
let issuingAddress = ""
let daoName = ""
let chain = ""

const page = () => {

  const [createDaoModal, setCreateDaoModal] = useState(false);
  const [MIN_TX_FEE, setMinTxFee] = useState("")
  const [uploadedImg, setUploadedImg] = useState()
  const [coverImg, setCoverImg] = useState()

   //This function search for assets
   const searchForAsset = async () => {
    const assetCode = E('assetCode').value.trim()
    const assetToml = E('assetUrl').value.trim()
    if(assetCode != "" && assetToml != "") {
        //check for insecure url
        if(assetToml.indexOf('http://') > -1 && assetToml.indexOf(window.location.host) == -1){
            stopTalking(4, talk("Trying to load a toml file at an insecure address<br>Please use a secure address (https://)", "fail"))
            return;
        }
        //get the toml
        E('assetButton').disabled = true //disable button
        E('asset_s').style.display = "none"
        const id = talk("Searching for Asset...")
        const tomlDetails = await readAssetToml(assetToml, CHAIN)
        if(tomlDetails !== false) {
            let flg = false
            //display information
            if(tomlDetails.CURRENCIES){
                for(let i=0; i<tomlDetails.CURRENCIES.length;i++) {
                    const cur = tomlDetails.CURRENCIES[i]
                    if(cur?.code == assetCode || cur?.currency == assetCode) {
                        //have found our code
                        E('asset_s_name').innerHTML = cur.name || ""
                        E('dao_name').value = cur.name || ""
                        E('asset_s_code').innerHTML = cur.code || cur?.currency || ""
                        E('asset_s_domain').innerHTML = (tomlDetails.DOCUMENTATION) ? tomlDetails.DOCUMENTATION.ORG_URL : ""
                        E('dao_about').value = cur.desc || ""
                        E('asset_s_img').src = cur.image || cur.icon || "https://images.unsplash.com/photo-1513151233558-d860c5398176?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        if(!(cur.issuer == undefined || cur.issuer == "")) {
                            (tomlDetails.ACCOUNTS == undefined) ? tomlDetails.ACCOUNTS = [] :  "";
                            issueAddress = cur.issuer
                            approveWallets = tomlDetails.ACCOUNTS
                            assetUrl = assetToml
                        }
                        else {
                            flg = false
                            stopTalking(4, talk("Unable to find issuer address in Toml file", "fail"))
                            stopTalking(4, id)
                            E('assetButton').disabled = false
                            return;
                        }
                        flg = true
                        break;
                    }
                }
            }
            if(flg) {
                //show div
                await checkForAsset()
                E('asset_s').style.display = "block"
                talk("Asset found", "good", id)
                stopTalking(4, id)
            }
            else {
                stopTalking(4, talk("Unable to find asset in Toml file", "fail"))
                stopTalking(4, id)
            }
        }
        else {
            stopTalking(4, talk("Unable to fetch Toml file<br> This can be due to network or bad Toml URL address", "fail"))
            stopTalking(4, id)
        }
        
    }
    E('assetButton').disabled = false
   
}
//this functions verifies an asset
const checkForAsset = async () => {
    const assetCode = E('assetCode').value.trim()
    if(assetCode != "" && issueAddress != "") {
        //disable button
        const res = await verifyAsset({
            code:assetCode, issuer:issueAddress,
        })
        if(res === false) {
            //unwrapped token
            E('asset_s_msg').innerHTML = `This asset has not been wrapped. Click on Wrap Asset`
            E('asset_s_msg').style.color = 'dodgerblue'
            E('createButton').innerText = 'Wrap Asset'
            E('createButton').onclick = () => {wrapToken()}
        }
        else {
            assetAddress = res
            E('asset_s_msg').innerHTML = "This asset can be used"
            E('asset_s_msg').style.color = 'forestgreen'
            E('createButton').innerText = 'Create Dao'
            E('createButton').onclick = (event) => {createTheDao(event)}
        } 
        E('assetButton').disabled = false
    }
}
//this function wraps the asset
const wrapToken = async () => {
    const assetCode = E('assetCode').value.trim()
    if(assetCode != "" && issueAddress != "") {
        const id = talk("Wrapping Asset")
        try{
            E('assetButton').disabled = true
            await new Promise((resolve) => setTimeout(resolve, 500));
            const val = await wrapAsset(); 
            if(val !== false) {
                //make call to the main asset wrapping route
                const url = API_URL + "wrapasset&code=" + assetCode + "&issuer=" + issueAddress + "&rand=" + Math.random()
                fetch(url, {
                    method: 'GET', // *GET, POST, PUT, DELETE, etc.
                    mode: 'cors', // no-cors, *cors, same-origin
                    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                    headers: {
                      'Content-Type': 'application/json'
                    },
                }).then((response) => response.json()
                    .then(async (data) => {  console.log(data)
                        await checkForAsset()
                        E('assetButton').disabled = false
                        if(data === "1" || data === 1) {
                            talk("Wrapped Successfully", "good", id)
                            stopTalking(3, id)
                        }
                        else {
                            talk("Something went wrong", "fail", id)
                            stopTalking(3, id)
                        }
                    }))
                    .catch(err => {
                        E('assetButton').disabled = false
                        talk("Something went wrong<br>This may be due to poor network", "fail", id)
                        stopTalking(3, id)
                    })
            }
            else {
                E('assetButton').disabled = false
                talk("Something went wrong", "fail", id)
                stopTalking(3, id)
            }
        }
        catch(e) { console.log(e)
            E('assetButton').disabled = false
            talk("Something went wrong", "fail", id)
            stopTalking(3, id)
        }
    }
}
//this function creates the dao
const createTheDao = async (event) => {
    event.preventDefault()
    const name = E('dao_name').value.trim()
    const desc = E('dao_about').value.trim()
    const _url = E('assetUrl').value.trim()
    const code = E('asset_s_code').innerHTML.trim()
    const img = E('asset_s_img').src.trim()
    if(name != "" && desc != "") {
        if(assetAddress != null) {
            if(approveWallets.includes(walletAddress)) {
                //disable button
                E('createButton').disabled = true
                const dao_exists = await isDao(assetAddress)
                if(dao_exists === false) {
                    const isSub = await isSubDomainExists(name)
                    let tName = name.replace(/[^a-zA-Z0-9]/g,"").toLowerCase()
                    if(isSub) {
                      //add random number to name
                      tName += Math.floor(Math.random() * 100000)
                    }
                    const id = talk("Creating Dao...")
                    const res = await createDaos({
                        domain:tName,
                        name:name,
                        about:desc,
                        token:assetAddress,
                        url:_url,
                        code,
                        issuer:issueAddress,
                        image:img
                    })
                    console.log(res)
                    daoName = name
                    if(res.status === false) {
                        //unwrapped token
                        talk(`Unable to create DAO<br>${res.msg}`, "fail", id)
                        stopTalking(4, id)
                    }
                    else if(res.status === true){
                        let _a = assetAddress; assetAddress  = null
                        issueAddress = ""
                        assetUrl = ""
                        talk("Dao created successfuly", "good", id)
                        stopTalking(4, id)
                        window.location.assign("/dao/" + _a)
                    }
                    else {
                        assetAddress = null
                        talk("This asset has already being used", "fail", id)
                        stopTalking(4, id)
                    }
                }
                else {
                    stopTalking(3, talk("This DAO already exists", "fail"))
                }
                E('createButton').disabled = false
            }
            else {
                stopTalking(3, talk("Your wallet is not present in the toml file", "fail"))
            }
        }
        else {
            stopTalking(3, talk("This asset cannot be used", "fail"))
        }
    }
    else {
        stopTalking(3, talk("Empty field present", "fail"))
    }
}

//this function creates the dao based on the other type
const createODao = async (event) => {
    let userAddress = (chain=='stellar')?issuingkeyPair.publicKey():issuingkeyPair.address;
    issuingAddress = userAddress
    event.preventDefault()
    const aCode = E('asset_o_code').value.trim()
    const aSupply = E('asset_o_supply').value.trim()
    const name = E('dao_o_name').value.trim()
    const about = E('dao_o_about').value.trim()
    if(aCode != "" && aSupply != "" && name != "" && about != "" && upload_file != null) {
        if(isSafeToml(aCode) && isSafeToml(name) && isSafeToml(about)) {
            //disable button
            E('createodao').disabled = true
            //check if subdomain exists
            const isSub = await isSubDomainExists(name)
            let tName = name.replace(/[^a-zA-Z0-9]/g,"").toLowerCase()
            if(isSub) {
                //add random number to name
                tName += Math.floor(Math.random() * 100000)
            } 
            //first fund the issuing wallet
            const id = talk(`Creating the issuing wallet...`)
            await new Promise((resolve) => setTimeout(resolve, 500));
            talk(`Funding the issuing wallet ${fAddr(issuingAddress, 5)}...`, 'norm', id)
            let res = await fundIssuer({
                address:issuingAddress
            })
            if(res.status !== false){
                talk(`Funded the issuing wallet`, 'good', id)
                await new Promise((resolve) => setTimeout(resolve, 500));
                talk("Creating Asset for DAO...", 'norm', id)
                //make wallet address the issuing keypair
                res = await deployStellarAsset(aCode, userAddress, issuingkeyPair)
                if(res.status === false) {
                    //unwrapped token
                    talk("Unable to create Asset<br>" + res.msg, "fail", id)
                    stopTalking(4, id)
                    E('createodao').disabled = false
                }
                else if(res.status === true || res.msg == "simulation fail"){
                    assetAddress = res.value
                    if(res.msg == "simulation fail") assetAddress = await verifyAsset({code:aCode, issuer:userAddress})
                    console.log(assetAddress)
                    talk("Asset created successfuly", "good", id)
                    //check if the dao has already being created
                    const dao_exists = await isDao(assetAddress)
                    if(dao_exists === false) {
                        //time to mint the asset
                        await new Promise((resolve) => setTimeout(resolve, 500));
                        //creating the toml file
                        talk(`Creating the ${CHAIN} toml file`, "norm", id)
                        uploadTomlFile(encodeURIComponent(createAssetToml({
                            domain:tName,
                            name:name,
                            code:aCode,
                            about:about,
                            issuer:userAddress,
                            distributing:walletAddress,
                            image:window.location.protocol + `//${TOML_URL}/.well-known/images/` + (aCode + userAddress) + ".png"
                        })), tName, assetAddress, async (res, turl) => {
                            if(res == true) {
                                //upload the file
                                uploadAssetImg(aCode + userAddress, tName, async (res, url) => {
                                    if(res == true) {
                                        const daoImage = url
                                        //time to mint the asset
                                        talk(`Created the ${CHAIN} toml file`, "good", id)
                                        //E('asset_o_toml').innerHTML = turl
                                        if(res == true){
                                            //talk("Domain set successfully", "good", id)
                                            await new Promise((resolve) => setTimeout(resolve, 500));
                                            talk("Minting suply", "norm", id)
                                            res = await createTrustlineQuiet(aCode, issuingAddress, walletAddress)
                                            if(res.status !== false){ 
                                                res = await mintToken(aSupply, aCode, userAddress, walletAddress, issuingkeyPair)
                                                if(res.status === false) {
                                                    //unwrapped token
                                                    talk("Unable to mint supply<br>" + res.msg, "fail", id)
                                                    await new Promise((resolve) => setTimeout(resolve, 500));
                                                    talk("You can still create the DAO by using the first option<br> Just input the toml url and the asset code", "warn", id)
                                                    E('createodao').disabled = false
                                                    stopTalking(5, id)
                                                }
                                                else if(res.status != undefined){
                                                    talk("Supply minted successfuly", "good", id)
                                                    await new Promise((resolve) => setTimeout(resolve, 500));
                                                    //verify the dao, then create the dao 
                                                    talk("locking issuing wallet", "norm", id)
                                                    //first transfer the balance before locking it
                                                    res = await lockIssuerQuietly({
                                                        issuer:userAddress,
                                                    }, issuingkeyPair)
                                                    if(res.status !== false) {
                                                        talk("locked issuing wallet", "good", id)
                                                        //change the issuing wallet address, to cover of create dao fail
                                                        issuingkeyPair = (chain == 'stellar')? StellarSdk.Keypair.random() : xrp.Wallet.generate()
                                                        //E('issuing_address').innerText = fAddr(issuingAddress, 4)
                                                        talk("Creating the DAO", "norm", id)
                                                        res = await createDaos({
                                                            domain:tName,
                                                            name:name,
                                                            about:about,
                                                            token:assetAddress,
                                                            url:turl,
                                                            code:aCode,
                                                            issuer:userAddress,
                                                            image:daoImage
                                                        })
                                                        daoName = name
                                                        if(res.status === false) {
                                                            //unwrapped token
                                                            E('createodao').disabled = false
                                                            talk(`Unable to create DAO<br>${res.msg}`, "fail", id)
                                                            stopTalking(4, id)
                                                        }
                                                        else if(res.status === true){
                                                            let _a = assetAddress; assetAddress  = null
                                                            talk("Dao created successfuly", "good", id)
                                                            await new Promise((resolve) => setTimeout(resolve, 1000));
                                                            stopTalking(4, id)
                                                            window.location.assign('/dao/'+ _a)
                                                        }
                                                        else {
                                                            E('createodao').disabled = false
                                                            assetAddress = null
                                                            talk("This asset has already being used<br>Chnage the asset code", "fail", id)
                                                            stopTalking(4, id)
                                                            //change the issuing wallet address, to cover of create dao fail
                                                            issuingkeyPair = (chain == 'stellar')? StellarSdk.Keypair.random() : xrp.Wallet.generate()
                                                            //E('issuing_address').innerText = fAddr((chain=='stellar')?issuingkeyPair.publicKey():
                                                            //issuingkeyPair.address, 6)
                                                        }
                                                    }
                                                    else {
                                                        talk("Unable to lock issuing wallet<br>" + res.msg, "fail", id)
                                                        E('createodao').disabled = false
                                                        stopTalking(4, id)
                                                        //change the issuing wallet address, to cover of create dao fail
                                                        issuingkeyPair = (chain == 'stellar')? StellarSdk.Keypair.random() : issuingkeyPair
                                                        //E('issuing_address').innerText = fAddr((chain=='stellar')?issuingkeyPair.publicKey():
                                                        //issuingkeyPair.address, 6)
                                                        
                                                    }
                                                }
                                            }
                                            else {
                                                E('createodao').disabled = false
                                                talk("Unable to mint supply <br>" + res.msg, "fail", id)
                                                stopTalking(4, id)
                                                //change the issuing wallet address, to cover of create dao fail
                                                issuingkeyPair = (chain == 'stellar')? StellarSdk.Keypair.random() : issuingkeyPair
                                                // E('issuing_address').innerText = fAddr((chain=='stellar')?issuingkeyPair.publicKey():
                                                // issuingkeyPair.address, 6)
                                            }
                                        }
                                        else {
                                            E('createodao').disabled = false
                                            talk("Unable to set domain<br>Something went wrong", "fail", id)
                                            stopTalking(4, id)
                                            //change the issuing wallet address, to cover of create dao fail
                                            issuingkeyPair = (chain == 'stellar')? StellarSdk.Keypair.random() : issuingkeyPair
                                            // E('issuing_address').innerText = fAddr((chain=='stellar')?issuingkeyPair.publicKey():
                                            // issuingkeyPair.address, 6)
                                        }
                                    }
                                    else {
                                        E('createodao').disabled = false
                                        talk(`Unable to create ${CHAIN} file<br>Something went wrong`, "fail", id)
                                        stopTalking(4, id)
                                        //change the issuing wallet address, to cover of create dao fail
                                        issuingkeyPair = (chain == 'stellar')? StellarSdk.Keypair.random() : issuingkeyPair
                                        // E('issuing_address').innerText = fAddr((chain=='stellar')?issuingkeyPair.publicKey():
                                        // issuingkeyPair.address, 6)
                                    }
                                })
                            }
                            else {
                                 if(turl === "exists") {
                                    E('createodao').disabled = false
                                    talk("Dao with this name already exists<br>Please change the name", "fail", id)
                                }
                                else {
                                    E('createodao').disabled = false
                                    talk(`Unable to create ${CHAIN} file<br>Something went wrong`, "fail", id)
                                }
                                stopTalking(4, id)
                            }
                        })
                    }
                    else {
                        E('createodao').disabled = false
                        assetAddress = null
                        talk("This DAO already exists<br>Change the asset code and try again", "fail", id)
                        stopTalking(4, id)
                    }
                     
                }
                else {
                    E('createodao').disabled = false
                    assetAddress = null
                    if(res.msg != undefined){talk("This asset has already being  created", "fail", id)}
                    else {talk("Unable to create Asset<br>Something went wrong", "fail", id)}
                    stopTalking(4, id)
                }
            }
            else {
                talk("Unable to fund issuing address<br>" + res.msg, "fail", id)
                stopTalking(4, id)
                E('createodao').disabled = false
            }
        }
        else {
            E('createodao').disabled = false
            const msg  = "Invalid characters(\") present in one of the fields.<br> Please remove it and try again";
            stopTalking(4, talk(msg, "fail"))
        }
    }
    else {
        E('createodao').disabled = false
        stopTalking(3, talk("Empty field present", "fail"))
    }
}
//upload asset image
const uploadAssetImg = (assetName, domain, callback) => {
    const formData = new FormData(); // Create a FormData object
    // Add the selected file to the FormData object
    formData.append('file', upload_file);
    formData.append('cover', cover_upload);
    // Create an HTTP request
    const xhr = new XMLHttpRequest();
    const url = API_URL +"upload&name=" + assetName + ".png" + "&domain=" + domain
    // Define the server endpoint (PHP file)
    xhr.open('POST', url, true);
    // Set up an event listener to handle the response
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) { 
          if (xhr.responseText == "1") {callback(true,`https://${TOML_URL}/.well-known/images/` + assetName + ".png")}else{callback(false)}
      }
      else if (xhr.readyState === 4 && xhr.status !== 200) {
          callback(false)
      }
    };
   // Send the FormData object with the image
    xhr.send(formData);
}
const uploadTomlFile = (asset, name, dao, callback) => {
    const xhr = new XMLHttpRequest();
    const url = API_URL + "toml&asset=" + asset + "&value=" + name + "&chain=" + CHAIN + "&dao=" + dao
    // Define the server endpoint (PHP file)
    xhr.open('GET', url, true);
    // Set up an event listener to handle the response
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {  
          if (xhr.responseText == "1") {
            callback(true, "http://" + name + "." + TOML_URL + `/.well-known/${(CHAIN=='stellar')?'stellar.toml':'xrp-ledger.toml'}`)
          }
          else if(xhr.responseText == "0"){
            callback(true, "http://" + name + "." + TOML_URL + `/.well-known/${(CHAIN=='stellar')?'stellar.toml':'xrp-ledger.toml'}`)
          }
          else {callback(false)}
      }
      else if (xhr.readyState === 4 && xhr.status !== 200) {
          callback(false)
      }
    };
   // Send the FormData object with the image
    xhr.send(); 
}
const createAssetToml = (asset) => {
    if(chain == 'stellar'){
        return `ACCOUNTS=["${asset.distributing}"]\n\n[DOCUMENTATION]\nORG_NAME="${asset.name}"\nORG_URL="http://${asset.domain}.testing.lumosdao.io"\nORG_DESCRIPTION="${asset.about}"\nORG_LOGO="${asset.image}"\nORG_TWITTER=""\nORG_INSTAGRAM=""\nORG_DISCORD=""\nORG_TELEGRAM=""\nORG_REDDIT=""\nORG_SUPPORT_EMAIL=""\n\n[[CURRENCIES]]\ncode="${asset.code}"\nissuer="${asset.issuer}"\ndisplay_decimals=1\nname="${asset.name}"\ndesc="${asset.about}"\nstatus="live"\nimage="${asset.image}"`
    }
    else {
        return `# This file was auto generated in LumosDao
[METADATA]
modified = ${new Date().toISOString()}

[[ACCOUNTS]]
address = "${asset.issuer}"
type="issuer"
desc = "Lumos Dao asset issuer"

[[ACCOUNTS]]
address = "${asset.distributing}"
type="distributing"
desc = "Lumos Dao asset distributing"
        
[DOCUMENTATION]
ORG_NAME="${asset.name}"
ORG_URL="http://${asset.domain}.testing.lumosdao.io"
ORG_DESCRIPTION="${asset.about}"\nORG_LOGO="${asset.image}"
ORG_TWITTER=""
ORG_INSTAGRAM=""
ORG_DISCORD=""
ORG_TELEGRAM=""
ORG_REDDIT=""

[[CURRENCIES]]
code="${asset.code}"
issuer="${asset.issuer}"
icon="${asset.image}"
network="testnet"
display_decimals=6`
    }
} 
  /** Hooks */
  useEffect(() => {
    window.E = (id) => document.getElementById(id)
    window.walletAddress = localStorage.getItem('selectedWallet') || ""
    chain = window.CHAIN = (localStorage.getItem('LUMOS_CHAIN') || "").toLowerCase()
    //set the issuing address
    issuingkeyPair = (CHAIN == 'stellar')? StellarSdk.Keypair.random() : xrp.Wallet.generate()
    if(CHAIN == 'stellar'){
      setMinTxFee('3 XLM')
    }
    else if(chain == 'xrp'){
      setMinTxFee('11 XRP')
    }
    //configure image uploads   
    if(E('asset_o_upload_msg')){  
      // //validate the image upload
      validateImageUpload('asset_o_upload', 'asset_display_image', 2, (e, url) => { 
          if(e != null) {
              //optimize the image
              optimizeImg(url, 0.9, 400, 400).then((img) => { 
                  //update upload file
                  upload_file = img
                  setUploadedImg(true)
              })
              
          }
      })
      validateImageUpload('cover_o_photo', 'asset_cover_image', 2, async (e, url) => {
          if(e != null) {
              //optimize the image
              optimizeImg(url, 0.9, 1584, 396).then((img) => {
                //update upload file
                cover_upload = img
                setCoverImg(true)
              })
              
          }
      })
      //limit the asset code string
      E('asset_o_code').oninput = (e) => {
          const value = E('asset_o_code').value.trim().replace(/ /g,"")
          if(CHAIN == 'xrp') {
              if(value.length > 3) {
                  E('asset_o_code').value = value.substring(0, 3)
              }
          }
      }
      //display the issuing pair
      // E('issuing_address').innerText = fAddr((chain=='stellar')?issuingkeyPair.publicKey():
      // issuingkeyPair.address, 6)
      // E('distributing_address').innerText = fAddr(walletAddress, 6)
    }
  }, [])

  useEffect(() => {
    projectType = localStorage.getItem('projectType');
  },[])

  function createDao(){
    setCreateDaoModal(true);
  }

  return (
    <div className='helvetica-font'>
      {projectType === "Existing token" ?
        (
          <div className='bg-white mt-[1rem] lg:mx-[7rem] md:mx-[4rem] mx-[1rem]'>
            <div className="mt-[1rem] lg:w-[500px] md:w-[75%] w-[95%] bg-white text-center mx-auto">
                <p className='pt-[6rem] font-[500] lg:text-[22px] text-[18px]'>Describe your DAO</p>
                <p className='text-[#52606D] md:text-[15px] text-[12px] mb-[4rem] md:leading-[28px]'>Name and define your DAO so new contributors know they've come to the right place. This information is displayed on the DAO Explore page and can be changed with a vote.</p>
                <div className='flex gap-2 justify-center w-full md:text-[14px] text-[12px]'>
                  <div className='border-b border-[#BEBEBE] pb-[3rem] w-full'>
                      <div className='flex flex-col sm:flex-row items-center gap-5 text-left w-full'>
                        <div className='w-full'>
                          <p className='text-[#344054] mb-1'>Asset Code</p>
                          <input id='assetCode' type="text" placeholder='LUMOS' className='border border-[#D0D5DD] w-full px-3 py-[10px] rounded-[8px]'/>
                        </div>
                        <div className='w-full'>
                          <p className='text-[#344054] mb-1'>Asset Toml URL.</p>
                          <input id='assetUrl' type="text" placeholder='https://asset-domain/.well-known/.toml' className='border border-[#D0D5DD] w-full px-3 py-[10px] rounded-[8px]'/>
                        </div>
                      </div>
                      <button onClick={() => {searchForAsset()}} id='assetButton' className='bg-[#FF7B1B] md:w-[350px] w-[100%] mx-auto py-[10px] rounded-[4px] text-white mt-[3rem]'>Search</button>
                  </div>
                </div>
                <div  id='asset_s'  className='w-[100%] mx-auto text-left mt-[2rem] pb-[4rem] md:text-[14px] text-[12px]' style={{display:'none'}}>
                  <p className='text-[#344054] mb-1'>DAO Name</p>
                  <input id='dao_name' type="text" placeholder='USDC' className='border border-[#D0D5DD] w-[100%] px-3 py-[10px] rounded-[8px]'/>
                  <p id='asset_s_msg' className='text-[#05C12E]'>This asset can be used</p>

                  <p className='text-[#344054] mb-1 mt-[1.5rem]'>DAO Description</p>
                  <textarea id='dao_about' className='border border-[#D0D5DD] text-[#667085] resize-none w-full rounded-[8px] p-3' rows="5" placeholder='Enter a description...'></textarea>

                  <div className='flex gap-5 justify-between mt-[1.5rem] md:text-[14px] text-[12px]'>
                    <div>
                      <p className='font-[500]'>Project Logo</p>
                      <img id='asset_s_img' src="" alt="" className='w-[70px] h-[70px] mt-2' />
                    </div>
                    <div className='font-[500]'>
                      <p>Project</p>
                      <p className='my-2'>Ticker</p>
                      <p>Home Domain</p>
                    </div>   
                    <div>
                      <p id='asset_s_name' className='my-2'>USDC</p>
                      <p id='asset_s_code' className='my-2'>USDC</p>
                      <p id='asset_s_domain'>https://www.centre.io</p>
                    </div>
                  </div>
                  <button id='createButton' onClick={($event) => {createTheDao($event)}}className='bg-[#FF7B1B] text-white w-[100%] mx-auto mt-[3.5rem] block py-[12px] rounded-[4px]'>Create DAO</button>
                </div>
                {/* <Link className='bg-[#FF7B1B] text-white w-[500px] mx-auto mt-[20rem] block py-[12px] rounded-[4px]' href="/create-dao/choose-blockchain">Proceed</Link> */}
            </div>
          </div>
        )
        :
        (
          <div className='bg-white mt-[1rem] lg:mx-[7rem] md:mx-[4rem] mx-[1rem]'>
            <div className="mt-[1rem] lg:w-[500px] md:w-[75%] w-[95%] mx-auto text-center pb-[4rem] bg-white">
                <p className='pt-[6rem] font-[500] lg:text-[22px] text-[18px]'>Describe your DAO</p>
                <p className='text-[#52606D] md:text-[15px] text-[12px] mx-auto mt-[14px] mb-[0.5rem] md:leading-[28px]'>Name and define your DAO so new contributors know they've come to the right place. This information is displayed on the DAO Explore page and can be changed with a vote.</p>
                <p className='text-[#52606D] md:text-[15px] text-[12px] mx-auto mb-[4rem] md:leading-[28px]'>This page will also help you create a fresh token automatically for your project.</p>
                <div className='flex gap-2 justify-center w-full md:text-[14px] text-[12px]'>
                  <div className='pb-[2rem] w-full'>
                    <div className='w-full mb-[2rem] text-left'>
                      <p className='text-[#344054] mb-1'>DAO Name</p>
                      <input  id='dao_o_name' type="text" placeholder='LUMOS' className='border border-[#D0D5DD] w-[100%] px-3 py-[10px] rounded-[8px]'/>
                    </div>
                      <div className='flex flex-col sm:flex-row items-center gap-5 text-left w-full'>
                        <div className='w-full'>
                          <p className='text-[#344054] mb-1'>Asset Code</p>
                          <input id='asset_o_code' type="text" placeholder='LUMOS' className='border border-[#D0D5DD] w-[100%] px-3 py-[10px] rounded-[8px]'/>
                        </div>
                        <div className='w-full'>
                          <p className='text-[#344054] mb-1'>Asset Supply</p>
                          <input id='asset_o_supply' type="text" placeholder='100000' className='border border-[#D0D5DD] w-[100%] px-3 py-[10px] rounded-[8px]'/>
                        </div>
                      </div>
                      <div className='bg-[#FFF8EB] border border-[#FF7B1B] rounded-[8px] w-full py-3 px-4 text-left text-[#FF7B1B] mt-[2.5rem]'>
                        <p>Note:</p>
                        <p className='text-[13px]'>Deposit min {MIN_TX_FEE} in your wallets to cover the transaction fees </p>
                      </div>
                  </div>
                </div>

                <div className='w-[100%] mx-auto text-left md:text-[14px] text-[12px]'>
                  <p className='text-[#344054]'>Upload Logo</p>
                  <p className='text-[#667085] mb-5'>This will be displayed on your profile.</p>
                  <img id='asset_display_image' className='h-[150px] absolute left-[50%] right-[50%] translate-x-[-50%] translate-y-[10%]' alt="" />
                  <button onClick={() => {document.getElementById('asset_o_upload').click()}} className='rounded-[8px] w-full h-[180px] flex flex-col items-center justify-center' style={{border:'2px solid #00000014'}}>
                    {
                        uploadedImg !== true &&
                        <>
                            <img id='asset_o_upload_msg' src="/images/upload.svg"  style={{maxWidth:'100%', maxHeight:'100%'}}  alt="" />
                            <p className='text-[#667085]'><span className='text-[#6941C6]'>Browse files</span> or drag and drop</p>
                            <p className='text-[#667085] text-[12px]'>SVG, PNG, JPG or GIF (max. 800x400px)</p>
                        </>
                    }
                  </button>
                  <input id='asset_o_upload' type="file" style={{marginTop:'40px', display:'none'}} />
                  <div style={{ height:'100%', whiteSpace:'nowrap',overflow:'hidden', textOverflow:'ellipsis'}} />
                </div>

                <div className='w-[100%] mx-auto text-left mt-[2rem] pb-[2rem] md:text-[14px] text-[12px]'>
                  <p className='text-[#344054] mb-1 mt-[1.5rem]'>DAO Description</p>
                  <textarea id='dao_o_about' className='border border-[#D0D5DD] text-[#667085] resize-none w-full rounded-[8px] p-3' rows="5" placeholder='Enter a description...'></textarea>
                </div>

                <div className='w-[100%] mx-auto text-left md:text-[14px] text-[12px]'>
                  <p className='text-[#344054]'>Cover photo</p>
                  <p className='text-[#667085] mb-5'>This will be displayed on your profile.</p>
                  <img id='asset_cover_image' className='h-[150px] absolute left-[50%] right-[50%] translate-x-[-50%] translate-y-[10%]' alt="" />
                  <button onClick={() => {document.getElementById('cover_o_photo').click()}} className='rounded-[8px] w-full h-[180px] flex flex-col items-center justify-center' style={{border:'2px solid #00000014'}}>
                    {
                        coverImg !== true &&
                        <>
                            <img id='cover_o_photo_msg' src="/images/upload.svg" alt="" style={{maxWidth:'100%', maxHeight:'100%'}} />
                            <p className='text-[#667085]'><span className='text-[#6941C6]'>Browse files</span> or drag and drop</p>
                            <p className='text-[#667085] text-[12px]'>SVG, PNG, JPG or GIF (max. 800x400px)</p>
                        </>
                    }
                  </button>
                  <input type="file" id='cover_o_photo' style={{marginTop:'40px', display:'none'}} />
                  <div style={{ height:'100%', whiteSpace:'nowrap',overflow:'hidden', textOverflow:'ellipsis'}} />
                  <button onClick={($event) => {createODao($event)}} id='createodao' className='bg-[#FF7B1B] text-white w-[100%] mx-auto mt-[3.5rem] block py-[12px] rounded-[4px]'>Create DAO</button>
                </div>
                {/* <Link className='bg-[#FF7B1B] text-white w-[500px] mx-auto mt-[20rem] block py-[12px] rounded-[4px]' href="/create-dao/choose-blockchain">Proceed</Link> */}
            </div>
          </div>
        )
        
      }

      {
        createDaoModal && (
          <div>
            <div className="h-full w-full fixed top-0 left-0 z-[999]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setCreateDaoModal(false)}></div>
            <div className="bg-white md:w-[450px] w-[92%] px-2 flex flex-col items-center justify-center fixed top-[48%] left-[50%] pb-[3rem] rounded-[8px] z-[1000] login-modal" style={{ transform: "translate(-50%, -50%)" }}>
                <div className='flex items-center justify-between pt-6 px-3 w-full'>
                    <p className='text-[15px] md:text-[20px]'></p>
                    <IoCloseOutline onClick={() => setCreateDaoModal(false)} className='text-gray-500 md:text-[25px] text-[20px] cursor-pointer'/>
                </div>
                <div className='text-center mb-10 flex items-center flex-col'>
                  <p className='text-[15px] mt-5 mb-2'>You’ve successfully created your DAO</p>
                  <img src="/images/success.svg" alt="" />
                </div>
                <p className='text-[12px] mb-3'>Copy your DAO Link and Share:</p>
                <div className='flex md:gap-7 gap-4 items-center justify-center'>
                  <img src="/images/link.svg" alt="" />
                  <img src="/images/fb.svg" alt="" />
                  <img src="/images/telegram.svg" alt="" />
                  <img src="/images/insta.svg" alt="" />
                  <img src="/images/wp.svg" alt="" />
                  <img src="/images/tweeter.svg" alt="" />
                  <img src="/images/linkedin.svg" alt="" />
                </div>
              </div>
            </div>
        )
      }
    </div>
  )
}

export default page