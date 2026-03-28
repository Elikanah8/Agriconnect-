<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This part ADDS the column to your database.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 1. Create a column for the transporter's ID
            // 2. Make it 'nullable' because new orders don't have a driver yet
            // 3. Link it to the 'users' table
            $table->foreignId('transporter_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     * This part REMOVES the column if you ever need to roll back.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // We must drop the foreign key link first, then the column
            $table->dropForeign(['transporter_id']);
            $table->dropColumn('transporter_id');
        });
    }
};