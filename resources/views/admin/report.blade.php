<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Pendapatan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 rounded-3xl text-white shadow-xl shadow-orange-500/20">
                    <p class="text-orange-100 text-sm">Total Pendapatan (Bulan Ini)</p>
                    <h3 class="text-3xl font-bold mt-1">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                </div>

                @foreach($reportByCategory as $cat)
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-gray-500 text-sm">Total {{ $cat['name'] }}</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($cat['total'], 0, ',', '.') }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $cat['count'] }} Kendaraan</p>
                </div>
                @endforeach
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="font-bold text-gray-700">Rincian Pendapatan Harian</h3>
                </div>
                <table class="w-full">
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
    </div>
</x-app-layout>