@props([
    'id' => 'password',
    'name' => 'password',
    'label' => 'Password',
    'placeholder' => '',
    'showStrengthMeter' => false,
    'required' => true,
    'autocomplete' => 'new-password'
])

<div x-data="{ 
    show: false, 
    password: '',
}">
    <label for="{{ $id }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
        {{ $label }}
    </label>
    
    <div class="relative">
        {{-- Input Field --}}
        <input 
            id="{{ $id }}" 
            name="{{ $name }}"
            :type="show ? 'text' : 'password'"
            x-model="password"
            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors placeholder-gray-400 pr-12"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            autocomplete="{{ $autocomplete }}"
        >
        
        {{-- Eye Toggle Button --}}
        <button 
            type="button" 
            @click="show = !show"
            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
        >
            {{-- Eye Open (Show) --}}
            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            {{-- Eye Closed (Hide) --}}
            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>
        </button>
    </div>
    
    {{-- Password Requirements Checklist --}}
    @if($showStrengthMeter)
    <div class="mt-4 space-y-2">
        {{-- Huruf besar --}}
        <div class="flex items-center gap-3">
            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors"
                 :class="/[A-Z]/.test(password) ? 'border-teal-500 bg-teal-500' : 'border-gray-400 dark:border-gray-500'">
                <svg x-show="/[A-Z]/.test(password)" class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-sm transition-colors" :class="/[A-Z]/.test(password) ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400'">Huruf besar (A-Z)</span>
        </div>

        {{-- Huruf kecil --}}
        <div class="flex items-center gap-3">
            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors"
                 :class="/[a-z]/.test(password) ? 'border-teal-500 bg-teal-500' : 'border-gray-400 dark:border-gray-500'">
                <svg x-show="/[a-z]/.test(password)" class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-sm transition-colors" :class="/[a-z]/.test(password) ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400'">Huruf kecil (a-z)</span>
        </div>

        {{-- Angka --}}
        <div class="flex items-center gap-3">
            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors"
                 :class="/[0-9]/.test(password) ? 'border-teal-500 bg-teal-500' : 'border-gray-400 dark:border-gray-500'">
                <svg x-show="/[0-9]/.test(password)" class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-sm transition-colors" :class="/[0-9]/.test(password) ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400'">Angka (0-9)</span>
        </div>

        {{-- Karakter spesial --}}
        <div class="flex items-center gap-3">
            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors"
                 :class="/[!?<>@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?]/.test(password) ? 'border-teal-500 bg-teal-500' : 'border-gray-400 dark:border-gray-500'">
                <svg x-show="/[!?<>@#$%^&*()_+\-=\[\]{};':&quot;\\|,.<>\/?]/.test(password)" class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-sm transition-colors" :class="/[!?<>@#$%^&*()_+\-=\[\]{};':&quot;\\|,.<>\/?]/.test(password) ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400'">Karakter spesial (misal: !?&lt;&gt;@#$%)</span>
        </div>

        {{-- Minimal 8 karakter --}}
        <div class="flex items-center gap-3">
            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors"
                 :class="password.length >= 8 ? 'border-teal-500 bg-teal-500' : 'border-gray-400 dark:border-gray-500'">
                <svg x-show="password.length >= 8" class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-sm transition-colors" :class="password.length >= 8 ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400'">Minimal 8 karakter</span>
        </div>
    </div>
    @endif
</div>
