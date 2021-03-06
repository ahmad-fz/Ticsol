<?php

namespace App\Ticsol\Base\Repository\Contract;

/**
 * Base contract for repository.
 */
interface IRepository{
    public function all($with = [], $columns = array('*'));
    public function find($id, $with = [], $columns = array('*'));
    public function findBy($field, $value, $columns = array('*'));
    public function paginate($perPage = 15, $with=[], $columns = array('*'));
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($field, $value, $softDelete = true);
    public function restore($field, $value);
}