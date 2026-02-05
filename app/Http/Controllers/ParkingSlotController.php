<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    /**
     * Menampilkan daftar area parkir (Motor & Mobil)
     */
    public function index()
    {
        $slots = ParkingSlot::all();
        return view('admin.slot', compact('slots'));
    }

    /**
     * Memperbarui kapasitas area parkir
     */
    public function updateSlot(Request $request, $id)
    {
        // 1. Validasi input: Kapasitas harus angka dan tidak boleh negatif
        $request->validate([
            'capacity' => 'required|integer|min:0'
        ]);

        // 2. Cari area berdasarkan ID
        $slot = ParkingSlot::findOrFail($id);

        // 3. Update kapasitas total area tersebut
        $slot->update([
            'capacity' => $request->capacity
        ]);

        // 4. Kembali ke halaman dengan pesan sukses
        return redirect()->back()->with('success', 'Kapasitas area ' . $slot->type . ' berhasil diperbarui!');
    }
}