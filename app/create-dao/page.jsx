'use client'
import React, { useEffect, useMemo } from 'react'
import { BsUpload } from "react-icons/bs";
import * as StellarSdk from '@stellar/stellar-sdk'; 
import { createDaos, createTrustlineQuiet, deployStellarAsset, fundIssuer, isDao, isSafeToml, lockIssuerQuietly, mintToken, optimizeImg, validateImageUpload, verifyAsset, wrapAsset } from '../core/core';
import { fAddr, isSubDomainExists, readAssetToml } from '../core/getter';
import { API_URL, S, TOML_URL } from '../data/constant';
import { stopTalking, talk } from '../components/alert/swal'; 

let assetAddress = null; 
let issueAddress = "";
let approveWallets = []
let assetUrl = null
let upload_file = null
let cover_upload = null;
let issuingkeyPair = StellarSdk.Keypair.random() 
let daoName = ""
const CreateDao = () => { 
    
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
            const tomlDetails = await readAssetToml(assetToml)
            if(tomlDetails !== false) {
                let flg = false
                //display information
                if(tomlDetails.CURRENCIES){
                    for(let i=0; i<tomlDetails.CURRENCIES.length;i++) {
                        const cur = tomlDetails.CURRENCIES[i]
                        if(cur.code == assetCode) {
                            //have found our code
                            E('asset_s_name').innerHTML = cur.name || ""
                            E('dao_name').value = cur.name || ""
                            E('asset_s_code').innerHTML = cur.code || ""
                            E('asset_s_domain').innerHTML = (tomlDetails.DOCUMENTATION) ? tomlDetails.DOCUMENTATION.ORG_URL : ""
                            E('dao_about').value = cur.desc || ""
                            E('asset_s_img').src = cur.image || "{{ asset('images/topright.png') }}"
                            if(!(cur.issuer == undefined || cur.issuer == "")) {
                                (tomlDetails.ACCOUNTS == undefined) ? tomlDetails.ACCOUNTS = [] :  "";
                                if(cur.issuer == walletAddress || tomlDetails.ACCOUNTS.includes(walletAddress) || true) {
                                    issueAddress = cur.issuer
                                    approveWallets = tomlDetails.ACCOUNTS
                                    assetUrl = assetToml
                                }
                                else {
                                    stopTalking(4, talk("Your wallet address is not authorise to use this Asset", "fail"))
                                    flg = false
                                    stopTalking(1, id)
                                     E('assetButton').disabled = false
                                     return false;
                                }
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
            console.log(res)
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
        let userAddress = issuingkeyPair.publicKey()
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
                talk(`Funding the issuing wallet ${fAddr(issuingkeyPair.publicKey(), 5)}...`, 'norm', id)
                let res = await fundIssuer({
                    address:issuingkeyPair.publicKey()
                })
                if(res.status !== false){
                    talk(`Funded the issuing wallet`, 'good', id)
                    await new Promise((resolve) => setTimeout(resolve, 500));
                    talk("Creating Asset for DAO...", 'norm', id)
                    //make wallet address the issuing keypair
                    console.log(userAddress)
                    res = await deployStellarAsset(new S.Asset(aCode, userAddress), issuingkeyPair)
                    if(res.status === false) {
                        //unwrapped token
                        talk("Unable to create Asset<br>" + res.msg, "fail", id)
                        stopTalking(4, id)
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
                            talk("Creating the Stellar toml file", "norm", id)
                            uploadTomlFile(encodeURIComponent(createAssetToml({
                                domain:tName,
                                name:name,
                                code:aCode,
                                about:about,
                                issuer:userAddress,
                                distributing:walletAddress,
                                image:window.location.protocol + `//${TOML_URL}/.well-known/images/` + (aCode + userAddress) + ".png"
                            })), tName, async (res, turl) => {
                                if(res == true) {
                                    //upload the file
                                    uploadAssetImg(aCode + userAddress, tName, async (res, url) => {
                                        if(res == true) {
                                            //time to mint the asset
                                            talk("Created the Stellar toml file", "good", id)
                                            E('asset_o_toml').innerHTML = turl
                                            if(res == true){
                                                //talk("Domain set successfully", "good", id)
                                                await new Promise((resolve) => setTimeout(resolve, 500));
                                                talk("Minting suply", "norm", id)
                                                res = await createTrustlineQuiet(aCode, issuingkeyPair.publicKey(), walletAddress)
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
                                                        //time to extend the asset life
                                                        await new Promise((resolve) => setTimeout(resolve, 500));
                                                        //talk("Extending Asset life", "norm", id)
                                                        //await bumpContractInstance(assetAddress)
                                                        //verify the dao, then create the dao 
                                                        talk("locking issuing wallet", "norm", id)
                                                        //first transfer the balance before locking it
                                                        res = await lockIssuerQuietly({
                                                            issuer:userAddress,
                                                        }, issuingkeyPair)
                                                        if(res.status !== false) {
                                                            talk("locked issuing wallet", "good", id)
                                                            //change the issuing wallet address, to cover of create dao fail
                                                            issuingkeyPair = StellarSdk.Keypair.random()
                                                            E('issuing_address').innerText = fAddr(issuingkeyPair.publicKey(), 4)
                                                            talk("Creating the DAO", "norm", id)
                                                            res = await createDaos({
                                                                domain:tName,
                                                                name:name,
                                                                about:about,
                                                                token:assetAddress,
                                                                url:turl,
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
                                                                talk("This asset has already being used", "fail", id)
                                                                stopTalking(4, id)
                                                                //change the issuing wallet address, to cover of create dao fail
                                                                issuingkeyPair = StellarSdk.Keypair.random()
                                                            }
                                                        }
                                                        else {
                                                            talk("Unable to lock issuing wallet<br>" + res.msg, "fail", id)
                                                            E('createodao').disabled = false
                                                            stopTalking(4, id)
                                                            //change the issuing wallet address, to cover of create dao fail
                                                            issuingkeyPair = StellarSdk.Keypair.random()
                                                            
                                                        }
                                                    }
                                                }
                                                else {
                                                    E('createodao').disabled = false
                                                    talk("Unable to mint supply <br>" + res.msg, "fail", id)
                                                    stopTalking(4, id)
                                                    //change the issuing wallet address, to cover of create dao fail
                                                    issuingkeyPair = StellarSdk.Keypair.random()
                                                }
                                            }
                                            else {
                                                E('createodao').disabled = false
                                                talk("Unable to set domain<br>Something went wrong", "fail", id)
                                                stopTalking(4, id)
                                                //change the issuing wallet address, to cover of create dao fail
                                                issuingkeyPair = StellarSdk.Keypair.random()
                                                            
                                            }
                                        }
                                        else {
                                            E('createodao').disabled = false
                                            talk("Unable to create Stellar file<br>Something went wrong", "fail", id)
                                            stopTalking(4, id)
                                            //change the issuing wallet address, to cover of create dao fail
                                            issuingkeyPair = StellarSdk.Keypair.random()
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
                                        talk("Unable to create Stellar file<br>Something went wrong", "fail", id)
                                    }
                                    stopTalking(4, id)
                                }
                            })
                        }
                        else {
                            E('createodao').disabled = false
                            assetAddress = null
                            talk("This DAO already exists", "fail", id)
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
    const uploadTomlFile = (asset, name, callback) => {
        const xhr = new XMLHttpRequest();
        const url = API_URL + "toml&asset=" + asset + "&value=" + name
        // Define the server endpoint (PHP file)
        xhr.open('GET', url, true);
        // Set up an event listener to handle the response
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) { // console.log(xhr.responseText)
              if (xhr.responseText == "1") {callback(true, "http://" + name + "." + TOML_URL + "/.well-known/stellar.toml")}
              else if(xhr.responseText == "0"){callback(true, "http://" + name + "." + TOML_URL + "/.well-known/stellar.toml")}
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
        return `ACCOUNTS=["${asset.distributing}"]\n\n[DOCUMENTATION]\nORG_NAME="${asset.name}"\nORG_URL="http://${asset.domain}.lumosdao.io"\nORG_DESCRIPTION="${asset.about}"\nORG_LOGO="${asset.image}"\nORG_TWITTER=""\nORG_INSTAGRAM=""\nORG_DISCORD=""\nORG_TELEGRAM=""\nORG_REDDIT=""\nORG_SUPPORT_EMAIL=""\n\n[[CURRENCIES]]\ncode="${asset.code}"\nissuer="${asset.issuer}"\ndisplay_decimals=1\nname="${asset.name}"\ndesc="${asset.about}"\nstatus="live"\nimage="${asset.image}"`
    } 
  
    /** Hooks */
  useEffect(() => {
        window.E = (id) => document.getElementById(id)     
  
        // //validate the image upload
        validateImageUpload('asset_o_upload', 'asset_o_upload_msg', 1, (e, url) => { 
            if(e != null) {
                //optimize the image
                optimizeImg(url, 0.9, 400, 400).then((img) => { 
                    //update upload file
                    upload_file = img
                })
                
            }
        })
        validateImageUpload('cover_o_photo', 'cover_o_photo_msg', 1, async (e, url) => {
            if(e != null) {
                //optimize the image
                optimizeImg(url, 0.9, 1584, 396).then((img) => {
                   //update upload file
                   cover_upload = img
                })
                
            }
        })
        //set the issuing address
        E('issuing_address').innerText = fAddr(issuingkeyPair.publicKey(), 4)
  }, [])

  return (
    <div className='px-[3rem] my-[80px]'>
        <div>
            <p className='font-[600] text-[24px] mb-1'>1.Create DAO for an existing Steller project</p>
            <p className='my-3'>Easily create a dedicated DAO for your existing token on Stellar. Build a hub for collaborative decision-making and project development.</p>
            <p className='bg-red-100 border border-red-300 p-2 text-[13px] rounded-[5px] text-red-700'>Please include the stellar wallet address from which you intend to create the DAO in the token's TOML file - <span className='underline text-blue-500 cursor-pointer'>Learn now</span> </p>
            <div className='flex items-end mt-7 bg-white shadow border pt-10 pb-5 px-4 justify-between gap-[2rem] rounded-[10px]'>
                <div className='w-full'>
                    <p className='mb-3'>Asset Code</p>
                    <input id='assetCode' type="text" placeholder='LUMOS' className='bg-transparent outline-none p-3 border rounded-[8px] w-full'/>
                </div>
                <div className='w-full'>
                    <p className='mb-3'>Asset Toml Url</p>
                    <input id='assetUrl' type="text" placeholder='https://asset-domain/.well-known/stellar.toml' className='bg-transparent outline-none p-3 border rounded-[8px] w-full'/>
                </div>
                <div className='w-full'>
                    <button onClick={() => {searchForAsset()}} id='assetButton' className='bg-[#DC6B19] w-[60%] py-[10px] rounded-[6px] text-white'>Search</button>
                </div>
            </div>
        </div>

        <div id='asset_s'  className='bg-white p-5 mt-5 rounded-[10px]' style={{display:'none'}}>
            <p id='asset_s_msg' className='text-center text-green-700'>This asset can be used</p>
            <div className='w-full'>
                <p className='mb-3'>DAO Name</p>
                <input id='dao_name' type="text" className='bg-[#EFF2F6] outline-none p-3 border rounded-[8px] w-full'/>
            </div>
            <div className='w-full my-7'>
                <p className='mb-3'>DAO Description</p>
                <input id='dao_about' type="text" className='bg-[#EFF2F6] outline-none p-3 border rounded-[8px] w-full'/>
            </div>
            <div className='flex items-start md:items-center gap-[2rem] flex-col md:flex-row justify-between'>
                <table>
                    <tbody>
                        <tr>
                            <td className='font-[500]'>Project</td>
                            <td id='asset_s_name' className='pl-[4rem]'>USD Coin</td>
                        </tr>
                        <tr>
                            <td className='py-5 '>Ticker</td>
                            <td id='asset_s_code' className='pl-[4rem]'>Ticker</td>
                        </tr>
                        <tr>
                            <td className='font-[500]'>Home domain</td>
                            <td id='asset_s_domain' className='pl-[4rem]'>https://www.centre.io</td>
                        </tr>
                    </tbody>
                </table>
                <div className='bg-[#EFF2F6] py-5 pr-[5rem] pl-[1.5rem] rounded-[10px] w-full md:w-auto'>
                    <p className='font-[500] mb-2 text-[18px]'>Project Logo</p>
                    <img id='asset_s_img'  width="50px" height='50px' alt="Project logo" className='mx-auto' />
                </div>
            </div>
            <button id='createButton' onClick={($event) => {createTheDao($event)}} className='bg-[#DC6B19] mb-5 md:w-[20%] w-[70%] block mt-10 rounded-[8px] font-[500] mx-auto text-white py-[10px]'>Create DAO</button>
        </div>

        <div>
            <p className='font-[600] text-[24px] mb-1 mt-[5rem]'>2.Create DAO for an new Steller project</p>
            <p className='my-3'>Start fresh by generating a new token on LumosDAO and instantly create its DAO. Foster community engagement, discussions, and decisions for your unique concept.</p>
            <div className='mt-7'>
                <p className='font-[600] text-[18px] mb-1'>DAO Details:</p>
                <div className='flex flex-col bg-white shadow border pt-10 pb-5 px-4 justify-between gap-[1.5rem] rounded-[10px]'>
                    <div className='flex'>
                        <p className='w-[15%] font-[500]'>Note:</p>
                        <p className='w-3/4'>Deposit min 3 XLM in your wallets to cover the transaction fees</p>
                    </div>
                    <div className='flex'>
                        <p className='w-[15%] font-[500]'>Stellar Toml Url:</p>
                        <p id='asset_o_toml' className='w-3/4'></p>
                    </div>
                    <div className='flex'>
                        <p className='w-[15%] font-[500]'>Issuing address:</p>
                        <p id='issuing_address' className='w-3/4 font-[500] text-blue-400'></p>
                    </div>
                    <div className='flex'>
                        <p className='w-[15%] font-[500]'>Distributing address:</p>
                        <p className='w-3/4 font-[500] text-blue-400'></p>
                    </div>
                    <div className='grid grid-cols-4 gap-5'>
                        <div className=' w-full'>
                            <p className='mb-3 font-[500]'>Add Logo:</p>
                            <div className='cursor-pointer relative h-full border rounded-[8px] flex items-center flex-col justify-center'>
                                <input type="file" id='asset_o_upload' className='absolute bg-transparent opacity-0 h-full outline-none p-3 border rounded-[8px] w-full'/>
                                <span id='asset_o_upload_msg'>Browse computer</span>
                                <BsUpload className='text-[24px]'/>
                            </div>
                        </div>
                        <div className='w-full'>
                            <p className='mb-3 font-[500]'>DAO name:</p>
                            <input id='dao_o_name' type="text" placeholder='' className='bg-transparent outline-none p-3 border rounded-[8px] w-full'/>
                        </div>
                        <div className='w-full'>
                            <p className='mb-3 font-[500]'>Asset Code:</p>
                            <input id='asset_o_code' type="text" placeholder='LUMOS' className='bg-transparent outline-none p-3 border rounded-[8px] w-full'/>
                        </div>
                        <div className='w-full'>
                            <p className='mb-3 font-[500]'>Supply:</p>
                            <input id='asset_o_supply' type="text" placeholder='000' className='bg-transparent outline-none p-3 border rounded-[8px] w-full'/>
                        </div>
                    </div>
                    <div className='mt-[3rem] w-full'>
                        <p className='mb-3 font-[500]'>DAO Description:</p>
                        <textarea id='dao_o_about' rows="4" className='border resize-none w-full rounded-[8px] p-3'></textarea>
                    </div>
                    <div className=' w-full'>
                        <p className='mb-3 font-[500]'>Add Cover Photo:</p>
                        <div className='font-[500] cursor-pointer py-6 relative h-full border rounded-[8px] flex items-center flex-col justify-center'>
                            <input type="file" id='cover_o_photo' className='absolute bg-transparent opacity-0 h-full outline-none p-3 border rounded-[8px] w-full'/>
                            <span id='cover_o_photo_msg'>Add Cover Photo</span>
                            <BsUpload className='text-[24px]'/>
                        </div>
                        <p className='text-end mt-2 text-[14px]'>The banner image should have dimensions of 1584×396 Pixels</p>
                    </div>
                    <button onClick={($event) => {createODao($event)}} id='createodao' className='bg-[#DC6B19] mb-5 w-[20%] rounded-[8px] font-[500] mx-auto text-white py-[10px]'>Create DAO</button>
                </div>
            </div>
        </div>
    </div>
  )
}

export default CreateDao