
<div class="sidebar-base pr-hide
            {{ getCustomizationSetting('sidebar_show') == 'sidebar-none' ? 'sidebar-none' : 'sidebar' }}
            {{ !empty(getCustomizationSetting('sidebar_menu_style')) ? getCustomizationSetting('sidebar_menu_style') : 'sidebar-default navs-pill-all' }}
            {{ getCustomizationSetting('sidebar_color') }}
            {{ !empty(getCustomizationSetting('sidebar_type')) ? implode(' ',getCustomizationSetting('sidebar_type')) : '' }}
            "
            data-toggle="main-sidebar" id="sidebar" data-sidebar="responsive">
    <div class="d-flex align-items-center justify-content-start">
        <div class="logo-main">
            <a href="{{route('backend.home')}}" class="navbar-brand">
                @php
                   $dark_logo=GetSettingValue('dark_logo') ??  asset(setting('dark_logo')); 
                   $logo=GetSettingValue('logo') ??  asset(setting('logo')); 
                   $mini_logo=GetSettingValue('mini_logo') ??  asset(setting('mini_logo'));
                    $dark_mini_logo=GetSettingValue('dark_mini_logo') ??  asset(setting('dark_mini_logo'));
              

                @endphp
                <img class="logo-normal img-fluid" src="{{ $logo }}" height="30" alt="{{ app_name() }}">
               <img class="logo-normal dark-normal img-fluid" src="{{ $dark_logo}}" height="30" alt="{{ app_name() }}">
               <img class="logo-mini img-fluid" src="{{$mini_logo}}" height="30" alt="{{ app_name() }}">
               <img class="logo-mini dark-mini img-fluid" src="{{$mini_logo}}" height="30" alt="{{ app_name() }}">
           </a>
        </div>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list" id="sidebar">
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
              @php
                  $menu = new \App\Http\Middleware\GenerateMenus();
                  $menu = $menu->handle('menu', 'vertical', 'ARRAY_MENU');
              @endphp
                @include(config('laravel-menu.views.bootstrap-items'), ['items' => $menu->roots()])
            </ul>
        </div>
    </div>
    <div class="sidebar-footer"></div>
</div>

