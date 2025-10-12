@foreach ($items as $item)
  <?php
  if ($item->hasChildren()) {
      if (
          $item
              ->children()
              ->where('isActive', true)
              ->first() !== null
      ) {
          $active = 'active';
      } else {
          $active = '';
      }
  } else {
      $active = '';
  }
  ?>
  <li @lm_attrs($item) @if ($item->hasChildren()) class="nav-item" @endif @lm_endattrs>
      @if ($item->link)
          <a @lm_attrs($item->link)
              class="nav-link"
              @if ($item->hasChildren())
                  data-bs-toggle="collapse" role="button"
                  aria-expanded="{{ $active != '' ? 'true' : 'false' }}" aria-controls="collapseExample"
              @endif
              @lm_endattrs href="{!! $item->url() !!}">
          {!! $item->title !!}
          @if ($item->hasChildren())
              <i class="right-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
              </i>
          @endif
          </a>
      @else
      <span class="navbar-text">{!! $item->title !!}</span>
      @endif
      @if ($item->hasChildren())
          <ul class="sub-nav collapse  {{ $active != '' ? 'show' : '' }}" id="{!! str_replace('#', '', $item->link->attr()['href'] ?? '') !!}"
              data-bs-parent="{!! $item->link->attr()['data-bs-parent'] ?? '#sidebar-menu' !!}">
              @include(config('laravel-menu.views.bootstrap-items'), ['items' => $item->children()])
          </ul>
      @endif
    </li>
    @if ($item->divider)
        <li {!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
    @endif
@endforeach
