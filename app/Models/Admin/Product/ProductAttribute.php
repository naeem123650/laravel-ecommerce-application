<?php

namespace App\Models\Admin\Product;

use App\Models\Admin\Attributes\Attribute;
use App\Models\Admin\Attributes\AttributeValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = "product_attributes";

    protected $fillable = [
        "attribute_id","value","quantity","price","product_id"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function attributeValues()
    // {
    //     return $this->belongsToMany(AttributeValue::class);
    // }

    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }
}
