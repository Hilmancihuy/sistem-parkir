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
    Schema::table('parking_slots', function (Blueprint $table) {
        // Hapus kolom lama yang tidak terpakai
        $table->dropColumn(['code', 'status']); 
        
        // Tambahkan kolom baru untuk sistem kuota
        $table->string('type')->after('id'); // motor atau mobil
        $table->integer('capacity')->default(0); // Total kapasitas area
        $table->integer('used')->default(0); // Jumlah kendaraan yang parkir saat ini
    });
}

public function down()
{
    Schema::table('parking_slots', function (Blueprint $table) {
        $table->dropColumn(['type', 'capacity', 'used']);
        $table->string('code');
        $table->string('status');
    });
}
};
