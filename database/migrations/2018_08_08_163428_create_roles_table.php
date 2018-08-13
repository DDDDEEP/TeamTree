<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable()->comment('项目id，null为通用角色');
            $table->string('display_name', 100)->default('')->comment('角色显示名字');
            $table->string('description', 100)->default('')->comment('角色描述');
            $table->integer('level')
                ->comment('角色等级，对应的通用角色为：1闲置人员，2执行者，3节点管理员，4树管理员，5项目管理员，6超级管理员');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
