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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->nullable()->after('product_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2)->nullable()->after('quantity'); // Preço no momento da adição
            $table->foreignId('product_id')->nullable()->change(); // Tornar product_id nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn(['product_variant_id', 'price']);
            $table->foreignId('product_id')->nullable(false)->change(); // Voltar product_id para not null
        });
    }
};
