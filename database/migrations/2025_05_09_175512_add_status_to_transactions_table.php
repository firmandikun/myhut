<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menambahkan kolom status
            $table->enum('status', ['processing', 'shipped', 'completed'])->default('processing');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menghapus kolom status
            $table->dropColumn('status');
        });
    }
}
