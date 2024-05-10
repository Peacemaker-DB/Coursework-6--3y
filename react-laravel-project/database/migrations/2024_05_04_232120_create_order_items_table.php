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
        Schema::create('orderItems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Внешний ключ для связи с таблицей заказов
            $table->unsignedBigInteger('product_id'); // Внешний ключ для связи с таблицей продуктов
            $table->integer('item_quantity'); // Количество продукта в заказе
            $table->decimal('price', 10, 2); // Цена продукта на момент заказа
            // Другие необходимые поля

            $table->timestamps();

            // Создание связи с таблицей заказов
            $table->foreign('order_id')->references('id')->on('orders');
            // Создание связи с таблицей продуктов
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
