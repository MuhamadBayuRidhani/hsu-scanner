<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanHistory extends Model
{
    // Mengizinkan penyimpanan data secara massal
    protected $fillable = ['url', 'score', 'header_results', 'file_results'];
    
    // Otomatis mengubah tipe data JSON di MySQL menjadi Array di PHP
    protected $casts = [
        'header_results' => 'array',
        'file_results' => 'array',
    ];
}