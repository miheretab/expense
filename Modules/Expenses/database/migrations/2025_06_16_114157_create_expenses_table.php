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
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->decimal('amount', 10, 2);
            $table->enum('category', ['food', 'transport', 'entertainment', 'bills', 'health', 'other']);
            $table->date('expense_date');
            $table->text('notes')->nullable();
            $table->integer('user_id')->nullable(); // Assuming you want to track the user who created the expense
            $table->foreign('user_id')->references('id')->on('users'); // Adjust as needed for your users table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
