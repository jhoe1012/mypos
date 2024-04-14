<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eod_inventories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->bigInteger('unit_id');
            $table->string('sku');
            $table->string('product_name');
            $table->string('uom');
            $table->date('inv_date');
            $table->float('begin_qty')->nullable();
            $table->float('in_qty')->nullable();
            $table->float('sold_qty')->nullable();
            $table->float('spoilage_qty')->nullable();
            $table->float('end_qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
};
