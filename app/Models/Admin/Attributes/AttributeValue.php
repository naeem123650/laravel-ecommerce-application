<?php

namespace App\Models\Admin\Attributes;

use App\Models\Admin\Product\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $table = "attribute_values";

    protected $fillable = [
        "attribute_id","value","price"
    ];

    protected $casts = [
        "attribute_id" => "integer"
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class,"id");
    }

    public function productAttributes()
    {
        return $this->belongsToMany(ProductAttribute::class);
    }
}
