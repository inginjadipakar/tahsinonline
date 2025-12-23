<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Student</th>
                                    <th scope="col" class="px-6 py-3">Date</th>
                                    <th scope="col" class="px-6 py-3">Proof</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    @php
                                        // Calculate next 25th date for billing
                                        $now = now();
                                        $currentDay = $now->day;
                                        if ($currentDay < 25) {
                                            $nextBillingDate = $now->copy()->setDay(25)->format('d M Y');
                                        } else {
                                            $nextBillingDate = $now->copy()->addMonth()->setDay(25)->format('d M Y');
                                        }
                                        
                                        $userName = $payment->user?->name ?? 'User';
                                        $userPhone = $payment->user?->phone ?? '';
                                        $subscription = $payment->user?->subscription;
                                        $className = $subscription?->tahsinClass?->name ?? 'Kelas Tahsin';
                                        $proofUrl = url('storage/' . $payment->payment_proof);
                                        
                                        // WhatsApp message for approval
                                        $waApproveMessage = "Assalamu'alaikum {$userName},

Alhamdulillah, pembayaran Anda telah kami terima dan diverifikasi ✅

📋 *Detail Langganan*
• Kelas: {$className}
• Aktif sampai: {$nextBillingDate}

Selamat belajar! Semoga Allah mudahkan dalam mempelajari Al-Qur'an.

Jazakallahu khairan 🙏
- Admin Tahsinku";

                                        // WhatsApp message for rejection
                                        $waRejectMessage = "Assalamu'alaikum {$userName},

Mohon maaf, pembayaran Anda belum dapat kami verifikasi ❌

Kemungkinan penyebab:
• Nominal tidak sesuai
• Bukti transfer tidak jelas
• Transfer ke rekening yang salah

Silakan upload ulang bukti pembayaran atau hubungi admin untuk klarifikasi.

Jazakallahu khairan 🙏
- Admin Tahsinku";
                                        
                                        $waApproveUrl = $userPhone ? "https://wa.me/{$userPhone}?text=" . urlencode($waApproveMessage) : '#';
                                        $waRejectUrl = $userPhone ? "https://wa.me/{$userPhone}?text=" . urlencode($waRejectMessage) : '#';
                                    @endphp
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $payment->user?->name ?? 'User Deleted' }}<br>
                                            <span class="text-xs text-gray-500">{{ $payment->user?->phone ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline">View Image</a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($payment->status === 'accepted') bg-green-100 text-green-800 
                                                @elseif($payment->status === 'rejected') bg-red-100 text-red-800 
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($payment->status === 'pending')
                                                <div class="flex flex-wrap gap-2">
                                                    {{-- Approve Button --}}
                                                    <form action="{{ route('payments.update', $payment) }}" method="POST" onsubmit="return confirm('Approve pembayaran ini?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-xs px-3 py-2">
                                                            ✓ Approve
                                                        </button>
                                                    </form>
                                                    
                                                    {{-- Reject Button --}}
                                                    <form action="{{ route('payments.update', $payment) }}" method="POST" onsubmit="return confirm('Reject pembayaran ini?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-xs px-3 py-2">
                                                            ✕ Reject
                                                        </button>
                                                    </form>
                                                    
                                                    {{-- WhatsApp Approve Notification --}}
                                                    @if($userPhone)
                                                    <a href="{{ $waApproveUrl }}" target="_blank" class="inline-flex items-center gap-1 text-white bg-emerald-500 hover:bg-emerald-600 font-medium rounded-lg text-xs px-3 py-2">
                                                        <svg class="w-3 h-3" viewBox="0 0 256 256" fill="currentColor">
                                                            <path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84Z"/>
                                                        </svg>
                                                        WA ✓
                                                    </a>
                                                    @endif
                                                </div>
                                            @elseif($payment->status === 'accepted')
                                                {{-- Already approved - show WA button to send confirmation again --}}
                                                @if($userPhone)
                                                <a href="{{ $waApproveUrl }}" target="_blank" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 text-xs font-medium">
                                                    <svg class="w-3 h-3" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84Z"/>
                                                    </svg>
                                                    Kirim WA
                                                </a>
                                                @else
                                                <span class="text-gray-400 text-xs">✓ Approved</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400 text-xs">✕ Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center">No payments found.</td>
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
</x-app-layout>
