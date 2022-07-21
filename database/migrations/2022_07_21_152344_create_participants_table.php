<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('restaurant_number', 100);
            $table->string('leader_name', 200)->nullable();
            $table->string('members_number', 50)->nullable();
            $table->string('custom_id');
            $table->string('status')->default('pending');
            $table->string('location', 200);
            $table->string('file_name', 200);
            $table->boolean('accepted_tos')->default(true);
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
        Schema::dropIfExists('participants');
    }
};
