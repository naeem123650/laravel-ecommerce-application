<?php

namespace App\Models\Admin\Attributes;

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
}
