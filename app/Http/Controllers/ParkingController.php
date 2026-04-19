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
   $pendapatanHariIni = Parking::withTrashed()
        ->where('status', 'selesai')
        ->whereDate('exit_time', today())
        ->sum('total_price');

   // Mengambil 5 atau 10 data per halaman
    $recentParkings = Parking::with(['vehicle', 'slot'])
                        ->latest()
                        ->paginate(5);
                        
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
        'status' => 'parkir',
        'user_id'      => auth()->id()
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
    $parking = Parking::with('vehicle')->findOrFail($id);
    
    $entryTime = \Carbon\Carbon::parse($parking->entry_time);
    $exitTime = now(); 

    // Menggunakan diffInHours untuk mendapatkan angka jam bulat (integer)
    // 0-59 menit = 0
    // 60-119 menit = 1
    $durationInHours = (int) $entryTime->diffInHours($exitTime);

    // Ambil harga dasar kategori (Misal: Motor 2000, Mobil 5000)
    $basePrice = $parking->vehicle->price; 
    
    // Tarif tambahan Rp 1.000 dikali jumlah jam bulat
    $extraPrice = $durationInHours * 1000;
    
    $totalPrice = $basePrice + $extraPrice;

    // Simpan ke database
    $parking->update([
        'exit_time' => $exitTime,
        'total_price' => $totalPrice,
        'status' => 'selesai'
    ]);

    // Kembalikan kuota area
    \App\Models\ParkingSlot::find($parking->slot_id)->decrement('used');

    return redirect()->route('admin.keluar')->with('success', 
        "Kendaraan {$parking->plate_number} Keluar. Total Bayar: Rp " . number_format($totalPrice, 0, ',', '.') . 
        " (Durasi: {$durationInHours} Jam)"
    );
}



public function history()
{
    // Mengambil data parkir yang sudah selesai dengan pagination
    $histories = Parking::with(['vehicle', 'slot'])
        ->where('status', 'selesai')
        ->latest('exit_time')
        ->paginate(10); // Mengganti get() menjadi paginate(10)

    return view('admin.history', compact('histories'));
}


// Tambahkan di App\Http\Controllers\ParkingController.php

public function destroy($id)
{
    if (!auth()->user()->hasRole('admin')) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus data!');
    }
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
    $month = $request->get('month', date('m'));
    $year = $request->get('year', date('Y'));

    // Gunakan withTrashed() agar data tetap terhitung di laporan meskipun sudah diarsip/hapus dari riwayat
    $todayRevenue = Parking::withTrashed() 
        ->where('status', 'selesai')
        ->whereDate('exit_time', now())
        ->sum('total_price');

    $reportByCategory = Parking::withTrashed() 
        ->with('vehicle')
        ->where('status', 'selesai')
        ->whereMonth('exit_time', $month)
        ->whereYear('exit_time', $year)
        ->get()
        ->groupBy('vehicle_id')
        ->map(function ($group) {
            return [
                'name' => $group->first()->vehicle->name ?? 'N/A',
                'total' => $group->sum('total_price'),
                'count' => $group->count()
            ];
        });

    $monthlyRevenue = $reportByCategory->sum('total');

    $dailyReports = Parking::withTrashed() 
        ->where('status', 'selesai')
        ->whereMonth('exit_time', $month)
        ->whereYear('exit_time', $year)
        ->selectRaw('DATE(exit_time) as date, SUM(total_price) as total, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

    return view('admin.report', compact(
        'reportByCategory', 
        'monthlyRevenue', 
        'dailyReports', 
        'month', 
        'year', 
        'todayRevenue'
    ));
}



// app/Http/Controllers/ParkingController.php

// Menyimpan plat dari Python ke Cache/Session sementara
// app/Http/Controllers/ParkingController.php

// app/Http/Controllers/ParkingController.php

public function setAntrian(Request $request) {
    $rawPlate = strtoupper($request->plate_number); // Pastikan Kapital
    
    // Logika menambahkan spasi: D1234A menjadi D 1234 A
    // Regex ini memisahkan Huruf Depan, Angka, dan Huruf Belakang
    $formattedPlate = preg_replace('/^([A-Z]{1,2})(\d+)([A-Z]*)$/', '$1 $2 $3', $rawPlate);

    cache(['temp_parking_data' => [
        'plate_number' => trim($formattedPlate), // trim untuk hapus spasi berlebih
        'type'         => $request->type
    ]], now()->addMinutes(1));
    
    return response()->json(['status' => 'success']);
}

public function getAntrian() {
    // Ambil dengan kunci yang sama: temp_parking_data
    $data = cache('temp_parking_data'); 
    
    if ($data) {
        cache()->forget('temp_parking_data');
        return response()->json($data);
    }
    return response()->json(null);
}


public function petugasDashboard()
{
    // Ambil data slot untuk memantau kapasitas parkir
    $areas = \App\Models\ParkingSlot::all();
    
    // Hitung kendaraan yang masih parkir (status 'parkir')
    $totalParkir = \App\Models\Parking::where('status', 'parkir')->count();
    
    // Ambil 5 riwayat kendaraan masuk terakhir untuk pantauan petugas
    $recentParkings = \App\Models\Parking::with(['vehicle', 'slot'])
        ->latest()
        ->take(5)
        ->get();

    return view('petugas.dashboard', compact('areas', 'totalParkir', 'recentParkings'));
}





}
