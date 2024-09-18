import React from 'react'

const PrivacyPolicy = () => {
  return (
    <div className='px-[3rem] mt-[50px] mb-[80px]'>
        <p className='font-[500] text-[40px] mb-10'>Privacy Policy</p>
        <div className='flex flex-col gap-12'>
            <div>
                <p className='font-[600] mb-4'>Introduction</p>
                <p>LumosDAO is committed to protecting and respecting your privacy. This policy sets out the basis on which any personal data we collect from you, or that you provide to us, will be processed by us.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Information We May Collect From You</p>
                <p>We may collect and process the following data about you:</p>
                <ul className='mt-3 list-disc ml-8'>
                    <li>Information that you provide by filling in forms on our site.</li>
                    <li>Transactional information related to your Stellar wallet and any DAOs or proposals you interact with.</li>
                </ul>
            </div>
            <div>
                <p className='font-[600] mb-4'>Cookies</p>
                <p>Our website uses cookies to distinguish you from other users of our website. This helps us to provide you with a good experience when you browse our website and also allows us to improve our site.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Where We Store Your Personal Data</p>
                <p>The data that we collect from you will be stored on secure servers. We will take all steps reasonably necessary to ensure that your data is treated securely and in accordance with this privacy policy.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Uses Made of the Information</p>
                <p>We use information held about you in the following ways:</p>
                <ul className='mt-3 list-disc ml-8'>
                    <li>To ensure that content from our site is presented in the most effective manner for you and for your computer.</li>
                    <li>To provide you with information or services that you request from us.</li>
                </ul>
            </div>
            <div>
                <p className='font-[600] mb-4'>Disclosure of Your Information</p>
                <p>We may disclose your personal information to third parties if we are under a duty to disclose or share your personal data in order to comply with any legal obligation, or to protect the rights, property, or safety of LumosDAO, our customers, or others.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Changes to Our Privacy Policy</p>
                <p>Any changes we may make to our privacy policy in the future will be posted on this page and, where appropriate, notified to you by email.</p>
            </div>
            <div>
                <p className='font-[600] mb-4'>Contact</p>
                <p>Questions, comments and requests regarding this privacy policy are welcomed and should be addressed to our support team.Questions, comments and requests regarding this privacy policy are welcomed and should be addressed to our support team.</p>
            </div>
        </div>
    </div>
  )
}

export default PrivacyPolicy