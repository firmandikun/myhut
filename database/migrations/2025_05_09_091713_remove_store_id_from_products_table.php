<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Langsung drop kolom store_id
            if (Schema::hasColumn('products', 'store_id')) {
                $table->dropColumn('store_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan kembali kolom dan foreign key
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};

