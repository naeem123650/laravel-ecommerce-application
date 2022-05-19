<?php

namespace App\Models\Admin\Product;

use App\Models\Admin\Brand\Brand;
use App\Models\Admin\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $primaryKey = "id";

    protected $fillable = [
        "brand_id","sku","name","slug","desc","quantity",
        "weight","price","sale_price","status","featured",
    ];

    protected $casts = [
        "status" => "boolean",
        "featured" => "boolean",
        "brand_id" => "integer",
        "quantity" => "integer",
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,"brand_id");
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,"product_categories","product_id","category_id");
    }
}
