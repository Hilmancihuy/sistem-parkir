<!DOCTYPE html>
<html>
<head>
    <title>Cetak Karcis - {{ $parking->plate_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Bebas+Neue&display=swap');

        @page { size: 58mm auto; margin: 0; }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Share Tech Mono', 'Courier New', monospace;
            width: 58mm;
            margin: 0 auto;
            padding: 4mm 4mm 6mm;
            font-size: 9px;
            color: #111;
            background: #fff;
            letter-spacing: 0.03em;
        }

        /* ── Header ── */
        .header {
            text-align: center;
            padding-bottom: 5px;
        }
        .header .logo-text {
            font-family: 'Bebas Neue', 'Arial Narrow', sans-serif;
            font-size: 22px;
            letter-spacing: 3px;
            line-height: 1;
            color: #111;
        }
        .header .sub {
            font-size: 8px;
            letter-spacing: 1px;
            color: #555;
            margin-top: 1px;
        }

        /* ── Badge KARCIS MASUK ── */
        .badge {
            margin: 6px 0;
            background: #111;
            color: #fff;
            text-align: center;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 13px;
            letter-spacing: 4px;
            padding: 3px 0 4px;
            clip-path: polygon(4px 0%, calc(100% - 4px) 0%, 100% 4px, 100% calc(100% - 4px), calc(100% - 4px) 100%, 4px 100%, 0% calc(100% - 4px), 0% 4px);
        }

        /* ── Dividers ── */
        .divider {
            border: none;
            border-top: 1px dashed #aaa;
            margin: 6px 0;
        }
        .divider-solid {
            border: none;
            border-top: 2px solid #111;
            margin: 6px 0;
        }
        .divider-double {
            border-top: 1px solid #111;
            border-bottom: 1px solid #111;
            padding: 2px 0;
            margin: 5px 0;
        }

        /* ── Plat Nomor besar ── */
        .plate-wrap {
            text-align: center;
            margin: 8px 0 6px;
        }
        .plate-box {
            display: inline-block;
            border: 2.5px solid #111;
            border-radius: 3px;
            padding: 4px 10px 3px;
            position: relative;
        }
        .plate-box::before,
        .plate-box::after {
            content: '●';
            font-size: 5px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #111;
        }
        .plate-box::before { left: 3px; }
        .plate-box::after  { right: 3px; }
        .plate-number {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px;
            letter-spacing: 4px;
            line-height: 1;
            color: #111;
        }

        /* ── Data rows ── */
        .info-block {
            margin: 4px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            line-height: 1.7;
        }
        .info-label {
            color: #555;
            font-size: 8px;
            letter-spacing: 0.5px;
            flex-shrink: 0;
            padding-right: 4px;
        }
        .info-dots {
            flex: 1;
            border-bottom: 1px dotted #ccc;
            margin: 0 2px 2px;
        }
        .info-value {
            font-size: 9px;
            font-weight: bold;
            color: #111;
            text-align: right;
            flex-shrink: 0;
        }

        /* ── Waktu besar ── */
        .time-block {
            text-align: center;
            margin: 6px 0;
            padding: 4px;
            border: 1px solid #ddd;
            background: #f7f7f7;
        }
        .time-label {
            font-size: 7px;
            letter-spacing: 2px;
            color: #888;
            text-transform: uppercase;
        }
        .time-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20px;
            letter-spacing: 3px;
            line-height: 1.1;
            color: #111;
        }
        .date-value {
            font-size: 9px;
            color: #444;
            letter-spacing: 1px;
        }

        /* ── Footer ── */
        .footer {
            text-align: center;
            margin-top: 6px;
        }
        .footer .warn {
            font-size: 8px;
            letter-spacing: 1.5px;
            color: #111;
            line-height: 1.8;
        }
        .footer .warn strong {
            font-size: 9px;
        }

        /* ── Decorative corner marks ── */
        .corner-marks {
            display: flex;
            justify-content: space-between;
            font-size: 7px;
            color: #ccc;
            margin: 2px 0;
        }

        /* ── Tombol kembali (tidak dicetak) ── */
        .no-print {
            display: block;
            margin: 12px auto 0;
            padding: 6px 16px;
            background: #111;
            color: #fff;
            border: none;
            font-family: 'Share Tech Mono', monospace;
            font-size: 10px;
            letter-spacing: 1px;
            cursor: pointer;
            width: 100%;
        }
        .no-print:hover { background: #333; }

        @media print {
            .no-print { display: none !important; }
            body { width: 58mm; }
        }
    </style>
</head>
<body onload="window.print();">

    <!-- Header -->
    <div class="header">
        <div class="logo-text">PARKIR SYSTEM</div>
        <div class="sub">LEMBANG · JAWA BARAT</div>
    </div>

    <div class="divider-solid"></div>

    <!-- Badge -->
    <div class="badge">✦ KARCIS MASUK ✦</div>

    <!-- Plat Nomor -->
    <div class="plate-wrap">
        <div class="plate-box">
            <div class="plate-number">{{ $parking->plate_number }}</div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Data kendaraan -->
    <div class="info-block">
        <div class="info-row">
            <span class="info-label">JENIS</span>
            <span class="info-dots"></span>
            <span class="info-value">{{ strtoupper($parking->vehicle->name) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">AREA</span>
            <span class="info-dots"></span>
            <span class="info-value">{{ strtoupper($parking->slot->type ?? 'N/A') }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Waktu masuk -->
    <div class="time-block">
        <div class="time-label">WAKTU MASUK</div>
        <div class="time-value">{{ date('H:i', strtotime($parking->entry_time)) }}</div>
        <div class="date-value">{{ date('d / m / Y', strtotime($parking->entry_time)) }}</div>
    </div>

    <div class="divider"></div>

    <!-- Corner deco + ID transaksi -->
    <div class="corner-marks">
        <span>◤</span>
        <span style="font-size:7px; color:#aaa; letter-spacing:1px;">
            #{{ strtoupper(substr(md5($parking->plate_number . $parking->entry_time), 0, 8)) }}
        </span>
        <span>◥</span>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="divider-double">
            <div class="warn">
                <strong>⚠ SIMPAN KARCIS INI</strong><br>
                WAJIB DITUNJUKKAN SAAT KELUAR<br>
                KEHILANGAN DIKENAKAN BIAYA
            </div>
        </div>
        <div style="font-size:7px; color:#bbb; letter-spacing:1px; margin-top:4px;">
            ★ TERIMA KASIH ★
        </div>
    </div>

    <!-- Tombol kembali -->
    <button class="no-print" onclick="window.location.href='{{ route('admin.masuk') }}'">
        ← KEMBALI KE FORM
    </button>

</body>
</html>