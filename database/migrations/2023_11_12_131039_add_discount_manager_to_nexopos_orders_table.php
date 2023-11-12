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
        Schema::table('nexopos_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('nexopos_orders', 'discount_manager')) {
                $table->string('discount_manager', 255)->nullable()->comment('User Authorize the discount');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nexopos_orders', function (Blueprint $table) {
            if (Schema::hasColumn('nexopos_orders', 'discount_manager')) {
                $table->dropColumn('discount_manager');
            }
        });
    }
};
