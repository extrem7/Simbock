<?php

namespace App\Models\Map\US;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public $incrementing = false;
    protected $table = 'us_states';
    protected $keyType = 'string';

    protected $fillable = ['id', 'name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
