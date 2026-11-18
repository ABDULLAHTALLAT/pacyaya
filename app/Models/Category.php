<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Category extends Model
{
    protected $guarded = [];

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function getLabelAttribute(): string
    {
        $key = 'catalog.categories.' . $this->slug;

        return Lang::has($key) ? __($key) : $this->name;
    }
}
