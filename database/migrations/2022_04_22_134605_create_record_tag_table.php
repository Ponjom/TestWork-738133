<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordTagTable extends Migration
{
    public function up()
    {
        Schema::create('record_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('record_id');
            $table->unsignedBigInteger('tag_id');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('record_id')->references('id')->on('records');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    public function down()
    {
        Schema::dropIfExists('record_tag');
    }
}
