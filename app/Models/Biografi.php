<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biografi extends Model
{
    protected $table = 'biografis';
    protected $fillable = [
        'name',
        'slug',
        'birth_place',
        'birth_date',
        'death_date',
        'achievements',
        'life_story',
        'category_id',
        'user_id',
        'status',
        'image_path'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Helper methods
    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function publish()
    {
        $this->status = 'published';
        $this->save();
    }

    public function unpublish()
    {
        $this->status = 'draft';
        $this->save();
    }
}
