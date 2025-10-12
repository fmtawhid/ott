<a href="{{ route('movies.genre', $genres_list['id']) }}" class="text-center genres-card d-block position-relative">
    <img src="{{$genres_list['genre_image']}}" alt="genres img" class="object-cover rounded genres-img">
    <span class="h6 mb-0 geners-title line-count-1">  {{ $genres_list['name'] }}</span>
  </a>

