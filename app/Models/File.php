<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Get all of the owning commentable models.
     */
    public function fileable()
    {
        return $this->morphTo();
    }
}
