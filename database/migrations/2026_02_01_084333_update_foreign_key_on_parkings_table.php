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
        // Hapus foreign key lama yang mengarah ke tabel 'vehicles'
        $table->dropForeign(['vehicle_id']);
        
        // Buat foreign key baru yang mengarah ke tabel 'categories'
        $table->foreign('vehicle_id')->references('id')->on('categories')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
