<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('problem_categories_id');
            $table->integer('users_id');
            $table->string('problems_title');
            $table->string('problems_address');
            $table->string('problems_short_desc');
            $table->text('problems_long_desc');
            $table->double('problems_lat');
            $table->double('problems_lng');
            $table->string('problems_image');
            $table->string('problems_video');
            $table->string('problems_iconImageHref');
            $table->integer('problems_active')->default(0);
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
        Schema::dropIfExists('problems');
    }
}
