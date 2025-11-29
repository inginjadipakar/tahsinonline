<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Subscription') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($subscription && $subscription->status === 'active')
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        You have an active subscription.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Subscription Details</h3>
                                <dl class="mt-2 text-sm text-gray-600">
                                    <div class="flex justify-between py-1">
                                        <dt>Status:</dt>
                                        <dd class="font-semibold text-green-600">Active</dd>
                                    </div>
                                    <div class="flex justify-between py-1">
                                        <dt>Start Date:</dt>
                                        <dd>{{ \Carbon\Carbon::parse($subscription->start_date)->format('d M Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between py-1">
                                        <dt>End Date:</dt>
                                        <dd>{{ \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between py-1">
                                        <dt>Days Remaining:</dt>
                                        <dd>{{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($subscription->end_date), false) }} days</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No Active Subscription</h3>
                            <p class="mt-1 text-sm text-gray-500">You do not have an active subscription at the moment.</p>
                            <div class="mt-6">
                                <a href="{{ route('payments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Upload Payment Proof
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
