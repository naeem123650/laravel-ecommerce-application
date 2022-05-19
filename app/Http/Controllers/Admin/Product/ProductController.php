<?php

namespace App\Http\Controllers\Admin\Product;

use App\Contracts\Admin\Brand\BrandContract;
use App\Contracts\Admin\Category\CategoryContract;
use App\Contracts\Admin\Product\ProductContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\BaseController;
use App\Http\Requests\admin\Product\CreateProductRequest;
use App\Http\Requests\admin\Product\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    protected $productRepository;

    protected $brandRepository;

    protected $categoryRepository;

    public function __construct(BrandContract $brandRepository,CategoryContract $categoryRepository,ProductContract $productRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->listProducts();

        $this->setPageTitle("Products","Product Details.");

        return view("admin.products.index",compact("products"));
    }

    public function create()
    {
        $brands = $this->brandRepository->listBrands(["name","id"],"id","asc");
        $categories = $this->categoryRepository->listCategories(["name","id"],"id","asc");
        $this->setPageTitle("Product","Create Product.");
        return view("admin.products.create",compact("brands","categories"));
    }

    public function store(CreateProductRequest $request)
    {
        $product = $this->productRepository->createProduct($request->except("_token"));

        if(!$product){
            return $this->responseRedirectBack("There is some error while adding product.","error");
        }

        return $this->responseRedirect("admin.products.index","success","Product added successfully.");
    }

    public function edit($id)
    {
        $targetProduct = $this->productRepository->findProductById($id);

        $brands = $this->brandRepository->listBrands(["id","name"],"id","asc");

        $categories = $this->categoryRepository->listCategories(["id","name"],"id","asc");

        $this->setPageTitle("Products","Edit Product: ".$targetProduct->name);

        return view("admin.products.edit",compact("targetProduct","brands","categories"));
    }

    public function update(UpdateProductRequest $request)
    {
        $product = $this->productRepository->updateProduct($request->except("_token"));

        if(!$product){
            return $this->responseRedirectBack("There is some errors while updating product.","error");
        }

        return $this->responseRedirectBack("Product updated successfully.","success");

    }

    public function delete($id)
    {
        $product = $this->productRepository->deleteProduct($id);

        if(!$product){
            return $this->responseRedirectBack("There is some errors while deleting product.","error");
        }

        return $this->responseRedirectBack("Product deleted successfully.","success");

    }
}
