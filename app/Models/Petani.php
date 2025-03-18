<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Petani extends Model
{
    protected $table = 'petani';
    protected $primaryKey = 'petani_id';
    public $incrementing = true;
    public $timestamps = false;
    public $guarded = ['petani_id'];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id')->withDefault([
            'username' => 'no data'
        ]);
    }
}
