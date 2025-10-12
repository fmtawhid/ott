<div class="media-item d-flex align-items-center gap-3">
    <img src="{{ $thumbnail ?  $thumbnail : setDefaultImage($thumbnail)}}" alt="{{ $name }}" class="media-thumbnail avatar avatar-100">
    <div class="media-details">
        <h4 class="media-name mb-1">{{ $name }}</h3>
        @if($type == 'episode')
            <p class="media-genre mb-1">{{ $seasonName }}</p>
        @endif
        @if($type == 'castcrew')
            <p class="media-genre mb-1">{{ $designation }}</p>
        @endif
        @if($type == 'movie' || $type == 'tvshow')
            <p class="media-genre mb-1">{{ $genre }}</p>
            <p class="media-release-date mb-1">{{ $releaseDate }}</p>
        @endif
    </div>
</div>
