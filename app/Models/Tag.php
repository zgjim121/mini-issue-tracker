<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tag extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'color',
    ];

    public function issues(): BelongsToMany
    {
        return $this->belongsToMany(Issue::class);
    }
}
