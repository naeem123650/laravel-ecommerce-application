<?php

namespace App\Repositories\Admin\Brand;

use App\Contracts\Admin\Brand\BrandContract;
use App\Models\Admin\Brand\Brand;
use App\Repositories\Core\BaseRepository;
use App\Traits\Uploadable;
use Faker\Provider\ar_EG\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class BrandRepository extends BaseRepository implements BrandContract
{
    use Uploadable;

    protected $model;

    public function __construct(Brand $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listBrands($columns = array('*'),string $orderBy = "id",string $sortBy = "desc")
    {
        return $this->all($columns,$orderBy,$sortBy);
    }

    public function findBrandById(int $id)
    {
        try {

            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException($ex->getMessage());
        }
    }

    public function createBrand(array $params)
    {
        try {

            $logo = null;

            $collection = collect($params);

            if($collection->has('logo') && ($params['logo'] instanceof UploadedFile)){
                $logo = $this->uploadOne($params['logo'],"brand");
            }

            $status = $collection->has('status') ? 1 : 0;

            $merge = $collection->merge(compact('status','logo'));

            $brand = $this->model->create($merge->all());

            $brand->save();

            return $brand;

        } catch (QueryException $ex) {
            throw new InvalidArgumentException($ex->getMessage());
        }
    }

    public function updateBrand(array $params)
    {
        try {

            $brand = $this->findBrandById($params['id']);

            $logo = $brand->logo;

            $collection = collect($params);

            if($collection->has('logo') && ($params['logo'] instanceof UploadedFile)){
                if($params['logo'] != null){
                    $this->deleteOne($params['logo']);
                }

                $logo = $this->uploadOne($params['logo'],'brand');
            }

            $status = $collection->has('status') ? 1 : 0;

            $merge = $collection->merge(compact('logo','status'));

            $brand->update($merge->all());

            return $brand;

        } catch (QueryException $ex) {
            throw new InvalidArgumentException($ex->getMessage());
        }
    }

    public function deleteBrand(int $id)
    {
        $brand = $this->findBrandById($id);

        if($brand->logo != null){
            $this->deleteOne($brand->logo);
        }

        $brand->delete();

        return $brand;
    }
}
