<?php

namespace App\Repositories;


use App\Core\App;

class AbstractRepository
{

    private $model = null;

    public function getRepository(string $entityClass)
    {

        if (!class_exists($entityClass)) {
            throw new \Exception('Class '.$entityClass.' does not exists.');
        }

        if (!defined("$entityClass::REPOSITORY")) {
            throw new \Exception('Class '.$entityClass.' does not contains constant REPOSITORY.');
        }

        $repositoryClass = $entityClass::REPOSITORY;
        if (!class_exists($repositoryClass)) {
            throw new \Exception('Class '.$repositoryClass.' does not exists.');
        }

        $repository = new $repositoryClass();

        return $repository;
    }


    public function getEntity(string $entityClass)
    {
        if (!class_exists($entityClass)) {
            throw new \Exception('Class '.$entityClass.' does not exists.');
        }

        if ($this->model === null)
        {
            $this->model = new $entityClass(App::getConnection());
            return $this->model;
        }

        return $this->model;
    }
}
