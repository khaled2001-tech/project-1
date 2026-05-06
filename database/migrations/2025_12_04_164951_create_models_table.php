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
        Schema::create('models', function (Blueprint $table) {
              $table->id();
              $table->string('name');
              $table->string('description')->nullable();
              $table->boolean('status')->default(true);
              $table->foreignid('brand_id')->nullable()->constrained('brands')->nullOnDelete()->cascadeOnDelete();
            
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
