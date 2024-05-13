<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/soroban-client/1.0.0-beta.4/soroban-client.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/stellar-sdk/11.3.0/stellar-sdk.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/stellar-freighter-api/1.7.1/index.min.js" async></script>
<script type="module"> import n from 'https://cdn.jsdelivr.net/npm/toml@3.0.0/+esm' ; window.toml = n</script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script src="https://kit.fontawesome.com/1b9091d672.js" crossorigin="anonymous" async></script>
<script>

    @if (isset($_COOKIE['wallet']))
        var wallet = "{{ $_COOKIE['wallet'] }}";
    @else
        var wallet = null;
    @endif
    var base_url = "@php echo url('/') @endphp";
    const E = (id) => {return document.getElementById(id)}
</script>
<script>
 

    /**
     * CONTAINS ALL FUNCTIONS NEEDED TO INTERACT WITH THE DAO VIA 
     * THE FREIGHTER EXTERNAL WALLET PROVIDER USED
     **/
    const stellarServer = "https://soroban-testnet.stellar.org"
    const daoContractId = 'CBXYXKX4TY6MGPF4RXRLBRDWKG4ZINQ7ZD7E6A26O4BQL724XW3NMOJL'  
    const wrappingAddress = 'GC5JKOC7OMSS22NVC23MVL2363QS5JO7SQM5X7C7DPVLQLFQHZ3ZRHGF'
    const networkUsed = StellarSdk.Networks.TESTNET
    const networkWalletUsed = "TESTNET"
    const contract = new StellarSdk.Contract(daoContractId);
    const timeout = 86400 //using a timeout of one day
    const fee = 100;
    const floatingConstant = 1E10;
    const version = 'v1.0'
    const S = SorobanClient;
    SorobanClient = StellarSdk.SorobanRpc
    const server = new SorobanClient.Server(stellarServer);
    const API_URL = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type="
    /* SOCIAL MEDIA AUTH KEYS */
    const REDDIT_CLIENT_ID = 'aR5bt1khN1rgRWq6eW9Uzw'
    const LINKEDIN_CLIENT_ID = '77k00ndkottff0'
    const GITHUB_CLIENT_ID = '2a8b021c17c97e2ef0ee'
                        
    @if (isset($_COOKIE['wallet']))
        const walletAddress = "{{ $_COOKIE['public']  }}" //; 
        //const walletKey = "SDWGPCFEKAPULQCQGT34CZKE3MOYTUK2PIMAO62KCR4JCTZMTSH7DEED"
    @else
        const walletAddress = ""
    @endif
 
    //SETTER FUNCTION
    //'GAND2QCNSNCRIQELQIB7FJU6XETRMCV7EW3PAJEIEM2IEITT7SQOF5WW' TESTING PURPOSES
            
    /** This function increase a contract lifetime by a year
     * @params {address}
     * returns {statusObject} | {statusBoolean}
    **/
    const bumpContractInstance =  async (address) => {
      address = S.Address.fromString(address);
      console.log('bumping contract instance: ', address.toString());
      const contractInstanceXDR = S.xdr.LedgerKey.contractData(
        new S.xdr.LedgerKeyContractData({
          contract: address.toScAddress(),
          key: S.xdr.ScVal.scvLedgerKeyContractInstance(),
          durability: S.xdr.ContractDataDurability.persistent(),
        })
      );
      const bumpTransactionData = new S.xdr.SorobanTransactionData({
        resources: new S.xdr.SorobanResources({
          footprint: new S.xdr.LedgerFootprint({
            readOnly: [contractInstanceXDR],
            readWrite: [],
          }),
          instructions: 0,
          readBytes: 0,
          writeBytes: 0,
        }),
        refundableFee: S.xdr.Int64.fromString('0'),
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        ext: new S.xdr.ExtensionPoint(0),
      });

      const txBuilder = await createTxBuilder();
      txBuilder.addOperation(S.Operation.bumpFootprintExpiration({ ledgersToExpire: 100000 })); // 1 year 535670
      txBuilder.setSorobanData(bumpTransactionData);
      const result = await invokeTransaction(txBuilder.build(), false, () => undefined);
      return result;
    }
    
    /** This list of functions deploy a new asset
     * @params {assetCode}
     * returns {statusObject {status, assetId}} | {statusBoolean}
    **/
    const deployStellarAsset = async (asset) => {
        try{
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
             () => undefined
           );
            
           if(res.status) {
               res.value = StellarSdk.scValToNative(res.value)
               //save the tx first
               await addTx({
                   address:walletAddress,
                   action:"Create new Stellar Asset (" + asset.code + ")",
                   data:'dao/' + contractId,
                   hash:res.hash
               })
           }
           return res
        }
        catch(e) {
            console.log(e)
            return false
        }
     }
    const invokeAndUnwrap = async (operation, parse) => {
      const result = await invoke(operation, false, parse); 
      return result;
    }
    const invoke = async (operation,sim,parse) => {
      const txBuilder = await createTxBuilder();
      if (typeof operation === 'string') {
        operation = S.xdr.Operation.fromXDR(operation, 'base64');
      }
      txBuilder.addOperation(operation);
      const tx = txBuilder.build();
      return invokeTransaction(tx, sim, parse);
    }
    const createTxBuilder = async () => {
      try {
          
        const account = await server.getAccount(walletAddress)
        return new S.TransactionBuilder(account, {
          fee: '10000',
          networkPassphrase: networkUsed
        }).setTimeout(timeout);
      } catch (e) {
        console.error(e);
        throw Error('unable to create txBuilder');
      }
    }
    const invokeTransaction = async(tx, sim, parse) => {
      
      const hash = tx.hash().toString('hex');
      const simulation_resp = await server.simulateTransaction(tx);
      if (sim || S.SorobanRpc.isSimulationError(simulation_resp)) {
        // allow the response formatter to fetch the error or return the simulation results
        return {status:false, msg:'simulation fail'};
      }
      const prepped_tx = S.assembleTransaction(tx, networkUsed, simulation_resp).build();
      return await exeTranst(prepped_tx)
    }
     
    /** For asset deployment only **/
    const exeTranst = async (transaction = "") => {
        if(transaction !== "") {
            //prepare xdr
             
            let xdr = await transaction.toXDR();
            try {
                if(wallet.toLowerCase() == "freighter" || wallet.toLowerCase() == 'frighter') xdr = await window.freighterApi.signTransaction(xdr, networkWalletUsed) //sign with freighter
                if(wallet.toLowerCase() == "rabet") xdr = window.rabet.sign(xdr, networkWalletUsed.toLowerCase())
                if(wallet.toLowerCase() == "albedo") xdr = window.albedo.tx({xdr:xdr, network:networkWalletUsed.toLowerCase()})
                if(wallet.toLowerCase() == "xbull") xdr = window.sign({xdr:xdr})
                
                //recreate signed transaction
                transaction = new S.Transaction(xdr, networkUsed)
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
                    return {status:true, value: returnValue, hash:sendResponse.hash}
                  } else {  
                    return {status:false}
                  }
                } else {
                   return {status:false}
                }
          } catch (err) {
            // Catch and report any errors we've thrown
            console.log("Sending transaction failed", err);
            return {status:false}
        }
    }
    }
   
    /** This function creates trustline
     * @params {code} String
     * @params {issuer} String
     * @params {address} String
     * returns {statusObject} | {statusBoolean}
    **/
    const createTrustline = async (code, issuer, address, daoName = "", daoId = "") => {
        try{
            if(walletAddress != "") {
                 
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
                    await addTx({
                       address:walletAddress,
                       action:"Joined DAO " + daoName,
                       data: 'dao/' + daoId,
                       hash:res.hash
                   })
                   return {status: true}
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
    const removeTrustline = async (code, issuer, address, daoName = "", daoId = "") => {
        try{
            if(walletAddress != "") {
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
                      address:walletAddress,
                      action:"Left DAO " + daoName,
                      data: 'dao/' + daoId,
                      hash:res.hash
                  })
                    return {status: true}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
   
    /** This function mints token to the owner
     * @params {amount}
     * @params {tokenId}
     * returns {statusObject} | {statusBoolean}
    **/
    const mintToken = async (amount, code, issuer) => {
        try{
            if(walletAddress != "") {
                const account = await server.getAccount(walletAddress)
                let _walletAdr = new StellarSdk.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                const asset = new StellarSdk.Asset(code, issuer)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call mint on the contract
                        StellarSdk.Operation.payment({
                          amount: amount,
                          asset: asset,
                          destination: walletAddress,
                          source: walletAddress,
                        })
                     )
                     .setTimeout(timeout)
                     .addMemo(StellarSdk.Memo.text(version + ' Minting total supply'))
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
    
    /** This function burns token
     * @params {amount}
     * @params {tokenId}
     * returns {statusObject} | {statusBoolean}
    **/
    const burnToken = async (amount, code, issuer) => {
        try{
            if(walletAddress != "") {
                 
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
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
   
    /** This function sends payment to contract
     * @params {amount}
     * returns {statusObject} | {statusBoolean}
    **/
    const payBudget = async (amount, code, issuer, propId) => {
        try{
            if(walletAddress != "") {
                 
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
                          destination: daoContractId,
                          source: walletAddress,
                        })
                     )
                     .setTimeout(timeout)
                     .addMemo(StellarSdk.Memo.text(version + ' sent budget of PROP_' + propId))
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
   
   
    /** This function sends the
     * wrapping fee to the wrapping address 
     * @params {code} String
     * @params {issuer} String
     * @params {address} String
     * returns {statusObject} | {statusBoolean}  
    **/
    const wrapAsset = async () => {
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
                          amount: "200",
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
   
    /** This function creates the DAO
     * @params {paramsObject {name, token, about}
     * returns {daoId} | {statusBoolean}
    **/
    const createDaos = async (params = {}) => {
        try{
            if(walletAddress != "") {
                //first add dao info to off chain db
                if(params.url.trim() != "" && params.token != "") {
                    const aToml = await readAssetToml(params.url); 
                    let code = await getTokenInfo(params.token, "symbol");code = code.replace(/[^a-zA-Z0-9]/g,"");
                    //fetch the token info
                    const tomlInfo = getTokenTomlInfo(aToml, code)
                    const coverImgx = tomlInfo.image.replace((code + walletAddress), "cover_" + (code + walletAddress)); 
                    const isCoverValid = await isImageURLValid(coverImgx)
                    const defCoverImg = (isCoverValid) ? coverImgx : 'https://images.unsplash.com/photo-1513151233558-d860c5398176?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
            
                    //check if the url is http and from this domain
                    let url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=new_dao&dao_id=" + daoContractId  + "&token=" + encodeURIComponent(params.token) + "&url=" + encodeURIComponent(params.url) 
                    url += "&name=" + encodeURIComponent(tomlInfo.name) + "&code=" +  encodeURIComponent(code) + "&issuer=" +  encodeURIComponent(tomlInfo.issuer)  + "&image=" +  encodeURIComponent(tomlInfo.image)  + "&cover_image=" +  encodeURIComponent(defCoverImg) + "&about=" +  encodeURIComponent(tomlInfo.desc) 
                    const response = await fetch(url);
                    if (!response.ok) {
                      return {status: false, msg:'Network error'};
                    }
                    const res = await response.json(); console.log(res) 
                    if(!res.status) {return {status: false, msg:'Internal server error'}}
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
                     .addMemo(StellarSdk.Memo.text(version + ' Creating Lumos Dao'))
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
                   await addTx({
                       address:walletAddress,
                       action:"Create new DAO " + params.name,
                       data:'dao/' + params.token,
                       hash:res.hash
                   })
                   return {status: (S.scValToNative(res.value))}
                }
            }
            else {return {status: false, msg:'No wallet connected'}}
        }
        catch(e) {console.log(e); return {status: false, msg:'Network error'}}
    }
    
    /** This function creates the proposal
     * @params {paramsObject {creator, dao, name, about, start, links}
     * returns {daoId} | {statusBoolean}
    **/
    const createProposal = async (params = {}) => {
        try{
            if(walletAddress != "") {
                 
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.creator = new StellarSdk.Address(params.creator);params.creator = params.creator.toScVal()
                const propDao = params.dao
                params.dao = new StellarSdk.Address(params.dao); params.dao = params.dao.toScVal()
                const _name = StellarSdk.nativeToScVal(params.name)
                const about = StellarSdk.nativeToScVal(params.about)
                let start = StellarSdk.nativeToScVal(params.start)
                let links = StellarSdk.nativeToScVal(params.links)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("create_proposal", params.creator, params.dao)
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
                    let url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=new_proposal&dao_id=" + daoContractId  + "&dao=" + encodeURIComponent(propDao) + "&links=" + encodeURIComponent(params.links) 
                    url += "&name=" + encodeURIComponent(params.name) + "&about=" +  encodeURIComponent(params.about) + "&prop_id=" + (StellarSdk.scValToNative(res.value)) + "&user=" + (walletAddress)
                    const response = await fetch(url);
                    if (!response.ok) {
                      return false;
                    }
                    if(!(await response.json()).status) {return false}
                    await addTx({
                       address:walletAddress,
                       action:"Created proposal " + params.name,
                       data: 'dao/' + propDao + '/proposal/' + StellarSdk.scValToNative(res.value),
                       hash:res.hash
                    })
                    return {status: (StellarSdk.scValToNative(res.value))}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
    
    /** This function creates the proposal
     * @params {paramsObject {proposalId, voters, vote_type, voting_power}
     * returns {propId} | {statusBoolean}
    **/
    const voteProposal = async (params = {}) => {
        try{
            if(walletAddress != "") {
                 
                const account = await server.getAccount(walletAddress)
                //first save voter reasons
                //check if the url is http and from this domain
                let url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=vote_reason&dao_id=" + params.daoId  + "&user=" + encodeURIComponent(walletAddress) + "&reason=" + encodeURIComponent(params.reason) 
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
                const voting_power = StellarSdk.nativeToScVal(Math.round(params.voting_power * floatingConstant))
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("vote_on_proposal", propId, params.voters, vote_type, voting_power)
                     )
                     .setTimeout(timeout)
                     .addMemo(StellarSdk.Memo.text(version + ' Voting Lumos Proposal'))
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
                       address:walletAddress,
                       action:"Voted " + ((params.vote_type == 1) ? 'Yes' : 'No') + " on this proposal " + (params.name || ""),
                       data:"dao/" + params.daoId + "/proposal/" + params.proposalId,
                       hash:res.hash
                   })
                   //log alert for proposal owner
                   await addAlerts({
                       other:walletAddress,
                       user:params.owner || "",
                       action:"Voted " + ((params.vote_type == 1) ? 'Yes' : 'No') + " on this proposal " + (params.name || ""),
                       link:"dao/" + params.daoId + "/proposal/" + params.proposalId,
                       title:'Vote on proposal',
                       type:'vote'
                   })
                   return {status: (StellarSdk.scValToNative(res.value))}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
    
    /** This function executes the proposal
     * @params {paramsObject {propId, status}
     * returns {string} | {statusBoolean}
    **/
    const executeProposal = async (params = {}) => {
        try{
            if(walletAddress != "") {
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.owner = new StellarSdk.Address(walletAddress);params.owner = params.owner.toScVal()
                const propId = StellarSdk.nativeToScVal(params.propId)
                const status = StellarSdk.nativeToScVal(params.status * 1)
                const _type = StellarSdk.nativeToScVal(params._type * 1)
                let msg = "";
                if((params.status * 1) === 1) {
                    msg = ' approved Lumos Proposal'
                }
                else {
                    msg = ' rejected Lumos Proposal'
                }
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
                else {
                    if((StellarSdk.scValToNative(res.value)) === 'done'){
                        //save the active proposals mark
                        if((params.status * 1) === 1) {
                            const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=dao_active_proposal&token=" + params.daoId
                            const response = await fetch(url);
                            if (!response.ok) {
                              return false;
                            }
                            if(!(await response.json()).status) {return false}
                        }
                        else {
                            //remove proposals from db
                            const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=remove_proposal&prop_id=" + params.propId
                            const response = await fetch(url);
                            if (!response.ok) {
                              return false;
                            }
                            if(!(await response.json()).status) {return false}
                        }
                        //save tx
                        await addTx({
                           address:walletAddress, 
                           action:msg + ' with id PROP_' + params.propId,
                           data:"dao/" + params.daoId + "/proposal/" + params.proposalId,
                           hash:res.hash
                        })
                       //log alert for proposal owner 
                       addAlerts({
                           other:walletAddress,
                           user:params.creator || "",
                           action:msg + ' with id PROP_' + params.propId,
                           link:"dao/" + params.daoId + "/proposal/" + params.proposalId,
                           title:msg.trim(),
                           type:'execute'
                       })
                   }
                   return {status: (StellarSdk.scValToNative(res.value))}
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
    const addDelegate = async (params = {}) => {
        try{
            if(walletAddress != "") {
                 
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                const daoId = params.dao
                params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                const delegator = (new StellarSdk.Address(walletAddress)).toScVal()
                const delegatee = (new StellarSdk.Address(params.delegatee)).toScVal()
                let memoTx = [];
                if(walletAddress != params.delegatee) {
                    memoTx[0] = ' Delegated voting power'  
                    memoTx[1] = ' Delegated voting power to ' + fAddr(params.delegatee, 6)  
                }
                else {
                    memoTx[0] = ' Reclaimed voting power'
                    memoTx[1] = ' Reclaimed voting power from ' + fAddr(params.del_address, 6)  
                }
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
                else {
                    await addTx({
                       address:walletAddress,
                       action:memoTx[1],
                       data:"dao/" + daoId,
                       hash:res.hash
                   })
                   if(StellarSdk.scValToNative(res.value) !== false) {
                       await addAlerts({
                           other:walletAddress,
                           user:params.del_address || "",
                           action:memoTx[1],
                           link:"dao/" + daoId,
                           title:"Voting power delegation",
                           type:'delegation'
                       })
                   }
                   return {status: (StellarSdk.scValToNative(res.value))}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
    
    /** This function sets the treasury
     * @params {paramsObject {treasury, dao}
     * returns {string} | {statusBoolean}
    **/
    const setDaoTreasury = async (params = {}) => {
        try{
            if(walletAddress != "") {
                 
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                const owner = (new StellarSdk.Address(walletAddress)).toScVal()
                const treasury = (new StellarSdk.Address(params.treasury)).toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("set_treasury", params.dao, owner, treasury)
                     )
                     .setTimeout(timeout)
                     .addMemo(StellarSdk.Memo.text(version + "Setting treasury"))
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
                       address:walletAddress,
                       action:"set treasury address to " + fAddr(params.treasury, 14),
                       data:params.treasury
                   })
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
    const addAdmin = async (params = {}) => {
        try{
            if(walletAddress != "") {
                 
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                const daoId = params.dao
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
                else {
                    await addTx({
                       address:walletAddress,
                       action:"added admin " + fAddr(params.admin, 14),
                       data:"dao/" + daoId,
                       hash:res.hash
                   })
                   if((StellarSdk.scValToNative(res.value)) !== false) {
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
                   return {status: (StellarSdk.scValToNative(res.value))}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
    
    /** This function removes an admin
     * @params {paramsObject {admin, dao}
     * returns {string} | {statusBoolean}
    **/
    const removeDaoAdmin = async (params = {}) => {
        try{
            if(walletAddress != "") {
                 
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                const daoId = params.dao
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
                else {
                    await addTx({
                       address:walletAddress,
                       action:"removed admin " + fAddr(params.admin, 14),
                       data:"dao/" + daoId,
                       hash:res.hash
                   })
                   if((StellarSdk.scValToNative(res.value)) !== false) {
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
                   return {status: (StellarSdk.scValToNative(res.value))}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
    
    /** This function signs admin for multi signatory
     * @params {paramsObject {dao: Address, propId: Int, admin: Address}
     * returns {string} | {statusBoolean}
    **/
    const signDaoAdmin = async (params = {}) => {
        try{
            if(walletAddress != "") {
                 
                const account = await server.getAccount(walletAddress)
                //preparing arguements
                params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                const propId = StellarSdk.nativeToScVal(params.propId)
                const admin = (new StellarSdk.Address(params.admin)).toScVal()
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("sign_admin", params.dao, propId, admin)
                     )
                     .setTimeout(timeout)
                     .addMemo(StellarSdk.Memo.text(version + "Signed PROP_" + params.propId))
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
                       address:walletAddress,
                       action:fAddr(params.admin, 14) + " signed for budget transfer for PROP_" + params.propId,
                       data:params.admin
                   })
                    return {status: (StellarSdk.scValToNative(res.value))}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
    
    /** This function bans a member
     * @params {paramsObject {user, dao}
     * returns {string} | {statusBoolean}
    **/
    const banDaoMember = async (params = {}) => {
        try{
            const res = await isAdmin(params.dao)
            if(walletAddress != "" && res == true) {
                const isBan = await getUserBan(params.dao, walletAddress)
                if(isBan === false){
                     
                    const account = await server.getAccount(walletAddress)
                    //preparing arguements
                    params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                    const member = (new StellarSdk.Address(params.user)).toScVal()
                    let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                        .addOperation(
                            // An operation to call create on the contract
                            contract.call("ban_member", params.dao, member)
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
                        await addTx({
                           address:walletAddress,
                           action:"banned member " + fAddr(params.user, 6),
                           data:"user/" + params.user,
                           hash:res.hash
                       })
                        return {status: (StellarSdk.scValToNative(res.value))}
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
    const unbanDaoMember = async (params = {}) => {
        try{
            const res = await isAdmin(params.dao)
            if(walletAddress != "" && res == true) {
                const isBan = await getUserBan(params.dao, walletAddress)
                if(isBan === false){
                     
                    const account = await server.getAccount(walletAddress)
                    //preparing arguements
                    params.dao = new StellarSdk.Address(params.dao);params.dao = params.dao.toScVal()
                    const member = (new StellarSdk.Address(params.user)).toScVal()
                    let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                        .addOperation(
                            // An operation to call create on the contract
                            contract.call("un_ban_member", params.dao, member)
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
                           address:walletAddress,
                           action:"Unbanned member " + fAddr(params.user, 6),
                           data:'user/' + params.user,
                           hash:res.hash
                       })
                        return {status: (StellarSdk.scValToNative(res.value))}
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
    
    /** To verify if an asset has been wrapped
     * @params {params}
     * @params {callBack}
    **/
    const verifyAsset = async (params = {code:"", issuer:""}) => {
        if(walletAddress != "") {
            try{
                 
                const account = await server.getAccount(walletAddress)
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
                console.log(e)
                return false
            }
        }
        else {return false}
    }
    
    /** To execute a transaction
     * @params {transactionObject}
     * @params {callBack}
    **/
    const execTranst = async (transaction = "") => {
        if(transaction !== "") {
            //prepare xdr
            const server = new StellarSdk.SorobanRpc.Server(stellarServer); 
            let xdr = await transaction.toXDR();
            try {
                if(wallet.toLowerCase() == "freighter" || wallet.toLowerCase() == 'frighter') xdr = await window.freighterApi.signTransaction(xdr, networkWalletUsed) //sign with freighter
                if(wallet.toLowerCase() == "rabet") xdr = window.rabet.sign(xdr, networkWalletUsed.toLowerCase())
                if(wallet.toLowerCase() == "albedo") xdr = window.albedo.tx({xdr:xdr, network:networkWalletUsed.toLowerCase()})
                if(wallet.toLowerCase() == "xbull") xdr = window.sign({xdr:xdr})
                //transaction.sign(StellarSdk.Keypair.fromSecret(walletKey));
                //recreate signed transaction
                transaction = new StellarSdk.Transaction(xdr, networkUsed)
                let sendResponse = await server.sendTransaction(transaction);
                if (sendResponse.status === "PENDING") {
                  let getResponse = await server.getTransaction(sendResponse.hash);
                  // Poll `getTransaction` until the status is not "NOT_FOUND"
                  while (getResponse.status === "NOT_FOUND") {
                    // See if the transaction is complete
                    getResponse = await server.getTransaction(sendResponse.hash);
                    // Wait one second
                    await new Promise((resolve) => setTimeout(resolve, 1000));
                  }
                  console.log(getResponse); 
                  if (getResponse.status === "SUCCESS") {
                    // Make sure the transaction's resultMetaXDR is not empty
                    if (!getResponse.resultMetaXdr) {
                       return {status:true, msg:""}
                    }
                    // Find the return value from the contract and return it
                    
                    //let transactionMeta = getResponse.resultMetaXdr;
                    let returnValue = getResponse.returnValue
                    return {status:true, value: returnValue, hash: sendResponse.hash}
                  } else { 
                    return {status:false, msg:'Transaction failed'}
                  }
                } else {
                   return {status:false, msg:'Unable to submit transaction'}
                }
          } catch (err) {
            // Catch and report any errors we've thrown
            console.log("Sending transaction failed", err);
            return {status:false, msg:err.message}
        }
    }
    }
    // xyu
    setTimeout(async () => {
      //console.log(await isAdmin("CBKG6MDVI3FGYWGUUO5ZS7YI6MJLTTAXCFFYXXCPHIHEFYOOBQLKQBKW"))
    }, 5000)//
    // setTimeout(async () => {console.log(1);console.log(await createDaos(
    //     {
    //             token:walletAddress,name::"JUI", about:"Here", url:"yes"
    //     }))}, 5000)
    
    /* GETTER FUNCTIONS */
    /** This function retrieves
     * the DAO GENERAL INFORMATIONS
     * returns @map | []
     **/ 
    const getDaoMetadata =  async () => {
        if(walletAddress != "") {
            try{
                const account = await server.getAccount(walletAddress)
                let transaction = new StellarSdk.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_metadata")
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                let transactionMeta = (await server.simulateTransaction(transaction))
                //fetch off chain data
                const res = await getOffChainInfo()
                return {...(await StellarSdk.scValToNative(transactionMeta.result.retval)), ...res};
            }
            catch(e) {console.log(e)
                return []}
        }
        else {return []}
        /* Fetch dao info from off chain */
        async function getOffChainInfo(){
            try {
                //check if the url is http and from this domain
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_metadata&dao_id=" + daoContractId + "&id=" + Math.random() * 1000 
                const response = await fetch(url);
                if (!response.ok) {
                  return {}
                }
                const res = await response.json();  
                return res;
                
            } catch (error) { console.log(error); return {}}
        }
    }
    
    /** This function checks
     *  if DAO exists
     * @params {daoId: Address}
     * returns @map | []
     **/ 
    const isDao =  async (daoId) => {
        if(walletAddress != "" && daoId != undefined && daoId != "") {
            try{
                 
                const account = await server.getAccount(walletAddress)
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
            catch(e) {
                //console.log(e)
                return false}
        }
        else {return []}
    }
    
    /**  DAO SPECIFIC INFO
     * @params {daoId: Address}
     * returns @map | []
     **/ 
    const getDao =  async (daoId = []) => {
        if(walletAddress != "" && daoId.length > 0) {
            try{
                const account = await server.getAccount(walletAddress)
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
                const daoMeta = await getAlldaoInfo(daoId.join(","))
                if(daoMeta !== false && dao.length > 0) { 
                    for(let i=0;i<dao.length;i++) {
                        daoMeta[dao[i].token] = {...(dao[i]), ... daoMeta[dao[i].token]}
                    }
                    return daoMeta;
                }
                else {return []}
                
            }
            catch(e) {
                console.log(e)
                return []}
        }
        else {return []}
    }
    
    /**  DAO SPECIFIC INFO WITHOUT META
     * @params {daoId: Address}
     * returns @map | []
     **/ 
    const getDaoWithoutMeta =  async (daoId = []) => {
        if(walletAddress != "" && daoId.length > 0) {
            try{
                const account = await server.getAccount(walletAddress);
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
            catch(e) {
                console.log(e)
                return []}
        }
        else {return []}
    }
    
    /** This function retrieves proposal info
     * @params {propId: int}
     * returns @map | []
    **/ 
    const getProposal =  async (propId) => {
        if(walletAddress != "" && propId != undefined && propId !== 0) {   
            try{
                const account = await server.getAccount(walletAddress)
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
    /** This function retrieves all proposal info
     * @params {propId: [int]}
     * returns @map | []
     **/ 
    const getAllProposal =  async (propId = [], dao) => {
        if(walletAddress != "" && propId.length > 0) {   
            try{
                const account = await server.getAccount(walletAddress)
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
            catch(e) {
              //  console.log(e)
                return []}
        }
        else {return []}
    }
     /** This function retrieves group proposal info
     * @params {propId, voter, dao}
     * returns @map | []
    **/ 
    const getProposalGroupInfo =  async (params = {}) => {
        if(walletAddress != "") {   
            try{
                const account = await server.getAccount(walletAddress)
                params.propId = StellarSdk.nativeToScVal(propId),
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
    /** This function retrieves the proposal voter info
     * @params {propId: int}
     * returns @map | []
    **/ 
    const getProposalVotersInfo =  async (propId, dao) => {
        if(walletAddress != "" && propId != undefined && propId !== 0) {   
            try{
                 
                const account = await server.getAccount(walletAddress)
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
                    url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_all_vote&all_voters=" + voters + "&dao_id=" + dao + "&prop_id=" + propId
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
    
    /** This function retrieves the proposal specific voter info
     * @params {propId: int}
     * returns @map | []
    **/ 
    const getProposalVoterInfo =  async (propId, address) => {
        if(walletAddress != "" && propId != undefined && propId !== 0) {   
            try{  
                const account = await server.getAccount(walletAddress)
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
    /** This function retrieves the voter delegation info
     * @params {dao: Address}
     * @params {voter: Address}
     * returns @map | []
    **/ 
    const getDaoDelegators =  async (dao = "", voter = "") => {
        if(voter != "" && dao != null && dao !== "") {   
            try{  
                 
                const account = await server.getAccount(walletAddress)
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
            catch(e) {
                console.log(e)
                return false
            }
        }
        else {return false}
    }
    /** This function retrieves the user delegatee info
     * @params {dao: Address}
     * returns @map | []
    **/ 
    const getDaoDelegatee =  async (dao = "", user = "") => {
        if(user != "" && dao != null && dao !== "") {   
            try{  
                 
                const account = await server.getAccount(walletAddress)
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
            catch(e) {
                //console.log(e)
                return false
            }
        }
        else {return false}
    }
    /** This function retrieves the user ban info
     * @params {dao: Address, user: Address}
     * returns @boolean
    **/ 
    const getUserBan =  async (dao = "", user = "") => {
        if(user != "" && dao != null && dao !== "") {   
            try{  
                 
                const account = await server.getAccount(walletAddress)
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
            catch(e) {
                //console.log(e)
                return 2
            }
        }
        else {return 0}
    }
    /** To retreive token info
     * @params {tokenId}
    **/
    const getTokenInfo = async (tokenId, info="name") => {
        if(walletAddress != "") {
            try{
                 
                const account = await server.getAccount(walletAddress)
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
    
    const getTokenUserBal = async (tokenId, address) => {
        if(walletAddress != "") {
            try{
                 
                const account = await server.getAccount(walletAddress)
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
            catch(e) {
                return false
            }
        }
        else {return false}
    }
    
    //calculate voting power of an address
    const getVotingPower = async (asset = {}, address, total_voter = []) => {
        //get the holders score
        const url = `https://api.stellar.expert/explorer/${networkWalletUsed.toLowerCase()}/asset/${asset.asset.toUpperCase() +'-' + asset.address}/position/${address}`
        try{
            let holder_pos;let response;
            if(address != asset.issuer) {
               response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=asset_holder&url=` + encodeURIComponent(url));
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
            response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=wallet_comment&address=` + address + "&dao_id=" + asset.dao + "&id=" + Math.random());
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
            response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=wallet_age&address=` + address);
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
            response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=wallet_trade&address=` + address);
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
            response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=xlm_usd&address=` + address);
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
        } catch (error) { console.log(error)
            return false;
        }
    }
    // URL of the Stellar asset's TOML file
    const readAssetToml = async (url) => {
         try {
            //check if the url is http and from this domain
            if(url.indexOf('http://') > -1 && url.indexOf("<?php echo $_SERVER['HTTP_HOST']; ?>") > -1) {
                //using insecure http and from lumos, serve from asset folder
                url = new URL(url);
                url = url.hostname.split('.')[0]; // Get the first part of the hostname
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=loadtoml&value=" + url  + "&id=" + Math.random() * 1000
            }
            const response = await fetch(url);
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const tomlContent = await response.text();
           // console.log(toml.parse(tomlContent))
            return toml.parse(tomlContent);
        } catch (error) { console.log(error)
            return false;
        }
    }
    
    //to leave a dao
    const leaveDao = async (code, issuer, daoId, daoName) => { console.log(daoName, daoId)
        //leave the dao
        const res = await removeTrustline(code, issuer, walletAddress, daoName, daoId)
        return res;
    }
    //get comments for a user
    const getUserComment = async (address) => {
         try {
            //check if the url is http and from this domain
           url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=user_comment&address=" + address + "&id=" + Math.random() * 1000 
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
    // get comments for a proposal
    const getProposalComment = async (propId, dao = "") => {
         try {
            //check if the url is http and from this domain
           url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_comment&proposal_id=" + propId  + "&dao=" + dao + "&id=" + Math.random() * 1000 
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
    // get comments for bulletins
    const getBulletinComment = async (id) => {
         try {
            //check if the url is http and from this domain
            const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_bulletin_comment&bid=" + id + "&id=" + Math.random() * 1000 
            const response = await fetch(url);
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const commt = await response.json();   
            return commt;
        } catch (error) { console.log(error)
            return [];
        }
    }
    // get comments for bulletins
    const getDaoTweet = async (id) => {
         try {
            //check if the url is http and from this domain
            const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_tweet&dao_id=" + id + "&id=" + Math.random() * 1000 
            const response = await fetch(url);
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const tweet = await response.json();   
            return tweet;
        } catch (error) { console.log(error)
            return [];
        }
    }
    // send proposal comment
    const sendProposalComment = async (propId, daoId, msg = "", address) => {
         try {
             if(msg.trim() != "" && address != "") {
                //check if the url is http and from this domain
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=add_comment&proposal_id=" + propId  + "&dao_id=" + daoId  + "&msg=" + encodeURIComponent(msg) + "&address=" + encodeURIComponent(address)
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
    // send bulletin comment
    const sendBulletinComment = async (id, msg = "", user) => {
         try {
             if(msg.trim() != "" && user != "") {
                //check if the url is http and from this domain
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=add_bulletin_comment&bid=" + id + "&msg=" + encodeURIComponent(msg) + "&user=" + encodeURIComponent(user)
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
    // send dao bulletin
    const sendDaoBulletin = async (daoId, msg = "", address, polls = null) => {
         try {
             if(msg.trim() != "" && address != "") {
                //check if the url is http and from this domain
                if(polls == null) {
                   url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=add_bulletin&dao_id=" + daoId  + "&msg=" + encodeURIComponent(msg) + "&address=" + encodeURIComponent(address)
                }
                else {
                   url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=add_poll&dao_id=" + daoId  + "&msg=" + encodeURIComponent(msg) + "&address=" + encodeURIComponent(address) + "&polls=" + encodeURIComponent(JSON.stringify(polls))
                }
                const response = await fetch(url);
                if (!response.ok) {
                  throw new Error("Network response was not ok");
                }
                const res = await response.json();
                return res
            }
            else {return 2}
        } catch (error) { console.log(error)
            return false;
        }
    }
    
    // like dao bulletin
    const likeDaoBulletin = async (id, address) => {
         try {
             if(id != "" && address != "") {
                //check if the url is http and from this domain
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=like_bulletin&id=" + id + "&user=" + encodeURIComponent(address)
                const response = await fetch(url);
                if (!response.ok) {
                  throw new Error("Network response was not ok");
                }
                const res = await response.json();
                return res
            }
            else {return 2}
        } catch (error) { console.log(error)
            return false;
        }
    }
    
    // like dao bulletin
    const dislikeDaoBulletin = async (id, address) => {
         try {
             if(id != "" && address != "") {
                //check if the url is http and from this domain
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=dislike_bulletin&id=" + id + "&user=" + encodeURIComponent(address)
                const response = await fetch(url);
                if (!response.ok) {
                  throw new Error("Network response was not ok");
                }
                const res = await response.json();
                return res
            }
            else {return 2}
        } catch (error) { console.log(error)
            return false;
        }
    }
    
    // to vote on poll
    const voteDaoPoll = async (id, pid, address) => {
         try {
             if(id != "" && address != "") {
                //check if the url is http and from this domain
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=vote_poll&id=" + id + "&user=" + encodeURIComponent(address) + "&pid=" + pid
                const response = await fetch(url);
                if (!response.ok) {
                  throw new Error("Network response was not ok");
                }
                const res = await response.json();
                return res
            }
            else {return 2}
        } catch (error) { console.log(error)
            return false;
        }
    }
    // send tweet code
    const embedDaoTweet = async (daoId, code = "", address) => {
         try { 
             if(code.trim() != "" && address != "") {
                //check if the url is http and from this domain
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=add_tweet&dao_id=" + daoId  + "&code=" + encodeURIComponent(code) + "&address=" + encodeURIComponent(address)
                const response = await fetch(url);
                if (!response.ok) {
                  throw new Error("Network response was not ok");
                }
                const res = await response.json();
                return res
            } 
            else {return 2}
        } catch (error) { console.log(error)
            return false;
        }
    }
    //
    const addDaoUser = async (params) => {
         try {
             if(params.token != "") {
                //check if the url is http and from this domain
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=dao_user&token=" + params.token  + "&_type=" + encodeURIComponent(params.type) + "&user=" + encodeURIComponent(walletAddress)
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
                url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=add_tx&dao_id=" + daoContractId  + "&action=" + encodeURIComponent(params.action) + "&address=" + encodeURIComponent(params.address) + "&data=" + encodeURIComponent(params.data) + "&hash=" + encodeURIComponent(params.hash)
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
    //logg in alerts
    const addAlerts = async (params) => {
         try { 
             if(params.action.trim() != "" && params.other != "") {
                //check if the url is http and from this domain
                let url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=add_alert&action=" + encodeURIComponent(params.action) + "&other=" + encodeURIComponent(params.other) + "&user=" + encodeURIComponent(params.user)
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
    // get all dao info
    const getAlldaoInfo = async (daos) => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_all_dao&all_dao=" + daos + "&user=" + walletAddress + "&id=" + Math.random() * 1000 
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
    const getAllPropInfo = async (propIds, daoId) => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_all_proposal&all_proposal=" + propIds + "&dao_id=" + daoId + "&id=" + Math.random() * 1000 
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
    // get all tx
    const getTx = async () => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_tx&dao=" + daoContractId + "&id=" + Math.random() * 1000 
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
    // get all Users tx
    const getAllUsersTx = async () => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_user_tx&dao=" + daoContractId + "&address=" + walletAddress + "&id=" + Math.random() * 1000 
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
    // get all tx
    const getUserTx = async (addr) => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_dao_users&dao=" + daoContractId + "&id=" + Math.random() * 1000 
            const response = await fetch(url);
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const tx = await response.text();  console.log(tx)
            return (tx != "") ? JSON.parse(tx) : ""
        } catch (error) { console.log(error)
            return false;
        }
    }
    // get all user info
    const getUserInfo = async (addr) => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_user&user=" + addr + "&id=" + Math.random() * 1000 
            const response = await fetch(url);
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const res = await response.json();  
            return res
        } catch (error) { console.log(error)
            return false;
        }
    }
    // get user dao meta
    const getUserMeta = async (addr) => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_user_meta&user=" + addr + "&id=" + Math.random() * 1000 
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
    // get all Users alerts
    const getAllUserAlerts = async () => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_user_alert&user=" + walletAddress + "&id=" + Math.random() * 1000 
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
    // get all Users alerts unread num
    const getAllUserAlertsNo = async () => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_user_alert_no&user=" + walletAddress + "&id=" + Math.random() * 1000 
            const response = await fetch(url);
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const tx = await response.json();  
            return tx['num'];
        } catch (error) { console.log(error)
            return 0;
        }
    }
    // get dao users by dao name
    const getDaoUsersP = async (daoName) => { 
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
    // get all users
    const getAllDaoUsers = async () => { 
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_all_dao_users&id=" + Math.random() * 1000 
            const response = await fetch(url);
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const res = await response.json();  
            return res.users || []
        } catch (error) { console.log(error)
            return [];
        }
    }
    // get num of users
    const getDaoUsers = async () => {
         try {
             let num = 0; let joiners = []
             const tx = await getUserTx(); 
             for(let i=0;i<tx.length;i++) {
                 tx[i] = JSON.parse(tx[i])
                 if(tx[i].action.toLowerCase().indexOf('joined dao') > -1 || tx[i].action.toLowerCase().indexOf('create new dao') > -1){
                         //add
                         joiners.push(tx[i].signer)
                 }
                 else if(tx[i].action.toLowerCase().indexOf('left dao') > -1) {
                     joiners[joiners.indexOf(tx[i].signer)] = ""
                 }
             }
             let j = []
             //loop through and remove duplicates
             for(let i=0;i<joiners.length;i++) {
                 if(!j.includes(joiners[i])) {
                     j.push(joiners[i])
                 }
             }
             return j.length
        } catch (error) { console.log(error)
            return 0;
        }
    }
    
    // get bulletins 
    const getDaoBulletins = async (dao) => {
         try {
            //check if the url is http and from this domain
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_bulletin&dao_id=" + dao + "&user=" + walletAddress + "&id=" + Math.random() * 1000 
            const response = await fetch(url);
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const res = await response.json();  
            return res
        } catch (error) { console.log(error)
            return [];
        }
    }
    //to load tweet via url
    const loadTweetsUri = async (uri) => {
         try {
            // Fetch the tweet using Twitter's oEmbed API
            const response = await fetch('https://publish.twitter.com/oembed?url=' + encodeURIComponent(uri))
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            const res = await response.json(); 
            return res.html
        } catch (error) { console.log(error)
            return false;
        }
    }
    //check if user is an admin
    const isAdmin = async (daoId = "") => {
        //structure url
        if(walletAddress != "" && daoId != "") {
            try{
                
                const account = await server.getAccount(walletAddress)
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
            catch(e) {return 2}
        }
        else {return 2}
    }
    
    
    //check if subdomain exists
    const isSubDomainExists = async (domain) => {
         try {
            const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=subdomain&value=" + domain.replace(/[^a-zA-Z0-9]/g,"").toLowerCase()
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
    
    //check if proposal exists
    const isProposalExists = async (proposal, dao) => {
         try {
            const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=proposal&value=" + encodeURIComponent(proposal.replace(/ /g,"")) + "&dao=" + encodeURIComponent(dao.toLowerCase())
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
    
    //get the token info from toml file
    const getTokenTomlInfo = (aToml, code) => { 
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
    /* Get Joined dao membership date */
    const getDaoJoinedDate = async (_address) => {
         try {
            const daos = await getDaoMetadata(); 
            _address = _address.replace(/[^A-Z0-9a-z]/g,"")
            //loop through the daos
            if(daos.daos.length > 0) {
                let canContinue = true; let arr = []
                let url = 'https://horizon-testnet.stellar.org/accounts/'+_address+'/transactions?limit=200&order=asc&include_failed=false'
                while(canContinue){
                    let res = await fetch(url); 
                    if (!res.ok) {
                      canContinue = false
                    }else{
                        res = await res.json(); url = res._links.next.href;res = res._embedded.records;  
                        if(res.length > 0) {
                            //loop through the response
                            for(let i=0;i<res.length;i++) { 
                                const val = (res[i].memo || "").toLowerCase().trim()
                                if(val == (version + ' creating dao') || val == (version + ' creating trustline') || val == (version + ' joining lumos dao') || val == (version + ' creating lumos dao')) {
                                    //get the date
                                     return res[i].created_at
                                     break;
                                }
                            }
                           
                        }
                        else {
                            break;
                        }
                    }
                    
                }
                return ""
             }
            else {
                return ""
            }
        } catch (error) { console.log(error)
            return [0, []];
        }
    }
    /* Get user joined dao number  */
    const getDaoJoinedNum = async (_address) => {
         try {
            response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_user_join_dao&user=` + _address + "&id=" + Math.random());
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
    /* Get user joined dao number  */
    const getDaoJoinedWithInfo = async (_address) => {
         try {
            response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_user_join_daometa&user=` + _address + "&dao_id=" + daoContractId);
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
    //return proposal comment number
    const getCommentNum = async (_address) => {
         try {
            response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=wallets_comment&address=` + _address + "&id=" + Math.random());
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            let comt_act = await response.text() * 1;
            return comt_act
        } catch (error) { console.log(error)
            return 0;
        }
    }
    /* 2 FACTOR AUTHENTICATION */
    const get2FaCodeURI = async () => {
        if(walletAddress != "") {
            try {
                response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=get_2fa&user=` + walletAddress + "&id=" + Math.random());
                if (!response.ok) {
                  throw new Error("Network response was not ok");
                }
                let res = await response.json();
                if(res.uri != "") {
                    E('2fa_bar_code').innerHTML = ""
                    new QRCode(E("2fa_bar_code"), {
                    	text: res.uri,
                    	width: 200,
                    	height: 200,
                    });
                    E('2fa_bar_code').setAttribute('data', 'shown') 
                    E('2fa_auth_code').setAttribute('data', res.secret) 
                }
            } catch (error) { console.log(error)
                return "";
            }
        }
    }
    get2FaCodeURI()
    const reg2FaCode = async () => {
        //check if the input field has shown
        if(E('2fa_bar_code').getAttribute('data') === 'shown') {
            E('2fa_bar_code').style.display = 'none'
            E('2fa_auth_code').style.display = 'block'
            E('2fa_auth_msg').innerText = "Please input the OTP showing in your authenticator app"
            E('2fa_bar_code').setAttribute('data', 'otp') //switch to showing otp
        }
        else if (E('2fa_bar_code').getAttribute('data') === 'otp') {
            //verify otp
            try {
                const code = E('2fa_auth_code').value.trim()
                const key = E('2fa_auth_code').getAttribute('data') || ""
                //console.log(key, code)
                const id = talk('Verifying OTP')
                response = await fetch(window.location.protocol + `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=verify_2fa&code=${code}&key=${key}&user=` + walletAddress + "&id=" + Math.random());
                if (!response.ok) {
                  stoptalking(3, talk('Network error', 'fail', id))
                }
                let res = await response.json();
                //console.log(res)
                if(res.status === true) {
                    stopTalking(3, talk('2-Factor authentication enabled', 'good', id))
                    E('2fa_bar_code').style.display = ''
                    E('2fa_auth_code').style.display = 'none'
                    E('2fa_auth_msg').innerText = "Using the app, scan the QR code to continue"
                    E('2fa_bar_code').setAttribute('data', 'shown') //switch to showing otp
                }
                else {
                    stopTalking(3, talk('OTP has expired or is invalid', 'fail', id))
                }
            } catch (error) { console.log(error)
                return "";
            }
        }
    }
    
    /* UTILITIES */
    
    /** This functions show a modal message
     * @params {msg} String
     * @params {type} String [good|fail|warn|norm]
     * @return {int} ModalId
    **/
    const talk = (msg = "", type = "norm", id = "", pgress=0) => {
        //config stylings
        let params = {color:"black", 'class':"talk_spin fa-solid fa-spinner"}
        if(type == "good") {params.color = "forestgreen"; params.class='fa-solid fa-check-circle'}
        else if(type == "fail") {params.color = "red"; params.class='fa-solid fa-times'}
        else if(type == "warn") {params.color = "#ffa101"; params.class='fa-solid fa-info'}
        if(id != "") {
            //performing modifications
            E(id).style.color = params.color
            E(id).style.borderColor = params.color
            E('talk_msg' + id).innerHTML = msg
            E('talk_icon' + id).classList = params.class
            E('talk_loader' + id).style.width = pgress + '%'
        }
        else {
            //generate id
            id = 'talk_' + Math.floor(Math.random() * 10000000 * Math.random())
            let div = document.createElement('div')
            div.innerHTML =  `<di><style>
            .talk_spin{animation:talk_spin 700ms infinite;}
                        @keyframes talk_spin{
                            0%{
                                transform:rotate(0deg);
                            }
                            100%{
                                transform:rotate(720deg);
                            }
                        }
                </style>
                <div style='position:fixed;top:0px;left:0px;width:100vw;height:0px;display:flex;align-items:flex-start;z-index:1500'>
                    <div id='${id}' style='margin-left:auto;margin-right:20px;margin-top:40px;background:white;display:flex;overflow:hidden;
                    border-radius:10px;border:1px solid ${params.color};color:${params.color};font-size:17px;box-shadow:0 0 6px 3px rgba(0,0,0,.1)'>
                    <div style='padding:10px 15px;text-align:center;z-index:2'><span id='talk_icon${id}' class='${params.class}' style='margin-right:5px'></span>
                    <span id='talk_msg${id}' style='margin-right:5px'>${msg}</span></div>
                    <div name='loader' style='margin-left:-100%;width:100%'><div id='talk_loader${id}' style='transition:all 200ms;background:linear-gradient(to right, #FFA500, #FF4500, #FF0000); width:${pgress}%;height:100%'></div></div>
                    </div></div></div>
            `
            document.body.appendChild(div.firstElementChild)
        }
        return id
    }
    //Remove
    const stopTalking = (_timeout, id) => {
        if(_timeout > 0) {
            //using timeout
            setTimeout(() => {document.body.removeChild(E(id).parentElement.parentElement)}, _timeout * 1000)
        }
        else {
            //not using timeout
            document.body.removeChild(E(id).parentElement.parentElement)
        }
    }
    
     /** to enable pagination
     * @params {Element, data, Integer, function} 
     * return {Integer} Id
    **/
   const paginate = (dispId, contentData, page_size = 20, drawFunction, callback = null) => {
       //prepare the view with the next and prev button
       const disp = E(dispId)
       if(disp != null) {
           let paginate_page = 1;
           let paginate_page_segment = page_size;
           const id = Math.floor(Math.random() * Math.random() * 10000000)
           disp.innerHTML = `<div style='width:100%' id='paginate_data_${id}'></div>
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
    
    /** Check if its toml safe
     * @params {value} String
     * @return {boolean}
    **/
    const isSafeToml = (value) => {
        //check if it has "
        if(value.indexOf('"') > -1) {return false}
        return true
    }
   
    
    /** Validate image upload 
    * params {id} String - the id of the file element
    * params {dispId} String - the id of the elemnt to display the image
    * params {type: 1[background] |2 [src]} Integer - specifies if its background or src that would be changes
    */
    const validateImageUpload =  (id, dispId, type = 1, callback = (e)=>{}) => {
        E(id).onchange = (event) => {
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
    
    /** To validate a document file
     * params {file} A file object
     * returns {boolean}
    */
    function isDocument(file) {
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
    
    /** To check if an image url is valid
     * params {url}
     * returns {boolean}
    */
   async function isImageURLValid(url) {
        //structure url
        try {
            url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=valid_image&value=" + encodeURIComponent(url)
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
    
    /** To convert a bigInt to number
     * params {num}
     * returns {BigInt}
    */
    const N = (num) => {return (num.toString() * 1)}
    /** To convert  to formatted number
     * params {num}
     * returns {string}
    */
    const fNum = (num) => {
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
    /** To format an address to display
     * params {_address} the address as string
     * params {n} the number of address characters to display
     * returns {String}
    */
    const fAddr = (_address, n = 14) => {
        _address += ""
        return _address.substring(0,n) + '...' + _address.substring(_address.length - n)
    }
    /** To format a date to display
     * params {date_string} the address as string
     * returns {String}
    */
    const fDate = (date_string) => {
        const options = {
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: 'numeric',
          minute: 'numeric'
        };
        return (new Date(date_string)).toLocaleDateString('en-US', options);
    }
    /** To check current user ban status
     * params {user: address, dao:address} the address as string
     * returns {bool}
    */
    const isBanned = async (dao, user) => {
        const isBan = await getUserBan(dao, user)
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
    /** To copy a link to clipboard
     * params {text}
     * returns {bool}
    */
    const copyLink = (text) => {
        // Check if the Clipboard API is available
        if (navigator.clipboard) {
            // Use the Clipboard API to copy text
            navigator.clipboard.writeText(text)
                .then(() => {
                    stopTalking(2, talk("Copied to clipboard", "good"))
                })
                .catch(err => {
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
            } catch (err) {
                stopTalking(2, talk("Unable to copy to clipboard", "fail"))
            }
    
            // Clean up
            document.body.removeChild(textarea);
        }
        return true
    }
    /* To Compress image
    for optimization
    */
    const optimizeImg = async (pngDataURL, quality, maxWidth, maxHeight) => {
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
    //remove null elements in array */
    const fArr = (arr) => {
        if(arr.length > 0) {
            let newArr = []
            for(let i=0;i<arr.length;i++) {
                if(arr[i] != null && arr[i] != undefined) {newArr.push(arr[i])}
            }
             
            return newArr
        }
        return []
    }
    /* SOCIAL AUTH METHOD */
    
    //reddit oauth url
    const getRedditOauthUri = (dao, domain) => {
        const clientId = REDDIT_CLIENT_ID;
        const redirectUri = 'https://develop.lumosdao.io/.well-known/asset.php?type=reddit_auth';
        const scopes = ['identity', 'read'];
        const randomString = dao + ":" + domain
        const authUrl = `https://www.reddit.com/api/v1/authorize?client_id=${clientId}&response_type=code&state=${randomString}&redirect_uri=${encodeURIComponent(redirectUri)}&duration=permanent&scope=${scopes.join('+')}`;
        return authUrl
    }
    //linkedin oauth url
    const getLinkedInUri = (user) => {
        // Replace these values with your actual client ID and redirect URI
        const redirectUri = 'https://develop.lumosdao.io/.well-known/asset.php?type=user_linkedin_auth';
        const scopes = ['r_basicprofile', 'r_emailaddress']; // Add the desired scopes
        const authUrl = `https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=${LINKEDIN_CLIENT_ID}&state=${user}&redirect_uri=${encodeURIComponent(redirectUri)}&scope=${scopes.join('%20')}`;
        return authUrl;
    }
    //github oauth url
    const getGithubUri = (user) => {
        const redirectURI = 'https://develop.lumosdao.io/.well-known/asset.php?type=user_github_auth'
        const authURL = `https://github.com/login/oauth/authorize?client_id=${GITHUB_CLIENT_ID}&redirect_uri=${redirectURI}&state=${user}&scope=user`;
        return authURL;
    }
</script>