'use client'
/**
 * CONTAINS ALL FUNCTIONS NEEDED TO INTERACT WITH THE DAO VIA
**/
import * as StellarSdk from '@stellar/stellar-sdk';
import { API_URL, S, networkUsed, networkWalletUsed, server, fee, timeout, daoContractId, contract, version, stellarServer, wrappingAddress, horizonServer, floatingConstant, BACKEND_API, walletConnectConfig, walletConnectNetwork, xrpClient, xrp, TOML_URL, xrpTreasuryAddress } from "../data/constant"
import freighterApi from '@stellar/freighter-api'
import lobstrApi from '@lobstrco/signer-extension-api'
import {isInstalled, signTransaction} from "@gemwallet/api"
import { alert, stopTalking, talk } from '../components/alert/swal';
import { fAddr, fNum, getAlldaoInfo, getTokenTomlInfo, getUserBan, Hash, isAdmin, isImageURLValid, readAssetToml } from './getter';
import UniversalProvider from '@walletconnect/universal-provider'  
import { Xumm } from "xumm"

/* GETTER UTILS */
const E = (id) => {
  return document.getElementById(id);
}; 

/** To convert a bigInt to number
* params {num}
* returns {BigInt} 
*/
export const N = (num) => {return ((num||0).toString() * 1)}
/** Validate image upload 
* params {id} String - the id of the file element
* params {dispId} String - the id of the elemnt to display the image
* params {type: 1[background] |2 [src]} Integer - specifies if its background or src that would be changes
*/

export const validateImageUpload = (id, dispId, type = 1, callback = (e)=>{}, options = {}) => {
    E(id).onchange = async (event) => {
        try{
            const fileInput = E(id); 
              // Check if a file is selected
              if (fileInput.files.length === 0) {
                stopTalking(4, talk("Please select a file.", "warn"));
                fileInput.files = []
                callback(null)
                return;
              }
              
              // Check the file size (max size: 3MB)
              const maxSize = 3 * 1024 * 1024; // 3MB in bytes
              if (fileInput.files[0].size > maxSize) {
                stopTalking(4, talk("File size exceeds the maximum allowed (3MB).", "warn"));
                fileInput.files = []
                callback(null) 
                return;
              }
              // Check if the selected file is an image
              if (!fileInput.files[0].type.startsWith('image/')) {
                stopTalking(4, talk("Please select an image file.", "warn"));
                fileInput.files = []
                callback(null)
                return;
              }
              const imageURL = URL.createObjectURL(fileInput.files[0]);
              if(options.width && options.height) {
                //check dimensions
                const size = await imgSize(imageURL) 
                if(size.width != options.width && size.height != options.height) {
                    stopTalking(4, talk(`The image should have dimensions of ${options.width}×${options.height} Pixels`, 'fail'))
                    URL.revokeObjectURL(imageURL)
                    callback(null)
                    return;
                }
              }
              callback(fileInput.files[0], imageURL)
              if(type == 1) {
                  const imageElement = document.createElement("img");
                  imageElement.src = imageURL;
                  imageElement.style.maxWidth = "90%"; // Adjust image size if needed
                  imageElement.style.maxHeight = "90%"; // Adjust image size if needed
                  E(dispId).innerHTML = ""; // Clear any previous image
                  E(dispId).appendChild(imageElement);
              }
              else { 
                  //using src
                  E(dispId).src = imageURL
              }
        }
        catch(e) {callback(null)}
    }
}
/* To Compress image
for optimization
*/
export const optimizeImg = async (pngDataURL, quality, maxWidth, maxHeight) => {
        return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => {
            let width = img.width;
            let height = img.height;
            // Calculate new dimensions while maintaining aspect ratio
            if (width > maxWidth && maxWidth != 0) {
                height *= (maxWidth / width);
                width = maxWidth;
            }
            if (height > maxHeight && maxHeight != 0) {
                width *= (maxHeight / height);
                height = maxHeight;
            }
            
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(img, 0, 0, width, height);
            canvas.toBlob((blob) => {
                resolve(blob);
            }, 'image/jpeg', quality);
        };
        img.onerror = (error) => {
            reject(error);
        };
        img.src = pngDataURL;
    });
}
/** Validate image upload  
* params {id} String - the id of the file element
* params {dispId} String - the id of the elemnt to display the image
* params {type: 1[background] |2 [src]} Integer - specifies if its background or src that would be changes
*/
export const validateImageUploadSilently =  (callback = (e)=>{}, options = {}) => {
        const fileInput = document.createElement('input')
        fileInput.type = 'file'
        fileInput.accept=".jpg, .jpeg, .png, .bmp, .gif"
        fileInput.onchange = async (event) => {
            try{
                  // Check if a file is selected
                  if (fileInput.files.length === 0) {
                    stopTalking(4, talk("Please select a file.", "warn"));
                    fileInput.files = []
                    callback(null)
                    return;
                  }
                  
                  // Check the file size (max size: 3MB)
                  const maxSize = 3 * 1024 * 1024; // 3MB in bytes
                  if (fileInput.files[0].size > maxSize) {
                    stopTalking(4, talk("File size exceeds the maximum allowed (3MB).", "warn"));
                    fileInput.files = []
                    callback(null) 
                    return;
                  }
                  // Check if the selected file is an image
                  if (!fileInput.files[0].type.startsWith('image/')) {
                    stopTalking(4, talk("Please select an image file.", "warn"));
                    fileInput.files = []
                    callback(null)
                    return;
                  }
                  const imageURL = URL.createObjectURL(fileInput.files[0]);
                  if(options.width && options.height) {
                    //check dimensions
                    const size = await imgSize(imageURL) 
                    if(size.width != options.width && size.height != options.height) {
                        stopTalking(4, talk(`The image should have dimensions of ${options.width}×${options.height} Pixels`, 'fail'))
                        URL.revokeObjectURL(imageURL)
                        callback(null)
                        return;
                    }
                  }
                  callback(fileInput.files[0], imageURL)
            }
            catch(e) {callback(null)}
           }
        fileInput.click()
}

/* MODIFIERS */
/** This function creates trustline
* @params {code} String
* @params {issuer} String
* @params {address} String
* returns {statusObject} | {statusBoolean}
**/
export const createTrustline = async (code, issuer, address, daoName = "", daoId = "") => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                let _walletAdr = new StellarSdk.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                const asset = new StellarSdk.Asset(code, issuer)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to establist trustline
                        StellarSdk.Operation.changeTrust({
                        asset: asset,
                        source: address,
                        }),
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' joining lumos dao'))
                    .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    await addDaoUser({
                        type:'join',
                        token:daoId
                    })
                    await addTx({hash:res.hash,
                    address:walletAddress,
                    action:"Joined DAO " + daoName,
                    data: daoId
                })
                return {status: true}
                }
            }
            else if(CHAIN == 'xrp') {
                const client = await xrpClient()
                const trustTx = await client.autofill({
                    "TransactionType": "TrustSet",
                    "Account": walletAddress,
                    "LimitAmount": {
                      "currency": code,
                      "issuer": issuer,
                      "value": "1000000000000000000000" 
                    }
                })
                const res = await execTranst(trustTx)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    await addDaoUser({
                        type:'join',
                        token:daoId
                    })
                    await addTx({
                        hash:res.hash,
                        address:walletAddress,
                        action:"Joined DAO " + daoName,
                        data: daoId
                    })
                    return {status: true}
                }
            }
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** This function burns token
 * @params {amount}
 * @params {tokenId}
 * returns {statusObject} | {statusBoolean}
**/
export const burnToken = async (amount, code, issuer) => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                let _walletAdr = new StellarSdk.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                const asset = new StellarSdk.Asset(code, issuer)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call mint on the contract
                        StellarSdk.Operation.payment({
                            amount: amount,
                            asset: asset,
                            destination: issuer,
                            source: walletAddress,
                        })
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' Burning Asset'))
                    .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    return {status: true}
                }
            }
            else if(CHAIN == 'xrp') {
                const client = await xrpClient()
                const burnTx = await client.autofill({
                    "TransactionType": "Payment",
                    "Account": walletAddress,
                    "Amount": {
                      "currency": code,
                      "value": amount,
                      "issuer": issuer
                    },
                    "Destination": issuer,
                    "DestinationTag": 1 
                })
                const res = await execTranst(burnTx)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                   return {status: true}
                }
            }
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** This function removes a trustline
     * @params {code} String
     * @params {issuer} String
     * @params {address} String
     * returns {statusObject} | {statusBoolean}
**/
export const removeTrustline = async (code, issuer, address, daoName = "", daoId = "") => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                let _walletAdr = new StellarSdk.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                const asset = new StellarSdk.Asset(code, issuer)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to establist trustline
                        StellarSdk.Operation.changeTrust({
                        asset: asset,
                        source: address,
                        limit:'0'
                        }),
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' leaving lumos dao'))
                    .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    await addDaoUser({
                        type:'left',
                        token:daoId
                    })
                    await addTx({
                        hash:res.hash,
                        address:walletAddress,
                        action:"Left DAO " + daoName,
                        data: daoId
                    })
                    return {status: true}
                }
            }
            else if(CHAIN == 'xrp') {
                const client = await xrpClient()
                const trustTx = await client.autofill({
                    "TransactionType": "TrustSet",
                    "Account": walletAddress,
                    "LimitAmount": {
                      "currency": code,
                      "issuer": issuer,
                      "value": "0" 
                    }
                })
                const res = await execTranst(trustTx)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    await addDaoUser({
                        type:'left',
                        token:daoId
                    })
                    await addTx({
                        hash:res.hash,
                        address:walletAddress,
                        action:"Left DAO " + daoName,
                        data: daoId
                    })
                    return {status: true}
                }
            }
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}

//to leave a dao
export const leaveDao = async (code, issuer, daoId, daoName) => {  
    //leave the dao
    const res = await removeTrustline(code, issuer, walletAddress, daoName, daoId)
    return res;
}
/** This list of functions deploy a new asset
* @params {assetCode}
* returns {statusObject {status, assetId}} | {statusBoolean}
**/
export const deployStellarAsset = async (code, issuer, signingKey = null) => {
    try{ 
        if(CHAIN == 'stellar'){
            const asset = new S.Asset(code, issuer)
            const xdrAsset = asset.toXDRObject();
            const encoder = new TextEncoder(); 
            const encodedData = encoder.encode(networkUsed);
            const networkId = S.hash(encodedData.buffer);
            const preimage = S.xdr.HashIdPreimage.envelopeTypeContractId(
                new S.xdr.HashIdPreimageContractId({
                networkId: networkId,
                contractIdPreimage: S.xdr.ContractIdPreimage.contractIdPreimageFromAsset(xdrAsset),
                })
            );
            const contractId = S.StrKey.encodeContract(S.hash(preimage.toXDR()));
            const deployFunction = S.xdr.HostFunction.hostFunctionTypeCreateContract(
                new S.xdr.CreateContractArgs({
                contractIdPreimage: S.xdr.ContractIdPreimage.contractIdPreimageFromAsset(xdrAsset),
                executable: S.xdr.ContractExecutable.contractExecutableToken(),
                })
            );
            const res = await invokeAndUnwrap(
                S.Operation.invokeHostFunction({
                func: deployFunction,
                auth: [],
                }),
                () => undefined,
                signingKey
            );
                
            if(res.status) {
                res.value = StellarSdk.scValToNative(res.value)
                //save the tx first
                await addTx({hash:res.hash,
                    address:issuer,
                    action:"Create new Stellar Asset (" + asset.code + ")",
                    data:asset.code
                })
            }
            return res
        }
        else if(CHAIN == 'xrp') {
            //configure the account settings
            const client = await xrpClient()
            const assetTx = await client.autofill({
                "TransactionType": "AccountSet",
                "Account": signingKey.address,
                "TransferRate": 0,
                "TickSize": 7,
                "Domain": Buffer.from(TOML_URL, 'utf8').toString('hex'),
                "SetFlag": xrp.AccountSetAsfFlags.asfDefaultRipple,
                "Flags": (xrp.AccountSetTfFlags.tfDisallowXRP |
                    xrp.AccountSetTfFlags.tfRequireDestTag)
       
            })
            const res = await execTranst(assetTx, signingKey)
            if(res.status === false) {
                //something went wrong
                return false
            }
            else {
                //create settings for the hot wallet
                const assetTx = await client.autofill({
                    "TransactionType": "AccountSet",
                    "Account": walletAddress,
                    "Domain": Buffer.from(TOML_URL, 'utf8').toString('hex'),
                    "SetFlag": xrp.AccountSetAsfFlags.asfDefaultRipple,
                    "Flags": (xrp.AccountSetTfFlags.tfDisallowXRP |
                        xrp.AccountSetTfFlags.tfRequireDestTag)
           
                })
                const resp = await execTranst(assetTx)
                if(resp.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                } 
                return {status:true, value:await Hash(`${code}:${issuer}`)}
            }

        }
    }
    catch(e) {
        console.log(e)
        return {status:false, msg:e.message || e  || "Something went wrong"}
    }
    return {status:false, msg:"Something went wrong"}
}
export const invokeAndUnwrap = async (operation, parse, signingKey=null) => {
  const result = await invoke(operation, false, parse, signingKey); 
  return result;
}
export const invoke = async (operation,sim,parse, signingKey = null) => {
  const txBuilder = await createTxBuilder(signingKey);
  if (typeof operation === 'string') {
    operation = S.xdr.Operation.fromXDR(operation, 'base64');
  }
  txBuilder.addOperation(operation);
  const tx = txBuilder.build();
  return invokeTransaction(tx, sim, parse, signingKey);
}
export const createTxBuilder = async (signingKey=null) => {
  try {
      
    const account = await server.getAccount(signingKey.publicKey())
    return new S.TransactionBuilder(account, {
      fee: '10000',
      networkPassphrase: networkUsed
    }).setTimeout(timeout);
  } catch (e) {
    console.error(e);
    throw Error('unable to create txBuilder');
  }
}
export const invokeTransaction = async(tx, sim, parse, signingKey=null) => {
  
  const hash = tx.hash().toString('hex');
  const simulation_resp = await server.simulateTransaction(tx);
  if (sim || S.SorobanRpc.isSimulationError(simulation_resp)) {
    // allow the response formatter to fetch the error or return the simulation results
    return {status:false, msg:'simulation fail'};
  }
  const prepped_tx = S.assembleTransaction(tx, networkUsed, simulation_resp).build();
  return await exeTranst(prepped_tx, signingKey)
}
/** For asset deployment only **/
export const exeTranst = async (transaction = "", signingKey = null) => {
    if(transaction !== "") {
        //prepare xdr
        let xdr = await transaction.toXDR();
        try { 
            if(signingKey != null) {
                //sign with signing key
                transaction.sign(S.Keypair.fromSecret(signingKey.secret()));
            }
            else{
                if(WALLET_TYPE.toLowerCase() == "freighter") xdr = await freighterApi.signTransaction(xdr, networkWalletUsed) //sign with freighter
                if(WALLET_TYPE.toLowerCase() == "lobstr") xdr = await lobstrApi.signTransaction(xdr)
                if(WALLET_TYPE.toLowerCase() == "wallet_connect") {
                        //create provider
                        const signClient = await SignClient.init(
                        {
                            projectId: process.env.NEXT_PUBLIC_WALLET_CONNECT_ID,
                            // optional parameters
                            relayUrl: 'wss://relay.walletconnect.com',
                            metadata: {
                                name: 'Lumos Dao',
                                description: 'Create DAOs on Lumos Dao',
                                url: 'https://app.lumosdao.com/',
                                icons: ["https://lumosdao.io/public/images/Image.png"]
                            },
                        })
                        walletConnectConfig.client = signClient
                        const provider = await UniversalProvider.init(walletConnectConfig)
                        const lastKeyIndex = signClient.session.getAll().length - 1
                        const session = signClient.session.getAll()[lastKeyIndex]
                        if(session){
                            provider.namespace = walletConnectNameSpace
                            signClient.namespace = walletConnectNameSpace
                            provider.on('session_event', ({ event, chainId }) => {
                            })
    
                            xdr = await signClient.request({
                                topic:session.topic,
                                chainId: walletConnectNetwork,
                                request: {
                                    method: 'stellar_signXDR',
                                    params: {xdr}
                                }
                            })
                            if(xdr) xdr = xdr.signedXDR
                        }
                    else {
                            //disconnect wallet
                            localStorage.setItem('selectedWallet', '') 
                            localStorage.setItem('LUMOS_WALLET', '') 
                            localStorage.setItem('LUMOS_WALLET_CONNECT_EXPIRY', 0)
                            alert("Wallet disconnected", 'Wallet Error')
                    }
                }
                //recreate signed transaction
                transaction = new S.Transaction(xdr, networkUsed)
            }
            //transaction.sign(S.Keypair.fromSecret(walletKey));
            let sendResponse = await server.sendTransaction(transaction);
            console.log(`Sent transaction: ${JSON.stringify(sendResponse)}`);
            if (sendResponse.status === "PENDING") {
              let getResponse = await server.getTransaction(sendResponse.hash);
              // Poll `getTransaction` until the status is not "NOT_FOUND"
              while (getResponse.status === "NOT_FOUND") {
                console.log("Waiting for transaction confirmation...");
                // See if the transaction is complete
                getResponse = await server.getTransaction(sendResponse.hash);
                // Wait one second
                await new Promise((resolve) => setTimeout(resolve, 1000));
              }
              if (getResponse.status === "SUCCESS") {
                // Make sure the transaction's resultMetaXDR is not empty
                if (!getResponse.resultMetaXdr) {
                   return {status:true, msg:""}
                }
                // Find the return value from the contract and return it
                let transactionMeta = getResponse.resultMetaXdr;
                let returnValue = transactionMeta.v3().sorobanMeta().returnValue();
                return {status:true, value: returnValue}
              } else {  
                return {status:false, msg:"Transacton failed"}
              }
            } else {
               return {status:false, msg:"Unable to send transaction"}
            }
      } catch (err) {
        // Catch and report any errors we've thrown
        console.log("Sending transaction failed", err);
        return {status:false, msg:err.msg || err || "Something went wrong"}
    }
}
}
/** To execute a transaction
* @params {transactionObject}
* @params {callBack}
**/
export const execTranst = async (transaction = "", signingKey = null) => {
    if(transaction !== "") {
        if(CHAIN == 'stellar'){
            //prepare xdr
            const server = new StellarSdk.SorobanRpc.Server(stellarServer); 
            let xdr = await transaction.toXDR(); 
            try {
                if(signingKey != null) {
                    //sign with signing key
                    transaction.sign(StellarSdk.Keypair.fromSecret(signingKey.secret()));
                }
                else{
                    if(WALLET_TYPE.toLowerCase() == "freighter") xdr = await freighterApi.signTransaction(xdr, networkWalletUsed) //sign with freighter
                    if(WALLET_TYPE.toLowerCase() == "lobstr") xdr = await lobstrApi.signTransaction(xdr)
                    if(WALLET_TYPE.toLowerCase() == "wallet_connect") {
                        //create provider
                        const provider = await UniversalProvider.init(walletConnectConfig)
                        const session = JSON.parse(localStorage.getItem('LUMOS_WALLET_CONNECT_DATA') || "{}")
                        if(session.namespaces){
                            provider.session = session
                            console.log(provider.session)
                            xdr = await provider.request({
                                method:"stellar_signXDR",
                                params:xdr
                            }, walletConnectNetwork)
                        }
                        else {
                            //disconnect wallet
                            localStorage.setItem('selectedWallet', '') 
                            localStorage.setItem('LUMOS_WALLET', '') 
                            localStorage.setItem('LUMOS_WALLET_CONNECT_EXPIRY', 0)
                            alert("Wallet disconnected", 'Wallet Error')
                        }
                    }
                    
                    //recreate signed transaction
                    transaction = new StellarSdk.Transaction(xdr, networkUsed)
                }
                //transaction.sign();
                let sendResponse = await server.sendTransaction(transaction);
                if (sendResponse.status === "PENDING") {
                let getResponse = await server.getTransaction(sendResponse.hash);
                const hash = sendResponse.hash
                // Poll `getTransaction` until the status is not "NOT_FOUND"
                while (getResponse.status === "NOT_FOUND") {
                    // See if the transaction is complete
                    getResponse = await server.getTransaction(sendResponse.hash);
                    // Wait one second
                    await new Promise((resolve) => setTimeout(resolve, 1000));
                }
                if (getResponse.status === "SUCCESS") {
                    // Make sure the transaction's resultMetaXDR is not empty
                    if (!getResponse.resultMetaXdr) {
                    return {status:true, msg:"", hash}
                    }
                    // Find the return value from the contract and return it
                    
                    //let transactionMeta = getResponse.resultMetaXdr;
                    let returnValue = getResponse.returnValue
                    return {status:true, value: returnValue, hash}
                } else { 
                    let error = (StellarSdk.scValToNative(getResponse.resultXdr._attributes.result))
                    if(error[0]._value._value._switch.name.toLowerCase().indexOf('underfunded') > -1){
                        error = "Not enough XLM"
                    }
                    else {
                        error = error[0]._value._value._switch.name
                    }
                    return {status:false, msg:error || "Transaction failed"}
                }
                } else {
                     return {status:false, msg:'Unable to submit transaction<br>Invalid wallet signature'}
                }
            } catch (err) {
                // Catch and report any errors we've thrown
                console.log("Sending transaction failed", err);
                return {status:false, msg:err.message}
            }
        }
        else if(CHAIN == 'xrp') {
            const client = await xrpClient()
            try {
                if(signingKey != null) { 
                    //sign with signing key
                    const tx = signingKey.sign(transaction);
                    transaction = tx.tx_blob
                }
                else{
                    if(WALLET_TYPE.toLowerCase() == "gem"){
                        if(await isInstalled()){
                            const tx = await signTransaction({transaction}) //sign with gem
                            //recreate signed transaction
                            transaction = tx.result?.signature
                        }
                    }
                    else if(WALLET_TYPE.toLowerCase() == "xama"){
                        const xama = new Xumm(process.env.NEXT_PUBLIC_XAMA_PUBLIC_KEY, process.env.NEXT_PUBLIC_XAMA_SECRET_KEY)
                        await xama.authorize()
                        const { created, resolved } = await xama.payload.createAndSubscribe(transaction, 
                            eventMessage => {
                            if ('signed' in eventMessage.data) {
                              // The `signed` property is present, true (signed) / false (rejected)
                              return eventMessage
                            }
                        })
                        //popop the sig request
                        window.open(created.next.always)
                        const {response} = await resolved
                        if(response){
                            if(response?.dispatched_result === 'tesSUCCESS') {
                                return {status:true, value:response?.dispatched_result, hash:response?.txid}
                            }
                            else{
                                return {status:true, value:'Transaction error', hash:response?.txid}
                            }
                        }
                        else{
                            return {status:false, msg:'Transaction error', hash:""}
                        }
                    }
                }
                let sendResponse = await client.submitAndWait(transaction)
                if (sendResponse.result.meta.TransactionResult === 'tesSUCCESS') {
                    console.log('Transaction was successful!');
                    return {status:true, value:sendResponse.result.meta.TransactionResult, hash:sendResponse.result.hash}
                } else {
                    console.log(sendResponse)
                    return {status:false, msg:'Transaction error', hash:sendResponse.result.hash}
                }
            } catch (err) {
                // Catch and report any errors we've thrown
                console.log("Sending transaction failed", err);
                return {status:false, msg:err.message}
            }
        }
    }
}
/** To verify if an asset has been wrapped
* @params {params}
* @params {callBack}
**/
export const verifyAsset = async (params = {code:"", issuer:""}) => {
    if(CHAIN == 'stellar'){
        if(wrappingAddress != "") {
            try{
                const account = await server.getAccount(wrappingAddress)
                let asset; let contract;
                if(params.code.length == 56) {
                    contract = new StellarSdk.Contract(params.code);
                }
                else {
                    asset = new StellarSdk.Asset(params.code, params.issuer)
                    contract = new StellarSdk.Contract(asset.contractId(networkUsed));
                }
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("symbol")
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                if(params.code.length == 56) {
                    return params.code;  
                }
                else {
                    return asset.contractId(networkUsed); 
                }
            }
            catch(e) {
                return false
            }
        }
    }
    else if(CHAIN == 'xrp'){
        return await Hash(`${params.code}:${params.issuer}`)
    }
    return false
}

/** This function checks
*  if DAO exists
* @params {daoId: Address}
* returns @map | []
**/ 

export const isDao =  async (daoId) => {
    if(wrappingAddress != "" && daoId != undefined && daoId != "") {
        try{ 
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(wrappingAddress)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_dao", (new StellarSdk.Address(daoId)).toScVal())
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                let dao = StellarSdk.scValToNative(transactionMeta.result.retval);
                if(dao['url'] != undefined) {  
                    return true
                }
                else {return false}
            }
            else if(CHAIN == 'xrp') {
                const daoMeta = await getAlldaoInfo([daoId].join(","))[daoId]
                if(daoMeta) { 
                    return true;
                }
                else {return false}
            }
        }
        catch(e) {
            return false}
    }
    else {return []}
}

/** This function creates trustline
* @params {code} String
* @params {issuer} String
* @params {address} String
* returns {statusObject} | {statusBoolean}
**/
export const createTrustlineQuiet = async (code, issuer, address) => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                let _walletAdr = new StellarSdk.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                const asset = new StellarSdk.Asset(code, issuer)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to establist trustline
                        StellarSdk.Operation.changeTrust({
                        asset: asset,
                        source: address,
                        }),
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' create trustline'))
                    .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    return {status: true}
                }
            }
            else {
                const client = await xrpClient()
                const trustTx = await client.autofill({
                    "TransactionType": "TrustSet",
                    "Account": walletAddress,
                    "LimitAmount": {
                      "currency": code,
                      "issuer": issuer,
                      "value": "1000000000000000000000" 
                    }
                })
                const res = await execTranst(trustTx)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    return {status: true}
                }
            }
        }
        else {return {status:false, msg:"Connect Wallet"}}
    }
    catch(e) {console.log(e);return {status:false, msg:e.message || e  || "Something went wrong"}}
}
  
/** This function creates the DAO
* @params {paramsObject {name, token, about}
* returns {daoId} | {statusBoolean}
**/
export const createDaos = async (params = {}) => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                //first add dao info to off chain db
                if(params.url.trim() != "" && params.token != "") {
                    const aToml = await readAssetToml(params.url, CHAIN); 
                    let code = params.code;code = code.replace(/[^a-zA-Z0-9]/g,"");
                    //fetch the token info
                    const tomlInfo = getTokenTomlInfo(aToml, code)
                    const coverImgx = tomlInfo.image.replace((code + tomlInfo.issuer), "cover_" + (code + tomlInfo.issuer)); 
                    const isCoverValid = await isImageURLValid(coverImgx)
                    const defCoverImg = (isCoverValid) ? coverImgx : 'https://images.unsplash.com/photo-1513151233558-d860c5398176?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            
                    //check if the url is http and from this domain
                    let url = API_URL + "new_dao&dao_id=" + daoContractId  + "&token=" + encodeURIComponent(params.token) + "&url=" + encodeURIComponent(params.url) + "&chain=stellar"
                    url += "&domain=" + encodeURIComponent(params.domain) + "&name=" + encodeURIComponent(tomlInfo.name) + "&code=" +  encodeURIComponent(code) + "&owner=" +  encodeURIComponent(walletAddress) + "&issuer=" +  encodeURIComponent(tomlInfo.issuer)  + "&image=" +  encodeURIComponent(tomlInfo.image)  + "&cover_image=" +  encodeURIComponent(defCoverImg) + "&about=" +  encodeURIComponent(tomlInfo.desc) 
                    const response = await fetch(url);
                    if (!response.ok) {
                    return {status: false, msg:'Network error'};
                    }
                    const res = await response.json();
                    if(!res.status) {return {status: false, msg:'Network error'}}
                }else{return {status: false, msg:'Unable to parse asset data'}}
                //now add info to on chain
                
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                let _walletAdr = new StellarSdk.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                let _tokenAdr = new StellarSdk.Address(params.token); _tokenAdr = _tokenAdr.toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("create", _walletAdr, _tokenAdr)
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' Created Lumos Dao'))
                    .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction); console.log(res)
                if(res.status === false) {
                    //something went wrong
                    return {status: false, msg:res.msg || 'Blockchain error'}
                }
                else {
                    //save the tx first
                await addTx({hash:res.hash,
                    address:walletAddress,
                    action:"Create new DAO " + params.name,
                    data:params.token
                })
                return {status: (S.scValToNative(res.value))}
                }
            }
            else if(CHAIN == 'xrp') {
                //first make the payment
                const hash = await payXrp(walletAddress, `${version} Created Lumos Dao`)
                if(hash) {
                    //create the dao
                    if(params.url.trim() != "" && params.token != "") {
                        let code = params.code;code = code.replace(/[^a-zA-Z0-9]/g,"");
                        //fetch the token info
                        const coverImgx = params.image.replace((code + params.issuer), "cover_" + (code + params.issuer)); 
                        const isCoverValid = await isImageURLValid(coverImgx)
                        const defCoverImg = (isCoverValid) ? coverImgx : 'https://images.unsplash.com/photo-1513151233558-d860c5398176?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
                        const res = await fetch(`${BACKEND_API}/chain/xrp/dao/new`, {
                            method: "POST",
                            body: JSON.stringify({
                                dao:{
                                    "token":params.token,              
                                    "url": params.url,    
                                    "domain": params.domain,         
                                    "name": params.name,          
                                    "code": code,                 
                                    "owner": walletAddress,     
                                    "issuer": params.issuer,  // XRP wallet address of the issuer
                                    "image": params.image,   
                                    "cover": defCoverImg,  
                                    "desc": params.about
                                },
                                }
                            ),
                            headers: {
                                "content-type": "application/json",
                            },
                        });
                        if(res.ok) {
                            const resp = await res.json()
                            if(res.status) {
                                await addTx({
                                    hash,
                                    address:walletAddress,
                                    action:"Create new DAO " + params.name,
                                    data:params.token
                                })
                                return {status: true}
                            }
                            else{
                                return {status: false, msg:resp.msg}
                            }
                        }
                    }else{return {status: false, msg:'Unable to parse asset data'}}
                }
                else {
                    return {status: false, msg:'User cancelled the operation'}
                }
            }
        }
        else {return {status: false, msg:'No wallet connected'}}
    }
    catch(e) {console.log(e); return {status: false, msg:'Network error'}}
}
/** This function funds the
* the issuing address 
* @params {address} String
* returns {statusObject} | {statusBoolean}  
**/
export const fundIssuer = async (params) => {
    try{
        if(CHAIN == 'stellar'){
            if(walletAddress != "") {
                //first check if the wallet already exists
                try{ 
                    const response = await fetch(`${horizonServer}/accounts/${params.address}`);
                    if (response.status != 404) {
                    return false
                    }
                }catch(e) {
                    return false
                }
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        StellarSdk.Operation.createAccount({
                        destination: params.address,
                        source:walletAddress,
                        startingBalance: "2",
                        }),
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' Creating issuer'))
                    .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    return {status: true}
                }
            }else{
                return {status:false, msg:"Connect wallet"}
            }
        }
        else if(CHAIN == 'xrp' && walletAddress != "") {
            const client = await xrpClient()
            //first check if issuer exists
            try{
                const info = await client.request({
                    command: 'account_info',
                    account: params.address,
                    ledger_index: 'validated'
                });
                // Extract and log the balance (in drops, convert to XRP)
                const bal = xrp.dropsToXrp(info?.result?.account_data?.Balance || 0);
                if(bal > 10) return {status: true} 
            }catch(e){}
            const fundTx = await client.autofill({
                "TransactionType": "Payment",
                "Account": walletAddress,
                "Amount": xrp.xrpToDrops(10.1),
                "Destination": params.address
            })
            const res = await execTranst(fundTx)
            if(res.status === false) {
                //something went wrong
                return {status:false, msg:res.msg}
            }
            else {
                return {status: true}
            }
        }
        return {status:false, msg:"Connect Wallet"}
    }
    catch(e) {console.log(e); return {status:false, msg:e.message || e || "Something went wrong"}}
}
/** This function mints token to the owner
 * @params {amount}
 * @params {tokenId}
 * returns {statusObject} | {statusBoolean}
**/
export const mintToken = async (amount, code, issuer, des, signingKey = null) => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(signingKey.publicKey())
                const asset = new StellarSdk.Asset(code, issuer)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call mint on the contract
                        StellarSdk.Operation.payment({
                        amount: amount,
                        asset: asset,
                        destination: des,
                        source: signingKey.publicKey(), 
                        })
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' Minting total supply'))
                    .build();
                //sign and exec transactions
                const res = await execTranst(transaction, signingKey)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    return {status: true}
                }
            }
            else if(CHAIN == 'xrp') {
                const client = await xrpClient()
                const mintTx = await client.autofill({
                    "TransactionType": "Payment",
                    "Account": issuer,
                    "Amount": {
                      "currency": code,
                      "value": amount,
                      "issuer": issuer
                    },
                    "Destination": walletAddress,
                    "DestinationTag": 1 
                })
                const res = await execTranst(mintTx, signingKey)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    //save the tx first
                    await addTx({
                        hash:res.hash,
                        address:issuer,
                        action:"Create new Xrp Asset (" + code + ")",
                        data:code 
                    })
                    return {status: true}
                }
            }
        }
        else {return {status:false, msg:"Connect Wallet"}}
    }
    catch(e) {console.log(e); 
        return {status:false, msg:e.message || e  || "Something went wrong"}
    }
}
/** This function locks an issuing wallet
 * @params {issuer} String
 * returns {statusObject} | {statusBoolean}  
**/
export const lockIssuerQuietly = async (params, signingKey = null) => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(signingKey.publicKey())
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        StellarSdk.Operation.setOptions({
                            masterWeight: 0,
                            source: params.issuer
                    })
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' verifying dao'))
                    .build();
                //sign and exec transactions
                const res = await execTranst(transaction, signingKey)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    return {status: true}
                }
            }
            else if(CHAIN == 'xrp'){
                const client = await xrpClient()
                const lockTx = await client.autofill({
                    TransactionType: "AccountSet",
                    Account: signingKey.address,
                    SetFlag: xrp.AccountSetAsfFlags.asfNoFreeze
                })
                //sign and exec transactions
                const res = await execTranst(lockTx, signingKey)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {return {status: true}}
            }
        }
        else {return {status:false, msg:"Connect Wallet"}}
    }
    catch(e) {console.log(e); return {status:false, msg:e.message || e  || "Something went wrong"}}
}
/** This function creates the proposal
 * @params {paramsObject {creator, dao, name, about, start, links}
 * returns {daoId} | {statusBoolean}
**/
export const createProposal = async (params = {}) => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.creator = new StellarSdk.Address(params.creator);params.creator = params.creator.toScVal()
                const propDao = params.dao
                params.dao = new StellarSdk.Address(params.dao); params.dao = params.dao.toScVal()
                const voting_type = StellarSdk.nativeToScVal(params.voting_type)
                const voting_option_no = StellarSdk.nativeToScVal(Object.keys(params?.voting_options || {}).length);
                
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("create_proposal", params.creator, params.dao, voting_type, voting_option_no)
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' Creating Lumos Proposal'))
                    .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false 
                }
                else {
                    let url = API_URL + "new_proposal&dao_id=" + daoContractId  + "&dao=" + encodeURIComponent(propDao) + "&links=" + encodeURIComponent(params.links) + "&voting_options=" + JSON.stringify(params?.voting_options || {})
                    url += "&name=" + encodeURIComponent(params.name) + "&about=" +  encodeURIComponent(params.about) + "&prop_id=" + (StellarSdk.scValToNative(res.value)) + "&user=" + (walletAddress) + "&ipfs=" + (params.ipfs)
                    const response = await fetch(url);
                    if (!response.ok) {
                    return false;
                    }
                    if(!(await response.json()).status) {return false}
                    await addTx({hash:res.hash,
                    address:walletAddress,
                    action:"Created proposal " + params.name,
                    data: JSON.stringify({dao:propDao,  proposal: N(StellarSdk.scValToNative(res.value))})
                    })
                    return {status: (StellarSdk.scValToNative(res.value))}
                }
            }
            else if(CHAIN == 'xrp') {
                //first make the payment
                const hash = await payXrp(walletAddress, `${version} Created Proposal`)
                if(hash) {
                    //create the dao
                    if(params.dao != "") {
                      
                        const res = await fetch(`${BACKEND_API}/chain/xrp/proposal/new`, {
                            method: "POST",
                            body: JSON.stringify({
                                prop:{
                                    creator:walletAddress,
                                    dao:params.dao,
                                    links:params.links,
                                    name:params.name,
                                    about:params.about,
                                    user:walletAddress,
                                    voting_type: params.voting_type,
                                    voting_options: params.voting_options
                                },
                            }),
                            headers: {
                                "content-type": "application/json",
                            },
                        });
                        if(res.ok) {
                            const resp = await res.json()
                            if(resp.status === true) {
                                await addTx({
                                    hash,
                                    address:walletAddress,
                                    action:"Created proposal " + params.name,
                                    data: JSON.stringify({dao:params.dao,  proposal: N(resp.propId)})
                                })
                                return {status: resp.propId}
                            }
                            else{
                                return {status: false, msg:resp.msg}
                            }
                        }
                    }else{return {status: false, msg:'Unable to parse asset data'}}
                }
                else {
                    return {status: false, msg:'User cancelled the operation'}
                }
            }
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** This function adds a delegate
* @params {paramsObject {delegate, dao}
* returns {string} | {statusBoolean}
**/
export const addDelegate = async (params = {}) => {
    try{
        if(walletAddress != "") {
            let memoTx = [];
            if(walletAddress != params.delegatee) {
                memoTx[0] = ' Delegated voting power'  
                memoTx[1] = ' Delegated voting power to ' + fAddr(params.delegatee, 6)  
            }
            else {
                memoTx[0] = ' Reclaimed voting power'
                memoTx[1] = ' Reclaimed voting power from ' + fAddr(params.del_address, 6)  
            }
            const daoId = params.dao
            let value="";let hash="";
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                const delegator = (new StellarSdk.Address(walletAddress)).toScVal()
                const delegatee = (new StellarSdk.Address(params.delegatee)).toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("add_delegate", params.dao, delegator, delegatee)
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + memoTx[0]))
                    .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else{value=StellarSdk.scValToNative(res.value);hash=res.hash}
            }
            else if(CHAIN == 'xrp'){
                hash = await payXrp(walletAddress, `${version} ${memoTx[0]}`)
                if(hash) {
                    //create the dao
                    if(params.dao != "") {
                        const res = await fetch(`${BACKEND_API}/chain/xrp/dao/setdelegator`, {
                            method: "POST",
                            body: JSON.stringify({
                                daoId:params.dao,
                                delegator:walletAddress,
                                delegatee:params.delegatee
                            }),
                            headers: {
                                "content-type": "application/json",
                            },
                        });
                        if(res.ok) {
                            const resp = await res.json()
                            if(resp.status === true) {
                                value = true
                            }
                            else{
                                value = false
                            }
                        }
                    }else{return false}
                }
                else {
                    return false
                }
            }
            if(value !== false) {
                await addTx({
                   hash,
                   address:walletAddress,
                   action:memoTx[1],
                   data:params.delegatee
               })
               await addAlerts({
                   other:walletAddress,
                   user:params.del_address || "",
                   action:memoTx[1],
                   link:"dao/" + daoId,
                   title:"Voting power delegation",
                   type:'delegation'
               })
            }
            return value
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}



//add dao user
export const addDaoUser = async (params) => {
    try {
        if(params.token != "") {
           //check if the url is http and from this domain
           const url = API_URL + "dao_user&token=" + params.token  + "&_type=" + encodeURIComponent(params.type) + "&user=" + encodeURIComponent(walletAddress)
           const response = await fetch(url);
           if (!response.ok) {
             throw new Error("Network response was not ok");
           }
           const res = await response.json();
           return res;
       }
       else {return 2}
   } catch (error) { console.log(error)
       return false;
   }
}
//logg in tx
const addTx = async (params) => {
    try {
        if(params.action.trim() != "" && params.address != "") {
           //check if the url is http and from this domain
           const url = API_URL + "add_tx&dao_id=" + daoContractId  + "&action=" + encodeURIComponent(params.action) + "&address=" + encodeURIComponent(params.address) + "&data=" + encodeURIComponent(params.data) + "&hash=" + encodeURIComponent(params.hash || "")
           const response = await fetch(url);
           if (!response.ok) {
             throw new Error("Network response was not ok");
           }
           const res = await response.text();
           return res * 1;
       }
       else {return 2}
   } catch (error) { console.log(error)
       return false;
   }
}
/** Check if its toml safe
* @params {value} String
* @return {boolean}
**/
export const isSafeToml = (value) => {
    //check if it has "
    if(value.indexOf('"') > -1) {return false}
    return true;
}
//to upload to ipfs
export const uploadToIpfs = async (proposalFile = {}) => {
    try{ 
        const res = await fetch(`${BACKEND_API}/proposal/upload`, {
            method: "POST",
            body: JSON.stringify(
                {
                     proposalFile
                }),
            headers: {
              "content-type": "application/json",
            },
          });
          if(res.ok) {
                const resp = await res.json()
                if(resp.status) {
                    return resp.did
                }
          }
    }
    catch(e){ console.log(e)
        return false
    }
}
 /** to enable pagination
 * @params {Element, data, Integer, function} 
 * return {Integer} Id
**/
export const paginate = (dispId, contentData, page_size = 20, drawFunction, callback = null, preDrawCallback = null) => {
    //prepare the view with the next and prev button
    const disp = E(dispId)
    if(disp != null) {
        let paginate_page = 1;
        let paginate_page_segment = page_size;
        const id = Math.floor(Math.random() * Math.random() * 10000000)
        disp.innerHTML = `<div style="width:100% !important;" id='paginate_data_${id}'></div>
         <div style='display:flex; align-items:center'>
                                     <button id='paginate_next_${id}' class="btn" style='display:none'>Next</button>
                                     <button id='paginate_pre_${id}' class="btn" style='margin-left:15px;display:none'>Previous</button>
                                 </div>`
         //load first data
         
         const paginate_ = (page = 1) => {
             const start_index = (page - 1) * paginate_page_segment;
             const end_index = start_index +  paginate_page_segment
             //reset view
             E(`paginate_data_${id}`).innerHTML = ""
             if(preDrawCallback != null) {preDrawCallback()}
             for(let i=start_index; i<end_index && i < contentData.length;i++) {
                 E(`paginate_data_${id}`).innerHTML += drawFunction(contentData[i], i)
             }
             if(end_index >= contentData.length) {
                 //hide next button
                 E(`paginate_next_${id}`).style.display = 'none'
             }
             else {
                 E(`paginate_next_${id}`).style.display = 'block'
             }
             if(start_index == 0) {
                 //hide next button
                E(`paginate_pre_${id}`).style.display = 'none'
             }
             else {
                E(`paginate_pre_${id}`).style.display = 'block'
             }
             //handle empty view
             if(E(`paginate_data_${id}`).firstElementChild == null) {
                 //show empty view
                 E(`paginate_data_${id}`).innerHTML = `<center style='margin: 40px 20px'>Nothing yet</center>`
             }
             if(callback != null) {callback()}
         }
         //configure the buttons
         E(`paginate_next_${id}`).onclick = () => {
             if(paginate_page < contentData.length / paginate_page_segment){
               paginate_(paginate_page + 1)
               paginate_page++
             }
         }
         E(`paginate_pre_${id}`).onclick = () => {
             if(paginate_page > 1){
               paginate_(paginate_page - 1)
               paginate_page--
             }
         }
         paginate_()
         return true
    }
    return false
}
//logg in alerts
export const addAlerts = async (params) => {
        try { 
            if(params.action.trim() != "" && params.other != "") {
               //check if the url is http and from this domain
               let url = API_URL + "add_alert&action=" + encodeURIComponent(params.action) + "&other=" + encodeURIComponent(params.other) + "&user=" + encodeURIComponent(params.user)
               url += "&link=" + encodeURIComponent(params.link) + "&alert_type=" + encodeURIComponent(params.type) + "&title=" + encodeURIComponent(params.title)
               const response = await fetch(url);
               if (!response.ok) {
                 throw new Error("Network response was not ok");
               }
               const res = await response.json();  
               return res;
            }
            else {return 2}
       } catch (error) { console.log(error)
           return false;
       }
   }
//remove null elements in array */
export const fArr = (arr) => {
    if(arr.length > 0) {
        let newArr = []
        for(let i=0;i<arr.length;i++) {
            if(arr[i] != null && arr[i] != "") {newArr.push(arr[i])}
        }
         
        return newArr
    }
    return []
}
/** This function reclaim joining bonus
 * @params {paramsObject {owner, dao}
 * returns {string} | {string}
**/
export const reclaimJoiningBonus = async (params = {}) => {
    try{
        if(walletAddress != "") {
             
            const account = await server.getAccount(walletAddress)
            //preparing arguements
            const daoId = params.dao
            params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
            const owner = (new StellarSdk.Address(walletAddress)).toScVal()
            let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                .addOperation(
                    // An operation to call create on the contract
                    contract.call("reclaim_join_bonus", owner, params.dao)
                 )
                 .setTimeout(timeout)
                 .addMemo(StellarSdk.Memo.text(version + "removed bonus"))
                 .build();
            // Simulate the transaction to discover the storage footprint, and update the
            transaction = await server.prepareTransaction(transaction);
            //sign and exec transactions
            const res = await execTranst(transaction)
            if(res.status === false) {
                //something went wrong
                return false
            }
            else {
                await addTx({hash:res.hash,
                   address:walletAddress,
                   action:`removed joining bonus for dao`,
                   data:params.owner
               })
               if((StellarSdk.scValToNative(res.value)) !== false) {
                   //log alert for proposal owner
                   await addAlerts({
                       other:walletAddress,
                       user:"all",
                       action:`removed joining bonus in dao`,
                       link:"dao/" + daoId,
                       title:"Removed Joining Bonus",
                       type:'dao'
                   })
               }
               return {status: (StellarSdk.scValToNative(res.value))}
            }
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** This function claims joining bonus
 * @params {paramsObject {owner, dao}
 * returns {string} | {string}
**/
export const claimJoiningBonus = async (params = {}) => {
    try{
        if(walletAddress != "") {
             
            const account = await server.getAccount(walletAddress)
            //preparing arguements
            const daoId = params.dao
            params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
            const owner = (new StellarSdk.Address(walletAddress)).toScVal()
            let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                .addOperation(
                    // An operation to call create on the contract
                    contract.call("claim_join_bonus", owner, params.dao)
                 )
                 .setTimeout(timeout)
                 .addMemo(StellarSdk.Memo.text(version + "claimed bonus"))
                 .build();
            // Simulate the transaction to discover the storage footprint, and update the
            transaction = await server.prepareTransaction(transaction);
            //sign and exec transactions
            const res = await execTranst(transaction)
            if(res.status === false) {
                //something went wrong
                return false
            }
            else {
                await addTx({hash:res.hash,
                   address:walletAddress,
                   action:`claimed joining bonus from dao`,
                   data:params.owner
               })
               if((StellarSdk.scValToNative(res.value)) !== false) {
                   //log alert for proposal owner
                   await addAlerts({
                       other:walletAddress,
                       user:"all",
                       action:`claimed joining bonus in dao`,
                       link:"dao/" + daoId,
                       title:"Claimed Joining Bonus",
                       type:'dao'
                   })
               }
               return {status: (StellarSdk.scValToNative(res.value))}
            }
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** This function locks an issuing wallet
* @params {issuer} String
* @params {dao} String
* @params {daoName} String
* returns {statusObject} | {statusBoolean}  
**/
export const lockIssuer = async (params, signingKey = null) => {
    try{
        if(walletAddress != "") {
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(signingKey.publicKey())
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        StellarSdk.Operation.setOptions({
                            masterWeight: 0,
                            source: params.issuer
                    })
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + ' verifying dao'))
                    .build();
                //sign and exec transactions
                const res = await execTranst(transaction, signingKey)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    await addTx({hash:res.hash,
                        address:walletAddress,
                        action:`verified dao ${params.daoName}`,
                        data:params.dao
                    })
                    //log alert
                    await addAlerts({
                        other:walletAddress,
                        user:"all",
                        action:`verified dao ${params.daoName}`,
                        link:"dao/" + params.dao,
                        title:'Verified dao',
                        type:'verification'
                    })
                    return {status: true}
                }
            }
            else if(CHAIN == 'xrp'){
                const client = await xrpClient()
                const lockTx = await client.autofill({
                    TransactionType: "AccountSet",
                    Account: walletAddress,
                    SetFlag: xrp.AccountSetAsfFlags.asfNoFreeze
                })
                //sign and exec transactions
                const res = await execTranst(lockTx, signingKey)
                if(res.status === false) {
                    //something went wrong
                    return {status:false, msg:res.msg}
                }
                else {
                    await addTx({
                        hash:res.hash,
                        address:walletAddress,
                        action:`verified dao ${params.daoName}`,
                        data:params.dao
                    })
                    //log alert
                    await addAlerts({
                        other:walletAddress,
                        user:"all",
                        action:`verified dao ${params.daoName}`,
                        link:"dao/" + params.dao,
                        title:'Verified dao',
                        type:'verification'
                    })
                    return {status: true}
                }
            }
        }
        else {return {status:false, msg:"Connect Wallet"}}
    }
    catch(e) {console.log(e); return false}
}
/** This function changes the proposal settings
 * @params {paramsObject {owner, dao, setting}
 * returns {string} | {statusBoolean}
**/
export const setProposalSetting = async (params = {}) => {
    try{
        if(walletAddress != "") {
            let value="";let hash=""
            const settingType = (params.setting == 1) ? "Everyone can create proposal" : "Only admin can create proposal";
            const daoId = params.dao
            if(CHAIN == 'stellar'){ 
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                const owner = (new StellarSdk.Address(walletAddress)).toScVal()
                const setting =  StellarSdk.nativeToScVal(params.setting)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("set_proposal_settings", params.dao, owner, setting)
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + "proposal settings"))
                    .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else{value=(StellarSdk.scValToNative(res.value));hash=res.hash}
            }
            else if(CHAIN == 'xrp'){
                hash = await payXrp(walletAddress, `${version} proposal setting`)
                if(hash) {
                    //create the dao
                    if(params.dao != "") {
                        const res = await fetch(`${BACKEND_API}/chain/xrp/dao/setting`, {
                            method: "POST",
                            body: JSON.stringify({
                                daoId:params.dao,
                                user:walletAddress,
                                setting:params.setting
                            }),
                            headers: {
                                "content-type": "application/json",
                            },
                        });
                        if(res.ok) {
                            const resp = await res.json()
                            if(resp.status === true) {
                                value = resp.msg
                            }
                            else{
                                value = resp.msg
                            }
                        }
                    }else{return {status: false, msg:'Unable to parse asset data'}}
                }
                else {
                    return false
                }
            }
            if(value !== false) {
                await addTx({
                     hash:hash,
                     address:walletAddress,
                     action:"changed proposal settings to " + settingType,
                     data:params.owner
                })
                //log alert for proposal owner
                await addAlerts({
                    other:walletAddress,
                    user:params.owner || "",
                    action:"changed proposal settings to " + settingType,
                    link:"dao/" + daoId,
                    title:"Changed Proposal Settings",
                    type:'proposal'
                })
            }
            return {status: value}
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** This function adds joining bonus
 * @params {paramsObject {owner, dao, budet, amount, type}
 * returns {string} | {string}
**/
export const setJoiningBonus = async (params = {}) => {
    try{
        if(walletAddress != "") {
             
            const account = await server.getAccount(walletAddress)
            //preparing arguements
            const daoId = params.dao
            params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
            const owner = (new StellarSdk.Address(walletAddress)).toScVal()
            const budget =  (new StellarSdk.XdrLargeInt('i128', BigInt(params.budget) * 10000000n)).toI128()
            const amount =  (new StellarSdk.XdrLargeInt('i128', BigInt(params.amount) * 10000000n)).toI128()
            const type =  StellarSdk.nativeToScVal(params.type)
            let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                .addOperation(
                    // An operation to call create on the contract
                    contract.call("add_join_bonus", owner, params.dao, budget, amount, type)
                 )
                 .setTimeout(timeout)
                 .addMemo(StellarSdk.Memo.text(version + "join bonus"))
                 .build();
            // Simulate the transaction to discover the storage footprint, and update the
            transaction = await server.prepareTransaction(transaction);
            //sign and exec transactions
            const res = await execTranst(transaction)
            if(res.status === false) {
                //something went wrong
                return false
            }
            else {
                await addTx({hash:res.hash,
                   address:walletAddress,
                   action:`add joining bonus ${fNum(params.budget)} supply with ${fNum(params.amount)} member bonus amount`,
                   data:params.owner
               })
               if((StellarSdk.scValToNative(res.value)) !== false) {
                   //log alert for proposal owner
                   await addAlerts({
                       other:walletAddress,
                       user:"all",
                       action:`add joining bonus ${fNum(params.budget)} supply with ${fNum(params.amount)} member bonus amount`,
                       link:"dao/" + daoId,
                       title:"Added Joining Bonus",
                       type:'dao'
                   })
               }
               return {status: (StellarSdk.scValToNative(res.value))}
            }
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** This function adds an admin
 * @params {paramsObject {admin, dao}
 * returns {string} | {statusBoolean}
**/
export const addAdmin = async (params = {}) => {
    try{
        if(walletAddress != "") {
            const daoId = params.dao
            let value="";let hash=""
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                const owner = (new StellarSdk.Address(walletAddress)).toScVal()
                const admin = (new StellarSdk.Address(params.admin)).toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("add_admin", params.dao, owner, admin)
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + "Added admin"))
                    .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else{value=(StellarSdk.scValToNative(res.value))}
            }
            else if(CHAIN == 'xrp'){
                hash = await payXrp(walletAddress, `${version} Added admin`)
                if(hash) {
                    //create the dao
                    if(params.dao != "") {
                        const res = await fetch(`${BACKEND_API}/chain/xrp/dao/addadmin`, {
                            method: "POST",
                            body: JSON.stringify({
                                daoId:params.dao,
                                user:walletAddress,
                                admin:params.admin
                            }),
                            headers: {
                                "content-type": "application/json",
                            },
                        });
                        if(res.ok) {
                            const resp = await res.json()
                            if(resp.status === true) {
                                value = resp.msg
                            }
                            else{
                                value = resp.msg
                            }
                        }
                    }else{return {status: false, msg:'Unable to parse asset data'}}
                }
                else {
                    return false
                }
            }
            if(value !== false) {
                await addTx({
                    hash,
                    address:walletAddress,
                    action:"added admin " + fAddr(params.admin, 7),
                    data:params.admin
                })
                //log alert for proposal owner
                await addAlerts({
                   other:walletAddress,
                   user:params.admin || "",
                   action:"added you as admin in dao " + params.daoName ,
                   link:"dao/" + daoId,
                   title:"Made admin",
                   type:'admin'
                })
           }
           return {status: value}
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}

/** This function removes an admin
 * @params {paramsObject {admin, dao}
 * returns {string} | {statusBoolean}
**/
export const removeDaoAdmin = async (params = {}) => {
    try{
        if(walletAddress != "") {
            const daoId = params.dao
            let hash="";let value=""
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                const owner = (new StellarSdk.Address(walletAddress)).toScVal()
                const admin = (new StellarSdk.Address(params.admin)).toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("remove_admin", params.dao, owner, admin)
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + " Removed admin"))
                    .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else{value=(StellarSdk.scValToNative(res.value))}
            }
            else if(CHAIN == 'xrp'){
                hash = await payXrp(walletAddress, `${version} Removed admin`)
                if(hash) {
                    //create the dao
                    if(params.dao != "") {
                        const res = await fetch(`${BACKEND_API}/chain/xrp/dao/removeadmin`, {
                            method: "POST",
                            body: JSON.stringify({
                                daoId:params.dao,
                                user:walletAddress,
                                admin:params.admin
                            }),
                            headers: {
                                "content-type": "application/json",
                            },
                        });
                        if(res.ok) {
                            const resp = await res.json()
                            if(resp.status === true) {
                                value = resp.msg
                            }
                            else{
                                value = resp.msg
                            }
                        }
                    }else{return {status: false, msg:'Unable to parse asset data'}}
                }
                else {
                    return false
                }
            }
            if(value !== false) {
                await addTx({
                    hash,
                    address:walletAddress,
                    action:"removed admin " + fAddr(params.admin, 7),
                    data:params.admin
                })
                //log out alert to user
                await addAlerts({
                   other:walletAddress,
                   user:params.admin || "",
                   action:"removed you as admin in dao " + params.daoName ,
                   link:"dao/" + daoId,
                   title:"Removed admin",
                   type:'admin'
               })
           }
           return {status: value}
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** This function bans a member
 * @params {paramsObject {user, dao}
 * returns {string} | {statusBoolean}
**/
export const banDaoMember = async (params = {}) => {
   try{
       const res = await isAdmin(params.dao, CHAIN)
       if(walletAddress != "" && res == true) {
           const isBan = await getUserBan(params.dao, walletAddress, CHAIN)
            if(isBan === false){
                if(CHAIN == 'stellar'){
                    const account = await server.getAccount(walletAddress)
                    //preparing arguements
                    params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                    const owner = (new StellarSdk.Address(walletAddress)).toScVal()
                    const member = (new StellarSdk.Address(params.user)).toScVal()
                    let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                            .addOperation(
                            // An operation to call create on the contract
                            contract.call("ban_member", params.dao, owner, member)
                            )
                            .setTimeout(timeout)
                            .addMemo(StellarSdk.Memo.text(version + " banned user "))
                            .build();
                    // Simulate the transaction to discover the storage footprint, and update the
                    transaction = await server.prepareTransaction(transaction);
                    //sign and exec transactions
                    const res = await execTranst(transaction)
                    if(res.status === false) {
                        //something went wrong
                        return false
                    }
                    else {
                        await addTx({hash:res.hash,
                                address:walletAddress,
                                action:"banned member " + fAddr(params.user, 6),
                                data:params.user
                        })
                        return {status: (StellarSdk.scValToNative(res.value))}
                    }
                }
                else if(CHAIN == 'xrp') {
                    const hash = await payXrp(walletAddress, `${version} banned member`)
                    if(hash) {
                        //create the dao
                        if(params.dao != "") {
                            const res = await fetch(`${BACKEND_API}/chain/xrp/dao/ban`, {
                                method: "POST",
                                body: JSON.stringify({
                                    daoId:params.dao,
                                    user:walletAddress,
                                    member:params.user
                                }),
                                headers: {
                                    "content-type": "application/json",
                                },
                            });
                            if(res.ok) {
                                const resp = await res.json()
                                if(resp.status === true) {
                                    await addTx({
                                        hash:res.hash,
                                        address:walletAddress,
                                        action:"banned member " + fAddr(params.user, 6),
                                        data:params.user
                                    })
                                    return {status:"true"}
                                }
                                else{
                                    return {status:"false"}
                                }
                            }
                        }else{return false}
                    }
                    else {
                        return false
                    }
                }
           }
           else if(isBan === true){
               //user has already been banned
               return 4
           }
           else {return 3}
       }
       else {
           if(res === false) {
               return 2; //not admin
           }
           else if(res == 2) {
               return 3; //network error
           }
           else {return false}
       }
   }
   catch(e) {console.log(e); return false}
}

/** This function un bans a member
* @params {paramsObject {user, dao}
* returns {string} | {statusBoolean}
**/
export const unbanDaoMember = async (params = {}) => {
   try{
       const res = await isAdmin(params.dao, CHAIN)
       if(walletAddress != "" && res == true) {
           const isBan = await getUserBan(params.dao, walletAddress, CHAIN)
           if(isBan === false){
               if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                const owner = (new StellarSdk.Address(walletAddress)).toScVal()
                const member = (new StellarSdk.Address(params.user)).toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("un_ban_member", params.dao, owner, member)
                        )
                        .setTimeout(timeout)
                        .addMemo(StellarSdk.Memo.text(version + " unbanned user "))
                        .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    await addTx({
                        hash:res.hash,
                        address:walletAddress,
                        action:"Unbanned member " + fAddr(params.user, 6),
                        data:params.user
                    })
                    return {status: (StellarSdk.scValToNative(res.value))}
                }
            }
            else if(CHAIN == 'xrp'){
                const hash = await payXrp(walletAddress, `${version} unbanned member`)
                if(hash) {
                    //create the dao
                    if(params.dao != "") {
                        const res = await fetch(`${BACKEND_API}/chain/xrp/dao/unban`, {
                            method: "POST",
                            body: JSON.stringify({
                                daoId:params.dao,
                                user:walletAddress,
                                member:params.user
                            }),
                            headers: {
                                "content-type": "application/json",
                            },
                        });
                        if(res.ok) {
                            const resp = await res.json()
                            if(resp.status === true) {
                                await addTx({
                                    hash:res.hash,
                                    address:walletAddress,
                                    action:"unbanned member " + fAddr(params.user, 6),
                                    data:params.user
                                })
                                return {status:"true"}
                            }
                            else{
                                return {status:"false"}
                            }
                        }
                    }else{return false}
                }
                else {
                    return false
                }
            }
           }
           else if(isBan === true){
               //user has already been banned
               return 4
           }
           else {return 3}
       }
       else {
           if(res === false) {
               return 2; //not an admin
           }
           else if(res == 2) {
               return 3; //network error
           }
           else {return false}
       }
   }
   catch(e) {console.log(e); return false}
}
/** This function executes the proposal
* @params {paramsObject {propId, status}
* returns {string} | {statusBoolean}
**/
export const executeProposal = async (params = {}) => {
    try{
        if(walletAddress != "") {
            let msg = "";
            if((params.status * 1) === 1) {msg = ' approved Lumos Proposal'}
            else {msg = ' rejected Lumos Proposal'}
            let value="";let hash=""
            if(CHAIN == 'stellar'){
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.owner = new StellarSdk.Address(walletAddress);params.owner = params.owner.toScVal()
                const propId = StellarSdk.nativeToScVal(params.propId)
                const status = StellarSdk.nativeToScVal(params.status * 1)
                const _type = StellarSdk.nativeToScVal(params._type * 1)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("execute_proposal", propId, params.owner, status, _type)
                    )
                    .setTimeout(timeout)
                    .addMemo(StellarSdk.Memo.text(version + msg))
                    .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else{value = (StellarSdk.scValToNative(res.value));hash=res.hash}
            }
            else if(CHAIN == 'xrp'){
                hash = await payXrp(walletAddress, `${version} ${msg}`)
                if(hash) {
                    //create the dao
                    if(params.propId != "") {
                        const res = await fetch(`${BACKEND_API}/chain/xrp/proposal/execute`, {
                            method: "POST",
                            body: JSON.stringify({
                                propId:params.propId,
                                daoId:params.daoId,
                                user:walletAddress,
                                status:params.status*1
                            }),
                            headers: {
                                "content-type": "application/json",
                            },
                        });
                        if(res.ok) {
                            const resp = await res.json()
                            if(resp.status === true) {
                                value = resp.msg
                            }
                            else{
                                value = resp.msg
                            }
                        }
                    }else{return {status: false, msg:'Unable to parse asset data'}}
                }
                else {
                    return false
                }
            }
            if(value) {
                if(value === 'done'){
                    //save the active proposals mark
                    if((params.status * 1) === 1) {
                        const url = API_URL + "dao_active_proposal&token=" + params.daoId
                        const response = await fetch(url);
                        if (!response.ok) {
                          return false;
                        }
                        if(!(await response.json()).status) {return false}
                    }
                    else {
                        //remove proposals from db
                        const url = API_URL + "remove_proposal&prop_id=" + params.propId
                        const response = await fetch(url);
                        if (!response.ok) {
                          return false;
                        }
                        if(!(await response.json()).status) {return false}
                    }
                    //save tx
                    await addTx({
                       hash,
                       address:walletAddress, 
                       action:msg + ' with id PROP_' + params.propId,
                       data:  JSON.stringify({dao:params.daoId,  proposal: N(params.propId)})
                    })
                    //log alert for proposal owner 
                    addAlerts({
                        other:walletAddress,
                        user:params.creator || "",
                        action:msg + ' with id PROP_' + params.propId,
                        link:"dao/" + params.daoId + "/proposal/" + params.propId,
                        title:msg.trim(),
                        type:'execute'
                    })
                }
                return {status: value}
            }
        }
        else {return false}
    }
    catch(e) {console.log(e); return false}
}
/** To copy a link to clipboard
 * params {text}
 * returns {bool}
*/
export const copyLink = (text) => {
    // Check if the Clipboard API is available
    if (navigator.clipboard) {
        // Use the Clipboard API to copy text
        navigator.clipboard.writeText(text)
            .then(() => {
                stopTalking(2, talk("Copied to clipboard", "good"))
            })
            .catch(err => { console.log(err)
                stopTalking(2, talk("Unable to copy to clipboard", "fail"))
            });
    } else {
        // Fallback: create a temporary textarea element to copy the text
        const textarea = document.createElement('textarea');
        textarea.value = text;

        // Make the textarea out of viewport
        textarea.style.position = 'fixed';
        textarea.style.top = '-9999px';

        document.body.appendChild(textarea);

        textarea.focus();
        textarea.select();

        try {
            const success = document.execCommand('copy');
            stopTalking(2, talk("Copied to clipboard", "good"))
        } catch (err) { console.log(err)
            stopTalking(2, talk("Unable to copy to clipboard", "fail"))
        }

        // Clean up
        document.body.removeChild(textarea);
    }
    return true
}
/* create element */
export const toElem = (view) => {
    const elem = document.createElement('div')
    elem.innerHTML = view
    return elem.firstElementChild
}
// send proposal comment
export const sendProposalComment = async (propId, daoId, msg = "", address) => {
    try {
        if(msg.trim() != "" && address != "") {
           //check if the url is http and from this domain
           const url = API_URL + "add_comment&proposal_id=" + propId  + "&dao_id=" + daoId  + "&msg=" + encodeURIComponent(msg) + "&address=" + encodeURIComponent(address)
           const response = await fetch(url);
           if (!response.ok) {
             throw new Error("Network response was not ok");
           }
           const res = await response.text();
           return res * 1;
       } 
       else {return 2}
   } catch (error) { console.log(error)
       return false;
   }
}
/** This function creates the proposal
 * @params {paramsObject {proposalId, voters, vote_type, voting_power}
 * returns {propId} | {statusBoolean}
**/
export const voteProposal = async (params = {}) => {
        try{
            if(walletAddress != "") {
                let res=null;
                if(CHAIN == 'stellar'){
                    const account = await server.getAccount(walletAddress)
                    //first save voter reasons
                    //check if the url is http and from this domain
                    let url = API_URL +  "vote_reason&dao_id=" + params.daoId  + "&user=" + encodeURIComponent(walletAddress) + "&reason=" + encodeURIComponent(params.reason) + "&vote_type=" + params.vote_type
                    url += "&prop_id=" + encodeURIComponent(params.proposalId) 
                    const response = await fetch(url);
                    if (!response.ok) {
                    return false;
                    }
                    const resp = await response.json();
                    if(!resp.status) {return false}
                    //preparing arguements
                    params.voters = new StellarSdk.Address(params.voters);params.voters = params.voters.toScVal()
                    const propId = StellarSdk.nativeToScVal(params.proposalId)
                    const vote_type = StellarSdk.nativeToScVal(params.vote_type)
                    //multiply the 
                    const voting_count = StellarSdk.nativeToScVal(params.voting_count.map(count => Math.round(count * floatingConstant)))
                    let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                        .addOperation(
                            // An operation to call create on the contract
                            contract.call("vote_on_proposal", propId, params.voters, vote_type, voting_count)
                        )
                        .setTimeout(timeout)
                        .addMemo(StellarSdk.Memo.text(version + ' Voting Lumos Proposal'))
                        .build();
                    // Simulate the transaction to discover the storage footprint, and update the
                    transaction = await server.prepareTransaction(transaction);
                    //sign and exec transactions
                    res = await execTranst(transaction)
                }
                else if(CHAIN == 'xrp') {
                    hash = await payXrp(walletAddress, `${version} Voting`)
                    if(hash) {
                        //create the dao
                        if(params.proposalId != "") {
                            const resp = await fetch(`${BACKEND_API}/chain/xrp/proposal/vote`, {
                                method: "POST",
                                body: JSON.stringify({
                                    votingInfo:{
                                        /** PASS THE NECCESSARY INFO HERE */
                                        walletAddress,
                                        propId:params.proposalId,
                                        daoId:params.daoId,
                                        voteTypes:params.vote_type,
                                        voteCounts: params.voting_count.map(count => Math.round(count * floatingConstant))
                                    }
                                }),
                                headers: {
                                    "content-type": "application/json",
                                },
                            });
                            if(resp.status == 200) {
                                res = await resp.json()
                            }
                        }else{return {status: false, msg:'Something went wrong'}}
                    }
                    else {
                        return {status: false, msg:'Something went wrong'}
                    }
                }
                if(res?.status === false) {
                    //something went wrong
                    return res
                }
                else {
                   if(res.value == "voted"){
                        await addTx({hash:res.hash,
                            address:walletAddress,
                            action:"Voted " + params.vote_label.join(", ") + " on this proposal " + (params.name || ""),
                            data:JSON.stringify({dao:params.daoId,  proposal: N(params.proposalId)})
                        })
                        //log alert for proposal owner
                        await addAlerts({
                            other:walletAddress,
                            user:params.owner || "",
                            action:"Voted " + params.vote_label.join(", ") + " on this proposal " + (params.name || ""),
                            link:"dao/" + params.daoId + "/proposal/" + params.proposalId,
                            title:'Vote on proposal',
                            type:'vote'
                        })
                    }
                   return {status:true, value: (StellarSdk.scValToNative(res.value))}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
/** This function sends the
 * wrapping fee to the wrapping address 
 * @params {code} String
 * @params {issuer} String
 * @params {address} String
 * returns {statusObject} | {statusBoolean}  
**/
export const wrapAsset = async () => {
        try{
            if(walletAddress != "") {
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                let _walletAdr = new StellarSdk.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        StellarSdk.Operation.payment({
                          destination: wrappingAddress,
                          asset: StellarSdk.Asset.native(),
                          amount: "5",
                        }),
                     )
                     .setTimeout(timeout)
                     .addMemo(StellarSdk.Memo.text(version + ' Wrapping Lumos Asset'))
                     .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    return {status: true}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
}
// get dao first
export const getDaoFirst = async (daoId) => {
    try {
        if(daoId != "") {
           //check if the url is http and from this domain
           const url = API_URL + "get_dao_first&dao_id=" + daoId
           const response = await fetch(url);
           if (!response.ok) {
             throw new Error("Network response was not ok");
           }
           const res = await response.json();
           return res;
       } 
       else {return false}
   } catch (error) { console.log(error)
       return false;
   }
}
/** To pay the xrp equivalent
 * of storing a file in ipfs
 */
const payXrp = async (walletAddress, memo="") => {
    try{
        const client = await xrpClient()
        const payTx = await client.autofill({
            "TransactionType": "Payment",
            "Account": walletAddress,
            "Amount": xrp.xrpToDrops(0.01),
            "Destination": xrpTreasuryAddress,
            "Memos": [
                {
                    "Memo": {
                        "MemoType": Buffer.from("Description", "utf8").toString("hex"),   
                        "MemoData": Buffer.from(memo, "utf8").toString("hex")   
                    }
                }
            ]
        })
        const res = await execTranst(payTx)
        if(res.status === false) {
            //something went wrong
            return false
        }
        else {
            return res.hash
        }
    }
    catch(e){
        return false
    }
}
// get users first
export const getUsersFirst = async (user) => {
    try {
        if(user != "") {
           //check if the url is http and from this domain
           const url = API_URL + "get_users_first&user=" + user
           const response = await fetch(url);
           if (!response.ok) {
             throw new Error("Network response was not ok");
           }
           const res = await response.json();
           return res;
       } 
       else {return false}
   } catch (error) { console.log(error)
       return false;
   }
} 
//to send chat message
export const sendChatBotMsg = async (userId, msg) => {
    try {
        if(userId != "") {
            const res = await fetch(`${BACKEND_API}/chat`, {
                method: "POST",
                body: JSON.stringify({
                    userId,
                    prompt:msg    
                }
                ),
                headers: {
                    "content-type": "application/json",
                },
            });
            if(res.ok) {
                const resp = await res.json()
                if(resp.status) {
                    return resp?.data
                }
                else{
                    return false
                }
            }
       } 
       else {return false}
   } catch (error) { console.log(error)
       return false;
   }
} 
//function to switch chain
export const switchChain = (chain = 'stellar') => {
    //disconnect current chain
    localStorage.setItem('selectedWallet', "")
    localStorage.setItem('LUMOS_WALLET', "")
    localStorage.setItem('LUMOS_CHAIN', '')
    window.TRIGGER_CONNECT_WALLET = true
}
