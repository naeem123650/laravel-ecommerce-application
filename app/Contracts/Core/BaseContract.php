<?php

namespace App\Contracts\Core;



/**
 * Methods:
 *      - create(array $attributes)
 *      - update(array $attributes, int $id)
 *      - all($columns = array('*'),string $orderBy = 'id', string $sortBy = 'desc')
 *      - find(int $id)
 *      - findOneOrFail(int $id)
 *      - findBy(array $data)
 *      - findByOne(array $data)
 *      - findByOneOrFail(array $data)
 *      - delete(int $id)
 *      - deleteMany(array $ids)
 */


interface BaseContract
{
    /**
     * Create Resourse
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes);


    /**
     * Update Resource
     */

    public function update(array $attributes,int $id);

    /**
     * Display All Resources.
     */

    public function all($columns = array('*'),string $orderBy = 'id', string $sortBy = 'desc');

    /**
     * find single resourse.
     */

    public function find(int $id);

    /**
     * find a Resourse if resourse not found then through an Exception.
     */

    public function findOneOrFail(int $id);

    /**
     * find by array of data given
     */

    public function findBy(array $data);

    /**
     * find single resource by given data.
     */

    public function findOneBy(array $data);

    /**
     * find through array of data or throw an exception if not found.
     */

    public function findOneByOrFail(array $data);

    /**
     * delete resource
     */

    public function delete(int $id);


    /**
     * delete many records at once.
     *
     * @param array $ids
     * @return void
     */
    public function deleteMany(array $ids);

}
