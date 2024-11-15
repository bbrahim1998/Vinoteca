<?php

namespace App\Models;

use App\Services\UploadService;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;
use Brick\Math\Exception\NumberFormatException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use NumberFormatter;

class Wine extends Model
{
    //
    use HasSlug;

    protected $filable =[
        "category_id",
        "name",
        "slug",
        "description",
        "year",
        "price",
        "stock",
        "image",
    ];

    protected function casts() : array
    {
        return [
            "year" =>"integer",
            "price" =>"decimal:2",
            "stock"=> "integer",
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => UploadService::url($this->image),
        );
    }

    public function formattedPrice(): Attribute
    {
        $formatter = new NumberFormatter("es_ES", NumberFormatter::CURRENCY);
        return Attribute::make(
            get: fn () => $formatter ->formatCurrency($this->price,"EUR"),
        ) ;

    }
}
