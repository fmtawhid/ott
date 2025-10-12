<?php

namespace Modules\NotificationTemplate\Http\Middleware;

use App\Trait\HorizontalMenu;
use Closure;
use Illuminate\Http\Request;

class GenerateHorizontalMenus
{
    use HorizontalMenu;

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // \Menu::make('horizontal_menu', function ($menu) {

        //     // NOTIFICATION
        //     $notification = $this->parentMenu($menu, [
        //         'icon' => '<i class="nav-icon fas fa-bell"></i>',
        //         'title' => 'Notifications',
        //         'nickname' => 'notifications',
        //         'permission' => ['view_notificationtemplates'],
        //         'order' => 210,
        //     ]);
        //     $this->childMain($notification, [
        //         'icon' => '<i class="nav-icon fas fa-cogs"></i>',
        //         'title' => 'View All',
        //         'route' => 'backend.notifications.index',
        //         'active' => 'app/notifications',
        //     ]);
        //     $this->childMain($notification, [
        //         'icon' => '<i class="nav-icon fas fa-cogs"></i>',
        //         'title' => 'Templete',
        //         'route' => 'backend.notification-templates.index',
        //         'active' => 'app/notification-templates*',
        //     ]);
        //     $this->childMain($notification, [
        //         'icon' => '<i class="nav-icon fas fa-cogs"></i>',
        //         'title' => 'Settings',
        //         'route' => 'backend.notifications.index',
        //         'active' => 'admin',
        //     ]);

        // })->sortBy('order');

        // return $next($request);
    }
}
