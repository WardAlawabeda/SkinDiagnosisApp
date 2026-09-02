<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MlApiService
{
    protected $baseUrl;
    protected $predictEndpoint;

    public function __construct()
    {
        $this->baseUrl = config('services.ml_api.base_url');
        $this->predictEndpoint = config('services.ml_api.predict_endpoint');
    }

    public function predict(string $imageFullPath)
    {
        // نرسل الصورة لمودل Python كـ multipart/form-data
        $response = Http::attach(
            'image',
            file_get_contents($imageFullPath),
            basename($imageFullPath)
        )->post($this->baseUrl . $this->predictEndpoint);

        if ($response->failed()) {
            throw new \Exception('ML API request failed: ' . $response->body());
        }

        return $response->json();
    }
}
