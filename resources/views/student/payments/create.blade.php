<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Payment Proof') }}
        </h2>
    </x-slot>

    @php
        // WhatsApp message template
        $waNumber = '6282230466573';
        $userName = auth()->user()->name;
        $userPhone = auth()->user()->phone;
        $className = $subscription->tahsinClass->name ?? 'Kelas Tahsin';
        $amountFormatted = 'Rp ' . number_format($amount ?? 0, 0, ',', '.');
        
        $waMessage = "Assalamu'alaikum Admin Tahsinku,

Saya ingin konfirmasi pembayaran dengan detail berikut:

📋 *Detail Pendaftaran*
• Nama: {$userName}
• No. HP: {$userPhone}
• Kelas: {$className}
• Paket: {$packageName}
• Total: {$amountFormatted}

Saya sudah melakukan transfer sesuai nominal di atas. Mohon untuk diverifikasi.

Jazakallahu khairan 🙏";
        
        $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Invoice Summary --}}
                    @if(isset($subscription) && isset($amount))
                    <div class="mb-8 bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 border border-blue-100 dark:border-blue-800">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Rincian Tagihan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kelas</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $subscription->tahsinClass->name ?? 'Kelas Tahsin' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Paket</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $packageName }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Pembayaran</p>
                                <p class="text-3xl font-extrabold text-islamic-emerald dark:text-islamic-gold">
                                    Rp {{ number_format($amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-blue-200 dark:border-blue-700">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">Instruksi Pembayaran</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Silakan transfer sesuai nominal di atas ke rekening berikut:</p>
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">BSI (Bank Syariah Indonesia)</p>
                                    <p class="font-mono text-lg text-gray-600 dark:text-gray-300">7271614122</p>
                                    <p class="text-sm text-gray-500">a.n. Yayasan Tahsin Online</p>
                                </div>
                                <button onclick="navigator.clipboard.writeText('7271614122'); alert('Nomor rekening berhasil disalin!')" class="text-islamic-emerald hover:text-islamic-emerald-dark text-sm font-semibold">
                                    Salin
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="payment_proof" :value="__('Bukti Pembayaran (Gambar)')" />
                            <input id="payment_proof" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-2" type="file" name="payment_proof" required accept="image/*">
                            <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG atau GIF (MAKS. 2MB).</p>
                        </div>

                        {{-- Single button: Upload + Auto WhatsApp --}}
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-3 px-6 py-4 bg-green-500 hover:bg-green-600 text-white font-bold text-base rounded-xl transition-all shadow-lg shadow-green-500/20">
                            <svg class="w-6 h-6" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M74.34,85.66a8,8,0,0,1,11.32-11.32L120,108.69V40a8,8,0,0,1,16,0v68.69l34.34-34.35a8,8,0,0,1,11.32,11.32l-48,48a8,8,0,0,1-11.32,0ZM240,136v64a16,16,0,0,1-16,16H32a16,16,0,0,1-16-16V136a16,16,0,0,1,16-16H84a8,8,0,0,1,0,16H32v64H224V136H172a8,8,0,0,1,0-16h52A16,16,0,0,1,240,136Zm-40,32a12,12,0,1,0-12,12A12,12,0,0,0,200,168Z"/>
                            </svg>
                            Upload & Kirim Konfirmasi WhatsApp
                            <svg class="w-5 h-5 opacity-70" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84Z"/>
                            </svg>
                        </button>
                    </form>

                    {{-- Info about auto WhatsApp --}}
                    <div class="mt-6 bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35a8,8,0,0,1,11.32,11.32Z"/>
                            </svg>
                            <div class="text-sm text-emerald-800">
                                <p class="font-semibold mb-1">Satu Klik = Upload + WhatsApp</p>
                                <p>Setelah upload berhasil, WhatsApp akan <strong>otomatis terbuka</strong> dengan pesan konfirmasi ke Admin. Anda tinggal klik "Kirim".</p>
                            </div>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="mt-4 bg-amber-50 rounded-xl p-4 border border-amber-100">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z"/>
                            </svg>
                            <div class="text-sm text-amber-800">
                                <p class="font-semibold mb-1">Penting!</p>
                                <p>Proses verifikasi pembayaran membutuhkan waktu 1x24 jam. Akun Anda akan aktif setelah pembayaran diverifikasi oleh Admin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
