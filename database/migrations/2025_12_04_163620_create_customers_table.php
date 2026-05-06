<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
             $table->string('email')->unique();
             $table->string('phone', 20)->nullable();
            $table->string('password');
            $table->string('birthdate')->nullable();
            $table->char('gender',1)->default('m');
            $table->string('photo')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('fav_client')->default(false);
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('users')->nullOnDelete()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
