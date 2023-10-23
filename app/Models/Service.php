<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];

    public function sub_invoice()
    {
        return $this->morphMany(File::class, 'sub_invoice_able');
    }
}
