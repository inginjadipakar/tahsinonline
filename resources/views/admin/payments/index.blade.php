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
                    
                    {{-- Search & Filter Form --}}
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <form method="GET" action="{{ route('payments.index') }}" class="flex flex-wrap gap-3 items-end">
                            {{-- Search Input --}}
                            <div class="flex-1 min-w-[180px]">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Nama atau No. HP..." 
                                       class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            
                            {{-- Status Filter --}}
                            <div class="w-32">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                                <select name="status" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            
                            {{-- Date From --}}
                            <div class="w-36">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Dari Tanggal</label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                       class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            
                            {{-- Date To --}}
                            <div class="w-36">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                       class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            
                            {{-- Class Filter --}}
                            <div class="w-44">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Kelas</label>
                                <select name="class_id" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Semua Kelas</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Buttons --}}
                            <div class="flex gap-2">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"/>
                                    </svg>
                                    Cari
                                </button>
                                <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded-md hover:bg-gray-500 transition-colors">
                                    Reset
                                </a>
                            </div>
                        </form>
                        
                        {{-- Active Filters Display --}}
                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to', 'class_id']))
                            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                <span class="text-gray-500">Filter aktif:</span>
                                @if(request('search'))
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                        Search: "{{ request('search') }}"
                                    </span>
                                @endif
                                @if(request('status'))
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                        Status: {{ ucfirst(request('status')) }}
                                    </span>
                                @endif
                                @if(request('date_from'))
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                        Dari: {{ request('date_from') }}
                                    </span>
                                @endif
                                @if(request('date_to'))
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                        Sampai: {{ request('date_to') }}
                                    </span>
                                @endif
                                @if(request('class_id'))
                                    @php $selectedClass = $classes->find(request('class_id')); @endphp
                                    @if($selectedClass)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                        Kelas: {{ $selectedClass->name }}
                                    </span>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Student</th>
                                    <th scope="col" class="px-6 py-3">Kelas</th>
                                    <th scope="col" class="px-6 py-3">Date</th>
                                    <th scope="col" class="px-6 py-3">Proof</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Actions</th>
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
                                        $className = $subscription?->tahsinClass?->name ?? '-';
                                        
                                        // WhatsApp message for approval
                                        $waApproveMessage = "Assalamu'alaikum {$userName},

Alhamdulillah, pembayaran Anda telah kami terima dan diverifikasi ✅

📋 *Detail Langganan*
• Kelas: {$className}
• Aktif sampai: {$nextBillingDate}

Selamat belajar! Semoga Allah mudahkan dalam mempelajari Al-Qur'an.

Jazakallahu khairan 🙏
- Admin Tahsinku";
                                        
                                        $waApproveUrl = $userPhone ? "https://wa.me/{$userPhone}?text=" . urlencode($waApproveMessage) : '';
                                    @endphp
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $payment->user?->name ?? 'User Deleted' }}<br>
                                            <span class="text-xs text-gray-500">{{ $payment->user?->phone ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($className !== '-')
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-700">
                                                    {{ $className }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                                    <path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40ZM156,88a20,20,0,1,1-20,20A20,20,0,0,1,156,88Zm60,112H40V178.95l49.17-42.16a8,8,0,0,1,10.56.18l24.31,22.22,58.13-64.58a8,8,0,0,1,11.17-.63L216,114Z"/>
                                                </svg>
                                                View
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($payment->status === 'accepted')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z"/>
                                                    </svg>
                                                    Accepted
                                                </span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"/>
                                                    </svg>
                                                    Rejected
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 animate-spin" viewBox="0 0 256 256" fill="currentColor">
                                                        <path d="M136,32V64a8,8,0,0,1-16,0V32a8,8,0,0,1,16,0Zm88,88H192a8,8,0,0,0,0,16h32a8,8,0,0,0,0-16Zm-62.22,61.77a8,8,0,0,0-11.32,11.32l22.63,22.63a8,8,0,0,0,11.32-11.32ZM128,184a8,8,0,0,0-8,8v32a8,8,0,0,0,16,0V192A8,8,0,0,0,128,184Z"/>
                                                    </svg>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-1">
                                                @if($payment->status === 'pending')
                                                    {{-- Approve Button --}}
                                                    <form action="{{ route('payments.update', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Approve pembayaran ini?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" title="Approve" class="p-2 text-white bg-green-500 hover:bg-green-600 rounded-lg transition-colors">
                                                            <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                                                <path d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    
                                                    {{-- Reject Button --}}
                                                    <form action="{{ route('payments.update', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Reject pembayaran ini?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" title="Reject" class="p-2 text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                                                            <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                                                <path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    
                                                    {{-- WhatsApp Approve Notification --}}
                                                    @if($waApproveUrl)
                                                    <a href="{{ $waApproveUrl }}" target="_blank" title="Send WhatsApp" class="p-2 text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg transition-colors">
                                                        <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                                            <path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84Z"/>
                                                        </svg>
                                                    </a>
                                                    @endif
                                                @elseif($payment->status === 'accepted')
                                                    {{-- Send WA for accepted --}}
                                                    @if($waApproveUrl)
                                                    <a href="{{ $waApproveUrl }}" target="_blank" title="Send WhatsApp" class="p-2 text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition-colors">
                                                        <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                                            <path d="M187.58,144.84l-32-16a8,8,0,0,0-8,.5l-14.69,9.8a40.55,40.55,0,0,1-16-16l9.8-14.69a8,8,0,0,0,.5-8l-16-32A8,8,0,0,0,104,64a40,40,0,0,0-40,40,88.1,88.1,0,0,0,88,88,40,40,0,0,0,40-40A8,8,0,0,0,187.58,144.84Z"/>
                                                        </svg>
                                                    </a>
                                                    @endif
                                                    <span class="text-xs text-gray-400 ml-1">✓ Done</span>
                                                @else
                                                    {{-- Delete button for rejected --}}
                                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Delete payment ini permanen?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="p-2 text-white bg-gray-500 hover:bg-gray-600 rounded-lg transition-colors">
                                                            <svg class="w-4 h-4" viewBox="0 0 256 256" fill="currentColor">
                                                                <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <span class="text-xs text-red-400 ml-1">Rejected</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" viewBox="0 0 256 256" fill="currentColor">
                                                <path d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Z"/>
                                            </svg>
                                            @if(request()->hasAny(['search', 'status', 'date_from', 'date_to', 'class_id']))
                                                Tidak ada pembayaran yang cocok dengan filter.
                                            @else
                                                No payments found.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Menampilkan {{ $payments->count() }} data
                        </div>
                        <div class="flex gap-2">
                            @if ($payments->previousPageUrl())
                                <a href="{{ $payments->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 mr-1" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M165.66,202.34a8,8,0,0,1-11.32,11.32l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L91.31,128Z"/>
                                    </svg>
                                    Previous
                                </a>
                            @endif
                            
                            @if ($payments->hasMorePages())
                                <a href="{{ $payments->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 transition-colors">
                                    Next
                                    <svg class="w-4 h-4 ml-1" viewBox="0 0 256 256" fill="currentColor">
                                        <path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
