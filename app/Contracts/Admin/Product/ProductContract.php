<?php

namespace App\Contracts\Admin\Product;

interface ProductContract
{
    public function listProducts($columns = array('*'),string $orderBy = "id",$sortBy = "desc");

    public function findProductById(int $id);

    public function createProduct(array $params);

    public function updateProduct(array $params);

    // public function deleteProduct(int $id);
}
