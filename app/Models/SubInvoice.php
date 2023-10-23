<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubInvoice extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function invoice()
    {
      return  $this->belongsTo(Invoice::class,'invoice_id')->withDefault();
    }

    public function user_plane()
    {
        return $this->belongsTo(UserPlane::class,'sub_invoiceable_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'sub_invoiceable_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'sub_invoiceable_id');
    }

    public function sub_invoiceable()
    {
        return $this->morphTo();
    }
}
