<?php

namespace Modules\Subscriptions\Http\Middleware;

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

        //     $company = $this->createCompanyMenu($menu);

        //     // Service
        //     $Plan = $this->parentMenu($company, [
        //         'title' => 'Subscriptions',
        //         'nickname' => 'subscriptions',
        //         'order' => 240,
        //     ]);

        //     $this->childMain($Plan, [
        //         'title' => 'Subscription List',
        //         'route' => 'backend.subscriptions.index',
        //         'active' => 'app/subscriptions',

        //     ]);

        //     //  Sub- Service -Child

        //     $this->childMain($Plan, [
        //         'title' => 'Plan List',
        //         'route' => 'backend.subscription.plans.index',
        //         'active' => 'app/subscriptions/plans',
        //     ]);

        //     $this->childMain($Plan, [
        //         'title' => 'Plan Limitation',
        //         'route' => 'backend.subscription.planlimitation.index',
        //         'active' => 'app/subscriptions/planlimitation',
        //     ]);

        // });

        // return $next($request);
    }
}
