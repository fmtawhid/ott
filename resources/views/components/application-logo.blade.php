
            @php

            $logo=GetSettingValue('dark_logo') ??  asset(setting('dark_logo'));
        @endphp

<img src="{{  $logo }}" class="img-fluid h-4 mb-4">

