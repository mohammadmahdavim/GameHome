<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workshop extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(WorkshopType::class, 'workshop_type_id')->withDefault();
    }

    public function staff()
    {
        return $this->hasMany(WorkshopStaff::class);
    }
}
