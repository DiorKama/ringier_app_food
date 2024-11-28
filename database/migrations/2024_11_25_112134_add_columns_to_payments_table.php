<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('token')->nullable();
            $table->string('payment_status')->default('pending');
            $table->date('payment_date')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['token', 'payment_status', 'payment_date']);
        });
    }
};
