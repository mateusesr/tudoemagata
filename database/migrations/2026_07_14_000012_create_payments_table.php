<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider')->default('mercado_pago');
            $table->string('provider_payment_id')->nullable()->index();
            $table->enum('method', ['pix', 'credit_card'])->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled', 'expired', 'refunded'])->default('pending');
            $table->decimal('amount', 10, 2);
            $table->json('payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
