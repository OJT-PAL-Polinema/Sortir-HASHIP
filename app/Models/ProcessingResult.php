<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessingResult extends Model
{
    // app/Models/ProcessingResult.php
protected $fillable = [
    'processing_type',
    'original_filename',
    'row_number',
    'data',
    'status',
    'message',
];

protected $casts = [
    'data' => 'array', // Automatically cast the JSON data to an array
];
}
