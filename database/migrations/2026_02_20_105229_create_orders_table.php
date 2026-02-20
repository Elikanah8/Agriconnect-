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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Link to the product being bought
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // Link to the Buyer (User)
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            // Link to the Farmer (User)
            $table->foreignId('farmer_id')->constrained('users')->onDelete('cascade');
            
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // pending, accepted, completed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};