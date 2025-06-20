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
       
Schema::create('items', function (Blueprint $table) {

$table->id();
//$table->string('item_code');
$table->string('relevant_store_id');
$table->string('ict_category_id');
$table->string('equipment_type_id');
$table->string('title_name');
$table->string('item_name');
$table->string('ledger_card_no');
$table->string('manufactured_country')->nullable();
$table->string('is_serial');
$table->string('is_unit')->nullable();
$table->string('unit_of_issue_id');
$table->string('re_order_level');
$table->string('commander_reserve');
$table->string('remarks');
$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
