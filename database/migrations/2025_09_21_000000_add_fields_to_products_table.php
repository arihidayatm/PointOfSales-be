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
        Schema::table('products', function (Blueprint $table) {
            $table->string('barcode')->nullable()->after('description')->unique();
            $table->decimal('cost_price', 10, 2)->default(0)->after('price');
            $table->integer('min_stock_level')->default(0)->after('stock');
            $table->boolean('is_active')->default(true)->after('min_stock_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['barcode']);
            $table->dropColumn(['barcode', 'cost_price', 'min_stock_level', 'is_active']);
        });
    }
};
