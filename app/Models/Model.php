<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $guarded = ['id'];

    /**
     * 关联对象名集合
     *
     * @var array
     */
    protected $relationships = [
        'belongsTo' => [],
        'hasMany' => [],
        'belongsToMany' => [],
    ];

    /**
     * 获取该模型的单关联对象名集合
     *
     * @return array
     */
    public function getRelationships()
    {
        return $this->relationships;
    }

    /**
     * 获取该模型的所有字段名
     *
     * @return array
     */
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}