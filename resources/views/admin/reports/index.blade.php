<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto px-4">
            
            {{-- Header - Compact --}}
            <div class="mb-2">
                <h1 class="text-lg font-bold text-gray-900">LAPORAN & STATISTIK</h1>
                <p class="text-[10px] text-gray-500">Analisis kinerja, keuangan, dan data peserta Tahsin Online</p>
            </div>

            {{-- Summary Cards - Compact --}}
            <div class="grid grid-cols-4 gap-2 mb-3">
                <div class="bg-emerald-700 border border-emerald-900 p-2 text-white">
                    <p class="text-[9px] font-semibold uppercase mb-0.5">Estimasi Pendapatan (Bulan Ini)</p>
                    <h2 class="text-xl font-bold">Rp {{ number_format($estimatedMonthlyRevenue / 1000, 0) }}k</h2>
                    <p class="text-[8px] mt-0.5">*Berdasarkan {{ $activeSubscriptions->count() }} langganan aktif</p>
                </div>

                <div class="bg-white border border-gray-300 p-2">
                    <p class="text-[9px] text-gray-600 uppercase font-semibold mb-0.5">Siswa Terdaftar</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $totalStudents }}</h3>
                    <span class="text-[8px] text-green-700">+{{ $total Students }} Total</span>
                </div>

                <div class="bg-white border border-gray-300 p-2">
                    <p class="text-[9px] text-gray-600 uppercase font-semibold mb-0.5">Pengajar Aktif</p>
                    <h3 class="text-xl font-bold text-gray-900">{{ $totalTeachers }}</h3>
                </div>

                <div class="bg-white border border-gray-300 p-2">
                    <p class="text-[9px] text-gray-600 uppercase font-semibold mb-0.5">Pembayaran Pending</p>
                    <h3 class="text-xl font-bold {{ $pendingPayments > 0 ? 'text-red-700' : 'text-gray-900' }}">{{ $pendingPayments }}</h3>
                    @if($pendingPayments > 0)
                        <span class="text-[8px] text-red-700 font-bold uppercase">Action Needed</span>
                    @endif
                </div>
            </div>

            {{-- Charts - Compact Side by Side --}}
            <div class="grid grid-cols-3 gap-2 mb-3">
                
                {{-- Revenue Sources --}}
                <div class="bg-white border border-gray-300 p-2">
                    <h3 class="text-[10px] font-bold text-gray-900 uppercase mb-1">Sumber Pendapatan</h3>
                    <div class="h-32">
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <div class="mt-1 space-y-0.5">
                        @foreach($revenueByClass as $item)
                        <div class="flex justify-between text-[9px]">
                            <div class="flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $item['color'] }}"></span>
                                <span class="text-gray-600">{{ $item['name'] }}</span>
                            </div>
                            <span class="font-bold">{{ number_format($item['revenue'] / 1000, 0) }}k</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Gender --}}
                <div class="bg-white border border-gray-300 p-2">
                    <h3 class="text-[10px] font-bold text-gray-900 uppercase mb-1">Jenis Kelamin</h3>
                    <div class="h-32">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>

                {{-- Age Groups --}}
                <div class="bg-white border border-gray-300 p-2">
                    <h3 class="text-[10px] font-bold text-gray-900 uppercase mb-1">Kelompok Usia</h3>
                    <div class="h-32">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Table - Compact --}}
            <div class="bg-white border border-gray-300">
                <div class="px-3 py-1 border-b border-gray-300 flex justify-between items-center bg-gray-50">
                    <h3 class="text-[10px] font-bold text-gray-900 uppercase">Rincian Pendapatan per Kelas</h3>
                    <a href="{{ route('admin.subscriptions.index') }}" class="text-[9px] text-emerald-700 hover:text-emerald-900 font-bold">Lihat Semua →</a>
                </div>
                <table class="w-full text-[10px]" style="font-family: 'Courier New', monospace;">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="border-r border-gray-700 px-2 py-1 text-left uppercase">Kelas</th>
                            <th class="border-r border-gray-700 px-2 py-1 text-center uppercase">Siswa</th>
                            <th class="border-r border-gray-700 px-2 py-1 text-right uppercase">Harga/Paket</th>
                            <th class="px-2 py-1 text-right uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($revenueByClass as $item)
                        <tr class="border-t border-gray-300 hover:bg-gray-50">
                            <td class="border-r border-gray-300 px-2 py-1">
                                <div class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $item['color'] }}"></span>
                                    <span class="font-semibold">{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="border-r border-gray-300 px-2 py-1 text-center">{{ $item['count'] }}</td>
                            <td class="border-r border-gray-300 px-2 py-1 text-right">Rp {{ number_format($item['revenue'] / $item['count'] / 1000, 0) }}k</td>
                            <td class="px-2 py-1 text-right font-bold text-emerald-700">Rp {{ number_format($item['revenue'] / 1000, 0) }}k</td>
                        </tr>
                        @endforeach
                        <tr class="bg-gray-100 border-t-2 border-gray-600">
                            <td class="px-2 py-1 font-bold">TOTAL</td>
                            <td class="px-2 py-1 text-center font-bold">{{ $activeSubscriptions->count() }}</td>
                            <td></td>
                            <td class="px-2 py-1 text-right font-bold text-emerald-700">Rp {{ number_format($estimatedMonthlyRevenue / 1000, 0) }}k</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const revenueData = @json($revenueByClass);
        const genderData = @json($studentGender);
        const ageData = @json($studentAge);

        // Revenue Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'doughnut',
            data: {
                labels: revenueData.map(i => i.name),
                datasets: [{ data: revenueData.map(i => i.revenue), backgroundColor: revenueData.map(i => i.color), borderWidth: 0 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, cutout: '70%' }
        });

        // Gender Chart
        new Chart(document.getElementById('genderChart'), {
            type: 'pie',
            data: {
                labels: ['L', 'P'],
                datasets: [{ data: [genderData['male'] || 0, genderData['female'] || 0], backgroundColor: ['#3B82F6', '#EC4899'], borderWidth: 0 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { font: { size: 9 } } } } }
        });

        // Age Chart
        new Chart(document.getElementById('ageChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(ageData),
                datasets: [{ label: 'Siswa', data: Object.values(ageData), backgroundColor: '#10B981', borderRadius: 4 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 9 } } }, x: { grid: { display: false }, ticks: { font: { size: 9 } } } }
            }
        });
    </script>
</x-app-layout>
