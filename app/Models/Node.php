<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Project;

class Node extends Model
{
    /**
     * 获取该节点的父节点，若是根节点则返回null
     */
    public function parent()
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * 获取该节点对应项目。
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
