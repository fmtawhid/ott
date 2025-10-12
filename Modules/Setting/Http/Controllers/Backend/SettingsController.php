<?php

namespace Modules\Setting\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Modules\Setting\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Setting\Http\Requests\SettingRequest;
use App\Trait\ModuleTrait;
use Illuminate\Support\Facades\Config;
use Modules\NotificationTemplate\Models\NotificationTemplate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Modules\Currency\Models\Currency;
use Modules\World\Models\Country;
use Modules\User\Http\Requests\PasswordRequest;

class SettingsController extends Controller
{
    protected string $exportClass = '\App\Exports\SettingExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'settings.title', // module title
            'settings', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];

        $module_action = 'List';

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => ' Name',
            ]
        ];
        $export_url = route('backend.settings.export');

        return view('setting::backend.setting.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url'));
    }


    public function generalSetting()
    {
        $fields = ['app_name', 'user_app_name', 'helpline_number', 'inquriy_email', 'short_description', 'logo', 'mini_logo', 'dark_logo', 'dark_mini_logo','light_logo', 'favicon'];
        $data = $this->fieldsData($fields);

        // dd($data);

        return view('setting::backend.setting.section-pages.general', compact('data'));
    }
    public function moduleSetting()
    {
        $fields = ['movie', 'tvshow', 'livetv', 'video', 'enable_tmdb_api', 'tmdb_api_key'];
        $settings = $this->fieldsData($fields);

        return view('setting::backend.setting.section-pages.module-setting', compact('settings'));
    }

    public function customCode()
    {
        $fields = ['custom_css_block', 'custom_js_block'];
        $data = $this->fieldsData($fields);
        return view('setting::backend.setting.section-pages.custom-code', compact('data'));
    }

    public function invoiceSetting()
    {
        $fields = ['inv_prefix', 'order_code_start', 'spacial_note'];
        $data = $this->fieldsData($fields);

        return view('setting::backend.setting.section-pages.invoice-setting', compact('data'));
    }

    public function customization()
    {
        $fields = ['customization_setting_1', 'customization_setting_2'];

        $data = $this->fieldsData($fields);
        return view('setting::backend.setting.section-pages.customization', compact('data'));
    }

    public function mail()
    {
        $fields = ['email', 'mail_driver', 'mail_host', 'mail_port', 'mail_encryption', 'mail_username', 'mail_from', 'from_name', 'mail_password'];
        $data = $this->fieldsData($fields);

        return view('setting::backend.setting.section-pages.mail-setting', compact('data'));
    }

    public function notificationSetting()
    {

        $query_data = NotificationTemplate::with('defaultNotificationTemplateMap', 'constant')->get();
        $notificationTemplates = [];
        $notificationKeyChannels = array_keys(config('notificationtemplate.channels'));
        $arr = [];
        // For Channel Map Or Update Channel Value
        foreach ($notificationKeyChannels as $key => $value) {
            $arr[$value] = 0;
        }
        foreach ($query_data as $key => $value) {
            $notificationTemplates[$key] = [
                'id' => $value->id,
                'type' => $value->type,
                'template' => $value->defaultNotificationTemplateMap->subject,
                'is_default' => false,
            ];
            if (isset($value->channels)) {
                $notificationTemplates[$key]['channels'] = $value->channels;
            } else {
                $notificationTemplates[$key]['channels'] = $arr;
            }
        }

        $channels = config('notificationtemplate.channels');

        return view('setting::backend.setting.section-pages.notification-setting', compact('channels', 'notificationTemplates'));
    }

    public function integration()
    {
        $fields = [
            'is_google_login',
            'is_one_signal_notification',
            'is_mobile_notification',
            'is_map_key',
            'isForceUpdate',
            'is_application_link',
            'is_custom_webhook_notification',
            'onesignal_app_id',
            'onesignal_rest_api_key',
            'onesignal_channel_id',
            'custom_webhook_content_key',
            'custom_webhook_url',
            'customer_app_play_store',
            'customer_app_app_store',
            'google_maps_key',
            'version_code',
            'google_secretkey',
            'google_publickey',
        ];
        $data = $this->fieldsData($fields);
        return view('setting::backend.setting.section-pages.integration', compact('data'));
    }

    public function otherSettings()
    {
        $fields = ['is_event', 'is_blog', 'is_user_push_notification', 'is_provider_push_notification', 'enable_chat_gpt', 'test_without_key', 'chatgpt_key', 'firebase_notification', 'firebase_key',];
        $settings = $this->fieldsData($fields);

        return view('setting::backend.setting.section-pages.other-settings', compact('settings'));
    }

    public function paymentMethod()
    {
        $fields = ['razor_payment_method', 'razorpay_secretkey', 'razorpay_publickey', 'str_payment_method', 'stripe_secretkey', 'stripe_publickey', 'paystack_payment_method', 'paystack_secretkey', 'paystack_publickey', 'paypal_payment_method', 'paypal_secretkey', 'paypal_clientid', 'flutterwave_payment_method', 'flutterwave_secretkey', 'flutterwave_publickey', 'cash_payment_method', 'cash_secretkey', 'cash_publickey', 'cinet_payment_method', 'cinet_siteid', 'cinet_api_key', 'cinet_Secret_key', 'sadad_payment_method', 'sadad_Sadadkey', 'sadad_id_key', 'sadad_Domain', 'airtel_payment_method', 'airtel_money_secretkey', 'airtel_money_client_id', 'phonepe_payment_method', 'phonepe_App_id', 'phonepe_Merchant_id', 'phonepe_salt_key', 'phonepe_salt_index', 'midtrans_payment_method', 'midtrans_client_id','iap_payment_method','entertainment_id','apple_api_key','google_api_key'];
        $settings = $this->fieldsData($fields);
        return view('setting::backend.setting.section-pages.payment-method', compact('settings'));
    }

    public function languageSettings()
    {
        $query_data = Config::get('app.available_locales');
        $languages = [];
        foreach ($query_data as $key => $value) {
            $languages[] = [
                'id' => $key,
                'name' => $value,
            ];
        }
        $fields = ['language_setting_1', 'language_setting_2'];
        $data = $this->fieldsData($fields);
        return view('setting::backend.setting.section-pages.language-settings', compact('data', 'languages'));
    }

    public function notificationConfiguration()
    {
        $fields = ['expiry_plan', 'upcoming', 'continue_watch'];
        $settings = $this->fieldsData($fields);
        return view('setting::backend.setting.section-pages.notification-configuration', compact('settings'));
    }

    public function ResetDatabase(){


        \Artisan::call('migrate:fresh --seed');

        $message = __('messages.data_reset');

        return response()->json(['message' => $message, 'status' => true], 200);


    }


    public function storageSettings()
    {

        $fields = [
            'local',
            's3',
            'aws_access_key',
            'aws_secret_key',
            'aws_region',
            'aws_bucket',
            'aws_path_style'
        ];

        $settings = $this->fieldsData($fields);
        return view('setting::backend.setting.section-pages.storage-setting', compact('settings'));
    }

    public function databaseReset()
    {
        return view('setting::backend.setting.section-pages.database_reset');
    }


    public function dataload(){

        $this->setEnvValue('IS_DUMMY_DATA', 'true');

        $artisanPath = base_path('artisan');

        $output = [];
        $resultCode = 0;
        exec("php {$artisanPath} migrate:fresh --seed --force 2>&1", $output, $resultCode);

        // Log the full output of the command
        \Log::info('Migration Output: ' . implode("\n", $output));
        \Log::info('Migration Result Code: ' . $resultCode);

        if ($resultCode !== 0) {
            \Log::error('Migration failed with result code: ' . $resultCode);
            \Log::error('Migration error output: ' . implode("\n", $output));
            return redirect()->back()->with('error', __('settings.data_reset_failed'));
        }

        // Log the value of IS_DUMMY_DATA
        \Log::info('IS_DUMMY_DATA value: ' . env('IS_DUMMY_DATA'));

        \Log::info('Database reset completed.');

        $message = __('settings.data_reset');

        // Redirect back with success message
        return response()->json(['message' => $message, 'status' => true], 200);

    }

    public function datareset()
    {
        \Artisan::call('config:clear');

        $this->setEnvValue('IS_DUMMY_DATA', 'false');

        $artisanPath = base_path('artisan');

        $output = [];
        $resultCode = 0;
        exec("php {$artisanPath} migrate:fresh --seed --force 2>&1", $output, $resultCode);

        // Log the full output of the command
        \Log::info('Migration Output: ' . implode("\n", $output));
        \Log::info('Migration Result Code: ' . $resultCode);

        if ($resultCode !== 0) {
            \Log::error('Migration failed with result code: ' . $resultCode);
            \Log::error('Migration error output: ' . implode("\n", $output));
            return redirect()->back()->with('error', __('settings.data_reset_failed'));
        }

        // Log the value of IS_DUMMY_DATA
        \Log::info('IS_DUMMY_DATA value: ' . env('IS_DUMMY_DATA'));

        \Log::info('Database reset completed.');

        $message = __('settings.data_reset');

        return redirect()->back()->with('success', $message);
    }
    /**
     * Update a specific value in the .env file
     */
    private function setEnvValue($key, $value)
    {
        $envPath = base_path('.env');

        if (file_exists($envPath)) {
            // Read .env file
            $envContent = file_get_contents($envPath);

            // Update or add the key
            $pattern = "/^{$key}=.*/m";
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "{$key}={$value}", $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }

            // Save changes
            file_put_contents($envPath, $envContent);

            // Clear cache to apply changes
            \Artisan::call('config:clear');
            \Artisan::call('cache:clear');
        }

        return;
    }


    // public function datareset(){

    //     putenv('IS_DUMMY_DATA=false');

    //     \Artisan::call('migrate:fresh --seed');

    //     $message = __('settings.save_setting');

    //    return redirect()->back()->with('success', $message);

    // }

    // public function datareset(Request $request)
    // {

    //     EnvHelper::setEnvValue('IS_DUMMY_DATA', 'false');
    //      config(['app.is_dummy_data' => false]);

    //     // Clear the cache to make sure changes are reflected
    //     \Artisan::call('config:clear');
    //     \Artisan::call('config:cache');
    //     \Artisan::call('cache:clear');

    //     // List of tables that should not be cleared
    //     $protectedTables = [
    //         'users',
    //         'roles',
    //         'permissions',
    //         'model_has_roles',
    //         'role_has_permissions',
    //         'permission_role',
    //         'frontend_settings',
    //         'settings', // Add any additional tables related to Spatie here
    //     ];

    //     // Disable foreign key checks
    //     DB::statement('SET FOREIGN_KEY_CHECKS = 0');

    //     // Get all table names
    //     $tables = DB::select('SHOW TABLES');

    //     foreach ($tables as $table) {
    //         $tableName = (array)$table;
    //         $tableName = reset($tableName); // Extract table name from object

    //         // Skip protected tables
    //         if (in_array($tableName, $protectedTables)) {
    //             continue;
    //         }

    //         // Drop foreign key constraints for the current table (if any)
    //         $this->dropForeignKeys($tableName);

    //         // Truncate table if it's not protected
    //         DB::table($tableName)->truncate();
    //     }

    //     // Delete users where user_type is not 'admin' or 'demo admin'
    //     dB::table('users')
    //         ->whereIn('user_type', ['user', 'provider', 'handyman'])
    //         ->delete();

    //     // Re-enable foreign key checks
    //     DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    //     return redirect()->route('setting.index')->with('success', 'Database has been reset successfully.');
    // }







    public function currencySettings()
    {
        $currencies = Currency::all(); // Fetch all currencies, adjust query as needed

        $query_data = Country::get();

        $curr_names = [];
        foreach ($query_data as $row) {
            $curr_names[] = [
                'id' => $row->id,
                'name' => $row->name,
                'currency_name' => $row->currency_name,
                'symbol' => $row->symbol,
                'currency_code' => $row->currency_code,
            ];
        }


        return view('setting::backend.setting.section-pages.currency-setting', compact('currencies', 'curr_names'));
    }

    public function miscSetting()
    {
        $query_data = Config::get('app.available_locales');
        $languages = [];

        foreach ($query_data as $key => $value) {
            $languages[] = [
                'id' => $key,
                'name' => $value,
            ];
        }
        $timezones = timeZoneList();
        $data = [];
        $i = 0;
        foreach ($timezones as $key => $row) {
            $data[$i] = [
                'id' => $key,
                'text' => $row,
            ];
            $i++;
        }
        $timezones = $data;

        $fields = ['google_analytics', 'default_language', 'default_time_zone', 'data_table_limit', 'default_currency'];
        $settings = $this->fieldsData($fields);

        return view('setting::backend.setting.section-pages.misc-settings', compact('settings', 'languages', 'timezones'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */


    public function store(Request $request)
    {
        //dd($request->all());



        $rules = Setting::getSelectedValidationRules(array_keys($request->all()));
        // dd($request->all());
        // dd($request, $rules);

        $data = $this->validate($request, $rules);

        $validSettings = array_keys($rules);

        if ($request->has('firebase_json_file')) {

            $file = $request->file('firebase_json_file');

            $fileName = $file->getClientOriginalName();
            $directoryPath = storage_path('app/data');

            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }
            $files = File::files($directoryPath);

            foreach ($files as $existingFile) {
                $filePath = $existingFile->getPathname();

                if (strtolower($existingFile->getExtension()) === 'json') {
                    File::delete($filePath);
                }
            }
            $file->move($directoryPath, $fileName);
        }

        foreach ($data as $key => $val) {
            if (in_array($key, $validSettings)) {
                $mimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/vnd.microsoft.icon'];
                if (gettype($val) == 'object') {
                    if ($val->getType() == 'file' && in_array($val->getmimeType(), $mimeTypes)) {
                        $setting = Setting::add($key, '', Setting::getDataType($key), Setting::getType($key));
                        $mediaItems = $setting->addMedia($val)->toMediaCollection($key);
                        $setting->update(['val' => $mediaItems->getUrl()]);
                    }
                } else {
                    $setting = Setting::add($key, $val, Setting::getDataType($key), Setting::getType($key));
                }
            }
        }
        $message = __('settings.save_setting');
        if ($request->wantsJson()) {

            return response()->json(['message' => $message, 'status' => true], 200);
        } else {
            return redirect()->back()->with('success', $message);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = Setting::findOrFail($id);
        return view('setting::backend.setting.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(SettingRequest $request, Setting $setting)
    {
        $requestData = $request->all();
        $setting->update($requestData);

        return redirect()->route('backend.settings.index', $setting->id)->with('success', 'Setting updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {
        $data = Setting::findOrFail($id);
        $data->delete();
        $message = __('Taxes Deleted Successfully');
        return response()->json(['message' => $message, 'type' => 'DELETE_FORM']);
    }

    public function restore($id)
    {
        $data = Setting::withTrashed()->findOrFail($id);
        $data->restore();
        return response()->json(['message' => 'Tax entry restored successfully']);
    }

    public function forceDelete($id)
    {
        $data = Setting::withTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json(['message' => 'Tax entry permanently deleted']);
    }

    public function clear_cache()
    {
        Setting::flushCache();

        $message = __('messages.cache_cleard');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function fieldsData($fields)
    {

        $responseData = Setting::whereIn('name', $fields)->get();
        $data = [];

        foreach ($responseData as $setting) {
            $field = $setting->name;
            $value = $setting->val;

            if (in_array($field, ['logo', 'mini_logo', 'dark_logo', 'dark_mini_logo', 'favicon'])) {
                $value = asset($value);
            }

            $data[$field] = $value;
        }

        return $data;
    }

    public function change_password()
    {

        return view('setting::backend.profile.section-pages.change-password');
    }

    public function information()
    {
        $user = Auth::user();

        return view('setting::backend.profile.section-pages.information-page', compact('user'));
    }

    public function userProfileUpdate(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $data = User::findOrFail($user->id);
        $request_data = $request->except('profile_image');
        $data->update($request_data);

        if ($request->custom_fields_data) {
            $data->updateCustomFieldData(json_decode($request->custom_fields_data));
        }

        if ($request->file('profile_image')) {
            storeMediaFile($data, $request->file('profile_image'), 'profile_image');
        }

        $message = __('messages.profile_update');

        return redirect()->back()->with('success', $message);
    }

    public function changePassword(Request $request)
    {
        if (env('IS_DEMO')) {
            return redirect()->back()->with('error', __('messages.permission_denied'));
        }

        $user = Auth::user(); // Get the currently authenticated user
        $user_id = $user->id; // Retrieve the user's ID
        $data = User::findOrFail($user_id);

        if ($data == "") {
            $message = __('messages.user_not_found');
            return redirect()->back()->with('error', $message);
        }

        $hashedPassword = $data->password;

        $match = Hash::check($request->old_password, $hashedPassword);

        $same_exits = Hash::check($request->new_password, $hashedPassword);

        if ($match) {
            if ($same_exits) {
                $message = __('messages.same_pass');
                return redirect()->back()->with('error', $message);
            }

            $data->fill([
                'password' => Hash::make($request->new_password)
            ])->save();
            $message = __('messages.pass_successfull');
            return redirect()->back()->with('success', $message);
        } else {
            $message = __('messages.check_old_password');
            return redirect()->back()->with('error', $message);
        }
    }



    // App config
    public function appConfig(Request $request)
    {
        $module_title = __('settings.add_title');
        $module_action = 'List';
        $fields = ['is_social_login', 'is_google_login','google_client_id','google_client_secret','google_redirect_uri', 'is_otp_login', 'apiKey', 'authDomain', 'databaseURL', 'projectId', 'storageBucket', 'messagingSenderId', 'appId', 'measurementId', 'is_apple_login', 'is_firebase_notification','firebase_key', 'is_user_push_notification', 'is_application_link', 'ios_url', 'android_url', 'force_update', 'enter_app_version', 'app_version', 'message_text', 'is_ChatGPT_integration', 'ChatGPT_key'];
        $data = $this->fieldsData($fields);
        return view('setting::backend.appconfig.index', compact('module_action', 'data', 'module_title'));
    }

    public function getCurrencyData(Request $request)
    {
        $currencyName = $request->input('currency_name');

        $currency = Country::where('currency_name', $currencyName)->first();

        if ($currency) {
            return response()->json([

                'currency_symbol' => $currency->symbol,
                'currency_code' => $currency->currency_code,
            ]);
        } else {
            return response()->json(['error' => 'Currency not found'], 404);
        }
    }
}
