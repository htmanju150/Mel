<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocAccreditations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_accreditations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id');
            $table->string('accr_type');
            $table->string('accr_number');
            $table->string('accr_file');
            $table->string('accr_valid_upto');
            $table->string('accr_country');
            $table->string('accr_state');
            $table->boolean('is_verified');
            $table->integer('verified_by');
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
        Schema::dropIfExists('doc_accreditations');
    }
}
