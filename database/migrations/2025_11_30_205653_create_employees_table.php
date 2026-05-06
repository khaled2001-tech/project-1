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
        Schema::create('employees', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('birthdate')->nullable();
    $table->string('job')->nullable();
    $table->boolean('gender')->default(true);
    $table->decimal('salary', 8, 2)->default(0);
    $table->float('commission', 5, 2)->nullable();
    $table->string('photo')->nullable();
    $table->string('phone')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
