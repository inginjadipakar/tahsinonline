<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Laporan & Statistik</h1>
                <p class="mt-1 text-sm text-gray-500">Analisis kinerja, keuangan, dan data peserta Tahsin Online</p>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Revenue Card --}}
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium mb-1">Estimasi Pendapatan (Bulan Ini)</p>
                        <h2 class="text-3xl font-bold">Rp {{ number_format($estimatedMonthlyRevenue, 0, ',', '.') }}</h2>
                        <p class="text-xs text-emerald-200 mt-2">*Berdasarkan {{ $activeSubscriptions->count() }} langganan aktif</p>
                    </div>
                    <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-2 translate-y-2">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/></svg>
                    </div>
                </div>

                {{-- Students Card --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+{{ $totalStudents }} Total</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</h3>
                    <p class="text-sm text-gray-500">Siswa Terdaftar</p>
                </div>

                {{-- Teachers Card --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalTeachers }}</h3>
                    <p class="text-sm text-gray-500">Pengajar Aktif</p>
                </div>

                {{-- Pending Payments --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        @if($pendingPayments > 0)
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full animate-pulse">Action Needed</span>
                        @endif
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pendingPayments }}</h3>
                    <p class="text-sm text-gray-500">Pembayaran Pending</p>
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                {{-- 1. Revenue Sources (Doughnut) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Sumber Pendapatan</h3>
                    <div class="relative h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <div class="mt-4 space-y-2">
                        @foreach($revenueByClass as $item)
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full" style="background-color: {{ $item['color'] }}"></span>
                                <span class="text-gray-600">{{ $item['name'] }}</span>
                            </div>
                            <span class="font-bold text-gray-900">Rp {{ number_format($item['revenue'] / 1000, 0) }}k</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- 2. Demographics (Bar & Pie) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Demografi Siswa</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Gender --}}
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-3 text-center">Jenis Kelamin</h4>
                            <div class="relative h-48">
                                <canvas id="genderChart"></canvas>
                            </div>
                        </div>

                        {{-- Age Groups --}}
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-3 text-center">Kelompok Usia</h4>
                            <div class="relative h-48">
                                <canvas id="ageChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Breakdown Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Rincian Pendapatan per Kelas</h3>
                    <a href="{{ route('admin.subscriptions.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua Subscription &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Siswa</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Harga per Paket</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($revenueByClass as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full" style="background-color: {{ $item['color'] }}"></span>
                                        <span class="text-sm font-medium text-gray-900">{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                                    {{ $item['count'] }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format(($item['revenue'] / $item['count']), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-bold text-emerald-600">
                                    Rp {{ number_format($item['revenue'], 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                            <tr class="bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-900">Total</td>
                                <td class="px-6 py-4 text-center font-bold text-gray-900">{{ $activeSubscriptions->count() }}</td>
                                <td></td>
                                <td class="px-6 py-4 text-right font-bold text-emerald-600 text-lg">
                                    Rp {{ number_format($estimatedMonthlyRevenue, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data from Controller
        const revenueData = @json($revenueByClass);
        const genderData = @json($studentGender);
        const ageData = @json($studentAge);

        // 1. Revenue Chart (Doughnut)
        new Chart(document.getElementById('revenueChart'), {
            type: 'doughnut',
            data: {
                labels: revenueData.map(item => item.name),
                datasets: [{
                    data: revenueData.map(item => item.revenue),
                    backgroundColor: revenueData.map(item => item.color),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '70%'
            }
        });

        // 2. Gender Chart (Pie)
        new Chart(document.getElementById('genderChart'), {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [
                        genderData['male'] || 0,
                        genderData['female'] || 0
                    ],
                    backgroundColor: ['#3B82F6', '#EC4899'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // 3. Age Chart (Bar)
        const ageLabels = Object.keys(ageData);
        new Chart(document.getElementById('ageChart'), {
            type: 'bar',
            data: {
                labels: ageLabels,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: Object.values(ageData),
                    backgroundColor: '#10B981',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</x-app-layout>
