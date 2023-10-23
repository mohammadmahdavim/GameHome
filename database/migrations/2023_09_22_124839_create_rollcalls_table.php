<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRollcallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rollcalls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author');
            $table->foreign('author')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('plane_id')->nullable();
            $table->foreign('plane_id')->on('planes')->references('id')->onDelete('cascade');
            $table->date('date');
            $table->string('enter');
            $table->integer('count')->default(1);
            $table->integer('duration')->default(0);
            $table->integer('sum')->default(0);
            $table->string('exit')->nullable();
            $table->enum('type', ['handy', 'system'])->default('system');
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
        Schema::dropIfExists('rollcalls');
    }
}
