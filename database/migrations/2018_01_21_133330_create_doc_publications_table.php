<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_publications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id');
            $table->string('title');
            $table->string('journal_name');
            $table->integer('month_year');
            $table->text('link');
            $table->string('citation_doc');
            $table->text('description');
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
        Schema::dropIfExists('doc_publications');
    }
}
