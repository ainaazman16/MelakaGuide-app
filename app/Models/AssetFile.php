<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetFile extends Model
{
    use HasFactory;
    protected $table = 'asset_files';

    protected $fillable = [
        'filename',
        'filepath',
        'filetype',
        'category',
        'reference_type',
        'reference_id',
    ];

    public function reference()
    {
        return $this->morphTo();
    }
}
