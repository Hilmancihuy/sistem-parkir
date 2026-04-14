<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parking extends Model
{
    

    use SoftDeletes;
    protected $fillable = [
        'plate_number',
        'vehicle_id', // Tetap gunakan nama kolom ini sesuai database Anda
        'slot_id',
        'entry_time',
        'exit_time',
        'total_price',
        'status',
        'user_id'
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

    public function user()
{
    return $this->belongsTo(User::class);
}

}


