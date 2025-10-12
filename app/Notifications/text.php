function setBaseUrlWithFileName($url = '')
{

    if (empty($url)) {
        return setDefaultImage();
    }

    if (filter_var($url, FILTER_VALIDATE_URL) && checkImageExists($url)) {
        return $url;
    }

    $fileName = basename(parse_url($url, PHP_URL_PATH));
    if (!$fileName) {
        return setDefaultImage();
    }

    $activeDisk = env('ACTIVE_STORAGE', 'local');

    switch ($activeDisk) {
        case 'local':
            $filePath = public_path("storage/streamit-laravel/$fileName");
            if (file_exists($filePath)) {
                return asset("storage/streamit-laravel/$fileName");
            }
            break;

        default:
            $baseUrl = env('DO_SPACES_URL');
            $filePath = "$baseUrl/streamit-laravel/$fileName";

            if (checkImageExists($filePath)) {
                return $filePath;
            }
            break;
    }

    // Return default image if file doesn't exist
    return setDefaultImage();
}
