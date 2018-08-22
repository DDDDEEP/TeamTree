<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Project;
use App\Models\User;
use App\Models\NodeUser;

class Node extends Model
{
    protected $relationships = [
        'belongsTo' => ['parent', 'project'],
        'hasMany' => ['children'],
        'belongsToMany' => ['users'],
    ];

    /**
     * 获取该节点的父节点，若是根节点则返回null
     */
    public function parent()
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * 获取该节点对应项目
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 获取该节点对应的角色（即节点角色）
     */
    public function users()
    {
        return $this->belongsToMany(User::Class)
            ->withPivot(['id', 'role_id'])
            ->withTimestamps()
            ->using(NodeUser::Class);
    }

    /**
     * 获取该节点对应的子节点
     */
    public function children()
    {
        return $this->hasMany(Node::class, 'parent_id', 'id');
    }

    /**
     * 判断该结点是否为根节点
     *
     * @return boolean
     */
    public function isRoot()
    {
        return $this->parent_id == null;
    }

    /**
     * 获取该节点对应所有后代，以height作为键分类
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDescendants()
    {
        $collection = $this->children()->get();
        foreach ($collection as $node) {
            $collection = $collection->merge($node->children()->get());
        }
        return $collection;
    }

    /**
     * 删除该节点与该节点所有后代，并清空对应的关系记录
     * 若为根节点，则只删除根节点的所有后代
     */
    public function deleteAll()
    {
        $delete_collection = $this->getDescendants();
        if (!$this->isRoot()) {
            $delete_collection->add($this);
        }
        foreach ($delete_collection as $delete_item) {
            $delete_item->users()->detach();
            $delete_item->delete();
        }
    }
}
