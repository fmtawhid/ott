

    <meta name="seo_image" id="dynamicSeoImage" content="{{ $seo->seo_image ?? '' }}">
    <meta name="title" id="dynamicMetaTitle" content="{{ $seo->meta_title ?? 'Default Title' }}">
    <title id="pageTitle">{{ $seo->meta_title ?? config('app.name') }}</title>
    <meta name="google-site-verification" id="dynamicGoogleVerification" content="{{ $seo->google_site_verification ?? '' }}">
    {{-- <meta name="keywords" id="dynamicMetaKeywords" content="{{ isset($seo->meta_keywords) && json_decode($seo->meta_keywords) !== null ? implode(',', array_map(function($keyword) { return $keyword['value']; }, json_decode($seo->meta_keywords, true))) : '' }}"> --}}
    <meta name="keywords" id="dynamicMetaKeywords" content="{{
        isset($seo->meta_keywords) ? (
            $decodedKeywords = json_decode($seo->meta_keywords, true)
            ) && is_array($decodedKeywords) ? implode(',', array_column($decodedKeywords, 'value')) : ''
        : ''
    }}">


    <link rel="canonical" id="dynamicCanonicalUrl" href="{{ $seo->canonical_url ?? '' }}">
    <meta name="description" id="dynamicMetaDescription" content="{{ $seo->short_description ?? 'Default Description' }}">

