/**
 * CONTAINS ALL FUNCTIONS NEEDED TO GET THE DAO DATA
**/

import { API_URL, daoContractId, networkUsed, server, fee, wrappingAddress, contract, timeout, TOML_URL, horizonServer, version, networkWalletUsed, BACKEND_API, xrpClient, xrp } from "../data/constant"
import * as StellarSdk from '@stellar/stellar-sdk';
import * as toml from 'toml';
import { stopTalking, talk } from "../components/alert/swal";
 
/**  DAO SPECIFIC INFO
* @params {daoId: Address}
* returns @map | []
**/  
export const getDao =  async (daoId = {}) => {
    if(wrappingAddress != "" && daoId) {
        try{
            //for stellar
            let daoMeta = [];
            if(daoId['stellar'].length > 0){
                const account = await server.getAccount(wrappingAddress)
                //convert to stellar array
                let addr = []; 
                for(let i=0;i<daoId['stellar'].length;i++){
                    addr.push(new StellarSdk.Address(daoId['stellar'][i]))
                }
                addr = StellarSdk.nativeToScVal(addr) 
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_all_dao", addr),
                    )
                    .setTimeout(timeout) //using a time out of a hourf
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                let dao = StellarSdk.scValToNative(transactionMeta.result.retval);
                //fecth the daos data
                daoMeta = await getAlldaoInfo(daoId['stellar'].join(","))
                if(daoMeta !== false && dao.length > 0) { 
                    for(let i=0;i<dao.length;i++) {
                        daoMeta[dao[i].token] = {...(dao[i]), ... daoMeta[dao[i].token]}
                    }
                }
            }
            if(daoId['xrp'].length> 0){
                //fetch the information
                const res = await fetch(`${BACKEND_API}/chain/xrp/dao/all`, {
                    method: "POST",
                    body: JSON.stringify({
                        ids:daoId['xrp'],
                        address:walletAddress,
                      }
                    ),
                    headers: {
                    "content-type": "application/json",
                    },
                });
                if(res.ok) {
                    const resp = await res.json()
                    if(resp.status) {
                        daoMeta = {...daoMeta, ...resp.daoMeta}
                        daoMeta.status = true
                    }
                }
            }
            return daoMeta
        }
        catch(e) {console.log(e);return []}
    }
    else {return []}
}
/**  DAO SPECIFIC INFO
* @params {daoId: Address}
* returns @map | []
**/  
export const getDaoInfo =  async (daoId = [], chain) => {
    if(wrappingAddress != "" && daoId) {  
        try{
            //for stellar
            let daoMeta = []
            if(daoId.length > 0 && chain == 'stellar'){
                const account = await server.getAccount(wrappingAddress)
                //convert to stellar array
                let addr = []; 
                for(let i=0;i<daoId.length;i++){
                    addr.push(new StellarSdk.Address(daoId[i]))
                }
                addr = StellarSdk.nativeToScVal(addr) 
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_all_dao", addr),
                    )
                    .setTimeout(timeout) //using a time out of a hourf
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                let dao = StellarSdk.scValToNative(transactionMeta.result.retval);
                //fecth the daos data
                daoMeta = await getAlldaoInfo(daoId.join(","))
                if(daoMeta !== false && dao.length > 0) { 
                    for(let i=0;i<dao.length;i++) {
                        daoMeta[dao[i].token] = {...(dao[i]), ...daoMeta[dao[i].token]}
                    }
                    return daoMeta
                }
            }
            if(daoId.length > 0 && chain == 'xrp'){ 
                //fetch the off chain information
                const res = await fetch(`${BACKEND_API}/chain/xrp/dao`, {
                    method: "POST",
                    body: JSON.stringify({
                        id:daoId,
                        address:walletAddress,
                      }
                    ),
                    headers: {
                    "content-type": "application/json",
                    },
                });
                if(res.ok) {
                    const resp = await res.json()
                    if(resp.status) {
                        daoMeta = resp.dao
                    }
                }
            }
            return daoMeta
        }
        catch(e) {console.log(e);return []}
    }
    else {return []}
}
/** This function retrieves all proposal info
* @params {propId: [int]}
* returns @map | []
**/ 
export const getAllProposal =  async (propId = [], dao, chain) => {
    if(wrappingAddress != "" && propId.length > 0) {   
        try{
            if(chain == 'stellar'){
                const account = await server.getAccount(wrappingAddress)
                let prop_ids = []; 
                for(let i=0;i<propId.length;i++){
                    prop_ids.push(propId[i])
                }
                prop_ids = StellarSdk.nativeToScVal(prop_ids) 
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_all_proposal", prop_ids)
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                let transactionMeta = (await server.simulateTransaction(transaction))
                const props =  (StellarSdk.scValToNative(transactionMeta.result.retval)); 
                //fecth the daos data
                const propMeta = await getAllPropInfo(propId.join(","), dao)
                if(propMeta !== false && props.length > 0) { 
                    for(let i=0;i<props.length;i++) {
                        propMeta[propId[i]] = {...(props[i]), ... propMeta[propId[i]]}
                    }
                    return propMeta;
                }
                else {return []}
            }
            else if(chain == 'xrp'){
                //fetch the information
                const res = await fetch(`${BACKEND_API}/chain/xrp/proposal/all`, {
                    method: "POST",
                    body: JSON.stringify({
                        ids:propId,
                        address:walletAddress,
                        daoId:dao
                      }
                    ),
                    headers: {
                    "content-type": "application/json",
                    },
                });
                if(res.ok) {
                    const resp = await res.json()
                    if(resp.status) {
                        return resp.props
                    }
                    else{return []}
                }
            }
        }
        catch(e) {console.log(e);return []}
    }
    else {return []}
}
/** This function retrieves
* the DAO GENERAL INFORMATIONS
* returns @map | []
**/ 
export const getDaoMetadata =  async (useCache=false) => { 
    if(useCache) {
        //fetch from cache
        try{return JSON.parse(localStorage.getItem("lumos_dao_metadata") || "{}")  || []}
        catch(e){return false}
    }
    //fecth all chain stats
    try {
        //check if the url is http and from this domain
        const url = BACKEND_API + "/chain/stats" 
        const response = await fetch(url);
        if (!response.ok) {
          return false
        }
        const {status, data} = await response.json(); 
        if(status) {
            localStorage.setItem('lumos_dao_metadata', JSON.stringify(data))
            return data
        } 
    } catch (error) {
        console.log(error)
    }
    return []
}
// get all dao info
export const getAlldaoInfo = async (daos) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_all_dao&all_dao=" + daos + "&user=" + walletAddress + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const dao = await response.json(); 
       return dao
   } catch (error) { console.log(error)
       return false;
   }
}
// get all proposal info
export const getAllPropInfo = async (propIds, daoId) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_all_proposal&all_proposal=" + propIds + "&dao_id=" + daoId + "&user=" + walletAddress + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const dao = await response.json();   
       return dao
   } catch (error) { console.log(error)
       return false;
   }
}
// get all user info
export const getUserInfo = async (addr) => {
    try {
       //check if the url is http and from this domain
       const url = `${API_URL}get_user&user=` + addr + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const res = await response.json();  
       return res
   } catch (error) { 
       return false;
   }
}
/** To format an address to display
* params {_address} the address as string
* params {n} the number of address characters to display
* returns {String}
*/
export const fAddr = (_address, n = 14) => {
    _address += ""
    return _address.substring(0,n) + '...' + _address.substring(_address.length - n)
}
/** To convert  to formatted number
* params {num}
* returns {string}
*/
export const fNum = (num) => {
    num *=  1;
    if(num >= 1000 && num < 1000000) {
        return Math.round(num/1000) + 'k'
    }
    else if(num >= 1000000 && num < 1000000000) {
        return Math.round(num/1000000) + 'M'
    }
    else if(num >= 1000000000) {
        return Math.round(num/1000000000) + 'B'
    }
    else {return num}
}
//check if subdomain exists
export const isSubDomainExists = async (domain) => {
    try {
       const url = API_URL + "subdomain&value=" + domain.replace(/[^a-zA-Z0-9]/g,"").toLowerCase()
       const response = await fetch(url + "&id=" + Math.random() * 1000);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const resp = await response.text();
       if(resp == '1') return true
       return false
   } catch (error) { console.log(error)
       return false;
   }
}
// URL of the Stellar asset's TOML file
export const readAssetToml = async (url, chain='stellar') => {
    try {
       //check if the url is http and from this domain
       if(url.indexOf('http://') > -1 && url.indexOf(TOML_URL) > -1) {
           //using insecure http and from lumos, serve from asset folder
           url = new URL(url);
           url = url.hostname.split('.')[0]; // Get the first part of the hostname
           url = API_URL + "loadtoml&chain=" + chain + "&value=" + url  + "&id=" + Math.random() * 1000
       }
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const tomlContent = await response.text();
       const data = toml.parse(tomlContent);
       if(chain == 'xrp'){
            //reformat it to the standard we understand
            const orgName = data.ORGANIZATION?.name || data?.DOCUMENTATION?.ORG_NAME || "";
            const orgWebsite = data.ORGANIZATION?.website || data?.DOCUMENTATION?.ORG_URL || "";
            // Social media links from TOKENS or ORGANIZATION
            const tokenWeblinks = data.TOKENS?.[0]?.WEBLINKS || [];
            const socialMediaLinks = {
                ORG_TWITTER: tokenWeblinks.find(link => link.url.includes('twitter.com'))?.url || data?.DOCUMENTATION?.ORG_TWITTER || "",
                ORG_INSTAGRAM: tokenWeblinks.find(link => link.url.includes('instagram.com'))?.url || data?.DOCUMENTATION?.ORG_INSTAGRAM || "",
                ORG_DISCORD: tokenWeblinks.find(link => link.url.includes('discord.gg'))?.url || data?.DOCUMENTATION?.ORG_DISCORD || "",
                ORG_TELEGRAM: tokenWeblinks.find(link => link.url.includes('t.me'))?.url || data?.DOCUMENTATION?.ORG_TELEGRAM || "",
                ORG_REDDIT: tokenWeblinks.find(link => link.url.includes('reddit.com'))?.url || data?.DOCUMENTATION?.ORG_REDDIT || ""
            };

            // Add new DOCUMENTATION fields
            data.DOCUMENTATION = {
                ORG_NAME: orgName,
                ORG_URL: orgWebsite || tokenWeblinks.find(link => link.type === "website")?.url || "",
                ...socialMediaLinks
            };
            // Restructure ACCOUNTS to be an array of account addresses
            data.ACCOUNTS = [...(data?.ACCOUNTS || []), ...(data?.ISSUERS || [])];
            data.ACCOUNTS = data.ACCOUNTS.map(account => account.address);
            // Update CURRENCIES field by matching with TOKENS
            if(data.TOKENS){
                data.CURRENCIES = [...(data?.CURRENCIES || []), ...(data?.TOKENS || [])];
                data.CURRENCIES = data.CURRENCIES.map(currency => {
                    const matchingToken = data?.TOKENS.find(token => 
                        token.name === currency.code || token.currency === currency.code
                    );

                    if (matchingToken) {
                        return {
                            ...currency,
                            name: matchingToken?.name,
                            desc: matchingToken?.desc,
                            image: matchingToken?.icon,
                            code:matchingToken?.currency
                        };
                    }
                    return currency;
                });
            }
            console.log(data)
            return data
       }
       else if(chain == 'stellar') return data
   } catch (error) { console.log(error)
       return false;
   }
}
/** To retreive token info
* @params {tokenId}
**/
export const getTokenInfo = async (tokenId, info="name") => {
    if(walletAddress != "") {
        try{
            const account = await server.getAccount(wrappingAddress)
            const contract = new StellarSdk.Contract(tokenId);
            let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                .addOperation(
                    contract.call(info)
                )
                .setTimeout(timeout) //using a time out of a hour
                .build();
            //Simulate the transaction to discover the storage footprint, and update the
            transaction = await server.prepareTransaction(transaction);
            let transactionMeta = (await server.simulateTransaction(transaction))
            return (StellarSdk.scValToNative(transactionMeta.result.retval)); 
        }
        catch(e) {
            console.log(e)
            return false
        }
    }
    else {return false}
}
//get the token info from toml file
export const getTokenTomlInfo = (aToml, code) => { 
    code = code.replace(/[^a-zA-Z0-9]/g,""); 
    for(let i=0; i<aToml.CURRENCIES.length;i++) {
        const cur = aToml.CURRENCIES[i];  
        if(cur.code == code) {
            //have found our code
            return {image: cur.image || "", issuer: cur.issuer || "", name: cur.name || "", desc: cur.desc || ""}
            break;
        }
    }
}
/** To check if an image url is valid
* params {url}
* returns {boolean}
*/
export const isImageURLValid = async (url) => {
    //structure url
    try {
        url = API_URL + "valid_image&value=" + encodeURIComponent(url)
        const response = await fetch(url + "&id=" + Math.random() * 1000);
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        const resp = await response.text();  
        if(resp == '1') return true
        return false
    } catch (error) { console.log(e)
        return false;
    }
}
 // get all tx
export const getTx = async () => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_tx&dao=" + daoContractId + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const tx = await response.text(); 
       return (tx != "") ? JSON.parse(tx) : ""
   } catch (error) { console.log(error)
       return false;
   }
}
// get all Users alerts
export const getAllUserAlerts = async () => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_user_alert&user=" + walletAddress + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const tx = await response.json(); 
       return tx;
   } catch (error) { console.log(error)
       return false;
   }
}
/** To check current user ban status
* params {user: address, dao:address} the address as string
* returns {bool}
*/
export const isBanned = async (dao, user, chain='stellar') => {
    const isBan = await getUserBan(dao, user, chain)
    if(isBan === false) {return false}
    if(isBan === true) { 
        //user has already been banned
        stopTalking(3, talk('Your account has been banned', 'fail'))
    }
    else{
        //user has already been banned
        stopTalking(3, talk('Network error', 'fail'))
    }
    return true
}
/** This function retrieves the user ban info
* @params {dao: Address, user: Address}
* returns @boolean
**/ 
export const getUserBan =  async (dao = "", user = "", chain='stellar') => {
    if(user != "" && dao != null && dao !== "") {   
        try{   
            if(chain=='stellar'){
                const account = await server.getAccount(wrappingAddress)
                let address = new StellarSdk.Address(user);address = address.toScVal()
                dao = new StellarSdk.Address(dao);dao = dao.toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_ban", dao, address)
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                return (StellarSdk.scValToNative(transactionMeta.result.retval)); 
            }
            else if(chain=='xrp'){
                const daoMeta = await getDaoInfo([dao], chain)
                if(daoMeta){
                    return daoMeta[dao].ban_members.includes(user)
                }
            }
        }
        catch(e) {
            console.log(e)
            return 2
        }
    }


    else {return 0}
}
//check if proposal exists
export const isProposalExists = async (proposal, dao) => {
    try {
       const url = API_URL + "proposal&value=" + encodeURIComponent(proposal.replace(/ /g,"")) + "&dao=" + encodeURIComponent(dao.toLowerCase())
       const response = await fetch(url + "&id=" + Math.random() * 1000);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const resp = await response.text();  
       if(resp == '1') return true
       return false
   } catch (error) { 
       return false;
   }
}
//get token user balance
export const getTokenUserBal = async (tokenId, address, chain='stellar') => {
    if(wrappingAddress != "") { 
        try{
            if(chain == 'stellar'){
                const account = await server.getAccount(wrappingAddress)
                const contract = new StellarSdk.Contract(tokenId);
                address = new StellarSdk.Address(address);address = address.toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call('balance', address)
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                let transactionMeta = (await server.simulateTransaction(transaction))
                return (StellarSdk.scValToNative(transactionMeta.result.retval)); 
            }
            else if(chain == 'xrp') {
                //get the user balance of a token
                const client = await xrpClient()
                const response = await client.request({
                    command: 'account_lines',
                    account: address
                });
                if(response){ 
                    const assetLine = response?.result?.lines || []
                    for(let i=0;i<assetLine.length;i++){
                        const assetHash = await Hash(`${assetLine[i].currency}:${assetLine[i].account}`)
                        if(assetHash == tokenId){
                            return Number(Math.abs(assetLine[i].balance))
                        }
                    } 
                }
            }
        }
        catch(e) {
            return 0
        }
    }
    else {return 0}
}
//check if user is a memeber of the dao
export const isMember = async (tokenId, address, chain='stellar') => {
    if(wrappingAddress != "") { 
        try{
            let resp = false
            if(chain == 'stellar'){
                const account = await server.getAccount(wrappingAddress)
                const contract = new StellarSdk.Contract(tokenId);
                address = new StellarSdk.Address(address);address = address.toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call('balance', address)
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                let transactionMeta = (await server.simulateTransaction(transaction))
                resp =  (StellarSdk.scValToNative(transactionMeta.result.retval)); 
            }
            else if(chain == 'xrp') {
                //get the user balance of a token
                const client = await xrpClient()
                const response = await client.request({
                    command: 'account_lines',
                    account: address
                });
                if(response){
                    const assetLine = response?.result?.lines || []
                    for(let i=0;i<assetLine.length;i++){
                        const assetHash = await Hash(`${assetLine[i].currency}:${assetLine[i].account}`)
                        if(assetHash == tokenId){
                            resp = Number(Math.abs(assetLine[i].balance))
                            break;
                        }
                    } 
                }
            }
            //get dao off chain info
            const daoMeta = await getAlldaoInfo([tokenId])
            if(daoMeta[tokenId]['joined'] == true && resp !== false){
                return true;
            }
        }
        catch(e) {
            return false
        }
    }
    else {return false}
}
// get all Users tx
export const getAllUsersTx = async (address) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_user_tx&dao=" + daoContractId + "&address=" + address + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const tx = await response.text(); 
       return (tx != "") ? JSON.parse(tx) : ""
   } catch (error) { console.log(error)
       return false;
   }
}
// get all Users Chats
export const getAllChats = async (userId) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_chat&uid=" + userId + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const chat = await response.json(); 
       return chat
   } catch (error) { console.log(error)
       return false;
   }
}
// get user dao meta
export const getUserMeta = async (addr) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_user_meta&user=" + addr + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const user = await response.json();  
       return user
   } catch (error) { console.log(error)
       return false;
   }
}
/* Get Joined dao membership date */
export const getDaoJoinedDate = async (_address) => {
    try {
        const tx = await getAllUsersTx(_address)
        if(tx.length > 0){
             for(let i=tx.length-1;i>-1;i--){
                 if(tx[i]){
                    const act = JSON.parse(tx[i])['action'].toLowerCase()
                    if(act.indexOf('created lumos dao') > -1 || act.indexOf('joined')){
                        //get the date
                        return new Date(JSON.parse(tx[i])['date']).toLocaleDateString()
                    }
                 }
             }
        }
        return ""
   } catch (error) { console.log(error)
       return [0, []];
   }
}
//return proposal comment number
export const getCommentNum = async (_address) => {
    try {
       const response = await fetch(API_URL + `wallets_comment&address=` + _address + "&id=" + Math.random());
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       let comt_act = await response.text() * 1;
       return comt_act
   } catch (error) { console.log(error)
       return 0;
   }
}
/** This function retrieves proposal info
 * @params {propId: int}
 * returns @map | []
**/ 
export const getProposal =  async (propId) => {
    if(wrappingAddress != "" && propId != undefined && propId !== 0) {   
        try{
            const account = await server.getAccount(wrappingAddress)
            let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                .addOperation(
                    contract.call("get_proposal", (StellarSdk.nativeToScVal(propId)))
                )
                .setTimeout(timeout) //using a time out of a hour
                .build();
            //Simulate the transaction to discover the storage footprint, and update the
            let transactionMeta = (await server.simulateTransaction(transaction))
            return (StellarSdk.scValToNative(transactionMeta.result.retval)); 
        }
        catch(e) {
          //  console.log(e)
            return []}
    }
    else {return []}
}
/** This function retrieves the proposal specific voter info
 * @params {propId: int}
 * returns @map | []
**/ 
export const getProposalVoterInfo =  async (propId, address) => {
    if(wrappingAddress != "" && propId != undefined && propId !== 0) {   
        try{  
            const account = await server.getAccount(wrappingAddress)
            address = new StellarSdk.Address(address);address = address.toScVal()
            let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                .addOperation(
                    contract.call("get_vote_type_proposal", (StellarSdk.nativeToScVal(propId)), address)
                )
                .setTimeout(timeout) //using a time out of a hour
                .build();
            //Simulate the transaction to discover the storage footprint, and update the
            let transactionMeta = (await server.simulateTransaction(transaction))
            return (StellarSdk.scValToNative(transactionMeta.result.retval)); 
        }
        catch(e) {
            console.log(e)
            return []}
    }
    else {return []}
}
//get comments for a user
export const getUserComment = async (address) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "user_comment&address=" + address + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const commt = await response.text();   
       return (commt != "") ? JSON.parse(commt) : ""
   } catch (error) { console.log(error)
       return false;
   }
}
/** This function retrieves the user delegatee info
* @params {dao: Address}
* returns @map | []
**/ 
export const getDaoDelegatee =  async (dao = "", user = "", chain='stellar') => {
    if(user != "" && dao != null && dao !== "") {   
        try{  
            if(chain=='stellar'){ 
                const account = await server.getAccount(wrappingAddress)
                let address = new StellarSdk.Address(user);address = address.toScVal()
                dao = new StellarSdk.Address(dao);dao = dao.toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_delegatee", dao, address)
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                let transactionMeta = (await server.simulateTransaction(transaction))
                return (StellarSdk.scValToNative(transactionMeta.result.retval)); 
            }
            else if(chain=='xrp'){
                const res = await fetch(`${BACKEND_API}/chain/xrp/dao/delegatee`, {
                    method: "POST",
                    body: JSON.stringify({
                        daoId:dao,
                        delegator:user,
                      }
                    ),
                    headers: {
                    "content-type": "application/json",
                    },
                });
                if(res.ok) {
                    const resp = await res.json()
                    if(resp.status) {
                        return resp.delegatee
                    }
                }
            }
        }
        catch(e) {
            //console.log(e)
            return false
        }
    }
    else {return false}
    return false;
}
/* Get user joined dao number  */
export const getDaoJoinedWithInfo = async (_address) => {
    try {
       const response = await fetch(API_URL + `get_user_join_daometa&user=` + _address + "&dao_id=" + daoContractId);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       let daos = await response.json(); 
       if(daos.status) {
           return [daos['daos'].length, daos['daos']]
       }
       else {return [0, []]}
   } catch (error) { console.log(error)
       return [0, []];
   }
}
/**  DAO SPECIFIC INFO WITHOUT META
 * @params {daoId: Address}
 * returns @map | []
**/ 
export const getDaoWithoutMeta =  async (daoId = [], chain='stellar') => {
    if(wrappingAddress != "" && daoId.length > 0) {
        try{
            if(chain == 'stellar'){
                const account = await server.getAccount(wrappingAddress);
                //convert to stellar array
                let addr = []; 
                for(let i=0;i<daoId.length;i++){
                    addr.push(new StellarSdk.Address(daoId[i]))
                }
                addr = StellarSdk.nativeToScVal(addr) 
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_all_dao", addr),
                    )
                    .setTimeout(timeout) //using a time out of a hourf
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                let transactionMeta = (await server.simulateTransaction(transaction))
                const dao = StellarSdk.scValToNative(transactionMeta.result.retval);
                return dao
            }
            else if(chain =='xrp') {
                const res = await fetch(`${BACKEND_API}/chain/xrp/dao/all`, {
                    method: "POST",
                    body: JSON.stringify({
                        ids:daoId,
                        address:walletAddress,
                      }
                    ),
                    headers: {
                    "content-type": "application/json",
                    },
                });
                if(res.ok) {
                    const resp = await res.json()
                    if(resp.status) {
                        return [resp.daoMeta[daoId[0]]]
                    }
                }
            }
        }
        catch(e) {
            console.log(e)
            return []}
    }
    else {return []}
    return []
}
// get dao users by dao name
export const getDaoUsersP = async (daoName) => { 
    try {
        let num = 0; let joiners = []
        const tx = await getUserTx();  
        daoName = daoName.toLowerCase()
        for(let i=0;i<tx.length;i++) {
            tx[i] = JSON.parse(tx[i])
            if(tx[i].action.toLowerCase().indexOf(daoName) > -1) {
                if(tx[i].action.toLowerCase().indexOf('joined dao') > -1 || tx[i].action.toLowerCase().indexOf('create new dao') > -1){
                   //add
                   joiners.push(tx[i].user)
                }
                else if(tx[i].action.toLowerCase().indexOf('left dao') > -1) {
                   joiners[joiners.indexOf(tx[i].signer)] = ""
                }
            }
        }
        let j = []
        //loop through and remove duplicates
        for(let i=0;i<joiners.length;i++) {
            if(!j.includes(joiners[i])) {
                j.push(joiners[i])
            }
        }
        return j
   } catch (error) { console.log(error)
       return 0;
   }
}
// get all dao delegates
export const getAllDelegates = async (dao) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_dao_delegates&dao=" + dao + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const del = await response.json();  
       return del['delegates']
   } catch (error) { console.log(error)
       return false;
   }
}
// get if an account has been locked
export const getLocked = async (address, chain) => { 
    try { 
        if(chain == 'stellar'){
            //check if the url is http and from this domain
            const response = await fetch(`${horizonServer}/accounts/${address}`);
            if (response.ok) {
                const resp = await response.json()
                //get the signers
                if(resp.signers) {
                    for(let i=0;i<resp.signers.length;i++) {
                        if(resp.signers[i].key == address) {
                            return (resp.signers[i].weight == 0) ? true : false;
                        }
                    }
                } 
            }
        }
        else if(chain == 'xrp') {
            // Get the account info
            const client = await xrpClient()
            const accountInfo = await client.request({
                command: "account_info",
                account: address,
                ledger_index: "validated"
            });
            // Extract flags
            const flags = accountInfo.result.account_flags;
            // Check if the asfNoFreeze flag is set
            return flags.noFreeze;
        }
   } catch (error) { console.log(error)
       return false;
   }
}
//calculate voting power of an address
export const getMarketCap = async (asset = {}) => {
    //get the holders score
    const url = ((asset.chain=='stellar')?API_URL + `asset_info&`:BACKEND_API+'/chain/xrp/asset/info?') + (`code=${asset.code}&issuer=${asset.issuer}&network=${networkWalletUsed.toLowerCase()}`)
    try{
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const res = await response.json()
        return res;
    } catch (error) { console.log(error)
        return false;
    }
}
// get all tx
export const getUserTx = async (addr) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_dao_users&dao=" + daoContractId + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const tx = await response.text();  
       return (tx != "") ? JSON.parse(tx) : ""
   } catch (error) { console.log(error)
       return false;
   }
}
// get dao users
export const getUsersDao = async (dao) => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_users_dao&dao=" + dao + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       return ((await response.json())['user']).filter(value => value !== null && value !== undefined && value !== '');  
   } catch (error) { console.log(error)
       return false;
   }
}
//check if user is an admin
export const isAdmin = async (daoId = "", chain='stellar') => {
    //structure url
    if(walletAddress != "" && daoId != "") {
        try{
            if(chain == 'stellar'){
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
                if(dao['admins'] != undefined) { 
                    return dao.admins.includes(walletAddress) || dao.owner == walletAddress
                }
                else {return false}
            }
            else if(chain == 'xrp') {
                const dao = (await getDaoInfo([daoId], chain))[daoId]
                if(dao['admins'] != undefined) { 
                    return dao.admins.includes(walletAddress) || dao.owner == walletAddress
                }
                else {return false}
            }
        }
        catch(e) {return 2}
    }
    else {return 2}
}
// get all users
export const getAllDaoUsers = async () => { 
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_all_dao_users&dao_id=" + daoContractId + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const res = await response.json();  
       return res || []
   } catch (error) { console.log(error)
       return [];
   }
}
/** This function retrieves group proposal info
* @params {propId, voter, dao}
* returns @map | []
**/ 
export const getProposalGroupInfo =  async (params = {}) => {
     if(wrappingAddress != "") {   
         try{
             const account = await server.getAccount(wrappingAddress)
             params.propId = StellarSdk.nativeToScVal(params.propId),
             params.dao = StellarSdk.nativeToScVal((new StellarSdk.Address(params.dao)))
             params.voter = StellarSdk.nativeToScVal((new StellarSdk.Address(params.voter)))
             let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                 .addOperation(
                     contract.call("get_proposal_user_group_info", params.propId, params.voter, params.dao)
                 )
                 .setTimeout(timeout) //using a time out of a hour
                 .build();
             //Simulate the transaction to discover the storage footprint, and update the
             let transactionMeta = (await server.simulateTransaction(transaction))
             return (StellarSdk.scValToNative(transactionMeta.result.retval)); 
         }
         catch(e) {
           //  console.log(e)
             return []}
     }
     else {return []}
}
// get comments for a proposal
export const getProposalComment = async (propId, dao = "") => {
    try {
       //check if the url is http and from this domain
       const url = API_URL + "get_comment&proposal_id=" + propId  + "&dao=" + dao + "&id=" + Math.random() * 1000 
       const response = await fetch(url);
       if (!response.ok) {
         throw new Error("Network response was not ok");
       }
       const commt = await response.text();  //console.log(commt, propId, dao)
       return (commt != "") ? JSON.parse(commt) : ""
   } catch (error) { console.log(error)
       return false;
   }
}
/** @params {propId: int}
* returns @map | []
**/ 
export const getProposalVotersInfo =  async (propId, dao) => {
   if(wrappingAddress != "" && propId != undefined && propId !== 0) {   
       try{
            
           const account = await server.getAccount(wrappingAddress)
           let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
               .addOperation(
                   contract.call("get_proposal_voters", (StellarSdk.nativeToScVal(propId)))
               )
               .setTimeout(timeout) //using a time out of a hour
               .build();
           //Simulate the transaction to discover the storage footprint, and update the
           let transactionMeta = (await server.simulateTransaction(transaction))
           let res = (StellarSdk.scValToNative(transactionMeta.result.retval)); 
           if(res.length > 0) {
               let voters = ""
               for(let i=0;i<res.length;i++) {
                   voters += res[i].voter + ","
               }
               //fetch all the voters reasons
               const url =  API_URL + "get_all_vote&all_voters=" + voters + "&dao_id=" + dao + "&prop_id=" + propId
               const response = await fetch(url);
               if (!response.ok) {
                 throw new Error("Network response was not ok");
               }
               const resp = await response.json();  
               if(resp.status) {
                   for(let i=0;i<res.length;i++) {
                       res[i] = {...(res[i]), ...resp[res[i].voter]}
                   }
                   return res;
               }   
               else {return []}
           }
           else {return []}
       }
       catch(e) {
           console.log(e)
           return []}
   }
   else {return []}
}
//calculate voting power of an address
export const getVotingPower = async (asset = {}, address, total_voter = []) => {
        //get the holders score
        const url = `https://api.stellar.expert/explorer/${networkWalletUsed.toLowerCase()}/asset/${asset.asset.toUpperCase() +'-' + asset.address}/position/${address}`
        try{
                let holder_pos;let response;
                if(address != asset.issuer) {
                response = await fetch(API_URL + `asset_holder&chain=${CHAIN}&url=` + encodeURIComponent(url));
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                    }
                    holder_pos = await response.text() * 1;//console.log(holder_pos)
                }
                else {
                    holder_pos = 1; //making issuer account be in top 1 automatically
                }
                //calculate holders rank
                if(holder_pos >= 1 && holder_pos <= 5) {holder_pos = 5}
                else if(holder_pos >= 6 && holder_pos <= 50) {holder_pos = 4}
                else if(holder_pos >= 51 && holder_pos <= 100) {holder_pos = 3}
                else if(holder_pos >= 101 && holder_pos <= 500) {holder_pos = 2}
                else {holder_pos = 1}
                
                //calculate activity using proposal
                let act_pos = 1;
                for(let i=0;i<total_voter.length;i++) {
                    if(total_voter[i].voter == address) {
                        if(total_voter[i].vote > 1 && total_voter[i].vote <= 5){act_pos = 2}
                        else if(total_voter[i].vote > 5 && total_voter[i].vote <= 25){act_pos = 3}
                        else if(total_voter[i].vote > 25 && total_voter[i].vote <= 50){act_pos = 4}
                        else if(total_voter[i].vote > 50){act_pos = 5}
                        break;
                    }
                }
                //using comment
                response = await fetch(API_URL + `wallet_comment&address=` + address + "&dao_id=" + asset.dao + "&id=" + Math.random());
                if (!response.ok) {
                throw new Error("Network response was not ok");
                }
                let comt_act = await response.text() * 1;  
                if(comt_act < 1) {comt_act = 1}
                else if(comt_act >= 1 && comt_act <= 25) {comt_act = 2}
                else if(comt_act >= 26 && comt_act <= 100) {comt_act = 3}
                else if(comt_act >= 101 && comt_act <= 500) {comt_act = 4}
                else {comt_act = 5}
                //calculate the average
                act_pos = (act_pos + comt_act) / 2
                //get the age
                response = await fetch(API_URL + `wallet_age&chain=${CHAIN}&address=` + address);
                if (!response.ok) {
                throw new Error("Network response was not ok");
                }
                let age_pos = await response.text() * 1; 
                if(age_pos < 1) {age_pos = 5}
                else if(age_pos >= 1 && age_pos <= 6) {age_pos = 2}
                else if(age_pos >= 6 && age_pos <= 12) {age_pos = 3}
                else if(age_pos >= 12 && age_pos <= 24) {age_pos = 4}
                else {age_pos = 5}
                //get no of trades
                response = await fetch(API_URL + `wallet_trade&chain=${CHAIN}&address=` + address);
                if (!response.ok) {
                throw new Error("Network response was not ok");
                }
                let trade_pos = await response.text() * 1; 
                if(trade_pos < 1) {trade_pos = 1}
                else if(trade_pos >= 1 && trade_pos <= 100) {trade_pos = 2}
                else if(trade_pos >= 101 && trade_pos <= 500) {trade_pos = 3}
                else if(trade_pos >= 501 && trade_pos <= 1000) {trade_pos = 4}
                else {trade_pos = 5}
                
                //fetch user xlm balances
                response = await fetch(API_URL + `xlm_usd&chain=${CHAIN}&address=` + address);
                if (!response.ok) {
                throw new Error("Network response was not ok");
                }   
                let xlm_act = await response.text() * 1;
                if(xlm_act >= 0 && xlm_act <= 50) {xlm_act = 1}
                else if(xlm_act >= 51 && xlm_act <= 100) {xlm_act = 2}
                else if(xlm_act >= 101 && xlm_act <= 500) {xlm_act = 3}
                else if(xlm_act >= 501 && xlm_act <= 1000) {xlm_act = 4}
                else {xlm_act = 5}
                
                //do the overall calculation
                const wal_act = (age_pos + trade_pos + xlm_act) / 3
                const res =  ((0.5 * holder_pos) + (0.25 * act_pos) + (0.25 * wal_act))
                if(((res % 1) + "").length > 7) return res.toFixed(5)
                return res
        } catch (error) { 
            return false;
        }
}
/** This function retrieves the voter delegation info
 * @params {dao: Address}
 * @params {voter: Address}
 * returns @map | []
**/ 
export const getDaoDelegators =  async (dao = "", voter = "",chain='stellar') => {
    if(voter != "" && dao != null && dao !== "") {   
        try{  
            if(chain=='stellar'){
                const account = await server.getAccount(wrappingAddress)
                let address = new StellarSdk.Address(voter);address = address.toScVal()
                dao = new StellarSdk.Address(dao);dao = dao.toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_delegator", dao, address)
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                return (StellarSdk.scValToNative(transactionMeta.result.retval)); 
            }
            else if(chain=='xrp'){
                const res = await fetch(`${BACKEND_API}/chain/xrp/dao/delegator`, {
                    method: "POST",
                    body: JSON.stringify({
                        daoId:dao,
                        delegatee:voter,
                      }
                    ),
                    headers: {
                    "content-type": "application/json",
                    },
                });
                if(res.ok) {
                    const resp = await res.json()
                    if(resp.status) {
                        return resp.delegators
                    }
                }
            }
        }
        catch(e) {
            console.log(e)
            return false
        }
    }
    else {return false}
    return false
}
/** To hash a string
 * @params {value}
 * @returns {hash}
 */
export const Hash = async (value) => {
    const encoder = new TextEncoder();
    const data = encoder.encode(value);
  
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}
/** To validate a document file
* params {file} A file object
* returns {boolean}
*/
export const isDocument = (file) => {
    // You can customize this based on the document file types you want to support
    return (
        file.type.startsWith('application/pdf') ||
        file.type.startsWith('application/msword') ||
        file.type.startsWith('application/vnd.openxmlformats-officedocument.wordprocessingml.document') ||
        file.type.startsWith('text/plain') ||
        file.type.startsWith('application/rtf') ||
        file.type.startsWith('application/vnd.ms-excel') ||
        file.type.startsWith('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') ||
        file.type.startsWith('application/vnd.ms-powerpoint') ||
        file.type.startsWith('application/vnd.openxmlformats-officedocument.presentationml.presentation')
    );
}
//to know which chain it was done
export const isChain = (signer="") => {
    //check for stellar
    if(signer != ""){
        if(signer.charAt(0) == "G" && signer.length == 56) {return 'stellar'}
        if(signer.charAt(0) == "r" && signer.length == 33) {return 'xrp'}
    }
}
//reddit oauth url
export const getRedditOauthUri = (dao, domain) => {
    const clientId = process.env.NEXT_PUBLIC_REDDIT_CLIENT_ID;
    const redirectUri = 'https://testing.lumosdao.io/.well-known/asset.php?type=reddit_auth';
    const scopes = ['identity', 'read'];
    const randomString = dao + ":" + domain
    const authUrl = `https://www.reddit.com/api/v1/authorize?client_id=${clientId}&response_type=code&state=${randomString}&redirect_uri=${encodeURIComponent(redirectUri)}&duration=permanent&scope=${scopes.join('+')}`;
    return authUrl
}
//github oauth url
export const getGithubUri = (user) => {
    const redirectURI = 'https://lumosdao.io/.well-known/asset.php?type=user_github_auth'
    const authURL = `https://github.com/login/oauth/authorize?client_id=${process.env.NEXT_PUBLIC_GITHUB_CLIENT_ID}&redirect_uri=${redirectURI}&state=${user}&scope=user`;
    return authURL;
}

export const formatDate = (date=new Date()) => {
    const day = date.getDate();
    const month = date.toLocaleString('en-US', { month: 'long' });
    const year = date.getFullYear();

    // Determine the ordinal suffix
    const suffix = (day % 10 === 1 && day !== 11) ? "st" :
                   (day % 10 === 2 && day !== 12) ? "nd" :
                   (day % 10 === 3 && day !== 13) ? "rd" : "th";

    return `${day}${suffix} ${month}, ${year}`;
};

export const getVotingResults = (arrayA, objB) => {
    const totalVotes = arrayA.reduce((sum, entry) => sum + Number(entry.voting_count), 0);
    const objBs = JSON.parse(objB)
  
    return arrayA.map(entry => {
      const optionLabel = objBs[entry.id.toString()] || "Unknown";
      const votePercentage = totalVotes > 0 ? (Number(entry.voting_count) / totalVotes) * 100 : 0;
      return { option: optionLabel, percentage: votePercentage.toFixed(2) + "%" };
    });
  }