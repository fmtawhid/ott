

@extends('setting::backend.setting.index')

@section('settings-content')
<!-- <form method="POST" action="{{ route('backend.setting.store') }}" enctype="multipart/form-data" id="settings-form"> -->
{{ html()->form('POST', route('backend.setting.store'))
    ->attribute('data-toggle', 'validator')
    ->attribute('id', 'form-submit')  // Add the id attribute here
    ->class('requires-validation')  // Add the requires-validation class
    ->attribute('novalidate', 'novalidate')  // Disable default browser validation
    ->attribute('enctype', 'multipart/form-data')
    ->open()
}}
    @csrf
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>   <i class="fas fa-cube"></i> {{ __('setting_sidebar.lbl_General') }}</h4>


    <div>
      <button type="button" class="btn btn-primary float-right" onclick="clearCache()">
        <i class="fa-solid fa-arrow-rotate-left mx-2"></i>{{ __('settings.purge_cache') }}
      </button>

      <!-- @role('admin')
      <button type="button" class="btn btn-primary float-right" onclick="resetDatabase()">
        <i class="fa-solid fa-arrow-rotate-left mx-2"></i>{{ __('setting_sidebar.lbl_database_reset') }}
      </button>
     @endrole -->
    </div>
    </div>


    <div class="form-group">
      <label class="form-label">{{ __('setting_bussiness_page.lbl_app') }} <span class="text-danger">*</span></label>
      {{ html()->text('app_name')
                ->class('form-control')
                ->value($data['app_name'] ?? old('app_name'))
                ->required() }}
                <div class="invalid-feedback" id="name-error">App field is required</div>
    </div>

    <div class="form-group">
      <label class="form-label">{{ __('setting_bussiness_page.lbl_user_app') }} <span class="text-danger">*</span></label>
      {{ html()->text('user_app_name')
                ->class('form-control')
                ->value($data['user_app_name'] ?? old('user_app_name'))
                ->required() }}
                <div class="invalid-feedback" id="name-error">User App field is required</div>
    </div>

    <div class="form-group">
      <label class="form-label">{{ __('setting_bussiness_page.lbl_contact_no') }} <span class="text-danger">*</span></label>
      {{ html()->text('helpline_number')
                ->class('form-control')
                ->value($data['helpline_number'] ?? old('helpline_number'))
                ->required() }}
                <div class="invalid-feedback" id="name-error">Helpline Number field is required</div>
    </div>

    <div class="form-group">
      <label class="form-label">{{ __('setting_bussiness_page.lbl_inquiry_email') }} <span class="text-danger">*</span></label>
      {{ html()->email('inquriy_email')
                ->class('form-control')
                ->value($data['inquriy_email'] ?? old('inquriy_email'))
                ->required() }}
                <div class="invalid-feedback" id="name-error">Inquiry email field is required</div>
    </div>

    <div class="form-group">
      <label class="form-label">{{ __('setting_bussiness_page.lbl_site_description') }} <span class="text-danger">*</span></label>
      {{ html()->text('short_description')
                ->class('form-control')
                ->value($data['short_description'] ?? old('short_description'))
                ->required() }}
                <div class="invalid-feedback" id="name-error">Short description field is required</div>
    </div>

    <div class="row">

        {{-- <div class="form-group mb-3 col-md-6">
  <label for="logo" class="form-label">{{ __('messages.logo') }}</label>
  <div class="row align-items-center">
    <div class="col-lg-4">
      <div class="card text-center">
        <div class="card-body">
          <img id="logoViewer" src="{{ $data['logo'] ?? asset('img/logo/logo.png') }}" class="img-fluid" alt="logo" />
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="d-flex align-items-center gap-2">
        <input type="file" class="form-control d-none" id="logo" name="logo" accept=".jpeg, .jpg, .png, .gif">
        <button type="button" class="btn btn-primary mb-5" onclick="document.getElementById('logo').click();">{{ __('messages.upload') }}</button>
        <button type="button" class="btn btn-dark mb-5" id="removeLogoButton">{{ __('messages.remove') }}</button>
      </div>
      <span class="text-danger" id="error_logo"></span>
    </div>
  </div>
</div> --}}

        <!-- Mini Logo Upload -->
        <div class="form-group mb-3 col-md-6">
  <label for="mini_logo" class="form-label">{{ __('messages.mini_logo') }}</label>
  <div class="row align-items-center">
    <div class="col-lg-4">
      <div class="card text-center">
        <div class="card-body">
          <img id="miniLogoViewer" src="{{ $data['mini_logo'] ?? asset('img/logo/mini_logo.png') }}" class="img-fluid" alt="mini_logo" />
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="d-flex align-items-center gap-2">
        <input type="file" class="form-control d-none" id="mini_logo" name="mini_logo" accept=".jpeg, .jpg, .png, .gif">
        <button type="button" class="btn btn-primary mb-5" onclick="document.getElementById('mini_logo').click();">{{ __('messages.upload') }}</button>
        <button type="button" class="btn btn-dark mb-5" id="removeMiniLogoButton">{{ __('messages.remove') }}</button>
      </div>
      <span class="text-danger" id="error_mini_logo"></span>
    </div>
  </div>
</div>

        <!-- Dark Logo Upload -->
        <div class="form-group mb-3 col-md-6">
  <label for="dark_logo" class="form-label">{{ __('messages.logo') }}</label>
  <div class="row align-items-center">
    <div class="col-lg-4">
      <div class="card text-center bg-dark">
        <div class="card-body">
          <img id="darkLogoViewer" src="{{ $data['dark_logo'] ?? asset('img/logo/dark_logo.png') }}" class="img-fluid" alt="dark_logo" />
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="d-flex align-items-center gap-2">
        <input type="file" class="form-control d-none" id="dark_logo" name="dark_logo" accept=".jpeg, .jpg, .png, .gif">
        <button type="button" class="btn btn-primary mb-5" onclick="document.getElementById('dark_logo').click();">{{ __('messages.upload') }}</button>
        <button type="button" class="btn btn-dark mb-5" id="removeDarkLogoButton">{{ __('messages.remove') }}</button>
      </div>
      <span class="text-danger" id="error_dark_logo"></span>
    </div>
  </div>
</div>

        <!-- Light Logo Upload -->
  {{-- <div class="form-group mb-3 col-md-6">
  <label for="light_logo" class="form-label">{{ __('messages.light_logo') }}</label>
  <div class="row align-items-center">
    <div class="col-lg-4">
      <div class="card text-center bg-light">
        <div class="card-body">
          <img id="lightLogoViewer" src="{{ $data['light_logo'] ?? asset('img/logo/light_logo.png') }}" class="img-fluid" alt="light_logo" />
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="d-flex align-items-center gap-2">
        <input type="file" class="form-control d-none" id="light_logo" name="light_logo" accept=".jpeg, .jpg, .png, .gif">
        <button type="button" class="btn btn-primary mb-5" onclick="document.getElementById('light_logo').click();">{{ __('messages.upload') }}</button>
        <button type="button" class="btn btn-dark mb-5" id="removeLightLogoButton">{{ __('messages.remove') }}</button>
      </div>
      <span class="text-danger" id="error_light_logo"></span>
    </div>
  </div>
</div> --}}

        <!-- Favicon -->
    <div class="form-group mb-3 col-md-6">
  <label for="favicon" class="form-label">{{ __('messages.favicon') }}</label>
  <div class="row align-items-center">
    <div class="col-lg-4">
      <div class="card text-center bg-light">
        <div class="card-body">
          <img id="faviconViewer" src="{{ $data['favicon'] ?? asset('img/logo/favicon.png') }}" class="img-fluid" alt="favicon_logo" />
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="d-flex align-items-center gap-2">
        <input type="file" class="form-control d-none" id="favicon" name="favicon" accept=".jpeg, .jpg, .png, .gif">
        <button type="button" class="btn btn-primary mb-5" onclick="document.getElementById('favicon').click();">{{ __('messages.upload') }}</button>
        <button type="button" class="btn btn-dark mb-5" id="removeFaviconButton">{{ __('messages.remove') }}</button>
      </div>
      <span class="text-danger" id="error_favicon"></span>
    </div>
  </div>
</div>

    <div class="form-group text-end">
      <button type="submit" class="btn btn-primary float-right" id="submit-button">
     {{ __('messages.save') }}
      </button>
    </div>
  </form>
  @endsection
  @push('after-scripts')

  <script>


    document.addEventListener('DOMContentLoaded', function() {

// document.getElementById('removeLogoButton').addEventListener('click', function() {
//     const logoViewer = document.getElementById('logoViewer');
//     const defaultLogo = "{{ asset('img/logo/logo.png') }}";

//     // Reset the image src to the default logo
//     logoViewer.src = defaultLogo;

//     // Also clear the file input in case user uploaded something
//     const logoInput = document.getElementById('logo');
//     logoInput.value = '';

//     // Optional: clear any validation errors
//     document.getElementById('error_logo').innerText = '';
//   });

       document.getElementById('removeMiniLogoButton').addEventListener('click', function() {
    const miniLogoViewer = document.getElementById('miniLogoViewer');
    const defaultMiniLogo = "{{ asset('img/logo/mini_logo.png') }}";

    // Reset the mini logo image to default
    miniLogoViewer.src = defaultMiniLogo;

    // Clear the file input
    const miniLogoInput = document.getElementById('mini_logo');
    miniLogoInput.value = '';

    // Clear any validation errors
    document.getElementById('error_mini_logo').innerText = '';
  });

        document.getElementById('removeDarkLogoButton').addEventListener('click', function() {
    const darkLogoViewer = document.getElementById('darkLogoViewer');
    const defaultDarkLogo = "{{ asset('img/logo/dark_logo.png') }}";

    // Reset the dark logo image to the default
    darkLogoViewer.src = defaultDarkLogo;

    // Clear the file input
    const darkLogoInput = document.getElementById('dark_logo');
    darkLogoInput.value = '';

    // Clear any validation errors
    document.getElementById('error_dark_logo').innerText = '';
  });

//         document.getElementById('removeLightLogoButton').addEventListener('click', function() {
//     const lightLogoViewer = document.getElementById('lightLogoViewer');
//     const defaultLightLogo = "{{ asset('img/logo/light_logo.png') }}";

//     // Reset light logo to default
//     lightLogoViewer.src = defaultLightLogo;

//     // Clear file input
//     const lightLogoInput = document.getElementById('light_logo');
//     lightLogoInput.value = '';

//     // Clear error messages
//     document.getElementById('error_light_logo').innerText = '';
//   });
      document.getElementById('removeFaviconButton').addEventListener('click', function() {
    const faviconViewer = document.getElementById('faviconViewer');
    const defaultFavicon = "{{ asset('img/logo/favicon.png') }}";

    // Reset favicon image to default
    faviconViewer.src = defaultFavicon;

    // Clear the file input
    const faviconInput = document.getElementById('favicon');
    faviconInput.value = '';

    // Clear any error messages
    document.getElementById('error_favicon').innerText = '';
  });
    });
    // Function to preview selected image in the corresponding image element
    function previewImage(inputId, imageId) {
      const input = document.getElementById(inputId);
      const imgElement = document.getElementById(imageId);

      const file = input.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          imgElement.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }

    function clearCache() {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to clear the cache?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Clear it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route('backend.settings.clear-cache') }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Cache Clear successfully', // Use the dynamic message from the server
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                }
            })
            .catch(error => {
                console.error('Error clearing cache:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while clearing the cache.',
                    icon: 'error',
                    showConfirmButton: true
                });
            });
        }
    });
}


function resetDatabase() {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to reset the Database?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Change button text to "Loading..." and disable it
            let button = document.querySelector('button[onclick="resetDatabase()"]');
            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin mx-2"></i>Loading...';

            fetch('{{ route('backend.settings.database-reset') }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Database reset successfully', // Use the dynamic message from the server
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                }
            })
            .catch(error => {
                console.error('Error clearing cache:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while resetting the database.',
                    icon: 'error',
                    showConfirmButton: true
                });
            })
            .finally(() => {
                // Reset the button text and enable it after the request
                button.disabled = false;
                button.innerHTML = '<i class="fa-solid fa-arrow-rotate-left mx-2"></i>{{ __('setting_sidebar.lbl_database_reset') }}';
            });
        }
    });
}







    // Function to clear cache
    // function clearCache() {
    //   if (confirm('Are you sure you want to clear the cache?')) {
    //     fetch('{{ route('backend.settings.clear-cache') }}', {
    //       method: 'GET',
    //       headers: {
    //         'Content-Type': 'application/json',
    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //       }
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //       if (data.success) {
    //         alert('Cache cleared successfully.');
    //       } else {
    //         alert('Failed to clear cache.');
    //       }
    //     })
    //     .catch(error => {
    //       console.error('Error clearing cache:', error);
    //       alert('An error occurred while clearing the cache.');
    //     });
    //   }
    // }



//   const logoInput = document.getElementById('logo');
//   const logoViewer = document.getElementById('logoViewer');


//   logoInput.addEventListener('change', function() {
//     const file = this.files[0];
//     if (file) {
//       const reader = new FileReader();
//       reader.onload = function(e) {
//         logoViewer.src = e.target.result;
//       }
//       reader.readAsDataURL(file);
//     }
//   });


  const minilogoInput = document.getElementById('mini_logo');
  const miniLogoViewer = document.getElementById('miniLogoViewer');

  minilogoInput.addEventListener('change', function() {
    const minilogofile = this.files[0];
    if (minilogofile) {
      const reader = new FileReader();
      reader.onload = function(e) {
        miniLogoViewer.src = e.target.result;
      }
      reader.readAsDataURL(minilogofile);
    }
  });

  const darklogoInput = document.getElementById('dark_logo');
  const darkLogoViewer = document.getElementById('darkLogoViewer');

  darklogoInput.addEventListener('change', function() {
    const darklogofile = this.files[0];
    if (darklogofile) {
      const reader = new FileReader();
      reader.onload = function(e) {
        darkLogoViewer.src = e.target.result;
      }
      reader.readAsDataURL(darklogofile);
    }
  });


//   const lightlogoInput = document.getElementById('light_logo');
//   const lightLogoViewer = document.getElementById('lightLogoViewer');

//   lightlogoInput.addEventListener('change', function() {
//     const lightlogofile = this.files[0];
//     if (lightlogofile) {
//       const reader = new FileReader();
//       reader.onload = function(e) {
//         lightLogoViewer.src = e.target.result;
//       }
//       reader.readAsDataURL(lightlogofile);
//     }
//   });
  const faviconInput = document.getElementById('favicon');
  const faviconViewer = document.getElementById('faviconViewer');

  faviconInput.addEventListener('change', function() {
    const faviconFile = this.files[0];
    if (faviconFile) {
      const reader = new FileReader();
      reader.onload = function(e) {
        faviconViewer.src = e.target.result;
      }
      reader.readAsDataURL(faviconFile);
    }
  });


  </script>
    @endpush

