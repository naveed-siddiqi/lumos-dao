'use client'

import * as StellarSdk from '@stellar/stellar-sdk';
import * as SClient  from 'soroban-client'

/* SAVE CONSTANTS VARIABLES */
export const API_URL = 'https://lumosdao.io/.well-known/asset.php?type='
export const TOML_URL = 'lumosdao.io'
export const BACKEND_API="https://lumosdaobackend.pro"
/* STELLARS */
export const stellarServer = "https://mainnet.stellar.validationcloud.io/v1/vfYPZayzy34E4hjJzTtSdM9-f1lWYg-ZI5EoLcNK4Jg"
export const horizonServer = "https://horizon.stellar.org" 
export const stellarExpert = "https://stellar.expert/explorer/public"  
export const daoContractId = 'CD72N4EC32ND2ZVAUAALVJFQ6D3RRS5EM4TWJZH7U7E4PTEES7CKB6EM'  
export const wrappingAddress = 'GASMDOYAEWJ5OY3JVRUV63TH6WL37RQN5GQRYUQB3LEF2MLAYYVSPNFY'
export const networkUsed = StellarSdk.Networks.PUBLIC  
export const networkWalletUsed = "PUBLIC"  
export const walletConnectNetwork = 'stellar:pubnet'
export const contract = new StellarSdk.Contract(daoContractId);
export const timeout = 86400 //using a timeout of one day
export const fee = 100;
export const floatingConstant = 1E10;
export const version = 'v1.0'
export const S = SClient; 
export const SorobanClient = StellarSdk.SorobanRpc
export const server = new StellarSdk.SorobanRpc.Server(stellarServer);
// Your web app's Firebase configuration 
export const firebaseConfig =  {
    apiKey: "AIzaSyB5hDEHEVhcj0rTEdso23UXEWcBHyN6wCU",
    authDomain: "lumosdao-6551e.firebaseapp.com",
    projectId: "lumosdao-6551e",
    storageBucket: "lumosdao-6551e.appspot.com",
    messagingSenderId: "436082192757",
    appId: "1:436082192757:web:6bca71b77f7026ba99e33c",
    measurementId: "G-S9BP1YQ5RS"
};
  
//wallet connect init
export const walletConnectConfig = {
    projectId: process.env.NEXT_PUBLIC_WALLET_CONNECT_ID,
    metadata: {
    name: 'Lumos Dao',
    description: 'Create DAOs on Lumos Dao',
    url: 'https://app.lumosdao.com/',
    icons: ["https://lumosdao.io/public/images/Image.png"]
    },
    client: undefined // optional instance of @walletconnect/sign-client
}
export const walletConnectNameSpace = {
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
}