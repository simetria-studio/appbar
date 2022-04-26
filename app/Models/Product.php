<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;

use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected $fillable = [
        'name',
        'resume',
        'provider',
        'provphone',
        'provname',
        'buyprice',
        'sellprice',
        'bitterness',
        'temperature',
        'ibv',
        'type',
        'image',
        'categoria',
        'description',
        'spotlight',
        'delivery',
        'location',
        'stock',
        'status',
    ];

    public function stock()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }
}
