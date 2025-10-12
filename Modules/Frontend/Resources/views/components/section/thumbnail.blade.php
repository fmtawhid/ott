<div class="detail-page-banner">
    <div class="video-player-wrapper">
        <!-- Video.js core -->
        <link rel="stylesheet" href="{{ asset('css/video-js.css') }}" />
        <script src="{{ asset('js/videojs/video.min.js') }}"></script>

        <!-- YouTube Support -->
        <script src="{{ asset('js/videojs/videojs-youtube.min.js') }}"></script>

        <!-- IMA SDK -->
        <script src="{{ asset('js/videojs/ima3.js') }}"></script>

        <!-- Video.js Ads & IMA plugins -->
        <script src="{{ asset('js/videojs/videojs-contrib-ads.min.js') }}"></script>
        <script src="{{ asset('js/videojs/videojs.ima.min.js') }}"></script>
        <link href="{{ asset('css/videojs.ima.css') }}" rel="stylesheet">

        <div class="video-player">
            <video id="videoPlayer" class="video-js vjs-default-skin vjs-ima" controls width="560" height="315" muted
                poster="{{ $thumbnail_image }}" data-setup='{"muted": false}' data-type="{{ $type }}"
                content-video-type="{{ $content_video_type }}"
                data-continue-watch="{{ isset($continue_watch) && $continue_watch ? 'true' : 'false' }}"
                @if ($type != 'Local') data-watch-time="{{ $watched_time ?? 0 }}"
                    data-movie-access="{{ $dataAccess ?? '' }}"
                    data-encrypted="{{ $data }}"
                @endif
                @if (isset($content_type) && isset($content_id)) data-contentType="{{ $content_type }}"
                    data-contentId="{{ $content_id }}"
                @endif
            >
                @if ($type == 'Local')
                    <source src="{{ $data }}" type="video/mp4" id="videoSource">
                @endif
            </video>

            <!-- Vimeo iframe for Vimeo videos -->
            <div id="vimeoContainer">
                <iframe id="vimeoIframe" frameborder="0"
                    allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
                </iframe>
            </div>

            <!-- Custom Ad Modal -->
            <div id="customAdModal">
                <div id="customAdContent">
                    <!-- Ad content will be injected here -->
                    <button id="customAdCloseBtn">&times;</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Include Video.js script if not already -->
<script src="{{ asset('js/videoplayer.min.js') }}"></script>



<script>
    const videoPlayer = document.getElementById('videoPlayer_html5_api');

    window.addEventListener('load', function() {
        console.log(videoPlayer)
     videoPlayer.remove = 'muted';
    });
</script>


<script>
    var isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    var loginUrl = "{{ route('login') }}";  // Update with your actual login route
</script>
<style>
    .video-player-wrapper {
        position: relative;
    }

    #vimeoContainer {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        display: none;
    }

    #vimeoIframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
    }

    #customAdModal {
        display: none;
        position: absolute;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        align-items: center;
        justify-content: center;
    }

    #customAdContent {
        position: relative;
        background: rgba(0, 0, 0, 0.0);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    #customAdCloseBtn {
        position: absolute;
        top: -20px;
        right: -20px;
        background: #f00;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        font-size: 20px;
        cursor: pointer;
        z-index: 2;
    }
</style>
<style>
    /* Hide ALL IMA Skip Elements */
    .ima-skip-container,
    .ima-skip-button,
    div[class*="ima-ad-skip"],
    div[class*="ima_skip"],
    div[class*="ima-skip"],
    button[class*="ima-skip"],
    button[class*="ima_skip"],
    div[class*="skip-button"],
    .ima-skip-button-container,
    [class*="skip-container"],
    [data-skip-button],
    [data-skip-container] {
        opacity: 0 !important;
        visibility: hidden !important;
        display: none !important;
        pointer-events: none !important;
        width: 0 !important;
        height: 0 !important;
        position: absolute !important;
        top: -9999px !important;
        left: -9999px !important;
    }

    /* Keep IMA Progress and Countdown Visible */
    .ima-controls-div,
    .ima-progress-div,
    .ima-countdown-div,
    .ima-seek-bar-div,
    .ima-progress-bar-div {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    .vjs-texttrack-settings {
        display: none !important;
    }

    .video-js.vjs-ima {
        overflow: visible;
    }

    .video-js.vjs-ima .vjs-ima-ad-container {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        pointer-events: none;
    }

    .video-js.vjs-ima .vjs-ima-ad-container>div {
        pointer-events: auto;
    }

    .vjs-ad-cue {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        z-index: 10;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .vjs-ad-cue:hover {
        width: 6px;
        opacity: 0.8;
    }

    .vjs-ad-cue[title*="Mid-roll"] {
        background-color: orange;
    }

    .vjs-ad-cue[title*="Post-roll"] {
        background-color: orange;
    }

    .vjs-ad-cue[title*="Overlay"] {
        background-color: orange;
    }

    /* Enhanced Skip Button Styling */
    .vjs-skip-ad-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        z-index: 9999 !important;
        font-size: 14px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .vjs-skip-ad-button:hover {
        background: rgba(255, 0, 0, 0.9) !important;
        transform: scale(1.05);
    }

    .overlay-ad {
        position: absolute;
        bottom: 60px;
        left: 20px;
        z-index: 1000;
        background: rgba(0, 0, 0, 0.8);
        padding: 5px;
        /* border-radius: 6px; */
    }

    .video-player {
        position: relative;
        z-index: 0;
    }

    #customAdModal {
        display: none;
        position: absolute;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        align-items: center;
        justify-content: center;
    }

    #customAdContent {
        max-width: 1000px;
        max-height:600px;
        width:100%;
        height:100%;
        padding:40px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        position: relative;
    }
    #customAdContent img,
    #customAdContent a,
    #customAdContent video {
        max-width: 1000px;
        max-height: 600px;
        width: 100%;
        height: 100%;
        border-radius: 12px;
    }


    #customAdCloseBtn {
        position: absolute;
        top: 25px;
        transform: translate(-50%, -50%);
        right: -8px;
        background: #f00;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        font-size: 20px;
        cursor: pointer;
        z-index: 2;
    }
    @media (max-width: 575px) {
        #customAdContent {
            padding: 20px;
        }
        #customAdCloseBtn {
            top: 10px;
        }
    }
</style>
