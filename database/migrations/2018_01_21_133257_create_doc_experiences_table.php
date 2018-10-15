<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id');
            $table->string('hospital_name');
            $table->string('designation');
            $table->string('city');
            $table->integer('from_month');
            $table->integer('from_year');
            $table->integer('to_month');
            $table->integer('to_year');
            $table->integer('duration')->nullable();        // In months
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
        Schema::dropIfExists('doc_experiences');
    }
}
