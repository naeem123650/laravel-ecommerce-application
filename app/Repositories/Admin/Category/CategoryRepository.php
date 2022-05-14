<?php

namespace App\Repositories\Admin\Category;

use App\Contracts\Admin\Category\CategoryContract;
use App\Models\Admin\Category\Category;
use App\Repositories\Core\BaseRepository;
use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class CategoryRepository extends BaseRepository implements CategoryContract
{
    use Uploadable;

    protected $model;

    // 'listCategories', 'findCategoryById', 'createCategory', 'updateCategory', 'deleteCategory'
    public function __construct(Category $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listCategories($columns = array('*'),string $orderBy = 'id',string $sortBy= 'desc')
    {
        return $this->all($columns,$orderBy,$sortBy);
    }

    public function findCategoryById(int $id)
    {
        try {

            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException($ex->getMessage());
        }
    }

    public function createCategory(array $params)
    {
        try {
            $image = null;

            $collection = collect($params);

            if ($collection->has('image') && ($params['image'] instanceof UploadedFile)) {
                $image = $this->uploadOne($params['image'],'categories');
            }

            $featured = $collection->has('featured') ? 1 : 0;

            $menu = $collection->has('menu') ? 1 : 0 ;

            $status = $collection->has('status') ? 1 : 0;

            $merge = $collection->merge(compact('image','featured','menu','status'));

            $category = new Category($merge->all());

            $category->save();

            return $category;

        } catch (QueryException $ex) {
            throw new InvalidArgumentException($ex->getMessage());
        }
    }

    public function updateCategory(array $params)
    {
        try {
            $category = $this->findCategoryById($params['id']);

            $image = $category->image;

            $collection = collect($params);

            if($collection->has('image') && ($params['image'] instanceof UploadedFile)){
                if($category->image != null){
                    $this->deleteOne($category->image);
                }

                $image =  $this->uploadOne($params['image'],'categories');
            }

            $featured = $collection->has('featured') ? 1 : 0;

            $menu = $collection->has('menu') ? 1 : 0;

            $status = $collection->has('status') ? 1 : 0;

            $merge = $collection->merge(compact('image','featured','menu','status'));

            $category->update($merge->all());

            return $category;

        } catch (QueryException $ex) {
            throw new InvalidArgumentException($ex->getMessage());
        }
    }

    public function deleteCategory(int $id)
    {
        try {

            $category = $this->findCategoryById($id);

            if($category->image != null){
                $this->deleteOne($category->image);
            }

            $category->delete();

            return $category;

        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException($ex->getMessage());
        }
    }

}
