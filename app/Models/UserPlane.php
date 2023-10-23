<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPlane extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function plane()
    {
        return $this->belongsTo(Plane::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function sub_invoice()
    {
        return $this->morphMany(SubInvoice::class, 'sub_invoiceable');
    }

}
