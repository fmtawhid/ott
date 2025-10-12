<?php

namespace Modules\Page\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Page\Models\Page;
use Modules\MenuBuilder\Models\MenuBuilder;
use Illuminate\Support\Facades\Schema;



class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        \DB::table('pages')->delete();

        \DB::table('pages')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'sequence' => NULL,
            'description' => '<p data-pm-slice="0 0 []">Iqonic Design Streamit Laravel (&ldquo;we,&rdquo; &ldquo;our,&rdquo; or &ldquo;us&rdquo;) is committed to protecting your privacy. At Iqonic Design, we are committed to protecting your privacy and ensuring that your personal information is handled securely.</p>
<p>This Privacy Policy applies to our website, and its associated subdomains (collectively, our &ldquo;Service&rdquo;) alongside our application, Iqonic Design Streamit Laravel. By accessing or using our Service, you signify that you have read, understood, and agree to our collection described in this Privacy Policy and our Terms of Service.</p>
<p>This Privacy Policy outlines how we collect, use, and safeguard your data when you use Streamit Laravel.</p>
<p><strong>1. Introduction </strong></p>
<p>At Iqonic Design, we are dedicated to safeguarding your privacy and ensuring your personal data is handled securely. This Privacy Policy explains how we collect, use, and protect your information when you use our services through the Streamit Laravel platform, including our website and associated applications. By accessing or using our services, you acknowledge that you have read and understood this Privacy Policy and agree to its terms.</p>
<p><strong>2. Information We Collect </strong></p>
<p>We may collect several types of information when you use Streamit Laravel, including:</p>
<p><strong>- Personal Information:</strong> Information you provide, such as your name, email address, payment information (e.g., credit card details), and any other personal information required for account creation and subscription services.</p>
<p><strong>- Usage Data:</strong> Details about how you interact with the platform, such as your IP address, browser type, device details, pages you visit, and your streaming activity. This data helps us optimize your experience and improve our service.</p>
<p><strong>- Cookies and Tracking Technologies:</strong> We use cookies and similar technologies to track user preferences, enhance your experience, and analyze traffic. You can manage your cookie settings through your browser.</p>
<p><strong>3. How We Use Your Information </strong></p>
<p>We collect and use your information to:</p>
<p><strong>- Provide Streaming Services:</strong> To deliver content, manage user accounts, and personalize recommendations based on your viewing habits.</p>
<p><strong>- Process Transactions:</strong> For managing subscriptions, handling payments securely, and maintaining transaction histories.</p>
<p><strong>- Improve User Experience:</strong> Analyze how users interact with the platform to improve navigation, content suggestions, and overall performance.</p>
<p><strong>- Communications:</strong> Send important notifications related to service updates, billing, and personalized marketing content based on your preferences (you can opt out of marketing communications).</p>
<p><strong>- Security:</strong> Use collected information to ensure the security of the platform, prevent fraud, and monitor potential misuse.</p>
<p><strong>4. Data Sharing and Disclosure </strong></p>
<p>WWe value your privacy and do not sell, rent, or disclose your personal information to third parties except in the following circumstances:</p>
<p><strong>- Service Providers:</strong> We may share your data with third-party service providers, such as payment processors or cloud storage providers, solely to help us deliver our services. These providers are bound by strict confidentiality agreements and are only authorized to use your information for the purpose of providing services to us.</p>
<p><strong>- Legal Requirements:</strong> We will only disclose your personal information if required by law, such as to comply with a legal obligation, or in response to valid legal processes like subpoenas, court orders, or other government demands. This will only occur when we have a legal basis to do so.</p>
<p>-<strong> Business Transfers (If Applicable):</strong> In the event that Iqonic Design undergoes a business transition such as a merger, acquisition, or sale of all or part of our assets, your information may be transferred as part of the transaction. If such a transfer occurs, we will notify you and ensure that the new entity adheres to this Privacy Policy or offers similar protections.</p>
<p><strong>5. Your Rights </strong></p>
<p>You have certain rights regarding your personal information, including:</p>
<p><strong>- Streamit LaravelAccess and CorrectionStreamit Laravel:</strong> You may access, correct, or update your personal data through your account settings.</p>
<p><strong>- Streamit LaravelDeletionStreamit Laravel:</strong> You may request the deletion of your account and associated data by contacting our support team.</p>
<p><strong>- Streamit LaravelData PortabilityStreamit Laravel:</strong> You have the right to request your personal data in a structured, machine-readable format to transfer to another service provider.</p>
<p><strong>- Streamit LaravelOpting Out of Marketing CommunicationsStreamit Laravel:</strong> You can opt out of receiving promotional emails or other communications at any time by adjusting your account settings or contacting us.</p>
<p><strong>6. Data Security </strong></p>
<p>We take the protection of your personal data very seriously and prioritize its security using a range of industry-standard security measures. These measures are designed to safeguard your information from unauthorized access, disclosure, or misuse. Our security practices include the use of encryption, secure data storage systems, firewalls, and regular security audits to detect vulnerabilities. In addition to these technical measures, we employ strict internal policies to control access to sensitive data, ensuring that only authorized personnel can handle it.</p>
<p>Despite our efforts to implement strong security systems, it\'s important to recognize that no method of transmission over the internet or method of electronic storage is completely secure. As such, while we are committed to doing our utmost to protect your personal information, we cannot guarantee absolute security. If you suspect any breach or unauthorized access to your account, please notify us immediately so we can take appropriate action to secure your data.</p>
<p><strong> 7. Children&rsquo;s Privacy </strong></p>
<p>The Streamit Laravel platform is designed for use by individuals aged 13 and older. We are committed to protecting the privacy of children and do not knowingly collect personal information from individuals under the age of 13. In compliance with the Children&rsquo;s Online Privacy Protection Act (COPPA) and similar regulations, we take precautions to avoid collecting any data from minors.</p>
<p>If you are a parent or guardian and become aware that your child has provided us with personal information without your consent, please contact us immediately. Upon receiving such a request, we will promptly review and remove the child\'s information from our system to ensure it is not used or stored. We take the privacy of minors seriously, and we will act quickly to address any concerns.</p>
<p><strong>8. Changes to This Privacy Policy </strong></p>
<p>Our privacy practices may evolve over time as we introduce new features, services, or update our operational procedures. To ensure transparency, we reserve the right to make changes to this Privacy Policy from time to time. Such updates may reflect changes in legal requirements, our business practices, or the introduction of new technologies.</p>
<p>In the event of any significant modifications to the way we collect, use, or store your data, we will provide you with clear notification either via email or by placing a prominent notice on our platform. We encourage you to review this Privacy Policy periodically to stay informed of any updates or changes. Your continued use of our services after changes have been made constitutes your acceptance of the updated policy.</p>
<p><strong>9. Contact Us </strong></p>
<p>If you have any questions, concerns, or require further clarification regarding this Privacy Policy, our team is here to help. We value open communication with our users and are committed to addressing any concerns related to your personal data and privacy.</p>
<p>You can contact us via the following email:</p>
<p><strong>- Email:</strong> hello@iqonic.design</p>
<p>We aim to respond to all queries in a timely manner and ensure that your privacy concerns are addressed effectively.</p>
<p><strong>10. Data Deletion Request </strong></p>
<p>We are committed to providing you with control over your personal information and ensuring that your data is handled in accordance with your preferences. If at any time you wish to request the deletion of your personal data from our servers, we offer a straightforward process to facilitate this.</p>
<p>To request the deletion of your data, please send an email from your registered email address to our dedicated privacy inbox at hello@iqonic.design. Include the subject line "Data Deletion Request" and provide any necessary details regarding your account. Upon receiving your request, our team will thoroughly review the provided information, verify your identity, and proceed with the deletion of your data as required by our privacy policies and applicable legal obligations.</p>
<p>Please note that certain legal requirements or regulatory obligations may require us to retain certain information for a specified period, even after a deletion request has been made. However, we will ensure that any retained data is handled securely and in compliance with relevant privacy laws.</p>
<p>&nbsp;</p>
<p><strong>This privacy policy helps ensure transparency and clarity about how Iqonic Design handles your data within Streamit Laravel. </strong></p>
<p><strong>Thank you for using Streamit Laravel. Your privacy is important to us, and we are committed to safeguarding your personal information.&nbsp;&nbsp;</strong></p>',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 03:49:15',
                'updated_at' => '2024-10-17 12:07:43',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'sequence' => NULL,
                'description' => '<p>Welcome to Streamit Laravel, a premier streaming platform developed by Iqonic Design. By accessing or using our services, you agree to comply with and be bound by these Terms and Conditions. These terms outline your rights and responsibilities when using our platform, and we encourage you to read them carefully. If you do not agree with these terms, please refrain from using the service.</p>
<p><strong>1. Acceptance of Terms</strong></p>
<p>By using Streamit Laravel, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions. This agreement serves as a legally binding contract between you and Iqonic Design. If you do not agree to any of these terms, please refrain from using our services. We reserve the right to update these terms at any time, and it is your responsibility to review them periodically for changes.</p>
<p><strong>2. Eligibility</strong></p>
<p>To access and use Streamit Laravel, you must be at least 18 years old or the age of majority in your jurisdiction. If you are under 18, you may only use the service under the supervision of a parent or legal guardian who agrees to these Terms and Conditions. By using the service, you represent that you meet these eligibility requirements and that you are legally able to enter into this agreement. We reserve the right to terminate your account if you do not meet these criteria.</p>
<p><strong>3. User Accounts</strong></p>
<p>To access certain features of Streamit Laravel, you may be required to create a user account. When creating an account, you agree to provide accurate, complete, and up-to-date information, including your name, email address, and any other required details. You are responsible for maintaining the confidentiality of your account information, including your password. Any activity performed using your account is your responsibility, and you agree to notify us immediately of any unauthorized use of your account or any other breach of security. We are not liable for any loss or damage arising from your failure to comply with these requirements.</p>
<p><strong>4. Subscription Plans</strong></p>
<p>Streamit Laravel offers a variety of subscription plans, each with different features and benefits tailored to meet the needs of our diverse user base. By subscribing, you agree to pay the applicable fees associated with your chosen plan, which will be billed in advance on a recurring basis. Subscription fees are non-refundable, except as specified in our refund policy. The specific features of each subscription plan are detailed on our platform. We reserve the right to modify, enhance, or discontinue any plan at our discretion, ensuring that we continuously provide value to our users.</p>
<p><strong>5. Payment and Billing</strong></p>
<p>Payments for subscriptions are processed through secure third-party payment gateways, including Stripe, RazorPay, Paystack, PayPal, and FlutterWave. You are responsible for providing accurate and complete payment information. If the payment is not successfully processed due to insufficient funds, expired card information, or any other reason, we reserve the right to suspend or terminate your account. All fees are subject to applicable taxes, and you are responsible for paying any additional charges incurred in your region. By providing payment information, you authorize us to charge the payment method for the subscription fees and any other applicable charges.</p>
<p><strong>6. Content Access and Usage</strong></p>
<p>Upon subscribing, you are granted a limited, non-exclusive, non-transferable license to access and view the content available on Streamit Laravel for personal, non-commercial use. This license is intended solely for your enjoyment and personal viewing. You may not reproduce, distribute, modify, publicly display, publicly perform, republish, download, or store any content from the service without obtaining prior written consent from us. All content remains the property of Iqonic Design or its content providers, and unauthorized use of the content may result in legal action.</p>
<p><strong>7. Intellectual Property</strong></p>
<p>All content available on Streamit Laravel, including but not limited to movies, TV shows, graphics, logos, software, and any associated trademarks, is protected by copyright, trademark, and other intellectual property laws. You agree not to infringe, violate, or misuse any intellectual property rights belonging to Iqonic Design or third-party content providers. Unauthorized use of the content may lead to civil and criminal penalties. If you wish to use any content for commercial purposes, you must obtain prior written permission from the rightful owner.</p>
<p><strong>8. Prohibited Activities</strong></p>
<p>While using Streamit Laravel, you agree not to engage in any unlawful activities or conduct that violates these Terms and Conditions. This includes, but is not limited to:</p>
<p>- Uploading or distributing malicious software, viruses, or any other harmful code.</p>
<p>- Interfering with the security of the service or the experience of other users.</p>
<p>- Attempting to bypass any content protection mechanisms or access restricted areas of the platform.</p>
<p>- Sharing your login credentials with others or using another user\'s account without permission. Engaging in any of these prohibited activities may result in immediate termination of your account and potential legal action.</p>
<p><strong>9. Third-Party Links</strong></p>
<p>Streamit Laravel may contain links to third-party websites or services that are not owned or controlled by Iqonic Design. We have no control over, and assume no responsibility for, the content, privacy policies, or practices of any third-party sites. Your interactions with these third-party services are governed by their own terms and policies. We encourage you to read the terms and conditions of any third-party website you visit. Iqonic Design is not responsible for any damages or losses caused by your use of these third-party services.</p>
<p><strong>10. Termination of Service</strong></p>
<p>We reserve the right to suspend or terminate your access to Streamit Laravel at any time, with or without notice, if you breach these Terms and Conditions or engage in conduct that we deem harmful to the platform or other users. In the event of termination, your right to use the service will immediately cease, and you may lose access to any content associated with your account. We will not be liable to you or any third party for any termination of your access to the service. Upon termination, any provisions of these terms that, by their nature, should survive termination shall remain in effect.</p>
<p><strong>11. Limitation of Liability</strong></p>
<p>In no event shall Iqonic Design or its affiliates be liable for any indirect, incidental, special, or consequential damages arising from your use or inability to use the Streamit Laravel service. This includes, but is not limited to, damages for loss of profits, data, or other intangible losses, even if we have been advised of the possibility of such damages. Your sole remedy for dissatisfaction with the service is to stop using it. Our liability for any claims arising out of these Terms and Conditions shall not exceed the total amount paid by you for the service during the twelve (12) months preceding the claim.</p>
<p><strong>12. Disclaimer of Warranties</strong></p>
<p>The Streamit Laravel service is provided "as is" and "as available." Iqonic Design makes no warranties or representations about the accuracy, reliability, or availability of the service. We disclaim all warranties, whether express or implied, including but not limited to implied warranties of merchantability, fitness for a particular purpose, and non-infringement. We do not guarantee that the service will be uninterrupted, secure, or error-free, and we are not responsible for any interruptions or errors in the service. Your use of the service is at your own risk.</p>
<p><strong>13. Modifications to Terms</strong></p>
<p>We reserve the right to modify these Terms and Conditions at any time. Any changes will be effective immediately upon posting on our platform. Your continued use of the service after the changes means you accept the new terms. We encourage you to review these Terms regularly to stay informed of any updates. If you do not agree with any changes, you should stop using the service. Continued access to Streamit Laravel after modifications indicates your acceptance of the updated terms.</p>
<p><strong>14. Governing Law</strong></p>
<p>These Terms and Conditions shall be governed by and construed in accordance with the laws of the jurisdiction in which Iqonic Design operates. Any legal actions arising from these terms must be filed in the appropriate courts of that jurisdiction. If any provision of these terms is found to be unenforceable, the remaining provisions will remain in full force and effect. By using Streamit Laravel, you consent to the exclusive jurisdiction of the courts located in that jurisdiction.</p>
<p><strong>15. Contact Us</strong></p>
<p>If you have any questions, concerns, or comments about these Terms and Conditions, please contact us at:</p>
<p>- Email: hello@iqonic.design</p>
<p><strong>We appreciate your cooperation and understanding of these Terms and Conditions. They are designed to protect both your rights and those of our users, ensuring a secure and enjoyable streaming experience on Streamit Laravel.</strong></p>
<p>&nbsp;</p>',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 03:49:15',
                'updated_at' => '2024-10-17 12:08:56',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Help and Support',
                'slug' => 'help-and-support',
                'sequence' => NULL,
                'description' => '<p>Welcome to Streamit Laravel Help &amp; Support! At Iqonic Design, we strive to offer you the best streaming experience possible. Should you have any questions, concerns, or need assistance with Streamit Laravel, you&rsquo;ve come to the right place. Our dedicated support team is here to help you with technical issues, general queries, and everything in between. We are committed to ensuring a smooth and enjoyable streaming experience.</p>
<p><strong>Frequently Asked Questions (FAQs)</strong></p>
<p>Before contacting us, we highly recommend checking our [FAQ Page] for common issues and their solutions. We continuously update this page to address frequently asked user queries, offering you the quickest route to a solution.</p>
<p><strong>Contact Support</strong></p>
<p>If you need further assistance, feel free to contact our support team at:</p>
<p>📧 <strong>Email: hello@iqonic.design</strong></p>
<p>We aim to respond to all queries within 24 to 48 hours (Monday through Friday). Our priority is resolving your issue as swiftly as possible.</p>
<p><strong>How Can We Assist You?</strong></p>
<p>Our support services include:</p>
<p><strong>1. Account &amp; Subscription Issues&nbsp;&nbsp;</strong></p>
<p>&nbsp; &nbsp;- Experiencing issues with your account setup, subscription, or payments? We&rsquo;re available to assist with any difficulties you encounter during the process of managing your account or subscription plan.</p>
<p><strong>2. App Navigation &amp; Features&nbsp;&nbsp;</strong></p>
<p>&nbsp; &nbsp;- Whether you\'re a new user or need help with specific features, we can guide you. Streamit Laravel is designed with user-friendly features, and we are here to help you make the most out of them.</p>
<p><strong>3. Technical Support&nbsp;&nbsp;</strong></p>
<p>&nbsp; &nbsp;- Facing technical difficulties with the app? Our technical team is prepared to assist with any malfunctions, connectivity problems, or performance issues to ensure that your streaming experience is uninterrupted.</p>
<p><strong>4. Content Inquiries&nbsp;</strong>&nbsp;</p>
<p>&nbsp; &nbsp;- Do you have questions about our content? We&rsquo;re happy to clarify any concerns regarding the availability, features, or quality of the content in our library.</p>
<p><strong>5. Feedback &amp; Suggestions&nbsp;&nbsp;</strong></p>
<p>&nbsp; &nbsp;- We value your feedback! Your input helps us improve your experience, and we carefully consider all suggestions and reported issues.</p>
<p><strong>Quick Assistance Steps</strong></p>
<p><strong>For a faster response, follow these steps:</strong></p>
<p>1. Check our FAQ page to see if your issue has already been addressed.</p>
<p>2. Email us at hello@iqonic.design with your query.</p>
<p>3. Include the following details for faster resolution:</p>
<p>- Your device model and operating system (OS) version.</p>
<p>- A brief description of the issue.</p>
<p>- Screenshots or steps to replicate the problem (if applicable).</p>
<p><strong>Help Us Help You</strong></p>
<p>To help us serve you better, please provide the following information in your support request:</p>
<p>- Your registered email address associated with Streamit Laravel.</p>
<p>- A detailed description of the issue you\'re experiencing.</p>
<p>- Any relevant steps to replicate the problem, including device and app information.</p>
<p>&nbsp;</p>
<p><strong>We are committed to ensuring your experience is smooth and enjoyable. Our team works diligently to resolve all queries and technical issues, helping you return to your seamless streaming experience as quickly as possible.</strong></p>
<p><strong>Thank you for choosing Streamit Laravel! Your satisfaction is our top priority, and we&rsquo;re always here to assist you with any concerns or questions.</strong></p>',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 03:49:15',
                'updated_at' => '2024-10-17 12:14:35',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Refund and Cancellation Policy',
                'slug' => 'refund-and-cancellation-policy',
                'sequence' => NULL,
                'description' => '<p>At Iqonic Design, we strive to ensure our customers have a seamless experience with Streamit Laravel. Please read our Refund and Cancellation Policy carefully to understand your rights and obligations.</p>
<p><strong>1. Subscription Cancellations</strong></p>
<p>You may cancel your subscription to Streamit Laravel at any time. Upon cancellation:</p>
<p><strong>- Continued Access:</strong> You will retain access to premium content and services until the end of your current billing cycle. There will be no disruption in service during this period.</p>
<p><strong>- No Refund for Partial Periods:</strong> We do not provide refunds for unused portions of the subscription period. Your access will remain until the next billing date.</p>
<p><strong>- How to Cancel:</strong> To cancel your subscription, visit your account settings in the app or contact our support team at hello@iqonic.design. Ensure that you follow the instructions clearly to avoid any confusion regarding cancellation timing.</p>
<p><strong>2. Refund Eligibility</strong></p>
<p><strong>Refunds may be granted under the following circumstances:</strong></p>
<p><strong>- Accidental Billing:</strong> If you were incorrectly charged due to a technical error or duplicate billing, please contact us immediately to resolve the issue.</p>
<p><strong>- Unauthorized Transactions:</strong> In the event your account was used without your permission, please notify us within 7 days of the transaction to be eligible for a refund.</p>
<p><strong>Non-Refundable Cases:</strong></p>
<p>Refunds will not be provided under the following circumstances:</p>
<p><strong>- Change of Mind:</strong> If you decide you no longer want the subscription after purchase, we cannot provide a refund.</p>
<p><strong>- Dissatisfaction with Content:</strong> Refunds will not be given solely based on dissatisfaction with the available content unless the service is defective or significantly misrepresented.</p>
<p><strong>- Lack of Usage:</strong> If you do not use the service after subscribing, you will not be eligible for a refund.</p>
<p><strong>3. Refund Process</strong></p>
<p>If you qualify for a refund, the process will be as follows:</p>
<p><strong>- Contact Support:</strong> Email us at hello@iqonic.design with the following details:</p>
<p>&nbsp; * Your registered email address.</p>
<p>&nbsp; * Subscription details (Plan name, Payment Date).</p>
<p>&nbsp; * Reason for the refund request.</p>
<p><strong>- Verification Process:</strong> We will review your request and confirm your eligibility for a refund. Additional information may be requested to complete this verification.</p>
<p><strong>- Processing Time:</strong> Once approved, refunds will be processed within 7&ndash;10 business days. The refunded amount will be credited to the original payment method used during the transaction.</p>
<p><strong>4. Free Trials</strong></p>
<p>If you sign up for a free trial and choose not to continue with a paid subscription, you must cancel before the trial period ends to avoid being charged. No refunds will be provided if the subscription is not canceled before the trial expiration date. Ensure you monitor your trial period closely to avoid unwanted charges.</p>
<p><strong>5. Changes to This Policy</strong></p>
<p>Iqonic Design reserves the right to update or modify this Refund and Cancellation Policy at any time. We will notify users of any significant changes via email or in-app notifications. Continued use of Streamit Laravel after changes are made will signify your acceptance of the revised policy.</p>
<p><strong>6. Contact Us</strong></p>
<p>If you have any questions about this policy or need further assistance, please reach out to us at:</p>
<p><strong>📧 Email: hello@iqonic.design&nbsp;&nbsp;</strong></p>
<p><strong>We are always available to assist with any concerns you may have about refunds or cancellations. Your satisfaction is important to us, and we strive to address any issues promptly.</strong></p>
<p><strong>Thank you for choosing Streamit Laravel and for being a valued customer of Iqonic Design!</strong></p>
<p>Company:<strong>&nbsp;Iqonic Design&nbsp;&nbsp;</strong></p>
<p>Product:<strong>&nbsp;Streamit Laravel&nbsp;&nbsp;</strong></p>
<p>Support Contact:<strong>&nbsp;hello@iqonic.design</strong></p>',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 03:49:15',
                'updated_at' => '2024-10-17 12:34:17',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Data Deletation Request',
                'slug' => 'data-deletation-request',
                'sequence' => NULL,
                'description' => '<p>At Iqonic Design, we value the privacy of our users and are committed to ensuring your personal data is handled securely. If you wish to request the deletion of your data associated with Streamit Laravel, please review the following guidelines.</p>
<p><strong>1. Right to Data Deletion</strong></p>
<p>In accordance with global data protection laws, you have the right to request the deletion of your personal data stored within our systems. Once your request is verified, we will remove your data from our servers unless certain legal obligations require us to retain it.</p>
<p><strong>2. Information We Delete</strong></p>
<p>When submitting a data deletion request, the following data will be removed:</p>
<p><strong>* Personal Information:</strong> Name, email address, phone number, and any other personally identifiable information.</p>
<p><strong>* Account Details:</strong> Subscription history, payment details, and usage data.</p>
<p><strong>* Watchlists and Preferences:</strong> Any watchlist, preferences, or custom content recommendations.</p>
<p><strong>**Please note: After the data is deleted, you will no longer have access to your Streamit Laravel account, and the action is irreversible**</strong></p>
<p><strong>3. How to Submit a Data Deletion Request</strong></p>
<p>To request the deletion of your data:</p>
<p><strong>* Email Request:</strong> Send an email to hello@iqonic.design with the subject line "Data Deletion Request."</p>
<p><strong>* Required Information:</strong> Include the following details in your email:</p>
<p>&nbsp; &nbsp;- Your full name.</p>
<p>&nbsp; &nbsp;- Your registered email address.</p>
<p>&nbsp; &nbsp;- Reason for your data deletion request (optional).</p>
<p><strong>* Verification:</strong> We may contact you to verify your identity before proceeding with the deletion.</p>
<p><strong>4. Processing Time</strong></p>
<p>Upon receiving and verifying your request, we will process the deletion within 30 days. You will be notified once your data has been successfully deleted.</p>
<p><strong>5. Exceptions to Data Deletion</strong></p>
<p>Certain data may not be eligible for deletion if:</p>
<p>- Legal Obligations: We are required to retain your data for legal, regulatory, or contractual reasons.</p>
<p>- Ongoing Transactions: If there are any unresolved issues such as pending transactions, your data may be retained until those issues are resolved.</p>
<p><strong>6. Impact of Data Deletion</strong></p>
<p>Once your data is deleted:</p>
<p>- You will lose access to your Streamit Laravel account.</p>
<p>- Any remaining subscription time will be forfeited, and no refunds will be issued.</p>
<p>- You will need to create a new account if you wish to use our services again in the future.</p>
<p><strong>7. Contact Us</strong></p>
<p>If you have any questions about this policy or need assistance with your data deletion request, please reach out to us at:</p>
<p>📧 Email: hello@iqonic.design&nbsp;&nbsp;</p>
<p>&nbsp;</p>
<p><strong>Our team is here to help you with any concerns related to your personal data and privacy.</strong></p>
<p><strong>Thank you for using Streamit Laravel, and for trusting Iqonic Design with your privacy.</strong></p>',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 03:49:15',
                'updated_at' => '2024-10-17 12:34:36',
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'About Us',
                'slug' => 'about-us',
                'sequence' => NULL,
                'description' => '<p><strong>About Streamit Laravel by Iqonic Design</strong></p>
<p>Welcome to Streamit Laravel, a next-generation streaming platform proudly developed by Iqonic Design. We specialize in creating cutting-edge digital solutions, and Streamit Laravel is our latest breakthrough in the world of online entertainment. Whether you\'re a movie lover, a TV show binge-watcher, or enjoy live events, our platform is designed to deliver high-quality content directly to your device, ensuring a seamless, uninterrupted experience. Streamit Laravel combines advanced technology with a user-friendly interface to cater to audiences worldwide.</p>
<p><strong>Our Mission</strong></p>
<p>Our mission at Iqonic Design is to reshape how digital content is consumed by creating a streaming platform that prioritizes speed, reliability, and personalization. Streamit Laravel is built using the latest technologies to provide users with superior streaming quality, customized recommendations, and an easy-to-use content management system. We are committed to making entertainment accessible and enjoyable for all audiences, whether you\'re at home or on the go.</p>
<p><strong>Why Choose Streamit Laravel?</strong></p>
<p>- Top-Tier Streaming Experience: Dive into high-definition and 4K content with smooth playback, ensuring no buffering even during high-traffic periods.</p>
<p>- Personalized Content Recommendations: Our AI-driven recommendation system curates content based on your viewing history, making it easy to discover your next favorite show or movie.</p>
<p>- Multi-Device Compatibility: Enjoy Streamit Laravel on your mobile, tablet, smart TV, or desktop, with seamless syncing across all devices.</p>
<p>- Exclusive Content &amp; Features: Gain access to exclusive shows, movies, and live events that are unavailable on other platforms, along with features like offline downloads and customizable viewing settings.</p>
<p>- Scalable &amp; Customizable for Developers: Streamit Laravel offers a flexible architecture that developers can tailor to specific needs, with options for scalability and integrations with other platforms.</p>
<p>- Comprehensive Content Management: Our platform is designed for content creators and streamers, allowing them to efficiently manage their movies, TV shows, episodes, and live TV in one easy-to-use dashboard.</p>
<p>- Enhanced Security &amp; Privacy: We employ cutting-edge encryption and security protocols to safeguard your data and protect against unauthorized access or breaches.</p>
<p><strong>Our Vision&nbsp;&nbsp;</strong></p>
<p>We envision a world where entertainment is no longer bound by geographical or technological limitations. With Streamit Laravel, we aim to revolutionize digital content consumption, offering users the flexibility to watch anything, anywhere, at any time. Our vision extends beyond just entertainment&mdash;we seek to empower creators by providing a dynamic platform where they can showcase their content to a global audience while maintaining full control over their media. As technology evolves, so does Streamit Laravel, constantly improving to meet the demands of today&rsquo;s and tomorrow&rsquo;s viewers.</p>
<p><strong>What Sets Us Apart?</strong></p>
<p><strong>- Adaptive Streaming Technology:</strong> Our adaptive bitrate streaming automatically adjusts video quality based on your internet connection, ensuring uninterrupted playback at the highest quality your network supports.</p>
<p><strong>- Collaborative Content Creation:</strong> Streamit Laravel allows content creators to collaborate, share, and co-produce projects, fostering a community of innovation and creativity.</p>
<p><strong>- Immersive Viewing Experience:</strong> Our platform offers advanced features like multi-language subtitles, customizable captions, and interactive content for an enhanced viewing experience.</p>
<p><strong>- Diverse Genre Library:</strong> Explore a wide range of genres, from action and thrillers to romance, horror, and documentaries. Whatever your preference, there&rsquo;s something for everyone on Streamit Laravel.</p>
<p><strong>- Real-Time Notifications &amp; Updates:</strong> Stay updated with new releases, exclusive content, and upcoming live events with personalized notifications based on your preferences.</p>
<p><strong>Connect with Us&nbsp;&nbsp;</strong></p>
<p>We value our community and encourage feedback to help us improve. If you have any questions, suggestions, or require assistance, our support team is ready to help:</p>
<p><strong>📧 Support Email: hello@iqonic.design</strong></p>
<p>Join us in our journey to transform the entertainment landscape with Streamit Laravel&mdash;where technology and creativity come together to offer the ultimate streaming experience.</p>
<p>Company:&nbsp;<strong>Iqonic Design&nbsp;&nbsp;</strong></p>
<p>Product:&nbsp;<strong>Streamit Laravel&nbsp;&nbsp;</strong></p>
<p>Support Contact:&nbsp;<strong>hello@iqonic.design</strong></p>',
                'status' => 1,
                'created_by' => NULL,
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 03:49:15',
                'updated_at' => '2024-10-17 12:33:59',
                'deleted_at' => NULL,
            ),
        ));


    }

}

