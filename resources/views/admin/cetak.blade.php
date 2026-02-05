<!DOCTYPE html>
<html>
<head>
    <title>Cetak Karcis - {{ $parking->plate_number }}</title>
    <style>
        @page { size: 58mm auto; margin: 0; }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 58mm; 
            margin: 0; 
            padding: 5mm; 
            font-size: 12px; 
            color: #000;
        }
        .text-center { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 8px 0; }
        .qr-code { margin: 10px 0; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print();">
    <div class="text-center">
        <strong>PARKIR SYSTEM v1</strong><br>
        Lembang, Jawa Barat<br>
        <div class="line"></div>
        <strong>KARCIS MASUK</strong>
    </div>

    <div class="qr-code text-center">
    @php
        // Menggunakan QuickChart API (Alternatif Google Charts yang lebih baru)
        $qrData = "Plat:" . $parking->plate_number . "|Masuk:" . $parking->entry_time;
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($qrData) . "&size=150";
    @endphp
    <img src="{{ $qrUrl }}" alt="QR Code Parkir" style="width: 120px; height: 120px;">
</div>

    <div style="margin-left: 2mm;">
        Plat : <strong>{{ $parking->plate_number }}</strong><br>
        Jenis: {{ $parking->vehicle->name }}<br>
        Area : {{ $parking->slot->type ?? 'N/A' }}<br>
        Jam  : {{ date('H:i:s', strtotime($parking->entry_time)) }}<br>
        Tgl  : {{ date('d/m/Y', strtotime($parking->entry_time)) }}<br>
    </div>

    <div class="line"></div>
    <div class="text-center">
        SIMPAN KARCIS INI<br>
        UNTUK PROSES KELUAR<br>
        <br>
        <button class="no-print" onclick="window.location.href='{{ route('admin.masuk') }}'" 
                style="padding: 5px 10px; cursor: pointer;">
            Kembali ke Form
        </button>
    </div>
</body>
</html>