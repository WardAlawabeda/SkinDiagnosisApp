<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Diagnosis;
use App\Services\MlApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiagnosisController extends Controller
{
    protected $mlApi;

    public function __construct(MlApiService $mlApi)
    {
        $this->mlApi = $mlApi;
    }

    public function diagnose(Request $request, Image $image)
    {
        // نجيب المسار الكامل للصورة من الـstorage
        $imagePath = Storage::disk('public')->path($image->path);

        // نرسل الصورة لمودل Python
        $mlResponse = $this->mlApi->predict($imagePath);

        // نفترض إنو الرد هيك:
        // {
        //   "disease_name": "psoriasis",
        //   "confidence": 0.92
        // }

        $diagnosis = Diagnosis::create([
            'image_id' => $image->id,
            'disease_name' => $mlResponse['disease_name'] ?? 'unknown',
            'confidence' => $mlResponse['confidence'] ?? null,
            'raw_response' => $mlResponse,
        ]);

        return response()->json([
            'message' => 'Diagnosis completed',
            'data' => $diagnosis,
        ]);
    }
}
