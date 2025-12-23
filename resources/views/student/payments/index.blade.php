<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Saya') }}
        </h2>
    </x-slot>

    @php
        $pendingPayment = $payments->where('status', 'pending')->first();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Pending Payment Alert --}}
                    @if($pendingPayment)
                    <div class="mb-6 bg-amber-50 border border-amber-100 rounded-xl p-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-amber-600 animate-pulse" viewBox="0 0 256 256" fill="currentColor">
                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-amber-900 text-lg">Menunggu Konfirmasi Admin</h3>
                                <p class="text-amber-700 mt-1">Bukti pembayaran Anda sedang diverifikasi. Proses verifikasi membutuhkan waktu maksimal 1x24 jam.</p>
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- No pending - show upload button --}}
                    <div class="mb-6">
                        <a href="{{ route('payments.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-colors shadow-lg shadow-emerald-500/20">
                            <svg class="w-5 h-5" viewBox="0 0 256 256" fill="currentColor">
                                <path d="M74.34,85.66a8,8,0,0,1,11.32-11.32L120,108.69V40a8,8,0,0,1,16,0v68.69l34.34-34.35a8,8,0,0,1,11.32,11.32l-48,48a8,8,0,0,1-11.32,0ZM240,136v64a16,16,0,0,1-16,16H32a16,16,0,0,1-16-16V136a16,16,0,0,1,16-16H84a8,8,0,0,1,0,16H32v64H224V136H172a8,8,0,0,1,0-16h52A16,16,0,0,1,240,136Z"/>
                            </svg>
                            Upload Bukti Pembayaran Baru
                        </a>
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
                                            @if($payment->status === 'accepted')
                                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z"/>
                                                    </svg>
                                                    Diterima
                                                </span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"/>
                                                    </svg>
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 animate-spin" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H128a8,8,0,0,1-8-8V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"/>
                                                    </svg>
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
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

    {{-- Auto-open WhatsApp after successful upload --}}
    @if(session('open_whatsapp'))
    @php
        $user = auth()->user();
        $subscription = $user->subscription;
        $waNumber = '6282230466573';
        $className = $subscription && $subscription->tahsinClass ? $subscription->tahsinClass->name : 'Kelas Tahsin';
        $proofUrl = session('payment_proof_url', '');
        
        $waMessage = "Assalamu'alaikum Admin Tahsinku,

Saya ingin konfirmasi pembayaran dengan detail berikut:

📋 *Detail Pendaftaran*
• Nama: {$user->name}
• No. HP: {$user->phone}
• Kelas: {$className}

📎 *Bukti Pembayaran*:
{$proofUrl}

Saya sudah mengupload bukti pembayaran dan menunggu verifikasi. Mohon untuk dicek.

Jazakallahu khairan 🙏";
        
        $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.open("{{ $waUrl }}", '_blank');
        });
    </script>
    @endif
</x-app-layout>
