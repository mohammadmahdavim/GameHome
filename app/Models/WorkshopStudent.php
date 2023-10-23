<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkshopStudent extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class)->withDefault();
    }

    public function sub_invoice()
    {
        return $this->morphMany(SubInvoice::class, 'sub_invoiceable');
    }
}
