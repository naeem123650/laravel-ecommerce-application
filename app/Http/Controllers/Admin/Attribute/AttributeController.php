<?php

namespace App\Http\Controllers\Admin\Attribute;

use App\Contracts\Admin\Attribute\AttributeContract;
use App\Http\Controllers\Core\BaseController;
use App\Http\Requests\admin\Attributes\CreateAttributeRequest;
use App\Http\Requests\admin\Attributes\UpdateAttributeRequest;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    protected $attributeRepository;

    public function __construct(AttributeContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function index()
    {
        $attributes = $this->attributeRepository->listAttributes(['*'],"id","asc");

        $this->setPageTitle("Attributes","Attribute Details");

        return view("admin.attributes.index",compact("attributes"));
    }

    public function create()
    {
        $this->setPageTitle("Attributes","Add Attributes Details.");

        return view("admin.attributes.create");
    }

    public function store(CreateAttributeRequest $request)
    {
        $attribute = $this->attributeRepository->createAttribute($request->except('_token'));

        if(!$attribute) {
            return $this->responseRedirectBack("Something went wrong while saving Attribute.","error");
        }

        return $this->responseRedirect("admin.attributes.index","success","Attribute added successfully.");
    }
    public function edit($id)
    {
        $targetAttribute = $this->attributeRepository->findAttributeById($id);

        $attributeValues = $targetAttribute->values;

        $this->setPageTitle("Attribute","Edit Attribute : ".$targetAttribute->name);

        return view("admin.attributes.edit",compact('targetAttribute','attributeValues'));
    }
    public function update(UpdateAttributeRequest $request)
    {
        $attribute = $this->attributeRepository->updateAttribute($request->all());

        if(!$attribute) {
            return $this->responseRedirectBack("Something went wrong while updating Attribute.","error");
        }

        return $this->responseRedirectBack("Attribute updated successfully.","success");
    }
    public function delete($id)
    {
        $attribute = $this->attributeRepository->deleteAttribute($id);

        if(!$attribute) {
            return $this->responseRedirectBack("Something went wrong while deleting Attribute.","error");
        }

        return $this->responseRedirect("admin.attributes.index","success","Attribute deleted successfully.");
    }
}
