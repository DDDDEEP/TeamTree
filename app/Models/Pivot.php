<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot as EloquentPivot;

class Pivot extends EloquentPivot
{
    protected $guarded = ['id'];

    public function getCreatedAtColumn()
    {
        return 'created_at';
    }

    public function getUpdatedAtColumn()
    {
        return 'updated_at';
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