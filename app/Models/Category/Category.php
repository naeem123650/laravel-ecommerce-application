<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    public $table = "categories";

    protected $fillable = [
        "name","slug","desc","parent_id","featured","menu","image","status"
    ];

    protected $casts =[
        "parent_id" => "integer",
        "featured" => "boolean",
        "menu" => "boolean",
        "status" => "boolean",
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name);
    }

    public function parent()
    {
        $this->belongsTo(Category::class,"parent_id");
    }

    public function children()
    {
        $this->hasMany(Category::class,"parent_id");
    }
}

