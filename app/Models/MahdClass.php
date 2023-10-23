<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahdClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function plane()
    {
        return $this->belongsTo(Plane::class)->withDefault();
    }
}
