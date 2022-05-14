<?php

namespace App\Repositories\Admin\Attribute;

use App\Contracts\Admin\Attribute\AttributeContract;
use App\Models\Admin\Attributes\Attribute;
use App\Repositories\Core\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class AttributeRepository extends BaseRepository implements AttributeContract
{
    protected $model;

    public function __construct(Attribute $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function removeTokenAndMethod(array $data)
    {


        if($data['_token']){
            unset($data['_token']);
        }

        if($data['_method']){
            unset($data['_method']);
        }
    }

    public function listAttributes($columns = array('*'),string $orderBy = "id",string $sortBy = "desc")
    {
        return $this->all($columns,$orderBy,$sortBy);
    }

    public function findAttributeById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException($ex->getMessage());
        }
    }

    public function createAttribute(array $params)
    {
        try {

            $collection = collect($params);

            $is_filterable = $collection->has('is_filterable') ? 1 : 0;

            $is_required = $collection->has('is_required') ? 1 : 0;

            $merge = $collection->merge(compact("is_filterable","is_required"));

            $attribute = new Attribute($merge->all());

            $attribute->save();

            return $attribute;

        } catch (QueryException $ex) {
            throw new InvalidArgumentException($ex->getMessage());

        }
    }

    public function updateAttribute(array $params)
    {
        try {

            $attribute = $this->findAttributeById($params['id']);

            $collection = collect($params);

            $is_filterable = $collection->has("is_filterable") ? 1 : 0 ;

            $is_required = $collection->has('is_required') ? 1 : 0;

            $merge = $collection->merge(compact("is_filterable","is_required"));


            $attribute->update($merge->all());

            return $attribute;

        } catch (QueryException $ex) {
            throw new InvalidArgumentException($ex->getMessage());
        }
    }

    public function deleteAttribute(int $id)
    {
        try {

            $attribute = $this->findAttributeById($id);
            $attribute->delete();
            return $attribute;

        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException($ex->getMessage());

        }
    }
}
