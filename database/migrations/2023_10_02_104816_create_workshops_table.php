<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author');
            $table->foreign('author')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('workshop_type_id');
            $table->foreign('workshop_type_id')->on('workshop_types')->references('id')->onDelete('cascade');
            $table->string('name');
            $table->string('day_count')->default(1);
            $table->string('day')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('time')->nullable();
            $table->string('capacity')->default(1);
            $table->string('price')->default(0);
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
        Schema::dropIfExists('workshops');
    }
}
