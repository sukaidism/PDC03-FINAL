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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landlord_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('property_type_id')->constrained('property_types')->onDelete('restrict');
            $table->foreignId('city_id')->constrained('cities')->onDelete('restrict');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->text('address');
            $table->string('coordinates', 100)->nullable();
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('size_sqm', 8, 2);
            $table->json('amenities')->nullable();
            $table->enum('status', ['available', 'occupied', 'pending', 'maintenance'])->default('available');
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            $table->date('available_from')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('landlord_id');
            $table->index('property_type_id');
            $table->index('city_id');
            $table->index('status');
            $table->index('is_featured');
            $table->index('price');
            $table->index('created_at');
            $table->index(['status', 'city_id', 'price'], 'idx_properties_composite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
