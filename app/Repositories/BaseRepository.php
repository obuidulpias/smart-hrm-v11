<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    // model property on class instances
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function all()
    {
        return $this->model->all();
    }

}