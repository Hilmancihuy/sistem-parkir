<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $fillable = [
        'plate_number',
        'vehicle_id', // Tetap gunakan nama kolom ini sesuai database Anda
        'slot_id',
        'entry_time',
        'exit_time',
        'total_price',
        'status'
    ];

    // Ubah relasi ini agar mengarah ke Category
    public function vehicle()
    {
        return $this->belongsTo(Category::class, 'vehicle_id'); 
    }

    public function slot()
    {
        return $this->belongsTo(ParkingSlot::class, 'slot_id');
    }

}


