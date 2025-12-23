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
                        <svg class="w-6 h-6 text-islamic-emerald" viewBox="0 0 256 256" fill="currentColor">
                            <path d="M232,48H160a40,40,0,0,0-32,16A40,40,0,0,0,96,48H24a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H96a24,24,0,0,1,24,24,8,8,0,0,0,16,0,24,24,0,0,1,24-24h72a8,8,0,0,0,8-8V56A8,8,0,0,0,232,48ZM96,192H32V64H96a24,24,0,0,1,24,24V200A39.81,39.81,0,0,0,96,192Zm128,0H160a39.81,39.81,0,0,0-24,8V88a24,24,0,0,1,24-24h64Z"/>
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
                        <svg class="w-6 h-6 text-islamic-emerald" viewBox="0 0 256 256" fill="currentColor">
                            <path d="M223.85,47.12a16,16,0,0,0-15-15c-12.58-.75-44.73.4-71.41,27.07L132.69,64H74.36A15.91,15.91,0,0,0,63,68.68L28.7,103a16,16,0,0,0,9.07,27.16l38.47,5.37,44.21,44.21,5.37,38.49a15.94,15.94,0,0,0,10.78,12.92,16.11,16.11,0,0,0,5.1.83A15.91,15.91,0,0,0,153,227.3L187.32,193A15.91,15.91,0,0,0,192,181.64V123.31l4.77-4.77C223.45,91.86,224.6,59.71,223.85,47.12ZM74.36,80h42.33L77.16,119.52,40,114.34Zm74.41-9.45a76.65,76.65,0,0,1,59.11-22.47,76.46,76.46,0,0,1-22.42,59.16L128,164.68,91.32,128ZM176,181.64,141.67,216l-5.19-37.17L176,139.31Zm-74.16,9.5C97.34,201,82.29,224,40,224a8,8,0,0,1-8-8c0-42.29,23-57.34,32.86-61.85a8,8,0,0,1,6.64,14.56c-6.43,2.93-20.62,12.36-23.12,38.91,26.55-2.5,36-16.69,38.91-23.12a8,8,0,1,1,14.56,6.64Z"/>
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
