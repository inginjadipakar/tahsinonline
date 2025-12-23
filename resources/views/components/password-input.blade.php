@props([
    'id' => 'password',
    'name' => 'password',
    'label' => 'Password',
    'placeholder' => 'Masukkan password',
    'showStrengthMeter' => false,
    'required' => true,
    'autocomplete' => 'new-password'
])

<div x-data="{ 
    show: false, 
    password: '',
    strength: 0,
    strengthText: '',
    strengthColor: '',
    checkStrength() {
        let score = 0;
        const pwd = this.password;
        
        if (pwd.length >= 8) score++;
        if (pwd.length >= 12) score++;
        if (/[a-z]/.test(pwd)) score++;
        if (/[A-Z]/.test(pwd)) score++;
        if (/[0-9]/.test(pwd)) score++;
        if (/[^a-zA-Z0-9]/.test(pwd)) score++;
        
        this.strength = score;
        
        if (score <= 2) {
            this.strengthText = 'Lemah';
            this.strengthColor = 'bg-red-500';
        } else if (score <= 4) {
            this.strengthText = 'Sedang';
            this.strengthColor = 'bg-yellow-500';
        } else {
            this.strengthText = 'Kuat';
            this.strengthColor = 'bg-green-500';
        }
    }
}">
    <label for="{{ $id }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    
    <div class="relative">
        {{-- Lock Icon --}}
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
        </div>
        
        {{-- Input Field --}}
        <input 
            id="{{ $id }}" 
            name="{{ $name }}"
            :type="show ? 'text' : 'password'"
            x-model="password"
            @if($showStrengthMeter) @input="checkStrength()" @endif
            class="block w-full pl-12 pr-12 py-3 border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors placeholder-gray-400"
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
    
    {{-- Password Strength Meter --}}
    @if($showStrengthMeter)
    <div x-show="password.length > 0" x-cloak class="mt-3">
        {{-- Strength Bar --}}
        <div class="flex gap-1 mb-2">
            <div class="h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="h-full transition-all duration-300" 
                     :class="[strengthColor, strength >= 1 ? 'w-full' : 'w-0']"></div>
            </div>
            <div class="h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="h-full transition-all duration-300" 
                     :class="[strengthColor, strength >= 2 ? 'w-full' : 'w-0']"></div>
            </div>
            <div class="h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="h-full transition-all duration-300" 
                     :class="[strengthColor, strength >= 4 ? 'w-full' : 'w-0']"></div>
            </div>
            <div class="h-1.5 flex-1 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="h-full transition-all duration-300" 
                     :class="[strengthColor, strength >= 5 ? 'w-full' : 'w-0']"></div>
            </div>
        </div>
        
        {{-- Strength Text --}}
        <div class="flex items-center justify-between text-xs">
            <span class="text-gray-500 dark:text-gray-400">Kekuatan Password:</span>
            <span :class="{
                'text-red-500': strength <= 2,
                'text-yellow-500': strength > 2 && strength <= 4,
                'text-green-500': strength > 4
            }" class="font-semibold" x-text="strengthText"></span>
        </div>
        
        {{-- Requirements Checklist --}}
        <div class="mt-2 space-y-1 text-xs text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-2" :class="password.length >= 8 ? 'text-green-500' : ''">
                <svg class="w-3.5 h-3.5" :class="password.length >= 8 ? 'text-green-500' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>Minimal 8 karakter</span>
            </div>
            <div class="flex items-center gap-2" :class="/[A-Z]/.test(password) ? 'text-green-500' : ''">
                <svg class="w-3.5 h-3.5" :class="/[A-Z]/.test(password) ? 'text-green-500' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>Huruf besar (A-Z)</span>
            </div>
            <div class="flex items-center gap-2" :class="/[a-z]/.test(password) ? 'text-green-500' : ''">
                <svg class="w-3.5 h-3.5" :class="/[a-z]/.test(password) ? 'text-green-500' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>Huruf kecil (a-z)</span>
            </div>
            <div class="flex items-center gap-2" :class="/[0-9]/.test(password) ? 'text-green-500' : ''">
                <svg class="w-3.5 h-3.5" :class="/[0-9]/.test(password) ? 'text-green-500' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>Angka (0-9)</span>
            </div>
            <div class="flex items-center gap-2" :class="/[^a-zA-Z0-9]/.test(password) ? 'text-green-500' : ''">
                <svg class="w-3.5 h-3.5" :class="/[^a-zA-Z0-9]/.test(password) ? 'text-green-500' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>Karakter spesial (!@#$%)</span>
            </div>
        </div>
    </div>
    @endif
</div>
