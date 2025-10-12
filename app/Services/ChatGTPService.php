<?php

namespace App\Services;

class ChatGTPService
{


    private $apiKey ='';

    private $model = 'gpt-4o';
    private $maxWords = 150;
    private $creativity = 0.75;

    public function __construct()
    {
        $this->apiKey = isenablemodule('ChatGPT_key');
    }

    private function generateMessage($name, $description = '', $type = null)
    {
        $maxWords = $type ? 50 : $this->maxWords;
        $userMessage = $description
            ? "Generate description for $name and $description. Maximum $maxWords words."
            : "Generate description for $name. Maximum $maxWords words. Creativity is $this->creativity between 0 and 1. Language is English US.";

        return [
            [
                "role" => "system",
                "content" => "You are a helpful assistant."
            ],
            [
                "role" => "user",
                "content" => $userMessage
            ]
        ];
    }

    private function generateBioMessage($prompt)
    {
        $userMessage = "$prompt. Maximum $this->maxWords words. Creativity is $this->creativity between 0 and 1. Language is English US.";

        return [
            [
                "role" => "system",
                "content" => "You are a helpful assistant."
            ],
            [
                "role" => "user",
                "content" => $userMessage
            ]
        ];
    }

    private function callAPI($messages)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "model" => $this->model,
                "messages" => $messages,
                "stream" => false
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function GenerateDescription($name, $description, $type = null)
    {
        $messages = $this->generateMessage($name, $description, $type);
        return $this->callAPI($messages);
    }

    public function GenerateBio($prompt)
    {
        $messages = $this->generateBioMessage($prompt);
        return $this->callAPI($messages);
    }
}
