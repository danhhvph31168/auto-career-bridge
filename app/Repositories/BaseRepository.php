<?php

namespace App\Repositories;

use PhpParser\Node\Stmt\Return_;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    public function getAll(array $column = ['*'])
    {

        return $this->_model->all($column);
    }


    public function findById($id, array $column = ['*'])
    {
        $result = $this->_model->find($id, $column);

        return $result;
    }

    public function create(array $data)
    {

        return $this->_model->create($data);
    }

    public function update($id, array $data)
    {
        $result = $this->findById($id);

        if ($result) {
            $result->update($data);

            return $result;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        $result = $this->findById($id);
        if ($result) {
            $result->delete();
            return true;
        }

        return false;
    }

    public function countAll()
    {
        return $this->_model->count();
    }
}
