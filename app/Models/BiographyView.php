<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiographyView extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'biografi_id',
        'ip_address',
        'user_agent',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Get the biography that was viewed.
     */
    public function biografi()
    {
        return $this->belongsTo(Biografi::class);
    }
}
