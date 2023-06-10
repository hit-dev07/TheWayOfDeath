<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_questionnaires', function (Blueprint $table) {
            $table->id();
            // $table->string('singleAnswer');
            // $table->String('multiAnswer');
            // $table->String('questionAnswer');
            // $table->String('statAnswer');
            // $table->String('scoringAnswer');
            // $table->unsignedBigInteger('answerId');
            // $table->foreign('answerId')->references('id')->on('answers')->onDelete('cascade');
            $table->longText('answerData');
            $table->tinyInteger('schoolId')->nullable();
            $table->tinyInteger('lessonId')->nullable();
            $table->unsignedBigInteger('postId');
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
        Schema::dropIfExists('answer_questionnaires');
    }
}
