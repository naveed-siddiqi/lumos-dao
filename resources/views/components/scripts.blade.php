<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/@albedo-link/intent"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/soroban-client/1.0.0-beta.2/soroban-client.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/stellar-freighter-api/1.7.1/index.min.js"></script>
<script type="module"> import n from 'https://cdn.jsdelivr.net/npm/toml@3.0.0/+esm' ; window.toml = n</script>

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
    const daoContractId = 'CCWTMDURJHXTNSMCWWGLE5VELYNXUSDRVVO2T2AP2AFIFYLRZXXX7Z3F'  
    const wrappingAddress = 'GC5JKOC7OMSS22NVC23MVL2363QS5JO7SQM5X7C7DPVLQLFQHZ3ZRHGF'
    const networkUsed = SorobanClient.Networks.TESTNET
    const networkWalletUsed = "TESTNET"
    const contract = new SorobanClient.Contract(daoContractId);
    const timeout = 86400 //using a timeout of one day
    const fee = 100;
                        
    @if (isset($_COOKIE['wallet']))
        const walletAddress = "{{ $_COOKIE['public']  }}"
    @else
        const walletAddress = ""
    @endif
 
    //SETTER FUNCTION
    //'SCWFXEQXLIAH4VZ2TJFU4I27ZVXLSBP65O3S3JDLO3VNOGGJTVUEWSV4' TESTING PURPOSES
            
    /** This function increase a contract lifetime by a year
     * @params {address}
     * returns {statusObject} | {statusBoolean}
    **/
    const bumpContractInstance =  async (address) => {
      address = SorobanClient.Address.fromString(address);
      console.log('bumping contract instance: ', address.toString());
      const contractInstanceXDR = SorobanClient.xdr.LedgerKey.contractData(
        new SorobanClient.xdr.LedgerKeyContractData({
          contract: address.toScAddress(),
          key: SorobanClient.xdr.ScVal.scvLedgerKeyContractInstance(),
          durability: SorobanClient.xdr.ContractDataDurability.persistent(),
        })
      );
      const bumpTransactionData = new SorobanClient.xdr.SorobanTransactionData({
        resources: new SorobanClient.xdr.SorobanResources({
          footprint: new SorobanClient.xdr.LedgerFootprint({
            readOnly: [contractInstanceXDR],
            readWrite: [],
          }),
          instructions: 0,
          readBytes: 0,
          writeBytes: 0,
        }),
        refundableFee: SorobanClient.xdr.Int64.fromString('0'),
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        ext: new SorobanClient.xdr.ExtensionPoint(0),
      });

      const txBuilder = await createTxBuilder();
      txBuilder.addOperation(SorobanClient.Operation.bumpFootprintExpiration({ ledgersToExpire: 100000 })); // 1 year 535670
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
          const networkId = SorobanClient.hash(encodedData.buffer);
          const preimage = SorobanClient.xdr.HashIdPreimage.envelopeTypeContractId(
             new SorobanClient.xdr.HashIdPreimageContractId({
               networkId: networkId,
               contractIdPreimage: SorobanClient.xdr.ContractIdPreimage.contractIdPreimageFromAsset(xdrAsset),
             })
           );
           const contractId = SorobanClient.StrKey.encodeContract(SorobanClient.hash(preimage.toXDR()));
           const deployFunction = SorobanClient.xdr.HostFunction.hostFunctionTypeCreateContract(
             new SorobanClient.xdr.CreateContractArgs({
               contractIdPreimage: SorobanClient.xdr.ContractIdPreimage.contractIdPreimageFromAsset(xdrAsset),
               executable: SorobanClient.xdr.ContractExecutable.contractExecutableToken(),
             })
           );
           const res = await invokeAndUnwrap(
             SorobanClient.Operation.invokeHostFunction({
               func: deployFunction,
               auth: [],
             }),
             () => undefined
           );
           if(res.status) {res.value = SorobanClient.scValToNative(res.value)}
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
        operation = SorobanClient.xdr.Operation.fromXDR(operation, 'base64');
      }
      txBuilder.addOperation(operation);
      const tx = txBuilder.build();
      return invokeTransaction(tx, sim, parse);
    }
    const createTxBuilder = async () => {
      try {
        const server = new SorobanClient.Server(stellarServer); 
        const account = await server.getAccount(walletAddress);
        return new SorobanClient.TransactionBuilder(account, {
          fee: '10000',
          networkPassphrase: networkUsed
        }).setTimeout(timeout);
      } catch (e) {
        console.error(e);
        throw Error('unable to create txBuilder');
      }
    }
    const invokeTransaction = async(tx, sim, parse) => {
      const server = new SorobanClient.Server(stellarServer);
      const hash = tx.hash().toString('hex');
      const simulation_resp = await server.simulateTransaction(tx);
      if (sim || SorobanClient.SorobanRpc.isSimulationError(simulation_resp)) {
        // allow the response formatter to fetch the error or return the simulation results
        return {status:false, msg:'simulation fail'};
      }
      const prepped_tx = SorobanClient.assembleTransaction(tx, networkUsed, simulation_resp).build();
      return await execTranst(prepped_tx)
    }
    
    /** This function creates trustline
     * @params {code} String
     * @params {issuer} String
     * @params {address} String
     * returns {statusObject} | {statusBoolean}
    **/
    const createTrustline = async (code, issuer, address) => {
        try{
            if(walletAddress != "") {
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                //preparing arguements
                let _walletAdr = new SorobanClient.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                const asset = new SorobanClient.Asset(code, issuer)
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to establist trustline
                        SorobanClient.Operation.changeTrust({
                          asset: asset,
                          source: address,
                        }),
                     )
                     .setTimeout(timeout)
                     .addMemo(SorobanClient.Memo.text('Creating trustline'))
                     .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    return {status: (SorobanClient.scValToNative(res.value))}
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
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                //preparing arguements
                let _walletAdr = new SorobanClient.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                const asset = new SorobanClient.Asset(code, issuer)
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call mint on the contract
                        //contract.call("mint", _walletAdr, amount)
                        SorobanClient.Operation.payment({
                          amount: amount,
                          asset: asset,
                          destination: walletAddress,
                          source: walletAddress,
                        })
                     )
                     .setTimeout(timeout)
                     .addMemo(SorobanClient.Memo.text('Minting total supply'))
                     .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    return {status: (SorobanClient.scValToNative(res.value))}
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
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                //preparing arguements
                let _walletAdr = new SorobanClient.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        SorobanClient.Operation.payment({
                          destination: wrappingAddress,
                          asset: SorobanClient.Asset.native(),
                          amount: "1000",
                        }),
                     )
                     .setTimeout(timeout)
                     .addMemo(SorobanClient.Memo.text('Wrapping Asset'))
                     .build();
                //sign and exec transactions
                const res = await execTranst(transaction)
                
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    return {status: (SorobanClient.scValToNative(res.value))}
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
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                //preparing arguements
                let _walletAdr = new SorobanClient.Address(walletAddress);_walletAdr = _walletAdr.toScVal()
                let _tokenAdr = new SorobanClient.Address(params.token); _tokenAdr = _tokenAdr.toScVal()
                const _name = SorobanClient.nativeToScVal(params.name)
                const about = SorobanClient.nativeToScVal(params.about)
                const _url = SorobanClient.nativeToScVal(params.url)
                const dte = SorobanClient.nativeToScVal(Date.now())
                console.log(account)
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("create", _walletAdr, _tokenAdr, _name, about, _url, dte)
                     )
                     .setTimeout(timeout)
                     .addMemo(SorobanClient.Memo.text('Creating Dao'))
                     .build();
                // Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                //sign and exec transactions
                const res = await execTranst(transaction)
                console.log(res)
                if(res.status === false) {
                    //something went wrong
                    return false
                }
                else {
                    return {status: (SorobanClient.scValToNative(res.value))}
                }
            }
            else {return false}
        }
        catch(e) {console.log(e); return false}
    }
    
    /** This function creates the proposal
     * @params {paramsObject {creator, dao, name, about, start, end}
     * returns {daoId} | {statusBoolean}
    **/
    const createProposal = async (params = {}) => {
        try{
            if(walletAddress != "") {
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                //preparing arguements
                params.creator = new SorobanClient.Address(params.creator);params.creato = params.creato.toScVal()
                params.dao = new SorobanClient.Address(params.dao); params.dao = params.dao.toScVal()
                const _name = SorobanClient.nativeToScVal(params.name)
                const about = SorobanClient.nativeToScVal(params.about)
                start = SorobanClient.nativeToScVal(params.start)
                end = SorobanClient.nativeToScVal(params.end)
                
                console.log(account)
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase: networkUsed })
                    .addOperation(
                        // An operation to call create on the contract
                        contract.call("create_proposal", params.creator, params.dao, _name, about, start, end)
                     )
                     .setTimeout(timeout)
                     .addMemo(SorobanClient.Memo.text('Creating Proposal'))
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
                    return {status: (SorobanClient.scValToNative(res.value))}
                }
            }
            else {return false}
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
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                let asset; let contract;
                if(params.code.length == 56) {
                    contract = new SorobanClient.Contract(params.code);
                    console.log(contract, params.code)
                }
                else {
                    asset = new SorobanClient.Asset(params.code, params.issuer)
                    contract = new SorobanClient.Contract(asset.contractId(networkUsed));
                }
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
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
            const server = new SorobanClient.Server(stellarServer); 
            let xdr = await transaction.toXDR();
            try {
                console.log(wallet)
                if(wallet.toLowerCase() == "freighter" || wallet.toLowerCase() == 'frighter') xdr = await window.freighterApi.signTransaction(xdr, networkWalletUsed) //sign with freighter
                if(wallet.toLowerCase() == "rabet") xdr = window.rabet.sign(xdr, networkWalletUsed.toLowerCase())
                if(wallet.toLowerCase() == "albedo") xdr = window.albedo.tx({xdr:xdr, network:networkWalletUsed.toLowerCase()})
                if(wallet.toLowerCase() == "xbull") xdr = window.sign({xdr:xdr})
                
                //recreate signed transaction
                transaction = new SorobanClient.Transaction(xdr, networkUsed)
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
                  } else { console.log(getResponse)
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
   
   // setTimeout(() => {createDaos()}, 6000)
    
    /* GETTER FUNCTIONS */
    
    /** This function retrieves
     * the DAO GENERAL INFORMATIONS
     * returns @map | []
     **/ 
    const getDaoMetadata =  async () => {
        if(walletAddress != "") {
            try{
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_metadata")
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                return await SorobanClient.scValToNative(transactionMeta.result.retval);
            }
            catch(e) {
                console.log(e)
                return []}
        }
        else {return []}
    }
    
    /** This function retrieves
     *  DAO SPECIFIC INFO
     * @params {daoId: Address}
     * returns @map | []
     **/ 
    const getDao =  async (daoId) => {
        if(walletAddress != "" && daoId != undefined && daoId != "") {
            try{
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_dao", (new SorobanClient.Address(daoId)).toScVal())
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                let dao = SorobanClient.scValToNative(transactionMeta.result.retval);
                if(dao['url'] != undefined) {
                    const aToml = await readAssetToml(dao.url); 
                    let code = await getTokenInfo(dao.token, "symbol");code = code.replace(/[^a-zA-Z0-9]/g,"");
                    const tomlInfo = getTokenTomlInfo(aToml, code)
                    dao.name = tomlInfo.name
                    dao.description = tomlInfo.desc
                    dao.image = tomlInfo.image
                    dao.issuer = tomlInfo.issuer
                    dao.toml = aToml
                    dao.code = code
                    return dao
                }
                else {return []}
                
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
        if(walletAddress != "" && propId != undefined && propId * 1 !== 0) {
            try{
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call("get_proposal", (SorobanClient.nativeToScVal(propId)))
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                return (SorobanClient.scValToNative(transactionMeta.result.retval)); 
            }
            catch(e) {
                console.log(e)
                return []}
        }
        else {return []}
    }
  
    /** To retreive token info
     * @params {tokenId}
    **/
    const getTokenInfo = async (tokenId, info="name") => {
        if(walletAddress != "") {
            try{
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                const contract = new SorobanClient.Contract(tokenId);
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call(info)
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                return (SorobanClient.scValToNative(transactionMeta.result.retval)); 
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
                const server = new SorobanClient.Server(stellarServer); 
                const account = await server.getAccount(walletAddress);
                const contract = new SorobanClient.Contract(tokenId);
                address = new SorobanClient.Address(address);address = address.toScVal()
                let transaction = new SorobanClient.TransactionBuilder(account, { fee, networkPassphrase:networkUsed})
                    .addOperation(
                        contract.call('balance', address)
                    )
                    .setTimeout(timeout) //using a time out of a hour
                    .build();
                //Simulate the transaction to discover the storage footprint, and update the
                transaction = await server.prepareTransaction(transaction);
                let transactionMeta = (await server.simulateTransaction(transaction))
                return (SorobanClient.scValToNative(transactionMeta.result.retval)); 
            }
            catch(e) {
                return false
            }
        }
        else {return false}
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
            console.log(url)
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
    
    //check if subdomain exists
    const isSubDomainExists = async (domain) => {
         try {
            const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=subdomain&value=" + domain
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
    
 
       
    /* UTILITIES */
    
    /** This functions show a modal message
     * @params {msg} String
     * @params {type} String [good|fail|warn|norm]
     * @return {int} ModalId
    **/
    const talk = (msg = "", type = "norm", id = "") => {
        //config stylings
        let params = {color:"black"}
        if(type == "good") {params.color = "forestgreen"}
        else if(type == "fail") {params.color = "red"}
        else if(type == "warn") {params.color = "#ffa101"}
        if(id != "") {
            //performing modifications
            E(id).style.color = params.color
            E(id).style.borderColor = params.color
            E(id).innerHTML = msg
        }
        else {
            //generate id
            id = 'talk_' + Math.floor(Math.random() * 10000000 * Math.random())
            let div = document.createElement('div')
            div.innerHTML =  `
                <div style='position:fixed;top:0px;left:0px;width:100vw;height:0px;display:flex;align-items:flex-start;z-index:1500'>
                    <div id='${id}' style='margin-left:auto;margin-right:20px;margin-top:40px;background:white;
                    padding:10px 15px;border-radius:10px;border:1px solid ${params.color};color:${params.color};font-size:17px;box-shadow:0 0 6px 3px rgba(0,0,0,.1)'>
                    ${msg}</div></div>
            `
            document.body.appendChild(div.firstElementChild)
        }
        return id
    }
    //Remove
    const stopTalking = (_timeout, id) => {
        if(_timeout > 0) {
            //using timeout
            setTimeout(() => {document.body.removeChild(E(id).parentElement)}, _timeout * 1000)
        }
        else {
            //not using timeout
            document.body.removeChild(E(id).parentElement)
        }
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
    /** Encode toml special characters
     * to allow for safe parsing
     * @params {value} String
    **/
    
    
    /** Validate image upload 
    * params {id} String - the id of the file element
    * params {dispId} String - the id of the elemnt to display the image
    * params {type: 1[background] |2 [src]} Integer - specifies if its background or src that would be changes
    */
    const validateImageUpload =  (id, dispId, type = 1) => {
        E(id).onchange = (event) => {
                const fileInput = E(id);
                  // Check if a file is selected
                  if (fileInput.files.length === 0) {
                    stopTalking(4, talk("Please select a file.", "warn"));
                    fileInput.files = []
                    return;
                  }
                  
                  // Check the file size (max size: 3MB)
                  const maxSize = 3 * 1024 * 1024; // 3MB in bytes
                  if (fileInput.files[0].size > maxSize) {
                    stopTalking(4, talk("File size exceeds the maximum allowed (3MB).", "warn"));
                    fileInput.files = []
                    return;
                  }
                  // Check if the selected file is an image
                  if (!fileInput.files[0].type.startsWith('image/')) {
                    stopTalking(4, talk("Please select an image file.", "warn"));
                    fileInput.files = []
                    return;
                  }
                  
                  const imageURL = URL.createObjectURL(fileInput.files[0]);
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
    }
    
    
    
</script>
