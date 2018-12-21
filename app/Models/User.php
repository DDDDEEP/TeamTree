<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'sex', 'description', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

    /**
     * 获取该用户对应项目。
     */
    public function projects()
    {
        return $this->belongsToMany(Project::Class)
            ->withPivot(['id', 'role_id', 'status'])
            ->withTimestamps()
            ->using(ProjectUser::Class);
    }

    /**
     * 获取该用户对应的节点（节点角色）。
     */
    public function nodes()
    {
        return $this->belongsToMany(Node::Class)
            ->withPivot(['id', 'role_id'])
            ->withTimestamps()
            ->using(NodeUser::Class);
    }

    /**
     * 获取该用户对应项目的项目角色
     *
     * @param  integer  $project_id  项目id
     * @return \App\Models\Role|null
     */
    public function getProjectRole($project_id)
    {
        $project = $this->projects()
            ->where('project_id', $project_id)
            ->first();
        return $project ? Role::find($project->pivot->role_id) : null;
    }

    /**
     * 获取该用户离对应节点最近（包括对应节点），根节点方向的节点
     *
     * @param  integer  $node_id  节点id
     * @return \App\Models\Node(with pivot)
     */
    public function getClosestNodeWithPivot($node_id)
    {
        $node = Node::find($node_id);

        $node_users = $this->nodes;

        while ($node) {
            if ($node_users->contains('id', $node->id)) {
                return $node_users->where('id', $node->id)->first();
            }
            $node = $node->parent;
        }

        return null;
    }

    /**
     * 获取该用户对应节点的节点角色
     *
     * @param  integer  $node_id  节点id
     * @return \App\Models\Role|null
     */
    public function getNodeRole($node_id)
    {
        /**
         * 具体步骤为：
         * 1、包括该节点，一直向父节点方向遍历
         *   直至找到第一个在 node_user 有对应记录的节点，该记录的角色作为该节点对应的角色
         * 2、若遍历到根节点仍未找到对应记录，则将项目角色作为该节点对应的角色
         */
        $node = Node::find($node_id);
        if (!$node) {
            return null;
        }

        // 判断边界条件：该用户没有对应的node->project_id
        $project_id = $node->project_id;
        if ($this->projects()
            ->where('project_id', $project_id)
            ->doesntExist()) {
            return null;
        }

        $node = $this->getClosestNodeWithPivot($node_id);
        $role = $node ?
            Role::find($node->pivot->role_id) : $this->getProjectRole($project_id);
        $role->node = $node ? $node : null;
        return $role;
    }

    /**
     * 判断该用户是否比另一个用户更高级
     *
     * @param  integer  $user_id  被比较的用户
     * @param  integer  $project_id
     * @param  integer  $node_id  可选，被比较的节点
     * @return boolean|null
     */
    public function isHigherThan($user_id, $project_id, $node_id = null)
    {
        /**
         * 判断依据：
         * 1、若不带node_id参数，则为项目角色的比较
         * 2、若带node_id参数，则为节点角色的比较
         */
        $this_role = $node_id != null ?
            $this->getNodeRole($project_id) :
            $this->getProjectRole($project_id);
        $another_role = $node_id != null ?
            User::findOrFail($user_id)->getNodeRole($node_id) :
            User::findOrFail($user_id)->getProjectRole($node_id);
        return $this_role->level > $another_role->level;
    }
}
