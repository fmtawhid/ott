<x-auth-layout>
  <x-slot name="title">
    @lang('Login')
  </x-slot>

  <x-auth-card>
    <x-slot name="logo">
    @php
    $logo = GetSettingValue('dark_logo') ?? asset(setting('dark_logo'));
@endphp

<a href="{{ route('user.login') }}">
    <img src="{{ $logo }}" class="img-fluid logo h-4 mb-4">
</a>
    </x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Social Login -->
    <x-auth-social-login />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ $url ?? route('admin-login') }}">
      @csrf

      <!-- Email Address -->
      <div>
        <x-label for="email" :value="__('frontend.email')" />

        <x-input id="email" type="email" name="email" placeholder="{{__('frontend.enter_email')}}" :value="old('email')" required autofocus />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-label for="password" :value="__('frontend.password')" />

        <x-input id="password" type="password" name="password" placeholder="{{__('messages.enter_password')}}" required autocomplete="current-password" />
      </div>

      <!-- Remember Me -->
      <div class="mt-4">
        <label for="remember_me" class="d-inline-flex">
          <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
          <span class="ms-2">{{ __('frontend.remember_me') }}</span>
        </label>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
          {{ __('frontend.forgot_password') }}
        </a>
        @endif

        <button type="submit" id="submit-btn" onclick="disableButton()" class="btn btn-primary">
            {{ __('frontend.login') }}
        </button>
      </div>
    </form>
    <div class="d-none">
      <h6 class="text-center border-top py-3 mt-3">Demo Accounts</h6>
      <div class="parent">

      <select name="select"  id="SelectUser"  id="select" class="form-control selectpiker" onchange="getSelectedOption()">
          <option value="">Select Role</option>
          <option value="12345678,admin@tihd.com">Admin</option>
          <option value="secret,john@tihd.com">User</option>
      </select>

</div>

    </div>
    @if(env('IS_DEMO'))
    <div>
      <h6 class="text-center border-top py-3 mt-3">Demo Accounts</h6>
      <div class="d-flex justify-content-between">
        <div>
          <p class="mb-0" id="admin_email">admin@streamit.com</p>
          <p id="admin_password">12345678</p>
        </div>
        <div>
          <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-title="Click To Copy" onclick="setLoginCredentials('admin')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
            </svg>
          </a>
        </div>
      </div>
      <div class="d-flex justify-content-between">
        <div>
          <p class="mb-0" id="employee_email">john@streamit.com</p>
          <p id="employee_password">secret</p>
        </div>
        <div>
          <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-title="Click To Copy" onclick="setLoginCredentials('employee')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" width="18" height="18">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    @endif

    <x-slot name="extra">
      @if (Route::has('register'))
      <p class="text-center text-gray-600 mt-4">
        Do not have an account? <a href="{{ route('register') }}" class="underline hover:text-gray-900">Register</a>.
      </p>
      @endif
    </x-slot>
  </x-auth-card>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>

    .select2-container--default .select2-selection--single .select2-selection__rendered{
      line-height: inherit;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow,
    .select2-container--default .select2-selection--single .select2-selection__clear,
    .select2-container--classic .select2-selection--single .select2-selection__arrow {
      height: 100%;
    }

    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script type="text/javascript">
     window.onload = function() {
        getSelectedOption();
    };

    $(document).ready(function() {
            $('#SelectUser').select2({
                placeholder: "Select Role",
                minimumResultsForSearch: Infinity

            });
        });

 function disableButton(){
document.getElementById('submit-btn').classList.add('disabled');
document.getElementById('submit-btn').innerText = 'Login...';

}



    function getSelectedOption() {
        var selectElement = document.getElementById("SelectUser");
        var selectedOption = selectElement.options[selectElement.selectedIndex];

        if (selectedOption  && selectedOption.value !== "") {
            var optionText = selectedOption.textContent || selectedOption.innerText; // Get the text of the selected option
            var optionValue = selectedOption.value; // Get the value of the selected option

            var values = optionValue.split(",");
            var password = values[0];
            var email = values[1];

            domId('email').value =email;
            domId('password').value = password;

        } else {
          domId('email').value = "";
          domId('password').value = "";
        }
    }
    function domId (name) {
      return document.getElementById(name)
    }
    function setLoginCredentials(type) {
      domId('email').value = domId(type+'_email').textContent
      domId('password').value = domId(type+'_password').textContent
    }
  </script>
</x-auth-layout>
