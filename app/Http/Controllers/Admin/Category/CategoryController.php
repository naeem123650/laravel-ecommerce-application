<?php

namespace App\Http\Controllers\Admin\Category;

use App\Contracts\Admin\Category\CategoryContract;
use App\Http\Controllers\Core\BaseController;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    protected $categoryRepository;

    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->listCategories();

        $this->setPageTitle("Category Details","Details of all Categories");

        return view('admin.category.index',compact('categories'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->listCategories(["id","name"],"id","asc");

        $this->setPageTitle("Create Category","Create a new category.");

        return view('admin.category.create',compact('categories'));
    }

    public function store(CreateCategoryRequest $request)
    {
        $category = $this->categoryRepository->createCategory($request->except("_token"));

        if(!$category){
            return $this->responseRedirectBack("Something went wrong while saving data.","error");
        }

        return $this->responseRedirect("admin.categories.index","success","Category added successfully.",false,false);
    }

    public function edit($id)
    {
        $targetCategory = $this->categoryRepository->findCategoryById($id);

        $categories = $this->categoryRepository->listCategories(["id","name"],"id","asc");

        $this->setPageTitle("Edit Category","Edit Category: ".$targetCategory->name);

        return view('admin.category.edit',compact('targetCategory','categories'));
    }

    public function update(UpdateCategoryRequest $request)
    {
        $categoryUpdate = $this->categoryRepository->updateCategory($request->except('_token'));

        if(!$categoryUpdate){
            return $this->responseRedirectBack("Something went wrong while updating data.","error");
        }
        return $this->responseRedirect("admin.categories.index","success","Category updated successfully.");
    }

    public function delete($id)
    {
        $category = $this->categoryRepository->deleteCategory($id);

        if (!$category) {
            return $this->responseRedirectBack("Something went wrong while deleting record.","error");
        }

        return $this->responseRedirect("admin.categories.index","success","Category deleted successfully.");
    }

    public function updateStatus(Request $request)
    {
        $category = $this->categoryRepository->findCategoryById($request->categoryId);

        $category->status = $request->status;

        if($category->save()){
            return response()->json(['message' => "Category status updated successfully."]);
        }

    }
}
