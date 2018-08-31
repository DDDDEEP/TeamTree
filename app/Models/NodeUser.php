<?php

namespace App\Models;

use App\Models\Common\Pivot;

class NodeUser extends Pivot
{
    /**
     * 获取该身份对应用户。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取该身份对应节点。
     */
    public function node()
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * 获取该身份对应角色。
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * 删除该结点所有后代存在的某用户的节点角色
     */
    public function deleteChildren($user_id)
    {
        $user = User::findOrFail($user_id);
        $ids = $user->nodes
            ->where('height', '>', $this->node->height)
            ->pluck('id')
            ->toArray();
        $user->nodes()->detach($ids);
    }

}
