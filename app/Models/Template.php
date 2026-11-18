<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Template extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function getLabelAttribute(): string
    {
        $key = 'catalog.templates.' . $this->slug;

        return Lang::has($key) ? __($key) : $this->name;
    }
}
