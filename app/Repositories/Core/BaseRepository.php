<?php

namespace App\Repositories\Core;

use App\Contracts\Core\BaseContract;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes,int $id)
    {
        return $this->model->find($id)->update($attributes);
    }

    public function all($columns = array('*'),$orderBy = 'id',$sortBy = 'desc')
    {
        return $this->model->orderBy($orderBy,$orderBy)->get($columns);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findOneOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBy(array $data)
    {
        return $this->model->where($data)->all();
    }

    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    public function findOneByOrFail(array $data)
    {
       return $this->model->where($data)->findOrFail();
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }

    public function deleteMany(array $ids)
    {
        $deleteIds =  implode(",",$ids);

        return $this->model->whereIn('id',[$deleteIds])->delete();
    }
}