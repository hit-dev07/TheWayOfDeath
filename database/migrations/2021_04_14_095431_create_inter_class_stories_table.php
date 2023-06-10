<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterClassStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inter_class_stories', function (Blueprint $table) {
            $table->id();
            $table->LONGTEXT('content');
            $table->json('viewList')->nullable();
            $table->unsignedBigInteger('postId');
            $table->tinyInteger('schoolId');
            $table->tinyInteger('lessonId');
            $table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('inter_class_stories');
    }
}
