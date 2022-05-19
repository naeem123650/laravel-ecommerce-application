<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Attributes\Attribute;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Product\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function loadAttributes()
    {
        $attributes = Attribute::all();

        return response()->json($attributes);
    }

    public function productAttributes(Request $request)
    {
        $product = Product::findOrFail($request->id);

        return response()->json($product->attributes);
    }

    public function loadValues(Request $request)
    {
        $attribute = Attribute::findOrFail($request->id);

        return response()->json($attribute->values);
    }

    public function addAttribute(Request $request)
    {
        $productAttr = ProductAttribute::create($request->data);

        if(!$productAttr){
            return response()->json(["message" => "There is some error while creating product attribute.","type"=>"error"]);
        }

        return response()->json(["message" => "Product attribute added successfully.","type"=>"success"]);
    }

    public function deleteAttribute(Request $request)
    {
        $productAttr = ProductAttribute::find($request->product_attr_id)->delete();

        if(!$productAttr){
            return response()->json(["message" => "There is some error while deleting product attribute.","type"=>"error"]);
        }

        return response()->json(["message" => "Product attribute deleted successfully.","type"=>"success"]);
    }
}
