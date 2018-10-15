<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('picture')->nullable();
            $table->integer('salutation');  // 0->Mr. 1->Ms. 2-> Dr. 3-> Prof.
            $table->boolean('is_deleted');
            $table->boolean('is_disabled');
            $table->boolean('is_active');
            $table->boolean('is_edited');
            $table->string('phone_token')->nullable();
            $table->string('email_token')->nullable();
            $table->rememberToken();
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
        Schema::drop('doctors');
    }
}
