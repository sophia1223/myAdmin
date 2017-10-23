<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('remark')->nullable()->comment('备注');
            $table->string('controller')->comment('控制器');
            $table->string('method')->comment('方法');
            $table->string('action_type_ids')->nullable()->comment('请求方法');
            $table->string('route')->comment('路由');
            $table->string('alias')->nullable()->comment('路由别名');
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
        Schema::dropIfExists('permissions');
    }
}
