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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('iban', 34)->unique(); 
            $table->string('currency', 3)->default('EUR'); 
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->enum('status', ['pending', 'approved', 'disapproved'])->default('pending');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
