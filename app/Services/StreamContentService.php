<?php
// app/Services/StreamContentService.php

namespace App\Services;

use Illuminate\Http\Request;

class StreamContentService
{
    public function handleQualityVideoUrlInput(Request $request, $model, $idField)
    {
  
        if ($request->has('enable_quality') && $request->enable_quality == 1) {

            $Quality_video_url = $request->quality_video_url_input;
            $videoQuality = $request->video_quality;
            $videoQualityType = $request->video_quality_type ?? null;

            if (!empty($videoQuality) && !empty($Quality_video_url)) {

                foreach ($videoQuality as $index => $videoquality) {

                    if ($videoquality != '' && $Quality_video_url[$index] != '') {

                        $url = $Quality_video_url[$index] ?? null;
                        $quality = $videoquality;
                        $type = $videoQualityType[$index] ?? null;

                        $data = [
                            $idField => $model->id,
                            'url' => $url,
                            'quality' => $quality,
                        ];

                        if (!is_null($videoQualityType)) {
                            $data['type'] = $type;
                        }

                        $model::create($data);
                    }
                }
            }
        }
    }
}
