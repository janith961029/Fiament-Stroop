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
        Schema::create('recive_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('ledger_card_no');
            $table->integer('quantity');
            $table->string('purchase_order_no');
            $table->date('received_date');
            $table->date('approved_date');
            $table->decimal('item_price', 10, 2);
            $table->string('warranty_period');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recive_items');
    }
};
