<?php

namespace App\Http\Middleware;

use App\Trait\Menu;

class GenerateMenus
{
    use Menu;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle()
    {
        return \Menu::make('menu', function ($menu) {
            if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin')) {
                $this->staticMenu($menu, ['title' =>  __('sidebar.main'), 'order' => 0]);
                $this->mainRoute($menu, [
                    'icon' => 'ph ph-squares-four',
                    'title' => __('sidebar.dashboard'),
                    'route' => 'backend.home',
                    'active' => ['app', 'app/dashboard'],
                    'order' => 0,
                ]);
            }


            $this->mainRoute($menu, [
                'icon' => 'ph ph-images-square',
                'route' => 'backend.media-library.index',
                'title' => __('sidebar.media'),
                'active' => ['app/media'],
                'permission' => ['view_media'],
                'order' => 0,
            ]);

            $permissionsToCheck = ['view_genres', 'view_movies', 'view_tvshow', 'view_seasons','view_episodes','view_videos','view_livetv',
            'view_tvcategory','view_tvchannel','view_castcrew','view_director','view_ads','view_vastads','view_customads'];

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => __('sidebar.media_management'), 'order' => 0]);
            }

            $this->mainRoute($menu, [
                'icon' => 'ph ph-mask-happy',
                'route' => 'backend.genres.index',
                'title' => __('sidebar.genres'),
                'active' => ['app/genres'],
                'permission' => ['view_genres'],
                'order' => 0,
            ]);

            if(isenablemodule('movie')==1){
            $this->mainRoute($menu, [
                'icon' => 'ph ph-film-strip',
                'route' => 'backend.movies.index',
                'title' => __('sidebar.movies'),
                'active' => ['app/movies'],
                'permission' => ['view_movies'],
                'order' => 0,
            ]);
          }

          if(isenablemodule('tvshow')==1){

            $tv_show = $this->parentMenu($menu, [
                'icon' => 'ph ph-television-simple',
                'title' => __('sidebar.tv_show'),
                'nickname' => 'tv_show',
                'permission' => ['view_tvshow'],
                'order' => 0,
            ]);

            $this->childMain($tv_show, [
                'title' => __('sidebar.tv_show'),
                'route' => 'backend.tvshows.index',
                'active' => ['app/tvshows'],
                'shortTitle' => 's',
                'order' => 0,
                'permission' => ['view_tvshows'],
                'icon' => 'ph ph-monitor-play',
            ]);

            $this->childMain($tv_show, [
                'title' => __('sidebar.seasons'),
                'route' => 'backend.seasons.index',
                'active' => ['app/seasons'],
                'shortTitle' => 's',
                'order' => 0,
                'permission' => ['view_seasons'],
                'icon' => 'ph ph-television',
            ]);

            $this->childMain($tv_show, [
                'title' => __('sidebar.episodes'),
                'route' => 'backend.episodes.index',
                'active' => ['app/episodes'],
                'shortTitle' => 's',
                'order' => 0,
                'permission' => ['view_episodes'],
                'icon' => 'ph ph-cards-three',
            ]);

        }


        if(isenablemodule('video')==1){

            $this->mainRoute($menu, [
                'icon' => 'ph ph-video-camera',
                'route' => 'backend.videos.index',
                'title' => __('sidebar.videos'),
                'active' => ['app/videos'],
                'permission' => ['view_videos'],
                'order' => 0,
            ]);
        }

        if(isenablemodule('livetv')==1){

            $live_tv = $this->parentMenu($menu, [
                'icon' => 'ph ph-screencast',
                'title' => __('sidebar.live_tv'),
                'nickname' => 'live_tv',
                'permission' => ['view_livetv'],
                'order' => 0,
            ]);

            $this->childMain($live_tv, [
                'title' => __('sidebar.tv_category'),
                'route' => 'backend.tv-category.index',
                'active' => ['app/tv-category'],
                'shortTitle' => 's',
                'order' => 0,
                'permission' => ['view_tvcategory'],
                'icon' => 'ph ph-circles-three-plus',
            ]);

            $this->childMain($live_tv, [
                'title' => __('sidebar.tv_channel'),
                'route' => 'backend.tv-channel.index',
                'active' => ['app/tv-channel'],
                'shortTitle' => 's',
                'order' => 0,
                'permission' => ['view_tvchannel'],
                'icon' => 'ph ph-polygon',
            ]);

        }

            $cast = $this->parentMenu($menu, [
                'icon' => 'ph ph-users',
                'title' => __('sidebar.cast'),
                'nickname' => 'cast',
                'permission' => ['view_castcrew'],
                'order' => 0,
            ]);

            $this->childMain($cast, [
                'title' => __('sidebar.actors'),
                'route' => ['backend.castcrew.index','type' => 'actor'],
                'active' => ['app/castcrew/actor'],
                'shortTitle' => 's',
                'order' => 0,
                'permission' => 'view_actor',
                'icon' => 'ph ph-user-focus',
            ]);

            $this->childMain($cast, [
                'title' => __('sidebar.directors'),
                'route' => ['backend.castcrew.index', 'type' => 'director'],
                'active' => ['app/castcrew/director'],
                'shortTitle' => 's',
                'order' => 0,
                'permission' => 'view_director',
                'icon' => 'ph ph-user-circle-gear',
            ]);

            // $adsManager = $this->parentMenu($menu, [
            //         'icon' => 'ph ph-megaphone',
            //         'title' => __('sidebar.ads_manager'),
            //         'nickname' => 'ads',
            //         'permission' => ['view_ads'],
            //         'order' => 0,
            // ]);
            // $this->childMain($adsManager, [
            //     'title' => __('sidebar.vast_ads_settings'),
            //     'route' => 'backend.vastads.index', 
            //     'active' => ['app/vastads'],
            //     'icon' => 'ph ph-gear', 
            //     'permission' => ['view_vastads'],
            //     'order' => 1,
            // ]);

            // $this->childMain($adsManager, [
            //     'title' => __('sidebar.custom_ads_settings'),
            //     'active' => ['app/customads'],
            //     'route' => 'backend.customads.index', 
            //     'icon' => 'ph ph-sliders', 
            //     'permission' => ['view_customads'],
            //     'order' => 2,
            // ]);
            

            $permissionsToCheck = ['view_subscription', 'view_plans', 'view_planlimitation'];

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => __('sidebar.subscription'), 'order' => 0]);
            }


            // $show = $this->parentMenu($menu, [
            //     'icon' =>  'ph ph-currency-circle-dollar',
            //     'title' => __('sidebar.subscription'),
            //     'nickname' => 'subscription',
            //     'permission' => 'view_subscription',
            //     'order' => 0,
            // ]);

            $this->mainRoute($menu, [
                'icon' => 'ph ph-hand',
                'title' => __('sidebar.subscriptions'),
                'route' => 'backend.subscriptions.index',
                'active' => ['app/subscriptions'],
                'nickname' => 'subscription',
                'shortTitle' => 's',
                'order' => 0,
                'permission' => ['view_subscriptions'],
            ]);


            $this->mainRoute($menu, [
                'icon' => 'ph ph-list-dashes',
                'title' => __('sidebar.plan'),
                'route' => 'backend.plans.index',
                'active' => ['app/plans'],
                'nickname' => 'plans',
                'shortTitle' => 'p',
                'permission' => ['view_plans'],
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => 'ph ph-warning-octagon',
                'title' => __('sidebar.plan_limits'),
                'route' => 'backend.planlimitation.index',
                'active' => ['app/planlimitation'],
                'nickname' => 'planlimitation',
                'shortTitle' => 's',
                'order' => 0,
                'permission' => ['view_planlimitation'],
            ]);

            $this->mainRoute($menu, [
                'icon' => 'ph ph-hand',
                'title' => __('sidebar.rent_history'),
                'route' => 'backend.pay-per-view-history',
                'active' => ['app/pay-per-view-history'],
                'nickname' => 'rent history',
                'shortTitle' => 'R',
                'order' => 0,
                'permission' => ['view_subscriptions'],
            ]);



            $this->mainRoute($menu, [
                'icon' => 'ph ph-ticket',
                'title' => __('sidebar.coupon'),
                'route' => 'backend.coupon.index',
                'active' => ['app/coupon'],
                'order' => 0,
            ]);

            $permissionsToCheck = ['view_subscriptions'];

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => __('sidebar.user'), 'order' => 0]);
            }

            $this->mainRoute($menu, [
                'icon' => 'ph ph-user',
                'title' => __('sidebar.user'),
                'route' => 'backend.users.index',
                'active' => ['app/users'],
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => 'ph ph-hourglass',
                'title' => __('sidebar.plan_expire'),
                'nickname' => 'soon-to-expire',
                'route' => ['backend.users.soon-to-exipre','type' => 'soon-to-expire'],
                'shortTitle' => 'se',
                'active' => ['app/app/users/soon-to-expire'],
                'permission' => ['view_subscriptions'],
                'order' => 0,
            ]);

           $this->mainRoute($menu, [
    'icon' => 'ph ph-star-half', 
    'title' => __('sidebar.review'),
    'route' => 'backend.reviews.index',
    'active' => ['app/reviews'],
    'order' => 0,
]);

            $permissionsToCheck = ['view_taxes','view_page','view_setting'];

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => __('sidebar.system_setting'), 'order' => 0]);
            }

            $this->mainRoute($menu, [
                'icon' => 'ph ph-layout',
                'title' => __('sidebar.app_banner'),
                'route' => 'backend.banners.index',
                'active' => ['app/banners'],
                'permission' =>['view_banners'],
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => 'fa-brands fa-intercom',
                'title' => __('sidebar.cont'),
                'route' => 'backend.constants.index',
                'active' => ['app/constants'],
                'permission' =>['view_constants'],
                'order' => 0,
            ]);

            $mobile_setting = $this->parentMenu($menu, [
                'icon' => 'ph ph-device-mobile',
                'route' => '',
                'title' => __('sidebar.mobile_setting'),
                'nickname' => 'mobile_setting',
                'order' => 0,
            ]);
            $this->childMain($mobile_setting, [
                'icon' => 'ph ph-gear',
                'title' => __('sidebar.dashboard_setting'),
                'route' => 'backend.mobile-setting.index',
                'active' => 'app/mobile-setting',
                'permission' => ['view_setting'],
                'order' => 0,
            ]);

            if(auth()->user()->hasRole('admin')){

            $this->childMain($mobile_setting, [
                'icon' => 'ph ph-gear-six',
                'title' => __('sidebar.App_configuration'),
                'route' => 'backend.AppConfig.index',
                'active' => 'app/appconfig',
                'order' => 0,
            ]);

        }


            // $system = $this->parentMenu($menu, [
            //     'icon' => 'ph ph-airplay',
            //     'route' => '',
            //     'title' => __('sidebar.system'),
            //     'nickname' => 'system',
            //     'order' => 0,
            // ]);
            $this->mainRoute($menu, [
                'icon' => 'ph ph-list-bullets',
                'route' => 'backend.settings.fcm.index',
                'title' => __('notification.title'),
                'active' => ['backend/settings/fcm'],
                'permission' => ['view_notification'],
                'order' => 0,
            ]);

            // $notification = $this->parentMenu($menu, [
            //     'icon' => 'ph ph-bell',
            //     'title' => __('notification.title'),
            //     'nickname' => 'notifications',
            //     'permission' => ['view_notification'],
            //     'order' => 0,
            // ]);

            // $this->childMain($notification, [
            //     'icon' => 'ph ph-list-bullets',
            //     'title' => __('sidebar.notification_list'),
            //     'route' => 'backend.notifications.index',
            //     'shortTitle' => 'Li',
            //     'active' => 'app/notifications',
            //     'permission' => ['view_notification'],
            //     'order' => 0,
            // ]);
            //       $this->childMain($notification, [
            //         'icon' => 'ph ph-layout',
            //         'title' => __('notification.template'),
            //         'route' => 'backend.notification-templates.index',
            //         'shortTitle' => 'TE',
            //         'active' => 'app/notification-templates',
            //         'permission' => ['view_notification_template'],
            //         'order' => 0,
            //     ]);



            $this->mainRoute($menu, [
                'icon' => 'ph ph-gear-six',
                'title' => __('sidebar.settings'),
                'route' => 'backend.settings.general',
                'active' => 'app/setting/general-setting',
                // 'permission' => ['view_setting'],
                'order' => 0,
            ]);

            if(auth()->user()->hasRole('admin')){

            $this->mainRoute($menu, [
                'icon' => 'ph ph-faders',
                'title' => __('sidebar.access_control'),
                'route' => 'backend.permission-role.list',
                'active' => ['app/permission-role'],
                'order' => 10,
            ]);
        }

            $this->mainRoute($menu, [
                'icon' => 'ph ph-file',
                'title' => __('sidebar.page'),
                'route' => 'backend.pages.index',
                'active' => ['app/pages'],
                'permission' =>['view_page'],
                'order' => 0,
            ]);


            $this->mainRoute($menu, [
                'icon' => 'ph ph-percent',
                'title' => __('sidebar.tax'),
                'route' => 'backend.taxes.index',
                'active' => ['app/taxes'],
                'permission' =>['view_taxes'],
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => 'ph ph-question',
                'title' => __('faq.title'),
                'route' => 'backend.faqs.index',
                'active' => ['app/faqs'],
                // 'permission' => ['view_faqs'],
                'order' => 0,
            ]);




            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (\Auth::getDefaultDriver() == 'admin') {
                            return true;
                        }
                        if (auth()->user()->hasAnyPermission($item->data('permission'), \Auth::getDefaultDriver())) {
                            return true;
                        }
                    }

                    return false;
                } else {
                    return true;
                }
            });
            // Set Active Menu
            $menu->filter(function ($item) {
                if ($item->activematches) {
                    $activematches = (is_string($item->activematches)) ? [$item->activematches] : $item->activematches;
                    foreach ($activematches as $pattern) {
                        if (request()->is($pattern)) {
                            $item->active();
                            $item->link->active();
                            if ($item->hasParent()) {
                                $item->parent()->active();
                            }
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');
    }
}
