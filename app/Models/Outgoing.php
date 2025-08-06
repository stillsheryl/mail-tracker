<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Outgoing extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'name',
        'date',
        'country',
        'region',
        'city',
        'thanked',
        'has_been_sent',
        'occasion',
        'description',
        'link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
