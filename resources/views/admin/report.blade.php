<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Pendapatan</h2>
            
            <div class="flex gap-3 print:hidden">
                {{-- Tombol Export Excel --}}
                <button onclick="exportToExcel()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel
                </button>

                {{-- Tombol Cetak PDF (Browser) --}}
                <button onclick="window.print()" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak PDF
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Form Filter --}}
            <div class="print:hidden bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
                <form action="{{ route('admin.report') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select name="month" class="rounded-xl border-gray-300 focus:ring-orange-500">
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <select name="year" class="rounded-xl border-gray-300 focus:ring-orange-500">
                            @for($i=date('Y'); $i>=2024; $i--)
                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl hover:bg-slate-900 transition">
                        Filter Laporan
                    </button>
                </form>
            </div>

            {{-- Kartu Ringkasan Pendapatan --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-3xl border-2 border-orange-100 shadow-sm">
                    <p class="text-gray-500 text-sm italic">Hari Ini</p>
                    <h3 class="text-2xl font-black text-orange-600 mt-1">
                        Rp {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 rounded-3xl text-white shadow-xl">
                    <p class="text-orange-100 text-sm">Total Bulan Ini</p>
                    <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                </div>

                @foreach($reportByCategory as $cat)
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-gray-500 text-sm">Total {{ $cat['name'] }}</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($cat['total'], 0, ',', '.') }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $cat['count'] }} Kendaraan</p>
                </div>
                @endforeach
            </div>

            {{-- Tabel Rincian --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden print:shadow-none print:border-gray-300">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="font-bold text-gray-700">Rincian Pendapatan Harian</h3>
                </div>
                <div id="reportTableArea">
                    <table class="w-full" id="mainReportTable">
                        <thead class="bg-gray-50 text-gray-500 text-sm">
                            <tr>
                                <th class="p-4 text-left">Tanggal</th>
                                <th class="p-4 text-center">Jumlah Kendaraan</th>
                                <th class="p-4 text-right">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($dailyReports as $report)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-medium">{{ date('d M Y', strtotime($report->date)) }}</td>
                                <td class="p-4 text-center">{{ $report->count }}</td>
                                <td class="p-4 text-right font-bold text-slate-700">Rp {{ number_format($report->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer Khusus Print --}}
            <div class="hidden print:block mt-12 text-right text-sm">
                <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
                <p class="mt-12 font-bold">(____________________)</p>
                <p>Petugas Admin</p>
            </div>
        </div>
    </div>

    <script>
        function exportToExcel() {
            const table = document.getElementById("mainReportTable");
            const html = table.outerHTML;
            
            // Format Blob untuk Excel
            const blob = new Blob([html], {
                type: "application/vnd.ms-excel"
            });
            
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "Laporan_Parkir_{{ $month }}_{{ $year }}.xls";
            a.click();
            window.URL.revokeObjectURL(url);
        }
    </script>

    <style>
        @media print {
            body { background: white; }
            .py-12 { padding-top: 0; padding-bottom: 0; }
        }
    </style>
</x-app-layout>