<?php

namespace App\Repositories\Admin\Product;

use App\Contracts\Admin\Product\ProductContract;
use App\Models\Admin\Product\Product;
use App\Repositories\Core\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class ProductRepository extends BaseRepository implements ProductContract
{
    protected $model;

    public function __construct(Product $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listProducts($columns = array('*'),string $orderBy = "id",$sortBy = "desc")
    {
        return $this->all($columns,$orderBy,$sortBy);
    }

    public function findProductById(int $id)
    {
        try {

            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException($ex->getMessage());
        }
    }

    public function createProduct(array $params)
    {
        try {
            $collection = collect($params);

            $status = $collection->has("status") ? 1 : 0;

            $featured = $collection->has("featured") ? 1 : 0;

            $merge = $collection->merge(compact("status","featured"));

            $product = $this->model->create($merge->all());

            $product->save();

            if($collection->has("categories")){
                $product->categories()->sync($params['categories']);
            }

            return $product;

        } catch (QueryException $ex) {
            throw new InvalidArgumentException($ex->getMessage());

        }
    }

    public function updateProduct(array $params)
    {
        try {
            $product = $this->findProductById($params['product_id']);

            $collection = collect($params);

            $status = $collection->has('status') ? 1 : 0;

            $featured = $collection->has('featured') ? 1 : 0;

            $merge = $collection->merge(compact("status","featured"));


            $product->update($merge->all());

            if($collection->has("categories")){
                $product->categories()->sync($params['categories']);
            }

            return $product;

        } catch (QueryException $ex) {
            throw new InvalidArgumentException($ex->getMessage());

        }
    }

    // public function deleteProduct(int $id)
    // {
    //     $product = $this->findProductById($id);

    //     $product->delete();

    //     return $product;
    // }
}
