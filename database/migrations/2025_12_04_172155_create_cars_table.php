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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img')->nullable();
            $table->Integer('count')->unsigned()->nullable();
            $table->string('Vin-number')->nullable();
            $table->enum('body_type', ['RENT', 'BUY']);
            $table->string('color')->nullable();
            $table->decimal('price')->unsigned();
            $table->integer('engine_capacity')->nullable();
            $table->year('menufacturing_year')->nullable();
            $table->string('transmission_type')->nullable();
            $table->Integer('number_doors')->unsigned()->default(4);
            //$table->enum('fuel_type', ['petrol', 'diesel', 'electric']);
            $table->float('discount',5,2)->default(0.00);
            $table->boolean('status')->default(true);
            $table->foreignid('brand_id')->nullable()->constrained('brands')->nullOnDelete()->cascadeOnDelete();
            $table->foreignid('model_id')->nullable()->constrained('models')->nullOnDelete()->cascadeOnDelete();
            $table->foreignid('created_by')->nullable()->constrained('users')->nullOnDelete()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
