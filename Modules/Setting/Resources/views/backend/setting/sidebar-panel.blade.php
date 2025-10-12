
<div class="col-md-4 col-lg-3">
    <div id="setting-sidebar" class="setting-sidebar-inner">
        <div class="card">
            <div class="card-body">
                <div class="list-group list-group-flush" id="setting-list">
                    @hasPermission('setting_bussiness')
                        <div class="mb-3 active-menu">
                            <a id="link-general" href="{{ route('backend.settings.general') }}" class="btn btn-border {{ request()->routeIs('backend.settings.general') ? 'active' : '' }}">
                                <i class="fas fa-cube"></i>{{ __('setting_sidebar.lbl_General') }}
                            </a>
                        </div>
                    @endhasPermission
                    <!-- @hasPermission('setting_custom_code')
                        <div class="mb-3 active-menu">
                            <a id="link-custom-code" href="{{ route('backend.settings.custom-code') }}" class="btn btn-border {{ request()->routeIs('backend.settings.custom-code') ? 'active' : '' }}">
                                <i class="fas fa-cube"></i>{{ __('setting_sidebar.lbl_custom_code') }}
                            </a>
                        </div> -->
                    @endhasPermission
                    @hasPermission('setting_module')
                    <div class="mb-3 active-menu">
                        <a id="link-module-setting" href="{{ route('backend.settings.module') }}" class="btn btn-border {{ request()->routeIs('backend.settings.module') ? 'active' : '' }}">
                            <i class="icon ph ph-list-dashes"></i>{{ __('setting_sidebar.lbl_module-setting') }}
                        </a>
                    </div>
                    @endhasPermission
                    @hasPermission('setting_misc')
                        <div class="mb-3 active-menu">
                            <a id="link-misc" href="{{ route('backend.settings.misc') }}" class="btn btn-border {{ request()->routeIs('backend.settings.misc') ? 'active' : '' }}">
                                <i class="fa-solid fa-screwdriver-wrench"></i>{{ __('setting_sidebar.lbl_misc_setting') }}
                            </a>
                        </div>
                    @endhasPermission
                    <!-- @hasPermission('setting_invoice')
                        <div class="mb-3 active-menu">
                            <a id="link-invoice-setting" href="{{ route('backend.settings.invoice-setting') }}" class="btn btn-border {{ request()->routeIs('backend.settings.invoice-setting') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-invoice" aria-hidden="true"></i>{{ __('setting_sidebar.lbl_inv_setting') }}
                            </a>
                        </div>
                    @endhasPermission  -->
                    <!-- @hasPermission('setting_customization')
                        <div class="mb-3 active-menu">
                            <a id="link-customization" href="{{ route('backend.settings.customization') }}" class="btn btn-border {{ request()->routeIs('backend.settings.customization') ? 'active' : '' }}">
                                <i class="fa-solid fa-swatchbook"></i>{{ __('setting_sidebar.lbl_customization') }}
                            </a>
                        </div>
                    @endhasPermission -->
                    @hasPermission('setting_mail')
                        <div class="mb-3 active-menu">
                            <a id="link-mail" href="{{ route('backend.settings.mail') }}" class="btn btn-border {{ request()->routeIs('backend.settings.mail') ? 'active' : '' }}">
                                <i class="fas fa-envelope"></i>{{ __('setting_sidebar.lbl_mail') }}
                            </a>
                        </div>
                    @endhasPermission
                    <!--@hasPermission('setting_notification')-->
                    <!--    <div class="mb-3 active-menu">-->
                    <!--        <a id="link-notification" href="{{ route('backend.settings.notificationsetting') }}" class="btn btn-border {{ request()->routeIs('backend.settings.notificationsetting') ? 'active' : '' }}">-->
                    <!--            <i class="fa-solid fa-bullhorn"></i>{{ __('setting_sidebar.lbl_notification') }}-->
                    <!--        </a>-->
                    <!--    </div>-->
                    <!--@endhasPermission-->
                    <!-- <div class="mb-3 active-menu">
                        <a id="link-payment-method" href="{{ route('backend.settings.payment-method') }}" class="btn btn-border {{ request()->routeIs('backend.settings.payment-method') ? 'active' : '' }}">
                            <i class="fa-solid fa-coins"></i>{{ __('setting_sidebar.lbl_payment') }}
                        </a>
                    </div> -->
                    @hasPermission('setting_language')
                        <div class="mb-3 active-menu">
                            <a id="link-language-settings" href="{{ route('backend.settings.language-settings') }}" class="btn btn-border {{ request()->routeIs('backend.settings.language-settings') ? 'active' : '' }}">
                                <i class="fa fa-language" aria-hidden="true"></i>{{ __('setting_sidebar.lbl_language') }}
                            </a>
                        </div>
                    @endhasPermission
                    <div class="mb-3 active-menu">
                        <a id="link-notification-configuration" href="{{ route('backend.settings.notification-configuration') }}" class="btn btn-border {{ request()->routeIs('backend.settings.notification-configuration') ? 'active' : '' }}">
                            <i class="fa-solid fa-bell"></i>{{ __('setting_sidebar.lbl_notification_configuration') }}
                        </a>
                    </div>
                    @hasPermission('view_currency')
                    <div class="mb-3 active-menu">
                        <a id="link-currency-settings" href="{{ route('backend.settings.currency-settings') }}" class="btn btn-border {{ request()->routeIs('backend.settings.currency-settings') ? 'active' : '' }}">
                            <i class="fa fa-dollar fa-lg mr-2"></i>{{ __('setting_sidebar.lbl_currency_setting') }}
                        </a>
                    </div>
                    @endhasPermission
                    <div class="mb-3 active-menu">
                        <a id="link-storage-settings" href="{{ route('backend.settings.storage-settings') }}" class="btn btn-border {{ request()->routeIs('backend.settings.storage-settings') ? 'active' : '' }}">
                            <i class="fa-solid fa-database"></i>{{ __('setting_sidebar.lbl_storage') }}
                        </a>
                    </div>

                    {{-- <div class="mb-3 active-menu">
                        <a id="link-storage-settings" href="{{ route('backend.settings.database-reset') }}" class="btn btn-border {{ request()->routeIs('backend.settings.database-reset') ? 'active' : '' }}">
                            <i class="fa-solid fa-database"></i>{{ __('setting_sidebar.lbl_database_reset') }}
                        </a>
                    </div> --}}

                    <div class="mb-3 active-menu">
                        <a id="link-seo-settings" href="{{ route('Seo.seo-settings') }}" class="btn btn-border {{ request()->routeIs('Seo.seo-settings') ? 'active' : '' }}">
                            <i class="fa-solid fa-search"></i>{{ __('setting_sidebar.lbl_seo') }}
                        </a>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function toggle() {
            const formOffcanvas = document.getElementById('offcanvas');
            formOffcanvas.classList.add('show');
        }

        function hasPermission(permission) {
            return window.auth_permissions.includes(permission);
        }
    </script>
@endpush

<style scoped>
    .btn-border {
        text-align: left;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
</style>
