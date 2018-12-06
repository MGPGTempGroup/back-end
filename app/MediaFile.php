<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    protected $fillable = ['key', 'path', 'mime_type', 'suffix', 'url'];

    public function scopeImages($query, $key)
    {
        $query->where('media_file_type', 0)->where('key', $key);
    }

}
