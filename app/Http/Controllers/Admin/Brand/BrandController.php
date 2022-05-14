<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Contracts\Admin\Brand\BrandContract;
use App\Http\Controllers\Core\BaseController;
use App\Http\Requests\admin\Brand\CreateBrandRequest;
use App\Http\Requests\admin\Brand\UpdateBrandRequest;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    protected $brandRepository;

    public function __construct(BrandContract $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $brands = $this->brandRepository->listBrands(['*'],"id","asc");

        $this->setPageTitle("Brand","Brand Details");

        return view("admin.brands.index",compact("brands"));
    }

    public function create()
    {
        $this->setPageTitle("Brand","Add Brand Details");

        return view("admin.brands.create");
    }

    public function store(CreateBrandRequest $request)
    {
        $brand = $this->brandRepository->createBrand($request->except('_token'));

        if(!$brand) {
            return $this->responseRedirectBack("There is some error while adding brands.","error");
        }

        return $this->responseRedirect("admin.brands.index","success","Brand Added Successfully.");
    }

    public function edit($id)
    {
        $targetBrand = $this->brandRepository->findBrandById($id);

        $this->setPageTitle("Brands","Edit Brand : ".$targetBrand->name);

        return view("admin.brands.edit",compact("targetBrand"));
    }

    public function update(UpdateBrandRequest $request)
    {
        $brand = $this->brandRepository->updateBrand($request->except('_token'));

        if(!$brand) {
            return $this->responseRedirectBack("There is some error while updating brands.","error");
        }

        return $this->responseRedirectBack("Brand Updated Successfully.","success");
    }

    public function delete($id)
    {
        $brand = $this->brandRepository->deleteBrand($id);

        if(!$brand){
            return $this->responseRedirectBack("There is some error while deleting brand.","error");
        }

        return $this->responseRedirect("admin.brands.index","success","Brand Deleted Successfully.");
    }
}
