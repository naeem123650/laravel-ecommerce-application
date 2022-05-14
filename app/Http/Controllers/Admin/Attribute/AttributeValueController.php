<?php

namespace App\Http\Controllers\Admin\Attribute;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\BaseController;
use App\Models\Admin\Attributes\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends BaseController
{
    public function store(Request $request,$attribute_id)
    {
        $attribute = AttributeValue::create([
            "attribute_id" => $attribute_id,
            "value" => $request->value,
            "price" => $request->price
        ]);


        if(!$attribute){
            return $this->responseRedirectBack("There is some Error while Adding attribute value.","error");
        }

        return $this->responseRedirectBack("Attribute value added successfully.","success");
    }

    public function edit($id)
    {
        $attribute = AttributeValue::find($id);

        return response()->json($attribute);
    }

    public function update(Request $request,$attribute_id)
    {
        $attribute = AttributeValue::find($attribute_id);

        $attribute->update([
            "value" => $request->value,
            "price" => $request->price
        ]);


        if(!$attribute){
            return $this->responseRedirectBack("There is some Error while Adding attribute value.","error");
        }

        return $this->responseRedirectBack("Attribute value updated successfully.","success");
    }

    public function delete($id)
    {
        $attribute = AttributeValue::find($id)->delete();

        if(!$attribute){
            return $this->responseRedirectBack("There is some Error while Deleting attribute value.","error");
        }

        return $this->responseRedirectBack("Attribute value deleted successfully.","success");
    }
}
