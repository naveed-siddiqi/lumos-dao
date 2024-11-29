"use client"

import "./globals.css";
import Navbar from "./components/nav-bar/Navbar";
import Footer from "./components/footer/Footer";
import ConnectWalletModal from "./components/connect-wallet-modal/ConnectWalletModal";
import { useEffect, useState } from "react";
import Head from "next/head";
import SettingsModal from "./components/settings-modal/SettingsModal";
import { Open_Sans } from '@next/font/google';
// import favicon

const metadata = {
  title: "LUMOS DAO",
  description: "LUMOS DAO",
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
    window.CHAIN = (localStorage.getItem('LUMOS_CHAIN') || "").toLowerCase()
    window.E = (id) => document.getElementById(id)     
  }, [])
  return (
    <html lang="en">
      <body style={{ backgroundColor:'#F9FAFB'}}>
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
