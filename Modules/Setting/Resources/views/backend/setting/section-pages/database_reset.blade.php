

@extends('setting::backend.setting.index')

@section('settings-content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>   <i class="fa-solid fa-database"></i> {{ __('setting_sidebar.lbl_database_reset') }}</h4>
 
    </div>

    
        {{-- <button type="button" class="btn btn-primary " onclick="clearCache()">
            <i class="fa-solid fa-arrow-rotate-left mx-2"></i>{{ __('setting_sidebar.load_sample_data') }}
          </button>
    
          <button type="button" class="btn btn-primary " onclick="clearCache()">
            <i class="fa-solid fa-arrow-rotate-left mx-2"></i>{{ __('setting_sidebar.reset_database') }}
          </button> --}}


<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <div class="col-md-offset-3 col-sm-12 ">
                <a href="{{route('backend.dataload')}}" class= "btn btn-md btn-primary float-md-end">{{__('setting_sidebar.load_simple_data')}}</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <div class="col-md-offset-3 col-sm-12 ">
                <a href="{{route('backend.datareset')}}" class= "btn btn-md btn-primary float-md-end">{{__('setting_sidebar.reset_database')}}</a>      
            </div>
        </div>
    </div>
</div>





  @endsection
  @push('after-scripts')

  <script>


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








  </script>
    @endpush

