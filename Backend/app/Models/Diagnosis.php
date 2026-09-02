<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = [
        'image_id',
        'disease_name',
        'confidence',
        'raw_response',
    ];

    protected $casts = [
        'raw_response' => 'array',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}