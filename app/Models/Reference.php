<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'biografi_id',
        'title',
        'author',
        'year',
        'url',
        'type',
    ];

    /**
     * Get the biography that owns the reference.
     */
    public function biografi()
    {
        return $this->belongsTo(Biografi::class);
    }
}
