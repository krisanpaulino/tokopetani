<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $table = 'province';
    protected $primaryKey = 'province_id';
    public $incrementing = true;
    public $timestamps = false;
    public $guarded = ['province_id'];

    function city(): HasMany
    {
        return $this->hasMany(City::class, 'province_id', 'province_id');
    }
}
