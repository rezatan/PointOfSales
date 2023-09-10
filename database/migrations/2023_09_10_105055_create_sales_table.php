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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable();
            $table->foreignId('user_id');
            $table->unsignedMediumInteger('total_qty');
            $table->unsignedInteger('total_price');
            $table->tinyInteger('disc')->default(0);
            $table->unsignedInteger('bill')->default(0);
            $table->unsignedInteger('receipt')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
