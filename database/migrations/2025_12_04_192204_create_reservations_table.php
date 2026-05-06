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
        Schema::create('reservations', function (Blueprint $table) {
           $table->id();
        $table->dateTime('pickup_date');
        $table->dateTime('return_date')->nullable();
        $table->decimal('total_price', 10, 2)->nullable();
        $table->integer('rental_days')->nullable();
        $table->string('pickup_location')->nullable();
        $table->string('payment_method')->nullable();
        $table->text('notes')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'cancelled'])
         ->default('pending');
        $table->boolean('delivery_required')->default(false);
        $table->string('delivery_address')->nullable();
        $table->string('delivery_status')->nullable();
        $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
        $table->foreignId('model_id')->nullable()->constrained('models')->nullOnDelete();
        $table->foreignId('car_id')->nullable()->constrained('cars')->nullOnDelete();
        $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
        $table->foreignId('approved_id')->nullable()->constrained('employees')->nullOnDelete();
        // ← driver_id مش هنا، هي في deliveries table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
