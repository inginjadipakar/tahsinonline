<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center py-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Mari Berinfak</h2>
                        <p class="text-gray-600 max-w-md mx-auto mb-8">
                            Dukung pengembangan platform Tahsin Online dan raih pahala jariyah dengan berinfak.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto text-left">
                            <!-- Bank Transfer -->
                            <div class="border rounded-xl p-5 hover:shadow-md transition-shadow">
                                <h3 class="font-bold text-lg mb-2">Transfer Bank</h3>
                                <p class="text-sm text-gray-600 mb-4">Transfer langsung ke rekening yayasan.</p>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="font-mono font-bold text-lg">BSI 1234567890</p>
                                    <p class="text-xs text-gray-500">a.n. Yayasan Tahsin Online</p>
                                </div>
                            </div>
                            
                            <!-- QRIS -->
                            <div class="border rounded-xl p-5 hover:shadow-md transition-shadow">
                                <h3 class="font-bold text-lg mb-2">QRIS</h3>
                                <p class="text-sm text-gray-600 mb-4">Scan QR code untuk pembayaran instan.</p>
                                <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-sm">QR Code Placeholder</span>
                                </div>
                            </div>
                            
                            <!-- E-Wallet -->
                            <div class="border rounded-xl p-5 hover:shadow-md transition-shadow">
                                <h3 class="font-bold text-lg mb-2">E-Wallet</h3>
                                <p class="text-sm text-gray-600 mb-4">GoPay, OVO, Dana, ShopeePay.</p>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                        <span class="text-sm">0812-3456-7890</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-10">
                            <button class="bg-green-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-700 transition-colors">
                                Konfirmasi Infak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
