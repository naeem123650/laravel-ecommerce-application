<?php

namespace App\Contracts\Admin\Brand;

interface BrandContract
{
    public function listBrands($columns = array('*'),string $orderBy = "id",string $sortBy = "desc");

    public function findBrandById(int $id);

    public function createBrand(array $params);

    public function updateBrand(array $params);

    public function deleteBrand(int $id);
}
