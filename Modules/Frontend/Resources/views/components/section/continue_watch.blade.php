<div class="continue-watching-block">
    <div class="d-flex align-items-center justify-content-between my-2">

        @php

          $profile_id=getCurrentProfile(auth()->user()->id, request());

          $name = optional(App\Models\UserMultiProfile::where('id', $profile_id)->first())->name ?? null;

        @endphp

            @if($name == null)
            <h5 class="main-title text-capitalize mb-0">{{__('frontend.continue_watching')}} </h5>
            @else

            <h5 class="main-title text-capitalize mb-0">{{__('frontend.continue_watching_for')}}  {{ $name }}</h5>
            @endif


        @if(count($continuewatchData)>6)
        <a href="{{ route('continueWatchList')}}" class="view-all-button text-decoration-none flex-none"><span>{{__('frontend.view_all')}}</span> <i class="ph ph-caret-right"></i></a>
        @endif
    </div>
    <div class="card-style-slider {{ count($continuewatchData) < 7 ? 'slide-data-less' : '' }}">
        <div class="card-style-slider continue-watch-delete {{ count($continuewatchData) < 7 ? 'slide-data-less' : '' }}">
            <div class="slick-general slick-general-continue-watch " data-items="5.5" data-items-laptop="4.5" data-items-tab="3.5" data-items-mobile-sm="2.5"
                data-items-mobile="1" data-speed="1000" data-autoplay="false" data-center="false" data-infinite="false"
                data-navigation="true" data-pagination="false" data-spacing="12">
                    @foreach (array_values($continuewatchData) as $data)
                        <div class="slick-item remove-continuewatch-card">
                             @include('frontend::components.card.card_continue_watch' ,['value' =>$data ])
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        function intializeremoveButton() {
            $('.continue_remove_btn').off('click').on('click', function() {
                const itemId = this.getAttribute('data-id');
                const baseUrl = document.querySelector('meta[name="baseUrl"]').getAttribute('content');
                const data = {
                    id: itemId,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                };

                fetch(`${baseUrl}/api/delete-continuewatch`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => {

                        if (response.ok) {

                             window.successSnackbar('Continuewatch remove successfully');

                             this.closest('.remove-continuewatch-card').remove();
                             const totalSlickItems = $('.continue-watch-delete .slick-item').length;
                            if (totalSlickItems === 0) {
                               $('.continue-watching-block').addClass('d-none');
                              }
                        } else {
                            alert('Failed to delete item');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while trying to delete the item.');
                    });
            });
        }
        intializeremoveButton()
    });
</script>
