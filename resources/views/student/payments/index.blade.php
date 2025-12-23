<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Saya') }}
        </h2>
    </x-slot>

    @php
        // Check if there's a pending payment for WhatsApp button
        $pendingPayment = $payments->where('status', 'pending')->first();
        $user = auth()->user();
        $subscription = $user->subscription;
        
        // WhatsApp message template
        $waNumber = '6282230466573';
        $className = $subscription && $subscription->tahsinClass ? $subscription->tahsinClass->name : 'Kelas Tahsin';
        
        $waMessage = "Assalamu'alaikum Admin Tahsinku,

Saya ingin konfirmasi pembayaran dengan detail berikut:

📋 *Detail Pendaftaran*
• Nama: {$user->name}
• No. HP: {$user->phone}
• Kelas: {$className}

Saya sudah mengupload bukti pembayaran dan menunggu verifikasi. Mohon untuk dicek.

Jazakallahu khairan 🙏";
        
        $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 mb-6">
                        <a href="{{ route('payments.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-800 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:bg-gray-700 transition ease-in-out duration-150">
                            <svg class="w-5 h-5" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M74.34,85.66a8,8,0,0,1,11.32-11.32L120,108.69V40a8,8,0,0,1,16,0v68.69l34.34-34.35a8,8,0,0,1,11.32,11.32l-48,48a8,8,0,0,1-11.32,0ZM240,136v64a16,16,0,0,1-16,16H32a16,16,0,0,1-16-16V136a16,16,0,0,1,16-16H84a8,8,0,0,1,0,16H32v64H224V136H172a8,8,0,0,1,0-16h52A16,16,0,0,1,240,136Z"/>
                            </svg>
                            Upload Bukti Pembayaran
                        </a>
                        
                        @if($pendingPayment)
                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white font-semibold text-sm rounded-lg transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84ZM152,176a72.08,72.08,0,0,1-72-72A24,24,0,0,1,99.29,82.91l11.48,23L101,119.42a8,8,0,0,0-.73,7.51,56.47,56.47,0,0,0,28.78,28.78,8,8,0,0,0,7.51-.73l13.52-9.75,23,11.48A24,24,0,0,1,152,176ZM128,24A104,104,0,0,0,36.18,176.88L24.83,210.93a16,16,0,0,0,20.24,20.24l34.05-11.35A104,104,0,1,0,128,24Zm0,192a87.87,87.87,0,0,1-44.06-11.81,8,8,0,0,0-6.54-.67L40,216,52.47,178.6a8,8,0,0,0-.66-6.54A88,88,0,1,1,128,216Z"/>
                            </svg>
                            Konfirmasi via WhatsApp
                        </a>
                        @endif
                    </div>

                    {{-- Pending Payment Alert --}}
                    @if($pendingPayment)
                    <div class="mb-6 bg-amber-50 border border-amber-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-amber-800">Menunggu Verifikasi</p>
                                <p class="text-sm text-amber-700 mt-1">Anda memiliki pembayaran yang sedang diverifikasi. Klik tombol "Konfirmasi via WhatsApp" di atas untuk mempercepat proses verifikasi.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Payment History Table --}}
                    <div class="relative overflow-x-auto rounded-xl border border-gray-100">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Tanggal</th>
                                    <th scope="col" class="px-6 py-4">Bukti</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                                    <path d="M228,128a20,20,0,0,1-5.86,14.14l-96,96a20,20,0,0,1-28.28-28.28L175.71,132H40a20,20,0,0,1,0-40H175.71L97.86,14.14a20,20,0,0,1,28.28-28.28l96,96A20,20,0,0,1,228,128Z"/>
                                                </svg>
                                                Lihat
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($payment->status === 'accepted') bg-green-100 text-green-800 
                                                @elseif($payment->status === 'rejected') bg-red-100 text-red-800 
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                @if($payment->status === 'accepted')
                                                    ✓ Diterima
                                                @elseif($payment->status === 'rejected')
                                                    ✕ Ditolak
                                                @else
                                                    ⏳ Menunggu
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($payment->status === 'pending')
                                                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                                   class="inline-flex items-center gap-1 text-green-600 hover:text-green-700 font-medium text-xs">
                                                    <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84Z"/>
                                                    </svg>
                                                    WhatsApp
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" viewBox="0 0 256 256" fill="currentColor">
                                                <path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Z"/>
                                            </svg>
                                            Belum ada riwayat pembayaran
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Auto-open WhatsApp after successful upload --}}
    @if(session('open_whatsapp'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open WhatsApp in new tab
            window.open("{{ $waUrl }}", '_blank');
        });
    </script>
    @endif
</x-app-layout>
