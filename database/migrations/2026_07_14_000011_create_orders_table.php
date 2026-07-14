<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->foreignId('customer_address_id')->nullable()->constrained()->nullOnDelete();

            // Snapshot do endereço no momento da compra (não referenciar só o cadastro atual)
            $table->string('shipping_recipient_name')->nullable();
            $table->string('shipping_zip_code', 9)->nullable();
            $table->string('shipping_street')->nullable();
            $table->string('shipping_number')->nullable();
            $table->string('shipping_complement')->nullable();
            $table->string('shipping_neighborhood')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state', 2)->nullable();

            $table->enum('status', [
                'pending', 'paid', 'separating', 'shipped', 'completed', 'cancelled',
            ])->default('pending');

            $table->decimal('items_total', 10, 2)->default(0);
            $table->decimal('shipping_total', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);

            $table->string('shipping_provider')->nullable();
            $table->string('shipping_service')->nullable();
            $table->integer('shipping_deadline_days')->nullable();
            $table->string('tracking_code')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();

            // Snapshot: nome, preço e imagem no momento da compra
            $table->string('product_name');
            $table->string('variant_name')->nullable();
            $table->string('sku')->nullable();
            $table->string('image_path')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
