<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_role_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('项目id');
            $table->integer('role_id')->comment('角色id');
            $table->integer('permission_id')->comment('权限id');
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
        Schema::dropIfExists('project_role_permission');
    }
}
