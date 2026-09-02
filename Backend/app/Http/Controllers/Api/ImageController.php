<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB
            'source' => 'nullable|string|in:camera,gallery',
        ]);

        $file = $request->file('image');
        $path = $file->store('images', 'public');

        $image = Image::create([
            'user_id' => auth()->id, // إذا عندك auth، وإلا خليه null
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'source' => $request->input('source', 'gallery'),
        ]);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'data' => $image,
        ], 201);
    }
}