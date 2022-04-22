<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function records()
    {
        return $this->belongsToMany(Record::class)->withPivot('description');
    }

    public function getCreatedAtAttribute($data)
    {
        return Carbon::parse($data)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($data)
    {
        return Carbon::parse($data)->format('Y-m-d H:i:s');
    }
}
