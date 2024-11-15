<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasSlug;

    //proteger app ante asignación masiva de laravel
    protected $filable = [
        "name",
        "slug",
        "description",
        "image",
    ];

    public function wines(): HasMany
    {
        return $this->hasMany(Wine::class);
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () =>UploadService::url($this->image),
        );
    }

}
