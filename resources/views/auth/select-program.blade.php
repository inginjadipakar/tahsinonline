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
                    <div class="w-12 h-12 bg-islamic-emerald/10 rounded-xl flex items-center justify-center mb-1">
                        <svg class="w-6 h-6 text-islamic-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 dark:text-white text-sm">Program Iqra</div>
                        <div class="text-xs text-gray-500 mt-1">Belajar dari nol</div>
                    </div>
                </div>

                <!-- Tahsin -->
                <div @click="program = 'tahsin'" 
                     :class="{'border-islamic-emerald bg-islamic-emerald/5 ring-2 ring-islamic-emerald': program === 'tahsin', 'border-gray-200 hover:border-islamic-emerald/50': program !== 'tahsin'}"
                     class="cursor-pointer rounded-xl border-2 p-4 flex flex-col items-center text-center gap-3 transition-all hover:shadow-md">
                    <div class="w-12 h-12 bg-islamic-emerald/10 rounded-xl flex items-center justify-center mb-1">
                        <svg class="w-6 h-6 text-islamic-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        </svg>
                    </div>
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
