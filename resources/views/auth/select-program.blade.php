<x-split-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Konfirmasi Pilihan</h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Sesuaikan paket belajar untuk kelas <strong>{{ $class->name }}</strong></p>
    </div>

    <div x-data="{ 
        package: 'monthly', 
        program: 'iqra',
        basePrice: {{ $class->price }},
        get price() {
            if (this.package === 'monthly') return this.basePrice;
            if (this.package === 'semester') return this.basePrice * 6 * 0.85; // 15% discount
            if (this.package === 'yearly') return this.basePrice * 12 * 0.75; // 25% discount
            return 0;
        },
        formatPrice(value) {
            return new Intl.NumberFormat('id-ID').format(Math.round(value));
        }
    }" class="space-y-10">

        {{-- Duration Selection --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">1. Pilih Durasi Belajar</h3>
            <div class="space-y-3">
                <!-- Monthly -->
                <div @click="package = 'monthly'" 
                     :class="{'border-islamic-emerald bg-islamic-emerald/5 ring-2 ring-islamic-emerald': package === 'monthly', 'border-gray-200 hover:border-islamic-emerald/50': package !== 'monthly'}"
                     class="cursor-pointer rounded-xl border-2 p-4 transition-all flex items-center justify-between group">
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white group-hover:text-islamic-emerald transition-colors">Bulanan</div>
                        <div class="text-sm text-gray-500">Bayar per bulan</div>
                    </div>
                    <div class="font-extrabold text-lg text-islamic-emerald">
                        Rp <span x-text="formatPrice(basePrice)"></span>
                    </div>
                </div>

                <!-- Semester -->
                <div @click="package = 'semester'" 
                     :class="{'border-islamic-emerald bg-islamic-emerald/5 ring-2 ring-islamic-emerald': package === 'semester', 'border-gray-200 hover:border-islamic-emerald/50': package !== 'semester'}"
                     class="cursor-pointer rounded-xl border-2 p-4 transition-all flex items-center justify-between relative group">
                    <div class="absolute -top-2.5 right-4 bg-yellow-400 text-[10px] font-bold px-2 py-0.5 rounded-full text-black shadow-sm">Hemat 15%</div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white group-hover:text-islamic-emerald transition-colors">Semester</div>
                        <div class="text-sm text-gray-500">6 Bulan</div>
                    </div>
                    <div class="font-extrabold text-lg text-islamic-emerald">
                        Rp <span x-text="formatPrice(basePrice * 6 * 0.85)"></span>
                    </div>
                </div>

                <!-- Yearly -->
                <div @click="package = 'yearly'" 
                     :class="{'border-islamic-emerald bg-islamic-emerald/5 ring-2 ring-islamic-emerald': package === 'yearly', 'border-gray-200 hover:border-islamic-emerald/50': package !== 'yearly'}"
                     class="cursor-pointer rounded-xl border-2 p-4 transition-all flex items-center justify-between relative group">
                    <div class="absolute -top-2.5 right-4 bg-red-500 text-[10px] font-bold px-2 py-0.5 rounded-full text-white shadow-sm">Hemat 25%</div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white group-hover:text-islamic-emerald transition-colors">Tahunan</div>
                        <div class="text-sm text-gray-500">12 Bulan</div>
                    </div>
                    <div class="font-extrabold text-lg text-islamic-emerald">
                        Rp <span x-text="formatPrice(basePrice * 12 * 0.75)"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Program Selection --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">2. Pilih Program</h3>
            <div class="grid grid-cols-2 gap-4">
                <!-- Iqra -->
                <div @click="program = 'iqra'" 
                     :class="{'border-islamic-emerald bg-islamic-emerald/5 ring-2 ring-islamic-emerald': program === 'iqra', 'border-gray-200 hover:border-islamic-emerald/50': program !== 'iqra'}"
                     class="cursor-pointer rounded-xl border-2 p-4 flex flex-col items-center text-center gap-3 transition-all hover:shadow-md">
                    <div class="text-4xl mb-1">📖</div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white text-sm">Program Iqra</div>
                        <div class="text-xs text-gray-500 mt-1">Belajar dari nol</div>
                    </div>
                </div>

                <!-- Tahsin -->
                <div @click="program = 'tahsin'" 
                     :class="{'border-islamic-emerald bg-islamic-emerald/5 ring-2 ring-islamic-emerald': program === 'tahsin', 'border-gray-200 hover:border-islamic-emerald/50': program !== 'tahsin'}"
                     class="cursor-pointer rounded-xl border-2 p-4 flex flex-col items-center text-center gap-3 transition-all hover:shadow-md">
                    <div class="text-4xl mb-1">🎯</div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white text-sm">Program Tahsin</div>
                        <div class="text-xs text-gray-500 mt-1">Perbaikan bacaan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Button --}}
        <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
            <a :href="'{{ route('register') }}?class_id={{ $class->id }}&package=' + package + '&program=' + program" 
               class="w-full flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl text-white bg-islamic-emerald hover:bg-islamic-emerald-dark dark:bg-islamic-gold dark:text-islamic-navy dark:hover:bg-white transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Lanjut Pendaftaran →
            </a>
            <p class="mt-4 text-center text-sm text-gray-500">
                Total estimasi: <span class="font-bold text-gray-900 dark:text-white">Rp <span x-text="formatPrice(price)"></span></span>
            </p>
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ url('/#pricing') }}" class="text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
            ← Kembali ke Pilihan Kelas
        </a>
    </div>
</x-split-layout>
