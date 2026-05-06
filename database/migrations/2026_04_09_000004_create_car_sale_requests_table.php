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
        Schema::create('car_sale_requests', function (Blueprint $table) {
                   $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete(); // ✅ Fixed: references 'users' not 'customers'
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->string('color')->nullable();
            $table->integer('engine_capacity')->nullable();
            $table->unsignedInteger('number_doors')->default(4);            // ✅ Fixed: consistent unsigned
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('mileage')->default(0);
            $table->enum('transmission', ['manual', 'automatic']);
            $table->enum('fuel_type', ['petrol', 'diesel', 'electric', 'hybrid']); // ✅ Added hybrid
            $table->enum('condition', ['new', 'used']);
            $table->text('description');
            $table->json('images')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'needs_modification'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_sale_requests');
    }
};
