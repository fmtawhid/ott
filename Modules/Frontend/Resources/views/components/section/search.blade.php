<div class="movie-lists section-spacing-bottom">
    <div class="container-fluid">
        <div class="row gy-4 row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6" id="entertainment-list">

            <div id="entertainment-card">
                @include('frontend::components.card.card_entertainment',  ['video_card' => 'video'])
            </div>

            <div id="tvshow-card">
                @include('frontend::components.card.card_entertainment',  ['video_card' => 'video'])
            </div>


        </div>
    </div>
</div>
