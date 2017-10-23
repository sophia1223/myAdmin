<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('新闻标题');
            $table->string('image')->comment('新闻封面图');
            $table->text('content')->comment('新闻内容');
            $table->integer('news_type_id')->comment('新闻类型');
            $table->integer('hits')->default(0)->comment('点击量');
            $table->integer('admin_id')->comment('发布人');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态:0-未审核；1-通过；2-拒绝');
            $table->string('reply')->nullable()->comment('申请批复内容');
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
        Schema::dropIfExists('news');
    }
}
