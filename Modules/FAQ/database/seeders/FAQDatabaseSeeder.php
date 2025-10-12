<?php

namespace Modules\FAQ\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\FAQ\Models\FAQ;
use Modules\MenuBuilder\Models\MenuBuilder;

class FAQDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        \DB::table('faqs')->delete();

        \DB::table('faqs')->insert(array (
            0 =>
            array (
                'id' => 1,
                'question' => '1. What is Streamit Laravel?',
                'answer' => 'Streamit Laravel is a cutting-edge streaming platform developed by Iqonic Design that allows users to watch movies, TV shows, and live content seamlessly. It provides a feature-rich experience with personalized recommendations, multiple subscription plans, and high-quality streaming.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:43:30',
                'updated_at' => '2024-09-28 06:43:30',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'question' => '2. How can I create an account on Streamit Laravel?',
                'answer' => 'To create an account, simply click on the "Sign Up" button on the homepage, enter your details, and follow the on-screen instructions. Once registered, you can start exploring our extensive content library.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:44:16',
                'updated_at' => '2024-09-28 06:44:16',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'question' => '3. What subscription plans are available?',
                'answer' => 'We offer multiple subscription plans tailored to your needs:
- Basic Plan: Weekly subscription.
- Premium Plan: Monthly subscription.
- Ultimate Plan: Quarterly subscription.
- Elite Plan: Yearly subscription.
Each plan offers different features such as HD streaming, multi-device support, and download options. Visit our Subscription Plans page for more details.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:44:36',
                'updated_at' => '2024-09-28 06:44:36',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'question' => '4. What payment methods do you accept?',
                'answer' => 'We accept a variety of payment gateways for your convenience:
- Stripe
- RazorPay
- Paystack
- PayPal
- FlutterWave
You can choose your preferred method at checkout.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:44:57',
                'updated_at' => '2024-09-28 06:44:57',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'question' => '5. How can I manage my subscription?',
                'answer' => 'To manage your subscription, log into your account, go to the "Account Settings" section, and select "Subscription." From there, you can upgrade, downgrade, or cancel your plan at any time.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:45:14',
                'updated_at' => '2024-09-28 06:45:14',
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'question' => '6. How can I add content to my watchlist?',
                'answer' => 'While browsing movies or TV shows, simply click on the "Add to Watchlist" button. You can view your watchlist anytime under the "My Watchlist" section of your account dashboard.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:45:33',
                'updated_at' => '2024-09-28 06:45:33',
                'deleted_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'question' => '7. Can I download content for offline viewing?',
                'answer' => 'Yes, Streamit Laravel allows you to download selected content for offline viewing, depending on your subscription plan. This feature is available for both mobile and tablet devices.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:45:48',
                'updated_at' => '2024-09-28 06:45:48',
                'deleted_at' => NULL,
            ),
            7 =>
            array (
                'id' => 8,
                'question' => '8. Does Streamit Laravel support multiple devices?',
                'answer' => 'Yes, you can stream on multiple devices based on your subscription plan. The higher the plan, the more devices you can use simultaneously.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:46:05',
                'updated_at' => '2024-09-28 06:46:05',
                'deleted_at' => NULL,
            ),
            8 =>
            array (
                'id' => 9,
                'question' => '9. How does the recommendation system work?',
                'answer' => 'Our platform uses a smart recommendation engine that suggests content based on your viewing history and preferences. The more you watch, the better the recommendations get!',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:46:21',
                'updated_at' => '2024-09-28 06:46:21',
                'deleted_at' => NULL,
            ),
            9 =>
            array (
                'id' => 10,
                'question' => '10. Is there a free trial available?',
                'answer' => 'Yes, we offer a limited-time free trial for new users. During the trial, you can explore all the features of the platform and decide if you want to subscribe to a full plan.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:46:40',
                'updated_at' => '2024-09-28 06:46:40',
                'deleted_at' => NULL,
            ),
            10 =>
            array (
                'id' => 11,
                'question' => '11. How does the referral program work?',
                'answer' => 'Our referral program rewards you for inviting friends to join Streamit Laravel. For each friend who subscribes using your referral link, you both receive a discount on your next billing cycle. Check the referral section in your account for more details!',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:51:25',
                'updated_at' => '2024-09-28 06:51:25',
                'deleted_at' => NULL,
            ),
            11 =>
            array (
                'id' => 12,
                'question' => '12. What types of content are available on Streamit Laravel?',
                'answer' => 'Streamit Laravel offers a diverse range of content, including movies, TV shows, documentaries, and live events across various genres. You\'ll find everything from action and comedy to horror and romance!',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:51:47',
                'updated_at' => '2024-09-28 06:51:47',
                'deleted_at' => NULL,
            ),
            12 =>
            array (
                'id' => 13,
                'question' => '13. Can I change my subscription plan later?',
                'answer' => 'Absolutely! You can change your subscription plan at any time through your account settings. Simply select a different plan, and your new billing will take effect at the end of your current billing cycle.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:52:05',
                'updated_at' => '2024-09-28 06:52:05',
                'deleted_at' => NULL,
            ),
            13 =>
            array (
                'id' => 14,
                'question' => '14. What should I do if I forget my password?',
                'answer' => 'If you forget your password, click on the "Forgot Password?" link on the login page. Follow the instructions to reset your password via the email associated with your account.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:52:21',
                'updated_at' => '2024-09-28 06:52:21',
                'deleted_at' => NULL,
            ),
            14 =>
            array (
                'id' => 15,
                'question' => '15. Is there any age restriction for using Streamit Laravel?',
                'answer' => 'Yes, users must be at least 13 years old to create an account. We recommend parental guidance for users under 18, as some content may not be suitable for younger viewers.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:52:38',
                'updated_at' => '2024-09-28 06:52:38',
                'deleted_at' => NULL,
            ),
            15 =>
            array (
                'id' => 16,
                'question' => '16. Can I share my account with family members?',
                'answer' => 'Yes, depending on your subscription plan, you can share your account with family members. However, please note that simultaneous streaming may be limited based on your chosen plan.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:52:56',
                'updated_at' => '2024-09-28 06:52:56',
                'deleted_at' => NULL,
            ),
            16 =>
            array (
                'id' => 17,
                'question' => '17. How often is new content added to the platform?',
                'answer' => 'We regularly update our library with new content! You can expect new movies, TV shows, and episodes added every week, so there\'s always something fresh to watch.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:53:14',
                'updated_at' => '2024-09-28 06:53:14',
                'deleted_at' => NULL,
            ),
            17 =>
            array (
                'id' => 18,
                'question' => '18. Does Streamit Laravel offer subtitles or closed captions?',
                'answer' => 'Yes, many of our titles offer subtitles and closed captions in various languages. You can enable them through the video player settings while watching content.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:54:30',
                'updated_at' => '2024-09-28 06:54:30',
                'deleted_at' => NULL,
            ),
            18 =>
            array (
                'id' => 19,
                'question' => '19. What should I do if I encounter a streaming issue?',
                'answer' => 'If you experience buffering or streaming issues, first check your internet connection. If the problem persists, try clearing your cache or refreshing the page. If you continue to have issues, please contact our support team for assistance.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:54:44',
                'updated_at' => '2024-09-28 06:54:44',
                'deleted_at' => NULL,
            ),
            19 =>
            array (
                'id' => 20,
                'question' => '20. How do I use the parental controls on Streamit?',
                'answer' => 'To use parental controls on Streamit, navigate to your account settings. Here, you can set age restrictions for various content types and block specific shows or movies. Additionally, you can create custom profiles for family members with tailored controls. For added security, consider setting a PIN or password.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:58:39',
                'updated_at' => '2024-09-28 06:58:39',
                'deleted_at' => NULL,
            ),
            20 =>
            array (
                'id' => 21,
                'question' => '21. How do I enable subtitles or closed captions?',
                'answer' => 'To enable subtitles or closed captions while watching content on Streamit, look for the "Subtitles" or "CC" icon on the video player. Click on it, and you can choose your preferred language for subtitles. This feature enhances your viewing experience and accessibility.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:59:10',
                'updated_at' => '2024-09-28 06:59:10',
                'deleted_at' => NULL,
            ),
            21 =>
            array (
                'id' => 22,
                'question' => '22. How do I customize my Streamit homepage?',
                'answer' => 'To customize your Streamit homepage, log into your account and navigate to the "Settings" section. From there, you can personalize your homepage by selecting your favorite genres, organizing your watchlist, and adjusting display preferences to see content that interests you most.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 06:59:36',
                'updated_at' => '2024-09-28 06:59:36',
                'deleted_at' => NULL,
            ),
            22 =>
            array (
                'id' => 23,
                'question' => '23. How do I download videos for offline viewing?',
                'answer' => 'To download videos for offline viewing on Streamit, find the desired movie or show and look for the download icon. Click it, and the content will be saved to your device for offline access. Note that the ability to download may depend on your subscription plan.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 07:00:06',
                'updated_at' => '2024-09-28 07:00:06',
                'deleted_at' => NULL,
            ),
            23 =>
            array (
                'id' => 24,
                'question' => '24. Can I delete my account?',
                'answer' => 'Yes, you can delete your account at any time. To do this, log into your account, navigate to the "Account Settings" section, and select "Delete Account." Please note that this action is irreversible, and all your data will be permanently removed.',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 07:00:40',
                'updated_at' => '2024-09-28 07:00:40',
                'deleted_at' => NULL,
            ),
            24 =>
            array (
                'id' => 25,
                'question' => '25. How can I contact customer support?',
                'answer' => 'If you need assistance, you can reach our customer support team via email at hello@iqonic.design. We\'re here to help!',
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'deleted_by' => NULL,
                'created_at' => '2024-09-28 07:00:53',
                'updated_at' => '2024-09-28 07:02:01',
                'deleted_at' => NULL,
            ),
        ));


    }
}
