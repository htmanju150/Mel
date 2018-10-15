<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id');
            $table->timestamp('start_leave')->useCurrent();
            $table->timestamp('end_leave')->useCurrent();
            $table->bigInteger('start_at')->useCurrent();
            $table->bigInteger('end_at')->useCurrent();
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
        Schema::dropIfExists('doc_leaves');
    }
}
