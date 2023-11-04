<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class MessageReseiver extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
