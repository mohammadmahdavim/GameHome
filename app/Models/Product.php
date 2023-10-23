<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function sub_invoice()
    {
        return $this->morphMany(SubInvoice::class, 'sub_invoiceable');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class)->orderBy('date');
    }


}
