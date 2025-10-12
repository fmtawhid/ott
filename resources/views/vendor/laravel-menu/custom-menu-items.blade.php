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
                class="nav-link menu-arrow"
                @if ($item->hasChildren())
                    data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ $active != '' ? 'true' : 'false' }}" aria-controls="collapseExample"
                @endif
                @lm_endattrs href="{!! $item->url() !!}">
            {!! $item->title !!}
            @if ($item->hasChildren())
                @if($item->parent !== null)
                    <i class="right-icon">
                        <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.5 5L15.5 12L8.5 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </i>
                @endif
            @endif
            </a>
        @endif
        @if ($item->hasChildren())
            <ul class="iq-header-sub-menu list-unstyled collapse  {{ $active != '' ? 'show' : '' }}" id="{!! str_replace('#', '', $item->link->attr()['href'] ?? '') !!}"
                data-bs-parent="{!! $item->link->attr()['data-bs-parent'] ?? '#sidebar-menu' !!}">
                @include('vendor.laravel-menu.custom-menu-items', ['items' => $item->children()])
            </ul>
        @endif
      </li>
@endforeach
