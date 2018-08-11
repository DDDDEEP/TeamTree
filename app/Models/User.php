<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Project;
use App\Models\Node;
use App\Models\Identity;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * 获取该用户对应项目。
     */
    public function projects()
    {
        return $this->belongsToMany(Project::Class)
            ->withTimestamps();
    }

    /**
     * 获取该用户对应的节点。
     */
    public function nodes()
    {
        return $this->belongsToMany(Node::Class, 'identity', 'user_id', 'node_id')
            ->withTimestamps()
            ->using(Identity::Class);
    }
}
