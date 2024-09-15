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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->foreignId('receiver_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['debit', 'credit']);
            $table->decimal('before_balance', 10, 2);
            $table->decimal('after_balance', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
