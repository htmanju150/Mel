<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id');
            $table->string('type');         // Life or Health
            $table->integer('policy_provider_id')->default(0);
            $table->string('policy_number')->nullable();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_till')->nullable();
            //$table->string('benefits')->nullable();
            $table->string('policy_document');
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
        Schema::dropIfExists('doc_insurances');
    }
}
