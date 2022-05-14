<?php

namespace App\Contracts\Admin\Attribute;

interface AttributeContract
{
    public function listAttributes($columns = array('*'),string $orderBy = "id",string $sortBy = "desc");

    public function findAttributeById(int $id);

    public function createAttribute(array $params);

    public function updateAttribute(array $params);

    public function deleteAttribute(int $id);
}
