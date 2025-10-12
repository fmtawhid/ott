<div class="iq-navbar-header navs-bg-color">
    <div class="container-fluid iq-container pb-0">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb gap-2 heading-font m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.home') }}">{{__('messages.dashboard')}}</a></li>
                            @if(isset($show_name) && !empty($show_name))
                                <li><i class="ph ph-caret-double-right"></i></li>
                                <li class="breadcrumb-item"><a href="{{ route($route) }}">{{ $module_title ?? '' }}</a></li>
                                <li><i class="ph ph-caret-double-right"></i></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __($show_name) }}</li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ __($module_title ?? '') }}</li>
                            @endif
                        </ol>
                    </nav>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


