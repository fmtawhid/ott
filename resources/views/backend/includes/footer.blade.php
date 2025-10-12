
{{-- Footer Section Start --}}
<footer class="footer pr-hide sticky {{ getCustomizationSetting('footer_style') }}">
  <div class="footer-body">
      <div class="text-center">
          <a href="{{ route('backend.home') }}">{{setting('app_name')}}</a>
           <span>(v{{ config('app.version') }})</span>
      </div>
  </div>
</footer>
