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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->default('utensils');
            $table->string('tagline')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->decimal('original_price', 8, 2)->nullable();
            $table->decimal('rating', 3, 2)->default(4.8);
            $table->integer('reviews_count')->default(120);
            $table->string('prep_time')->default('20-25 min');
            $table->integer('calories')->nullable();
            $table->string('image');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_chef_special')->default(false);
            $table->boolean('is_vegetarian')->default(false);
            $table->boolean('is_spicy')->default(false);
            $table->integer('spice_level')->default(0);
            $table->json('tags')->nullable();
            $table->json('customization_options')->nullable();
            $table->timestamps();
        });

        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->string('description');
            $table->enum('type', ['percentage', 'fixed', 'free_delivery'])->default('percentage');
            $table->decimal('value', 8, 2)->default(0);
            $table->decimal('min_spend', 8, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->text('delivery_address');
            $table->text('notes')->nullable();
            $table->string('payment_method')->default('card');
            $table->enum('status', ['received', 'preparing', 'on_the_way', 'delivered', 'cancelled'])->default('received');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('delivery_fee', 8, 2)->default(3.99);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('tip', 8, 2)->default(0);
            $table->decimal('total', 8, 2);
            $table->string('promo_code')->nullable();
            $table->json('items');
            $table->timestamp('estimated_delivery_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('promo_codes');
        Schema::dropIfExists('food_items');
        Schema::dropIfExists('categories');
    }
};
