<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->comment('上级栏目id')->default(0);
            $table->integer('order')->comment('排序')->default(0);
            $table->string('title')->comment('疾病名称');
            $table->text('items')->comment('治疗项目')->nullable();
            $table->string('intro')->comment('疾病简介')->nullable();
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
        Schema::dropIfExists('diseases');
    }
}
