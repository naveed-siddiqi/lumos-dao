import Link from 'next/link'
import React from 'react'

const PrivacyPolicy = () => {
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px]'>
        <p className='font-[500] text-[40px] mb-10'>Privacy Policy</p>
        <div className='flex flex-col gap-12'>
            <div>
                <p className='font-[600] mb-4'>LumosDAO Privacy Policy</p>
                <p>By accessing and using the LumosDAO website <Link href="http://www.lumosdao.com">(www.lumosdao.com)</Link>, you are indicating your consent to the privacy practices outlined in this policy. If you do not accept these practices, please refrain from using the LumosDAO website or its services. LumosDAO reserves the right to modify this policy at any time. Continued use of the website or services after such changes have been posted will signify your acceptance of the updated policy. We encourage you to periodically review this page for any updates.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Information We Collect and How We Use It</p>
                <p>At LumosDAO, we respect your privacy and are committed to protecting the information you provide. We do not sell or distribute user information to third parties unless legally required. We collect user data to improve the platform and respond to your requests. The information collected helps us provide a better user experience and facilitate LumosDAO services.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Data Security Compliance</p>
                <p>LumosDAO is committed to protecting the security and privacy of your data. We use commercially reasonable efforts to safeguard your personal information, including firewalls, encryption, and password-protected databases with restricted access. While we strive to protect your data, we cannot guarantee that unauthorized access or accidental disclosure won’t occur.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Collecting User Information</p>
                <p>LumosDAO collects information about visitors to the site indirectly through our internet access logs. When you visit LumosDAO, your browser’s domain name and IP address may be logged for analytical purposes to help us understand which sections of the website are most visited.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Usage of Personal Information</p>
                <p>Personal Information refers to data that can be used to identify an individual, such as your name, address, email, and other contact details. In general, you can visit LumosDAO without revealing any Personal Information. However, if you choose to provide us with your Personal Information, it may be used within LumosDAO or shared with trusted third-party service providers to facilitate services. LumosDAO ensures that all data transfers comply with applicable laws, even when transferred across jurisdictions.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Use of Cookies</p>
                <p>LumosDAO may use cookies to track visitor interactions with the website. Cookies do not personally identify users unless they voluntarily provide that information. If you prefer, you can disable cookies in your browser’s settings. However, disabling cookies may affect your ability to access certain features of the website.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Disclosure of User Information</p>
                <p>LumosDAO does not rent, sell, or share your personal information with unaffiliated third parties. If you provide information via email or web forms, it will only be shared within LumosDAO and trusted affiliates who are responsible for processing your requests. We may disclose your information to trusted partners under strict confidentiality agreements or as required by law to prevent illegal activities or threats to physical safety.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Links to Third-Party Sites</p>
                <p>LumosDAO may provide links to third-party websites for your convenience. LumosDAO is not responsible for the content, privacy practices, or accuracy of these third-party sites. If you access these links, please be aware that you are subject to their privacy policies and terms.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Data Security Best Practices</p>
                <p>LumosDAO does not hold or manage your crypto wallets or assets. You are responsible for maintaining the security of your private keys and wallet information. LumosDAO cannot access your private keys, and we strongly recommend that you store them securely. LumosDAO interacts directly with the Stellar blockchain and other blockchain networks, and transactions made through LumosDAO are irreversible once confirmed.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Changes to This Privacy Policy</p>
                <p>LumosDAO may update this Privacy Policy from time to time to reflect changes in our practices or for other operational, legal, or regulatory reasons. We encourage you to check this page periodically to stay informed about how we are protecting your personal data.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Contact Information</p>
                <p>If you have any questions or concerns about this Privacy Policy, or if you wish to update, delete, or access your personal information, please contact us at support@lumosdao.com.</p>
            </div>
        </div>
    </div>
  )
}

export default PrivacyPolicy