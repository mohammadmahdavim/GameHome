<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author');
            $table->foreign('author')->on('users')->references('id')->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['hourly', 'monthly', 'mahd'])->default('hourly');
            $table->integer('hour')->nullable();
            $table->integer('month')->nullable();
            $table->string('price');
            $table->string('service')->nullable();
            $table->string('service_price')->nullable();
            $table->boolean('breakfast')->default(0);
            $table->boolean('lunch')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('planes');
    }
}
