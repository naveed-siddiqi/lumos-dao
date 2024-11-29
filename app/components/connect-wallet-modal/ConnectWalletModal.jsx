import Image from 'next/image'
import React, { useState } from 'react'
import { FiChevronDown } from "react-icons/fi";
import Alert from '../alert/Alert';
import { useRouter } from 'next/navigation';
import { GoChevronRight } from "react-icons/go";
import {
    isConnected,
    requestAccess
} from "@stellar/freighter-api";
import { Xumm } from "xumm"
import lobstr from "@lobstrco/signer-extension-api";
import {isInstalled, getAddress} from "@gemwallet/api"
import {alert} from '../alert/swal'
import { getUserInfo } from '@/app/core/getter';
import UniversalProvider from '@walletconnect/universal-provider' 
import SignClient from '@walletconnect/sign-client'
import QRCode from 'qrcode';
import { walletConnectConfig, walletConnectNetwork } from '@/app/data/constant';
import { IoCloseOutline } from 'react-icons/io5';
import { RiLoader5Fill } from 'react-icons/ri';

 
const ConnectWalletModal = ({setConnectWallet}) => {

    const [msg, setMsg] = useState("")
    const [alertType, setAlertType] = useState("")
    const [loader, setLoader] = useState(false)
    const [qrModal, setQrModal] = useState(false)
    const [walletUri, setWalletUri] = useState("")
    const [walletLoading, setWalletLoading] = useState(false)
    const [selectedNetwork, setSelectedNetwork] = useState('')
    const router = useRouter();

    const availableNetworks = [
        {
            name: 'Stellar',
            icon: '/images/stellar-network.svg',
            commingSoon: false,
        },
        {
            name: 'Ripple',
            icon: '/images/xrp-network.svg',
            commingSoon: false,
        },
        {
            name: 'Solana',
            icon: '/images/solana-network.svg',
            commingSoon: true,
        },
        {
            name: 'Ton',
            icon: '/images/ton-network.svg',
            commingSoon: true,
        },
        {
            name: 'Ethereum',
            icon: '/images/eth-network.svg',
            commingSoon: true,
        },
        {
            name: 'Avalanche',
            icon: '/images/eth-network.svg',
            commingSoon: true,
        },
        {
            name: 'Polygon',
            icon: '/images/polygon-network.svg',
            commingSoon: true,
        }
    ]

    const stellarWallets = [
        {
            name: 'Lobstr',
            icon: '/images/lobstr.jpg',
            url: 'https://lobstr.io/',
        },
        {
            name: 'Freighter',
            icon: '/images/frighter.png',
            url: 'https://freighter.app/',
        },
        {
            name: 'Wallet Connect',
            icon: '/images/walletConnectLogo.jpg',
            url: 'https://walletconnect.com//',
        }
    ]

    const xrpWallets = [
        {
            name: 'Gem',
            icon: '/images/gem.svg',
            url: 'https://freighter.app/',
        },
        {
            name: 'Xaman',
            icon: '/images/xaman.png',
            url: 'https://xaman.app/',
        }
    ]
   
    const xrpMobileWallets = [
        {
            name: 'Xaman',
            icon: '/images/xaman.png',
            url: 'https://xaman.app/',
        }
    ]

    const stellarMobileWallets = [
        {
            name: 'Wallet Connect',
            icon: '/images/walletConnectLogo.jpg',
            url: 'https://walletconnect.com//',
        }
    ]

    const [selectedWallet, setSelectedWallet] = useState("")
    const [dropdownOpen, setDropdownOpen] = useState(false)
    function fixedEncodeURIComponent(str) {
        return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
            return '%' + c.charCodeAt(0).toString(16);
        });
    }
    async function connectWallet(selectedWallet) {
        console.log(selectedWallet)
        if(!selectedWallet){
            setMsg("Please select a wallet.");
            setAlertType("warning");
            return;
        }else{
            setLoader(true)
            //for frieghter
            try{
                if(selectedWallet.name.toLowerCase() == 'freighter'){
                    //check if freighter is installed
                    //we are calling it twice, because its usually fails the first time, its a freigther bug
                    await isConnected()
                    const isInstalled = await isConnected()
                    if(isInstalled) {  
                        //we are calling it twice, because its usually fails the first time, its a freigther bug
                        await requestAccess() 
                        const userAddress = await requestAccess()
                        if(userAddress){
                            JSON.stringify(localStorage.setItem('selectedWallet', userAddress))
                            JSON.stringify(localStorage.setItem('LUMOS_WALLET', 'freighter'))
                            JSON.stringify(localStorage.setItem('LUMOS_CHAIN', 'stellar'))
                            await auth2Fa(userAddress)
                        }
                        else {
                            alert('User denied access','Wallet Connect Error')
                        }
                    }   
                    else {
                        //redirect to freighter website
                        alert('Freighter wallet app is not installed in your browser.','Wallet Info','warn')
                        //window.open(selectedWallet.url, '_blank')
                    }    
                }
                else if(selectedWallet.name.toLowerCase() == 'lobstr'){ 
                    //check if lobstr is installed
                    const isInstalled = await lobstr.isConnected()
                    if(isInstalled) {  
                        const userAddress = await lobstr.getPublicKey()
                        if(userAddress){
                            JSON.stringify(localStorage.setItem('selectedWallet', userAddress))
                            JSON.stringify(localStorage.setItem('LUMOS_WALLET', 'lobstr'))
                            JSON.stringify(localStorage.setItem('LUMOS_CHAIN', 'stellar'))
                            await auth2Fa(userAddress)
                        }
                        else {
                            alert('User denied access','Wallet Connect Error')
                        }
                    }   
                    else {
                        //redirect to freighter website
                        alert('Lobstr wallet app is not installed in your browser.','Wallet Info','warn')
                     }
                }
                else if(selectedWallet.name.toLowerCase() == 'gem'){ 
                    //check if lobstr is installed
                    const isInstall = await isInstalled()
                    if(isInstall) {  
                        const userAddress = await getAddress()
                        if(userAddress){
                            JSON.stringify(localStorage.setItem('selectedWallet', userAddress.result.address))
                            JSON.stringify(localStorage.setItem('LUMOS_WALLET', 'gem'))
                            JSON.stringify(localStorage.setItem('LUMOS_CHAIN', 'xrp'))
                            await auth2Fa(userAddress.result.address)
                        }
                        else {
                            alert('User denied access','Wallet Connect Error')
                        }
                    }   
                    else {
                        //redirect to freighter website
                        alert('Gem wallet app is not installed in your browser.','Wallet Info','warn')
                     }
                }
                else if(selectedWallet.name.toLowerCase() == 'xaman'){ 
                    //ping xama
                    const xama = new Xumm(process.env.NEXT_PUBLIC_XAMA_PUBLIC_KEY, process.env.NEXT_PUBLIC_XAMA_SECRET_KEY)
                    /*await xama.ping()
                    const pay = await xama.payload.create({
                        "txjson": {
                          "TransactionType": "SignIn"
                        }
                      })
                      console.log(pay)
                    if(pay.next){
                        //open websocket first
                        const web = new WebSocket(pay?.refs?.websocket_status)
                        web.onmessage = (e) => {
                            console.log(e)
                        }
                    }
                    return;*/
                    xama.on("logout", async () => {
                        console.log("Log out")
                    })
                    await xama.logout()
                    xama.on("ready", (e) => console.log("Xama Ready", e))
                    //success events
                    xama.on("success", async (e) => {
                      xama.user.account.then(async account => { 
                        if(account){
                            JSON.stringify(localStorage.setItem('selectedWallet', account))
                            JSON.stringify(localStorage.setItem('LUMOS_WALLET', 'xama'))
                            JSON.stringify(localStorage.setItem('LUMOS_CHAIN', 'xrp'))
                            await auth2Fa(account)
                        }
                        else {
                            alert('User denied access','Wallet Connect Error')
                        }
                      })
                    })
                    xama.on("retrieving", async (e) => { 
                        xama.user.account.then(async account => { 
                          if(account){
                              JSON.stringify(localStorage.setItem('selectedWallet', account))
                              JSON.stringify(localStorage.setItem('LUMOS_WALLET', 'xama'))
                              JSON.stringify(localStorage.setItem('LUMOS_CHAIN', 'xrp'))
                              await auth2Fa(account)
                          }
                          else {
                              alert('User denied access','Wallet Connect Error')
                          }
                        })
                    })
                    //disconnect first any session
                    xama.authorize() 
                }
                else if(selectedWallet.name.toLowerCase() == "wallet connect") {
                    const signClient = await SignClient.init(
                        {
                            projectId: process.env.NEXT_PUBLIC_WALLET_CONNECT_ID,
                            // optional parameters
                            relayUrl: 'wss://relay.walletconnect.com',
                            metadata: {
                                name: 'Lumos Dao',
                                description: 'Create DAOs on Lumos Dao',
                                url: 'https://app.lumosdao.org/',
                                icons: ["https://lumosdao.io/public/images/Image.png"]
                            },
                    })
                    walletConnectConfig.client = signClient
                    setQrModal(true)
                    setWalletLoading(true)
                    const provider = await UniversalProvider.init(walletConnectConfig)
                    provider.on('display_uri', uri => {
                        const platform = navigator.userAgent.toLowerCase()
                        if(platform.indexOf('android') > -1) {
                            //using adroid
                            setWalletUri(uri)
                        }
                        else{setWalletUri(`https://lobstr.co/uni/wc/wc?uri=${encodeURIComponent(uri)}`)}
                        setWalletLoading(false)
                        
                        QRCode.toDataURL(E('walletConnectCanvas'), uri, {
                            width:200,
                            height:200,
                            color: {
                                dark:"#000000"
                            }
                        }, (err, url) => {
                            
                        });
                    })
                    const wallet = await provider.connect({
                        optionalNamespaces: {
                            stellar: {
                            methods: [
                                'stellar_signAndSubmitXDR',
                                'stellar_signXDR',
                            ],
                            chains: [walletConnectNetwork],
                            events: ['chainChanged', 'accountsChanged'],
                            rpcMap: {
                                pubnet:
                                `https://rpc.walletconnect.com?chainId=${walletConnectNetwork}&projectId=${process.env.NEXT_PUBLIC_WALLET_CONNECT_ID}`
                                }
                            }
                        },
                        skipPairing: false // optional to skip pairing ( later it can be resumed by invoking .pair())
                    })
                    if(wallet) {
                        if(provider.session) {
                            let address = (provider.session.namespaces.stellar.accounts[0])
                            address = address.substring(address.lastIndexOf(":") + 1)
                            JSON.stringify(localStorage.setItem('selectedWallet', address))
                            JSON.stringify(localStorage.setItem('LUMOS_WALLET', 'wallet_connect'))
                            localStorage.setItem('LUMOS_WALLET_CONNECT_EXPIRY', provider.session.expiry)
                            localStorage.setItem('LUMOS_WALLET_CONNECT_DATA', JSON.stringify(provider.session))
                            await auth2Fa(address)
                        }
                    }
                }
                setConnectWallet(false)
                setLoader(false)
            }
            catch(e){
                console.log(e)
                setLoader(false)
                setQrModal(false)
                alert(e,'Wallet Connect Error')
            }
        }
    }

    const auth2Fa = async (address) => {
        const user = await getUserInfo(address)
        if(user !== false) {
            if(user.status){
                if(user.user['2fa_secret_key'] != '' && user.user['2fa_auth'] != 'true') {
                    //redirect to 2fa page
                    window.location.assign('/2fa')
                    return;
                }
            }
        }
        //redirect to dao
        if(location.href.indexOf("/") > -1){
            //not in homepage
            location.reload()
        }
        else{window.location.assign("/dao")}
    }
  return (
    <>
    {
        (qrModal) ?
            <div className='flex px-4 py-7 md:p-7 flex-col justify-center fixed top-[50%] left-[50%] bg-white md:w-[600px] border w-[97%] z-[9999999] helvetica-font' style={{ transform: "translate(-50%, -50%)" }}>
                    <div className='flex items-center justify-between mb-3 w-full'>
                        <p>Login with wallet connect</p>
                        <p className='text-[24px] cursor-pointer' onClick={() => setQrModal(false)}>&times;</p>
                    </div>
                    
                    
                    <div style={(walletLoading === true) ? {}: {display:'none'}} className='flex w-[100%] items-center justify-center'>
                        <svg aria-hidden="true" class="w-12 h-12 text-gray-100 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    
                    <div style={(walletLoading === false) ? {}: {display:'none'}} className='flex flex-col items-center justify-center'>
                    <button onClick={()=>{ console.log(walletUri)
                        window.open(walletUri, '_target')
                    }} className='my-3 px-4 py-2 rounded-[4px] bg-[#DC6B19] text-white lg:hidden block'>CONNECT ON MOBILE</button>
                        {/*  SHOW ONLY ON DESKTOP */}
                        <div className='hidden lg:flex flex-col' style={{alignItems:'center', justifyContent:'center'}}>
                        <p>
                            Open your WalletConnect-compatible app with stellar support, like LOBSTR wallet, and scan the QR Code to connect.
                        </p>
                        <div className='flex items-center' style={{justifyContent:'center'}}>
                            <canvas id='walletConnectCanvas'>

                            </canvas>
                        </div> 
                        <button onClick={()=> {
                            navigator.clipboard.writeText(walletUri)
                            setMsg('uri copied successfully!')
                        }} className='mt-3 block text-gray-500'>Copy to clipboard</button>
                        </div>
                    </div>
                    
            </div>
        :
        <></>
    }
        <div>
            <div className="h-full w-full fixed top-0 left-0 z-[999]" style={{ background:"rgba(14, 14, 14, 0.58)" }} onClick={() => setConnectWallet(false)}></div>
            <div className="bg-white md:w-[450px] w-[92%] px-2 flex flex-col items-start justify-center fixed top-[48%] left-[50%] pb-[3rem] rounded-[8px] z-[1000] login-modal" style={{ transform: "translate(-50%, -50%)" }}>
                <div className='flex items-center justify-between pt-6 px-3 w-full'>
                    <p className='text-[15px] md:text-[20px]'>Select Network</p>
                    <IoCloseOutline onClick={() => setConnectWallet(false)} className='text-gray-500 md:text-[25px] text-[20px] cursor-pointer'/>
                </div>
                {
                    selectedNetwork === '' &&
                    <div className='flex items-start flex-col text-center w-full mt-6'>
                        {
                            availableNetworks.map((network, index) => {
                                return(
                                    <div key={index} 
                                        onClick={() => {
                                            setSelectedNetwork(network)
                                            console.log(network.name);
                                            
                                            // setConnectWallet(false)
                                            // setSelectedWallet(network)
                                            setDropdownOpen(false)
                                        }} className='flex justify-between items-center w-full cursor-pointer hover:bg-gray-100 border-b px-4 pb-[12px] pt-[20px]'>
                                        <div className='gap-[8px] flex items-center text-gray-500'>
                                            <img src={network.icon} className='w-[35px]'/>
                                            <p>{network.name}</p>
                                        </div>
                                            {
                                                network.commingSoon === false ?
                                                <GoChevronRight /> 
                                                    :
                                                <p className='text-[#344054] bg-[#F2F4F7] text-[12px] rounded-full py-1 px-3 inline-block min-w-[90px] text-center'>Coming soon</p>
                                            }
                                    </div>
                                )
                            })
                        }
                    </div>
                }

                {
                    selectedNetwork.name === "Stellar" &&
                    <div className='md:flex items-start flex-col text-center w-full mt-6 hidden'>
                        {
                            stellarWallets.map((wallet, index) => {
                                return(
                                    <div key={index} 
                                        onClick={() => {
                                            // setConnectWallet(false)
                                            setSelectedWallet(wallet)
                                        }} className='flex justify-between items-center w-full cursor-pointer hover:bg-gray-100 border-b px-4 pb-[12px] pt-[20px]'>
                                        <div className='gap-[8px] flex items-center text-gray-500'>
                                            <img src={wallet.icon} className='w-[35px]'/>
                                            <p>{wallet.name}</p>
                                        </div>
                                        {
                                            loader ? 
                                            <p className='bg-[#F2F4F7] rounded-full py-[6px] px-3 inline-flex justify-center items-center min-w-[90px] text-center text-[12px] cursor-not-allowed'>
                                                <RiLoader5Fill  className='animate-spin text-center'/>
                                            </p>
                                                :
                                            <p onClick={() => connectWallet(wallet)} className='text-[#344054] bg-[#F2F4F7] text-[12px] rounded-full py-1 px-3 inline-block min-w-[90px] text-center'>Connect</p>
                                        }
                                    </div>
                                )
                            })
                        }
                    </div>
                }

                {
                    selectedNetwork.name === "Stellar" &&
                    <div className='flex items-start flex-col text-center w-full mt-6 md:hidden'>
                        {
                            stellarMobileWallets.map((wallet, index) => {
                                return(
                                    <div key={index} 
                                        onClick={() => {
                                            // setConnectWallet(false)
                                            setSelectedWallet(wallet)
                                        }} className='flex justify-between items-center w-full cursor-pointer hover:bg-gray-100 border-b px-4 pb-[12px] pt-[20px]'>
                                        <div className='gap-[8px] flex items-center text-gray-500'>
                                            <img src={wallet.icon} className='w-[35px]'/>
                                            <p>{wallet.name}</p>
                                        </div>
                                        {
                                            loader ? 
                                            <p className='bg-[#F2F4F7] rounded-full py-[6px] px-3 inline-flex justify-center items-center min-w-[90px] text-center text-[12px] cursor-not-allowed'>
                                                <RiLoader5Fill  className='animate-spin text-center'/>
                                            </p>
                                                :
                                            <p onClick={() => connectWallet(wallet)} className='text-[#344054] bg-[#F2F4F7] text-[12px] rounded-full py-1 px-3 inline-block min-w-[90px] text-center'>Connect</p>
                                        }
                                    </div>
                                )
                            })
                        }
                    </div>
                }

                {
                    selectedNetwork.name === "Ripple" &&
                    <div className='md:flex hidden items-start flex-col text-center w-full mt-6'>
                        {
                            xrpWallets.map((wallet, index) => {
                                return(
                                    <div key={index} 
                                        onClick={() => {
                                            // setConnectWallet(false)
                                            setSelectedWallet(wallet)
                                        }} className='flex justify-between items-center w-full cursor-pointer hover:bg-gray-100 border-b px-4 pb-[12px] pt-[20px]'>
                                        <div className='gap-[8px] flex items-center text-gray-500'>
                                            <img src={wallet.icon} className='w-[35px]'/>
                                            <p>{wallet.name}</p>
                                        </div>
                                        {
                                            loader ? 
                                            <p className='bg-[#F2F4F7] rounded-full py-[6px] px-3 inline-flex justify-center items-center min-w-[90px] text-center text-[12px] cursor-not-allowed'>
                                                <RiLoader5Fill  className='animate-spin text-center'/>
                                            </p>
                                                :
                                            <p onClick={() => connectWallet(wallet)} className='text-[#344054] bg-[#F2F4F7] text-[12px] rounded-full py-1 px-3 inline-block min-w-[90px] text-center'>Connect</p>
                                        }
                                    </div>
                                )
                            })
                        }
                    </div>
                }

                {
                    selectedNetwork.name === "Ripple" &&
                    <div className='md:hidden flex items-start flex-col text-center w-full mt-6'>
                        {
                            xrpMobileWallets.map((wallet, index) => {
                                return(
                                    <div key={index} 
                                        onClick={() => {
                                            // setConnectWallet(false)
                                            setSelectedWallet(wallet)
                                        }} className='flex justify-between items-center w-full cursor-pointer hover:bg-gray-100 border-b px-4 pb-[12px] pt-[20px]'>
                                        <div className='gap-[8px] flex items-center text-gray-500'>
                                            <img src={wallet.icon} className='w-[35px]'/>
                                            <p>{wallet.name}</p>
                                        </div>
                                        {
                                            loader ? 
                                            <p className='bg-[#F2F4F7] rounded-full py-[6px] px-3 inline-flex justify-center items-center min-w-[90px] text-center text-[12px] cursor-not-allowed'>
                                                <RiLoader5Fill  className='animate-spin text-center'/>
                                            </p>
                                                :
                                            <p onClick={() => connectWallet(wallet)} className='text-[#344054] bg-[#F2F4F7] text-[12px] rounded-full py-1 px-3 inline-block min-w-[90px] text-center'>Connect</p>
                                        }
                                    </div>
                                )
                            })
                        }
                    </div>
                }
            </div>
        </div>

        {
            msg && (
                <Alert msg={msg} alertType={alertType} setMsg={setMsg} />
            )
        }
    </>
  )
}

export default ConnectWalletModal