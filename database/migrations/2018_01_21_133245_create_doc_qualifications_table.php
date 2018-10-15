<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id');
            $table->string('type');
            $table->string('reg_number');
            $table->boolean('is_verified');
            $table->integer('verified_by');
            $table->string('degree_certificate');
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
        Schema::dropIfExists('doc_qualifications');
    }
}
