<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('项目id');
            $table->integer('parent_id')->nullable()->comment('父节点id，null为根节点');
            $table->string('name', 100)->comment('节点标题');
            $table->integer('height')->comment('节点高度，1为根节点');
            $table->integer('status')->comment('结点状态，0禁用，1未完成，2待验收，3已完成');
            $table->string('description', 100)->default('')->comment('节点描述');
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
        Schema::dropIfExists('nodes');
    }
}
