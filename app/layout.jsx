"use client"

import "./globals.css";
import Navbar from "./components/nav-bar/Navbar";
import Footer from "./components/footer/Footer";
import ConnectWalletModal from "./components/connect-wallet-modal/ConnectWalletModal";
import { useEffect, useState } from "react";
import Head from "next/head";
import SettingsModal from "./components/settings-modal/SettingsModal";
// import favicon

const metadata = {
  title: "LUMOS DAO",
  description: "LUMOS DAO"
};

export default function RootLayout({ children }) {

  const [connectWallet, setConnectWallet] = useState(false);
  const [settings, setSettings] = useState(false);

  /** TOP LEVEL VARIABLES DECLARATION
   * DO NOT EDIT
   */
  useEffect(() => {
    window.walletAddress = localStorage.getItem('selectedWallet') || ""
    window.WALLET_TYPE = localStorage.getItem('LUMOS_WALLET') || ""
    window.E = (id) => document.getElementById(id)     
  }, [])
  return (
    <html lang="en">
      <Head>
      </Head>
      <body style={{ backgroundColor:'#EFF2F6'}}>
        <link rel="icon" href="/images/Image.png" sizes="any" />
        <div className='min-h-screen flex flex-col'>
          <Navbar setConnectWallet={setConnectWallet} setSettings={setSettings} settings={settings}/>
          <main className='flex-grow'>
            {children}
          </main>
          <footer className='flex-shrink-0'>
            <Footer />
          </footer>
            {
              connectWallet && <ConnectWalletModal setConnectWallet={setConnectWallet}/>  // Only show modal when connectWallet state is true
            }
            {
              settings && (
                <SettingsModal setSettings={setSettings} />
              )
            }
        </div>
      </body>
    </html>
  );
}
