<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Parking;
use App\Models\ParkingSlot;
use App\Models\Category;

class ParkingController extends Controller
{

   // app/Http/Controllers/ParkingController.php

public function dashboard()
{
    // 1. Ambil semua data area (Motor & Mobil) untuk progress bar
    $areas = \App\Models\ParkingSlot::all();
    
    // 2. Hitung total kendaraan yang sedang parkir saat ini
    $totalParkir = Parking::where('status', 'parkir')->count();
    
    // 3. Hitung total pendapatan hari ini
    $pendapatanHariIni = Parking::whereDate('created_at', today())->sum('total_price');

    // 4. Ambil 5 transaksi terakhir
    $recentParkings = Parking::with(['vehicle', 'slot'])->latest()->take(5)->get();

    // Pastikan 'areas' dimasukkan ke dalam compact()
    return view('admin.dashboard', compact(
        'areas', 
        'totalParkir', 
        'pendapatanHariIni', 
        'recentParkings'
    ));
}

   public function create()
{
    $vehicles = Category::all();
    // Ambil data area yang masih punya sisa kuota
    $areas = ParkingSlot::whereRaw('used < capacity')->get();

    return view('admin.masuk', compact('vehicles', 'areas'));
}

public function store(Request $request)
{
    $request->validate([
        'plate_number' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'slot_id' => 'required|exists:parking_slots,id', // Sekarang slot_id adalah ID Area
    ]);

    // Simpan transaksi
    $parking = Parking::create([
        'plate_number' => $request->plate_number,
        'vehicle_id' => $request->category_id, 
        'slot_id' => $request->slot_id,
        'entry_time' => now(),
        'status' => 'parkir'
    ]);

    // Update Kuota Area: Tambah 1 yang terisi
    ParkingSlot::find($request->slot_id)->increment('used');

    return redirect()->route('admin.cetak', $parking->id);
}

// Tambahkan fungsi baru untuk menampilkan view cetak
public function showCetak($id)
{
    $parking = Parking::with(['vehicle', 'slot'])->findOrFail($id);
    return view('admin.cetak', compact('parking'));
}



// Tambahkan di App\Http\Controllers\ParkingController.php

public function indexKeluar(Request $request)
{
    $query = Parking::with(['vehicle', 'slot'])->where('status', 'parkir');

    // Jika ada input pencarian plat nomor
    if ($request->has('search') && $request->search != '') {
        $query->where('plate_number', 'like', '%' . $request->search . '%');
    }

    $parkings = $query->get();
    
    return view('admin.keluar', compact('parkings'));
}

public function updateKeluar(Request $request, $id)
{
    $parking = Parking::findOrFail($id);
    
    // 1. Ambil harga dasar flat dari kategori (misal: Motor 2000, Mobil 5000)
    $totalPrice = $parking->vehicle->price; 

    // 2. Update data transaksi
    $parking->update([
        'exit_time' => now(), // Waktu keluar tetap dicatat untuk laporan
        'total_price' => $totalPrice,
        'status' => 'selesai'
    ]);

    // 3. Update Kuota Area: Kurangi jumlah terisi karena kendaraan keluar
    \App\Models\ParkingSlot::find($parking->slot_id)->decrement('used');

    return redirect()->route('admin.cetak', $parking->id);
}



public function history()
{
    // Mengambil data parkir yang sudah selesai, diurutkan dari yang terbaru
    $histories = Parking::with(['vehicle', 'slot'])
        ->where('status', 'selesai')
        ->latest('exit_time')
        ->get();

    return view('admin.history', compact('histories'));
}


// Tambahkan di App\Http\Controllers\ParkingController.php

public function destroy($id)
{
    $parking = Parking::findOrFail($id);
    $parking->delete();

    return back()->with('success', 'Data riwayat berhasil dihapus.');
}

public function destroyAll()
{
    // Hanya menghapus yang statusnya sudah 'selesai'
    Parking::where('status', 'selesai')->delete();

    return back()->with('success', 'Semua riwayat parkir telah dibersihkan.');
}


public function report(Request $request)
{
    // Filter berdasarkan bulan dan tahun saat ini jika tidak ada input
    $month = $request->get('month', date('m'));
    $year = $request->get('year', date('Y'));

    // 1. Pendapatan per Kategori (Chart Data)
    $reportByCategory = Parking::with('vehicle')
        ->where('status', 'selesai')
        ->whereMonth('exit_time', $month)
        ->whereYear('exit_time', $year)
        ->get()
        ->groupBy('vehicle_id')
        ->map(function ($group) {
            return [
                'name' => $group->first()->vehicle->name,
                'total' => $group->sum('total_price'),
                'count' => $group->count()
            ];
        });

    // 2. Total Keseluruhan Bulan Ini
    $monthlyRevenue = $reportByCategory->sum('total');

    // 3. Data Harian untuk Tabel
    $dailyReports = Parking::where('status', 'selesai')
        ->whereMonth('exit_time', $month)
        ->whereYear('exit_time', $year)
        ->selectRaw('DATE(exit_time) as date, SUM(total_price) as total, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

    return view('admin.report', compact('reportByCategory', 'monthlyRevenue', 'dailyReports', 'month', 'year'));
}





}
