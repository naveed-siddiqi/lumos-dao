import Link from 'next/link'
import React from 'react'

const TermsAndCondition = () => {
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px]'>
        <p className='font-[500] text-[40px] mb-10'>Terms and Conditions for LumosDAO</p>
        <div className='flex flex-col gap-12'>
          <div>
            <p className='font-[600] mb-4'>Use of Our Services</p>
            <p>Your use of the LumosDAO website <Link href='http://www.lumosdao.com'>(www.lumosdao.com)</Link> , its interface, software, services, and any other related applications, software, or services provided by LumosDAO or any third party authorized by LumosDAO is subject to the following terms (the "Terms"). By accessing or using LumosDAO, you agree to be bound by these Terms.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Acceptance of Terms</p>
            <p>By using LumosDAO, you confirm that you are at least 18 years old and have the legal capacity to enter into this agreement. If you are representing a legal entity, you have the authority to bind that entity to these Terms. If you do not agree to these Terms, you must not use the services provided by LumosDAO.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Changes to the Terms</p>
            <p>LumosDAO reserves the right to modify these Terms at any time. Any updates will be posted on our website. Continued use of LumosDAO services after changes to the Terms signifies your acceptance of the revised Terms.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Privacy Policy</p>
            <p>Please refer to our Privacy Policy for details on how we collect, use, and share your personal information. By using LumosDAO, you agree to our data collection and use practices as outlined in the Privacy Policy.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>LumosDAO Account</p>
            <p>To access certain services, you may need to create an account. You are responsible for maintaining the confidentiality of your account information, including your password and any cryptoasset keys. You must not allow unauthorized access to your account, and LumosDAO is not liable for any unauthorized use of your account.</p>
            <ul className='mt-3 list-disc ml-8'>
              <li>Accounts created by bots or automated systems are prohibited.</li>
              <li>You must be 18 years or older to open an account.</li>
              <li>LumosDAO reserves the right to suspend or terminate your account in case of a violation of the Terms.</li>
            </ul>
          </div>
          <div>
            <p className='font-[600] mb-4'>User Responsibilities and Risks</p>
            <p>By using LumosDAO, you acknowledge and accept the risks associated with using decentralized platforms and blockchain networks, including but not limited to the risk of hardware or software failure, network disruptions, or unauthorized access. LumosDAO is not responsible for any loss of funds, data, or transactions due to these risks.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Fees</p>
            <p>Currently, LumosDAO does not charge a fee for DAO creation, proposal submission, or voting on the platform. However, this may change in the future, and any applicable fees will be communicated to users before implementation. Network fees associated with blockchain transactions are the responsibility of the user.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Use of $LUMOS Tokens</p>
            <p>$LUMOS tokens will be required to perform certain actions on the platform, such as creating DAOs, submitting proposals, and voting. The specific fees for these actions will be clearly outlined within the platform.</p>
            <p>Example fees:</p>
            <ul className='mt-3 list-disc ml-8'>
              <li> 50 $LUMOS for DAO creation</li>
              <li> 5 $LUMOS for proposal submission</li>
              <li> 0.5 $LUMOS per vote cast</li>
            </ul>
          </div>
          <div>
            <p className='font-[600] mb-4'>Intellectual Property</p>
            <p>All content, features, and materials provided through LumosDAO are the intellectual property of LumosDAO. Users are not permitted to copy, reproduce, or distribute materials from LumosDAO without prior written consent.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Third-Party Services</p>
            <p>LumosDAO may provide links or integrate with third-party services. LumosDAO is not responsible for the content, performance, or policies of these third-party services. Users should review the terms of use and privacy policies of any third-party services they engage with.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Limitations of Liability</p>
            <p>LumosDAO provides its services "as is" and makes no warranties regarding the performance, reliability, or availability of its platform. LumosDAO is not responsible for any direct, indirect, or consequential losses incurred through the use of its services, including the loss of digital assets.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Governing Law</p>
            <p>These Terms are governed by the laws of the jurisdiction in which LumosDAO operates. Any disputes arising out of the use of LumosDAO services shall be resolved in accordance with local laws.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Termination</p>
            <p>You may terminate your LumosDAO account at any time. However, LumosDAO reserves the right to suspend or terminate your account if you violate any of these Terms or engage in activities deemed harmful to the platform.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Indemnification</p>
            <p>By using LumosDAO, you agree to indemnify and hold harmless LumosDAO, its affiliates, and employees from any claims, damages, or expenses arising from your use of the platform, violation of these Terms, or infringement of third-party rights.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Control Over Wallets and Network</p>
            <p>LumosDAO does not hold or manage your crypto wallets, secret keys, or assets. When you use LumosDAO, you are interacting directly with the Stellar blockchain or any other integrated blockchain network. LumosDAO does not have access to your private keys, nor do we have control over transactions on the Stellar network or any other network.</p>
            <p>Any transactions made through LumosDAO are irreversible and entirely dependent on the blockchain protocols. LumosDAO is not responsible for network disruptions, delays, or failures related to the blockchain technology you interact with.</p>
          </div>
          <div>
            <p className='font-[600] mb-4'>Zero Tolerance for Scam Projects</p>
            <p>LumosDAO has a zero-tolerance policy towards scam projects and fraudulent activities. Any DAOs or users found to be engaging in scams, fraudulent activities, or deceptive practices will be immediately banned from the platform, and their accounts will be terminated without notice. LumosDAO reserves the right to investigate suspicious activity and take appropriate action to protect the community.</p>
            <p>We strongly encourage users to report any suspicious or fraudulent activity. Ensuring the integrity and trustworthiness of DAOs on the platform is our top priority.</p>
          </div>
            
        </div>
    </div>
  )
}

export default TermsAndCondition