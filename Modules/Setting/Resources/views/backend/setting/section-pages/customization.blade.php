@extends('setting::backend.setting.index')

@section('settings-content')
<form method="POST" action="{{ route('backend.setting.store') }}" id="settings-form-data"  enctype="multipart/form-data">
    @csrf
    <div>
        <div class="d-flex justify-content-between align-items-center card-title">
            <h3 class="mb-3"><i class="fa-solid fa-file-code"></i> {{ __('setting_sidebar.lbl_customization') }}</h3>
        </div>
    </div>

    <!-- Color customizer start here -->
    <div>
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="mt-4 mb-3">{{__('customization.color_customizer')}}</h6>
            <div class="d-flex align-items-center">
                <a href="#custom-color" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="custom-color">{{__('customization.custom')}}</a>
                <div data-setting="radio">
                    <input type="radio" value="default" class="btn-check"
                        name="theme_color" id="theme-color-default"
                        data-colors='{"primary": "#7093e5", "secondary": "#f68685"}'>
                    <label class="btn bg-transparent px-2 border-0" for="theme-color-default"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Color"
                        data-bs-original-title="Reset color">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21.4799 12.2424C21.7557 12.2326 21.9886 12.4482 21.9852 12.7241C21.9595 14.8075 21.2975 16.8392 20.0799 18.5506C18.7652 20.3986 16.8748 21.7718 14.6964 22.4612C12.518 23.1505 10.1711 23.1183 8.01299 22.3694C5.85488 21.6205 4.00382 20.196 2.74167 18.3126C1.47952 16.4293 0.875433 14.1905 1.02139 11.937C1.16734 9.68346 2.05534 7.53876 3.55018 5.82945C5.04501 4.12014 7.06478 2.93987 9.30193 2.46835C11.5391 1.99683 13.8711 2.2599 15.9428 3.2175L16.7558 1.91838C16.9822 1.55679 17.5282 1.62643 17.6565 2.03324L18.8635 5.85986C18.945 6.11851 18.8055 6.39505 18.549 6.48314L14.6564 7.82007C14.2314 7.96603 13.8445 7.52091 14.0483 7.12042L14.6828 5.87345C13.1977 5.18699 11.526 4.9984 9.92231 5.33642C8.31859 5.67443 6.8707 6.52052 5.79911 7.74586C4.72753 8.97119 4.09095 10.5086 3.98633 12.1241C3.8817 13.7395 4.31474 15.3445 5.21953 16.6945C6.12431 18.0446 7.45126 19.0658 8.99832 19.6027C10.5454 20.1395 12.2278 20.1626 13.7894 19.6684C15.351 19.1743 16.7062 18.1899 17.6486 16.8652C18.4937 15.6773 18.9654 14.2742 19.0113 12.8307C19.0201 12.5545 19.2341 12.3223 19.5103 12.3125L21.4799 12.2424Z"
                                fill="#31BAF1" />
                            <path
                                d="M20.0941 18.5594C21.3117 16.848 21.9736 14.8163 21.9993 12.7329C22.0027 12.4569 21.7699 12.2413 21.4941 12.2512L19.5244 12.3213C19.2482 12.3311 19.0342 12.5633 19.0254 12.8395C18.9796 14.283 18.5078 15.6861 17.6628 16.8739C16.7203 18.1986 15.3651 19.183 13.8035 19.6772C12.2419 20.1714 10.5595 20.1483 9.01246 19.6114C7.4654 19.0746 6.13845 18.0534 5.23367 16.7033C4.66562 15.8557 4.28352 14.9076 4.10367 13.9196C4.00935 18.0934 6.49194 21.37 10.008 22.6416C10.697 22.8908 11.4336 22.9852 12.1652 22.9465C13.075 22.8983 13.8508 22.742 14.7105 22.4699C16.8889 21.7805 18.7794 20.4073 20.0941 18.5594Z"
                                fill="#0169CA" />
                        </svg>
                    </label>
                </div>
            </div>
        </div>
        <div class="collapse" id="custom-color">
            <div class="form-group d-flex justify-content-between align-items-center">
                <label class="" for="custom-primary-color">{{__('customization.primary')}}</label>
                <input class="" name="theme_color" data-extra="primary" type="color"
                    id="custom-primary-color" value="#3a57e8" data-setting="color">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center">
                <label class="" for="custom-secondary-color">{{__('customization.secondary')}}</label>
                <input class="" name="theme_color" data-extra="secondary" type="color"
                    id="custom-secondary-color" value="#8a92a6" data-setting="color">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center">
                <label class="" for="custom-success-color">{{__('customization.success')}}</label>
                <input class="" name="theme_color" data-extra="success" type="color"
                    id="custom-success-color" value="#1aa053" data-setting="color">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center">
                <label class="" for="custom-danger-color">{{__('customization.danger')}}</label>
                <input class="" name="theme_color" data-extra="danger" type="color"
                    id="custom-danger-color" value="#c03221" data-setting="color">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center">
                <label class="" for="custom-warning-color">{{__('customization.warning')}}</label>
                <input class="" name="theme_color" data-extra="warning" type="color"
                    id="custom-warning-color" value="#f16a1b" data-setting="color">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center">
                <label class="" for="custom-info-color">{{__('customization.info')}}</label>
                <input class="" name="theme_color" data-extra="info" type="color"
                    id="custom-info-color" value="#08B1BA" data-setting="color">
            </div>
        </div>
        <div class="grid-cols-5 mb-4 d-grid gap-3">
            <div data-setting="radio">
                <input type="radio" value="color-1" class="btn-check" name="theme_color"
                    id="theme-color-1">
                <label class="btn btn-border d-block bg-transparent text-center" for="theme-color-1"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Theme-1"
                    data-bs-original-title="Theme-1">
                    <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" width="26" height="26">
                        <circle cx="12" cy="12" r="10" fill="#00C3F9" />
                        <path d="M2,12 a1,1 1 1,0 20,0" fill="#573BFF" />
                    </svg>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="color-2" class="btn-check" name="theme_color"
                    id="theme-color-2">
                <label class="btn btn-border d-block bg-transparent text-center" for="theme-color-2"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Theme-2"
                    data-bs-original-title="Theme-2">
                    <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" width="26" height="26">
                        <circle cx="12" cy="12" r="10" fill="#91969E" />
                        <path d="M2,12 a1,1 1 1,0 20,0" fill="#FD8D00" />
                    </svg>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="color-3" class="btn-check" name="theme_color"
                    id="theme-color-3">
                <label class="btn btn-border d-block bg-transparent text-center" for="theme-color-3"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Theme-3"
                    data-bs-original-title="Theme-3">
                    <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" width="26" height="26">
                        <circle cx="12" cy="12" r="10" fill="#DB5363" />
                        <path d="M2,12 a1,1 1 1,0 20,0" fill="#366AF0" />
                    </svg>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="color-4" class="btn-check" name="theme_color"
                    id="theme-color-4">
                <label class="btn btn-border d-block bg-transparent text-center" for="theme-color-4"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Theme-4"
                    data-bs-original-title="Theme-4">
                    <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" width="26" height="26">
                        <circle cx="12" cy="12" r="10" fill="#EA6A12" />
                        <path d="M2,12 a1,1 1 1,0 20,0" fill="#6410F1" />
                    </svg>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="color-5" class="btn-check" name="theme_color"
                    id="theme-color-5">
                <label class="btn btn-border d-block bg-transparent text-center" for="theme-color-5"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Theme-5"
                    data-bs-original-title="Theme-5">
                    <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" width="26" height="26">
                        <circle cx="12" cy="12" r="10" fill="#E586B3" />
                        <path d="M2,12 a1,1 1 1,0 20,0" fill="#25C799" />
                    </svg>
                </label>
            </div>
        </div>
    </div>
    <!-- Color customizer end here -->

    <!-- Navbar style start here -->
    <h5 class="mt-4 mb-3">{{__('customization.navbar_style')}}</h5>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-3 mb-4">
      <div data-setting="radio" class="text-center col">
        <input type="radio" value="nav-glass" class="btn-check" name="header_navbar" id="nav-glass" autocomplete="off">
        <label class="btn btn-border  d-block text-center" for="nav-glass">{{__('customization.glass')}}</label>
      </div>
      <div data-setting="radio" class="text-center col">
        <input type="radio" value="navs-sticky" class="btn-check" name="header_navbar" id="navs-sticky" autocomplete="off">
        <label class="btn btn-border  d-block text-center" for="navs-sticky">{{__('customization.sticky')}}</label>
      </div>
      <div data-setting="radio" class="text-center col">
        <input type="radio" value="navs-transparent" class="btn-check" name="header_navbar" id="navs-transparent" autocomplete="off" checked>
        <label class="btn btn-border  d-block text-center" for="navs-transparent">{{__('customization.transparent')}}</label>
      </div>
      <div data-setting="radio" class="text-center col">
        <input type="radio" value="navs-default" class="btn-check" name="header_navbar" id="navs-default" autocomplete="off" checked>
        <label class="btn btn-border  d-block text-center" for="navs-default">{{__('customization.default')}}</label>
      </div>
    </div>
    <!-- Navbar style end here -->

   <!-- navbar hide start here -->
   <div data-setting="checkbox">
       <div class="d-flex justify-content-between align-items-center">
           <h6 class="mt-4 mb-3">{{__('customization.navbar_hide')}}</h6>
           <div class="form-check form-switch">
               <input class="form-check-input" value="iq-navbar-none" class="btn-check"
                   name="header_navbar_show" id="switch-navbar-show" type="checkbox">
           </div>
       </div>
   </div>
   <!-- navbar hide end here -->


    <!-- Card style start here -->
    <div class="mb-4">
        <div class="mt-4 mb-3">
            <h6 class="d-inline-block mb-0 me-2">{{__('customization.card_style')}}</h6>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-3">
            <div data-setting="radio">
                <input type="radio" value="card-default" class="btn-check" name="card_color"
                    id="card-default" checked>
                <label class="btn btn-border d-block text-center" for="card-default" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Card White"
                    data-bs-original-title="Card White">
                    <span>{{__('customization.default')}}</span>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="card-glass" class="btn-check" name="card_color"
                    id="card-glass">
                <label class="btn btn-border d-block text-center" for="card-glass" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Card Glass"
                    data-bs-original-title="Card Glass">
                    <span>{{__('customization.glass')}}</span>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="card-transparent" class="btn-check" name="card_color"
                    id="card-transparent">
                <label class="btn btn-border d-block text-center" for="card-transparent" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Card Transparent"
                    data-bs-original-title="Card Transparent">
                    <span>{{__('customization.transparent')}}</span>
                </label>
            </div>
        </div>
    </div>
    <!-- Card style end here -->

    <!-- Menu color start here -->

    <div class="d-none">
        <h6 class="mt-4 mb-3">{{__('customization.menu_color')}}</h6>
        <div class="d-grid gap-3 grid-cols-3 mb-3">
            <div data-setting="radio">
                <input type="radio" value="sidebar-white" class="btn-check"
                    name="sidebar_color" id="sidebar-white" checked>
                <label class="btn btn-border d-flex align-items-center bg-transparent"
                    for="sidebar-white" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Sidebar White" data-bs-original-title="Sidebar White">
                    <i class="text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-18"
                            width="18" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="8"
                                fill="currentColor" stroke="black" stroke-width="3"></circle>
                        </svg>
                    </i>
                    <span class="ms-2 ">{{__('customization.default')}}</span>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="sidebar-dark" class="btn-check"
                    name="sidebar_color" id="sidebar-dark">
                <label class="btn btn-border d-flex align-items-center bg-transparent"
                    for="sidebar-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Sidebar Dark" data-bs-original-title="Sidebar Dark">
                    <i class="text-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-18"
                            width="18" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="8"
                                fill="currentColor"></circle>
                        </svg>
                    </i>
                    <span class="ms-2 "> {{__('customization.dark')}} </span>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="sidebar-color" class="btn-check"
                    name="sidebar_color" id="sidebar-color">
                <label class="btn btn-border d-flex align-items-center bg-transparent"
                    for="sidebar-color" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Sidebar Colored" data-bs-original-title="Sidebar Colored">
                    <i class="text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-18"
                            width="18" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="8"
                                fill="currentColor"></circle>
                        </svg>
                    </i>
                    <span class="ms-2 "> {{__('customization.color')}} </span>
                </label>
            </div>
        </div>
        <div class="d-grid gap-3 grid-cols-2 mb-4">
            <div data-setting="radio">
                <input type="radio" value="sidebar-transparent" class="btn-check"
                    name="sidebar_color" id="sidebar-transparent">
                <label class="btn btn-border d-flex align-items-center bg-transparent"
                    for="sidebar-transparent" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Sidebar Transparent"
                    data-bs-original-title="Sidebar Transparent">
                    <i class="text-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-18"
                            width="18" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="8"
                                fill="#F5F6FA" stroke="black" stroke-width="3"></circle>
                        </svg>
                    </i>
                    <span class="ms-2">{{__('customization.transparent')}}</span>
                </label>
            </div>
            <div data-setting="radio">
                <input type="radio" value="sidebar-glass" class="btn-check"
                    name="sidebar_color" id="sidebar-glass">
                <label class="btn btn-border d-flex align-items-center bg-transparent"
                    for="sidebar-glass" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Sidebar Transparent" data-bs-original-title="Sidebar Transparent">
                    <i class="text-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-18"
                            width="18" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="8"
                                fill="#F5F6FA" stroke="black" stroke-width="3"></circle>
                        </svg>
                    </i>
                    <span class="ms-2">{{__('customization.glass')}}</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Menu color end here -->

    <!-- Menu Style start here -->

    <div>
        <h6 class="mt-4 mb-3">{{__('customization.menu_style')}}</h6>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-3 mb-4">
            <div data-setting="checkbox" class="text-center col">
                <input type="checkbox" value="sidebar-mini" class="btn-check"
                    name="sidebar_type" id="sidebar-mini">
                <label class="btn btn-border d-block text-center" for="sidebar-mini">{{__('customization.mini')}}</label>
            </div>
            <div data-setting="checkbox" class="text-center col">
                <input type="checkbox" value="sidebar-hover"
                    data-extra="{target: '.sidebar', ClassListAdd: 'sidebar-mini'}"
                    class="btn-check" name="sidebar_type" id="sidebar-hover">
                <label class="btn btn-border d-block text-center" for="sidebar-hover">{{__('customization.hover')}}</label>
            </div>
            <div data-setting="checkbox" class="text-center col">
                <input type="checkbox" value="sidebar-boxed" class="btn-check"
                    name="sidebar_type" id="sidebar-boxed">
                <label class="btn btn-border d-block text-center" for="sidebar-boxed">{{__('customization.boxed')}}</label>
            </div>
            <div data-setting="checkbox" class="text-center col">
                <input type="checkbox" value="sidebar-soft" class="btn-check"
                    name="sidebar_type" id="sidebar-soft">
                <label class="btn btn-border d-block text-center" for="sidebar-soft">{{__('customization.soft')}}</label>
            </div>
        </div>
    </div>

    <!-- Menu Style end here -->

    <!-- Active Menu Style start here -->

    <div>
        <h6 class="mt-4 mb-3">{{__('customization.active_menu_style')}}</h6>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-3 mb-4">
            <div data-setting="radio" class="text-center col">
                <input type="radio" value="sidebar-default navs-rounded" class="btn-check" name="sidebar_menu_style" id="navs-rounded">
                <label class="btn btn-border d-block text-center" for="navs-rounded">{{__('customization.rounded_one_side')}}</label>
            </div>
            <div data-setting="radio" class="text-center col">
                <input type="radio" value="sidebar-default navs-rounded-all" class="btn-check" name="sidebar_menu_style" id="navs-rounded-all">
                <label class="btn btn-border d-block text-center" for="navs-rounded-all">{{__('customization.rounded_all')}}</label>
            </div>
            <div data-setting="radio" class="text-center col">
                <input type="radio" value="sidebar-default navs-pill" class="btn-check" name="sidebar_menu_style" id="navs-pill">
                <label class="btn btn-border d-block text-center" for="navs-pill">{{__('customization.pill_one_side')}}</label>
            </div>
            <div data-setting="radio" class="text-center col">
                <input type="radio" value="sidebar-default navs-pill-all" class="btn-check" name="sidebar_menu_style" id="navs-pill-all">
                <label class="btn btn-border d-block text-center" for="navs-pill-all">{{__('customization.pill_all')}}</label>
            </div>
            <div data-setting="radio" class="text-center col">
                <input type="radio" value="left-bordered" class="btn-check" name="sidebar_menu_style" id="left-bordered" checked>
                <label class="btn btn-border d-block text-center" for="left-bordered">{{__('customization.left_bordered')}}</label>
            </div>
            <div data-setting="radio" class="text-center col">
                <input type="radio" value="sidebar-default navs-full-width" class="btn-check" name="sidebar_menu_style" id="navs-full-width">
                <label class="btn btn-border d-block text-center" for="navs-full-width">{{__('customization.full_width')}}</label>
            </div>
        </div>
    </div>

<!-- Active Menu Style end here -->

<!-- menu hide start here -->
{{-- <div data-setting="checkbox">
    <div class="d-flex justify-content-between align-items-center">
        <h6 class="mt-4 mb-3">{{__('customization.menu_hide')}}</h6>
        <div class="form-check form-switch">
            <input class="form-check-input" value="sidebar-none" class="btn-check"
                name="sidebar_show" id="switch-sidebar-show" type="checkbox">
        </div>
    </div>
</div> --}}
<!-- menu hide end here -->

<div class="mt-4 mb-3">
    <h6 class="d-inline-block mb-0 me-2">{{__('customization.footer')}} </h6>
</div>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-3 mb-4">
    <div data-setting="radio" class="col">
        <input type="radio" value="default" class="btn-check" name="footer" id="footer_default" checked>
        <label class="btn btn-border d-block" for="footer_default">{{__('customization.default')}}</label>
    </div>
    <div data-setting="radio" class="col">
        <input type="radio" value="sticky" class="btn-check" name="footer" id="footer_Sticky">
        <label class="btn btn-border d-block" for="footer_Sticky">{{__('customization.sticky')}}</label>
    </div>
    <div data-setting="radio" class="col">
        <input type="radio" value="glass" class="btn-check" name="footer" id="footer_glass">
        <label class="btn btn-border d-block" for="footer_glass">{{__('customization.glass')}}</label>
    </div>
</div>


    <div class="form-group text-end">
        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
    </div>
</form>
@endsection

@push('after-scripts')
<!-- Utilities Functions -->
<script src="{{ asset('js/iqonic-script/utility.js') }}"></script>
<!-- Settings Script -->
<script src="{{ asset('js/iqonic-script/setting.js') }}"></script>
<script src="{{ asset('js/setting-init.js') }}" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('settings-form-data');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        const formData = new FormData(form);

        // Convert FormData to JSON object
        const dataToSend = {};

        // Initialize the sidebar_type array
        dataToSend['sidebar_type'] = { 'value': [] };

        formData.forEach(function(value, key) {
            if (key === 'sidebar_type') {
                // If key is 'sidebar_type', push the value into the array
                dataToSend['sidebar_type'].value.push(value);
            } else {
                // Otherwise, store the value normally
                dataToSend[key] = { 'value': value };
            }
        });

        // Create customization_json object
        const customizationObject = {
            saveLocal: 'sessionStorage',
            storeKey: 'streamit-setting',
            setting: dataToSend,
        };

        // Convert customizationObject to JSON string
        const customizationJson = JSON.stringify(customizationObject);


        // Send data to backend
        fetch(form.action, {
            method: 'POST',
            body: JSON.stringify({
                customization_json: customizationJson
            }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch(error => {
            window.location.reload();
        });
    });
});


    </script>
@endpush
