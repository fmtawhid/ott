<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        try {
            if (\Schema::hasTable('settings')) {
                $settings = DB::table('settings')->whereIn('type', ['mail_config', 'bussiness', 'misc'])->get();
                if (count($settings) > 0) { //checking if table is not empty
                    $app_name = $this->getSetting($settings, 'app_name');
                    $mail_driver = $this->getSetting($settings, 'mail_driver');
                    $mail_host = $this->getSetting($settings, 'mail_host');
                    $mail_port = $this->getSetting($settings, 'mail_port');
                    $mail_from = $this->getSetting($settings, 'mail_from');
                    $from_name = $this->getSetting($settings, 'from_name');
                    $mail_encryption = $this->getSetting($settings, 'mail_encryption');
                    $mail_username = $this->getSetting($settings, 'mail_username');
                    $mail_password = $this->getSetting($settings, 'mail_password');
                    $local = $this->getSetting($settings, 'default_language');
                    if (isset($app_name)) {
                        Config::set('app.name', $app_name);
                    }
                    if (isset($mail_driver)) {
                        Config::set('mail.driver', $mail_driver);
                    }
                    if (isset($mail_host)) {
                        Config::set('mail.host', $mail_host);
                    }
                    if (isset($mail_port)) {
                        Config::set('mail.port', $mail_port);
                    }
                    if (isset($mail_from)) {
                        Config::set('mail.from.address', $mail_from);
                    }
                    if (isset($from_name)) {
                        Config::set('mail.from.name', $from_name);
                    }
                    if (isset($mail_encryption)) {
                        Config::set('mail.encryption', $mail_encryption);
                    }
                    if (isset($mail_username)) {
                        Config::set('mail.username', $mail_username);
                    }
                    if (isset($mail_password)) {
                        Config::set('mail.password', $mail_password);
                    }
                    if (isset($local)) {
                        Config::set('app.locale', $local);
                    }
                }
            }
        } catch (\Exception $e) {
        }
    }

    public function getSetting($model, $name)
    {
        $query = $model->where('name', $name)->first();
        if (isset($query)) {
            return $query->val;
        }

        return null;
    }
}
