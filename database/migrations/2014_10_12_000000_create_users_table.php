<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('code');
            $table->string('name');
            $table->string('family');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_mobile')->nullable();
            $table->string('mother_mobile')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('description')->nullable();
            $table->string('duration')->default(0);
            $table->boolean('active')->default(1);
            $table->bigInteger('purchase')->default(0);
            $table->bigInteger('used')->default(0);
            $table->bigInteger('remaining')->default(0);
            $table->unsignedBigInteger('mahd_class_id')->nullable();
            $table->foreign('mahd_class_id')->on('mahd_classes')->references('id')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
