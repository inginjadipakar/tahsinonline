<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Payment Proof') }}
        </h2>
    </x-slot>

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
                                    <p class="font-mono text-lg text-gray-600 dark:text-gray-300">1234-5678-90</p>
                                    <p class="text-sm text-gray-500">a.n. Yayasan Tahsin Online</p>
                                </div>
                                <button onclick="navigator.clipboard.writeText('1234567890')" class="text-islamic-emerald hover:text-islamic-emerald-dark text-sm font-semibold">
                                    Salin
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="payment_proof" :value="__('Payment Proof (Image)')" />
                            <input id="payment_proof" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="payment_proof" required>
                            <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 2MB).</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Upload') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
