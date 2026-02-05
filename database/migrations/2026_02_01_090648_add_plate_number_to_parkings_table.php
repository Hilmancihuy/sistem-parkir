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
    Schema::table('parkings', function (Blueprint $table) {
        // Menambahkan kolom plate_number setelah id
        $table->string('plate_number')->after('id')->nullable(); 
    });
}

public function down(): void
{
    Schema::table('parkings', function (Blueprint $table) {
        $table->dropColumn('plate_number');
    });
}
};
