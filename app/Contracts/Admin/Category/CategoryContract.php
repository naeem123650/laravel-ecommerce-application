<?php

namespace App\Contracts\Admin\Category;

interface CategoryContract
{
    public function listCategories($columns = array('*'),string $orderBy = 'id',string $sortBy= 'desc');

    public function findCategoryById(int $id);

    public function createCategory(array $params);

    public function updateCategory(array $params);

    public function deleteCategory(int $id);

}
